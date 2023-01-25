<?php 
    use Form\TaskForm;
    use Services\UserService;
    use Shuchkin\SimpleXLSX;
    load(["TaskForm"], FORMS);
    load(["UserService"], SERVICES);

    require_once LIBS.DS.'simplexlsx/vendor/autoload.php';

    class TaskController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->model = model('TaskModel');
            $this->taskSubmission = model('TaskSubmissionModel');
            $this->userModel = model('UserModel');
            $this->taskModel = model('TaskModel');

            $this->data['taskForm'] = new TaskForm();
        }

        public function index() {

        }

        public function create() {
            $req = request()->inputs();
            if(isSubmitted()) {
                $post = request()->posts();
                $this->model->createOrUpdate($post);
                
                if(!empty($req['returnTo'])) {
                    return redirect(unseal($req['returnTo']));
                }
            }
        }
        /**
         * submit tasks
         */
        public function show($id) {
            $task = $this->model->get($id);
            $this->data['task'] = $task;
            return $this->view('task/show', $this->data);
        }

        public function edit($id) {
            if (isSubmitted()) {
                $post = request()->posts();
                $isOkay = $this->model->createOrUpdate($post, $post['id']);
                
                if($isOkay) {
                    Flash::set("Task Updated!");
                } else {
                    Flash::set($this->model->getErrorString(), 'danger');
                }

                if(isset($req['returnTo'])) {
                    return redirect(unseal($req['returnTo']));
                } else {
                    return redirect(_route('classroom:show', $post['parent_id'], [
                        'page' => 'task_show',
                        'taskId' => $post['id']
                    ]));
                }
            }

            $task = $this->model->get($id);
            $this->data['task'] = $task;

            $taskForm = $this->data['taskForm'];

            $taskForm->setValueObject($task);
            $taskForm->addId($task->id);
            return $this->view('task/edit', $this->data);
        }

        public function uploadGoogleSheet() {
            $req = request()->inputs();
            if(isSubmitted()) {
                $messages = [];

                $post= request()->posts();

                $res = upload_document('file', PATH_UPLOAD.DS.'spreadsheets');
                if(isEqual($res['status'],'success')) {
                    $uploadResult = $res['result'];
                    $reader = SimpleXLSX::parse($uploadResult['path'].DS.$uploadResult['name']);

                    $headers = [];
                    foreach($reader->rows() as $rowCount => $rowValues) {
                        if($rowCount == 0) {
                            foreach($rowValues as $rowKey => $rowVal) {
                                if(isEqual($rowVal, ['score', 'student number','email address'])) {
                                    $rowVal = str_replace(' ', '_',strtolower($rowVal));
                                    $headers[$rowVal] = $rowKey;
                                }
                            }

                            continue;
                        }
                        
                        $studentNumber = trim($rowValues[$headers['student_number']]);
                        $score = trim($rowValues[$headers['score']]);

                        $user = $this->userModel->single([
                            'user_identification' => $studentNumber,
                            'user_type' => UserService::STUDENT
                        ]);

                        if(!$user) {
                            $invalidUsers[] = $studentNumber;
                            $messages[] = "User with '{$studentNumber}' student number does not found.";
                        } else {
                            $users [] = $user;

                            $task = $this->taskModel->get($post['task_id']);

                            if(!$task) {
                                $messages [] = "Task Not exists.";
                                break;
                            } elseif($score > $task->total_items) {
                                $messages [] = "User {$user->firstname}@#{$user->user_identification} Score ({$score}) is over total items, invalid score.";
                                continue;
                            }

                            $isAbleToSubmit = $this->taskSubmission->createOrUpdate([
                                'task_id' => $post['task_id'],
                                'user_id' => $user->id,
                                'user_score' => $score,
                                'status' => 'approved'
                            ]);

                            if($isAbleToSubmit) {
                                $messages [] = "{$user->firstname}@#{$user->user_identification} able to submit score '{$score}'.";
                            } else {
                                $messages [] = "{$user->firstname}@#{$user->user_identification} " . $this->taskSubmission->getErrorString();
                            }

                        }
                    }

                    $messageStr = '';
                    foreach($messages as $key => $row) {
                        $messageStr .= "<div>{$row}</div>";
                    }
                    Flash::set($messageStr,'primary','submit_message');

                    unlink($uploadResult['path'].DS.$uploadResult['name']);
                    if(isset($req['returnTo'])) {
                        return redirect(unseal($req['returnTo']));
                    } else {
                        return redirect(_route('classroom:show', $post['task_id']));
                    }
                }
            }
        }
    }
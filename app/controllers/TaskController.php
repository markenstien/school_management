<?php 
    use Form\TaskForm;
    load(["TaskForm"], FORMS);

    class TaskController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->model = model('TaskModel');
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
    }
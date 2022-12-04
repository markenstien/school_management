<?php

    use Form\ClassForm;
    use Form\TaskForm;
    use Form\FeedForm;
    use Services\UserService;   
    use Services\CommonService;

    load(['ClassForm', 'TaskForm', 'FeedForm'], FORMS);
    load(['UserService', 'CommonService'], SERVICES);
    

    class ClassroomController extends Controller {

        public function __construct()
        {
            parent::__construct();
            $this->model = model('ClassroomModel');
            $this->taskModel = model('TaskModel');    
            $this->userModel = model('UserModel');
            $this->feedModel = model('FeedModel');
            $this->data['_attachmentForm'] = $this->_attachmentForm;
            $this->data['form'] = new ClassForm();
        }

        public function index() {
            $this->data['classrooms'] = $this->model->all(null, 'id desc');
            return $this->view('classroom/index', $this->data);
        }

        public function create() {
            $req = request()->inputs();
            
            if (isSubmitted()) {
                // dump($req);
                $classroomId = $this->model->createOrUpdate($req);
                if($classroomId) {
                    Flash::set($this->model->getMessageString());
                    return redirect(_route('classroom:show', $classroomId));
                } else {
                    Flash::set($this->model->getErrorString(), 'danger');
                    return request()->return();
                }
            }            
            return $this->view('classroom/create', $this->data);
        }
        
        public function show($id) {
            $req = request()->inputs();
            $page = $req['page'] ?? 'feeds';

            $classroom = $this->model->get($id);

            $this->data['id'] = $id;
            $this->data['classroom'] = $classroom;

            if (isSubmitted()) {
                $post = request()->posts();
                if (!empty($post['btn_search_user_identification'])) {
                    $userId = $post['user_identification'];
                    $userSearched = $this->userModel->get([
                        'user_identification' => $userId,
                        'user_type' => UserService::STUDENT
                    ]);        

                    if(!$userSearched) {
                        Flash::set("Student {$userId} not found", 'danger');
                        return request()->return();
                    }
                }
            }
            
            switch($page)
            {
                case 'feeds' :
                    $this->data['feeds'] = $this->feedModel->all([
                        'parent_key' => CommonService::CLASSKEY,
                        'parent_id' => $id
                    ], 'id desc');
                    $this->data['pagePath'] = 'classroom/show_inc/feeds';
                break;

                case 'feed_create':
                    $feedForm = new FeedForm();
                    $feedForm->setValue('parent_id', $id);
                    $feedForm->setValue('parent_key', CommonService::CLASSKEY);

                    $this->data['feedForm'] = $feedForm;
                    $this->data['pagePath'] = 'classroom/show_inc/feed_create';
                break;

                case 'feed_show':
                    $feed = $this->feedModel->get($req['feedId']);
                    $feedForm = new FeedForm();
                    $feedForm->setValue('parent_id', $id);
                    $feedForm->setValue('parent_key', CommonService::CLASSKEY);

                    $this->data['feedForm'] = $feedForm;
                    $this->data['feed'] = $feed;
                    $this->data['pagePath'] = 'classroom/show_inc/feed_show';
                break;

                case 'students' :
                    $this->data['pagePath'] = 'classroom/show_inc/students';
                    $this->data['students'] = $this->model->getStudents($id);
                break;

                case 'students_add' :
                    $this->data['pagePath'] = 'classroom/show_inc/students_add';
                    $this->data['students'] = $this->model->getStudents($id);
                    $this->data['userSearched'] = $userSearched ?? null;
                break;

                case 'parents' :
                    $this->data['pagePath'] = 'classroom/show_inc/parents';
                break;

                case 'tasks' :
                    $this->data['tasks']   = $this->taskModel->all(['parent_id' => $id],'id desc');
                    $this->data['pagePath'] = 'classroom/show_inc/tasks';
                break;

                case 'setting' :
                    $this->data['pagePath'] = 'classroom/show_inc/setting';
                break;

                case 'task_create' :
                    $taskForm = new TaskForm();
                    $taskForm->init([
                        'method' => 'post',
                        'url' => _route('task:create', null, [
                            'returnTo' => seal(_route('classroom:show', $id, ['page' => 'tasks']))
                        ]),
                    ]);
                    $taskForm->setValue('parent_id', $id);
                    $this->data['taskForm'] = $taskForm;
                    $this->data['pagePath'] = 'classroom/show_inc/task_create';
                break;

                case 'task_show' :
                    $this->taskSubmissionModel = model('TaskSubmissionModel');
                    
                    $task = $this->taskModel->get($req['taskId']);
                    $this->_attachmentForm->setValue('global_key', 'TASK_SUBMISSION_IMAGE');
                    $this->data['_attachmentForm'] = $this->_attachmentForm;
                    $this->data['task_submissions'] = $this->taskSubmissionModel->getAll([
                        'where' => [
                            'task_id' => $req['taskId']
                        ]
                    ]);

                    $this->data['task'] = $task;
                    $this->data['pagePath'] = 'classroom/show_inc/task_show';
                break;
            }

            $this->data['pageData'] = $this->data;

            return $this->view('classroom/show', $this->data);
        }

        public function join() {
            $req = request()->inputs();
            /**
             * by-invite add parameter is_invited, invitee = user_id
             * only need to login his credentials
             */

            if (isSubmitted()) {
                $res = $this->model->joinByCode($req['join_code'], whoIs('id'));

                if(!$res) {
                    Flash::set($this->model->getErrorString(), 'danger');
                    return request()->return();
                }
                Flash::set($this->model->getMessageString());
                return redirect(_route('classroom:show', $this->model->retVal['classroom_id']));
            }
            return $this->view('classroom/join');
        }

        public function addTeacher($id) {
            if(isSubmitted()) {
                $post = request()->posts();
                $isOkay = $this->model->setTeacher($post['teacher_id'], $post['classroom_id']);

                if($isOkay) {
                    Flash::set("Teacher added");
                    return redirect(_route('classroom:show', $post['classroom_id']));
                } else {
                    Flash::set($this->model->getErrorString(), 'danger');
                    return request()->return();
                }
            }
            $classroom = $this->model->get($id);
            $teachers = $this->userModel->getAll([
                'where' => [
                    'user_type' => UserService::TEACHER
                ]
            ]);
            $this->data['classroom'] = $classroom;
            $this->data['teachers'] = arr_layout_keypair($teachers, ['id', 'firstname@lastname']);
            
            return $this->view('classroom/add_teacher', $this->data);
        }

        public function addStudent($id) {
            $req = request()->inputs();
            $studentId = $req['studentId'];
            
            if (empty($studentId)) {
                Flash::set("Invalid Request", 'danger');
                return request()->return();
            }
            
            $studentId = unseal($studentId);

            $res = $this->model->addStudent($studentId, $id);

            if($res) {
                Flash::set($this->model->getMessageString());
                if(!empty($req['returnTo'])) {
                    return redirect(unseal($req['returnTo']));
                }
                return redirect(_route('classroom:show', $id, ['page' => 'students']));
            } else {
                Flash::set($this->model->getErrorString(),'danger');
                return redirect(_route('classroom:show', $id, ['page' => 'students']));
            }
        }

        public function destroy($id) {
            $classroom = $this->model->delete($id);
            if(!$classroom) {
                Flash::set($this->model->getErrorString());
            } else {
                Flash::set($this->model->getMessageString());
            }
            return redirect(_route('classroom:index'));
        }

        public function resetJoinCode($id) {
            $this->model->resetJoinCode($id);
            return request()->return();
        }
    }
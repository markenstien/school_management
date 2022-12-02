<?php

    use Form\ClassForm;
    use Form\TaskForm;
use Services\UserService;

    load(['ClassForm', 'TaskForm'], FORMS);
    load(['UserService'], SERVICES);
    

    class ClassroomController extends Controller {

        public function __construct()
        {
            parent::__construct();
            $this->model = model('ClassroomModel');
            $this->taskModel = model('TaskModel');    
            $this->userModel = model('UserModel');
            $this->data['_attachmentForm'] = $this->_attachmentForm;
            $this->data['form'] = new ClassForm();
        }

        public function index() {
            $this->data['classrooms'] = $this->model->all();
            return $this->view('classroom/index', $this->data);
        }

        public function create() {
            $req = request()->inputs();
            
            if (isSubmitted()) {
                // dump($req);
                $classroomId = $this->model->createOrUpdate($req);
                if($classroomId) {
                    Flash::set($this->model->getMessageString());
                    return request()->return();
                } else {
                    Flash::set($this->model->getErrorString(), 'danger');
                    return redirect(_route('classroom:show', $classroomId));
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
            
            switch($page)
            {
                case 'feeds' :
                    $feedModel = model('FeedModel');
                    $this->data['feeds'] = $feedModel->all([
                        'parent_key' => 'Classroom',
                        'parent_id' => $id
                    ]);
                    $this->data['pagePath'] = 'classroom/show_inc/feeds';
                break;

                case 'students' :
                    $this->data['pagePath'] = 'classroom/show_inc/students';
                    $this->data['students'] = $this->model->getStudents($id);
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
                $res = $this->model->joinByCode($req['join_code'], 1);

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
    }
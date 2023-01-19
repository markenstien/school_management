<?php 

    class TaskSubmissionController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->model = model('TaskSubmissionModel');
            $this->task = model('TaskModel');
        }

        public function create() {
            $req = request()->inputs();
            if(isSubmitted()) {
                $post = request()->posts();
                $submitId = $this->model->createOrUpdate($post);

                if(!$submitId) {
                    Flash::set($this->model->getErrorString(), 'danger');
                    return redirect(unseal($req['returnTo']));
                }
                if(!upload_empty('file')) {
                    $this->_attachmentModel->upload([
                        'global_key' => $post['global_key'],
                        'global_id' => $submitId,
                        'display_name' => 'Task Submission'
                    ], 'file');
                }

                if(isset($req['returnTo'])) {
                    Flash::set("Submitted");
                    return redirect(unseal($req['returnTo']));
                }
            }
        }

        public function show($id) {
            $taskSubmit = $this->model->get($id);
            $task = $this->task->get($taskSubmit->task_id);

            if (isSubmitted()) {
                $post = request()->posts();

                if (!empty($post['btn_approve'])) {

                    //check user score

                    if($post['user_score'] > $task->total_items) {
                        Flash::set("Invalid Score", 'danger');
                        return request()->return();
                    }
                    
                    Flash::set("Task Submission Approved");
                    $this->model->approve($id);
                    $this->model->update([
                        'user_score' => $post['user_score']
                    ], $id);
                }

                if (!empty($post['btn_decline'])) {
                    Flash::set("Task Submission Declined", 'danger');
                    $this->model->decline($id);
                }

                return redirect(_route('classroom:show', $task->parent_id, [
                    'page' => 'task_show',
                    'taskId' => $task->id
                ]));
            }
            

            $this->data['taskSub'] = $taskSubmit;
            $this->data['task'] = $task;

            return $this->view('task_submission/show', $this->data);
        }
    }
<?php 

    class TaskSubmissionController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->model = model('TaskSubmissionModel');
        }

        public function create() {
            $req = request()->inputs();
            if(isSubmitted()) {
                $post = request()->posts();
                $submitId = $this->model->createOrUpdate($post);

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
            $this->data['taskSub'] = $taskSubmit;

            return $this->view('task_submission/show', $this->data);
        }
    }
<?php 
    class TaskController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->model = model('TaskModel');
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
    }
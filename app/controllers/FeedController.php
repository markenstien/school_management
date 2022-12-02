<?php 

    class FeedController extends Controller
    {

        public function __construct()
        {
            $this->model = model('FeedModel');
        }
        public function create() {
            $req = request()->inputs();
            if(isSubmitted()) {
                $this->model->createOrUpdate($req);
                if(isset($req['_returnRoute'])) {
                    Flash::set("Feed Created!");
                    return redirect($req['_returnRoute']);
                }
            }
        }
    }
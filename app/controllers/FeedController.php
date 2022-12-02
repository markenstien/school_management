<?php 
    use Services\CommonService;
    load(['CommonService'], SERVICES);

    class FeedController extends Controller
    {

        public function __construct()
        {
            parent::__construct();
            $this->model = model('FeedModel');
        }
        public function create() {
            $req = request()->inputs();
            if(isSubmitted()) {
                $post = request()->posts();
                $feedId = $this->model->createOrUpdate($post);

                if($feedId) {
                    Flash::set("Feed Created");
                }else{
                    Flash::set("Something went wrong");
                }

                if(!upload_empty('file_array') && $feedId) {
                    $this->_attachmentModel->upload_multiple([
                        'global_id' => $feedId,
                        'global_key' => CommonService::FEED_ATTACHMENTS
                    ], 'file_array');
                }

                if(isset($req['returnTo'])) {
                    Flash::set("Feed Created!");
                    return redirect(unseal($req['returnTo']));
                }
                return redirect(_route('classroom:index'));
            }
        }
    }
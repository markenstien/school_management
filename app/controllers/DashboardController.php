<?php
	class DashboardController extends Controller
	{
		public function __construct()
		{

		}

		public function index()
		{
			$user = whoIs();
			$this->data['page_title'] = 'Dashboard';
			switch($user->user_type) {
				case 'parent':
					$this->userModel = model('UserModel');
					$children = $this->userModel->getChildren($user->id);
					return $this->view('dashboard/parent', [
						'children' => $children
					]);
				break;
			}
			$this->data['page_title'] = 'Dashboard';
			return $this->view('tmp/maintenance', $this->data);
		}
	}
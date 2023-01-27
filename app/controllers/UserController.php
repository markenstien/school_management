<?php 
	load(['UserForm'] , APPROOT.DS.'form');
	use Form\UserForm;
use Services\UserService;

	class UserController extends Controller
	{

		public function __construct()
		{
			parent::__construct();

			$this->model = model('UserModel');

			$this->data['page_title'] = ' Users ';
			$this->data['user_form'] = new UserForm();
		}

		public function index()
		{
			$params = request()->inputs();

			if(!empty($params))
			{
				$this->data['users'] = $this->model->getAll([
					'where' => $params
				]);
			}else{
				$this->data['users'] = $this->model->getAll( );
			}
			

			return $this->view('user/index' , $this->data);
		}

		public function create()
		{
			$req = request()->inputs();

			if(isSubmitted()) {
				$post = request()->posts();
				$user_id = $this->model->create($post , 'profile');
				if(!$user_id){
					Flash::set( $this->model->getErrorString() , 'danger');
					return request()->return();
				}

				Flash::set('User Record Created');
				if( isEqual($post['user_type'] , 'patient') )
				{
					Flash::set('Patient Record Created');
					return redirect(_route('patient-record:create' , null , ['user_id' => $user_id]));
				}

				return redirect( _route('user:show' , $user_id , ['user_id' => $user_id]) );
			}
			$this->data['user_form'] = new UserForm('userForm');

			return $this->view('user/create' , $this->data);
		}

		public function edit($id)
		{
			if(isSubmitted()) {
				$post = request()->posts();
				$post['profile'] = 'profile';
				$res = $this->model->update($post , $post['id']);

				if($res) {
					Flash::set( $this->model->getMessageString());
					return redirect( _route('user:show' , $id) );
				}else
				{
					Flash::set( $this->model->getErrorString() , 'danger');
					return request()->return();
				}
			}

			$user = $this->model->get($id);

			$this->data['id'] = $id;
			$this->data['user_form']->init([
				'url' => _route('user:edit',$id)
			]);

			$this->data['user_form']->setValueObject($user);
			$this->data['user_form']->addId($id);
			$this->data['user_form']->remove('submit');
			$this->data['user_form']->remove('user_identification');
			$this->data['user_form']->add([
				'name' => 'password',
				'type' => 'password',
				'class' => 'form-control',
				'options' => [
					'label' => 'Password'
				]
			]);

			if(!isEqual(whoIs('user_type'), 'admin'))
				$this->data['user_form']->remove('user_type');

			return $this->view('user/edit' , $this->data);
		}

		public function show($id)
		{
			$req = request()->inputs();
			$user = $this->model->get($id);

			if(!$user) {
				Flash::set(" This user no longer exists " , 'warning');
				return request()->return();
			}

			$this->data['user'] = $user;
			
			if(isSubmitted()) {
				$post = request()->posts();
				if(isset($req['add_child'])) {
					$childUserIdentification = $post['user_identification'];
					$result = $this->model->addChild($id, $childUserIdentification);

					if(!$result) {
						Flash::set($this->model->getErrorString());
						return request()->return();
					} else {
						Flash::set('Child added');
						return redirect(_route('user:show', $id));
					}
				}
			}
			if(isEqual($user->user_type, UserService::PARENT)) {
				$this->data['action'] = $req['action'] ?? '';
				$this->data['children'] = $this->model->getChildren($id);
				return $this->view('user/parent', $this->data);
			}

			if(isEqual($user->user_type, UserService::TEACHER)) {
				$this->database = Database::getInstance();
				$this->classroomModel = model('ClassroomModel');
				$this->taskModel = model('TaskModel');
				
				$classrooms = $this->classroomModel->getAll([
					'where' => [
						'teacher_id' => $id
					]
				]);
				$classroomIds = [];
				foreach($classrooms as $key => $row) {
					$classroomIds [] = $row->id;
				}

				if($classroomIds) {
					$this->database->query(
						"SELECT * FROM v_total_student 
							WHERE class_id in ('".implode("','", $classroomIds)."')"
					);
					$totalStudent = $this->database->single()->total ?? 0;
				}
				
				$this->data['teacher_data'] = [
					'classrooms' => $classrooms,
					'totalStudent'   => $totalStudent ?? 0,
					'taskTotal' => $this->taskModel->_getCount([
						'parent_id' => [
							'condition' => 'in',
							'value' => $classroomIds
						]
					])
				];
			}
			return $this->view('user/show' , $this->data);
		}

		public function sendCredential($id)
		{
			$this->model->sendCredential($id);
			Flash::set("Credentials has been set to the user");
			return request()->return();
		}

		public function deleteChild($child_id) {

			if(!isset($this->childrenModel)) {
				$this->childrenModel = model('ChildrenModel');
			}
			$this->childrenModel->delete($child_id);
			return request()->return();
		}
	}
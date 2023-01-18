<?php
	use Services\UserService;
	load(['UserService'], SERVICES);
	class DashboardController extends Controller
	{
		public function __construct()
		{
			parent::__construct();

			$this->userModel = model('UserModel');
			$this->classroomModel = model('ClassroomModel');
			$this->studentClassModel = model('ClassStudentModel');
			$this->taskModel = model('TaskModel');
			$this->database = Database::getInstance();
			$this->whoIs = whoIs();
		}

		public function index()
		{
			$this->data['page_title'] = 'Dashboard';

			switch($this->whoIs->user_type) {
				case 'parent':
					$children = $this->userModel->getChildren($this->whoIs->id);
					return $this->view('dashboard/parent', [
						'children' => $children
					]);
				break;


				case 'admin':
					/**
					 * get total classrooms
					 */
					$totalClassroom = $this->classroomModel->_getCount();
					$totalTeacher = $this->userModel->_getCount([
						'user_type' => UserService::TEACHER
					]);
					$totalStudent = $this->userModel->_getCount([
						'user_type' => UserService::STUDENT
					]);
					$totalParent = $this->userModel->_getCount([
						'user_type' => UserService::PARENT
					]);
					return $this->view('dashboard/admin', [
						'totalClassroom' => $totalClassroom,
						'totalTeacher' => $totalTeacher,
						'totalStudent' => $totalStudent,
						'totalParent' => $totalParent
					]);
				break;


				case 'teacher':
					$classrooms = $this->classroomModel->getAll([
						'where' => [
							'teacher_id' => whoIs('id')
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
					
					return $this->view('dashboard/teacher', [
						'classrooms' => $classrooms,
						'totalStudent'   => $totalStudent ?? 0,
						'taskTotal' => $this->taskModel->_getCount([
							'parent_id' => [
								'condition' => 'in',
								'value' => $classroomIds
							]
						])
					]);
				break;


				case 'student':
					
					$classroomIds = $this->studentClassModel->getStudentClassIds(whoIs('id'));
					if(!empty($classroomIds)) {
						$classrooms = $this->classroomModel->getAll([
							'where' => [
								'cr.id' => [
									'condition' => 'in',
									'value' => $classroomIds
								]
							]
						], 'id desc');

						if(!empty($classrooms)) {
							$teacher_ids = [];
							foreach($classrooms as $key => $row) {
								if($row->teacher_id)
									$teacher_ids[] = $row->teacher_id;
							}

							$teachers = $this->userModel->getAll([
								'where' => [
									'id' => [
										'condition' => 'in',
										'value' => $teacher_ids
									]
								]
							]);


							$tasks = $this->taskModel->getAll([
								'where' => [
									'task.parent_id' => [
										'condition' => 'in',
										'value' => $classroomIds
									]
								],
								'order' => 'task.start_date desc'
							]);
						}
					}

					$data = [
						'tasks' => $tasks ?? [],
						'classrooms' => $classrooms ?? [],
						'parent' => $this->userModel->getParent($this->whoIs->id),
						'teachers' => $teachers ?? []
					];

					return $this->view('dashboard/student', $data);
				break;
			}

			$this->data['page_title'] = 'Dashboard';
			return $this->view('tmp/maintenance', $this->data);
		}
	}
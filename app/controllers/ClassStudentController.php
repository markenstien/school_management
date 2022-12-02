<?php 

	class ClassStudentController extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->model = model('ClassStudentModel');
		}
	}
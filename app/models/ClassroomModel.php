<?php
    use Services\UserService;
    load(['UserService'], SERVICES);
    
    class ClassroomModel extends Model
    {
        public $table = 'classrooms';
        public $_fillables = [
            'class_code',
            'class_name',
            'description',
            'teacher_id',
            'theme'
        ];


        public function delete($id) {
            $classroom = $this->get($id);

            if (!$classroom) {
                $this->addError("Classroom does not exists.");
                return false;
            }

            $classStudentModel = model('ClassStudentModel');
            $taskModel = model('TaskModel');

            //delete all items 

            //tasks
            //students

            $isStudentModel = $classStudentModel->deleteFromClass($id);
            $isTaskmodel = $taskModel->deleteFromClass($id);
            parent::delete($id);
            
            if($isStudentModel && $isTaskmodel) {
                $this->addMessage("CLASS {$classroom->class_name} Has been deleted! :: Class Reference : {$classroom->reference_code}");
                return true;
            } else {
                $this->addError("Unable to delete class");
                return false;
            }
        }
        public function createOrUpdate($classData, $id = null) {
            $_fillables = parent::getFillablesOnly($classData);
            if (is_null($id)) {
                $_fillables['reference_code'] = referenceSeries(parent::lastId(), 5, 'SY'.date('Y').'-');
                $_fillables['join_code'] = $this->createJoinCode();
                //create
                $retVal = parent::store($_fillables);
            } else {
                $retVal = parent::update($_fillables, $id);
            }

            return $retVal;
        }

        public function createJoinCode() {
            $joinCode = null;

            while(is_null($joinCode)) {
                $joinCode = strtoupper(get_token_random_char(6));
                $isExist = parent::single([
                    'join_code' => $joinCode
                ]);
                if($isExist) {
                    $joinCode = null;
                }
            }

            return $joinCode;
        }

        public function getAll($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if (isset($params['where'])) {
                $where = " WHERE ".parent::conditionConvert($params['where']);
            }

            if (isset($params['order'])) {
                $order = " ORDER BY {$params['order']}";
            }

            if (isset($params['limit'])) {
                $limit = " LIMIT {$params['limit']}";
            }

            $this->db->query(
                "SELECT cr.*,
                    concat(teacher.firstname , ' ', teacher.lastname) as teacher_name,
                    v_total_student.total as total_student
                    FROM {$this->table} as cr 
                    LEFT JOIN users as teacher 
                    ON teacher.id = cr.teacher_id
                    
                    LEFT JOIN v_total_student 
                    ON v_total_student.class_id = cr.id
                {$where}{$order}{$limit}"
            );

            return $this->db->resultSet();
        }

        public function get($id) {
            return $this->getAll([
                'where' => [
                    'cr.id' => $id
                ]
            ])[0] ?? false;
        }

        public function joinByCode($code, $studentId) {
            $classroom = parent::single([
                'join_code' => $code
            ]);

            if(!$classroom) {
                $this->addError("Classroom join code does not exists.");
                return false;
            }

            $addStudent = $this->addStudent($studentId, $classroom->id);
            $this->retVal['classroom'] = $classroom;

            return $addStudent;
        }

        public function addStudent($studentId, $classroomId) {
            //load student join
            $classStudentModel = model('ClassStudentModel');
            $userModel = model('UserModel');

            //check if studentId is really a student

            $user = $userModel->get($studentId);

            if (!isEqual($user->user_type, UserService::STUDENT)) {
                $this->addError("This account is not student, adding to user to class failed.");
                return false;
            }
            //check if student already exists
            $isOk = $classStudentModel->join([
                'student_id' => $studentId,
                'class_id' => $classroomId,
                'joined_by' => 'CODE'
            ]);

            if(!$isOk) {
                $this->addError($classStudentModel->getErrorString());
                return false;
            }

            $this->retVal['classroom_id'] = $classroomId; 
            $this->addMessage("Student Successfully joined the classroom");

            return $isOk;
        }

        public function getStudents($id) {
            $this->db->query(
                "SELECT user.*, cs.id as class_student_id
                    FROM class_students as cs 
                    JOIN users as user
                    ON user.id = cs.student_id
                WHERE class_id = {$id}"
            );
            return $this->db->resultSet();
        }
        
        public function getStudentsInClass($class_id, $studentIds = []) {
            $this->db->query(
                "SELECT * FROM class_students as cs
                    WHERE cs.class_id = '{$class_id}'
                    AND cs.student_id in ('".implode("','",$studentIds)."') "
            );

            $results =  $this->db->resultSet();

            $retVal = [];
            if($results) {
                foreach($results as $key => $row) {
                    $retVal[] = $row->student_id;
                }
            }
            
            return $retVal;
        }

        public function setTeacher($teacherId, $classroomId) {
            $classroom = $this->get($classroomId);

            if($classroom->teacher_id == $teacherId) {
                $this->addError("Teacher is alreay in placed!");
                return false;
            }

            return parent::update([
                'teacher_id' => $teacherId
            ], $classroomId);
        }

        public function resetJoinCode($id) {
            return parent::update([
                'join_code' => $this->createJoinCode()
            ], $id);
        }
    }
?>
<?php
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

        public function createOrUpdate($classData, $id = null) {
            $_fillables = parent::getFillablesOnly($classData);
            if (is_null($id)) {
                $_fillables['reference_code'] = referenceSeries(parent::lastId(), 5, 'SY'.date('Y').'-');
                //create
                $retVal = parent::store($_fillables);
            } else {
                $retVal = parent::update($_fillables, $id);
            }

            return $retVal;
        }

        public function getAll($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if (isset($params['where'])) {
                $where = " WHERE ".parent::conditionConvert($params['where']);
            }

            if (isset($params['order'])) {
                $order = " ORDER {$params['order']}";
            }

            if (isset($params['limit'])) {
                $limit = " LIMIT {$params['limit']}";
            }

            $this->db->query(
                "SELECT cr.*,
                    concat(teacher.firstname , ' ', teacher.lastname) as teacher_name
                    FROM {$this->table} as cr 
                    LEFT JOIN users as teacher 
                    ON teacher.id = cr.teacher_id
                    
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

            //load student join
            $classStudentModel = model('ClassStudentModel');
            
            $isOk = $classStudentModel->join([
                'student_id' => $studentId,
                'class_id' => $classroom->id,
                'joined_by' => 'CODE'
            ]);

            if(!$isOk) {
                $this->addError($classStudentModel->getErrorString());
                return false;
            }

            $this->retVal['classroom_id'] = $classroom->id; 
            $this->addMessage("Successfully joined classroom : {$classroom->class_name}");
            return $classroom;
        }

        public function getStudents($id) {
            $this->db->query(
                "SELECT user.* 
                    FROM class_students as cs 
                    LEFT JOIN users as user
                    ON user.id = cs.student_id
                WHERE class_id = {$id}"
            );
            return $this->db->resultSet();
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
    }
?>
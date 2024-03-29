<?php 

    class ClassStudentModel extends Model
    {
        public $table = 'class_students';

        public function join($classData, $id = null) {

            if(is_null($id)) {
                //search if already joined
                $isExists = parent::single([
                    'class_id' => $classData['class_id'],
                    'student_id' => $classData['student_id']
                ]);
                
                if($isExists) {
                    $this->addError("Student Already Exists.");
                    return false;
                }

                $joinId = parent::store([
                    'class_id' => $classData['class_id'],
                    'student_id' => $classData['student_id'],
                    'joined_by' => $classData['joined_by']
                ]);

                return $joinId;
            }
        }

        public function getStudentClassIds($student_id) {
            if(is_array($student_id)) {
                $results = parent::all([
                    'student_id' => [
                        'condition' => 'in',
                        'value' => $student_id
                    ]
                ]);
            } else {
                $results = parent::all([
                    'student_id' => $student_id
                ]);
            }
            
            $retVal = [];
            foreach($results as $key => $row) {
                $retVal[] = $row->class_id;
            }

            return $retVal;
        }

        public function deleteFromClass($classroom_id) {
            return parent::delete([
                'class_id' => $classroom_id
            ]);
        }
    }
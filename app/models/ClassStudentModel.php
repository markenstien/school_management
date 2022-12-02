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
    }
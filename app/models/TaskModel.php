<?php

use function PHPSTORM_META\map;

    class TaskModel extends Model
    {
        public $table = 'tasks';

        public $_fillables = [
            'task_reference',
            'task_code',
            'task_name', 
            'google_form_link',
            'parent_id',
            'status',
            'description',
            'passing_score',
            'created_by',
            'created_at',
            'start_date'
        ];

        public function createOrUpdate($taskData, $id = null) {
            $_fillables = parent::getFillablesOnly($taskData);
            
            if (is_null($id)) {
                $_fillables['task_reference'] = referenceSeries(parent::lastId(), 4, 'TASK-', date('md'));
                return parent::store($_fillables);
            }else {
                return parent::update($_fillables, $id);
            }
        }

        public function deleteFromClass($classroomId) {
            $tasks = parent::all([
                'parent_id' => $classroomId
            ]);

            $taskIds = [];
            foreach($tasks as $key => $row) {
                $tasksIds [] = $row->id;
            }

            if(!isset($this->taskSubmissionModel)) {
                $this->taskSubmissionModel = model('TaskSubmissionModel');
            }

            if($taskIds) {
                $this->taskSubmissionModel->delete([
                    'global_key' => 'TASK_SUBMISSION_IMAGE',
                    'global_id'  => [
                        'condition' => 'in',
                        'value' => $taskIds
                    ]
                ]);

                parent::delete([
                    'parent_id' => $classroomId
                ]);
            }
            
            return true;
        }
    }
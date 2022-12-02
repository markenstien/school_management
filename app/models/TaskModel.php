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
            'created_at'
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
    }
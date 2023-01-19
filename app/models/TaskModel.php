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
            'start_date',
            'total_items'
        ];


        public function get($id) {
            return $this->getAll([
                'where' => ['task.id' => $id]
            ])[0] ?? false;
        }
        public function getAll($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if(!empty($params['where'])) {
                $where = " WHERE ".parent::conditionConvert($params['where']);
            }

            if(!empty($params['order'])) {
                $order = " ORDER BY {$params['order']}";
            }

            if(!empty($params['limit'])) {
                $limit = " LIMIT {$params['limit']}";
            }

            $this->db->query(
                "SELECT task.*, ifnull(v_total_submission.total,0) as total_submission 
                    FROM {$this->table} as task
                    LEFT JOIN v_total_submission 
                    ON v_total_submission.task_id = task.id
                    {$where} {$order} {$limit}"
            );

            return $this->db->resultSet();
        }

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
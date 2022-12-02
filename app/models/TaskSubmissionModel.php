<?php 
    class TaskSubmissionModel extends Model{
        public $table = 'task_submissions';
        
        public $_fillables = [
            'task_id',
            'user_id',
            'user_score',
        ];

        public function createOrUpdate($data, $id = null) {
            $_fillables = parent::getFillablesOnly($data);
            if(is_null($id)) {
                return parent::store($_fillables);
            }else{
                return parent::update($_fillables, $id);
            }
        }

        public function getAll($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if (isset($params['where'])) {
                 $where = " WHERE ". parent::conditionConvert($params['where']);
            }

            if (isset($params['order'])) {
                $order = " ORDER {$params['order']}";
           }

           if (isset($params['limit']))  {
            $limit = " LIMIT {$params['limit']} ";
           }
           
            $this->db->query(
                "SELECT ts.*, user.user_identification,
                user.firstname,user.lastname,
                task.id as task_id,
                task.parent_id as task_parent_id,
                task.task_name as task_name

                FROM {$this->table} as ts 

                LEFT JOIN users as user 
                ON user.id = ts.user_id 

                LEFT JOIN tasks as task
                on task.id = ts.task_id

                {$where}{$order}{$limit}"
            );
            return $this->db->resultSet();
        }

        public function get($id) {
            $result = $this->getAll(['where' => ['ts.id' => $id]]);
            if(!$result) {
                return false;
            }
            $submission = $result[0];

            if(!isset($this->attachmentModel)) {
                $this->attachmentModel = model('AttachmentModel');
            }

            $submission->attachments = $this->attachmentModel->all(
                ['global_key' => 'TASK_SUBMISSION_IMAGE', 'global_id' => $id]
            );
            
            return $submission;
        }

        public function approve($id) {
            return parent::update([
                'status' => 'approved'
            ], $id);
        }

        public function decline($id) {
            return parent::update([
                'status' => 'denied'
            ], $id);
        }
    }



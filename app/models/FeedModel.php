<?php 
    use Services\CommonService;
    load(['CommonService'], SERVICES);

    class FeedModel extends Model
    {
        public $table = 'feeds';

        public $_fillables = [
            'title',
            'content',
            'owner_id',
            'tags',
            'category',
            'type',
            'parent_id',
            'parent_key'
        ];
        
        public function createOrUpdate($feedData, $id = null) {
            $_fillables = parent::getFillablesOnly($feedData);
            if (is_null($id)) {
                $feed = parent::store($_fillables);
            } else {
                $feed = parent::update($_fillables, $id);
            }

            return $feed;
        }

        public function get($id) {
            $feed = $this->getAll([
                'where' => ['feed.id' => $id]
            ])[0] ?? false;

            if($feed) {
                if(!isset($this->attachmentModel)) {
                    $this->attachmentModel = model('AttachmentModel');
                }
                $feed->attachments = $this->attachmentModel->all(
                    [
                        'global_key' => CommonService::FEED_ATTACHMENTS,
                        'global_id' => $feed->id
                    ]
                );

                return $feed;
            }

            return false;
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
                $order = " LIMIT {$params['limit']}";
            }


            $this->db->query(
                "SELECT feed.* ,
                    concat(user.firstname, ' ',user.lastname) as publisher_name,
                    user.profile as publisher_profile,
                    user.user_type as publisher_type
                    FROM {$this->table} as feed 
                    LEFT JOIN users as user
                    ON user.id = feed.owner_id 
                    {$where} {$order} {$limit}"
            );

            return $this->db->resultSet();
        }
    }
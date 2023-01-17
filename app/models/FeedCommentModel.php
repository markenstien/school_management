<?php 

    class FeedCommentModel extends Model
    {
        public $table = 'feed_comments';
        public $_fillables = [
            'feed_id',
            'user_id',
            'thread_id',
            'replied_to',
            'comment'
        ];

        public function addComment($commentData) {
            $commentData = parent::getFillablesOnly($commentData);
            return parent::store($commentData);
        }

        public function getComments($feed_id) {

            $this->db->query(
                "SELECT concat(commentor.firstname, ' ',commentor.lastname) as commentor,
                    commentor.user_type as commentor_type, {$this->table}.* 
                    FROM {$this->table}
                    
                    LEFT JOIN users as commentor
                    ON commentor.id = feed_comments.user_id
                    
                    ORDER BY {$this->table}.id desc"
            );
            return $this->db->resultSet();
        }
    }
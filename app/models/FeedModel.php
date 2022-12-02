<?php 

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
            }
        }
    }
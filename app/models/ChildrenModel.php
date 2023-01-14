<?php 

    class ChildrenModel extends Model
    {
        public $table = 'children';

        public function addChild($parent_id, $child_id) {
            //validate
            $isChildHasParent = parent::single([
                'child_id' => $child_id
            ]);

            if($isChildHasParent) {
                $this->addError("Child already has existing parent");
                return false;
            }

            return parent::store([
                'parent_id' => $parent_id,
                'child_id'  => $child_id
            ]);
        }

        public function getChildren($parent_id) {
            $this->db->query(
                "SELECT children.id as id, concat(parent.firstname, ' ' ,parent.lastname) as parent_name,
                    concat(child.firstname, ' ' ,child.lastname) as child_name,
                    parent.id as parent_id, child.id as child_id

                    FROM {$this->table}

                    LEFT JOIN users as parent 
                    ON parent.id = children.parent_id
                    
                    LEFT JOIN users as child
                    ON child.id = children.child_id
                    WHERE children.parent_id = '{$parent_id}' "
            );

            return $this->db->resultSet();
        }
    }
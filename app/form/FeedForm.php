<?php 

    namespace Form;
    use Core\Form;

    load(['Form'], CORE);

    class FeedForm extends Form
    {

        public function __construct()
        {
            parent::__construct('feed-form');
            $this->addTitle();
            $this->addContent();
            $this->addTags();
            $this->addType();
        }

        public function addTitle() {
            $this->add([
                'name' => 'title',
                'type' => 'text',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Title'
                ]
            ]);
        }

        public function addContent() {
            $this->add([
                'name' => 'content',
                'type' => 'textarea',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Content'
                ],
                'attributes' => [
                    'rows' => 5
                ]
            ]);
        }

        public function addOwnerId() {

        }

        public function addTags() {
            $this->add([
                'name' => 'tags',
                'type' => 'text',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Tags Seperate by comma(,)'
                ]
            ]);
        }

        public function addCategory() {
            $this->add([
                'name' => 'Tags',
                'type' => 'select',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Category',
                    'option_values' => [
                        'informative',
                        'must-read',
                        'warning'
                    ]
                ]
            ]);
        }

        public function addType() {
            $this->add([
                'name' => 'category',
                'type' => 'select',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Category',
                    'option_values' => [
                        'announcements',
                        'feed'
                    ]
                ]
            ]);
        }
    }
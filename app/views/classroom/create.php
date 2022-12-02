<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Create Classroom</h4>
        </div>

        <div class="card-body">
            <?php echo $form->start([
                'action' => _route('classroom:create')
            ])?>
                <div class="form-group">
                    <?php echo $form->getCol('class_code')?>
                </div>

                <div class="form-group">
                    <?php echo $form->getCol('class_name')?>
                </div>

                <div class="form-group">
                    <?php echo $form->getCol('teacher_id')?>
                </div>

                <div class="form-group">
                    <?php echo $form->getCol('description')?>
                </div>

                <div class="form-group">
                    <?php Form::submit('', 'Create Classroom')?>
                </div>
            <?php echo $form->end()?>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>
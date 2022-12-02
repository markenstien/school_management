<?php build('content') ?>
<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add teacher to : <?php echo $classroom->class_name?></h4>
        </div>
        <div class="card-body">
            <?php Flash::show()?>
            <?php
                Form::open([
                    'method' => 'post'
                ]);

                Form::hidden('classroom_id', $classroom->id);
            ?>
            <div class="form-group">
                <?php
                    Form::label('Teachers');
                    Form::select('teacher_id', $teachers, '', [
                        'class' => 'form-control',
                        'required' => true
                    ]);
                ?>
            </div>

            <div class="form-group">
                <?php Form::submit('', 'Add teacher')?>
            </div>
            <?php Form::close()?>
        </div> 
    </div>
</div>
<?php endbuild()?>
<?php loadTo()?>
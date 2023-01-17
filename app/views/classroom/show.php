<?php build('content') ?>
<div class="card theme-main">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h3>Classroom Of : <?php echo $classroom->class_name?></h3>
                <small>Class Code : <?php echo $classroom->class_code?></small> | 
                <small>Class Reference  : <?php echo $classroom->reference_code?></small>
                <div>
                    Teacher : <?php echo empty($classroom->teacher_id) ? wLinkDefault(_route('classroom:addTeacher', $classroom->id), 'Add Teacher') : $classroom->teacher_name?>
                </div>
            </div>
        </div>
    </div>

    <?php Flash::show()?>
</div>
    <div class="row">
        <div class="col-md-2">
            <div class="list-group">
                <a href="#" 
                    class="list-group-item list-group-item-action">Main</a>
                <a href="<?php echo _route('classroom:show',$id, ['page' => 'students'])?>" 
                    class="list-group-item list-group-item-action">Students</a>
                <a href="<?php echo _route('classroom:show',$id, ['page' => 'tasks'])?>" 
                    class="list-group-item list-group-item-action">Tasks</a>
                <a href="<?php echo _route('classroom:show',$id, ['page' => 'feeds'])?>" 
                    class="list-group-item list-group-item-action">Feeds</a>
                <a href="<?php echo _route('classroom:show',$id, ['page' => 'performance'])?>" 
                    class="list-group-item list-group-item-action">Performance</a>
                <a href="<?php echo _route('classroom:show',$id, ['page' => 'setting'])?>" 
                    class="list-group-item list-group-item-action">Settings</a>
            </div>
        </div>

        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <?php echo grab($pagePath, $pageData)?>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>
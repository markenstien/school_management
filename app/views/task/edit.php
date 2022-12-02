<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit Task # <?php echo $task->task_reference?> </h4>
        </div>
        <div class="card-body">
            <?php echo $taskForm->start()?> 
                <?php echo $taskForm->getFormItems()?>
            <?php echo $taskForm->end()?>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>
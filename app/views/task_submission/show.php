<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Task Submission Preview</h4>
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td>Student ID</td>
                                <td><?php echo $taskSub->user_identification?></td>
                            </tr>
                            <tr>
                                <td>Studet Name</td>
                                <td><?php echo $taskSub->firstname . ' ' .$taskSub->lastname?></td>
                            </tr>
                            <tr>
                                <td>User Score</td>
                                <td><?php echo $taskSub->user_score?></td>
                            </tr>
                            <tr>
                                <td>Task</td>
                                <td>
                                    <a href="<?php echo _route('classroom:show', $taskSub->task_parent_id, [
                                        'page' => 'task_show',
                                        'taskId' => $taskSub->task_id
                                    ])?>"><?php echo $taskSub->task_name?></a>
                                </td>
                            </tr>
                            <tr>
                                <td>Action</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">APPROVE</a>
                                    <a href="#" class="btn btn-sm btn-danger">DECLINE</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="col-md-5">
                    <?php if($taskSub->attachments) :?>
                        <?php foreach($taskSub->attachments as $key => $row) :?>
                            <img src="<?php echo $row->full_url?>" alt=""
                                style="width: 250px;">
                        <?php endforeach?>
                    <?php endif?>
                </div>
            </div>
            
        </div>
    </div> 
<?php endbuild()?>
<?php loadTo()?>
<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Task Submission Preview</h4>
            <?php echo wLinkDefault(_route('classroom:show', $task->parent_id, [
                'page' => 'task_show',
                'taskId' => $task->id
            ]), 'Back to Task')?>
        </div>


        <div class="card-body">
            <?php Flash::show()?>
            <?php Form::open(['method' => 'post'])?>
            <?php Form::hidden('passing_score', $task->passing_score)?>
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
                                <td>Total Items</td>
                                <td>
                                    <?php echo $task->total_items; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Passing Score</td>
                                <td>
                                    <?php echo $task->passing_score; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>User Score</td>
                                <td>
                                    <?php Form::text('user_score', $taskSub->user_score); ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Status</td>
                                <td>
                                    <?php echo $taskSub->status; ?>
                                </td>
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
                            
                            <?php
                                $isShow = isTeacher();
                                if($isShow) {
                                    echo '<tr>';
                                        echo '<td>';
                                            Form::submit('btn_approve', 'APPROVE', ['class' => 'btn btn-primary btn-sm']);
                                            Form::submit('btn_decline', 'DECLINE', ['class' => 'btn btn-danger btn-sm']);
                                        echo '<td/>';
                                    echo '</tr>';
                                }

                                if(!$isShow) {
                                    $isShow = (isEqual($taskSub->status, 'unapproved') && whoIs('id', $taskSub->user_id));
                                }

                                if($isShow) {
                                    echo '<tr>';
                                        echo '<td>';
                                            echo wLinkDefault(_route('task-sub:delete', $taskSub->id, [
                                                'returnTo' => seal(_route('classroom:show', $task->parent_id, [
                                                    'page' => 'task_show',
                                                    'taskId' => $task->id
                                                ]))
                                            ]), 'Delete', ['class' => 'form-verify']);
                                        echo '</td>';
                                    echo '</tr>';
                                }
                            ?>
                            
                        </table>
                    </div>
                </div>

                <div class="col-md-5">
                    <?php if($taskSub->attachments) :?>
                        <?php foreach($taskSub->attachments as $key => $row) :?>
                            <img src="<?php echo $row->full_url?>" alt=""
                                style="width: 400px;">
                        <?php endforeach?>
                    <?php endif?>
                </div>
            </div>
            <?php Form::close()?>
        </div>
    </div> 
<?php endbuild()?>
<?php loadTo()?>
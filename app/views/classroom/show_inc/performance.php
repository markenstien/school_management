<div class="sub-header">
    <h4>Performance</h4>
    <!-- <?php echo wLinkDefault(_route('classroom:show', $id, ['page' => 'feed_create']), 'Create Feed')?> -->
</div>

<?php if(!isset($_POST['btn_performance'])) :?>
<div class="card">
    <h4 class="text-center mt-2">Performance Preview</h4>
    <div class="card-body">
        <?php
            Form::open([
                'method' => 'post'
            ])
        ?>
        <div class="form-group row">
            <div class="col"><?php echo $_formCommon->getCol('start_date'); ?></div>
            <div class="col"><?php echo $_formCommon->getCol('end_date'); ?></div>
        </div>

        <div class="form-group mt-3">
            <?php Form::submit('btn_performance', 'View Performance')?>
        </div>

        <?php Form::close(); ?>
    </div>
</div>

<?php else:?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Student Performance</h4>
                <?php echo wLinkDefault(_route('classroom:show', $id, [
                    'page' => 'performance'
                ]), 'Re-Filter')
            ?>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                    <td width="50px"></td>
                    <?php foreach($tasks as $task) :?>
                        <td class="text-center">
                            <?php echo $task->task_reference?>
                            <div>
                                <small><?php echo $task->start_date?></small> </br>
                            </div>
                        </td>
                    <?php endforeach?>
                </tbody>

                <tbody>
                    <?php foreach($students as $user) :?>
                        <tr>
                            <td><?php echo $user->firstname . ' '.$user->lastname?></td>
                            <?php foreach($tasks as $key => $task) :?>
                                <td><?php wPrintResult((wSearchAndPrintTask($task->id, $user->id, $taskSubmissionFormatted)))?></td>
                            <?php endforeach?>
                        </tr>
                    <?php endforeach?>
                </tbody>
            </table>
            <p class="text-center mt-5">Performance Report for date <?php echo $_POST['start_date']?> To <?php echo $_POST['end_date']?> as of <?php echo date('Y-m-d H:i')?></p>
        </div>
    </div>
<?php endif?>


<?php
    function wSearchAndPrintTask($taskId, $userId, &$taskSubmissionFormatted) {
        foreach($taskSubmissionFormatted as $key => $row) {
            $task = $taskSubmissionFormatted[$taskId] ?? null;
            if(is_null($task))
                return 'pass nothing';
                
            $userSubmittion = $task[$userId] ?? null;

            if(is_null($userSubmittion)) {
                return 'pass nothing';
            } else {
                return $userSubmittion;
            }
        }
    }

    function wPrintResult($result = null) {
        if($result == 'pass nothing' || $result == null) {
            ?> 
                <span class="badge badge-warning">N/A</span>
            <?php
        } else {
            $badgeColor = 'primary';
                if(isEqual($result->status,'approved')) {
                    $badgeColor = 'success';
                } else if(isEqual($result->status,'unapproved')) {
                    $badgeColor = 'danger';
                }
            ?>
                <span class="badge badge-<?php echo $badgeColor?>" title="<?php echo $result->status?>">
                    <?php echo $result->user_score?>/<?php echo $result->passing_score?>
                </span>
            <?php
        }
    }
?>
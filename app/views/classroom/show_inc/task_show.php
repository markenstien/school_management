<div>
    <h4>Task Preview #<?php echo $task->task_reference?></h4>
    <?php
    if(isTeacher()) {
        echo wLinkDefault(_route('task:edit', $task->id, [
            'returnTo' => seal(_route('classroom:show', $task->parent_id, ['page' => 'tasks']))
        ]), 'Edit Task');

        echo '&nbsp;';

        echo wLinkDefault(_route('task:delete', $task->id, [
            'returnTo' => seal(_route('classroom:show', $task->parent_id, ['page' => 'tasks']))
        ]), 'Delete Task', ['class' => 'form-verify','data-message' => 'Are you sure you want to delete, task #' .$task->task_reference . ' This is an irevokable Action']);
    }      
    ?>
    <div class="row">
        <div class="col-md-6">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>Task Name</td>
                        <td><?php echo $task->task_name?></td>
                    </tr>
                    <tr>
                        <td>Task Code</td>
                        <td><?php echo $task->task_code?></td>
                    </tr>
                    <tr>
                        <td>Task Status</td>
                        <td><?php echo $task->status?></td>
                    </tr>
                    <?php if(isTeacher() || isStudent()) :?>
                    <tr>
                        <td>Task Link</td>
                        <td>
                            <a href="<?php echo $task->google_form_link?>">Exam Link</a>
                        </td>
                    </tr>
                    <?php endif?>
                </table>
            </div>
            <p>Description</p>
            <div><?php echo $task->description?></div>
        </div>

        <div class="col-md-6">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>Start Date</td>
                        <td><?php echo $task->start_date?></td>
                    </tr>

                    <tr>
                        <td>Deadline</td>
                        <td><?php echo date('Y-m-d', strtotime('+2 days '.$task->start_date))?></td>
                    </tr>
                    <tr>
                        <td>Total Items</td>
                        <td><?php echo $task->total_items?></td>
                    </tr>
                    <tr>
                        <td>Passing Score</td>
                        <td><?php echo $task->passing_score?></td>
                    </tr>
                    <tr>
                        <td>Total Submitted</td>
                        <td><?php echo $task->total_submission?></td>
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>
</div>
<?php echo wDivider(30)?>
<div>
    <h4>Submissions</h4>
        <?php 
            if(isStudent()) {
                echo wLinkDefault('#', 'Upload Exam Result', [
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#exampResultModal'
                ]);
            }

            if(isTeacher()) {
                echo wLinkDefault('#', 'Upload Google Sheet Excel', [
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#uploadGoogleSheet'
                ]);
            }
        ?>
    <?php Flash::show('submit_message')?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <th>Student #</th>
                <th>Date Submitted</th>
                <th>Score</th>
                <th>Status</th>
                <th>Action</th>
            </thead>

            <tbody>
                <?php foreach($task_submissions as $key => $row) :?>
                    <tr>
                        <td><?php echo $row->user_identification?></td>
                        <td><?php echo $row->created_at?></td>
                        <td><?php echo $row->user_score?></td>
                        <td><?php echo $row->status?></td>
                        <td>
                            <?php echo wLinkDefault(_route('task-sub:show', $row->id), 'Show')?>
                        </td>
                    </tr>
                <?php endforeach?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="exampResultModal" tabindex="-1" aria-labelledby="exampResultModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampResultModalLabel">Exam Result</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">
        <?php
            Form::open([
                'method' => 'post',
                'url' => _route('task-sub:create', null, [
                    'returnTo' => seal(_route('classroom:show', $task->parent_id, [
                        'page' => 'task_show',
                        'taskId' => $task->id
                    ]))
                ]),
                'enctype' => 'multipart/form-data'
            ]);

            Form::hidden('task_id', $task->id);
            Form::hidden('user_id', whoIs('id'));
        ?>
        <div class="form-group">
            <?php
                Form::label('Score');
                Form::text('user_score','' , ['class' => 'form-control', 'required' => true])
            ?>
        </div>

        <div class="form-group">
            <?php
                echo $_attachmentForm->getCol('file');
                echo $_attachmentForm->getCol('global_key');
            ?>
        </div>

        <div class="form-group">
            <?php Form::submit('', 'Save Submission')?>
        </div>
        
        <?php Form::close()?>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="uploadGoogleSheet" tabindex="-1" aria-labelledby="exampResultModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampResultModalLabel">Upload Google Sheet Result</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">
        <h4>Guidelines</h4>
        <span class="badge badge-danger">Email, Student Number, Score Columns</span> should exists in your spreadsheet(in any order).
        <?php
            Form::open([
                'method' => 'post',
                'url' => _route('task:upload-google-sheet', null, [
                    'returnTo' => seal(_route('classroom:show', $task->parent_id, [
                        'page' => 'task_show',
                        'taskId' => $task->id
                    ]))
                ]),
                'enctype' => 'multipart/form-data'
            ]);

            Form::hidden('task_id', $task->id);
            Form::hidden('user_id', whoIs('id'));
        ?>
        <div class="form-group">
            <?php
                echo $_attachmentForm->getCol('file');
                echo $_attachmentForm->getCol('global_key');
            ?>
        </div>

        <div class="form-group">
            <?php Form::submit('btn_upload_google_sheet', 'Save Submission')?>
        </div>
        
        <?php Form::close()?>
      </div>
    </div>
  </div>
</div>
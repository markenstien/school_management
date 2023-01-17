<div class="sub-header">
    <h4>Tasks</h4>
    <?php
        if(isTeacher() || isAdmin()) 
            echo wLinkDefault(_route('classroom:show',$id, ['page' => 'task_create']) , 'Create');
    ?>
</div>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <th>#</th>
            <th>Reference</th>
            <th>Name</th>
            <th>Start Date</th>
            <th>Status</th>
            <th>Submitted</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php foreach($tasks as $key => $row) :?>
                <tr>
                    <td><?php echo ++$key?></td>
                    <td><?php echo $row->task_reference?></td>
                    <td><?php echo $row->task_name?></td>
                    <td><?php echo $row->start_date?></td>
                    <td><?php echo $row->status?></td>
                    <td><?php echo $row->total_submission ?? 0?> / <?php echo $totalStudent?></td>
                    <td><?php echo wLinkDefault(_route('classroom:show', $row->parent_id, [
                        'page' => 'task_show',
                        'taskId' => $row->id
                    ]), 'Show')?></td>
                </tr>
            <?php endforeach?>
        </tbody>
    </table>
</div>
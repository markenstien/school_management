<h4>Tasks</h4>
<?php echo wLinkDefault(_route('classroom:show',$id, ['page' => 'task_create']) , 'Create')?>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <th>#</th>
            <th>Code</th>
            <th>Name</th>
            <th>Submitted</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php foreach($tasks as $key => $row) :?>
                <tr>
                    <td><?php echo ++$key?></td>
                    <td><?php echo $row->task_code?></td>
                    <td><?php echo $row->task_name?></td>
                    <td>3/10</td>
                    <td><?php echo wLinkDefault(_route('classroom:show', $row->parent_id, [
                        'page' => 'task_show',
                        'taskId' => $row->id
                    ]), 'Show')?></td>
                </tr>
            <?php endforeach?>
        </tbody>
    </table>
</div>
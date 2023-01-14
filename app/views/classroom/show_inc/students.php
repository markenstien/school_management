<div class="sub-header">
    <h4>Students</h4>
    <?php
        if(isAdmin() || isTeacher()) {
            echo wLinkDefault(_route('classroom:show', $id, [
                'page' => 'students_add'
            ]), 'Add Student');
        }
    ?>
</div>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <th width="3%">#</th>
            <th width="15%">Student Id</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Action</th>
        </thead>

        <tbody>
            <?php foreach($students as $key => $row) :?>
                <tr>
                    <td><?php echo ++$key?></td>
                    <td><?php echo $row->user_identification?></td>
                    <td><?php echo $row->firstname . ' ' . $row->lastname?></td>
                    <td><?php echo $row->gender?></td>
                    <td>
                        <?php echo wLinkDefault(_route('user:show', $row->id), 'Show')?>
                        <?php echo wLinkDefault(_route('class-student:delete', $row->class_student_id), 'Delete')?>
                    </td>
                </tr>
            <?php endforeach?>
        </tbody>
    </table>
</div>
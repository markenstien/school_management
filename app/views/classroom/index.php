<?php build('content') ?>
    <div class="card theme-main">
        <div class="card-header">
            <h4 class="card-title">Classrooms</h4> 
            <?php
                if(isAdmin())
                    echo wLinkDefault(_route('classroom:create'), 'Create');

                if(isStudent())
                    echo wLinkDefault(_route('classroom:join'), 'Join');
            ?>
        </div>

        <div class="card-body">
            <?php Flash::show()?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Reference</th>
                        <th>Class Code</th>
                        <th>Class Name</th>
                        <th>Teacher</th>
                        <th>Total Student</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php foreach($classrooms as $key => $row) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row->reference_code?></td>
                                <td><?php echo $row->class_code?></td>
                                <td><?php echo $row->class_name?></td>
                                <td><?php echo $row->teacher_name ?? 'N/A'?></td>
                                <td><?php echo $row->total_student?></td>
                                <td><?php echo wLinkDefault(_route('classroom:show', $row->id), 'Show')?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>
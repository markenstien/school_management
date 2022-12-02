<?php build('content') ?>
    <div class="card">
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
                        <th>Status</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php foreach($classrooms as $key => $row) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row->reference_code?></td>
                                <td><?php echo $row->class_code?></td>
                                <td><?php echo $row->class_name?></td>
                                <td><?php echo $row->teacher_id?></td>
                                <td><?php echo $row->is_active?></td>
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
<?php build('content')?>
    <div class="card">
        <div class="card-body">
            <h4>Parent Dashboard</h4>

            <?php echo wDivider(40)?>
            <h5>Children</h5>
            <?php echo wLinkDefault(_route('user:show', whoIs('id'), ['action' => 'add-child']), 'Add Child')?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                    </thead>


                    <tbody>
                        <?php foreach($children as $key => $row):?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row->child_name?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>
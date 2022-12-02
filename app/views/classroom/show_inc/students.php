<h4>Students</h4>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <th>#</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Email</th>
        </thead>

        <tbody>
            <?php foreach($students as $key => $row) :?>
                <tr>
                    <td><?php echo ++$key?></td>
                    <td><?php echo $row->firstname . ' ' . $row->lastname?></td>
                    <td><?php echo $row->gender?></td>
                    <td><?php echo $row->email?></td>
                </tr>
            <?php endforeach?>
        </tbody>
    </table>
</div>
<?php build('content')?>
<?php Flash::show()?>
<div class="row">
	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
			<div class="d-flex justify-content-between align-items-baseline">
				<h6 class="card-title mb-0">Classrooms</h6>
			</div>
			<div class="row">
				<div class="col-6 col-md-12 col-xl-5">
					<h3 class="mb-2"><?php echo count($classrooms ?? [])?></h3>
					<div class="d-flex align-items-baseline">
						<p class="text-success">
						<span>Total</span>
						</p>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>

	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
			<div class="d-flex justify-content-between align-items-baseline">
				<h6 class="card-title mb-0">Students</h6>
			</div>
			<div class="row">
				<div class="col-6 col-md-12 col-xl-5">
					<h3 class="mb-2"><?php echo $totalStudent?></h3>
					<div class="d-flex align-items-baseline">
						<p class="text-success">
						<span>Total</span>
						</p>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>

	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
			<div class="d-flex justify-content-between align-items-baseline">
				<h6 class="card-title mb-0">Tasks</h6>
			</div>
			<div class="row">
				<div class="col-6 col-md-12 col-xl-5">
					<h3 class="mb-2"><?php echo $taskTotal?></h3>
					<div class="d-flex align-items-baseline">
						<p class="text-success">
						<span>total</span>
						</p>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>

<?php echo wDivider(30)?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Classrooms</h4>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Students</th>
                    <th>View</th>
                </thead>

                <tbody>
                    <?php foreach($classrooms as $key => $row) :?>
                        <tr>
                            <td><?php echo ++$key?></td>
                            <td><?php echo $row->class_name?></td>
                            <td><?php echo $row->total_student?></td>
                            <td><?php echo wLinkDefault(_route('classroom:show', $row->id), 'Show Classroom')?></td>
                        </tr>
                    <?php endforeach?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php loadTo()?>
<?php build('content')?>
<?php Flash::show()?>
<div class="row">
	<div class="col-md-3 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
			<div class="d-flex justify-content-between align-items-baseline">
				<h6 class="card-title mb-0">Classrooms</h6>
			</div>
			<div class="row">
				<div class="col-6 col-md-12 col-xl-5">
					<h3 class="mb-2"><?php echo $totalClassroom?></h3>
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

	<div class="col-md-3 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
			<div class="d-flex justify-content-between align-items-baseline">
				<h6 class="card-title mb-0">Teachers</h6>
			</div>
			<div class="row">
				<div class="col-6 col-md-12 col-xl-5">
					<h3 class="mb-2"><?php echo $totalTeacher?></h3>
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

	<div class="col-md-3 grid-margin stretch-card">
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
						<span>total</span>
						</p>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>

	<div class="col-md-3 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
			<div class="d-flex justify-content-between align-items-baseline">
				<h6 class="card-title mb-0">Parent</h6>
			</div>
			<div class="row">
				<div class="col-6 col-md-12 col-xl-5">
					<h3 class="mb-2"><?php echo $totalParent?></h3>
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
<?php endbuild()?>
<?php loadTo()?>
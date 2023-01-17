<?php build('content')?>
<?php Flash::show()?>
<div class="row">
	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Clasrooms</h6>
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
				<h6 class="card-title mb-0">Teachers</h6>
			</div>
			<div class="row">
				<div class="col-6 col-md-12 col-xl-5">
					<h3 class="mb-2"><?php echo count($teachers ?? [])?></h3>
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
					<h3 class="mb-2"><?php echo count($tasks ?? [])?></h3>
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
<?php if($parent) :?>
    <h4>Parent : <?php echo $parent->parent_name?></h4>
    <?php echo wLinkDefault(_route('user:show', $parent->parent_id), 'show parent')?>
<?php else:?>
    <h4>No Parent Found</h4>
<?php endif?>

<?php endbuild()?>
<?php loadTo()?>
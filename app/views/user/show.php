<?php build('content') ?>
	<h4 class="mb-5"><?php echo $user->firstname . ' ' .$user->lastname?></h4>
	<?php Flash::show()?>
	<div class="row">
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">User Preview</h4>
					<?php if(isAdmin() || isEqual(whoIs('id'), $user->id)) :?>
						<?php echo wLinkDefault(_route('user:edit', $user->id), 'Edit Account')?>
					<?php endif?>
				</div>

				<div class="card-body">
					<h4>Personal Information</h4>
					<div>
						<img src="<?php echo $user->profile?>" style="width: 150px;">
					</div>
					<div>
						<label class="tx-11">User Identification</label>
						<p><span class="badge bg-warning"><?php echo $user->user_identification?></span></p>
					</div>

					<div>
						<label class="tx-11">Username</label>
						<p><?php echo $user->username?></p>
					</div>
					
					<div>
						<label class="tx-11">Name</label>
						<p><?php echo $user->lastname . ',' . $user->firstname?></p>
					</div>
					<div>
						<label class="tx-11">Gender</label>
						<p><?php echo $user->gender?></p>
					</div>
					<div>
						<label class="tx-11">Email And Mobile Number</label>
						<p><?php echo $user->email?></p>
						<p><?php echo $user->phone?></p>

						<!-- <span><a href="<?php echo _route('user:sendCredential' , $user->id)?>" title="Click to send the credential to the user">Send Credentials to User :</a><?php echo $user->email?></span> -->
					</div>
					<div>
						<label class="tx-11">Address</label>
						<p><?php echo "$user->address"?></p>
					</div>
					<hr>

					<?php
						if(isAdmin()) {
							echo wLinkDefault(_route('user:delete', $user->id, [
								'returnTo' => seal(_route('user:index'))
							]), 'Delete User', [
								'class' => 'btn btn-danger form-verify',
								'data-message' => 'Are you sure you want to delete this user?'
							]);
						}
					?>
				</div>
			</div>	
		</div>

		<?php if(isEqual($user->user_type, 'teacher') && isEqual(whoIs('user_type'), 'admin')) :?>
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-4 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
						<div class="d-flex justify-content-between align-items-baseline">
							<h6 class="card-title mb-0">Classrooms</h6>
						</div>
						<div class="row">
							<div class="col-6 col-md-12 col-xl-5">
								<h3 class="mb-2"><?php echo count($teacher_data['classrooms'] ?? [])?></h3>
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
								<h3 class="mb-2"><?php echo $teacher_data['totalStudent']?></h3>
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
								<h3 class="mb-2"><?php echo $teacher_data['taskTotal']?></h3>
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
								<?php foreach($teacher_data['classrooms'] as $key => $row) :?>
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
		</div>
		<?php endif?>
	</div>
<?php endbuild()?>
<?php loadTo()?>
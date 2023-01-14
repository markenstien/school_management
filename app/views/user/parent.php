<?php build('content') ?>
	<?php Flash::show()?>
	<div class="row">
		<div class="col-md-4">
			<div class="card theme-main">
				<div class="card-header">
					<h4 class="card-title">User Preview</h4>
                    <?php echo wLinkDefault(_route('user:edit', $user->id) , 'Edit')?>
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
				</div>
			</div>	
		</div>

        <div class="col-md-8">
            <div class="card theme-main">
                <div class="card-header">
                    <h4 class="card-title">Children</h4>
                    <?php echo wLinkDefault(_route('user:show', $user->id, [
                        'action' => 'add-child'
                    ]), 'Add Child')?>
                </div>

                <div class="card-body">
                    <?php if(isEqual($action, 'add-child')) :?>
                            <?php
                                Form::open([
                                    'method' => 'post'
                                ])
                            ?>
                                <div class="form-group">
                                    <?php
                                        Form::label('Child Student Number');
                                        Form::text('user_identification', '', [
                                            'class' => 'form-control',
                                            'required' => true
                                        ]);
                                    ?>
                                </div>

                                <div class="form-group">
                                    <?php Form::submit('add_child', 'Add Child')?>
                                </div>
                            <?php Form::close()?>
                        <?php else:?>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>#</th>
                                <th>Parent</th>
                                <th style="background-color: var(--main-color); color:#fff">Child</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                <?php foreach($children as $key => $row) :?>
                                <tr>
                                    <td><?php echo ++$key?></td>
                                    <td><?php echo $row->parent_name?></td>
                                    <td><?php echo $row->child_name?></td>
                                    <td>
                                        <?php echo wLinkDefault(_route('user:show', $row->child_id), 'Preview Child Account')?> | 
                                        <?php echo wLinkDefault(_route('user:delete-child', $row->id), 'Remove Child')?>
                                    </td>
                                </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif?>
                </div>
            </div>
        </div>
	</div>
<?php endbuild()?>
<?php loadTo()?>
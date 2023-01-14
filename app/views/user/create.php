<?php build('content') ?>
	<div class="card theme-main">
		<div class="card-header">
			<h4 class="card-title">Create User</h4>
			<?php echo wLinkDefault(_route('user:index'), 'List of Users')?>
		</div>

		<div class="card-body">
			<?php Flash::show()?>
			<?php echo $user_form->getForm()?>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo()?>
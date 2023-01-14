
<div class="sub-header">
<h4>Add Student</h4>
<?php
	echo wLinkDefault(_route('classroom:show', $id, [
	'page' => 'students'
	]), 'Students');
?>
</div>
<?php if(is_null($userSearched)) :?>
<?php
	Form::open([
		'method' => 'post'
	])
?>
	<div class="form-group">
		<?php
			Form::label('Student ID');
			Form::text('user_identification', '' , [
				'class' => 'form-control'
			]);
		?>
	</div>

	<div class="form-group">
		<?php Form::submit('btn_search_user_identification', 'Search Student')?>
	</div>
<?php Form::close()?>
<?php else:?>
<div class="text-center">
	<div class="table-responsive">
		<table class="table table-bordered">
			<tr>
				<td>Student ID:</td>
				<td><?php echo $userSearched->user_identification?></td>
			</tr>
			<tr>
				<td>Name</td>
				<td><?php echo $userSearched->firstname . ' '. $userSearched->lastname?></td>
			</tr>
		</table>
	</div>

	<div>
		<img src="<?php echo $userSearched->profile?>" style="width: 200px;">
	</div>

	<div>
		<?php echo wLinkDefault(_route('classroom:addStudent', $classroom->id, [
			'studentId' => seal($userSearched->id)
		]), 'Add Student')?>
	</div>
</div>
<?php endif?>
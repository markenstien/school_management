<div class="sub-header">
	<h4>Create Feed</h4>
	<?php echo wLinkDefault(_route('classroom:show', $id, ['page' => 'feeds']), 'Feeds')?>
</div>

<?php echo $feedForm->start([
	'enctype' => 'multipart/form-data',
	'url'  => _route('feed:create', null, [
		'returnTo' => seal(_route('classroom:show', $id, ['page' => 'feeds']))
	])
])?>

	<?php Form::hidden('classroom_id', $id)?>
	<?php echo $feedForm->getFormItems()?>
	<?php echo $_attachmentForm->getRow('file_array[]')?>

<div class="form-group">
	<?php Form::submit('', 'Create Feed')?>
</div>
<?php echo $feedForm->end()?>
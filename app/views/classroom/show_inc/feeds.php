<h4>Feeds</h4>
<h5><?php echo wLinkDefault('#', 'Create Feed')?></h5>

<div id="feed" style="display: none">
    <?php grab('tmp/inc/form_feed',[
        'returnRoute' => _route('classroom:show', $id, ['page' => 'feeds']),
        'parentId' => $id,
        'parentKey' => 'Classroom'
    ])?>
</div>

<?php if($feeds) :?>
    <?php foreach($feeds as $key => $row) :?>
        <div class="card" style="border: 1px solid #000;">
            <div class="card-header">
                <div class="card-title"><?php echo $row->title?></div>
            </div>
            <div class="card-body">
                <?php echo $row->content?>
                <div>#<?php echo $row->tags?></div>
            </div>
        </div>
    <?php endforeach?>
<?php endif?>
<h4>Feeds</h4>
<?php echo wLinkDefault(_route('classroom:show', $id, ['page' => 'feed_create']), 'Create Feed')?>

<div id="feed" style="display: none">
    <?php grab('tmp/inc/form_feed',[
        'returnRoute' => _route('classroom:show', $id, ['page' => 'feeds']),
        'parentId' => $id,
        'parentKey' => 'Classroom'
    ])?>
</div>

<?php if($feeds) :?>
    <?php foreach($feeds as $key => $row) :?>
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <a href="<?php echo _route('classroom:show', $id, ['page' => 'feed_show', 'feedId' => $row->id])?>"><?php echo $row->title?></a>
                </div>
                <?php echo $row->content?>
                <hr>
                <div>#<?php echo $row->tags?></div>
            </div>
        </div>
    <?php endforeach?>
<?php endif?>
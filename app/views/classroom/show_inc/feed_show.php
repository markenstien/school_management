<div class="row">
    <div class="col-md-7" style="border:1px solid #000; padding: 12px;">
        <h4><?php echo $feed->title?></h4>
        <small>Posted On : <?php echo $feed->created_at?></small>

        <div style="border:1px solid #000;padding: 10px;border-radius: 5px;">
            <?php echo $feed->content?>
        </div>
        <?php echo wDivider('30')?>

        <div style="border:1px solid #000;padding: 10px;border-radius: 5px;">
            <div class="row">
                <div class="col-md-4">
                    Attachments
                    <?php if(!empty($feed->attachments)) :?>
                        <?php foreach($feed->attachments as $attKey => $att) :?>
                            <div>
                                <a href="/ViewerController/show?file=<?php echo $att->full_url?>" target="_blank"><?php echo $att->display_name?></a>
                            </div>
                        <?php endforeach?>
                    <?php endif?>
                </div>
                <div class="col-md-8">
                   <div style="text-align: right;">
                        Publisher
                        <div>
                            <h4><?php echo $feed->publisher_name?></h4>
                            <img src="<?php echo $feed->publisher_profile?>" style="width: 90px;">
                            <div><small><?php echo $feed->publisher_type?></small></div>
                        </div>
                   </div>
                </div>
            </div>
            <?php echo wDivider(20)?>
            <a href="<?php echo _route('feed:delete', $feed->id, [
                    'returnTo' => seal(
                        _route('classroom:show', $id, ['page' => 'feeds'])
                    ),
                ])?>" 
                class="btn btn-danger btn-sm">Delete</a>
        </div>
    </div>

    <div class="col-md-5">
        <!-- ADD COMMENT SECTION -->
        <section>
            <?php
                Form::small('Add Comment');
                Form::textarea('', '' , ['class' => 'form-control','rows' => 2]);
                Form::file('file');
            ?>
            <div><?php Form::submit('btn_add_comment', 'Add Comment');?></div>
        </section>

        <!-- COMMENTS -->

        <section>
            <div class="comments">
                
            </div>
        </section>
    </div>
</div>
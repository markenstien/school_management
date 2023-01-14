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
            <!-- COMMENTS -->
        
        <?php echo wDivider(30)?>
        <section>
            <div class="comments">
            <?php if(empty($comments)) :?>
                <p class="text-center">There are no comments here..</p> 
                <?php else:?>
                    <h4>Comments</h4>
                    <?php foreach($comments as $key => $row):?>
                        <div class="card">
                           <div class="card-footer">
                            <small><strong><?php echo $row->commentor?></strong></small>
                            <p><?php echo $row->comment?></p> 
                            <small style="color:#9F8772"><?php echo time_since($row->created_at)?></small>     
                           </div>                  
                        </div>
                    <?php endforeach?>
            <?php endif?>
            </div>
        </section>
    </div>

    <div class="col-md-5">
        <?php
            Form::open([
                'method' => 'post'
            ]);

            Form::hidden('feed_id', $feed->id);
        ?>
            <!-- ADD COMMENT SECTION -->
            <section>
                <?php
                    Form::small('Add Comment');
                    Form::textarea('comment', '' , ['class' => 'form-control','rows' => 2]);
                    Form::file('file');
                ?>
                <div><?php Form::submit('btn_add_comment', 'Add Comment');?></div>
            </section>
        <?php Form::close()?>
    </div>
</div>
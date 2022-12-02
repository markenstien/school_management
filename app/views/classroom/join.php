<?php build('content') ?>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Join Class Room</h4>
            </div>

            <div class="card-body">
                <?php Flash::show()?>
                <?php
                    Form::open([
                        'method' => 'post'
                    ])
                ?>
                    <div class="form-group">
                        <?php
                            Form::text('join_code', '' , [
                                'class' => 'form-control-lg form-control',
                                'placeholder' => 'Enter Classroom Join Code'
                            ]);
                        ?>
                    </div>

                    <div class="form-group text-center mt-5">
                        <?php Form::submit('', 'Join Class')?>
                    </div>
                <?php Form::close()?>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>
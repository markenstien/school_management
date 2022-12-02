<div>
    <h4> Class Settings </h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <td>Teacher</td>
                <td>
                    <?php echo $classroom->teacher_name?>
                    <div><?php echo wLinkDefault(_route('classroom:addTeacher', $classroom->id), 'Edit', [
                        'returnTo' => seal(_route('classroom:show', $classroom->id, [
                            'page' => 'setting'
                        ]))
                    ])?></div>
                </td>
            </tr>
            <tr>
                <td>Join Code</td>
                <td>
                    <?php echo $classroom->join_code?>
                    <div><?php echo wLinkDefault(_route('classroom:resetJoinCode', $classroom->id), 'Reset Join Code')?></div>
                </td>
            </tr>
        </table>
    </div>

    <?php echo wDivider()?>
    <div>
        <h4 class="bg-danger">Danger Zone</h4>
        <a href="<?php echo _route('classroom:delete', $classroom->id)?>" class="btn btn-warning btn-lg form-verify" data-message="Are you sure want to delete this clasroom? data will be lost.">
            DELETE CLASSROOM
        </a>
    </div>
</div>
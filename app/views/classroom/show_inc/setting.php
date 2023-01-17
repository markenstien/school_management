<div class="sub-header">
    <h4> Class Settings </h4>
</div>
<div class="table-responsive">
    <table class="table table-bordered">
        <?php if(isAdmin()) :?>
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
        <?php endif?>
        <tr>
            <td>Join Code</td>
            <td>
                <?php echo $classroom->join_code?>
                <div><?php echo wLinkDefault(_route('classroom:resetJoinCode', $classroom->id), 'Reset Join Code')?></div>
            </td>
        </tr>
    </table>
</div>

<?php echo wDivider(100)?>
<div>
    <a href="<?php echo _route('classroom:delete', $classroom->id)?>" class="btn btn-warning btn-lg form-verify" data-message="Are you sure want to delete this clasroom? data will be lost.">
        DELETE CLASSROOM
    </a>
</div>
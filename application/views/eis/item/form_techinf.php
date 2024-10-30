<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idForm';
// Start Slug = EDIT
$arraySelected = array();
if (isset($slug) && $slug == 'EDIT') {
    foreach ($selected as $eSelected) {
        $arraySelected[$eSelected['dtmsubcodetechinf_seq']] = $eSelected;
    }
}
// End Slug = EDIT
?>

<div class="row">
    <div class="col-md-12">
        <h6> <strong> <u> Technical Information : </u></strong></h6>
        <?php foreach ($result as $r) :
        ?>
            <div class="form-group row">
                <label for="iddtmsubcode_id" class="col-md-3 col-form-label"><?php echo $r['dtmsubcodetechinf_seq'] . " ({$r['dtmsubcodetechinf_remark']})"; ?></label>
                <div class="col-sm-8 col-xs-12">
                    <input type="hidden" name="dtmsubcodetechinf_ids[]" value="<?php echo $r['dtmsubcodetechinf_id']; ?>">
                    <textarea name="dtmsubcodetechinf_remark_<?php echo $r['dtmsubcodetechinf_id']; ?>" class="form-control form-control-sm" id="" cols="30" rows="2" placeholder="<?php echo $r['dtmsubcodetechinf_remark']; ?>"><?php echo isset($arraySelected[$r['dtmsubcodetechinf_seq']]['dtmitemtechinf_note']) ? $arraySelected[$r['dtmsubcodetechinf_seq']]['dtmitemtechinf_note'] : null; ?></textarea>
                </div>
            </div>

        <?php
        endforeach; ?>
    </div>
</div>

<script type="text/javascript">

</script>
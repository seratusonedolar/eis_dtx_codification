<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idFormTechInformation';
?>
<form id="<?php echo $form_id; ?>" class="form-horizontal">
    <input type="hidden" name="slug" value="<?php echo isset($slug) ? $slug : null; ?>">
    <input type="hidden" name="dtmsubcode_id" value="<?php echo isset($dtmsubcode_id) ? $dtmsubcode_id : null; ?>">
    <input type="hidden" name="dtmsubcodetechinf_id" value="<?php echo isset($row['dtmsubcodetechinf_id']) ? $row['dtmsubcodetechinf_id'] : null; ?>">

    <div class="form-group row">
        <label for="iddtmsubcodetechinf_seq" class="col-md-2 col-form-label">Seq</label>
        <div class="col-sm-4 col-xs-12">
            <input type="number" name="dtmsubcodetechinf_seq" id="iddtmsubcodetechinf_seq" class="form-control form-control-sm" placeholder="Seq" value="<?php echo isset($row['dtmsubcodetechinf_seq']) ? $row['dtmsubcodetechinf_seq'] : null;  ?>" <?php echo ($slug == 'edit') ? 'readonly' : ''; ?>>
        </div>
    </div>

    <div class="form-group row">
        <label for="iddtmsubcodetechinf_remark" class="col-md-2 col-form-label">Remark</label>
        <div class="col-sm-8 col-xs-12">
            <input type="text" name="dtmsubcodetechinf_remark" class="form-control form-control-sm" placeholder="Remark" value="<?php echo isset($row['dtmsubcodetechinf_remark']) ? $row['dtmsubcodetechinf_remark'] : null;  ?>">
        </div>
    </div>

    <div class="form-group row">
        <label for="iddtmsubcodetechinf_is_required" class="col-md-2 col-form-label">Required</label>
        <div class="col-sm-8 col-xs-12">
            <select name="dtmsubcodetechinf_is_required" id="iddtmsubcodetechinf_is_required" class="form-control form-control-sm">
                <option value="FALSE" <?php echo  set_select('dtmsubcodetechinf_is_required', 'FALSE', isset($row['dtmsubcodetechinf_is_required']) && $row['dtmsubcodetechinf_is_required'] == FALSE ? TRUE : FALSE); ?>>FALSE</option>
                <option value="TRUE" <?php echo  set_select('dtmsubcodetechinf_is_required', 'TRUE', isset($row['dtmsubcodetechinf_is_required']) && $row['dtmsubcodetechinf_is_required'] == TRUE ? TRUE : FALSE); ?>>TRUE</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="iddtmsubcodetechinf_is_active" class="col-md-2 col-form-label">IsActive</label>
        <div class="col-sm-8 col-xs-12">
            <select name="dtmsubcodetechinf_is_active" id="iddtmsubcodetechinf_is_active" class="form-control form-control-sm">
                <option value="TRUE" <?php echo  set_select('dtmsubcodetechinf_is_active', 'TRUE', isset($row['dtmsubcodetechinf_is_active']) && $row['dtmsubcodetechinf_is_active'] == TRUE ? TRUE : FALSE); ?>>TRUE</option>
                <option value="FALSE" <?php echo  set_select('dtmsubcodetechinf_is_active', 'FALSE', isset($row['dtmsubcodetechinf_is_active']) && $row['dtmsubcodetechinf_is_active'] == FALSE ? TRUE : FALSE); ?>>FALSE</option>
            </select>
        </div>
    </div>

    <hr>

    <?php if (checkPermission('MASTERITEM.CODIFICATION.SUBCODEDETAIL.ADD')) : ?>
        <button type="submit" name="btnSubmit" id="idbtnSubmit<?php echo $form_id; ?>" onclick="action_submit_detail_techinformation('<?php echo $form_id; ?>')" class="btn btn-sm btn-info">
            <i class="fas fa-save"></i> Save
        </button>
        <button onclick="event.preventDefault();window.location.reload()" class="btn btn-sm btn-default">
            <i class="fa fa-refresh"></i> Reset
        </button>
    <?php endif; ?>

</form>
<script type="text/javascript">
    function action_submit_detail_techinformation(form_id) {
        event.preventDefault();
        var form = $('#' + form_id)[0];

        // Loading animate
        $('#idbtnSubmit' + form_id).html('<i class="fa fa-spinner fa-pulse"></i> Loading');
        $('#idbtnSubmit' + form_id).attr('disabled', true);

        $.ajax({
            url: '<?php echo base_url() . $class_link . '/action_submit_detail_techinformation' ?>',
            type: "POST",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                if (data.code == 200) {
                    $('.errInput').html('');
                    reload_table_techinformation();
                    subcode_techinformation_form('add', '<?php echo $dtmsubcode_id; ?>', '');
                    toastAlert('success', data.messages);
                } else if (data.code == 401) {
                    toastAlert('warning', data.messages + '<br>' + data.data);
                    generateToken(data._token);
                } else if (data.code == 400) {
                    toastAlert('error', data.messages);
                    generateToken(data._token);
                } else {
                    toastAlert('error', 'Unknown Error');
                    generateToken(data._token);
                }
            },
            complete: function(dt) {
                // Loading animate
                $('#idbtnSubmit' + form_id).html('<i class="fas fa-save"></i> Save');
                $('#idbtnSubmit' + form_id).attr('disabled', false);
            }
        });
    }
</script>
<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idFormRole';
?>

<form id="<?php echo $form_id; ?>" class="form-horizontal">
    <input type="hidden" name="dtmrole_id" value="<?php echo isset($dtmrole_id) ? $dtmrole_id : null; ?>">
    <input type="hidden" name="slug" value="<?php echo isset($slug) ? $slug : null; ?>">

    <div class="row">
        <div class="col-md-12">

            <div class="form-group row">
                <label for="iddtmrole_name" class="col-md-2 col-form-label">RoleName</label>
                <div class="col-sm-8 col-xs-12">
                    <div class="input-group">
                        <input name="dtmrole_name" id="iddtmrole_name" type="text" class="form-control form-control-sm" value="<?php echo isset($row['dtmrole_name']) ? $row['dtmrole_name'] : null; ?>" placeholder="RoleName">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="iddtmrole_desc" class="col-md-2 col-form-label">RoleDesc</label>
                <div class="col-sm-8 col-xs-12">
                    <div class="input-group">
                        <input name="dtmrole_desc" id="iddtmrole_desc" type="text" class="form-control form-control-sm" value="<?php echo isset($row['dtmrole_desc']) ? $row['dtmrole_desc'] : null; ?>" placeholder="RoleDesc">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="iddtmrole_is_active" class="col-md-2 col-form-label">RoleActive</label>
                <div class="col-sm-4 col-xs-12">
                    <select name="dtmrole_is_active" class="form-control form-control-sm select2" id="idselect">
                        <option value="1" <?php echo set_select('dtmrole_is_active', 'TRUE', isset($row['dtmrole_is_active']) && $row['dtmrole_is_active'] == 1 ? TRUE : FALSE); ?>>TRUE</option>
                        <option value="0" <?php echo set_select('dtmrole_is_active', 'FALSE', isset($row['dtmrole_is_active']) && $row['dtmrole_is_active'] == 0 ? TRUE : FALSE); ?>>FALSE</option>
                    </select>
                </div>
            </div>

            <hr>

            <div class="form-group row">
                <div class="col-sm-4 offset-md-2 col-xs-12">
                    <button type="submit" name="btnSubmit" id="idbtnSubmit<?php echo $form_id; ?>" onclick="action_role_submit('<?php echo $form_id; ?>')" class="btn btn-sm btn-info">
                        <i class="fas fa-save"></i> Save
                    </button>
                    <button type="reset" name="btnReset" class="btn btn-sm btn-default">
                        <i class="fas fa-sync-alt"></i> Reset
                    </button>
                </div>
            </div>

        </div>
    </div>

</form>

<script type="text/javascript">
    function action_role_submit(form_id) {
        event.preventDefault();
        var form = $('#' + form_id)[0];

        // Loading animate
        $('#idbtnSubmit' + form_id).html('<i class="fa fa-spinner fa-pulse"></i> Loading');
        $('#idbtnSubmit' + form_id).attr('disabled', true);

        $.ajax({
            url: '<?php echo base_url() . $class_link . '/action_role_submit' ?>',
            type: "POST",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                if (data.code == 200) {
                    $('.errInput').html('');
                    reload_table();
                    toggle_modal('', '');
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
            error: function(jqXHR) {
                toastAlert('error', jqXHR.statusText);
            },
            complete: function(dt) {
                // Loading animate
                $('#idbtnSubmit' + form_id).html('<i class="fa fa-save"></i> Save');
                $('#idbtnSubmit' + form_id).attr('disabled', false);
            }
        });
    }

</script>
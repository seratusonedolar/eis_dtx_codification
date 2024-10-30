<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idForm';

if ($slug == 'EXTENDVIEW') {
    $row['dtmsubcodehierarchy_name'] = $dtmsubcodehierarchy_name;
    $row['dtmsubcodehierarchy_code'] = $dtmsubcodehierarchy_code;
}
?>
<form id="<?php echo $form_id; ?>" class="form-horizontal">
    <input type="hidden" name="slug" value="<?php echo isset($slug) ? $slug : null; ?>">
    <input type="hidden" name="dtmsubcode_id" value="<?php echo isset($dtmsubcode_id) ? $dtmsubcode_id : null; ?>">
    <input type="hidden" name="dtmsubcodehierarchy_id" value="<?php echo isset($dtmsubcodehierarchy_id) ? $dtmsubcodehierarchy_id : null; ?>">
    <div class="form-group row">
        <label for="iddtmsubcodehierarchy_code" class="col-md-2 col-form-label">Code</label>
        <div class="col-sm-4 col-xs-12">
            <input type="text" name="dtmsubcodehierarchy_code" id="iddtmsubcodehierarchy_code" class="form-control form-control-sm" placeholder="HierarchyCode" value="<?php echo isset($row['dtmsubcodehierarchy_code']) ? $row['dtmsubcodehierarchy_code'] : null;  ?>" <?php echo ($slug == 'edit' && checkPermission('MASTERITEM.CODIFICATION.EDIT.CODE')  == false && $row['dtmsubcodehierarchy_state'] == 'confirmed') ? 'readonly' : ''; ?> maxlength="15" autofocus>
        </div>
    </div>

    <div class="form-group row">
        <label for="iddtmsubcodehierarchy_name" class="col-md-2 col-form-label">Name</label>
        <div class="col-sm-8 col-xs-12">
            <input type="text" name="dtmsubcodehierarchy_name" class="form-control form-control-sm" placeholder="HierarchyName" value="<?php echo isset($row['dtmsubcodehierarchy_name']) ? $row['dtmsubcodehierarchy_name'] : null;  ?>">
        </div>
    </div>

    <div class="form-group row">
        <label for="iddtmsubcodehierarchy_is_active" class="col-md-2 col-form-label">IsActive</label>
        <div class="col-sm-8 col-xs-12">
            <select name="dtmsubcodehierarchy_is_active" id="iddtmsubcodehierarchy_is_active" class="form-control">
                <option value="1" <?php echo  set_select('dtmsubcodehierarchy_is_active', '1', isset($row['dtmsubcodehierarchy_is_active']) && $row['dtmsubcodehierarchy_is_active'] == 1 ? TRUE : FALSE); ?>>True</option>
                <option value="0" <?php echo  set_select('dtmsubcodehierarchy_is_active', '0', isset($row['dtmsubcodehierarchy_is_active']) && $row['dtmsubcodehierarchy_is_active'] == 0 ? TRUE : FALSE); ?>>False</option>
            </select>
        </div>
    </div>

    <hr>
    <!-- <h6>Depend On</h6>

    <div class="form-group row">
        <label for="idq_id" class="col-md-2 col-form-label">IsActive</label>
        <div class="col-sm-8 col-xs-12">
            <select name="txtcompany_id" id="idtxtcompany_id" class="form-control">
                <?php if (!empty($row['company_id'])) : ?>
                    <option value="<?php echo $row['company_id'];  ?>" selected="selected"> <?php echo "{$row['company_id']} | {$row['name']}" ?></option>
                <?php endif; ?>
                <option value="1">Active</option>
                <option value="0">NonActive</option>
            </select>
        </div>
    </div> -->

    <?php if (checkPermission('MASTERITEM.CODIFICATION.ADD')) : ?>
        <button type="submit" name="btnSubmit" id="idbtnSubmit<?php echo $form_id; ?>" onclick="action_submit_hierarchy('<?php echo $form_id; ?>')" class="btn btn-sm btn-info">
            <i class="fas fa-save"></i> Save
        </button>
        <button onclick="event.preventDefault();window.location.reload()" class="btn btn-sm btn-default">
            <i class="fa fa-refresh"></i> Reset
        </button>
    <?php endif; ?>

</form>
<script type="text/javascript">
    function action_submit_hierarchy(form_id) {
        event.preventDefault();
        var form = $('#' + form_id)[0];

        // Loading animate
        $('#idbtnSubmit' + form_id).html('<i class="fa fa-spinner fa-pulse"></i> Loading');
        $('#idbtnSubmit' + form_id).attr('disabled', true);

        $.ajax({
            url: '<?php echo base_url() . $class_link . '/action_submit_hierarchy' ?>',
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
                    subcode_hierarchy_form('add', '<?php echo $dtmsubcode_id; ?>', '');
                    toastAlert('success', data.messages);
                    $('#iddtmsubcodehierarchy_code').focus();
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

    function toastAlert(type, title) {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        switch (type) {
            case 'success':
                toastr.success(title);
                break;
            case 'info':
                toastr.info(title);
                break;
            case 'warning':
                toastr.warning(title);
                break;
            default:
                toastr.error(title);
        }
    }
</script>

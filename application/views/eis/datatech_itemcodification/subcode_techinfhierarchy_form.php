<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idForm';
?>
<form id="<?php echo $form_id; ?>" class="form-horizontal">
    <input type="hidden" name="slug" value="<?php echo isset($slug) ? $slug : null; ?>">
    <input type="hidden" name="dtmsubcodetechinf_id" value="<?php echo isset($dtmsubcodetechinf_id) ? $dtmsubcodetechinf_id : null; ?>">
    <input type="hidden" name="dtmsubcodetechinfhierarchy_id" value="<?php echo isset($dtmsubcodetechinfhierarchy_id) ? $dtmsubcodetechinfhierarchy_id : null; ?>">
    <div class="form-group row">
        <label for="iddtmsubcodetechinfhierarchy_code" class="col-md-2 col-form-label">Code</label>
        <div class="col-sm-4 col-xs-12">
            <input type="text" name="dtmsubcodetechinfhierarchy_code" id="iddtmsubcodetechinfhierarchy_code" class="form-control form-control-sm" placeholder="TechinfCode" value="<?php echo isset($row['dtmsubcodetechinfhierarchy_code']) ? $row['dtmsubcodetechinfhierarchy_code'] : null;  ?>" maxlength="15" autofocus>
        </div>
    </div>

    <div class="form-group row">
        <label for="iddtmsubcodetechinfhierarchy_name" class="col-md-2 col-form-label">Name</label>
        <div class="col-sm-8 col-xs-12">
            <input type="text" name="dtmsubcodetechinfhierarchy_name" class="form-control form-control-sm" placeholder="TechinfName" value="<?php echo isset($row['dtmsubcodetechinfhierarchy_name']) ? $row['dtmsubcodetechinfhierarchy_name'] : null;  ?>">
        </div>
    </div>

    <div class="form-group row">
        <label for="iddtmsubcodetechinfhierarchy_is_active" class="col-md-2 col-form-label">IsActive</label>
        <div class="col-sm-8 col-xs-12">
            <select name="dtmsubcodetechinfhierarchy_is_active" id="iddtmsubcodetechinfhierarchy_is_active" class="form-control">
                <option value="1" <?php echo  set_select('dtmsubcodetechinfhierarchy_is_active', '1', isset($row['dtmsubcodetechinfhierarchy_is_active']) && $row['dtmsubcodetechinfhierarchy_is_active'] == 1 ? TRUE : FALSE); ?>>True</option>
                <option value="0" <?php echo  set_select('dtmsubcodetechinfhierarchy_is_active', '0', isset($row['dtmsubcodetechinfhierarchy_is_active']) && $row['dtmsubcodetechinfhierarchy_is_active'] == 0 ? TRUE : FALSE); ?>>False</option>
            </select>
        </div>
    </div>

    <hr>
    <?php if (checkPermission('MASTERITEM.CODIFICATION.ADD')) : ?>
        <button type="submit" name="btnSubmit" id="idbtnSubmit<?php echo $form_id; ?>" onclick="action_submit_techinf('<?php echo $form_id; ?>')" class="btn btn-sm btn-info">
            <i class="fas fa-save"></i> Save
        </button>
        <button onclick="event.preventDefault();window.location.reload()" class="btn btn-sm btn-default">
            <i class="fa fa-refresh"></i> Reset
        </button>
    <?php endif; ?>

</form>
<script type="text/javascript">
    function action_submit_techinf(form_id) {
        event.preventDefault();
        var form = $('#' + form_id)[0];

        // Loading animate
        $('#idbtnSubmit' + form_id).html('<i class="fa fa-spinner fa-pulse"></i> Loading');
        $('#idbtnSubmit' + form_id).attr('disabled', true);

        $.ajax({
            url: '<?php echo base_url() . $class_link . '/action_submit_techinf' ?>',
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
                    subcode_techinfhierarchy_form('add', '<?php echo $dtmsubcodetechinf_id; ?>', '');
                    toastAlert('success', data.messages);
                    $('#iddtmsubcodetechinfhierarchy_code').focus();
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

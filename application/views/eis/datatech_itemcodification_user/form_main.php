<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idForm';
?>
<?php if ($slug == 'edit' && checkPermission('MASTERITEM.CODIFICATION.DELETE')) : ?>
    <button class="btn btn-sm btn-danger float-right" title="Delete" onclick="action_delete_subcode('<?php echo isset($dtmsubcode_id) ? $dtmsubcode_id : null; ?>')"> <i class="fas fa-trash"></i> </button>
<?php endif; ?>
<form id="<?php echo $form_id; ?>" class="form-horizontal">
    <input type="hidden" name="slug" placeholder="slug" value="<?php echo !empty($slug) ? $slug : null; ?>">
    <input type="hidden" name="dtmsubcode_id" placeholder="dtmsubcode_id" value="<?php echo !empty($dtmsubcode_id) ? $dtmsubcode_id : null; ?>">
    <input type="hidden" name="dtmsubcode_parent" placeholder="dtmsubcode_parent" value="<?php echo isset($dtmsubcode_parent) ? $dtmsubcode_parent : null; ?>">
    <input type="hidden" name="dtmsubcode_level" placeholder="dtmsubcode_level" value="<?php echo isset($dtmsubcode_level) ? $dtmsubcode_level : null; ?>">
    <div class="row">
        <div class="col-md-12">
            <?php if ($dtmsubcode_level == 1) : ?>
                <div class="form-group row">
                    <label for="iddtmsubcode_code" class="col-md-2 col-form-label">Code</label>
                    <div class="col-sm-5 col-xs-12">
                        <input type="text" name="dtmsubcode_code" id="iddtmsubcode_code" class="form-control form-control-sm" placeholder="Code" maxlength="15" value="<?php echo isset($dtmsubcode_code) ? $dtmsubcode_code : null; ?>">
                    </div>
                </div>
            <?php endif; ?>
            <div class="form-group row">
                <label for="iddtmsubcode_name" class="col-md-2 col-form-label">Name</label>
                <div class="col-sm-8 col-xs-12">
                    <input type="text" name="dtmsubcode_name" id="iddtmsubcode_name" class="form-control form-control-sm" placeholder="Name" value="<?php echo isset($dtmsubcode_name) ? $dtmsubcode_name : null; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="iddtmsubcode_is_active" class="col-md-2 col-form-label">IsActive</label>
                <div class="col-sm-8 col-xs-12">
                    <select name="dtmsubcode_is_active" id="iddtmsubcode_is_active" class="form-control form-control-sm">
                        <option value="1" <?php echo set_select('dtmsubcode_is_active', '1', isset($dtmsubcode_is_active) && $dtmsubcode_is_active == '1' ? TRUE : FALSE); ?>>TRUE</option>
                        <option value="0" <?php echo set_select('dtmsubcode_is_active', '0', isset($dtmsubcode_is_active) && $dtmsubcode_is_active == '0' ? TRUE : FALSE); ?>>FALSE</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-4 offset-md-2 col-xs-12">
                    <button type="submit" name="btnSubmit" id="idbtnSubmit<?php echo $form_id; ?>" onclick="action_submit_msubcode('<?php echo $form_id; ?>')" class="btn btn-sm btn-info">
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
    function action_submit_msubcode(form_id) {
        event.preventDefault();
        var form = $('#' + form_id)[0];

        // Loading animate
        $('#idbtnSubmit' + form_id).html('<i class="fa fa-spinner fa-pulse"></i> Loading');
        $('#idbtnSubmit' + form_id).attr('disabled', true);

        $.ajax({
            url: '<?php echo base_url() . $class_link . '/action_submit_msubcode' ?>',
            type: "POST",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                if (data.code == 200) {
                    $('.errInput').html('');
                    toggle_modal('', '');
                    window.location.reload();
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
                $('#idbtnSubmit' + form_id).html('<i class="fa fa-save"></i> Save');
                $('#idbtnSubmit' + form_id).attr('disabled', false);
            }
        });
    }

    function action_delete_subcode(dtmsubcode_id) {
        event.preventDefault();
        var conf = confirm('Are you sure ?');
        if (conf) {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() . $class_link . '/action_delete_subcode'; ?>',
                data: {
                    dtmsubcode_id: dtmsubcode_id
                },
                success: function(data) {
                    if (data.code == 200) {
                        toastAlert('success', data.messages);
                        window.location.reload();
                    } else {
                        toastAlert('error', data.messages);
                    }
                },
                error: function(request, status, error) {
                    toastAlert('error', error);
                }
            });
        }
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

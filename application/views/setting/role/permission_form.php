<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idForm';
$arrayRolePermission = [];
if (!empty($rolePermission)) {
    $arrayRolePermission = array_column($rolePermission, 'dtmrolepermission_name');
}
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Role Permissions</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <form id="<?php echo $form_id; ?>" class="form-horizontal">
            <input type="hidden" name="dtmrole_id" id="iddtmrole_id" placeholder="iddtmrole_id" value="<?php echo isset($dtmrole_id) ? $dtmrole_id : null; ?>">

            <div class="row">
                <div class="col-md-12">

                    <table border="0" style="width: 100%;">
                        <?php foreach ($permissions as $p => $el) : ?>
                            <tr>
                                <td style="width: 35%;">
                                    <div class="form-check">
                                        <?php
                                        $checked = '';
                                        if (in_array($p, $arrayRolePermission)) {
                                            $checked = 'checked';
                                        }
                                        ?>
                                        <input type="checkbox" name="dtmrolepermission_names[]" class="form-check-input" id="<?php echo $p; ?>" value="<?php echo $p; ?>" <?php echo $checked; ?>>
                                        <label class="form-check-label" for="<?php echo $p; ?>"><?php echo $p; ?></label>
                                    </div>
                                </td>
                                <td style="width: 65%;">
                                    <i> :
                                        <?= $el ?>
                                    </i>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                    <hr>

                    <div class="form-group row">
                        <div class="col-sm-4 offset-md-2 col-xs-12">
                            <button type="submit" name="btnSubmit" id="idbtnSubmit<?php echo $form_id; ?>" onclick="action_submit('<?php echo $form_id; ?>')" class="btn btn-sm btn-info">
                                <i class="fas fa-save"></i> Save
                            </button>
                            <button type="reset" name="btnReset" class="btn btn-sm btn-default" onclick="window.location.reload()">
                                <i class="fas fa-sync-alt"></i> Reset
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </form>
    </div>
</div>



<script type="text/javascript">
    function action_submit(form_id) {
        event.preventDefault();
        var form = $('#' + form_id)[0];

        // Loading animate
        $('#idbtnSubmit' + form_id).html('<i class="fa fa-spinner fa-pulse"></i> Loading');
        $('#idbtnSubmit' + form_id).attr('disabled', true);

        $.ajax({
            url: '<?php echo base_url() . $class_link . '/action_submit' ?>',
            type: "POST",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.code == 200) {
                    $('.errInput').html('');
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
<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idFormBatch';
?>

<div class="row">
    <div class="col-md-12">
        <form id="<?php echo $form_id; ?>" class="form-horizontal">
            <h6> <strong> <u> Processed : </u> </strong></h6>
            <div id="idtblitemprocessed"></div>
            <hr>
            <h6> <strong> <u> EIS Items : </u> </strong></h6>
            <div id="idtblitemEis"></div>
            <hr>

            <input type="hidden" name="txtitem_id" id="iditem_id" placeholder="iditem_id" value="<?php echo isset($eis_item['item_id']) ? $eis_item['item_id'] : null; ?>">
            <input type="hidden" name="slugAllowDuplicate" id="idslugAllowDuplicate" placeholder="idslugAllowDuplicate" value="0">

            <div class="form-group row">
                <div class="col-sm-4 col-xs-12">
                    <button type="submit" name="btnSubmit" id="idbtnSubmit<?php echo $form_id; ?>" onclick="action_submit_batch('<?php echo $form_id; ?>')" class="btn btn-sm btn-info">
                        <i class="fas fa-save"></i> Save
                    </button>
                    <button type="reset" name="btnReset" class="btn btn-sm btn-default">
                        <i class="fas fa-sync-alt"></i> Reset
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>


<script type="text/javascript">
    formbatch_tblitemprocessed();
    formbatch_tblitem();

    function formbatch_tblitemprocessed() {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/formbatch_tblitemprocessed'; ?>',
            async: false,
            success: function(html) {
                $('#idtblitemprocessed').html(html);
            }
        });
    }

    function formbatch_tblitem() {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/formbatch_tblitem'; ?>',
            async: false,
            success: function(html) {
                $('#idtblitemEis').html(html);
            }
        });
    }

    function action_submit_batch(form_id) {
        event.preventDefault();
        var form = $('#' + form_id)[0];

        // Loading animate
        $('#idbtnSubmit' + form_id).html('<i class="fa fa-spinner fa-pulse"></i> Loading');
        $('#idbtnSubmit' + form_id).attr('disabled', true);

        $.ajax({
            url: '<?php echo base_url() . $class_link . '/action_submit_batch' ?>',
            type: "POST",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.code == 200) {
                    toggle_modal('', '');
                    reload_table();
                    toastAlert('success', data.messages);
                } else if (data.code == 401) {
                    toastAlert('warning', data.messages + '<br>' + data.data);
                    generateToken(data._token);
                } else if (data.code == 400) {
                    toastAlert('error', data.messages);
                    generateToken(data._token);
                } else if (data.code == 402) {
                    // Duplicate Subcode
                    toastAlert('warning', data.messages);
                    generateToken(data._token);
                    toggle_modal_warning('Dupplicate Item Subcode', data.warninghtml);
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

    function confirmsubmit_warning() {
        toggle_modal_warning('', '')
        $('#idslugAllowDuplicate').val('1');
        action_submit('<?php echo $form_id; ?>');
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
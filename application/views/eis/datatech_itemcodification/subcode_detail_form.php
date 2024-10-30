<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idForm';
?>
<form id="<?php echo $form_id; ?>" class="form-horizontal">
    <input type="hidden" name="slug" value="<?php echo isset($slug) ? $slug : null; ?>">
    <input type="hidden" name="dtmsubcode_id" value="<?php echo isset($dtmsubcode_id) ? $dtmsubcode_id : null; ?>">
    <input type="hidden" name="dtmsubcodedtl_id" value="<?php echo isset($row['dtmsubcodedtl_id']) ? $row['dtmsubcodedtl_id'] : null; ?>">
    <div class="form-group row">
        <label for="iddtmsubcodedtl_seq" class="col-md-2 col-form-label">Subcode</label>
        <div class="col-sm-4 col-xs-12">
            <input type="number" name="dtmsubcodedtl_seq" id="iddtmsubcodedtl_seq" class="form-control form-control-sm" placeholder="Subcode" value="<?php echo isset($row['dtmsubcodedtl_seq']) ? $row['dtmsubcodedtl_seq'] : null;  ?>" <?php echo ($slug == 'edit') ? 'readonly' : '' ?>>
        </div>
    </div>

    <div class="form-group row">
        <label for="iddtmsubcodedtl_type" class="col-md-2 col-form-label">Type</label>
        <div class="col-sm-8 col-xs-12">
            <select name="dtmsubcodedtl_type" id="iddtmsubcodedtl_type" class="form-control form-control-sm" <?php echo ($slug == 'edit') ? 'readonly' : '' ?>>
                <option value="OPTION" <?php echo  set_select('dtmsubcodedtl_type', 'OPTION', isset($row['dtmsubcodedtl_type']) && $row['dtmsubcodedtl_type'] == 'OPTION' ? TRUE : FALSE); ?>>OPTION</option>
                <option value="TEXT" <?php echo  set_select('dtmsubcodedtl_type', 'TEXT', isset($row['dtmsubcodedtl_type']) && $row['dtmsubcodedtl_type'] == 'TEXT' ? TRUE : FALSE); ?>>TEXT</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="iddtmsubcode_option_id" class="col-md-2 col-form-label">Option</label>
        <div class="col-sm-8 col-xs-12">
            <select name="dtmsubcode_option_id" id="iddtmsubcode_option_id" class="form-control form-control-sm" <?php echo ($slug == 'edit') ? 'readonly' : '' ?>>
                <?php if (isset($row['dtmsubcode_option_id'])) : ?>
                    <option value="<?= $row['dtmsubcode_option_id']; ?>" selected><?= $row['dtmsubcode_name'] ?></option>
                <?php endif; ?>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="iddtmsubcodedtl_remark" class="col-md-2 col-form-label">Remark</label>
        <div class="col-sm-8 col-xs-12">
            <input type="text" name="dtmsubcodedtl_remark" class="form-control form-control-sm" placeholder="Remark" value="<?php echo isset($row['dtmsubcodedtl_remark']) ? $row['dtmsubcodedtl_remark'] : null;  ?>">
        </div>
    </div>

    <div class="form-group row">
        <label for="iddtmsubcodedtl_is_required" class="col-md-2 col-form-label">Required</label>
        <div class="col-sm-8 col-xs-12">
            <select name="dtmsubcodedtl_is_required" id="iddtmsubcodedtl_is_required" class="form-control form-control-sm">
                <option value="TRUE" <?php echo  set_select('dtmsubcodedtl_is_required', 'TRUE', isset($row['dtmsubcodedtl_is_required']) && $row['dtmsubcodedtl_is_required'] == TRUE ? TRUE : FALSE); ?>>TRUE</option>
                <option value="FALSE" <?php echo  set_select('dtmsubcodedtl_is_required', 'FALSE', isset($row['dtmsubcodedtl_is_required']) && $row['dtmsubcodedtl_is_required'] == FALSE ? TRUE : FALSE); ?>>FALSE</option>
            </select>
        </div>
    </div>

    <hr>
    <?php if (checkPermission('MASTERITEM.CODIFICATION.SUBCODEDETAIL.ADD')) : ?>
        <button type="submit" name="btnSubmit" id="idbtnSubmit<?php echo $form_id; ?>" onclick="action_submit_detail('<?php echo $form_id; ?>')" class="btn btn-sm btn-info">
            <i class="fas fa-save"></i> Save
        </button>
        <button onclick="event.preventDefault();window.location.reload()" class="btn btn-sm btn-default">
            <i class="fa fa-refresh"></i> Reset
        </button>
    <?php endif; ?>
</form>
<script type="text/javascript">
    render_subcode('iddtmsubcode_option_id', '2', '<?php echo $dtmsubcode_id; ?>');

    $('#iddtmsubcodedtl_type').change(function() {
        if ($(this).val() == 'OPTION') {
            $('#iddtmsubcode_option_id').attr('disabled', false);
            render_subcode('iddtmsubcode_option_id', '2', '<?php echo $dtmsubcode_id; ?>');
        } else {
            $('#iddtmsubcode_option_id').attr('disabled', true);
        }
    });

    function render_subcode(attributID, dtmsubcode_level, dtmsubcode_parent) {
        $("#" + attributID).select2({
            theme: 'bootstrap4',
            placeholder: '--Select Option--',
            minimumInputLength: 0,
            // allowClear: true,
            ajax: {
                url: '<?php echo base_url(); ?>/eis/datatech_itemcodification/autocomplete_subcode?dtmsubcode_level=' + dtmsubcode_level + '&dtmsubcode_parent=' + dtmsubcode_parent,
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        param_search: params.term,
                    };
                },
                processResults: function(response) {
                    return {
                        results: $.map(response, function(item) {
                            return {
                                id: item.dtmsubcode_id,
                                text: item.dtmsubcode_name,
                            };
                        })
                    };
                },
                cache: true
            }
        });
    }

    function action_submit_detail(form_id) {
        event.preventDefault();
        var form = $('#' + form_id)[0];

        // Loading animate
        $('#idbtnSubmit' + form_id).html('<i class="fa fa-spinner fa-pulse"></i> Loading');
        $('#idbtnSubmit' + form_id).attr('disabled', true);

        $.ajax({
            url: '<?php echo base_url() . $class_link . '/action_submit_detail' ?>',
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
                    subcode_detail_form('add', '<?php echo $dtmsubcode_id; ?>', '');
                    toastAlert('success', data.messages);
                    $('#iddtmsubcodedtl_seq').focus();
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

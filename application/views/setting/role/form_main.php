<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idForm';
?>

<table border="1" style="width: 100%;">
    <tr>
        <td style="width: 20%; font-weight: bold;">Classif</td>
        <td style="width: 30%;">: <?php echo $eis_item['classif_name']; ?></td>
        <td style="width: 20%; font-weight: bold;">SubClassif</td>
        <td style="width: 30%;">: <?php echo $eis_item['subclassif_name']; ?></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Name</td>
        <td colspan="3">: <?php echo $eis_item['name']; ?></td>
    </tr>
</table>
<hr>
<form id="<?php echo $form_id; ?>" class="form-horizontal">
    <input type="hidden" name="txtitem_id" id="iditem_id" placeholder="iditem_id" value="<?php echo isset($eis_item['item_id']) ? $eis_item['item_id'] : null; ?>">

    <div class="row">
        <div class="col-md-12">

            <div class="form-group row">
                <label for="iddtmsubcode_id0" class="col-md-2 col-form-label">Dttech. Classif 0</label>
                <div class="col-sm-8 col-xs-12">
                    <select name="dtmsubcode_id0" id="iddtmsubcode_id0" class="form-control form-control-sm">
                        <?php if (!empty($row['company_id'])) : ?>
                            <option value="<?php echo $row['company_id'];  ?>" selected="selected"> <?php echo "{$row['company_id']} | {$row['name']}" ?></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="iddtmsubcode_id1" class="col-md-2 col-form-label">Dttech. Classif 1</label>
                <div class="col-sm-8 col-xs-12">
                    <select name="dtmsubcode_id1" id="iddtmsubcode_id1" class="form-control form-control-sm">
                        <?php if (!empty($row['company_id'])) : ?>
                            <option value="<?php echo $row['company_id'];  ?>" selected="selected"> <?php echo "{$row['company_id']} | {$row['name']}" ?></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <hr>

            <div id="idvwsubcode"></div>

            <div class="form-group row">
                <div class="col-sm-4 offset-md-2 col-xs-12">
                    <button type="submit" name="btnSubmit" id="idbtnSubmit<?php echo $form_id; ?>" onclick="action_submit('<?php echo $form_id; ?>')" class="btn btn-sm btn-info">
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
    render_subcode('iddtmsubcode_id0', 0, '');

    $('#iddtmsubcode_id0').on('select2:select', function(e) {
        var data = e.params.data;
        console.log(data);
        render_subcode('iddtmsubcode_id1', 1, data.id);
    });

    $('#iddtmsubcode_id1').on('select2:select', function(e) {
        var data = e.params.data;
        renderview_subcode(data.id);
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
                                text: item.dtmsubcode_name
                            };
                        })
                    };
                },
                cache: true
            }
        });
    }

    function renderview_subcode(dtmsubcode_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/form_subcode'; ?>',
            data: {
                dtmsubcode_id: dtmsubcode_id
            },
            success: function(html) {
                $('#idvwsubcode').html(html);
            }
        });
    }

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
                console.log(data);
                if (data.code == 200) {
                    $('.errInput').html('');
                    toggle_modal('', '');
                    reload_table();
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
            complete: function(dt){
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
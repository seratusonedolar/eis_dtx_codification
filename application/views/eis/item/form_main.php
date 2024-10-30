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
    <tr>
        <td style="font-weight: bold;">UOM</td>
        <td colspan="3">: <?php echo $eis_item['um_name']; ?></td>
    </tr>
</table>
<hr>
<form id="<?php echo $form_id; ?>" class="form-horizontal">
    <input type="hidden" name="txtitem_id" id="iditem_id" placeholder="iditem_id" value="<?php echo isset($eis_item['item_id']) ? $eis_item['item_id'] : null; ?>">
    <input type="hidden" name="slugAllowDuplicate" id="idslugAllowDuplicate" placeholder="idslugAllowDuplicate" value="0">
    <input type="hidden" name="txtdtmitem_id" id="iddtmitem_id" placeholder="iddtmitem_id" value="<?php echo isset($dtmitem_id) ? $dtmitem_id : null; ?>">
    <input type="hidden" name="slug" id="slug" placeholder="slug" value="<?php echo isset($slug) ? $slug : null; ?>">

    <div class="row">
        <div class="col-md-12">

            <div class="form-group row">
                <label for="iddtmsubcode_id0" class="col-md-2 col-form-label text-right">Dttech. Classif 0</label>
                <div class="col-sm-9 col-xs-12">
                    <select name="dtmsubcode_id0" id="iddtmsubcode_id0" class="form-control form-control-sm">
                        <!-- HARDCODING on Datatex0 is RAWMATERIAL -->
                        <?php if (isset($selected)) : ?>
                            <option value="<?php echo $selected['dtmsubcode_id'];  ?>" selected="selected"> <?php echo $selected['dtmsubcode_name']; ?></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="iddtmsubcode_id1" class="col-md-2 col-form-label text-right">Dttech. Classif 1</label>
                <div class="col-sm-9 col-xs-12">
                    <select name="dtmsubcode_id1" id="iddtmsubcode_id1" class="form-control form-control-sm">
                        <?php if (!empty($selected['dtmitemRow'])) : ?>
                            <option value="<?php echo $selected['dtmitemRow']['dtmsubcode_id'];  ?>" selected="selected"> <?php echo "{$selected['dtmitemRow']['dtmsubcode_name']}" ?></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <hr>
            <div id="idvwsubcode"></div>

            <hr>
            <div id="idvwtechinf"></div>

            <hr>
            <div id="idvwtechinf_v2"></div>

            <hr>
            <div id="idvwotherinf"></div>

            <?php if (isset($parentRelated['count']) && $parentRelated['count'] > 0) : ?>
                <div class="col-md-12">
                    <div class="card bg-secondary">
                        <div class="card-header">
                            <h4 class="card-title"><strong>Notice !</strong></h4>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            There are <strong><?php echo $parentRelated['count']; ?></strong> item related with same ParentID, you can select <strong>Save & Go</strong> to process other related ItemID
                            <button type="submit" name="btnSubmit" id="idbtnSubmitSaveGo<?php echo $form_id; ?>" onclick="action_submit('<?php echo $form_id; ?>', true)" class="btn btn-sm btn-info">
                                <i class="fas fa-save"></i> Save & Go
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-group row">
                <div class="col-sm-4 offset-md-3 col-xs-12">
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
    // Start SLUG = EDIT
    <?php if (isset($slug) && $slug == 'EDIT') : ?>
        renderview_subcode('<?php echo $selected['dtmitemRow']['dtmsubcode_id'];  ?>', '<?php echo $dtmitem_id; ?>', '<?php echo $slug; ?>');
        // renderview_techinf('<?php echo $selected['dtmitemRow']['dtmsubcode_id'];  ?>', '<?php echo $dtmitem_id; ?>', '<?php echo $slug; ?>');
        renderview_techinf_v2('<?php echo $selected['dtmitemRow']['dtmsubcode_id'];  ?>', '<?php echo $dtmitem_id; ?>', '<?php echo $slug; ?>');
        renderview_otherinf('<?php echo $selected['dtmitemRow']['dtmsubcode_id'];  ?>', '<?php echo $eis_item['item_id']; ?>', '<?php echo $dtmitem_id; ?>', '<?php echo $slug; ?>');
    <?php endif; ?>
    // End SLUG = EDIT


    // HARDCODING on Datatex0 is RAWMATERIAL
    render_subcode('iddtmsubcode_id1', 1, '<?php echo $selected['dtmsubcode_id']; ?>')

    // render_subcode('iddtmsubcode_id0', 0, '');

    // $('#iddtmsubcode_id0').on('select2:select', function(e) {
    //     var data = e.params.data;
    //     console.log(data);
    //     render_subcode('iddtmsubcode_id1', 1, data.id);
    // });

    $('#iddtmsubcode_id1').on('select2:select', function(e) {
        var data = e.params.data;
        let item_id = $('#iditem_id').val();
        renderview_subcode(data.id);
        // renderview_techinf(data.id);
        renderview_techinf_v2(data.id);
        renderview_otherinf(data.id, item_id);
    });

    function render_subcode(attributID, dtmsubcode_level, dtmsubcode_parent) {
        $("#" + attributID).select2({
            theme: 'bootstrap4',
            placeholder: '--Select Option--',
            minimumInputLength: 0,
            // allowClear: true,
            dropdownParent: $("#modal-lg .modal-content"),
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
                                text: item.dtmsubcode_code + ' | ' + item.dtmsubcode_name
                            };
                        })
                    };
                },
                cache: false
            }
        });
    }

    function renderview_subcode(dtmsubcode_id, dtmitem_id = '', slug = '') {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/form_subcode'; ?>',
            async: false,
            data: {
                dtmsubcode_id: dtmsubcode_id,
                dtmitem_id: dtmitem_id,
                slug: slug
            },
            success: function(html) {
                $('#idvwsubcode').html(html);
            }
        });
    }

    function renderview_techinf(dtmsubcode_id, dtmitem_id = '', slug = '') {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/form_techinf'; ?>',
            async: false,
            data: {
                dtmsubcode_id: dtmsubcode_id,
                dtmitem_id: dtmitem_id,
                slug: slug
            },
            success: function(html) {
                $('#idvwtechinf').html(html);
            }
        });
    }

    function renderview_techinf_v2(dtmsubcode_id, dtmitem_id = '', slug = '') {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/form_techinf_v2'; ?>',
            async: false,
            data: {
                dtmsubcode_id: dtmsubcode_id,
                dtmitem_id: dtmitem_id,
                slug: slug
            },
            success: function(html) {
                $('#idvwtechinf_v2').html(html);
            }
        });
    }

    function renderview_otherinf(dtmsubcode_id, item_id, dtmitem_id = '', slug = '') {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/form_otherinf'; ?>',
            async: false,
            data: {
                dtmsubcode_id: dtmsubcode_id,
                item_id: item_id,
                dtmitem_id: dtmitem_id,
                slug: slug
            },
            success: function(html) {
                $('#idvwotherinf').html(html);
            }
        });
    }

    function action_submit(form_id, slugGo = false) {
        event.preventDefault();
        var form = $('#' + form_id)[0];

        // Loading animate
        $('#idbtnSubmit' + form_id).html('<i class="fa fa-spinner fa-pulse"></i> Loading');
        $('#idbtnSubmit' + form_id).attr('disabled', true);

        // Start slug = EDIT
        // post data to Item controller
        <?php
        if (isset($slug) && $slug == 'EDIT') :
            $class_link = 'eis/item';
        endif; ?>
        // End slug = EDIT

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
                    // Go after submit
                    if (slugGo == true) {
                        setTimeout(function() {
                            window.location.assign("<?php echo base_url() ?>eis/item/parent_index?dtmitem_id="+data.data.dtmitem_id_base64);
                        }, 500);
                    }
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
                    toggle_modal_warning('Duplicate Item Subcode', data.warninghtml);
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
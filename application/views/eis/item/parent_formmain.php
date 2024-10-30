<?php
defined('BASEPATH') or exit('No direct script access allowed');

$form_id = 'idfromBulk';
$dataJS['class_link'] = $class_link;
$sizeDtmsubcode_id = null;

?>
<form id="<?php echo $form_id; ?>">
    <input type="hidden" name="dtmitem_id" value="<?php echo $dtmitem_id; ?>" placeholder="dtmitem_id">
    <div class="row">
        <div class="card-body table-responsive p-0">
            <table id="idTableBatch" class="table table-bordered table-striped table-hover" style="font-size: 85%;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>EISItemID</th>
                        <th>EISItemFullName</th>
                        <?php foreach ($itemParent['datatech_item_detail'] as $eParent0) :
                            $subcodeName = $eParent0['dtmsubcode_name'];
                        ?>
                            <th style="background-color: burlywood;">Subcode-<?php echo $eParent0['dtmsubcodedtl_seq'] . " ($subcodeName)"; ?></th>
                        <?php endforeach; ?>
                        <?php foreach ($itemParent['datatex_item_tech_information'] as $eParentTechInf0) : ?>
                            <th style="background-color: teal;">TechInf-<?php echo $eParentTechInf0['dtmsubcodetechinf_remark']; ?></th>
                        <?php endforeach; ?>
                        <th>UOM</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itemChilds['result'] as $e0) : ?>
                        <tr>
                            <td><input type="checkbox" name="dtscopeitem_ids[]" class="clCheckboxItem" value="<?php echo $e0['dtscopeitem_id']; ?>" checked="checked"></td>
                            <td><?php echo $e0['item_id'] ?></td>
                            <td><?php echo $e0['name'] ?></td>
                            <!-- SUBCODE -->
                            <?php foreach ($itemParent['datatech_item_detail'] as $eParent) : ?>
                                <?php
                                $html = '';
                                if ($eParent['dtmsubcodedtl_type'] == 'TEXT') {
                                    $html = '<input type="text" class="form-control form-control-xs commonInput" value="' . $eParent['dtmitemdtl_code'] . '">';
                                } else {
                                    switch (strtoupper($eParent['dtmsubcode_name'])) {
                                            // HACK SPECIAL CASE FOR SIZE
                                        case 'SIZE':
                                            $sizeDtmsubcode_id = $eParent['dtmsubcode_id'];
                                            $html =
                                                '<select name="hiesize_ids[' . $e0['dtscopeitem_id'] . ']" id="" class="form-control form-control-xs sizeClass sizeClassId' . $e0['dtscopeitem_id'] . '">
                                                    <option value="" selected="selected">' . $eParent['dtmitemdtl_code'] . ' | ' . $eParent['dtmsubcodehierarchy_name'] . '</option>
                                                </select>
                                                <button class="btn btn-xs btn-secondary" onclick="open_hierarchy(\'' . base64_encode($eParent['dtmsubcode_id']) . '\', \'' . urlencode($e0['spec_name']) . '\',\'' . $e0['dtscopeitem_id'] . '\')"><i class="fa fa-plus"></i></button>';
                                            break;
                                            // HACK SPECIAL CASE FOR COLOR
                                        case 'COLOR':
                                            $colorDtmsubcode_id = $eParent['dtmsubcode_id'];
                                            $html =
                                                '<select name="hiecolor_ids[' . $e0['dtscopeitem_id'] . ']" id="" class="form-control form-control-xs colorClass colorClassId' . $e0['dtscopeitem_id'] . '">
                                                    <option value="" selected="selected">' . $eParent['dtmitemdtl_code'] . ' | ' . $eParent['dtmsubcodehierarchy_name'] . '</option>
                                                </select>
                                                <button class="btn btn-xs btn-secondary" onclick="open_hierarchy_color(\'' . base64_encode($eParent['dtmsubcode_id']) . '\', \'' . urlencode($e0['color_name']) . '\',\'' . $e0['dtscopeitem_id'] . '\')"><i class="fa fa-plus"></i></button>';
                                            break;
                                        default:
                                            $html =
                                                '<select name="" id="" class="form-control form-control-xs commonInput">
                                                <option value="" selected="selected">' . $eParent['dtmitemdtl_code'] . ' | ' . $eParent['dtmsubcodehierarchy_name'] . '</option>
                                            </select>';
                                    }
                                }
                                ?>
                                <td>
                                    <?php echo $html; ?>
                                </td>
                            <?php endforeach; ?>
                            <!-- TECHNICAL INFORMATION -->
                            <?php foreach ($itemParent['datatex_item_tech_information'] as $eTechInf) : ?>
                                <?php
                                $html =
                                    '<select name="" id="" class="form-control form-control-xs commonInput">
                                    <option value="" selected="selected">' . $eTechInf['dtmsubcodetechinfhierarchy_id'] . ' | ' . $eTechInf['dtmitemtechinf_note'] . '</option>
                                </select>';
                                ?>
                                <td>
                                    <?php echo $html; ?>
                                </td>
                            <?php endforeach; ?>
                            <!-- OTHER INFORMATION -->
                            <td>
                                <select name="" id="" class="form-control form-control-xs commonInput">
                                    <option value="<?php echo $itemParent['datatech_item']['dtmitem_uom_id'] ?>" selected="selected"><?php echo $itemParent['datatech_item']['dtmitem_uom_id'] ?></option>
                                </select>
                            </td>
                            <td>
                                <textarea name="dtmitem_descriptions[<?php echo $e0['dtscopeitem_id']; ?>]" class="form-control form-control-xs" id="" rows="2"><?php echo $e0['name'] ?></textarea>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><input type="checkbox" id="checkAll" checked="checked"></td>
                        <th>EISItemID</th>
                        <th>EISItemFullName</th>
                        <?php foreach ($itemParent['datatech_item_detail'] as $eParent1) :
                            $subcodeName = $eParent1['dtmsubcode_name'];
                            $html = "Subcode-" . $eParent1['dtmsubcodedtl_seq'] . " ($subcodeName)";
                            switch (strtoupper($eParent1['dtmsubcode_name'])) {
                                case 'SIZE':
                                    $html = '<button class="btn -btn-xs btn-secondary" id="idbtnseachsize"> <i class="fa fa-search"></i> Search Size </button>';
                                    break;
                                case 'COLOR':
                                    $html = '<button class="btn -btn-xs btn-secondary" id="idbtnseachcolor"> <i class="fa fa-search"></i> Search Color </button>';
                                    break;
                            }
                        ?>
                            <th style="background-color: burlywood;"><?php echo $html; ?></th>
                        <?php endforeach; ?>
                        <?php foreach ($itemParent['datatex_item_tech_information'] as $eParentTechInf1) : ?>
                            <th style="background-color: teal;">TechInf-<?php echo $eParentTechInf1['dtmsubcodetechinf_remark']; ?></th>
                        <?php endforeach; ?>
                        <th>UOM</th>
                        <th>Description</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group row">
                <div class="col-sm-4 col-xs-12">
                    <button type="submit" name="btnSubmit" id="idbtnSubmit<?php echo $form_id; ?>" onclick="action_submit_batch_byparent('<?php echo $form_id; ?>')" class="btn btn-sm btn-info">
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    var tbl = $("#idTableBatch").removeAttr('width').DataTable({
        "paging": false,
        "searching": false,
        "scrollX": true,
        "scrollY": "300",
        "fixedColumns": {
            left: 3,
        },
        "columnDefs": [{
            targets: [0],
            width: 10
        }, {
            targets: '_all',
            width: 150
        }],
    });

    $('.commonInput').prop("disabled", true);

    $(document).off('click', '#checkAll').on('click', '#checkAll', function() {
        $('.clCheckboxItem').prop('checked', this.checked);
    });

    // Search size
    $(document).off('click', '#idbtnseachsize').on('click', '#idbtnseachsize', function() {
        event.preventDefault();
        generateSearchSize();
    });

    // Search color
    $(document).off('click', '#idbtnseachcolor').on('click', '#idbtnseachcolor', function() {
        event.preventDefault();
        generateSearchColor();
    });

    // init execute;
    generateSearchSize();

    function generateSearchSize() {
        $('.preloader-custom').fadeIn('xfast');

        let dtscopeitem_ids = [];
        $('.clCheckboxItem:checkbox:checked').each(function() {
            var sThisVal = (this.checked ? $(this).val() : "");
            dtscopeitem_ids.push(sThisVal);
        });
        // Reset selected
        $(".sizeClass").empty().trigger('change')

        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/generate_suggestion_size'; ?>',
            async: false,
            data: {
                dtscopeitem_ids: JSON.stringify(dtscopeitem_ids),
                dtmitem_id: '<?php echo $dtmitem_id; ?>'
            },
            success: function(data) {
                if (data.code == 200) {
                    toastAlert('success', data.messages);

                    $.each(data.data, function(index, value) {
                        let selectedOption = $("<option selected='selected'></option>").val(value.dtmsubcodehierarchy_id).text(value.dtmsubcodehierarchy_code + ' | ' + value.dtmsubcodehierarchy_name);

                        $('.sizeClassId' + value.dtscopeitem_id).append(selectedOption).trigger('change');
                    });
                } else {
                    toastAlert('error', data.messages);
                }
            },
            complete: function() {
                $('.preloader-custom').fadeOut('xfast');
            }
        });
    }

    //init execute
    generateSearchColor();

    function generateSearchColor() {
        $('.preloader-custom').fadeIn('xfast');

        let dtscopeitem_ids = [];
        $('.clCheckboxItem:checkbox:checked').each(function() {
            var sThisVal = (this.checked ? $(this).val() : "");
            dtscopeitem_ids.push(sThisVal);
        });
        // Reset selected
        $(".colorClass").empty().trigger('change')

        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/generate_suggestion_color'; ?>',
            async: false,
            data: {
                dtscopeitem_ids: JSON.stringify(dtscopeitem_ids),
                dtmitem_id: '<?php echo $dtmitem_id; ?>'
            },
            success: function(data) {
                if (data.code == 200) {
                    toastAlert('success', data.messages);

                    $.each(data.data, function(index, value) {
                        let selectedOption = $("<option selected='selected'></option>").val(value.dtmsubcodehierarchy_id).text(value.dtmsubcodehierarchy_code + ' | ' + value.dtmsubcodehierarchy_name);

                        $('.colorClassId' + value.dtscopeitem_id).append(selectedOption).trigger('change');
                    });
                } else {
                    toastAlert('error', data.messages);
                }
            },
            complete: function() {
                $('.preloader-custom').fadeOut('xfast');
            }
        });
    }

    // Render select2 only for size
    render_subcode_hierarchy('sizeClass', '<?php echo $sizeDtmsubcode_id; ?>', '');
    render_subcode_hierarchy('colorClass', '<?php echo $colorDtmsubcode_id; ?>', '');

    function render_subcode_hierarchy(attributID, dtmsubcode_id, dtmsubcodehierarchy_parent) {
        $("." + attributID).select2({
            theme: 'bootstrap4',
            placeholder: '--Select Option--',
            minimumInputLength: 0,
            allowClear: true,
            ajax: {
                url: '<?php echo base_url(); ?>/eis/datatech_itemcodification/autocomplete_subcode_hierarchy?dtmsubcode_id=' + dtmsubcode_id + '&dtmsubcodehierarchy_parent=' + dtmsubcodehierarchy_parent,
                type: "get",
                dataType: 'json',
                delay: 250,
                async: false,
                data: function(params) {
                    return {
                        param_search: params.term,
                    };
                },
                processResults: function(response) {
                    return {
                        results: $.map(response, function(item) {
                            return {
                                id: item.dtmsubcodehierarchy_id,
                                text: item.dtmsubcodehierarchy_code + ' | ' + item.dtmsubcodehierarchy_name + ` (${item.dtmsubcodehierarchy_state})`,
                                dtmsubcodehierarchy_code: item.dtmsubcodehierarchy_code
                            };
                        })
                    };
                },
                cache: false
            }
        });
    }

    function open_hierarchy(dtmsubcode_id, dtmsubcodehierarchy_name, dtscopeitem_id) {
        event.preventDefault();
        // Check if already have size hierarchy
        let hierarchySizeId = $('.sizeClassId' + dtscopeitem_id).find(':selected').val();
        if (hierarchySizeId == '' || hierarchySizeId == null) {
            window.open('<?php echo base_url() . 'eis/datatech_itemcodification/subcode_hierarchy?id=' ?>' + dtmsubcode_id + '&slug=EXTENDVIEW&dtmsubcodehierarchy_name=' + dtmsubcodehierarchy_name);
        } else {
            toastAlert('error', 'Size already exist for this line');
        }
    }

    function open_hierarchy_color(dtmsubcode_id, dtmsubcodehierarchy_name, dtscopeitem_id) {
        event.preventDefault();
        // Check if already have size hierarchy
        let hierarchySizeId = $('.colorClassId' + dtscopeitem_id).find(':selected').val();
        if (hierarchySizeId == '' || hierarchySizeId == null) {
            window.open('<?php echo base_url() . 'eis/datatech_itemcodification/subcode_hierarchy?id=' ?>' + dtmsubcode_id + '&slug=EXTENDVIEW&dtmsubcodehierarchy_name=' + dtmsubcodehierarchy_name);
        } else {
            toastAlert('error', 'Color already exist for this line');
        }
    }

    function action_submit_batch_byparent(form_id) {
        event.preventDefault();
        var conf = confirm('Are you sure ?');
        if (conf) {
            var form = $('#' + form_id)[0];

            // Loading animate
            $('#idbtnSubmit' + form_id).html('<i class="fa fa-spinner fa-pulse"></i> Loading');
            $('#idbtnSubmit' + form_id).attr('disabled', true);
            $.ajax({
                url: '<?php echo base_url() . $class_link . '/action_submit_batch_byparent' ?>',
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    if (data.code == 200) {
                        window.location.reload();
                        toastAlert('success', data.messages);
                    } else if (data.code == 400) {
                        toastAlert('error', data.messages);
                    } else {
                        toastAlert('error', 'Unknown Error');
                    }
                },
                complete: function(dt) {
                    // Loading animate
                    $('#idbtnSubmit' + form_id).html('<i class="fa fa-save"></i> Save');
                    $('#idbtnSubmit' + form_id).attr('disabled', false);
                }
            });
        }
    }
</script>
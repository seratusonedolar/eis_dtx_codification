<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idForm';
// Start Slug = EDIT
$arraySelected = array();
if (isset($slug) && $slug == 'EDIT') {
    foreach ($selected as $eSelected) {
        $arraySelected[$eSelected['dtmsubcodetechinf_id']] = $eSelected;
    }
}
// End Slug = EDIT
?>

<div class="row">
<div class="col-md-12">
    <h6><strong><u>Technical Information:</u></strong></h6>
    <?php foreach ($result as $r) :
        $optionName = "subcodetechinfhierarchy_{$r['dtmsubcodetechinf_id']}";
        $optionID = "idtechinfseq{$r['dtmsubcodetechinf_id']}";
        $hideButton = in_array($r['dtmsubcodetechinf_id'], [35, 36, 37, 38, 39, 40, 7, 12, 11, 14, 19]);
    ?>
        <div class="form-group row">
            <label for="iddtmsubcode_id" class="col-md-2 col-form-label text-right"><?php echo $r['dtmsubcodetechinf_seq'] . " ({$r['dtmsubcodetechinf_remark']})"; ?></label>
            <div class="col-sm-9 col-xs-12">
                <input type="hidden" name="dtmsubcodetechinf_ids[]" value="<?php echo $r['dtmsubcodetechinf_id']; ?>">
                <select name="<?php echo $optionName; ?>" id="<?php echo $optionID; ?>" class="form-control form-control-sm">
                    <?php if (!empty($arraySelected)) : ?>
                        <option value="<?php echo isset($arraySelected[$r['dtmsubcodetechinf_id']]['dtmsubcodetechinfhierarchy_id']) ? $arraySelected[$r['dtmsubcodetechinf_id']]['dtmsubcodetechinfhierarchy_id'] : null; ?>" selected="selected"> <?php echo isset($arraySelected[$r['dtmsubcodetechinf_id']]['dtmsubcodetechinfhierarchy_code']) ? "{$arraySelected[$r['dtmsubcodetechinf_id']]['dtmsubcodetechinfhierarchy_code']} | {$arraySelected[$r['dtmsubcodetechinf_id']]['dtmsubcodetechinfhierarchy_name']}" : null; ?></option>
                    <?php endif; ?>
                </select>
                <textarea name="dtmsubcodetechinf_remark_<?php echo $r['dtmsubcodetechinf_id']; ?>" class="form-control form-control-sm" id="idtechinfseq<?php echo $r['dtmsubcodetechinf_id']; ?>remark" cols="30" rows="2" placeholder="<?php echo $r['dtmsubcodetechinf_remark']; ?>" readonly><?php echo isset($arraySelected[$r['dtmsubcodetechinf_id']]['dtmitemtechinf_note']) ? $arraySelected[$r['dtmsubcodetechinf_id']]['dtmitemtechinf_note'] : null; ?></textarea>
            </div>
            <?php if (!$hideButton) : ?>
                <div class="input-group-append">
                    <button class="btn btn-xs btn-default" title="Add" onclick="event.preventDefault(); window.open('<?php echo base_url() . 'eis/datatech_itemcodification/subcode_techinf?id=' . base64_encode($r['dtmsubcodetechinf_id']); ?>')"> <i class="fa fa-plus"></i> </button>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

</div>

<script type="text/javascript">
    <?php
    foreach ($result as $r1) :
            $optionID ="idtechinfseq{$r1['dtmsubcodetechinf_id']}";
    ?>
            render_techinf_hierarchy('<?php echo $optionID; ?>', '<?php echo $r1['dtmsubcodetechinf_id']; ?>');

            $('#<?php echo $optionID; ?>').on('select2:select', function(e) {
                var data = e.params.data;
                console.log(data);
                $('#<?php echo $optionID; ?>remark').val(data.dtmsubcodetechinfhierarchy_name);
            });

            $('#<?php echo $optionID; ?>').on('select2:unselecting', function(e) {
                $('#<?php echo $optionID; ?>remark').val('');
            });

    <?php
    endforeach;
    ?>

    function render_techinf_hierarchy(attributID, dtmsubcodetechinf_id) {
        $("#" + attributID).select2({
            theme: 'bootstrap4',
            placeholder: '--Select Option--',
            minimumInputLength: 0,
            dropdownParent: $("#modal-lg .modal-content"),
            allowClear: true,
            ajax: {
                url: '<?php echo base_url(); ?>eis/item/autocomplete_techinf_hierarchy?dtmsubcodetechinf_id=' + dtmsubcodetechinf_id,
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
                            console.log(item);
                            return {
                                id: item.dtmsubcodetechinfhierarchy_id,
                                text: item.dtmsubcodetechinfhierarchy_code + ' | ' + item.dtmsubcodetechinfhierarchy_name,
                                dtmsubcodetechinfhierarchy_name: item.dtmsubcodetechinfhierarchy_name
                            };
                        })
                    };
                },
                cache: false
            }
        });
    }
</script>

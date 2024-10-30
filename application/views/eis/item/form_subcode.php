<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idForm';
// Start Slug = EDIT
$arraySelected = array();
if (isset($slug) && $slug == 'EDIT') {
    foreach ($selected as $eSelected) {
        $arraySelected[$eSelected['dtmsubcodedtl_seq']][$eSelected['dtmsubcodedtl_type']] = $eSelected;
    }
}
// End Slug = EDIT
?>

<div class="row">
    <div class="col-md-12">
        <h6> <strong> <u> Subcode : </u></strong></h6>
        <button class="btn btn-xs btn-secondary" onclick="generate_suggestion_subcode('idbtnsuggestion')" id="idbtnsuggestion"> <i class="fa fa-recycle"></i> Suggestion</button>
        <br>
        <?php foreach ($result as $r) :
            $optionName = "seq{$r['dtmsubcodedtl_seq']}";
            $optionID = "idseq{$r['dtmsubcodedtl_seq']}";
            if ($r['dtmsubcodedtl_type'] == 'OPTION') :
        ?>
                <div class="form-group row">
                    <label for="iddtmsubcode_id" class="col-md-2 col-form-label text-right"><?php echo $r['dtmsubcodedtl_seq'] . " ({$r['dtmsubcode_name']})"; ?></label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="hidden" id="<?php echo $optionID; ?>code" placeholder="<?php echo $optionID; ?>code" name="<?php echo $optionName; ?>code" value="<?php echo !empty($arraySelected) && isset($arraySelected[$r['dtmsubcodedtl_seq']][$r['dtmsubcodedtl_type']]['dtmitemdtl_code']) ? $arraySelected[$r['dtmsubcodedtl_seq']][$r['dtmsubcodedtl_type']]['dtmitemdtl_code'] : null; ?>">
                        <select name="<?php echo $optionName; ?>" id="<?php echo $optionID; ?>" class="form-control form-control-sm">
                            <?php if (!empty($arraySelected)) : ?>
                                <option value="<?php echo isset($arraySelected[$r['dtmsubcodedtl_seq']][$r['dtmsubcodedtl_type']]['dtmsubcodehierarchy_id']) ? $arraySelected[$r['dtmsubcodedtl_seq']][$r['dtmsubcodedtl_type']]['dtmsubcodehierarchy_id'] : null;  ?>" selected="selected"> <?php echo isset($arraySelected[$r['dtmsubcodedtl_seq']][$r['dtmsubcodedtl_type']]['dtmsubcodehierarchy_code']) ? "{$arraySelected[$r['dtmsubcodedtl_seq']][$r['dtmsubcodedtl_type']]['dtmsubcodehierarchy_code']} | {$arraySelected[$r['dtmsubcodedtl_seq']][$r['dtmsubcodedtl_type']]['dtmsubcodehierarchy_name']}" : null; ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="input-group-append">
                        <!-- Check main category read permission -->
                        <!-- <?php if (strpos(strtoupper($r['dtmsubcode_name']), 'MAIN CATEGORY') !== false) : ?>
                            <?php if (checkPermission('MASTERITEM.CODIFICATION.SUBCODEHIERARCHY.ALL.MAIN_CATEGORY.READ')) : ?>
                                <button class="btn btn-xs btn-default" title="Add" onclick="event.preventDefault(); window.open('<?php echo base_url() . 'eis/datatech_itemcodification/subcode_hierarchy?id=' . base64_encode($r['dtmsubcode_option_id']); ?>')"> <i class="fa fa-plus"></i> </button>
                            <?php endif; ?>
                        <?php else : ?>
                            <button class="btn btn-xs btn-default" title="Add" onclick="event.preventDefault(); window.open('<?php echo base_url() . 'eis/datatech_itemcodification/subcode_hierarchy?id=' . base64_encode($r['dtmsubcode_option_id']); ?>')"> <i class="fa fa-plus"></i> </button>
                        <?php endif; ?> -->
                    </div>
                    <div style="color: blue;" id="idscores<?php echo $r['dtmsubcodedtl_seq']; ?>"></div>
                </div>
            <?php else :
            ?>
                <div class="form-group row">
                    <label for="idq_id" class="col-md-2 col-form-label text-right"><?php echo $r['dtmsubcodedtl_seq'] . " ({$r['dtmsubcodedtl_remark']})"; ?></label>
                    <div class="col-sm-9 col-xs-12">
                        <input name="<?php echo $optionName; ?>code" type="text" class="form-control form-control-sm" placeholder="<?php echo $r['dtmsubcodedtl_remark']; ?>" maxlength="20" value="<?php echo !empty($arraySelected) && isset($arraySelected[$r['dtmsubcodedtl_seq']][$r['dtmsubcodedtl_type']]['dtmitemdtl_code']) ? $arraySelected[$r['dtmsubcodedtl_seq']][$r['dtmsubcodedtl_type']]['dtmitemdtl_code'] : null; ?>">
                    </div>
                </div>
        <?php
            endif;
        endforeach; ?>
    </div>
</div>

<script type="text/javascript">
    <?php
    foreach ($result as $r1) :
        if ($r1['dtmsubcodedtl_type'] == 'OPTION') :
            $optionID = "idseq{$r1['dtmsubcodedtl_seq']}";
    ?>
            render_subcode_hierarchy('<?php echo $optionID; ?>', '<?php echo $r1['dtmsubcode_option_id']; ?>', '');

            $('#<?php echo $optionID; ?>').on('select2:select', function(e) {
                var data = e.params.data;
                $('#<?php echo $optionID; ?>code').val(data.dtmsubcodehierarchy_code);
            });
    <?php
        endif;
    endforeach;
    ?>

    function render_subcode_hierarchy(attributID, dtmsubcode_id, dtmsubcodehierarchy_parent) {
        $("#" + attributID).select2({
            theme: 'bootstrap4',
            placeholder: '--Select Option--',
            minimumInputLength: 0,
            // allowClear: true,
            dropdownParent: $("#modal-lg .modal-content"),
            ajax: {
                url: '<?php echo base_url(); ?>/eis/datatech_itemcodification/autocomplete_subcode_hierarchy?dtmsubcode_id=' + dtmsubcode_id + '&dtmsubcodehierarchy_parent=' + dtmsubcodehierarchy_parent,
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

    function generate_suggestion_subcode(buttonId) {
        event.preventDefault();
        let item_id = $('#iditem_id').val();
        let dtmsubcode_id = $('#iddtmsubcode_id1').val();

        // Loading animate
        $('#' + buttonId).html('<i class="fa fa-spinner fa-pulse"></i> Loading');
        $('#' + buttonId).attr('disabled', true);
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/generate_suggestion_subcode'; ?>',
            data: {
                item_id: item_id,
                dtmsubcode_id: dtmsubcode_id
            },
            success: function(data) {
                console.log(data);
                if (data.code == 200) {
                    $.each(data.data, function(index, value) {
                        let selectedOption = $("<option selected='selected'></option>").val(value.fuzzresult_id).text(value.fuzzresult_text_select2);

                        $('#idseq' + value.dtmsubcodedtl_seq + 'code').val(value.fuzzresult_code);
                        $('#idseq' + value.dtmsubcodedtl_seq).append(selectedOption).trigger('change');
                        $('#idscores' + value.dtmsubcodedtl_seq).text(value.fuzzresult_score);
                    });
                } else {
                    toastAlert('error', data.messages);
                }
            },
            complete: function() {
                // Loading animate
                $('#' + buttonId).html('<i class="fa fa-recycle"></i> Suggestion');
                $('#' + buttonId).attr('disabled', false);
            }
        });
    }
</script>


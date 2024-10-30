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
          <?php foreach ($result as $r) :
            $optionName = "seq{$r['dtmsubcodedtl_seq']}";
            $optionID = "idseq{$r['dtmsubcodedtl_seq']}";
            if ($r['dtmsubcodedtl_type'] == 'OPTION') :
        ?>
                <div class="form-group row">
                    <label for="iddtmsubcode_id" class="col-md-2 col-form-label text-right"><?php echo $r['dtmsubcodedtl_seq'] . " ({$r['dtmsubcode_name']})"; ?></label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="hidden" id="<?php echo $optionID; ?>code" placeholder="<?php echo $optionID; ?>code" name="<?php echo $optionName; ?>code" value="<?php echo !empty($arraySelected) && isset($arraySelected[$r['dtmsubcodedtl_seq']][$r['dtmsubcodedtl_type']]['dtmitemdtl_code']) ? $arraySelected[$r['dtmsubcodedtl_seq']][$r['dtmsubcodedtl_type']]['dtmitemdtl_code'] : null; ?>">
                        <select name="<?php echo $optionName; ?>" id="<?php echo $optionID; ?>" data-seq="<?php echo $r['dtmsubcodedtl_seq']; ?>" class="form-control form-control-sm select2clear">
                            <?php if (!empty($arraySelected)) : ?>
                                <option value="<?php echo isset($arraySelected[$r['dtmsubcodedtl_seq']][$r['dtmsubcodedtl_type']]['dtmsubcodehierarchy_id']) ? $arraySelected[$r['dtmsubcodedtl_seq']][$r['dtmsubcodedtl_type']]['dtmsubcodehierarchy_id'] : null;  ?>" selected="selected"> <?php echo isset($arraySelected[$r['dtmsubcodedtl_seq']][$r['dtmsubcodedtl_type']]['dtmsubcodehierarchy_code']) ? "{$arraySelected[$r['dtmsubcodedtl_seq']][$r['dtmsubcodedtl_type']]['dtmsubcodehierarchy_code']} | {$arraySelected[$r['dtmsubcodedtl_seq']][$r['dtmsubcodedtl_type']]['dtmsubcodehierarchy_name']}" : null; ?></option>
                            <?php endif; ?>
                        </select>
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

	$('.select2clear').on('select2:clear', function(e) {
		let seq = $(this).attr("data-seq");
		$('#idseq'+seq+'code').val("");
    });	

    function render_subcode_hierarchy(attributID, dtmsubcode_id, dtmsubcodehierarchy_parent) {
        $("#" + attributID).select2({
            theme: 'bootstrap4',
            placeholder: '--Select Option--',
            minimumInputLength: 0,
            allowClear: true,
            // dropdownParent: $("#modal-lg .modal-content"),
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

</script>

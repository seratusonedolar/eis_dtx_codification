<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idForm';
?>

<div class="row">
    <div class="col-md-12">

        <?php foreach ($result as $r) :
            $optionName = "seq{$r['dtmsubcodedtl_seq']}";
            $optionID = "idseq{$r['dtmsubcodedtl_seq']}";
            if ($r['dtmsubcodedtl_type'] == 'OPTION') :
        ?>
                <div class="form-group row">
                    <label for="iddtmsubcode_id" class="col-md-3 col-form-label">Subcode<?php echo $r['dtmsubcodedtl_seq'] . "({$r['dtmsubcode_name']})"; ?></label>
                    <div class="col-sm-8 col-xs-12">
                        <input type="hidden" id="<?php echo $optionID; ?>code" placeholder="<?php echo $optionID; ?>code" name="<?php echo $optionName; ?>code">
                        <select name="<?php echo $optionName; ?>" id="<?php echo $optionID; ?>" class="form-control form-control-sm">
                            <?php if (!empty($row['company_id'])) : ?>
                                <option value="<?php echo $row['company_id'];  ?>" selected="selected"> <?php echo "{$row['company_id']} | {$row['name']}" ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            <?php else :
            ?>
                <div class="form-group row">
                    <label for="idq_id" class="col-md-3 col-form-label">Subcode<?php echo $r['dtmsubcodedtl_seq'] . "({$r['dtmsubcodedtl_remark']})"; ?></label>
                    <div class="col-sm-8 col-xs-12">
                        <input name="<?php echo $optionName; ?>code" type="text" class="form-control form-control-sm" placeholder="<?php echo $r['dtmsubcodedtl_remark']; ?>" maxlength="10">
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
                                text: item.dtmsubcodehierarchy_code + ' | ' + item.dtmsubcodehierarchy_name,
                                dtmsubcodehierarchy_code: item.dtmsubcodehierarchy_code
                            };
                        })
                    };
                },
                cache: true
            }
        });
    }
</script>
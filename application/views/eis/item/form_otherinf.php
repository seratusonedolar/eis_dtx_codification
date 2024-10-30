<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idForm';
?>

<div class="row">
    <div class="col-md-12">
        <h6> <strong> <u> Other Information : </u></strong></h6>

        <div class="form-group row">
            <label for="idselect" class="col-md-2 col-form-label text-right">Primary UOM</label>
            <div class="col-sm-9 col-xs-12">
                <select name="dtmitem_uom_id" class="form-control form-control-sm select2" id="iddtmitem_uom_id">
                    <?php if (isset($row['um_id'])) : ?>
                        <option value="<?php echo $row['um_id']; ?>" selected><?php echo $row['um_id'] . ' | ' . $row['um_name']; ?></option>
                    <?php endif; ?>
                </select>
            </div>
        </div>

         <div class="form-group row">
            <label for="iddtmitem_description" class="col-md-2 col-form-label text-right">Item Description</label>
            <div class="col-sm-9 col-xs-12">
                <div class="input-group">
					<textarea name="dtmitem_description" id="iddtmitem_description" class="form-control form-control-sm" rows="2" placeholder="Item Description Max 200 Karakter" maxlength="200"><?php echo isset($row['dtmitem_description']) ? $row['dtmitem_description']: null; ?></textarea>
					<p id="wordCountMessage" style="color:red;"></p>
			    </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    render_uom('iddtmitem_uom_id');

    function render_uom(attributID) {
        $("#" + attributID).select2({
            theme: 'bootstrap4',
            placeholder: '--Select Option--',
            minimumInputLength: 0,
            // allowClear: true,
            dropdownParent: $("#modal-lg .modal-content"),
            ajax: {
                url: '<?php echo base_url() . $class_link; ?>/autocomplete_uom',
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
                                id: item.um_id,
                                text: item.um_text
                            };
                        })
                    };
                },
                cache: false
            }
        });
    }
</script>

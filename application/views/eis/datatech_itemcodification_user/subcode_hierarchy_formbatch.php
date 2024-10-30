<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idFormHierarchyBatch';
?>
<form id="<?php echo $form_id; ?>" class="form-horizontal">
    <input type="hidden" name="slug" value="<?php echo isset($slug) ? $slug : null; ?>">
    <input type="hidden" name="dtmsubcode_id" value="<?php echo isset($dtmsubcode_id) ? $dtmsubcode_id : null; ?>">

    <p> <i>
            <strong>Example (split with semicolon ; ) :</strong> <br>
            BASKT;Basket <br>
            BONDD;Bonded <br>
            ...
        </i> </p>

    <div class="form-group row">
        <label for="idbatchdata" class="col-md-2 col-form-label">Batch Hierarchy</label>
        <div class="col-sm-10 col-xs-12">
            <div class="input-group">
                <textarea name="batchdata" id="idbatchdata" class="form-control form-control-sm" rows="7" placeholder="Batch Hierarchy"><?php echo isset($keterangan) ? $keterangan : null; ?></textarea>
            </div>
        </div>
    </div>

    <hr>

    <button type="submit" name="btnSubmit" id="idbtnSubmit<?php echo $form_id; ?>" onclick="action_submit_hierarchy_batch('<?php echo $form_id; ?>')" class="btn btn-sm btn-info">
        <i class="fas fa-save"></i> Save
    </button>
    <button onclick="event.preventDefault();window.location.reload()" class="btn btn-sm btn-default">
        <i class="fa fa-refresh"></i> Reset
    </button>
</form>
<script type="text/javascript">
    function action_submit_hierarchy_batch(form_id) {
        event.preventDefault();
        var form = $('#' + form_id)[0];

        // Loading animate
        $('#idbtnSubmit' + form_id).html('<i class="fa fa-spinner fa-pulse"></i> Loading');
        $('#idbtnSubmit' + form_id).attr('disabled', true);

        $.ajax({
            url: '<?php echo base_url() . $class_link . '/action_submit_hierarchy_batch' ?>',
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
                    toastAlert('success', data.messages);
                    toggle_modal('', '');
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
</script>
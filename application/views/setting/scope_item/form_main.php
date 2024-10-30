<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idForm';
?>
<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-info"></i> Info!</h5>
    Select monthly periode already clossing.
</div>
<form id="<?php echo $form_id; ?>" class="form-horizontal">
    <input type="hidden" name="txtitem_id" id="iditem_id" placeholder="iditem_id" value="<?php echo isset($eis_item['item_id']) ? $eis_item['item_id'] : null; ?>">

    <div class="row">
        <div class="col-md-12">

            <div class="form-group row">
                <label for="idmonth" class="col-md-2 col-form-label">Month</label>
                <div class="col-sm-8 col-xs-12">
                    <select name="month" id="idmonth" class="form-control form-control-sm clperiode">
                        <option value="01"> Jan</option>
                        <option value="02"> Feb</option>
                        <option value="03"> Mar</option>
                        <option value="04"> Apr</option>
                        <option value="05"> May</option>
                        <option value="06"> Jun</option>
                        <option value="07"> Jul</option>
                        <option value="08"> Aug</option>
                        <option value="09"> Sep</option>
                        <option value="10"> Okt</option>
                        <option value="11"> Nop</option>
                        <option value="12"> Desx</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="idyear" class="col-md-2 col-form-label">Year</label>
                <div class="col-sm-8 col-xs-12">
                    <select name="year" id="idyear" class="form-control form-control-sm clperiode">
                        <option value="23"> 2023 </option>
                        <option value="24"> 2024 </option>
                        <option value="25"> 2025 </option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="idperiodecode" class="col-md-2 col-form-label">PeriodeCode</label>
                <div class="col-sm-2 col-xs-12">
                    <div class="input-group">
                        <input name="periodecode" id="idperiodecode" type="text" class="form-control form-control-sm" value="<?php echo $month . $year ?>" placeholder="PeriodeCode" readonly="readonly">
                    </div>
                </div>
                PARENT : 
                <label for="idperiodecode" id="idcount" class="col-md-2 col-form-label" style="color: red; font-size: 120%;">-</label>
                CHILD : 
                <label for="idperiodecode" id="idcountchild" class="col-md-2 col-form-label" style="color: blue; font-size: 120%;">-</label>
            </div>

            <hr>

            <div id="idvwsubcode"></div>

            <div class="form-group row">
                <div class="col-sm-4 offset-md-2 col-xs-12">
                    <button type="submit" name="btnSubmit" id="idbtncheck" onclick="action_checkoutstandingitemclossing()" class="btn btn-sm btn-info">
                        <i class="fas fa-check"></i> Check
                    </button>
                    <button type="reset" name="btnReset" id="idsubmit" onclick="action_submitoutstandingitemclossing()" class="btn btn-sm btn-warning">
                        <i class="fas fa-save"></i> Submit
                    </button>
                </div>
            </div>

        </div>
    </div>

</form>

<script type="text/javascript">
    $('#idmonth').val('<?php echo $month; ?>');
    $('#idyear').val('<?php echo $year; ?>');

    $('.clperiode').on('change', function(e) {
        let periodecode = $('#idmonth').val() + $('#idyear').val();
        $('#idperiodecode').val(periodecode);
    });

    function action_checkoutstandingitemclossing() {
        event.preventDefault();
        // Loading animate
        $('#idbtncheck').html('<i class="fa fa-spinner fa-pulse"></i> Loading');
        $('#idbtncheck').attr('disabled', true);

        $.ajax({
            url: '<?php echo base_url() . $class_link . '/action_getoutstandingitemsclossing' ?>',
            type: "GET",
            data: {
                periodecode: $('#idperiodecode').val()
            },
            success: function(data) {
                $('#idcount').text(data.messages.periodecode_count);
                $('#idcountchild').text(data.messages.perodecodechild_count);
            },
            complete: function() {
                // Loading animate
                $('#idbtncheck').html('<i class="fas fa-check"></i> Check');
                $('#idbtncheck').attr('disabled', false);
            }
        });
    }

    function action_submitoutstandingitemclossing() {
        event.preventDefault();
        // Loading animate
        $('#idsubmit').html('<i class="fa fa-spinner fa-pulse"></i> Loading');
        $('#idsubmit').attr('disabled', true);

        $.ajax({
            url: '<?php echo base_url() . $class_link . '/action_submitoutstandingitemclossing' ?>',
            type: "POST",
            data: {
                periodecode: $('#idperiodecode').val()
            },
            success: function(data) {
                if (data.code == 200) {
                    toastAlert('success', data.messages);
                    reload_table();
                    toggle_modal('', '');
                } else {
                    toastAlert('error', data.messages);
                }
            },
            complete: function() {
                // Loading animate
                $('#idsubmit').html('<i class="fas fa-save"></i> Save');
                $('#idsubmit').attr('disabled', false);
            }
        });
    }
</script>
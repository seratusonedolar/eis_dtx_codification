<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idFormUser';
?>

<form id="<?php echo $form_id; ?>" class="form-horizontal">
    <input type="hidden" name="dtmrole_id" value="<?php echo isset($dtmrole_id) ? $dtmrole_id : null; ?>">

    <div class="row">
        <div class="col-md-12">

            <div class="form-group row">
                <label for="iduser" class="col-md-2 col-form-label">User</label>
                <div class="col-sm-8 col-xs-12">
                    <select name="user_id" id="iduser" class="form-control form-control-sm">
                    </select>
                </div>
            </div>

            <hr>

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
    render_subcode('iduser');

    function render_subcode(attributID) {
        $("#" + attributID).select2({
            theme: 'bootstrap4',
            placeholder: '--Select Option--',
            minimumInputLength: 3,
            // allowClear: true,
            ajax: {
                url: '<?php echo base_url() . $class_link; ?>/autocomplete_user',
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
                                id: item.user_id,
                                text: item.username + ' (' + item.auth_email + ')'
                            };
                        })
                    };
                },
                cache: true
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
            url: '<?php echo base_url() . $class_link . '/action_submit_user' ?>',
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
                    user_form('<?php echo $dtmrole_id; ?>');
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
            error: function(jqXHR){
                toastAlert('error', jqXHR.statusText);
            },
            complete: function(dt) {
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
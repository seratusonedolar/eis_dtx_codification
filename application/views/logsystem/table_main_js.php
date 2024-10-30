<script type="text/javascript">
    viewData('<?php echo date('Y-m-d'); ?>');

    $('#reservationdate').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    function getLogDate() {
        $('.preloader-custom').fadeIn('xfast');
        var logDate = $('#idlogdate').val();
        return logDate;
    }

    function viewData(logdate) {
        if (logdate == null){
            logdate = getLogDate();
        }
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/action_view_log'; ?>',
            data: {
                logdate: logdate
            },
            success: function(html) {
                $('.preloader-custom').fadeOut('xfast');
                $('#idtextlog').text(html);
            }
        });
    }

    function toggle_modal(modalTitle, htmlContent) {
        $('#modal-lg').modal('toggle');
        $('.modal-title').text(modalTitle);
        $('#idmodalbody').html(htmlContent);
    }

    $('#idmodal-loader').modal('toggle');

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
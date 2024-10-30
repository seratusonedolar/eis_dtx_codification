<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BRIDGING PLM | Lockscreen</title>

    <link rel="shortcut icon" href='<?php echo getenv('RESOURCE_BASE_URL'); ?>/dist/img/favicon_ertx.ico'>
    <link rel="stylesheet" href="<?php echo getenv('RESOURCE_BASE_URL'); ?>/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo getenv('RESOURCE_BASE_URL'); ?>/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo getenv('RESOURCE_BASE_URL'); ?>/plugins/toastr/toastr.min.css">

</head>

<body class="hold-transition lockscreen">

    <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
            <h2><?php echo getenv('APP_NAME') ?></h2>
        </div>

        <div class="lockscreen-name">Administrator</div>

        <div class="lockscreen-item">

            <div class="lockscreen-image">
                <img src="<?php echo getenv('RESOURCE_BASE_URL'); ?>/dist/img/user.png" alt="User Image">
            </div>


            <form id="idform" class="lockscreen-credentials">
                <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <button type="submit" id="idbtnsubmit" class="btn">
                            <i class="fas fa-arrow-right text-muted"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="lockscreen-footer text-center">
            <strong>Copyright &copy; 2022-<?php echo date('Y'); ?> <small>AdminLTE.io</small>
        </div>
    </div>

    <script src="<?php echo getenv('RESOURCE_BASE_URL'); ?>/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo getenv('RESOURCE_BASE_URL'); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getenv('RESOURCE_BASE_URL'); ?>/plugins/toastr/toastr.min.js"></script>

    <script type="text/javascript">
        $('#idbtnsubmit').click(function(e){
            e.preventDefault();
            submitData('idform');
        });

        function submitData(form_id) {
            var form = $('#' + form_id)[0];

            $.ajax({
                url: '<?php echo getenv('BASE_URL') . 'lockscreen/auth' ?>',
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    if (data.code == 200) {
                        $('.errInput').html('');
                        toastAlert('success', data.messages);
                        window.location.assign('<?php echo getenv('BASE_URL'); ?>');
                    } else if (data.code == 400) {
                        toastAlert('error', data.messages);
                        generateToken(data._token);
                    } else {
                        toastAlert('error', 'Unknown Error');
                        generateToken(data._token);
                    }
                }
            });
        }

        function generateToken (csrf){
            $('input[name="<?php echo $this->config->item('csrf_token_name'); ?>"]').val(csrf);
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
</body>

</html>
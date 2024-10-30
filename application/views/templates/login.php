<?php
defined('BASEPATH') or exit('No direct script access allowed');
$form_id = 'idForm';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo getenv('APP_NAME') ?> | Log in</title>

    <link rel="shortcut icon" href='<?php echo getenv('RESOURCE_BASE_URL'); ?>/dist/img/favicon_ertx.ico'>
    <link rel="stylesheet" href="<?php echo getenv('RESOURCE_BASE_URL'); ?>/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo getenv('RESOURCE_BASE_URL'); ?>/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo getenv('RESOURCE_BASE_URL'); ?>/plugins/toastr/toastr.min.css">

</head>

<body class="hold-transition login-page" id="idbody">


    <div class="login-box">

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?php echo getenv('BASE_URL'); ?>" class="h1"><?php echo getenv('APP_NAME'); ?></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form id="<?php echo $form_id; ?>">
                    <div class="input-group mb-3">
                        <input name="username" type="text" class="form-control" placeholder="Username" autocomplete="off">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input name="password" type="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7">
                        </div>

                        <div class="col-5">
                            <button type="submit" class="btn btn-primary btn-block" id="idbtnSubmit<?php echo $form_id; ?>" onclick="submitData('<?php echo $form_id; ?>')">Sign In</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>


    <script src="<?php echo getenv('RESOURCE_BASE_URL'); ?>/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo getenv('RESOURCE_BASE_URL'); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getenv('RESOURCE_BASE_URL'); ?>/plugins/toastr/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.net.min.js"></script>
    <script>
        VANTA.NET({
            el: "#idbody",
            mouseControls: false,
            touchControls: false,
            gyroControls: false,
            minHeight: 200.00,
            minWidth: 200.00,
            scale: 1.00,
            scaleMobile: 1.00,
            color: 0x3f60ff
        })
    </script>
    <script type="text/javascript">
        function submitData(form_id) {
            event.preventDefault();
            var form = $('#' + form_id)[0];
            // Loading animate
            $('#idbtnSubmit' + form_id).html('<i class="fa fa-spinner fa-pulse"></i> Loading');
            $('#idbtnSubmit' + form_id).attr('disabled', true);

            $.ajax({
                url: '<?php echo getenv('BASE_URL') . 'auth/login' ?>',
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
                },
                complete: function(dt) {
                    // Loading animate
                    $('#idbtnSubmit' + form_id).html('Sign In');
                    $('#idbtnSubmit' + form_id).attr('disabled', false);
                }
            });
        }

        function generateToken(csrf) {
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

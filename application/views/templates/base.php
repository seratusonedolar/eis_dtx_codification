<?php
defined('BASEPATH') or exit('No direct script access allowed');
$segments = $this->uri->segment_array();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php
            $title = !empty($segments) ?  ucwords(str_replace('_', ' ', $segments[count($segments)])) : '';
            echo getenv('APP_NAME') . " - " . $title; ?></title>
    <link rel="shortcut icon" href='<?php echo getenv('RESOURCE_BASE_URL'); ?>dist/img/favicon_ertx.ico'>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo getenv('RESOURCE_BASE_URL'); ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo getenv('RESOURCE_BASE_URL'); ?>dist/css/adminlte.min.css">
    <?php
    foreach ($css as $file) {
        echo "\n\t\t";
    ?>
        <link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" /><?php
                                                                            }
                                                                            echo "\n\t";
                                                                                ?>
    <style type="text/css">
        .preloader-custom {
            /*display: none;*/
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('<?php echo getenv('RESOURCE_BASE_URL'); ?>dist/img/Spinner-2.gif') no-repeat rgb(255, 255, 255);
            background-position: center;
            opacity: .85;
        }
    </style>
	<style>
		.select2-dropdown-custom {
			width: auto !important;
			min-width: 100px; /* Adjust this as necessary */
		}
	</style>
</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
    <!-- Loader -->
    <div class="preloader-custom"></div>
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php echo $this->load->get_section('navbar'); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?php echo base_url(); ?>" class="brand-link">
                <img src="<?php echo getenv('RESOURCE_BASE_URL'); ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?php echo getenv('APP_NAME'); ?></span>
            </a>

            <!-- Sidebar -->
            <?php echo $this->load->get_section('sidebar'); ?>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <!-- <h1>Blank Page</h1> -->
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <?php for ($iSegment = 1; $iSegment <= count($segments); $iSegment++) : ?>
                                    <li class="breadcrumb-item"><?php echo strtoupper(str_replace('_', ' ', $segments[$iSegment])); ?></a></li>
                                <?php endfor; ?>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <?php echo $output; ?>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <?php echo $this->load->get_section('footer'); ?>
        <!-- /.Footer -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?php echo getenv('RESOURCE_BASE_URL'); ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo getenv('RESOURCE_BASE_URL'); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo getenv('RESOURCE_BASE_URL'); ?>dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="<?php echo getenv('RESOURCE_BASE_URL'); ?>/dist/js/demo.js"></script> -->
    <?php
    foreach ($js as $file) {
        echo "\n\t\t";
    ?><script src="<?php echo $file; ?>"></script><?php
                                                        }
                                                        echo "\n\t";
                                                            ?>

    <script type="text/javascript">
        /** add active class and stay opened when selected */
        var url = window.location;

        var splitGet = url.href.split('?');
        var splitUrl = splitGet[0].split('/');

        // for treeview
        $('ul.nav-treeview a').filter(function() {
            var splitHref = this.href.split('/');
            var lastUrlString = splitHref[splitHref.length - 1];
            return splitUrl.includes(lastUrlString);
            // return this.href == url;
        }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open');

        $('li.nav-item a').filter(function() {
            var splitHref = this.href.split('/');
            var lastUrlString = splitHref[splitHref.length - 1];
            return splitUrl.includes(lastUrlString);
            // return this.href == url;
        }).addClass('active');

        /** Loader */
        $(document).ready(function() {
            $('.preloader-custom').fadeOut('xfast');
        });

        /** Generate Token */
        function generateToken(csrf) {
            $('input[name="<?php echo $this->config->item('csrf_token_name'); ?>"]').val(csrf);
        }
    </script>


    <?php echo $this->load->get_section('scriptJS'); ?>
</body>

</html>

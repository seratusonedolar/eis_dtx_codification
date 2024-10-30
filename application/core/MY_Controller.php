<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        // $this->load->library(array('session'));
        $this->load->helper(array('url', 'cookie'));
        $this->load->helper(['my_helper']);

        $xtoken = isset($_COOKIE['x-token-' . strtolower(str_replace(' ', '', getenv('APP_NAME')))]) &&
            !empty($_COOKIE['x-token-' . strtolower(str_replace(' ', '', getenv('APP_NAME')))]) ? $_COOKIE['x-token-' . strtolower(str_replace(' ', '', getenv('APP_NAME')))] : null;
        $userid = isset($_COOKIE['x-userid-' . strtolower(str_replace(' ', '', getenv('APP_NAME')))]) &&
            !empty($_COOKIE['x-userid-' . strtolower(str_replace(' ', '', getenv('APP_NAME')))]) ? $_COOKIE['x-userid-' . strtolower(str_replace(' ', '', getenv('APP_NAME')))] : null;

        $this->user_id = '';
        if (!empty($xtoken)) {
            $this->user_id = base64_decode($userid);
            $decodeXtoken = base64_decode($xtoken);
            if (time() > $decodeXtoken) {
                setcookie('x-token-' . strtolower(str_replace(' ', '', getenv('APP_NAME'))), '', (86400 * 120));
                redirect('/auth', 'refresh');
            }
        } else {
            setcookie('x-token-' . strtolower(str_replace(' ', '', getenv('APP_NAME'))), '', (86400 * 120));
            redirect('/auth', 'refresh');
        }
    }

    public function baseTemplate()
    {
        $this->load->model(['/Mambo/Mos_usersModel']);
        
        $data = array();
        if (isset($this->user_id)) {
            $data['user'] = $this->Mos_usersModel->get_by_param(['id' => $this->user_id])->row_array();
        }
        $this->output->set_template('/base');
        $this->load->section('navbar', 'templates/navbar', $data);
        $this->load->section('sidebar', 'templates/sidebar', $data);
        $this->load->section('footer', 'templates/footer', $data);
    }

    public function stdTemplate()
    {
        $this->output->set_template('stdBootstrap');
    }

    public function datatablesAssets()
    {
        $this->load->css(getenv('RESOURCE_BASE_URL') . 'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css');
        $this->load->css(getenv('RESOURCE_BASE_URL') . 'plugins/datatables-responsive/css/responsive.bootstrap4.min.css');
        $this->load->css(getenv('RESOURCE_BASE_URL') . 'plugins/datatables-buttons/css/buttons.bootstrap4.min.css');
        $this->load->css(getenv('RESOURCE_BASE_URL') . 'plugins/datatables-fixedcolumns/css/fixedColumns.bootstrap4.min.css');

        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/datatables/jquery.dataTables.min.js');
        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js');
        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/datatables-responsive/js/dataTables.responsive.min.js');
        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/datatables-responsive/js/responsive.bootstrap4.min.js');
        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/datatables-buttons/js/dataTables.buttons.min.js');
        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/datatables-buttons/js/buttons.bootstrap4.min.js');
        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/jszip/jszip.min.js');
        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/pdfmake/pdfmake.min.js');
        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/pdfmake/vfs_fonts.js');
        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/datatables-buttons/js/buttons.html5.min.js');
        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/datatables-buttons/js/buttons.print.min.js');
        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/datatables-buttons/js/buttons.colVis.min.js');
        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/datatables-fixedcolumns/js/dataTables.fixedColumns.min.js');
    }

    public function select2Assets()
    {
        $this->load->css(getenv('RESOURCE_BASE_URL') . 'plugins/select2/css/select2.min.css');
        $this->load->css(getenv('RESOURCE_BASE_URL') . 'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css');

        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/select2/js/select2.full.min.js');
    }

    public function sweetAlert2Assets()
    {
        $this->load->css(getenv('RESOURCE_BASE_URL') . 'plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css');

        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/sweetalert2/sweetalert2.min.js');
    }

    public function toastAssets()
    {
        $this->load->css(getenv('RESOURCE_BASE_URL') . 'plugins/toastr/toastr.min.css');
        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/toastr/toastr.min.js');
    }

    public function inputmaskAssets()
    {
        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/moment/moment.min.js');
        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/inputmask/jquery.inputmask.min.js');
    }

    public function datetimepickerAssets()
    {
        $this->load->css(getenv('RESOURCE_BASE_URL') . 'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css');
        $this->load->js(getenv('RESOURCE_BASE_URL') . 'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js');
    }
}

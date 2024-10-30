<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logsystem extends MY_Controller
{
    private $class_link = 'logsystem';

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        parent::baseTemplate();
        parent::toastAssets();
        parent::inputmaskAssets();
        parent::datetimepickerAssets();

        $data['class_link'] = $this->class_link;
        $data['logDate'] = $this->input->get('logDate');

        $this->load->view($this->class_link . '/table_main', $data);
    }

    public function action_view_log()
    {
        $logdate = $this->input->get('logdate');

        $string = '-- Log Not Found! --';
        if (file_exists("./application/logs/log-$logdate.php")){
            $string = file_get_contents("./application/logs/log-$logdate.php");
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($string);
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lockscreen extends CI_Controller
{

    public function index()
    {
        $this->load->view('templates/lockscreen');
    }

    public function auth()
    {
        $this->load->helper(array('cookie'));

        $password = $this->input->post('password');
        if (!empty($password) && $password == getenv('APP_PASSWORD')) {
            $xtoken = strtotime("+12 hours", time());
            set_cookie('x-token-'.strtolower(str_replace(' ', '', getenv('APP_NAME'))), base64_encode($xtoken), 86400);

            $resp['code'] = 200;
            $resp['messages'] = 'Success';
        } else {
            $resp['code'] = 400;
            $resp['messages'] = 'Wrong Password';
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    public function logout()
    {
        $this->load->helper(array('cookie', 'url'));
        set_cookie('x-token-'.strtolower(str_replace(' ', '', getenv('APP_NAME'))), '', 86400);
        redirect('/lockscreen', 'refresh');
    }
}

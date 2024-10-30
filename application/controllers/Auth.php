<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->dbMambo = $this->load->database('mambo', TRUE);
    }

    public function index()
    {
        $this->load->view('templates/login');
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->dbMambo->query(
            "SELECT * 
            FROM mos_users
            WHERE username = ? ",
            array($username)
        )->row_array();

        if (!empty($user)) {
            if (md5($password) == $user['password']) {
                $userExist = $this->db->query(
                    "SELECT user_id FROM datatex_m_role_user WHERE user_id = ?",
                    [$user['id']]
                )->num_rows();

                if (empty($userExist)) {
                    $resp['code'] = 400;
                    $resp['messages'] = "User don't have access, please contact IT";
                } else {
                    $xtoken = strtotime("+12 hours", time()); // perhitungan dari GMT

                    setcookie('x-token-' . strtolower(str_replace(' ', '', getenv('APP_NAME'))), base64_encode($xtoken), $xtoken, '/');
                    setcookie('x-userid-' . strtolower(str_replace(' ', '', getenv('APP_NAME'))), base64_encode($user['id']), $xtoken, '/');

                    $resp['code'] = 200;
                    $resp['messages'] = 'Success';
                }
            } else {
                $resp['code'] = 400;
                $resp['messages'] = 'Sign in Failed';
            }
        } else {
            $resp['code'] = 400;
            $resp['messages'] = 'User not found';
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    public function logout()
    {
        $this->load->helper(array('cookie', 'url'));
        setcookie('x-token-' . strtolower(str_replace(' ', '', getenv('APP_NAME'))), '', (86400 * 30), '/');
        setcookie('x-userid-' . strtolower(str_replace(' ', '', getenv('APP_NAME'))), '', (86400 * 30), '/');
        redirect('/auth', 'refresh');
    }
}

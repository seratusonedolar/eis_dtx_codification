<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Role extends MY_Controller
{
    private $class_link = 'setting/role';

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['EISDatatex/Setting/LogTransactionModel']);
    }

    public function index()
    {
        if (!checkPermission('SETTING.ROLE.READ')) {
            show_error("You don't have permission", 403, 'Forbidden');
        }

        parent::baseTemplate();
        parent::datatablesAssets();
        parent::select2Assets();
        parent::toastAssets();

        $data['class_link'] = $this->class_link;

        $this->load->view($this->class_link . '/index', $data);
    }

    public function ajax()
    {
        $datatables = new Datatables(new CodeigniterAdapter);

        $datatables->query(
            "SELECT datatex_m_role.dtmrole_id as role_action, datatex_m_role.dtmrole_name, datatex_m_role.dtmrole_desc, datatex_m_role.dtmrole_is_active, datatex_m_role.dtmrole_id
            FROM datatex_m_role"
        );

        $datatables->edit('role_action', function ($data) {
            $html = '';
            $html .= '
            <a href="javascript:void(0);" onclick="detail_roleuser(\'' . $data['dtmrole_id'] . '\')" class="btn btn-tool btn-sm" title="List Users">
                <i class="fas fa-users"></i>
            </a>';
            $html .= '
            <a href="javascript:void(0);" onclick="role_form(\'' . 'edit' . '\',\'' . $data['dtmrole_id'] . '\')" class="btn btn-tool btn-sm" title="Edit">
                <i class="fas fa-edit"></i>
            </a>';
            $html .= '
            <a href="javascript:void(0);" onclick="delete_role(\'' . $data['dtmrole_id'] . '\')" class="btn btn-tool btn-sm" title="Delete">
                <i class="fas fa-trash"></i>
            </a>';
            return $html;
        });

        $datatables->edit('dtmrole_name', function ($data) {
            return '<a href="javascript:void(0);" onclick="detail_rolepermission(\'' . $data['dtmrole_id'] . '\')"> ' . $data['dtmrole_name'] . ' </a>';
        });

        echo $datatables->generate();
    }

    public function role_form()
    {
        $this->load->helper('form');

        $slug = $this->input->get('slug');
        $dtmrole_id = $this->input->get('dtmrole_id');

        if ($slug == 'edit') {
            $data['row'] = $this->db->query('
            SELECT * FROM datatex_m_role WHERE dtmrole_id = ?', [$dtmrole_id])->row_array();
        }

        $data['class_link'] = $this->class_link;
        $data['dtmrole_id'] = $dtmrole_id;
        $data['slug'] = $slug;

        $this->load->view($this->class_link . '/role_form', $data);
    }

    public function permission()
    {
        parent::baseTemplate();
        parent::datatablesAssets();
        parent::select2Assets();
        parent::toastAssets();

        $dtmrole_id = $this->input->get('dtmrole_id');
        $this->load->model(['EISDatatex/Setting/PermissionModel']);

        $data['class_link'] = $this->class_link;
        $data['dtmrole_id'] = $dtmrole_id;
        $data['role'] =  $this->db->query(
            "SELECT datatex_m_role.*
            FROM datatex_m_role
            WHERE datatex_m_role.dtmrole_id = ?",
            array($dtmrole_id)
        )->row_array();
        $data['rolePermission'] = $this->db->query(
            "SELECT datatex_m_role_permission.*
            FROM datatex_m_role_permission
            WHERE datatex_m_role_permission.dtmrole_id = ?",
            array($dtmrole_id)
        )->result_array();
        $data['permissions'] = $this->PermissionModel->get_all();

        $this->load->view($this->class_link . '/permission_form', $data);
    }

    public function action_submit()
    {
        $this->load->library(['form_validation']);
        $this->form_validation->set_rules('dtmrole_id', 'ID', 'required');

        $resp = [];
        if ($this->form_validation->run() == FALSE) {
            $resp['code'] = 400;
            $resp['messages'] = validation_errors();
        } else {
            $dtmrole_id = $this->input->post('dtmrole_id');
            $dtmrolepermission_names = $this->input->post('dtmrolepermission_names');

            if (!empty($dtmrolepermission_names)) {
                foreach ($dtmrolepermission_names as $dtname) {
                    $arrayRolePermissions[] = [
                        'dtmrole_id' => $dtmrole_id,
                        'dtmrolepermission_name' => $dtname
                    ];
                }
                $this->db->trans_begin();

                $this->db->delete('datatex_m_role_permission', array('dtmrole_id' => $dtmrole_id));
                $this->db->insert_batch('datatex_m_role_permission', $arrayRolePermissions);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $resp['code'] = 400;
                    $resp['messages'] = 'Error';
                } else {
                    $this->db->trans_commit();
                    $resp['code'] = 200;
                    $resp['messages'] = 'Success';
                }
            } else {
                $resp['code'] = 400;
                $resp['messages'] = 'No Selected Permission';
            }
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    public function action_role_submit()
    {
        $this->load->library(['form_validation']);
        $this->form_validation->set_rules('dtmrole_name', 'Name', 'required');

        $resp = [];
        if ($this->form_validation->run() == FALSE) {
            $resp['code'] = 400;
            $resp['messages'] = validation_errors();
        } else {
            $slug = $this->input->post('slug');
            $dtmrole_id = $this->input->post('dtmrole_id');
            $dtmrole_name = $this->input->post('dtmrole_name');
            $dtmrole_desc = $this->input->post('dtmrole_desc');
            $dtmrole_is_active = $this->input->post('dtmrole_is_active');

            $this->db->trans_begin();

            $arrayRole = [
                'dtmrole_name' => $dtmrole_name,
                'dtmrole_desc' => $dtmrole_desc,
                'dtmrole_is_active' => $dtmrole_is_active,
            ];
            if ($slug == 'add') {
                $this->db->insert('datatex_m_role', $arrayRole);

                /** Log */
                $dataLog = ['datatex_m_role' => $arrayRole];
                $this->LogTransactionModel->generateLog($dataLog, strtoupper($slug), $this->user_id);

            } elseif ($slug == 'edit') {
                if (!empty($dtmrole_id)) {

                    $this->db->update('datatex_m_role', $arrayRole, ['dtmrole_id' => $dtmrole_id]);
                }
            }


            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $resp['code'] = 400;
                $resp['messages'] = 'Error';
            } else {
                $this->db->trans_commit();
                $resp['code'] = 200;
                $resp['messages'] = 'Success';
            }
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    public function action_delete_role()
    {
        $dtmrole_id = $this->input->get('dtmrole_id');
        if (!empty($dtmrole_id)) {
            $this->db->trans_begin();

            /** Log */
            $dataLog = ['datatex_m_role' => $this->db->query("SELECT * FROM datatex_m_role WHERE dtmrole_id = ?", [$dtmrole_id])->row_array()];
            $this->LogTransactionModel->generateLog($dataLog, 'DELETE', $this->user_id);

            $this->db->delete('datatex_m_role', array('dtmrole_id' => $dtmrole_id));

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $resp['code'] = 400;
                $resp['messages'] = 'Error';
            } else {
                $this->db->trans_commit();
                $resp['code'] = 200;
                $resp['messages'] = 'Success';
            }
        } else {
            $resp['code'] = 400;
            $resp['messages'] = 'ID Null';
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    public function user()
    {
        parent::baseTemplate();
        parent::datatablesAssets();
        parent::select2Assets();
        parent::toastAssets();

        $dtmrole_id = $this->input->get('dtmrole_id');

        $data['class_link'] = $this->class_link;
        $data['dtmrole_id'] = $dtmrole_id;
        $data['role'] = $this->db->query("SELECT * FROM datatex_m_role WHERE dtmrole_id = ?", array($dtmrole_id))->row_array();

        $this->load->view($this->class_link . '/user_index', $data);
    }

    public function user_form()
    {
        $dtmrole_id = $this->input->get('dtmrole_id');

        $data['class_link'] = $this->class_link;
        $data['dtmrole_id'] = $dtmrole_id;

        $this->load->view($this->class_link . '/user_form', $data);
    }

    public function user_ajax()
    {
        $dtmrole_id = $this->input->get('dtmrole_id');
        $datatables = new Datatables(new CodeigniterAdapter);

        $datatables->query(
            "SELECT datatex_m_role_user.dtmroleuser_id, datatex_m_role_user.user_id, m_users.username, datatex_m_role_user.dtmroleuser_created_at
            FROM datatex_m_role_user 
            LEFT JOIN m_users ON m_users.user_id=datatex_m_role_user.user_id
            WHERE datatex_m_role_user.dtmrole_id = $dtmrole_id "
        );

        $datatables->edit('dtmroleuser_id', function ($data) {
            $html = '';
            $html .= '
            <a href="javascript:void(0);" class="btn btn-tool btn-sm" onclick="delete_data(\'' . $data['dtmroleuser_id'] . '\')">
                <i class="fas fa-trash"></i>
            </a>';
            return $html;
        });

        echo $datatables->generate();
    }

    public function autocomplete_user()
    {
        $param_search = $this->input->get('param_search');

        $q = "SELECT * FROM m_users WHERE m_users.status = 0 ";
        if (!empty($param_search)) {
            $q .= "AND m_users.username ILIKE '%$param_search%'";
        }
        $q .= " ORDER BY m_users.username ASC";

        $result = $this->db->query($q)->result_array();

        echo json_encode($result);
    }

    public function action_submit_user()
    {
        $this->load->library(['form_validation']);
        $this->form_validation->set_rules('user_id', 'ID', 'required');

        $resp = [];
        if ($this->form_validation->run() == FALSE) {
            $resp['code'] = 400;
            $resp['messages'] = validation_errors();
        } else {
            $dtmrole_id = $this->input->post('dtmrole_id');
            $user_id = $this->input->post('user_id');

            if (!empty($user_id)) {
                /** Check if already exist user */
                $checkExist = $this->db->query("SELECT user_id FROM datatex_m_role_user WHERE user_id = ?", [$user_id])->num_rows();
                if (!empty($checkExist)) {
                    $resp['code'] = 400;
                    $resp['messages'] = 'User ALready Exist';
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($resp);
                    exit();
                }

                $this->db->trans_begin();

                $arrayRoleUser = [
                    'dtmrole_id' => $dtmrole_id,
                    'user_id' => $user_id
                ];

                $this->db->insert('datatex_m_role_user', $arrayRoleUser);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $resp['code'] = 400;
                    $resp['messages'] = 'Error';
                } else {
                    $this->db->trans_commit();
                    $resp['code'] = 200;
                    $resp['messages'] = 'Success';
                }
            } else {
                $resp['code'] = 400;
                $resp['messages'] = 'No Selected User';
            }
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    public function action_delete_roleuser()
    {
        $dtmroleuser_id = $this->input->get('dtmroleuser_id');
        if (!empty($dtmroleuser_id)) {
            $this->db->trans_begin();

            $this->db->delete('datatex_m_role_user', array('dtmroleuser_id' => $dtmroleuser_id));

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $resp['code'] = 400;
                $resp['messages'] = 'Error';
            } else {
                $this->db->trans_commit();
                $resp['code'] = 200;
                $resp['messages'] = 'Success';
            }
        } else {
            $resp['code'] = 400;
            $resp['messages'] = 'ID Null';
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Datatech_itemcodification extends MY_Controller
{
    private $class_link = 'eis/datatech_itemcodification';

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['EISDatatex/Setting/LogTransactionModel']);
    }

    public function index()
    {
        if (!checkPermission('MASTERITEM.CODIFICATION.READ')) {
            show_error("You don't have permission", 403, 'Forbidden');
        }

        parent::baseTemplate();
        parent::datatablesAssets();
        parent::toastAssets();

        $data['class_link'] = $this->class_link;
        $data['msubcodes'] = $this->db->query(
            "SELECT datatex_m_subcode.* FROM datatex_m_subcode 
            LEFT JOIN datatex_m_subcode_detail ON datatex_m_subcode_detail.dtmsubcode_option_id = datatex_m_subcode.dtmsubcode_id AND datatex_m_subcode.dtmsubcode_level = 2
            ORDER BY datatex_m_subcode_detail.dtmsubcodedtl_seq ASC"
        )->result_array();

        $data['techInfs'] = $this->db->query(
            "SELECT * FROM datatex_m_subcode_tech_information
            ORDER BY dtmsubcodetechinf_seq"
        )->result_array();

        $this->load->view($this->class_link . '/index', $data);
    }

    public function form_main()
    {
        $this->load->helper('form');

        $slug = $this->input->get('slug');
        $dtmsubcode_id = $this->input->get('dtmsubcode_id');

        $dtmsubcode = $this->db->query(
            "SELECT * 
            FROM datatex_m_subcode
            WHERE dtmsubcode_id = ?",
            array($dtmsubcode_id)
        )->row_array();

        $dtmsubcode_level = $dtmsubcode['dtmsubcode_level'];
        if ($slug == 'add') {
            $dtmsubcode_level = (int) $dtmsubcode_level + 1;
            $dtmsubcode_parent = $dtmsubcode_id;
        } else {
            $dtmsubcode_parent = $dtmsubcode['dtmsubcode_parent'];
            $dtmsubcode_id = $dtmsubcode['dtmsubcode_id'];
            $data['dtmsubcode_name'] = $dtmsubcode['dtmsubcode_name'];
            $data['dtmsubcode_code'] = $dtmsubcode['dtmsubcode_code'];
            $data['dtmsubcode_is_active'] = $dtmsubcode['dtmsubcode_is_active'];
        }

        $data['class_link'] = $this->class_link;
        $data['slug'] = $slug;
        $data['dtmsubcode_level'] = $dtmsubcode_level;
        $data['dtmsubcode_parent'] = $dtmsubcode_parent;
        $data['dtmsubcode_id'] = $dtmsubcode_id;

        $this->load->view($this->class_link . '/form_main', $data);
    }

    public function action_submit_msubcode()
    {
        $this->load->library(['form_validation']);
        $this->form_validation->set_rules('dtmsubcode_name', 'Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $resp['code'] = 400;
            $resp['messages'] = validation_errors();
        } else {
            $slug = $this->input->post('slug');
            $dtmsubcode_id = $this->input->post('dtmsubcode_id');
            $dtmsubcode_code = $this->input->post('dtmsubcode_code');
            $dtmsubcode_level = $this->input->post('dtmsubcode_level');
            $dtmsubcode_name = $this->input->post('dtmsubcode_name');
            $dtmsubcode_parent = $this->input->post('dtmsubcode_parent');
            $dtmsubcode_is_active = $this->input->post('dtmsubcode_is_active');

            $arrayMSubcode = [
                'dtmsubcode_name' => $dtmsubcode_name,
                'dtmsubcode_parent' => !empty($dtmsubcode_parent) ? $dtmsubcode_parent : null,
                'dtmsubcode_level' => $dtmsubcode_level,
                'dtmsubcode_code' => !empty($dtmsubcode_code) ? $dtmsubcode_code : null,
                'dtmsubcode_is_active' => $dtmsubcode_is_active,
            ];
            if ($slug == 'add') {
                $this->db->trans_begin();

                $this->db->insert('datatex_m_subcode', $arrayMSubcode);

                /** Log */
                $dataLog = ['datatex_m_subcode' => $arrayMSubcode];
                $this->LogTransactionModel->generateLog($dataLog, 'ADD', $this->user_id);

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
                $arrayMSubcode = array_merge($arrayMSubcode, ['dtmsubcode_updated_at' => date('Y-m-d H:i:s')]);
                $this->db->trans_begin();

                /** Log */
                $dataLog = ['datatex_m_subcode' => $arrayMSubcode, 'where' => array('dtmsubcode_id' => $dtmsubcode_id)];
                $this->LogTransactionModel->generateLog($dataLog, 'UPDATE', $this->user_id);

                $this->db->update('datatex_m_subcode', $arrayMSubcode, array('dtmsubcode_id' => $dtmsubcode_id));

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
    }

    public function subcode_hierarchy()
    {
        parent::baseTemplate();
        parent::datatablesAssets();
        parent::toastAssets();

        $id = $this->input->get('id');
        $idDecode = base64_decode(($id));
        $slug = $this->input->get('slug');
        $dtmsubcodehierarchy_name = $this->input->get('dtmsubcodehierarchy_name');

        !empty($slug) ? $slug : 'add';

        $rowSubcode = $this->db->query(
            "SELECT datatex_m_subcode.dtmsubcode_name, parent1.dtmsubcode_name AS parent1_name, parent2.dtmsubcode_name AS parent2_name
            FROM datatex_m_subcode
            LEFT JOIN datatex_m_subcode AS parent1 ON parent1.dtmsubcode_id=datatex_m_subcode.dtmsubcode_parent
            LEFT JOIN datatex_m_subcode AS parent2 ON parent2.dtmsubcode_id=parent1.dtmsubcode_parent
            WHERE datatex_m_subcode.dtmsubcode_id = ?",
            array($idDecode)
        )->row_array();

        /** Special case for access FABRIC.MAINCATEGORY */
        if (strpos(strtoupper($rowSubcode['dtmsubcode_name']), 'MAIN CATEGORY') !== false) {
            if (!checkPermission('MASTERITEM.CODIFICATION.SUBCODEHIERARCHY.ALL.MAIN_CATEGORY.READ')) {
                show_error("You don't have permission", 403, 'Forbidden');
            }
        }

        $data['caption'] = "{$rowSubcode['parent2_name']} -> {$rowSubcode['parent1_name']} -> {$rowSubcode['dtmsubcode_name']}";
        $data['class_link'] = $this->class_link;
        $data['id'] = $idDecode;
        $data['slug'] = $slug;
        $data['dtmsubcodehierarchy_name'] = !empty($dtmsubcodehierarchy_name) ? urldecode($dtmsubcodehierarchy_name) : '';

        $this->load->view($this->class_link . '/subcode_hierarchy_index', $data);
    }

    public function subcode_hierarchy_form()
    {
        $this->load->helper('form');

        $dtmsubcode_id = $this->input->get('dtmsubcode_id');
        $dtmsubcodehierarchy_id = $this->input->get('dtmsubcodehierarchy_id');
        $slug = $this->input->get('slug');
        $dtmsubcodehierarchy_name = $this->input->get('dtmsubcodehierarchy_name');

        if ($slug == 'EXTENDVIEW') {
            $data['dtmsubcodehierarchy_code'] = substr(str_shuffle(str_repeat("012345678ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 5);;
        }

        $data['class_link'] = $this->class_link;
        $data['slug'] = !empty($slug) ? $slug : 'add';
        $data['dtmsubcode_id'] = $dtmsubcode_id;
        $data['dtmsubcodehierarchy_id'] = $dtmsubcodehierarchy_id;
        $data['dtmsubcodehierarchy_name'] = !empty($dtmsubcodehierarchy_name) ? urldecode($dtmsubcodehierarchy_name) : '';

        if ($slug == 'edit') {
            $data['row'] = $this->db->query(
                "SELECT * 
                FROM datatex_m_subcode_hierarchy
                WHERE dtmsubcodehierarchy_id = ?",
                array($dtmsubcodehierarchy_id)
            )->row_array();
        }

        $this->load->view($this->class_link . '/subcode_hierarchy_form', $data);
    }

    public function subcode_hierarchy_formbatch()
    {
        $dtmsubcode_id = $this->input->get('dtmsubcode_id');
        $slug = $this->input->get('slug');

        $data['class_link'] = $this->class_link;
        $data['slug'] = $slug;
        $data['dtmsubcode_id'] = $dtmsubcode_id;

        $this->load->view($this->class_link . '/subcode_hierarchy_formbatch', $data);
    }

    public function action_submit_hierarchy()
    {
        $this->load->library(['form_validation']);
        $this->form_validation->set_rules('dtmsubcode_id', 'Code', 'required');
        $this->form_validation->set_rules('dtmsubcodehierarchy_code', 'Code', 'required');
        $this->form_validation->set_rules('dtmsubcodehierarchy_name', 'Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $resp['code'] = 400;
            $resp['messages'] = validation_errors();
        } else {
            $slug = $this->input->post('slug');
            $dtmsubcode_id = $this->input->post('dtmsubcode_id');
            $dtmsubcodehierarchy_id = $this->input->post('dtmsubcodehierarchy_id');
            $dtmsubcodehierarchy_code = $this->input->post('dtmsubcodehierarchy_code');
            $dtmsubcodehierarchy_name = $this->input->post('dtmsubcodehierarchy_name');
            $dtmsubcodehierarchy_is_active = $this->input->post('dtmsubcodehierarchy_is_active');

            /** Validation Code */
            $dtmsubcodehierarchy_code = strtoupper($dtmsubcodehierarchy_code);
            $subcodehierarchy = $this->db->query(
                "SELECT dtmsubcodehierarchy_code
                FROM datatex_m_subcode_hierarchy
                WHERE dtmsubcode_id = ?
                AND (dtmsubcodehierarchy_code = ? OR dtmsubcodehierarchy_name = ?)",
                array($dtmsubcode_id, $dtmsubcodehierarchy_code, $dtmsubcodehierarchy_name)
            )->num_rows();
            
            if (!empty($subcodehierarchy) && $slug == 'add') {
                $resp['code'] = 400;
                $resp['messages'] = 'Code Already Exist';
            } else {
                $arrayHierarchy = [
                    'dtmsubcodehierarchy_code' => $dtmsubcodehierarchy_code,
                    'dtmsubcodehierarchy_name' => !empty($dtmsubcodehierarchy_name) ? $dtmsubcodehierarchy_name : null,
                    'dtmsubcode_id' => $dtmsubcode_id,
                    'dtmsubcodehierarchy_is_active' => $dtmsubcodehierarchy_is_active,
                    'dtmsubcodehierarchy_updated_at' => date('Y-m-d H:i:s'),
                    'dtmsubcodehierarchy_user_id' => $this->user_id
                ];
				$arrayHierarchy2item = [
                    'dtmitemdtl_code' => $dtmsubcodehierarchy_code,
                    'dtmitemdtl_updated_at' => date('Y-m-d H:i:s'),
                ];

                if ($slug == 'add' || $slug == 'EXTENDVIEW') {
                    $this->db->trans_begin();

                    $this->db->insert('datatex_m_subcode_hierarchy', array_merge($arrayHierarchy, ['dtmsubcodehierarchy_created_by' => $this->user_id]));

                    /** Log */
                    $dataLog = ['datatex_m_subcode_hierarchy' => $arrayHierarchy];
                    $this->LogTransactionModel->generateLog($dataLog, 'ADD', $this->user_id);

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
                    $arrayHierarchy = $arrayHierarchy;
                    $this->db->trans_begin();

                    /** Log */
                    $dataLog = ['datatex_m_subcode_hierarchy' => $arrayHierarchy, 'where' => array('dtmsubcodehierarchy_id' => $dtmsubcodehierarchy_id)];
                    $this->LogTransactionModel->generateLog($dataLog, 'UPDATE', $this->user_id);

                    $this->db->update('datatex_m_subcode_hierarchy', $arrayHierarchy, array('dtmsubcodehierarchy_id' => $dtmsubcodehierarchy_id));
					$this->db->update('datatex_m_item_detail', $arrayHierarchy2item, array('dtmsubcodehierarchy_id' => $dtmsubcodehierarchy_id));

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $resp['code'] = 400;
                        $resp['messages'] = 'Error';
                    } else {
                        $this->db->trans_commit();
                        $resp['code'] = 200;
                        $resp['messages'] = 'Success';
                        $resp['slug'] = $slug;
                    }
                }
            }
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    public function action_submit_hierarchy_batch()
    {
        $this->load->library(['form_validation']);
        $this->form_validation->set_rules('dtmsubcode_id', 'Code', 'required');
        $this->form_validation->set_rules('batchdata', 'Batch Data', 'required');

        $resp = array();
        if ($this->form_validation->run() == FALSE) {
            $resp['code'] = 400;
            $resp['messages'] = validation_errors();
        } else {
            $dtmsubcode_id = $this->input->post('dtmsubcode_id');
            $batchdata = $this->input->post('batchdata');

            try {
                /** Split lines */
                $expDataLines = explode(PHP_EOL, $batchdata);
                $countLines = count($expDataLines);

                $dataBatch = array();
                foreach ($expDataLines as $eLine) {
                    $expData = explode(';', $eLine);
                    if (count($expData) == 2) {
                        $dataBatch[] = [
                            'dtmsubcodehierarchy_code' => trim($expData[0]),
                            'dtmsubcodehierarchy_name' => trim($expData[1]),
                            'dtmsubcode_id' => $dtmsubcode_id,
                            'dtmsubcodehierarchy_is_active' => 1,
                            'dtmsubcodehierarchy_updated_at' => date('Y-m-d H:i:s'),
                            'dtmsubcodehierarchy_user_id' => $this->user_id,
                            'dtmsubcodehierarchy_created_by' => $this->user_id
                        ];
                    }
                }

                /** Check if code already exist */
                $subcodehierarchyExist = $this->db->query(
                    "SELECT dtmsubcodehierarchy_code
                    FROM datatex_m_subcode_hierarchy
                    WHERE dtmsubcode_id = ?",
                    array($dtmsubcode_id)
                )->result_array();
                $subcodehierarchyExistVal = array_column($subcodehierarchyExist, 'dtmsubcodehierarchy_code');

                $dataBatchReady = array();
                $countDataReady = 0;
                if (!empty($subcodehierarchyExistVal) && !empty($dataBatch)) {
                    for ($i = 0; $i < count($dataBatch); $i++) {
                        if (!in_array($dataBatch[$i]['dtmsubcodehierarchy_code'], $subcodehierarchyExistVal)) {
                            $dataBatchReady[] = $dataBatch[$i];
                            $countDataReady++;
                        }
                    }
                } else {
                    $dataBatchReady = $dataBatch;
                    $countDataReady = count($dataBatch);
                }

                if (!empty($dataBatchReady)) {
                    $this->db->trans_begin();

                    $this->db->insert_batch('datatex_m_subcode_hierarchy', $dataBatchReady);

                    /** Log */
                    $dataLog = ['datatex_m_subcode_hierarchy' => $dataBatchReady];
                    $this->LogTransactionModel->generateLog($dataLog, 'ADD_BATCH', $this->user_id);

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $resp['code'] = 400;
                        $resp['messages'] = 'Error';
                    } else {
                        $this->db->trans_commit();
                        $resp['code'] = 200;
                        $resp['messages'] = 'Success, Inserted ' . $countDataReady . ' lines';
                    }
                } else {
                    $resp['code'] = 400;
                    $resp['messages'] = 'No data ready to insert';
                }
            } catch (Exception $e) {
                $resp['code'] = 400;
                $resp['messages'] = $e->getMessage();
            }
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    public function action_delete_hierarchy()
    {
        $dtmsubcodehierarchy_id = $this->input->get('dtmsubcodehierarchy_id');
        if (!empty($dtmsubcodehierarchy_id)) {
            $this->db->trans_begin();

            /** Log */
            $dataLog = $this->db->query("SELECT * FROM datatex_m_subcode_hierarchy WHERE dtmsubcodehierarchy_id = ?", [$dtmsubcodehierarchy_id])->row_array();
            $dataLog = ['datatex_m_subcode_hierarchy' => $dataLog];
            $this->LogTransactionModel->generateLog($dataLog, 'DELETE', $this->user_id);

            $this->db->delete('datatex_m_subcode_hierarchy', array('dtmsubcodehierarchy_id' => $dtmsubcodehierarchy_id));

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

    public function subcode_hierarchy_ajax()
    {
        $id = $this->input->get('id');

        $datatables = new Datatables(new CodeigniterAdapter);

        $datatables->query(
            "SELECT datatex_m_subcode_hierarchy.dtmsubcodehierarchy_id,datatex_m_subcode_hierarchy.dtmsubcodehierarchy_id as hid, datatex_m_subcode_hierarchy.dtmsubcodehierarchy_code,
            datatex_m_subcode_hierarchy.dtmsubcodehierarchy_name, dtmsubcodehierarchy_is_active, dtmsubcodehierarchy_state, dtmsubcodehierarchy_updated_at
            FROM datatex_m_subcode_hierarchy
            WHERE datatex_m_subcode_hierarchy.dtmsubcode_id in (65, 21, 39, 76, 90, 81, 29, 11)"
        );

        $datatables->edit('dtmsubcodehierarchy_id', function ($data) {
            $html = '';
            if (checkPermission('MASTERITEM.CODIFICATION.EDIT')) :
                $html .=
                    '<a href="javascript:void(0);" class="btn btn-tool btn-sm" onclick="edit_data(\'' . $data['dtmsubcodehierarchy_id'] . '\')">
                        <i class="fas fa-edit"></i>
                    </a>';
            endif;
            if (checkPermission('MASTERITEM.CODIFICATION.DELETE')) :
                $html .=
                    ' <a href="javascript:void(0);" class="btn btn-tool btn-sm" onclick="delete_data(\'' . $data['dtmsubcodehierarchy_id'] . '\')">
                    <i class="fas fa-trash"></i>
                </a>';
            endif;

            return $html;
        });
        $datatables->edit('dtmsubcodehierarchy_is_active', function ($data) {
            return !empty($data['dtmsubcodehierarchy_is_active']) ? 'TRUE' : 'FALSE';
        });

        echo $datatables->generate();
    }

    public function subcode_detail()
    {
        parent::baseTemplate();
        parent::datatablesAssets();
        parent::toastAssets();
        parent::select2Assets();

        $id = $this->input->get('id');
        $idDecode = base64_decode(($id));

        $rowSubcode = $this->db->query(
            "SELECT datatex_m_subcode.dtmsubcode_name, parent1.dtmsubcode_name AS parent1_name, parent2.dtmsubcode_name AS parent2_name
            FROM datatex_m_subcode
            LEFT JOIN datatex_m_subcode AS parent1 ON parent1.dtmsubcode_id=datatex_m_subcode.dtmsubcode_parent
            LEFT JOIN datatex_m_subcode AS parent2 ON parent2.dtmsubcode_id=parent1.dtmsubcode_parent
            WHERE datatex_m_subcode.dtmsubcode_id = ?",
            array($idDecode)
        )->row_array();

        $data['caption'] = "{$rowSubcode['parent2_name']} -> {$rowSubcode['parent1_name']} -> {$rowSubcode['dtmsubcode_name']}";
        $data['class_link'] = $this->class_link;
        $data['id'] = $idDecode;

        $this->load->view($this->class_link . '/subcode_detail_index', $data);
    }

    public function subcode_detail_ajax()
    {
        $id = $this->input->get('id');

        $datatables = new Datatables(new CodeigniterAdapter);

        $datatables->query(
            "SELECT datatex_m_subcode_detail.dtmsubcodedtl_id, datatex_m_subcode_detail.dtmsubcodedtl_seq,
            datatex_m_subcode_detail.dtmsubcodedtl_type, datatex_m_subcode.dtmsubcode_name as detailoption_name, datatex_m_subcode_detail.dtmsubcodedtl_remark,
            datatex_m_subcode_detail.dtmsubcodedtl_is_required,
            datatex_m_subcode_detail.dtmsubcodedtl_created_at,
            datatex_m_subcode_detail.dtmsubcode_id
            FROM datatex_m_subcode_detail
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_subcode_detail.dtmsubcode_option_id
            WHERE datatex_m_subcode_detail.dtmsubcode_id = $id"
        );

        $datatables->edit('dtmsubcodedtl_id', function ($data) {
            $html = '';
            if (checkPermission('MASTERITEM.CODIFICATION.SUBCODEDETAIL.EDIT')) :
                $html .=
                    '<a href="javascript:void(0);" class="btn btn-tool btn-sm" onclick="subcode_detail_form(\'' . 'edit' . '\', \'' . $data['dtmsubcode_id'] . '\' ,\'' . $data['dtmsubcodedtl_id'] . '\')">
                        <i class="fas fa-edit"></i>
                    </a>';
            endif;
            if (checkPermission('MASTERITEM.CODIFICATION.SUBCODEDETAIL.DELETE')) :
                $html .=
                    '<a href="javascript:void(0);" class="btn btn-tool btn-sm" onclick="delete_data(\'' . $data['dtmsubcodedtl_id'] . '\')">
                    <i class="fas fa-trash"></i>
                </a>';
            endif;

            return $html;
        });

        echo $datatables->generate();
    }

    public function subcode_techinformation_ajax()
    {
        $id = $this->input->get('id');

        $datatables = new Datatables(new CodeigniterAdapter);

        $datatables->query(
            "SELECT datatex_m_subcode_tech_information.dtmsubcodetechinf_id, datatex_m_subcode_tech_information.dtmsubcodetechinf_seq, datatex_m_subcode_tech_information.dtmsubcodetechinf_remark, 
            datatex_m_subcode_tech_information.dtmsubcodetechinf_is_required,
            datatex_m_subcode_tech_information.dtmsubcodetechinf_is_active,
            datatex_m_subcode_tech_information.dtmsubcodetechinf_updated_at,
            datatex_m_subcode_tech_information.dtmsubcode_id
            FROM datatex_m_subcode_tech_information
            WHERE datatex_m_subcode_tech_information.dtmsubcode_id = $id"
        );

        $datatables->edit('dtmsubcodetechinf_id', function ($data) {
            $html = '';
            if (checkPermission('MASTERITEM.CODIFICATION.SUBCODEDETAIL.EDIT')) :
                $html .=
                    '<a href="javascript:void(0);" class="btn btn-tool btn-sm" onclick="subcode_techinformation_form(\'' . 'edit' . '\', \'' . $data['dtmsubcode_id'] . '\' ,\'' . $data['dtmsubcodetechinf_id'] . '\')">
                    <i class="fas fa-edit"></i>
                </a>';
            endif;

            if (checkPermission('MASTERITEM.CODIFICATION.SUBCODEDETAIL.DELETE')) :
                $html .=
                    '<a href="javascript:void(0);" class="btn btn-tool btn-sm" onclick="delete_data_techinf(\'' . $data['dtmsubcodetechinf_id'] . '\')">
                    <i class="fas fa-trash"></i>
                </a>';
            endif;

            return $html;
        });

        echo $datatables->generate();
    }

    public function subcode_detail_form()
    {
        $this->load->helper('form');

        $dtmsubcode_id = $this->input->get('dtmsubcode_id');
        $dtmsubcodedtl_id = $this->input->get('dtmsubcodedtl_id');
        $slug = $this->input->get('slug');

        $data['class_link'] = $this->class_link;
        $data['slug'] = $slug;
        $data['dtmsubcode_id'] = $dtmsubcode_id;
        $data['dtmsubcodedtl_id'] = $dtmsubcodedtl_id;

        if ($slug == 'edit') {
            $data['row'] = $this->db->query(
                "SELECT datatex_m_subcode_detail.*, datatex_m_subcode.dtmsubcode_name
                FROM datatex_m_subcode_detail
                LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_subcode_detail.dtmsubcode_option_id
                WHERE dtmsubcodedtl_id = ?",
                array($dtmsubcodedtl_id)
            )->row_array();
        }

        $this->load->view($this->class_link . '/subcode_detail_form', $data);
    }

    public function subcode_techinformation_form()
    {
        $this->load->helper('form');

        $dtmsubcode_id = $this->input->get('dtmsubcode_id');
        $dtmsubcodetechinf_id = $this->input->get('dtmsubcodetechinf_id');
        $slug = $this->input->get('slug');

        $data['class_link'] = $this->class_link;
        $data['slug'] = $slug;
        $data['dtmsubcode_id'] = $dtmsubcode_id;
        $data['dtmsubcodetechinf_id'] = $dtmsubcodetechinf_id;

        if ($slug == 'edit') {
            $data['row'] = $this->db->query(
                "SELECT datatex_m_subcode_tech_information.* 
                FROM datatex_m_subcode_tech_information
                WHERE dtmsubcodetechinf_id = ?",
                array($dtmsubcodetechinf_id)
            )->row_array();
        }

        $this->load->view($this->class_link . '/subcode_techinformation_form', $data);
    }

    public function subcode_techinf()
    {
        parent::baseTemplate();
        parent::datatablesAssets();
        parent::toastAssets();

        $id = $this->input->get('id');
        $idDecode = base64_decode(($id));

        $rowTechInf = $this->db->query(
            "SELECT datatex_m_subcode.dtmsubcode_name, datatex_m_subcode_tech_information.dtmsubcodetechinf_remark
            FROM datatex_m_subcode_tech_information
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_subcode_tech_information.dtmsubcode_id
            WHERE datatex_m_subcode_tech_information.dtmsubcodetechinf_id = ?",
            array($idDecode)
        )->row_array();

        $data['caption'] = "{$rowTechInf['dtmsubcode_name']} -> {$rowTechInf['dtmsubcodetechinf_remark']}";
        $data['class_link'] = $this->class_link;
        $data['id'] = $idDecode;

        $this->load->view($this->class_link . '/subcode_techinf_index', $data);
    }

    public function subcode_techinf_ajax()
    {
        $id = $this->input->get('id');

        $datatables = new Datatables(new CodeigniterAdapter);

        $datatables->query(
            "SELECT datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinfhierarchy_id, datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinfhierarchy_code,
            datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinfhierarchy_name, dtmsubcodetechinfhierarchy_is_active, dtmsubcodetechinfhierarchy_updated_at
            FROM datatex_m_subcode_tech_inf_hierarchy
            WHERE datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinf_id = $id"
        );

        $datatables->edit('dtmsubcodetechinfhierarchy_id', function ($data) {
            $html = '';
            if (checkPermission('MASTERITEM.CODIFICATION.EDIT')) :
                $html .=
                    '<a href="javascript:void(0);" class="btn btn-tool btn-sm" onclick="edit_data(\'' . $data['dtmsubcodetechinfhierarchy_id'] . '\')">
                        <i class="fas fa-edit"></i>
                    </a>';
            endif;
            if (checkPermission('MASTERITEM.CODIFICATION.DELETE')) :
                $html .=
                    ' <a href="javascript:void(0);" class="btn btn-tool btn-sm" onclick="delete_data(\'' . $data['dtmsubcodetechinfhierarchy_id'] . '\')">
                    <i class="fas fa-trash"></i>
                </a>';
            endif;

            return $html;
        });
        $datatables->edit('dtmsubcodehierarchy_is_active', function ($data) {
            return !empty($data['dtmsubcodehierarchy_is_active']) ? 'TRUE' : 'FALSE';
        });

        echo $datatables->generate();
    }

    public function subcode_techinfhierarchy_form()
    {
        $this->load->helper('form');

        $dtmsubcodetechinf_id = $this->input->get('dtmsubcodetechinf_id');
        $dtmsubcodetechinfhierarchy_id = $this->input->get('dtmsubcodetechinfhierarchy_id');
        $slug = $this->input->get('slug');

        $data['class_link'] = $this->class_link;
        $data['slug'] = $slug;
        $data['dtmsubcodetechinf_id'] = $dtmsubcodetechinf_id;
        $data['dtmsubcodetechinfhierarchy_id'] = $dtmsubcodetechinfhierarchy_id;

        if ($slug == 'edit') {
            $data['row'] = $this->db->query(
                "SELECT * 
                FROM datatex_m_subcode_tech_inf_hierarchy
                WHERE dtmsubcodetechinfhierarchy_id = ?",
                array($dtmsubcodetechinfhierarchy_id)
            )->row_array();
        }

        $this->load->view($this->class_link . '/subcode_techinfhierarchy_form', $data);
    }

    public function subcode_techinfhierarchy_formbatch()
    {
        $dtmsubcodetechinf_id = $this->input->get('dtmsubcodetechinf_id');
        $slug = $this->input->get('slug');

        $data['class_link'] = $this->class_link;
        $data['slug'] = $slug;
        $data['dtmsubcodetechinf_id'] = $dtmsubcodetechinf_id;

        $this->load->view($this->class_link . '/subcode_techinfhierarchy_formbatch', $data);
    }

    public function action_submit_techinf()
    {
        $this->load->library(['form_validation']);
        $this->form_validation->set_rules('dtmsubcodetechinf_id', 'Code', 'required');
        $this->form_validation->set_rules('dtmsubcodetechinfhierarchy_code', 'Code', 'required');
        $this->form_validation->set_rules('dtmsubcodetechinfhierarchy_name', 'Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $resp['code'] = 400;
            $resp['messages'] = validation_errors();
        } else {
            $slug = $this->input->post('slug');
            $dtmsubcodetechinfhierarchy_id = $this->input->post('dtmsubcodetechinfhierarchy_id');
            $dtmsubcodetechinf_id = $this->input->post('dtmsubcodetechinf_id');
            $dtmsubcodetechinfhierarchy_code = $this->input->post('dtmsubcodetechinfhierarchy_code');
			$dtmsubcodetechinfhierarchy_code = str_replace(' ', '', $dtmsubcodetechinfhierarchy_code);
            $dtmsubcodetechinfhierarchy_name = $this->input->post('dtmsubcodetechinfhierarchy_name');
            $dtmsubcodetechinfhierarchy_is_active = $this->input->post('dtmsubcodetechinfhierarchy_is_active');

            /** Validation Code */
            $dtmsubcodetechinfhierarchy_code = strtoupper($dtmsubcodetechinfhierarchy_code);
            $techinfhierarchy = $this->db->query(
                "SELECT dtmsubcodetechinfhierarchy_code
                FROM datatex_m_subcode_tech_inf_hierarchy
                WHERE dtmsubcodetechinf_id = ?
                AND dtmsubcodetechinfhierarchy_code = ?",
                array($dtmsubcodetechinf_id, $dtmsubcodetechinfhierarchy_code)
            )->num_rows();
            if (!empty($techinfhierarchy) && $slug == 'add') {
                $resp['code'] = 400;
                $resp['messages'] = 'Code Already Exist';
            } else {
                $arrayTechinfHIerarchy = [
                    'dtmsubcodetechinfhierarchy_code' => $dtmsubcodetechinfhierarchy_code,
                    'dtmsubcodetechinfhierarchy_name' => !empty($dtmsubcodetechinfhierarchy_name) ? $dtmsubcodetechinfhierarchy_name : null,
                    'dtmsubcodetechinf_id' => $dtmsubcodetechinf_id,
                    'dtmsubcodetechinfhierarchy_is_active' => $dtmsubcodetechinfhierarchy_is_active,
                    'dtmsubcodetechinfhierarchy_updated_at' => date('Y-m-d H:i:s'),
                    'dtmsubcodetechinfhierarchy_user_id' => $this->user_id
                ];
                if ($slug == 'add') {
                    $this->db->trans_begin();

                    $this->db->insert('datatex_m_subcode_tech_inf_hierarchy', $arrayTechinfHIerarchy);

                    /** Log */
                    $dataLog = ['datatex_m_subcode_tech_inf_hierarchy' => $arrayTechinfHIerarchy];
                    $this->LogTransactionModel->generateLog($dataLog, 'ADD', $this->user_id);

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
                    $arrayTechinfHIerarchy = $arrayTechinfHIerarchy;
                    $this->db->trans_begin();

                    /** Log */
                    $dataLog = ['datatex_m_subcode_tech_inf_hierarchy' => $arrayTechinfHIerarchy, 'where' => array('dtmsubcodetechinfhierarchy_id' => $dtmsubcodetechinfhierarchy_id)];
                    $this->LogTransactionModel->generateLog($dataLog, 'UPDATE', $this->user_id);

                    $this->db->update('datatex_m_subcode_tech_inf_hierarchy', $arrayTechinfHIerarchy, array('dtmsubcodetechinfhierarchy_id' => $dtmsubcodetechinfhierarchy_id));

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
            }
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    public function action_submit_techinfhierarchy_batch()
    {
        $this->load->library(['form_validation']);
        $this->form_validation->set_rules('dtmsubcodetechinf_id', 'Code', 'required');
        $this->form_validation->set_rules('batchdata', 'Batch Data', 'required');

        $resp = array();
        if ($this->form_validation->run() == FALSE) {
            $resp['code'] = 400;
            $resp['messages'] = validation_errors();
        } else {
            $dtmsubcodetechinf_id = $this->input->post('dtmsubcodetechinf_id');
            $batchdata = $this->input->post('batchdata');

            try {
                /** Split lines */
                $expDataLines = explode(PHP_EOL, $batchdata);
                $countLines = count($expDataLines);

                $dataBatch = array();
                foreach ($expDataLines as $eLine) {
                    $expData = explode(';', $eLine);
                    if (count($expData) == 2) {
                        $dataBatch[] = [
                            'dtmsubcodetechinfhierarchy_code' => trim($expData[0]),
                            'dtmsubcodetechinfhierarchy_name' => trim($expData[1]),
                            'dtmsubcodetechinf_id' => $dtmsubcodetechinf_id,
                            'dtmsubcodetechinfhierarchy_is_active' => true,
                            'dtmsubcodetechinfhierarchy_updated_at' => date('Y-m-d H:i:s'),
                            'dtmsubcodetechinfhierarchy_user_id' => $this->user_id
                        ];
                    }
                }

                /** Check if code already exist */
                $subcodehierarchyExist = $this->db->query(
                    "SELECT dtmsubcodetechinfhierarchy_code
                    FROM datatex_m_subcode_tech_inf_hierarchy
                    WHERE dtmsubcodetechinf_id = ?",
                    array($dtmsubcodetechinf_id)
                )->result_array();
                $subcodehierarchyExistVal = array_column($subcodehierarchyExist, 'dtmsubcodetechinfhierarchy_code');

                $dataBatchReady = array();
                $countDataReady = 0;
                if (!empty($subcodehierarchyExistVal) && !empty($dataBatch)) {
                    for ($i = 0; $i < count($dataBatch); $i++) {
                        if (!in_array($dataBatch[$i]['dtmsubcodetechinfhierarchy_code'], $subcodehierarchyExistVal)) {
                            $dataBatchReady[] = $dataBatch[$i];
                            $countDataReady++;
                        }
                    }
                } else {
                    $dataBatchReady = $dataBatch;
                    $countDataReady = count($dataBatch);
                }

                if (!empty($dataBatchReady)) {
                    $this->db->trans_begin();

                    $this->db->insert_batch('datatex_m_subcode_tech_inf_hierarchy', $dataBatchReady);

                    /** Log */
                    $dataLog = ['datatex_m_subcode_tech_inf_hierarchy' => $dataBatchReady];
                    $this->LogTransactionModel->generateLog($dataLog, 'ADD_BATCH', $this->user_id);

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $resp['code'] = 400;
                        $resp['messages'] = 'Error';
                    } else {
                        $this->db->trans_commit();
                        $resp['code'] = 200;
                        $resp['messages'] = 'Success, Inserted ' . $countDataReady . ' lines';
                    }
                } else {
                    $resp['code'] = 400;
                    $resp['messages'] = 'No data ready to insert';
                }
            } catch (Exception $e) {
                $resp['code'] = 400;
                $resp['messages'] = $e->getMessage();
            }
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    public function action_delete_techinfhierarchy()
    {
        $dtmsubcodetechinfhierarchy_id = $this->input->get('dtmsubcodetechinfhierarchy_id');
        if (!empty($dtmsubcodetechinfhierarchy_id)) {
            $this->db->trans_begin();

            /** Log */
            $dataLog = $this->db->query("SELECT * FROM datatex_m_subcode_tech_inf_hierarchy WHERE dtmsubcodetechinfhierarchy_id = ?", [$dtmsubcodetechinfhierarchy_id])->row_array();
            $dataLog = ['datatex_m_subcode_tech_inf_hierarchy' => $dataLog];
            $this->LogTransactionModel->generateLog($dataLog, 'DELETE', $this->user_id);

            $this->db->delete('datatex_m_subcode_tech_inf_hierarchy', array('dtmsubcodetechinfhierarchy_id' => $dtmsubcodetechinfhierarchy_id));

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

    public function action_submit_detail()
    {
        $this->load->library(['form_validation']);
        $this->form_validation->set_rules('dtmsubcode_id', 'Code', 'required');
        $this->form_validation->set_rules('dtmsubcodedtl_seq', 'Subcode', 'required');
        $this->form_validation->set_rules('dtmsubcodedtl_type', 'Type', 'required');

        if ($this->form_validation->run() == FALSE) {
            $resp['code'] = 400;
            $resp['messages'] = validation_errors();
        } else {
            $slug = $this->input->post('slug');
            $dtmsubcode_id = $this->input->post('dtmsubcode_id');
            $dtmsubcodedtl_id = $this->input->post('dtmsubcodedtl_id');
            $dtmsubcodedtl_seq = $this->input->post('dtmsubcodedtl_seq');
            $dtmsubcodedtl_type = $this->input->post('dtmsubcodedtl_type');
            $dtmsubcode_option_id = $this->input->post('dtmsubcode_option_id');
            $dtmsubcodedtl_remark = $this->input->post('dtmsubcodedtl_remark');
            $dtmsubcodedtl_is_required = $this->input->post('dtmsubcodedtl_is_required');

            /** Validation Code */
            $dtmsubcodedtl_seq = strtoupper($dtmsubcodedtl_seq);
            $subcodedetail = $this->db->query(
                "SELECT dtmsubcodedtl_seq
                FROM datatex_m_subcode_detail
                WHERE dtmsubcode_id = ?
                AND dtmsubcodedtl_seq = ?",
                array($dtmsubcode_id, $dtmsubcodedtl_seq)
            )->num_rows();
            if (!empty($subcodedetail) && $slug == 'add') {
                $resp['code'] = 400;
                $resp['messages'] = 'Code Already Exist';
            } else {
                if ($dtmsubcodedtl_seq > 10) {
                    $resp['code'] = 400;
                    $resp['messages'] = 'Max is 10';
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($resp);
                    exit();
                }

                $arrayDetail = [
                    'dtmsubcodedtl_remark' => $dtmsubcodedtl_remark,
                    'dtmsubcodedtl_is_required' => $dtmsubcodedtl_is_required
                ];
                if ($slug == 'add') {
                    $this->db->trans_begin();

                    $arrayDetail = array_merge($arrayDetail, [
                        'dtmsubcodedtl_seq' => $dtmsubcodedtl_seq,
                        'dtmsubcodedtl_type' => !empty($dtmsubcodedtl_type) ? $dtmsubcodedtl_type : null,
                        'dtmsubcode_id' => $dtmsubcode_id,
                        'dtmsubcode_option_id' => $dtmsubcode_option_id
                    ]);
                    $this->db->insert('datatex_m_subcode_detail', $arrayDetail);

                    /** Log */
                    $dataLog = ['datatex_m_subcode_detail' => $arrayDetail];
                    $this->LogTransactionModel->generateLog($dataLog, 'ADD', $this->user_id);

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
                    $arrayDetail = array_merge($arrayDetail, ['dtmsubcodedtl_updated_at' => date('Y-m-d H:i:s')]);
                    $this->db->trans_begin();

                    /** Log */
                    $dataLog = ['datatex_m_subcode_detail' => $arrayDetail, 'where' => array('dtmsubcodedtl_id' => $dtmsubcodedtl_id)];
                    $this->LogTransactionModel->generateLog($dataLog, 'UPDATE', $this->user_id);

                    $this->db->update('datatex_m_subcode_detail', $arrayDetail, array('dtmsubcodedtl_id' => $dtmsubcodedtl_id));

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
            }
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    public function action_submit_detail_techinformation()
    {
        $this->load->library(['form_validation']);
        $this->form_validation->set_rules('dtmsubcode_id', 'Code', 'required');
        $this->form_validation->set_rules('dtmsubcodetechinf_seq', 'Subcode', 'required');
        $this->form_validation->set_rules('dtmsubcodetechinf_remark', 'Type', 'required');

        if ($this->form_validation->run() == FALSE) {
            $resp['code'] = 400;
            $resp['messages'] = validation_errors();
        } else {
            $slug = $this->input->post('slug');
            $dtmsubcode_id = $this->input->post('dtmsubcode_id');
            $dtmsubcodetechinf_id = $this->input->post('dtmsubcodetechinf_id');
            $dtmsubcodetechinf_seq = $this->input->post('dtmsubcodetechinf_seq');
            $dtmsubcodetechinf_remark = $this->input->post('dtmsubcodetechinf_remark');
            $dtmsubcodetechinf_is_required = $this->input->post('dtmsubcodetechinf_is_required');
            $dtmsubcodetechinf_is_active = $this->input->post('dtmsubcodetechinf_is_active');

            /** Validation Code */
            $dtmsubcodetechinf_seq = strtoupper($dtmsubcodetechinf_seq);
            $subcodetechinformation = $this->db->query(
                "SELECT dtmsubcodetechinf_seq
                FROM datatex_m_subcode_tech_information
                WHERE dtmsubcode_id = ?
                AND dtmsubcodetechinf_seq = ?",
                array($dtmsubcode_id, $dtmsubcodetechinf_seq)
            )->num_rows();
            if (!empty($subcodetechinformation) && $slug == 'add') {
                $resp['code'] = 400;
                $resp['messages'] = 'Code Already Exist';
            } else {
                $arrayDetail = [
                    'dtmsubcodetechinf_remark' => !empty($dtmsubcodetechinf_remark) ? $dtmsubcodetechinf_remark : null,
                    'dtmsubcodetechinf_is_required' => $dtmsubcodetechinf_is_required,
                    'dtmsubcodetechinf_is_active' => $dtmsubcodetechinf_is_active,
                ];
                if ($slug == 'add') {
                    try {
                        $this->db->trans_begin();

                        $arrayDetail = array_merge(
                            $arrayDetail,
                            [
                                'dtmsubcode_id' => $dtmsubcode_id,
                                'dtmsubcodetechinf_seq' => $dtmsubcodetechinf_seq,
                                'dtmsubcodetechinf_updated_at' => date('Y-m-d H:i:s'), 'dtmsubcodetechinf_user_id' => $this->user_id
                            ]
                        );
                        $this->db->insert('datatex_m_subcode_tech_information', $arrayDetail);

                        /** Log */
                        $dataLog = ['datatex_m_subcode_tech_information' => $arrayDetail];
                        $this->LogTransactionModel->generateLog($dataLog, 'ADD', $this->user_id);

                        if ($this->db->trans_status() === FALSE) {
                            $this->db->trans_rollback();
                            $resp['code'] = 400;
                            $resp['messages'] = 'Error';
                        } else {
                            $this->db->trans_commit();
                            $resp['code'] = 200;
                            $resp['messages'] = 'Success';
                        }
                    } catch (Exception $e) {
                        $resp['code'] = 400;
                        $resp['messages'] = $e->getMessage();
                    }
                } else {
                    /** Edit */
                    $this->db->trans_begin();

                    $arrayDetail = array_merge($arrayDetail, ['dtmsubcodetechinf_updated_at' => date('Y-m-d H:i:s'), 'dtmsubcodetechinf_user_id' => $this->user_id]);

                    /** Log */
                    $dataLog = ['datatex_m_subcode_tech_information' => $arrayDetail, 'where' => array('dtmsubcodetechinf_id' => $dtmsubcodetechinf_id)];
                    $this->LogTransactionModel->generateLog($dataLog, 'UPDATE', $this->user_id);

                    $this->db->update('datatex_m_subcode_tech_information', $arrayDetail, array('dtmsubcodetechinf_id' => $dtmsubcodetechinf_id));

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
            }
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    public function action_delete_detail()
    {
        $dtmsubcodedtl_id = $this->input->get('dtmsubcodedtl_id');
        if (!empty($dtmsubcodedtl_id)) {
            $this->db->trans_begin();

            /** Log */
            $dataLog = $this->db->query("SELECT * FROM datatex_m_subcode_detail WHERE dtmsubcodedtl_id = ?", [$dtmsubcodedtl_id])->row_array();
            $dataLog = ['datatex_m_subcode_detail' => $dataLog];
            $this->LogTransactionModel->generateLog($dataLog, 'DELETE', $this->user_id);

            $this->db->delete('datatex_m_subcode_detail', array('dtmsubcodedtl_id' => $dtmsubcodedtl_id));

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

    public function action_delete_data_techinf()
    {
        $dtmsubcodetechinf_id = $this->input->get('dtmsubcodetechinf_id');
        if (!empty($dtmsubcodetechinf_id)) {
            $this->db->trans_begin();

            /** Log */
            $dataLog = $this->db->query("SELECT * FROM datatex_m_subcode_tech_information WHERE dtmsubcodetechinf_id = ?", [$dtmsubcodetechinf_id])->row_array();
            $dataLog = ['datatex_m_subcode_tech_information' => $dataLog];
            $this->LogTransactionModel->generateLog($dataLog, 'DELETE', $this->user_id);

            $this->db->delete('datatex_m_subcode_tech_information', array('dtmsubcodetechinf_id' => $dtmsubcodetechinf_id));

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

    public function action_delete_subcode()
    {
        $dtmsubcode_id = $this->input->get('dtmsubcode_id');
        if (!empty($dtmsubcode_id)) {
            $this->db->trans_begin();

            /** Log */
            $dataLog = $this->db->query("SELECT * FROM datatex_m_subcode WHERE dtmsubcode_id = ?", [$dtmsubcode_id])->row_array();
            $dataLog = ['datatex_m_subcode' => $dataLog];
            $this->LogTransactionModel->generateLog($dataLog, 'DELETE', $this->user_id);

            $this->db->delete('datatex_m_subcode', array('dtmsubcode_id' => $dtmsubcode_id));

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

    public function autocomplete_subcode()
    {
        $param_search = $this->input->get('param_search');
        $dtmsubcode_parent = $this->input->get('dtmsubcode_parent');
        $dtmsubcode_level = $this->input->get('dtmsubcode_level');

        $q = "SELECT * FROM datatex_m_subcode WHERE datatex_m_subcode.dtmsubcode_is_active = 1 ";
        if (!empty($dtmsubcode_parent)) {
            $q .= "AND datatex_m_subcode.dtmsubcode_parent = $dtmsubcode_parent ";
        }
        if (!empty($dtmsubcode_level) || $dtmsubcode_level === '0') {
            $q .= "AND datatex_m_subcode.dtmsubcode_level = $dtmsubcode_level ";
        }
        if (!empty($param_search)) {
            $q .= "AND datatex_m_subcode.dtmsubcode_name ILIKE '%$param_search%'";
        }
        $q .= " ORDER BY datatex_m_subcode.dtmsubcode_name ASC";

        $result = $this->db->query($q)->result_array();

        echo json_encode($result);
    }

    public function autocomplete_subcode_hierarchy()
    {
        $param_search = $this->input->get('param_search');
        $dtmsubcode_id = $this->input->get('dtmsubcode_id');
        $dtmsubcodehierarchy_parent = $this->input->get('dtmsubcodehierarchy_parent');

        $bindData = [];
        $q = "SELECT * FROM datatex_m_subcode_hierarchy WHERE datatex_m_subcode_hierarchy.dtmsubcodehierarchy_is_active = 1 AND datatex_m_subcode_hierarchy.dtmsubcodehierarchy_state <> 'reject'";
        if (!empty($dtmsubcode_id)) {
			if ($dtmsubcode_id == 30 OR $dtmsubcode_id == 40){
				$q .= "AND datatex_m_subcode_hierarchy.dtmsubcode_id in (30,40) ";
			} else if ($dtmsubcode_id == 11 OR $dtmsubcode_id == 21 OR $dtmsubcode_id == 29 OR $dtmsubcode_id == 39) {
				$q .= "AND datatex_m_subcode_hierarchy.dtmsubcode_id in (11,21,29,39) ";
			} else {
				$q .= "AND datatex_m_subcode_hierarchy.dtmsubcode_id = $dtmsubcode_id ";
			}
        }
        if (!empty($dtmsubcodehierarchy_parent)) {
            $q .= "AND datatex_m_subcode_hierarchy.dtmsubcodehierarchy_parent = $dtmsubcodehierarchy_parent ";
        }
        if (!empty($param_search)) {
            $q .= "AND (datatex_m_subcode_hierarchy.dtmsubcodehierarchy_name ILIKE ? OR
                datatex_m_subcode_hierarchy.dtmsubcodehierarchy_code ILIKE ?)";
            $bindData = ['%' . $param_search . '%', '%' . $param_search . '%'];
        }
        
        
        $samplevalid = $this->check_sample_status($this->user_id);
       
        if ($samplevalid == 1) {
            $q .= "union select * from datatex_m_subcode_hierarchy where dtmsubcode_id = $dtmsubcode_id and dtmsubcodehierarchy_code = 'SAAAM'";
        } else {
            $q .= "and dtmsubcodehierarchy_code <> 'SAAAM' ORDER BY datatex_m_subcode_hierarchy.dtmsubcodehierarchy_code ASC";
        }
       
        
        $result = $this->db->query($q, $bindData)->result_array();

        echo json_encode($result);
    }

    public function check_sample_status($user){
		$query = $this->db->query("SELECT coalesce(sample_id_status,0) sample_id_status FROM datatex_hierarchy_md_sample WHERE user_id = $user");
    
		$row = $query->row();
		return $row->sample_id_status;
	}
}

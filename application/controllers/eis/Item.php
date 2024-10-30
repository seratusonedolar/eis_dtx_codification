<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
use FuzzyWuzzy\Fuzz;
use FuzzyWuzzy\Process;

class Item extends MY_Controller
{
    private $class_link = 'eis/item';

    public function index()
    {
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
            "SELECT m_item.item_id, datatex_scope_item.dtscopeitem_buyer_ids, datatex_m_subcode_hierarchy.dtmsubcodehierarchy_name, m_classification.name, m_subclassification.name as subclassname, 
                m_item.content_name, m_item.material_name, m_item.reference_name, m_item.color_name,
                m_item.construction_name, m_item.spec_type, m_item.spec_name, m_item.item_type, m_item.source, m_item.um_id
            FROM datatex_scope_item
            LEFT JOIN m_item ON m_item.item_id=datatex_scope_item.item_id
            LEFT JOIN datatex_m_item ON datatex_m_item.item_id=m_item.item_id
            LEFT JOIN m_classification ON m_classification.classif_id=m_item.classif_id
            LEFT JOIN m_subclassification ON m_subclassification.subclassif_id=m_item.subclassif_id
            LEFT JOIN datatex_m_subcode_hierarchy ON datatex_m_subcode_hierarchy.dtmsubcodehierarchy_id = datatex_scope_item.dtmsubcodehierarchy_id
            WHERE datatex_m_item.item_id IS NULL "
        );

        $datatables->edit('item_id', function ($data) {
            return '<a href="javascript:void(0);" onclick="edit_data(\'' . $data['item_id'] . '\')"> <strong>' . $data['item_id'] . '</strong> </a>';
        });

        echo $datatables->generate();
    }

    public function form_main()
    {
        $item_id = $this->input->get('item_id');

        $data['class_link'] = $this->class_link;
        $data['eis_item'] = $this->db->query(
            "SELECT m_item.*, m_classification.name as classif_name, m_subclassification.name as subclassif_name, m_um.name as um_name
            FROM m_item
            LEFT JOIN m_classification ON m_classification.classif_id=m_item.classif_id
            LEFT JOIN m_subclassification ON m_subclassification.subclassif_id=m_item.subclassif_id
            LEFT JOIN m_um ON m_um.um_id=m_item.um_id
            WHERE m_item.item_id = ?",
            array($item_id)
        )->row_array();

        // HARDCODING on Datatex0 is RAWMATERIAL
        $data['selected'] = $this->db->query("SELECT * FROM datatex_m_subcode WHERE dtmsubcode_name = 'RAWMATERIAL'")->row_array();

        /** Get Unprocessed in scope, with same parent id */
        $qParentRelated =  $this->db->query(
            "SELECT datatex_scope_item.dtscopeitem_id, m_item.parent_item_id
            FROM datatex_scope_item 
            LEFT JOIN m_item ON m_item.item_id = datatex_scope_item.item_id
            LEFT JOIN datatex_m_item ON datatex_m_item.item_id = datatex_scope_item.item_id
            WHERE datatex_m_item.item_id IS NULL
            AND m_item.parent_item_id = (SELECT mi2.parent_item_id FROM m_item mi2 WHERE mi2.item_id = ?)",
            array($item_id)
        );
        $data['parentRelated']['count'] = $qParentRelated->num_rows();
        $data['parentRelated']['item_id'] = $item_id;

        $this->load->view($this->class_link . '/form_main', $data);
    }

    public function form_subcode()
    {
        $dtmsubcode_id = $this->input->get('dtmsubcode_id');

        $result = $this->db->query(
            "SELECT datatex_m_subcode_detail.*, datatex_m_subcode.dtmsubcode_name 
            FROM datatex_m_subcode_detail 
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_subcode_detail.dtmsubcode_option_id
            WHERE datatex_m_subcode_detail.dtmsubcode_id = ?
            ORDER BY datatex_m_subcode_detail.dtmsubcodedtl_seq ASC",
            array($dtmsubcode_id)
        )->result_array();

        $data['result'] = $result;
        $data['dtmsubcode_id'] = $dtmsubcode_id;
        $data['class_link'] = $this->class_link;

        $this->load->view($this->class_link . '/form_subcode', $data);
    }

    public function form_techinf()
    {
        $dtmsubcode_id = $this->input->get('dtmsubcode_id');

        $result = $this->db->query(
            "SELECT datatex_m_subcode_tech_information.*, datatex_m_subcode.dtmsubcode_name 
            FROM datatex_m_subcode_tech_information 
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_subcode_tech_information.dtmsubcode_id
            WHERE datatex_m_subcode_tech_information.dtmsubcode_id = ?
            ORDER BY datatex_m_subcode_tech_information.dtmsubcodetechinf_seq ASC",
            array($dtmsubcode_id)
        )->result_array();

        $data['result'] = $result;

        $this->load->view($this->class_link . '/form_techinf', $data);
    }

    /** option in technical information */
    public function form_techinf_v2()
    {
        $dtmsubcode_id = $this->input->get('dtmsubcode_id');

        $result = $this->db->query(
            "SELECT datatex_m_subcode_tech_information.*, datatex_m_subcode.dtmsubcode_name 
            FROM datatex_m_subcode_tech_information 
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_subcode_tech_information.dtmsubcode_id
            WHERE datatex_m_subcode_tech_information.dtmsubcode_id = ?
            AND datatex_m_subcode_tech_information.dtmsubcodetechinf_is_active = ?
            ORDER BY datatex_m_subcode_tech_information.dtmsubcodetechinf_seq ASC",
            array($dtmsubcode_id, true)
        )->result_array();

        $data['class_link'] = $this->class_link;
        $data['result'] = $result;

        $this->load->view($this->class_link . '/form_techinf_v2', $data);
    }

    public function form_otherinf()
    {
        $dtmsubcode_id = $this->input->get('dtmsubcode_id');
        $item_id = $this->input->get('item_id');

        if (!empty($item_id)) {

            $data['row'] = $this->db->query(
                "SELECT m_item.*, m_um.name as um_name 
                FROM m_item 
                LEFT JOIN m_um ON m_um.um_id=m_item.um_id
                WHERE m_item.item_id = ?",
                array($item_id)
            )->row_array();
        }

        $data['class_link'] = $this->class_link;

        $this->load->view($this->class_link . '/form_otherinf', $data);
    }

    /** Batch process */
    public function ajax_itemprocessed()
    {
        $datatables = new Datatables(new CodeigniterAdapter);

        $query =
            "SELECT datatex_m_item.dtmitem_id, datatex_m_item.dtmitem_code, datatex_m_subcode.dtmsubcode_name, m_item.item_id, datatex_scope_item.dtscopeitem_buyer_ids, m_classification.name, m_subclassification.name as subclassname, 
            m_item.content_name, m_item.material_name, m_item.reference_name, m_item.color_name,
            m_item.construction_name, m_item.spec_type, m_item.spec_name, m_item.item_type, m_item.source, m_item.um_id, datatex_m_item.dtmitem_created_by, datatex_m_item.dtmitem_created_at
            FROM datatex_m_item
            LEFT JOIN m_item ON m_item.item_id=datatex_m_item.item_id
            LEFT JOIN m_classification ON m_classification.classif_id=m_item.classif_id
            LEFT JOIN m_subclassification ON m_subclassification.subclassif_id=m_item.subclassif_id
            LEFT JOIN datatex_scope_item ON datatex_scope_item.item_id=datatex_m_item.item_id
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_item.dtmsubcode_id ";
        $datatables->query($query);

        $datatables->edit('dtmitem_id', function ($data) {
            return '<input type="radio" name="dtmitem_id" value="' . $data['dtmitem_id'] . '" >';
        });

        echo $datatables->generate();
    }

    public function ajax_item()
    {
        $datatables = new Datatables(new CodeigniterAdapter);

        $datatables->query(
            "SELECT m_item.item_id as id, m_item.item_id, datatex_scope_item.dtscopeitem_buyer_ids, datatex_m_subcode_hierarchy.dtmsubcodehierarchy_name, m_classification.name, m_subclassification.name as subclassname, 
                m_item.content_name, m_item.material_name, m_item.reference_name, m_item.color_name,
                m_item.construction_name, m_item.spec_type, m_item.spec_name, m_item.item_type, m_item.source, m_item.um_id
            FROM datatex_scope_item
            LEFT JOIN m_item ON m_item.item_id=datatex_scope_item.item_id
            LEFT JOIN datatex_m_item ON datatex_m_item.item_id=m_item.item_id
            LEFT JOIN m_classification ON m_classification.classif_id=m_item.classif_id
            LEFT JOIN m_subclassification ON m_subclassification.subclassif_id=m_item.subclassif_id
            LEFT JOIN datatex_m_subcode_hierarchy ON datatex_m_subcode_hierarchy.dtmsubcodehierarchy_id = datatex_scope_item.dtmsubcodehierarchy_id
            WHERE datatex_m_item.item_id IS NULL "
        );

        $datatables->edit('id', function ($data) {
            return '<input type="checkbox" class="clCheckboxItem" name="item_ids[]" value="' . $data['item_id'] . '" >';
        });

        echo $datatables->generate();
    }

    function formbatch_main()
    {
        $data['class_link'] = $this->class_link;

        $this->load->view($this->class_link . '/formbatch_main', $data);
    }

    function formbatch_tblitemprocessed()
    {
        $data['class_link'] = $this->class_link;

        $this->load->view($this->class_link . '/formbatch_tblitemprocessed', $data);
    }

    public function action_submit_batch()
    {
        $this->load->library(['form_validation']);

        $this->form_validation->set_rules('dtmitem_id', 'Item Processd', 'required');

        if ($this->form_validation->run() == FALSE) {
            $resp['code'] = 400;
            $resp['messages'] = validation_errors();
        } else {
            $dtmitem_id = $this->input->post('dtmitem_id');
            $item_ids = $this->input->post('item_ids');

            if (empty($item_ids)) {
                $resp['code'] = 400;
                $resp['messages'] = "No EIS Item Selected";
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($resp);
                exit();
            } elseif (count($item_ids) > 50) {
                $resp['code'] = 400;
                $resp['messages'] = "EIS Item Selected more than 50 Item, you're selected " . count($item_ids);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($resp);
                exit();
            }

            $dtmitemRow = $this->db->query(
                "SELECT * FROM datatex_m_item WHERE dtmitem_id = ?",
                [$dtmitem_id]
            )->row_array();

            $dtmitemDetails = $this->db->query(
                "SELECT * FROM datatex_m_item_detail WHERE dtmitem_id = ?",
                [$dtmitem_id]
            )->result_array();

            $dtmitemTechInfs = $this->db->query(
                "SELECT * FROM datatex_m_item_tech_information WHERE dtmitem_id = ?",
                [$dtmitem_id]
            )->result_array();

            $this->db->trans_begin();

            for ($i = 0; $i < count($item_ids); $i++) {
                // datatex_m_item
                $arrayMitem = [
                    'item_id' => $item_ids[$i],
                    'dtmitem_code' => $dtmitemRow['dtmitem_code'],
                    'dtmsubcode_id' => $dtmitemRow['dtmsubcode_id'],
                    'dtmitem_updated_at' => date('Y-m-d H:i:s'),
                    'dtmitem_created_by' => isset($this->user_id) ? $this->user_id : null,
                    'dtmitem_uom_id' => $dtmitemRow['dtmitem_uom_id'],
                    'dtmitem_description' => $dtmitemRow['dtmitem_description']
                ];
                $this->db->insert('datatex_m_item', $arrayMitem);
                $dtmitem_id = $this->db->insert_id();


                // datatex_m_item_detail
                $arrayMitemDetail = [];
                foreach ($dtmitemDetails as $eDtmitemDetail) {
                    $arrayMitemDetail[] = [
                        'dtmitem_id' => $dtmitem_id,
                        'dtmsubcodedtl_id' => $eDtmitemDetail['dtmsubcodedtl_id'],
                        'dtmsubcodehierarchy_id' =>  $eDtmitemDetail['dtmsubcodehierarchy_id'],
                        'dtmitemdtl_code' => $eDtmitemDetail['dtmitemdtl_code']
                    ];
                }
                $this->db->insert_batch('datatex_m_item_detail', $arrayMitemDetail);

                // datatex_m_item_tech_information
                $arrayTechInfs = [];
                foreach ($dtmitemTechInfs as $eDtmitemTechInf) {
                    $arrayTechInfs[] = [
                        'dtmitem_id' => $dtmitem_id,
                        'dtmsubcodetechinf_id' => $eDtmitemTechInf['dtmsubcodetechinf_id'],
                        'dtmitemtechinf_note' => $eDtmitemTechInf['dtmitemtechinf_note'],
                        'dtmsubcodetechinfhierarchy_id' => $eDtmitemTechInf['dtmsubcodetechinfhierarchy_id'],
                    ];
                }
                $this->db->insert_batch('datatex_m_item_tech_information', $arrayTechInfs);

				$arrayMitemUpdate[] = [
					'item_id' => $item_ids[$i],
					'item_status' => 0
				];
            }
			// MITEM status update
			$this->db->update_batch('m_item', $arrayMitemUpdate, 'item_id');

            // Logging
            $dataLog = [
                'dtmitemlog_data' => json_encode([
                    'datatex_m_item' => $arrayMitem,
                    'datatex_m_item_detail' => $arrayMitemDetail,
                    'datatex_m_item_tech_information' => $arrayTechInfs
                ]),
                'dtmitemlog_action' => 'INSERT_BATCH',
                'dtmitemlog_created_by' => isset($this->user_id) && !empty($this->user_id) ? $this->user_id : null
            ];
            $this->db->insert('datatex_m_item_log', $dataLog);

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

    function formbatch_tblitem()
    {
        $data['class_link'] = $this->class_link;

        $this->load->view($this->class_link . '/formbatch_tblitem', $data);
    }

    public function autocomplete_uom()
    {
        $param_search = $this->input->get('param_search');

        $q = "SELECT datatex_eis_uom.*, datatex_eis_uom.dtxuom_code as um_id, CONCAT(datatex_eis_uom.dtxuom_code, ' | ', datatex_eis_uom.dtxuom_eiscode, ' | ', datatex_eis_uom.dtxuom_name) as um_text  
        FROM datatex_eis_uom WHERE dtxuom_status=1 and 1 = 1 ";
        if (!empty($param_search)) {
            $q .= "AND (datatex_eis_uom.dtxuom_code ILIKE '%$param_search%' 
                        OR datatex_eis_uom.dtxuom_eiscode ILIKE '%$param_search%'
                        OR datatex_eis_uom.dtxuom_name ILIKE '%$param_search%')";
        }
        $q .= " ORDER BY datatex_eis_uom.dtxuom_eiscode ASC";

        $result = $this->db->query($q)->result_array();

        echo json_encode($result);
    }

    public function autocomplete_techinf_hierarchy()
    {
        $param_search = $this->input->get('param_search');
        $dtmsubcodetechinf_id = $this->input->get('dtmsubcodetechinf_id');

        $bindArray = [];
        $q = "SELECT * FROM datatex_m_subcode_tech_inf_hierarchy WHERE datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinfhierarchy_is_active = true ";
        if (!empty($dtmsubcodetechinf_id)) {
			if($dtmsubcodetechinf_id == 35 OR $dtmsubcodetechinf_id == 36 OR $dtmsubcodetechinf_id == 37 OR $dtmsubcodetechinf_id == 38 OR $dtmsubcodetechinf_id == 39 OR $dtmsubcodetechinf_id == 40){
				$q .= "AND datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinf_id in (35,36,37,38,39,40) 
                       and datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinfhierarchy_state!='reject'";
			}else {
				$q .= "AND datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinf_id = $dtmsubcodetechinf_id 
					   and datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinfhierarchy_state!='reject'";
			}
        }
        if (!empty($param_search)) {
            $q .= "AND (datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinfhierarchy_name ILIKE ? OR
                datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinfhierarchy_code ILIKE ?)";
            $bindArray = ['%' . $param_search . '%', '%' . $param_search . '%'];
        }
        $q .= " ORDER BY datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinfhierarchy_name ASC";
        $result = $this->db->query($q, $bindArray)->result_array();

        echo json_encode($result);
    }

    /** Fuzzywuzzy autocomplete */
    public function generate_suggestion_subcode()
    {
        $item_id = $this->input->get('item_id');
        $dtmsubcode_id = $this->input->get('dtmsubcode_id');

        try {
            $item =  $this->db->query(
                "SELECT m_item.* 
                FROM m_item
                WHERE m_item.item_id = ?",
                array($item_id)
            )->row_array();

            /** Get subcode with type OPTION */
            $subcodeOption = $this->db->query(
                "SELECT datatex_m_subcode_detail.*, datatex_m_subcode_hierarchy.*, datatex_m_subcode.dtmsubcode_name
                FROM datatex_m_subcode_detail
                LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id = datatex_m_subcode_detail.dtmsubcode_option_id
                LEFT JOIN datatex_m_subcode_hierarchy ON datatex_m_subcode_hierarchy.dtmsubcode_id=datatex_m_subcode.dtmsubcode_id
                WHERE datatex_m_subcode_detail.dtmsubcode_id = ? AND datatex_m_subcode_detail.dtmsubcodedtl_type = ?
                AND datatex_m_subcode_hierarchy.dtmsubcodehierarchy_is_active = ?
                ORDER BY datatex_m_subcode_detail.dtmsubcodedtl_seq ASC",
                array($dtmsubcode_id, 'OPTION', 1)
            )->result_array();

            /** > Group by seq */
            $groupBySeq = array();
            foreach ($subcodeOption as $eOption) {
                /** Except attribute Seq */
                if (strpos(strtoupper($eOption['dtmsubcode_name']), 'SEQ') !== false) {
                    continue;
                }

                $groupBySeq[$eOption['dtmsubcodedtl_seq']][] = $eOption;
            }

            $arrayFuzz = array();
            $arrayGroupByHierarchyName = array();

            $fuzz = new Fuzz;
            $process = new Process($fuzz);
            foreach ($groupBySeq as $seq => $elements) {
                /** array gorup by (dtmsubcodehierarchy_name) for search ID after fuzz */
                foreach ($elements as $el) {
                    $arrayGroupByHierarchyName[$el['dtmsubcodehierarchy_name']] = [
                        'dtmsubcodehierarchy_id' => $el['dtmsubcodehierarchy_id'],
                        'dtmsubcodehierarchy_code' => $el['dtmsubcodehierarchy_code']
                    ];
                }

                $fuzzresult = $process->extractOne($item['name'], array_column($elements, 'dtmsubcodehierarchy_name'), null, [$fuzz, 'tokenSetRatio']);
                // $fuzzresult = $process->extract($item['name'], array_column($elements, 'dtmsubcodehierarchy_name'), null, null, 5);

                $fuzzresult_id = 'NA';
                $fuzzresult_text = 'NA';
                $fuzzresult_score = 0;
                $fuzzresult_text_select2 = 'NA | NA';
                $fuzzresult_code = 'NA';
                if (!empty($fuzzresult)) {
                    $fuzzresult_score = $fuzzresult[1];
                    /** Min Score */
                    if ($fuzzresult_score >= (int) getenv('FUZZY_MIN_SCORE')) {
                        $fuzzresult_text = $fuzzresult[0];
                        $fuzzresult_code = $arrayGroupByHierarchyName[$fuzzresult_text]['dtmsubcodehierarchy_code'];
                        $fuzzresult_text_select2 = $fuzzresult_code . ' | ' . $fuzzresult_text;
                        $fuzzresult_id = $arrayGroupByHierarchyName[$fuzzresult_text]['dtmsubcodehierarchy_id'];
                        $arrayFuzz[] = [
                            'item_name' => $item['name'],
                            // 'dtmsubcodehierarchy_names' => array_column($elements, 'dtmsubcodehierarchy_name'),
                            'dtmsubcodedtl_seq' => $seq,
                            'fuzzresult_text' => $fuzzresult_text,
                            'fuzzresult_score' => $fuzzresult_score,
                            'fuzzresult_id' => $fuzzresult_id,
                            'fuzzresult_code' => $fuzzresult_code,
                            'fuzzresult_text_select2' => $fuzzresult_text_select2,
                        ];
                    }
                }
            }
            $resp['code'] = 200;
            $resp['messages'] = 'Success';
            $resp['data'] = $arrayFuzz;
        } catch (Exception $e) {
            $resp['code'] = 400;
            $resp['messages'] = 'Error';
            $resp['data'] = [];
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    /** autocomplete size */
    public function generate_suggestion_size()
    {
        $jsonDtscopeitem_ids = $this->input->get('dtscopeitem_ids');
        $dtmitem_id = $this->input->get('dtmitem_id');

        if (empty(json_decode($jsonDtscopeitem_ids))) {
            $resp['code'] = 400;
            $resp['messages'] = 'Empty ID Selected';
            $resp['data'] = [];

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($resp);
            exit();
        }

        try {
            $datatexItem =  $this->db->query(
                "SELECT datatex_m_item.*
                FROM datatex_m_item
                WHERE datatex_m_item.dtmitem_id = ?",
                array($dtmitem_id)
            )->row();

            $items =  $this->db->query(
                "SELECT datatex_scope_item.dtscopeitem_id, datatex_scope_item.item_id, m_item.spec_name
                FROM datatex_scope_item
                LEFT JOIN m_item ON m_item.item_id = datatex_scope_item.item_id
                WHERE datatex_scope_item.dtscopeitem_id IN ?",
                array(json_decode($jsonDtscopeitem_ids))
            )->result_array();

            $spec_names = array_column($items, 'spec_name');

            // HACK for size
            $hierarchySize = $this->db->query(
                "SELECT datatex_m_subcode_hierarchy.* FROM datatex_m_subcode_hierarchy
                LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_subcode_hierarchy.dtmsubcode_id
                WHERE datatex_m_subcode.dtmsubcode_parent = ?
                AND datatex_m_subcode_hierarchy.dtmsubcode_id = (SELECT v.dtmsubcode_id FROM datatex_m_subcode v WHERE v.dtmsubcode_parent = ? AND UPPER(V.dtmsubcode_name) = ?)
                AND datatex_m_subcode_hierarchy.dtmsubcodehierarchy_name IN ?
                AND datatex_m_subcode_hierarchy.dtmsubcodehierarchy_is_active = ?",
                array($datatexItem->dtmsubcode_id, $datatexItem->dtmsubcode_id, 'SIZE', $spec_names, 1)
            )->result();

            $arrayResult = array();
            foreach ($items as $eItem) {
                foreach ($hierarchySize as $hSize) {
                    if ($hSize->dtmsubcodehierarchy_name == $eItem['spec_name']) {
                        $arrayResult[] = [
                            'dtscopeitem_id' => $eItem['dtscopeitem_id'],
                            'item_id' => $eItem['item_id'],
                            'dtmsubcodehierarchy_id' => $hSize->dtmsubcodehierarchy_id,
                            'dtmsubcodehierarchy_code' => $hSize->dtmsubcodehierarchy_code,
                            'dtmsubcodehierarchy_name' => $hSize->dtmsubcodehierarchy_name,
                        ];
                    } else {
                        continue;
                    }
                }
            }

            $resp['code'] = 200;
            $resp['messages'] = 'Search Size Completed';
            $resp['data'] = $arrayResult;
        } catch (Exception $e) {
            $resp['code'] = 400;
            $resp['messages'] = 'Error';
            $resp['data'] = [];
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    /** autocomplete color */
    public function generate_suggestion_color()
    {
        $jsonDtscopeitem_ids = $this->input->get('dtscopeitem_ids');
        $dtmitem_id = $this->input->get('dtmitem_id');

        if (empty(json_decode($jsonDtscopeitem_ids))) {
            $resp['code'] = 400;
            $resp['messages'] = 'Empty ID Selected';
            $resp['data'] = [];

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($resp);
            exit();
        }

        try {
            $datatexItem =  $this->db->query(
                "SELECT datatex_m_item.*
                FROM datatex_m_item
                WHERE datatex_m_item.dtmitem_id = ?",
                array($dtmitem_id)
            )->row();

            $items =  $this->db->query(
                "SELECT datatex_scope_item.dtscopeitem_id, datatex_scope_item.item_id, m_item.color_name
                FROM datatex_scope_item
                LEFT JOIN m_item ON m_item.item_id = datatex_scope_item.item_id
                WHERE datatex_scope_item.dtscopeitem_id IN ?",
                array(json_decode($jsonDtscopeitem_ids))
            )->result_array();

            $color_names = array_column($items, 'color_name');

            // HACK for size
            $hierarchyColor = $this->db->query(
                "SELECT datatex_m_subcode_hierarchy.* FROM datatex_m_subcode_hierarchy
                LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_subcode_hierarchy.dtmsubcode_id
                WHERE datatex_m_subcode.dtmsubcode_parent = ?
                AND datatex_m_subcode_hierarchy.dtmsubcode_id = (SELECT v.dtmsubcode_id FROM datatex_m_subcode v WHERE v.dtmsubcode_parent = ? AND UPPER(V.dtmsubcode_name) = ?)
                AND datatex_m_subcode_hierarchy.dtmsubcodehierarchy_name IN ?
                AND datatex_m_subcode_hierarchy.dtmsubcodehierarchy_is_active = ?",
                array($datatexItem->dtmsubcode_id, $datatexItem->dtmsubcode_id, 'COLOR', $color_names, 1)
            )->result();

            $arrayResult = array();
            foreach ($items as $eItem) {
                foreach ($hierarchyColor as $hSize) {
                    if ($hSize->dtmsubcodehierarchy_name == $eItem['color_name']) {
                        $arrayResult[] = [
                            'dtscopeitem_id' => $eItem['dtscopeitem_id'],
                            'item_id' => $eItem['item_id'],
                            'dtmsubcodehierarchy_id' => $hSize->dtmsubcodehierarchy_id,
                            'dtmsubcodehierarchy_code' => $hSize->dtmsubcodehierarchy_code,
                            'dtmsubcodehierarchy_name' => $hSize->dtmsubcodehierarchy_name,
                        ];
                    } else {
                        continue;
                    }
                }
            }

            $resp['code'] = 200;
            $resp['messages'] = 'Search Color Completed';
            $resp['data'] = $arrayResult;
        } catch (Exception $e) {
            $resp['code'] = 400;
            $resp['messages'] = 'Error';
            $resp['data'] = [];
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    /* + Auto increment unutk special methode, special condifition where :
        1. type = text
        2. name containe SEQ 
       + Metode dengan update after insert on this subcode
    */
    private function get_lastSeq()
    {
        $lastSeq = 1;
        $dtmitemDtl = $this->db->query(
            "SELECT datatex_m_item_detail.dtmitemdtl_code as max_code
            FROM datatex_m_item_detail
            LEFT JOIN datatex_m_subcode_detail ON datatex_m_subcode_detail.dtmsubcodedtl_id = datatex_m_item_detail.dtmsubcodedtl_id 
            WHERE datatex_m_subcode_detail.dtmsubcodedtl_remark ILIKE '%SEQ%'
            ORDER BY datatex_m_item_detail.dtmitemdtl_id DESC 
            LIMIT 1
            "
        )->row_array();
        if (!empty($dtmitemDtl)) {
            $lastSeq = (int) $dtmitemDtl['max_code'] + 1;
        }

        return $lastSeq;
    }

    private function generate_autoincrement_seq($dtmitem_id, $lastSeq)
    {
        $dtmitem = $this->db->query(
            "SELECT * 
            FROM datatex_m_item
            WHERE dtmitem_id = ? 
            ",
            array($dtmitem_id)
        )->row_array();

        $dtmitemDtl = $this->db->query(
            "SELECT datatex_m_item_detail.* 
            FROM datatex_m_item_detail
            LEFT JOIN datatex_m_subcode_detail ON datatex_m_subcode_detail.dtmsubcodedtl_id = datatex_m_item_detail.dtmsubcodedtl_id 
            WHERE datatex_m_item_detail.dtmitem_id = ?
            AND datatex_m_subcode_detail.dtmsubcodedtl_remark ILIKE '%SEQ%'
            ",
            array($dtmitem_id)
        )->row_array();

        if (!empty($dtmitemDtl)) {
            $this->db->trans_begin();

            /* Update dttex_m_item_detail */
            $arrayDetail = ['dtmitemdtl_code' => $lastSeq];
            $this->db->update('datatex_m_item_detail', $arrayDetail, array('dtmsubcodedtl_id' => $dtmitemDtl['dtmsubcodedtl_id']));

            // /* Update dttex_m_item */
            $arrayMitemDetail = $this->db->query(
                "SELECT datatex_m_item_detail.* 
                FROM datatex_m_item_detail 
                LEFT JOIN datatex_m_subcode_detail ON datatex_m_subcode_detail.dtmsubcodedtl_id = datatex_m_item_detail.dtmsubcodedtl_id 
                WHERE datatex_m_item_detail.dtmitem_id = ?
                ORDER BY datatex_m_subcode_detail.dtmsubcodedtl_seq ASC",
                array($dtmitem['dtmitem_id'])
            )->result_array();
            $arrayMitem = ['dtmitem_code' => $this->generate_datatech_code($dtmitem['dtmsubcode_id'], $arrayMitemDetail)];
            $this->db->update('datatex_m_item', $arrayMitem, array('dtmitem_id' => $dtmitem['dtmitem_id']));

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } else {
            return true;
        }
    }


    private function generate_datatech_code($dtmsubcode_id1, $arrayMitemDetail)
    {
        $arrayCode = array_column($arrayMitemDetail, 'dtmitemdtl_code');

        $dtmsubcodelv1 = $this->db->query(
            "SELECT dtmsubcode_code
                    FROM datatex_m_subcode
                    WHERE dtmsubcode_id = ?",
            array($dtmsubcode_id1)
        )->row_array();
        $code = $dtmsubcodelv1['dtmsubcode_code'] . '-' . implode('-', $arrayCode);

        return $code;
    }

    public function action_submit()
    {
        $dtmsubcode_id1 = $this->input->post('dtmsubcode_id1');
        $subcodedetails = $this->db->query(
            "SELECT datatex_m_subcode_detail.*, datatex_m_subcode.dtmsubcode_name
            FROM datatex_m_subcode_detail
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id = datatex_m_subcode_detail.dtmsubcode_option_id
            WHERE datatex_m_subcode_detail.dtmsubcode_id = ?
            ORDER BY datatex_m_subcode_detail.dtmsubcodedtl_seq ASC",
            array($dtmsubcode_id1)
        )->result_array();

        $itemTechInfs = $this->db->query(
            "SELECT datatex_m_subcode_tech_information.*
            FROM datatex_m_subcode_tech_information
            WHERE datatex_m_subcode_tech_information.dtmsubcode_id = ?",
            array($dtmsubcode_id1)
        )->result_array();

        $this->load->library(['form_validation']);

        $this->form_validation->set_rules('dtmsubcode_id1', 'Classif', 'required');
        $this->form_validation->set_rules('txtitem_id', 'No Srj', 'required');
        $this->form_validation->set_rules('dtmitem_uom_id', 'UOM', 'required');
        /* Subocde form validation */
        foreach ($subcodedetails as $subcodedetail_1) {
            if ($subcodedetail_1['dtmsubcodedtl_is_required'] == true) {
                if ($subcodedetail_1['dtmsubcodedtl_type'] == 'OPTION') {
                    /* OPTION */
                    $this->form_validation->set_rules('seq' . $subcodedetail_1['dtmsubcodedtl_seq'] . 'code', $subcodedetail_1['dtmsubcode_name'], 'required');
                } else {
                    /* TEXT */
                    $this->form_validation->set_rules('seq' . $subcodedetail_1['dtmsubcodedtl_seq'] . 'code', $subcodedetail_1['dtmsubcodedtl_remark'], 'required');
                }
            }
            /** DetailSubcode 
             * this for : check if already exist this codification
             */
            $arraySubcode[] = [
                'dtmitemdtl_code' => $this->input->post('seq' . $subcodedetail_1['dtmsubcodedtl_seq'] . 'code')
            ];
        }

        /** Tech infromation validation */
        foreach ($itemTechInfs as $eitemTechInfs) {
            if ($eitemTechInfs['dtmsubcodetechinf_is_required'] == true) {
                $this->form_validation->set_rules('dtmsubcodetechinf_remark_' . $eitemTechInfs['dtmsubcodetechinf_id'], $eitemTechInfs['dtmsubcodetechinf_remark'], 'required');
            }
        }

        if ($this->form_validation->run() == FALSE) {
            $resp['code'] = 400;
            $resp['messages'] = validation_errors();
        } else {
            $item_id = $this->input->post('txtitem_id');
            $slugAllowDuplicate = $this->input->post('slugAllowDuplicate');
            $dtmitem_uom_id = $this->input->post('dtmitem_uom_id');
            $slug = $this->input->post('slug');
            $dtmitem_id = $this->input->post('txtdtmitem_id');
            $dtmitem_description = $this->input->post('dtmitem_description');

            /** Check already processed or not */
            $checkProcessed = $this->db->query("SELECT * FROM datatex_m_item WHERE item_id = ?", [$item_id])->num_rows();
            if (!empty($checkProcessed) && $slug != 'EDIT') {
                $resp['code'] = 400;
                $resp['messages'] = 'ItemID Already Processed';

                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($resp);
                exit();
            }

            /** Check subcode if exist or not  */
            if ($slugAllowDuplicate == '0') {
                $codificationExist = $this->db->query(
                    "SELECT datatex_m_item.dtmitem_id, datatex_m_item.item_id, datatex_m_item.dtmitem_code, datatex_m_item.dtmitem_created_at, m_item.name, m_users.name as user_name
                        FROM datatex_m_item 
                        LEFT JOIN m_item ON m_item.item_id = datatex_m_item.item_id
                        LEFT JOIN m_users ON m_users.user_id = datatex_m_item.dtmitem_created_by
                        WHERE datatex_m_item.dtmsubcode_id = ? AND datatex_m_item.dtmitem_code = ?
                        ORDER BY datatex_m_item.dtmitem_created_at DESC",
                    array($dtmsubcode_id1, $this->generate_datatech_code($dtmsubcode_id1, $arraySubcode))
                );
                if ($codificationExist->num_rows() > 0) {
                    $resp['code'] = 402;
                    $resp['messages'] = 'Already exist';
                    $resp['warninghtml'] = $this->load->view('eis/item/subcodewarning_table', ['result' => $codificationExist->result_array()], true);

                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($resp);
                    die();
                }
            }
			$validate = $this->check_approval_status($this->user_id);
            $sampleid = $this->check_sample_status($this->user_id);
			if($sampleid == 1){$idsample = 1;} else {$idsample = 0;}

			if($validate){
				$arrayMitem = [
					'item_id' => $item_id,
					'dtmsubcode_id' => $dtmsubcode_id1,
					'dtmitem_updated_at' => date('Y-m-d H:i:s'),
					'dtmitem_created_by' => isset($this->user_id) ? $this->user_id : null,
					'dtmitem_uom_id' => $dtmitem_uom_id,
					'dtmitem_description' => $dtmitem_description,
					'approval_status' => 'pending',
                    'dtmitem_approval_at' => date('Y-m-d H:i:s')
				];

				$status_approval = 'pending';
			}else{
                
				$arrayMitem = [
					'item_id' => $item_id,
					'dtmsubcode_id' => $dtmsubcode_id1,
					'dtmitem_updated_at' => date('Y-m-d H:i:s'),
					'dtmitem_created_by' => isset($this->user_id) ? $this->user_id : null,
					'dtmitem_uom_id' => $dtmitem_uom_id,
					'dtmitem_description' => $dtmitem_description,
                    'dtmitem_sample' => $idsample
				];

				$status_approval = 'pending';
			}

            $this->db->trans_begin();

            /** Custom get last Seq */
            // $lastSeq = $this->get_lastSeq();

            /** Start Slug == EDIT
             * > Delete in = datatex_m_item_detail
             * > Delete in = datatex_m_item_tech_information
             * > Delete in = datatex_m_item
             */
			$query_productibean = "INSERT INTO datatex_productibeandtl_status_240706 (dtmitem_id,status_subcode,date_input)
			VALUES (?, ?, NOW())";

            if ($slug == 'EDIT') {
                if (!empty($dtmitem_id)) {
                    $this->db->delete('datatex_m_item_tech_information', array('dtmitem_id' => $dtmitem_id));
                    $this->db->delete('datatex_m_item_detail', array('dtmitem_id' => $dtmitem_id));

                    /** Update Table : datatex_m_item */
                    $this->db->update('datatex_m_item', [
                        'dtmitem_updated_by' => isset($this->user_id) ? $this->user_id : null,
                        'dtmitem_updated_at' => date('Y-m-d H:i:s'), 
                        'dtmitem_uom_id' => $dtmitem_uom_id,
                        'dtmitem_description' => $dtmitem_description
                    ], array('dtmitem_id' => $dtmitem_id));
                }
                /** End Slug = EDIT */
            } else {
                $this->db->insert('datatex_m_item', $arrayMitem);
                $dtmitem_id = $this->db->insert_id();
				$this->db->query($query_productibean, array($dtmitem_id, $status_approval));

                if($dtmsubcode_id1 != '2' && $dtmsubcode_id1 != '12' && $dtmsubcode_id1 != '22' && $dtmsubcode_id1 != '31'){
                    //Update m_item status ACTIVE
				    $this->db->update('m_item', ['item_status' => 0], ['item_id' => $arrayMitem['item_id']]);
                }
                
                if($sampleid == 1){
                   //Update m_item status ACTIVE
				    $this->db->update('m_item', ['item_status' => 0], ['item_id' => $arrayMitem['item_id']]);                     
                }

				
            }

            foreach ($subcodedetails as $subcodedetail) {
                if ($subcodedetail['dtmsubcodedtl_type'] == 'OPTION') {
                    $dtmsubcodehierarchy_id = $this->input->post('seq' . $subcodedetail['dtmsubcodedtl_seq']);
                } else {
                    /** Is Text */
                    $dtmsubcodehierarchy_id = null;
                }
                $arrayMitemDetail[] = [
                    'dtmitem_id' => $dtmitem_id,
                    'dtmsubcodedtl_id' => $subcodedetail['dtmsubcodedtl_id'],
                    'dtmsubcodehierarchy_id' =>  $dtmsubcodehierarchy_id,
                    'dtmitemdtl_code' => $this->input->post('seq' . $subcodedetail['dtmsubcodedtl_seq'] . 'code')
                ];
            }

            /** Technical information insert batch */
            $dtmsubcodetechinf_ids = $this->input->post('dtmsubcodetechinf_ids');
            for ($i = 0; $i < count($dtmsubcodetechinf_ids); $i++) {
                $dtmitemtechinf_note = $this->input->post('dtmsubcodetechinf_remark_' . $dtmsubcodetechinf_ids[$i]);
                $subcodetechinfhierarchy = $this->input->post('subcodetechinfhierarchy_' . $dtmsubcodetechinf_ids[$i]);
                $arrayTechInfs[] = [
                    'dtmitem_id' => $dtmitem_id,
                    'dtmsubcodetechinf_id' => $dtmsubcodetechinf_ids[$i],
                    'dtmitemtechinf_note' => !empty($dtmitemtechinf_note) ? $dtmitemtechinf_note : null,
                    'dtmsubcodetechinfhierarchy_id' => !empty($subcodetechinfhierarchy) ? $subcodetechinfhierarchy : null
                ];
            }

            $this->db->update('datatex_m_item', ['dtmitem_code' => $this->generate_datatech_code($dtmsubcode_id1, $arrayMitemDetail)], array('dtmitem_id' => $dtmitem_id));
            $this->db->insert_batch('datatex_m_item_detail', $arrayMitemDetail);
            if (!empty($dtmsubcodetechinf_ids)) {
                $this->db->insert_batch('datatex_m_item_tech_information', $arrayTechInfs);
            }

            /** Custom update seq automatic */
            // $updateSeqAutomatic = $this->generate_autoincrement_seq($dtmitem_id, $lastSeq);
            $updateSeqAutomatic = true;

            if ($this->db->trans_status() === FALSE && $updateSeqAutomatic == false) {
                $this->db->trans_rollback();
                $resp['code'] = 400;
                $resp['messages'] = 'Error';
            } else {
                $this->db->trans_commit();
                $resp['code'] = 200;
                $resp['messages'] = 'Success';
                $resp['data'] = ['dtmitem_id_base64' => base64_encode($dtmitem_id)];
            }
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    /** For Batch process with parent ID */
    public function parent_index()
    {
        $slug = $this->input->get('slug');
        $dtmitem_id_base64 = $this->input->get('dtmitem_id');
        $dtmitem_id = base64_decode($dtmitem_id_base64);

        parent::baseTemplate();
        parent::datatablesAssets();
        parent::select2Assets();
        parent::toastAssets();

        $data['class_link'] = $this->class_link;
        $data['datatex_item'] = $this->db->query(
            "SELECT datatex_m_item.*, datatex_m_subcode.*, m_um.name as um_name, m_users.auth_email, m_item.parent_item_id
            FROM datatex_m_item
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_item.dtmsubcode_id
            LEFT JOIN m_um ON m_um.um_id=datatex_m_item.dtmitem_uom_id
            LEFT JOIN m_users ON m_users.user_id=datatex_m_item.dtmitem_created_by
            LEFT JOIN m_item ON m_item.item_id=datatex_m_item.item_id
            WHERE datatex_m_item.dtmitem_id = ?",
            array($dtmitem_id)
        )->row_array();

        // HARDCODING on Datatex0 is RAWMATERIAL
        $data['selected'] = $this->db->query("SELECT * FROM datatex_m_subcode WHERE dtmsubcode_name = 'RAWMATERIAL'")->row_array();
        $data['dtmitem_id'] = $dtmitem_id;
        $data['parent_item_id_base64'] = base64_encode($data['datatex_item']['parent_item_id']);
        $data['slug'] = $slug;

        $this->load->view($this->class_link . '/parent_index', $data);
    }

    public function parent_formmain()
    {
        $slug = $this->input->get('slug');
        $parent_item_id_base64 = $this->input->get('parent_item_id');
        $dtmitem_id = $this->input->get('dtmitem_id');
        $parent_item_id = base64_decode($parent_item_id_base64);

        $data['slug'] = $slug;
        $data['dtmitem_id'] = $dtmitem_id;
        $data['class_link'] = $this->class_link;
        $qItemChilds = $this->db->query(
            "SELECT datatex_scope_item.*, m_item.*, m_classification.name as classif_name, m_subclassification.name as subclassif_name, m_um.name as um_name
            FROM datatex_scope_item
            LEFT JOIN m_item ON m_item.item_id = datatex_scope_item.item_id
            LEFT JOIN datatex_m_item ON datatex_m_item.item_id=datatex_scope_item.item_id
            LEFT JOIN m_classification ON m_classification.classif_id=m_item.classif_id
            LEFT JOIN m_subclassification ON m_subclassification.subclassif_id=m_item.subclassif_id
            LEFT JOIN m_um ON m_um.um_id=m_item.um_id
            WHERE datatex_m_item.item_id IS NULL
            AND m_item.parent_item_id = ?",
            array($parent_item_id)
        );
        $data['itemChilds']['result'] =  $qItemChilds->result_array();

        /** Parent Item */
        $data['itemParent']['datatech_item'] = $this->db->query(
            "SELECT datatex_m_item.*, datatex_m_subcode.*, m_um.name as um_name, m_users.auth_email
            FROM datatex_m_item
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_item.dtmsubcode_id
            LEFT JOIN m_um ON m_um.um_id=datatex_m_item.dtmitem_uom_id
            LEFT JOIN m_users ON m_users.user_id=datatex_m_item.dtmitem_created_by
            WHERE datatex_m_item.dtmitem_id = ?",
            array($dtmitem_id)
        )->row_array();

        $data['itemParent']['eis_item'] = $this->db->query(
            "SELECT m_item.*, m_classification.name as classif_name, m_subclassification.name as subclassif_name, m_um.name as um_name
            FROM m_item
            LEFT JOIN m_classification ON m_classification.classif_id=m_item.classif_id
            LEFT JOIN m_subclassification ON m_subclassification.subclassif_id=m_item.subclassif_id
            LEFT JOIN m_um ON m_um.um_id=m_item.um_id
            WHERE m_item.item_id = ?",
            array($data['itemParent']['datatech_item']['item_id'])
        )->row_array();

        $data['itemParent']['datatech_item_detail'] = $this->db->query(
            "SELECT datatex_m_item_detail.*, 
            datatex_m_subcode_hierarchy.dtmsubcodehierarchy_name,
            datatex_m_subcode_detail.dtmsubcodedtl_seq, datatex_m_subcode_detail.dtmsubcodedtl_type, datatex_m_subcode_detail.dtmsubcodedtl_remark, datatex_m_subcode_detail.dtmsubcode_id,
            datatex_m_subcode.dtmsubcode_id, datatex_m_subcode.dtmsubcode_name
            FROM datatex_m_item_detail
            LEFT JOIN datatex_m_subcode_hierarchy ON datatex_m_subcode_hierarchy.dtmsubcodehierarchy_id=datatex_m_item_detail.dtmsubcodehierarchy_id
            LEFT JOIN datatex_m_subcode_detail ON datatex_m_subcode_detail.dtmsubcodedtl_id=datatex_m_item_detail.dtmsubcodedtl_id
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_subcode_detail.dtmsubcode_option_id
            WHERE datatex_m_item_detail.dtmitem_id= ?
            ORDER BY datatex_m_subcode_detail.dtmsubcodedtl_seq ASC
            ",
            array($dtmitem_id)
        )->result_array();

        $data['itemParent']['datatex_item_tech_information'] = $this->db->query(
            "SELECT datatex_m_item_tech_information.*,
            datatex_m_subcode_tech_information.dtmsubcodetechinf_seq, datatex_m_subcode_tech_information.dtmsubcodetechinf_remark
            FROM datatex_m_item_tech_information
            LEFT JOIN datatex_m_subcode_tech_information ON datatex_m_subcode_tech_information.dtmsubcodetechinf_id = datatex_m_item_tech_information.dtmsubcodetechinf_id
            WHERE datatex_m_item_tech_information.dtmitem_id= ?
            ORDER BY datatex_m_subcode_tech_information.dtmsubcodetechinf_seq ASC",
            array($dtmitem_id)
        )->result_array();

        $this->load->view($this->class_link . '/parent_formmain', $data);
    }

    public function action_submit_batch_byparent()
    {
        $dtmitem_id = $this->input->post('dtmitem_id');
        $dtscopeitem_ids = $this->input->post('dtscopeitem_ids');
        $hiesize_ids = $this->input->post('hiesize_ids');
        $hiecolor_ids = $this->input->post('hiecolor_ids');
        $dtmitem_descriptions = $this->input->post('dtmitem_descriptions');

        /** Start Validation */
        $this->load->library(['form_validation']);

        $this->form_validation->set_rules('dtmitem_id', 'ID', 'required');
        if ($this->form_validation->run() == FALSE) {
            $resp['code'] = 400;
            $resp['messages'] = validation_errors();

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($resp);
            exit();
        }
        // Validation checked scope
        if (empty($dtscopeitem_ids)) {
            $resp['code'] = 400;
            $resp['messages'] = 'Empty Selected ID';

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($resp);
            exit();
        }

        $countEmptySizeColors = 0;
        $arrayHierarchySizes = array();
        $arrayHierarchyColors = array();
        foreach ($dtscopeitem_ids as $eScopeitem_id) {
            if (empty($hiesize_ids[$eScopeitem_id]) || empty($hiecolor_ids[$eScopeitem_id])) {
                $countEmptySizeColors++;
            } else {
                $arrayHierarchySizes[] = $hiesize_ids[$eScopeitem_id];
                $arrayHierarchyColors[] = $hiecolor_ids[$eScopeitem_id];
            }
        }
        if (!empty($countEmptySizeColors)) {
            $resp['code'] = 400;
            $resp['messages'] = 'Empty Color/Size Selected';

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($resp);
            exit();
        }
        /** End Validation */

        $scopeItems = $this->db->query(
            "SELECT * FROM datatex_scope_item WHERE dtscopeitem_id IN ?",
            array($dtscopeitem_ids)
        )->result();

        /** Hierarchy Size */
        $scopeHierarchySizes = $this->db->query(
            "SELECT * FROM datatex_m_subcode_hierarchy WHERE dtmsubcodehierarchy_id IN ?",
            array($arrayHierarchySizes)
        )->result();
        $arrayGroupByIdHierarchy = array();
        foreach ($scopeHierarchySizes as $eScopeHierarchy) {
            $arrayGroupByIdHierarchy[$eScopeHierarchy->dtmsubcodehierarchy_id] = $eScopeHierarchy;
        }

        /** Hierarchy Color */
        $scopeHierarchyColors = $this->db->query(
            "SELECT * FROM datatex_m_subcode_hierarchy WHERE dtmsubcodehierarchy_id IN ?",
            array($arrayHierarchyColors)
        )->result();
        $arrayGroupByIdHierarchyColor = array();
        foreach ($scopeHierarchyColors as $eScopeHierarchyColor) {
            $arrayGroupByIdHierarchyColor[$eScopeHierarchyColor->dtmsubcodehierarchy_id] = $eScopeHierarchyColor;
        }

        $itemRef['datatex_m_item'] = $this->db->query(
            "SELECT * FROM datatex_m_item WHERE dtmitem_id = ?",
            array($dtmitem_id)
        )->row();
        $itemRef['datatex_m_item_detail'] = $this->db->query(
            "SELECT datatex_m_item_detail.*, datatex_m_subcode.dtmsubcode_name
            FROM datatex_m_item_detail 
            LEFT JOIN datatex_m_subcode_detail ON datatex_m_subcode_detail.dtmsubcodedtl_id = datatex_m_item_detail.dtmsubcodedtl_id
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id = datatex_m_subcode_detail.dtmsubcode_option_id
            WHERE datatex_m_item_detail.dtmitem_id = ?",
            array($dtmitem_id)
        )->result();
        $itemRef['datatex_m_item_tech_information'] = $this->db->query(
            "SELECT * FROM datatex_m_item_tech_information WHERE dtmitem_id = ?",
            array($dtmitem_id)
        )->result();

        $this->db->trans_begin();

        $arrayLogData = array();
        foreach ($scopeItems as $eScope) {
			$arrayMitem = [
				'item_id' => $eScope->item_id,
				'dtmsubcode_id' => $itemRef['datatex_m_item']->dtmsubcode_id,
				'dtmitem_created_by' => isset($this->user_id) ? $this->user_id : null,
				'dtmitem_uom_id' => $itemRef['datatex_m_item']->dtmitem_uom_id,
				'dtmitem_description' => !empty($dtmitem_descriptions[$eScope->dtscopeitem_id]) ? $dtmitem_descriptions[$eScope->dtscopeitem_id] : null
			];
            
            /** SUBMIT datatex_m_item */
            $this->db->insert('datatex_m_item', $arrayMitem);
            $dtmitem_idNew = $this->db->insert_id();
			
            $arrayMitemDetails = array();
            foreach ($itemRef['datatex_m_item_detail'] as $eItemDetail) {
                $dtmsubcodehierarchy_id = $eItemDetail->dtmsubcodehierarchy_id;
                $dtmitemdtl_code = $eItemDetail->dtmitemdtl_code;
                if (strtoupper($eItemDetail->dtmsubcode_name) == 'SIZE') {
                    $dtmsubcodehierarchy_id = $hiesize_ids[$eScope->dtscopeitem_id];
                    $dtmitemdtl_code = $arrayGroupByIdHierarchy[$hiesize_ids[$eScope->dtscopeitem_id]]->dtmsubcodehierarchy_code;
                } elseif (strtoupper($eItemDetail->dtmsubcode_name) == 'COLOR') {
                    $dtmsubcodehierarchy_id = $hiecolor_ids[$eScope->dtscopeitem_id];
                    $dtmitemdtl_code = $arrayGroupByIdHierarchyColor[$hiecolor_ids[$eScope->dtscopeitem_id]]->dtmsubcodehierarchy_code;
                }
				
                $arrayMitemDetails[] = [
                    'dtmitem_id' => $dtmitem_idNew,
                    'dtmsubcodedtl_id' => $eItemDetail->dtmsubcodedtl_id,
                    'dtmsubcodehierarchy_id' =>  $dtmsubcodehierarchy_id,
                    'dtmitemdtl_code' => $dtmitemdtl_code
                ];
            }
            /** SUBMIT datatex_m_item_detail */
            if (!empty($arrayMitemDetails)) {
                $this->db->insert_batch('datatex_m_item_detail', $arrayMitemDetails);
            }

            $arrayTechInfs = array();
            foreach ($itemRef['datatex_m_item_tech_information'] as $eTechInf) {
                $arrayTechInfs[] = [
                    'dtmitem_id' => $dtmitem_idNew,
                    'dtmsubcodetechinf_id' => $eTechInf->dtmsubcodetechinf_id,
                    'dtmitemtechinf_note' => $eTechInf->dtmitemtechinf_note,
                    'dtmsubcodetechinfhierarchy_id' => $eTechInf->dtmsubcodetechinfhierarchy_id,
                ];
            }

            /** SUBMIT datatex_m_item_tech_information */
            if (!empty($arrayTechInfs)) {
                $this->db->insert_batch('datatex_m_item_tech_information', $arrayTechInfs);
            }

            /** Generate DatatexCode */
            $this->db->update('datatex_m_item', ['dtmitem_code' => $this->generate_datatech_code($itemRef['datatex_m_item']->dtmsubcode_id, $arrayMitemDetails)], array('dtmitem_id' => $dtmitem_idNew));

            /** Logging */
            $arrayLogData[]['datatex_m_item'] = $arrayMitem;
            $arrayLogData[]['datatex_m_item_detail'] = $arrayMitemDetails;
            $arrayLogData[]['datatex_m_item_tech_information'] = $arrayTechInfs;
        }

        $dataLog = [
            'dtmitemlog_data' => json_encode($arrayLogData),
            'dtmitemlog_action' => 'INSERT_BATCH_BY_PARENT',
            'dtmitemlog_created_by' => isset($this->user_id) && !empty($this->user_id) ? $this->user_id : null
        ];

        $this->db->insert('datatex_m_item_log', $dataLog);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $resp['code'] = 400;
            $resp['messages'] = 'Error';
        } else {
            $this->db->trans_commit();
            $resp['code'] = 200;
            $resp['messages'] = 'Success';
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

	public function check_approval_status($user){
		$query = $this->db->query("SELECT * FROM datatex_m_role_user WHERE user_id = $user");
    
		$row = $query->row();
		
		if ($row && $row->approval == TRUE) {
			return true;
		} else {
			return false;
		}
	}

    public function check_sample_status($user){
		$query = $this->db->query("SELECT coalesce(sample_id_status,0) sample_id_status FROM datatex_hierarchy_md_sample WHERE user_id = $user");
    
		$row = $query->row();
		return $row->sample_id_status;
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Scope_item extends MY_Controller
{
    private $class_link = 'setting/scope_item';

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['EISDatatex/Setting/LogTransactionModel']);
    }

    public function index()
    {
        if (!checkPermission('SETTING.SCOPEITEM.READ')) {
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
            "SELECT datatex_scope_item.dtscopeitem_id as role_action, datatex_scope_item.item_id, datatex_scope_item.dtscopeitem_buyer_ids, datatex_m_subcode_hierarchy.dtmsubcodehierarchy_name, datatex_scope_item.dtscopeitem_created_at, datatex_scope_item.dtscopeitem_id
            FROM datatex_scope_item
            LEFT JOIN datatex_m_subcode_hierarchy ON datatex_m_subcode_hierarchy.dtmsubcodehierarchy_id = datatex_scope_item.dtmsubcodehierarchy_id"
        );

        $datatables->edit('role_action', function ($data) {
            $html = '';
            $html .= '
            <a href="javascript:void(0);" onclick="alert(\'' . "On Development" . '\')" class="btn btn-tool btn-sm" title="List">
                <i class="fas fa-search"></i>
            </a>';
            return $html;
        });

        echo $datatables->generate();
    }

    public function form_main()
    {
        $slug = $this->input->get('slug');

        $data['class_link'] = $this->class_link;
        $data['slug'] = $slug;
        $data['month'] = str_pad((int)date('m') - 1, 2, '0', STR_PAD_LEFT);
        $data['year'] = date('y');

        $this->load->view($this->class_link . '/form_main', $data);
    }

    public function action_getoutstandingitemsclossing()
    {
        $periodecode = $this->input->get('periodecode');

        $qItemsOutstandings = $this->db->query(
            "SELECT VSCOPE.ITEM_ID, VSCOPE.DTSCOPEITEM_BUYER_IDS, MI.PARENT_ITEM_ID FROM 
            (
                SELECT AMRU.ITEM_ID, STRING_AGG(DISTINCT(PRM.BUYER_ID), ', ') AS DTSCOPEITEM_BUYER_IDS
                FROM ACC_MONTHLY_REPORT_USD AMRU
                LEFT JOIN PURCHASE_REQUISITION_DETAIL PRD ON AMRU.ITEM_ID=PRD.ITEM_ID
                LEFT JOIN PURCHASE_REQUISITION_MASTER PRM ON PRD.PR_NO=PRM.PR_NO
                LEFT JOIN DATATEX_SCOPE_ITEM DSI ON DSI.ITEM_ID = AMRU.ITEM_ID
                WHERE 1=1 
                AND AMRU.PERIODE=?
                AND ((AMRU.OPENING_QTY <> 0) OR (AMRU.OPENING_VALUE <> 0) OR (AMRU.INCOMING_QTY <> 0) OR (AMRU.INCOMING_VALUE <> 0) OR
                       (AMRU.INCOMING_ADJUSMENT <> 0) OR (AMRU.ADJUSMENT_INC_VALUE <> 0) OR (AMRU.RETURN_QTY <> 0) OR (AMRU.RETURN_VALUE <> 0) OR (AMRU.OUTWARD_RETURN_QTY <> 0) OR
                       (AMRU.OUTWARD_RETURN_VALUE <> 0) OR (AMRU.OUTGOING_QTY <> 0) OR (AMRU.OUTGOING_VALUE <> 0) OR
                       (AMRU.OUTGOING_ADJUSMENT <> 0) OR (AMRU.ADJUSMENT_OUT_VALUE <> 0) OR (AMRU.BALANCE_QTY <> 0) OR (AMRU.BALANCE_VALUE <> 0) OR 
                       (AMRU.EXTRA_QTY <> 0) OR (AMRU.EXTRA_VALUE <> 0) OR (AMRU.GRAND_BALANCE_QTY <> 0) OR (AMRU.GRAND_BALANCE <> 0))
                AND DSI.ITEM_ID IS NULL
                GROUP BY AMRU.ITEM_ID
                ORDER BY AMRU.ITEM_ID
            ) AS VSCOPE
            LEFT JOIN M_ITEM MI ON MI.ITEM_ID = VSCOPE.ITEM_ID
            WHERE MI.PARENT_ITEM_ID IS NULL",
            array($periodecode)
        );

        $resp['code'] = 200;
        $resp['messages'] = ['periodecode' => $periodecode, 'periodecode_count' => $qItemsOutstandings->num_rows(), 'perodecodechild_count' => $this->service_countoutstandingchild($periodecode)];

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    public function action_submitoutstandingitemclossing()
    {
        $periodecode = $this->input->post('periodecode');

        $this->db->trans_begin();

        $this->db->query(
            "INSERT INTO DATATEX_SCOPE_ITEM (ITEM_ID, DTSCOPEITEM_BUYER_IDS)
                SELECT VSCOPE.ITEM_ID, VSCOPE.DTSCOPEITEM_BUYER_IDS FROM 
                (
                    SELECT AMRU.ITEM_ID, STRING_AGG(DISTINCT(PRM.BUYER_ID), ', ') AS DTSCOPEITEM_BUYER_IDS
                    FROM ACC_MONTHLY_REPORT_USD AMRU
                    LEFT JOIN PURCHASE_REQUISITION_DETAIL PRD ON AMRU.ITEM_ID=PRD.ITEM_ID
                    LEFT JOIN PURCHASE_REQUISITION_MASTER PRM ON PRD.PR_NO=PRM.PR_NO
                    LEFT JOIN DATATEX_SCOPE_ITEM DSI ON DSI.ITEM_ID = AMRU.ITEM_ID
                    WHERE 1=1 
                    AND AMRU.PERIODE=?
                    AND ((AMRU.OPENING_QTY <> 0) OR (AMRU.OPENING_VALUE <> 0) OR (AMRU.INCOMING_QTY <> 0) OR (AMRU.INCOMING_VALUE <> 0) OR
                        (AMRU.INCOMING_ADJUSMENT <> 0) OR (AMRU.ADJUSMENT_INC_VALUE <> 0) OR (AMRU.RETURN_QTY <> 0) OR (AMRU.RETURN_VALUE <> 0) OR (AMRU.OUTWARD_RETURN_QTY <> 0) OR
                        (AMRU.OUTWARD_RETURN_VALUE <> 0) OR (AMRU.OUTGOING_QTY <> 0) OR (AMRU.OUTGOING_VALUE <> 0) OR
                        (AMRU.OUTGOING_ADJUSMENT <> 0) OR (AMRU.ADJUSMENT_OUT_VALUE <> 0) OR (AMRU.BALANCE_QTY <> 0) OR (AMRU.BALANCE_VALUE <> 0) OR 
                        (AMRU.EXTRA_QTY <> 0) OR (AMRU.EXTRA_VALUE <> 0) OR (AMRU.GRAND_BALANCE_QTY <> 0) OR (AMRU.GRAND_BALANCE <> 0))
                    AND DSI.ITEM_ID IS NULL
                    GROUP BY AMRU.ITEM_ID
                    ORDER BY AMRU.ITEM_ID
                ) AS VSCOPE
                LEFT JOIN M_ITEM MI ON MI.ITEM_ID = VSCOPE.ITEM_ID
                WHERE MI.PARENT_ITEM_ID IS NULL
                ",
            array($periodecode)
        );

        if (!empty($this->service_countoutstandingchild($periodecode))) {
            $this->service_submitchilditem($periodecode);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $resp['code'] = 400;
            $resp['messages'] = 'Error Process';
        } else {
            $this->db->trans_commit();
            $resp['code'] = 200;
            $resp['messages'] = 'Success';
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resp);
    }

    private function service_submitchilditem($periodecode)
    {
        return $this->db->query(
            "INSERT INTO DATATEX_SCOPE_ITEMCHILD (ITEM_ID, DTSCOPEITEMCHILD_BUYER_IDS, PARENT_ITEM_ID)
                SELECT VSCOPE.ITEM_ID, VSCOPE.DTSCOPEITEMCHILD_BUYER_IDS, MI.PARENT_ITEM_ID FROM 
                (
                    SELECT AMRU.ITEM_ID, STRING_AGG(DISTINCT(PRM.BUYER_ID), ', ') AS DTSCOPEITEMCHILD_BUYER_IDS
                    FROM ACC_MONTHLY_REPORT_USD AMRU
                    LEFT JOIN PURCHASE_REQUISITION_DETAIL PRD ON AMRU.ITEM_ID=PRD.ITEM_ID
                    LEFT JOIN PURCHASE_REQUISITION_MASTER PRM ON PRD.PR_NO=PRM.PR_NO
                    LEFT JOIN DATATEX_SCOPE_ITEM DSI ON DSI.ITEM_ID = AMRU.ITEM_ID
                    LEFT JOIN DATATEX_SCOPE_ITEMCHILD DSIC ON DSIC.ITEM_ID = AMRU.ITEM_ID
                    WHERE 1=1 
                    AND AMRU.PERIODE=?
                    AND ((AMRU.OPENING_QTY <> 0) OR (AMRU.OPENING_VALUE <> 0) OR (AMRU.INCOMING_QTY <> 0) OR (AMRU.INCOMING_VALUE <> 0) OR
                        (AMRU.INCOMING_ADJUSMENT <> 0) OR (AMRU.ADJUSMENT_INC_VALUE <> 0) OR (AMRU.RETURN_QTY <> 0) OR (AMRU.RETURN_VALUE <> 0) OR (AMRU.OUTWARD_RETURN_QTY <> 0) OR
                        (AMRU.OUTWARD_RETURN_VALUE <> 0) OR (AMRU.OUTGOING_QTY <> 0) OR (AMRU.OUTGOING_VALUE <> 0) OR
                        (AMRU.OUTGOING_ADJUSMENT <> 0) OR (AMRU.ADJUSMENT_OUT_VALUE <> 0) OR (AMRU.BALANCE_QTY <> 0) OR (AMRU.BALANCE_VALUE <> 0) OR 
                        (AMRU.EXTRA_QTY <> 0) OR (AMRU.EXTRA_VALUE <> 0) OR (AMRU.GRAND_BALANCE_QTY <> 0) OR (AMRU.GRAND_BALANCE <> 0))
                    AND DSI.ITEM_ID IS NULL
                    AND DSIC.ITEM_ID IS NULL
                    GROUP BY AMRU.ITEM_ID
                    ORDER BY AMRU.ITEM_ID	
                ) AS VSCOPE
                LEFT JOIN M_ITEM MI ON MI.ITEM_ID = VSCOPE.ITEM_ID
                WHERE MI.PARENT_ITEM_ID IS NOT NULL
                ",
            array($periodecode)
        );
    }

    private function service_countoutstandingchild($periodecode)
    {
        return $this->db->query(
            "SELECT VSCOPE.ITEM_ID, VSCOPE.DTSCOPEITEM_BUYER_IDS, MI.PARENT_ITEM_ID FROM 
            (
                SELECT AMRU.ITEM_ID, STRING_AGG(DISTINCT(PRM.BUYER_ID), ', ') AS DTSCOPEITEM_BUYER_IDS
                FROM ACC_MONTHLY_REPORT_USD AMRU
                LEFT JOIN PURCHASE_REQUISITION_DETAIL PRD ON AMRU.ITEM_ID=PRD.ITEM_ID
                LEFT JOIN PURCHASE_REQUISITION_MASTER PRM ON PRD.PR_NO=PRM.PR_NO
                LEFT JOIN DATATEX_SCOPE_ITEM DSI ON DSI.ITEM_ID = AMRU.ITEM_ID
                LEFT JOIN DATATEX_SCOPE_ITEMCHILD DSIC ON DSIC.ITEM_ID = AMRU.ITEM_ID
                WHERE 1=1 
                AND AMRU.PERIODE=?
                AND ((AMRU.OPENING_QTY <> 0) OR (AMRU.OPENING_VALUE <> 0) OR (AMRU.INCOMING_QTY <> 0) OR (AMRU.INCOMING_VALUE <> 0) OR
                       (AMRU.INCOMING_ADJUSMENT <> 0) OR (AMRU.ADJUSMENT_INC_VALUE <> 0) OR (AMRU.RETURN_QTY <> 0) OR (AMRU.RETURN_VALUE <> 0) OR (AMRU.OUTWARD_RETURN_QTY <> 0) OR
                       (AMRU.OUTWARD_RETURN_VALUE <> 0) OR (AMRU.OUTGOING_QTY <> 0) OR (AMRU.OUTGOING_VALUE <> 0) OR
                       (AMRU.OUTGOING_ADJUSMENT <> 0) OR (AMRU.ADJUSMENT_OUT_VALUE <> 0) OR (AMRU.BALANCE_QTY <> 0) OR (AMRU.BALANCE_VALUE <> 0) OR 
                       (AMRU.EXTRA_QTY <> 0) OR (AMRU.EXTRA_VALUE <> 0) OR (AMRU.GRAND_BALANCE_QTY <> 0) OR (AMRU.GRAND_BALANCE <> 0))
                AND DSI.ITEM_ID IS NULL
                AND DSIC.ITEM_ID IS NULL
                GROUP BY AMRU.ITEM_ID
                ORDER BY AMRU.ITEM_ID	
            ) AS VSCOPE
            LEFT JOIN M_ITEM MI ON MI.ITEM_ID = VSCOPE.ITEM_ID
            WHERE MI.PARENT_ITEM_ID IS NOT NULL
                ",
            array($periodecode)
        )->num_rows();
    }
}

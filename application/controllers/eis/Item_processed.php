<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Item_processed extends MY_Controller
{
	private $class_link = 'eis/item_processed';
	private $class_link_item = 'eis/item';

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(['my_helper']);
		$this->load->model(['EISDatatex/Setting/PermissionModel']);
	}

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

		$query = "";
		$query .=
			"SELECT  datatex_m_item.dtmitem_code, datatex_m_subcode.dtmsubcode_name, m_item.item_id, m_classification.name, m_subclassification.name as subclassname, 
            m_item.content_name, m_item.material_name, m_item.reference_name, m_item.color_name,
            m_item.construction_name, m_item.spec_type, m_item.spec_name, m_item.item_type, m_item.source, m_item.um_id, datatex_m_item.dtmitem_uom_id, datatex_m_item.dtmitem_created_by, datatex_m_item.dtmitem_created_at, datatex_m_item.dtmitem_validated_at, datatex_m_item.dtmitem_updated_at,
            datatex_m_item.dtmitem_id
            FROM datatex_m_item
            LEFT JOIN m_item ON m_item.item_id=datatex_m_item.item_id
            LEFT JOIN m_classification ON m_classification.classif_id=m_item.classif_id
            LEFT JOIN m_subclassification ON m_subclassification.subclassif_id=m_item.subclassif_id
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_item.dtmsubcode_id ";
		/** Check if allow read all
		 * read all = all processed
		 * else = only created by you (userlogin)
		 */
		if (!checkPermission('MASTERITEM.PROCESSED.READ_ALL_RESULT')) {
			$query .= " WHERE datatex_m_item.dtmitem_created_by = '{$this->user_id}'";
		}

		$datatables->query($query);

		$datatables->edit('dtmitem_code', function ($data) {
			return '<a href="javascript:void(0);" onclick="view_data(\'' . $data['dtmitem_id'] . '\')"><strong> ' . $data['dtmitem_code'] . '</strong> </a>';
		});

		echo $datatables->generate();
	}

	public function form_main()
	{
		$dtmitem_id = $this->input->get('dtmitem_id');
		$slug = $this->input->get('slug');

		$data['slug'] = $slug;
		$data['class_link'] = $this->class_link;
		$data['uploaded'] = $this->PermissionModel->checkUploaded($dtmitem_id);
		$data['datatech_item'] = $this->db->query(
			"SELECT datatex_m_item.*, datatex_m_subcode.*, datatex_eis_uom.dtxuom_name as um_name, m_users.auth_email
            FROM datatex_m_item
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_item.dtmsubcode_id
            --LEFT JOIN m_um ON m_um.um_id=datatex_m_item.dtmitem_uom_id
			LEFT JOIN datatex_eis_uom ON datatex_eis_uom.dtxuom_code=datatex_m_item.dtmitem_uom_id
            LEFT JOIN m_users ON m_users.user_id=datatex_m_item.dtmitem_created_by
            WHERE datatex_m_item.dtmitem_id = ?",
			array($dtmitem_id)
		)->row_array();

		$data['eis_item'] = $this->db->query(
			"SELECT m_item.*, m_classification.name as classif_name, m_subclassification.name as subclassif_name, m_um.name as um_name
            FROM m_item
            LEFT JOIN m_classification ON m_classification.classif_id=m_item.classif_id
            LEFT JOIN m_subclassification ON m_subclassification.subclassif_id=m_item.subclassif_id
            LEFT JOIN m_um ON m_um.um_id=m_item.um_id
            WHERE m_item.item_id = ?",
			array($data['datatech_item']['item_id'])
		)->row_array();

		$data['datatech_item_detail'] = $this->db->query(
			"SELECT datatex_m_item_detail.dtmitemdtl_code, 
            datatex_m_subcode_hierarchy.dtmsubcodehierarchy_name,
            datatex_m_subcode_detail.dtmsubcodedtl_seq, datatex_m_subcode_detail.dtmsubcodedtl_type, datatex_m_subcode_detail.dtmsubcodedtl_remark,
            datatex_m_subcode.dtmsubcode_name
            FROM datatex_m_item_detail
            LEFT JOIN datatex_m_subcode_hierarchy ON datatex_m_subcode_hierarchy.dtmsubcodehierarchy_id=datatex_m_item_detail.dtmsubcodehierarchy_id
            LEFT JOIN datatex_m_subcode_detail ON datatex_m_subcode_detail.dtmsubcodedtl_id=datatex_m_item_detail.dtmsubcodedtl_id
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_subcode_detail.dtmsubcode_option_id
            WHERE datatex_m_item_detail.dtmitem_id= ?
            ORDER BY datatex_m_subcode_detail.dtmsubcodedtl_seq ASC
            ",
			array($dtmitem_id)
		)->result_array();

		$data['datatex_item_tech_information'] = $this->db->query(
			"SELECT datatex_m_item_tech_information.dtmitemtechinf_note,
            datatex_m_subcode_tech_information.dtmsubcodetechinf_seq, datatex_m_subcode_tech_information.dtmsubcodetechinf_remark,
			datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinfhierarchy_code, datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinfhierarchy_name
            FROM datatex_m_item_tech_information
            LEFT JOIN datatex_m_subcode_tech_information ON datatex_m_subcode_tech_information.dtmsubcodetechinf_id = datatex_m_item_tech_information.dtmsubcodetechinf_id
			LEFT JOIN datatex_m_subcode_tech_inf_hierarchy ON datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinfhierarchy_id = datatex_m_item_tech_information.dtmsubcodetechinfhierarchy_id
            WHERE datatex_m_item_tech_information.dtmitem_id= ?
            ORDER BY datatex_m_subcode_tech_information.dtmsubcodetechinf_seq ASC",
			array($dtmitem_id)
		)->result_array();

		/** Get Unprocessed in scope, with same parent id */
		$qParentRelated =  $this->db->query(
			"SELECT datatex_scope_item.dtscopeitem_id, m_item.parent_item_id
            FROM datatex_scope_item 
            LEFT JOIN m_item ON m_item.item_id = datatex_scope_item.item_id
            LEFT JOIN datatex_m_item ON datatex_m_item.item_id = datatex_scope_item.item_id
            WHERE datatex_m_item.item_id IS NULL
            AND m_item.parent_item_id = (SELECT mi2.parent_item_id FROM m_item mi2 WHERE mi2.item_id = ?)",
			array($data['datatech_item']['item_id'])
		);
		$data['parentRelated']['count'] = $qParentRelated->num_rows();

		$this->load->view($this->class_link . '/form_main', $data);
	}

	public function formedit_main()
	{
		$dtmitem_id = $this->input->get('dtmitem_id');

		if (empty($dtmitem_id)) {
			show_error('Cannot Loaded', 200, 'Error load data');
		}

		$dtmitemRow = $this->db->query(
			"SELECT * 
            FROM datatex_m_item 
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id = datatex_m_item.dtmsubcode_id
            WHERE dtmitem_id = ?",
			[$dtmitem_id]
		)->row_array();

		$data['slug'] = 'EDIT';
		$data['dtmitem_id'] = $dtmitem_id;
		$data['class_link'] = $this->class_link;
		$data['eis_item'] = $this->db->query(
			"SELECT m_item.*, m_classification.name as classif_name, m_subclassification.name as subclassif_name, m_um.name as um_name
            FROM m_item
            LEFT JOIN m_classification ON m_classification.classif_id=m_item.classif_id
            LEFT JOIN m_subclassification ON m_subclassification.subclassif_id=m_item.subclassif_id
            LEFT JOIN m_um ON m_um.um_id=m_item.um_id
            WHERE m_item.item_id = ?",
			array($dtmitemRow['item_id'])
		)->row_array();
		// HARDCODING on Datatex0 is RAWMATERIAL
		$data['selected'] = $this->db->query("SELECT * FROM datatex_m_subcode WHERE dtmsubcode_name = 'RAWMATERIAL'")->row_array();
		$data['selected']['dtmitemRow'] = $dtmitemRow;

		$this->load->view($this->class_link_item . '/form_main', $data);
	}

	/** View from Item/form_subcode */
	public function form_subcode()
	{
		$dtmsubcode_id = $this->input->get('dtmsubcode_id');
		$dtmitem_id = $this->input->get('dtmitem_id');

		if (empty($dtmsubcode_id) || empty($dtmitem_id)) {
			show_error('Cannot Loaded', 200, 'Error load data');
		}

		$result = $this->db->query(
			"SELECT datatex_m_subcode_detail.*, datatex_m_subcode.dtmsubcode_name 
            FROM datatex_m_subcode_detail 
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_subcode_detail.dtmsubcode_option_id
            WHERE datatex_m_subcode_detail.dtmsubcode_id = ?
            ORDER BY datatex_m_subcode_detail.dtmsubcodedtl_seq ASC",
			array($dtmsubcode_id)
		)->result_array();

		$data['slug'] = 'EDIT';
		$data['class_link'] = $this->class_link_item;
		$data['result'] = $result;
		$data['dtmsubcode_id'] = $dtmsubcode_id;
		$data['selected'] = $this->db->query(
			"SELECT datatex_m_item.*, datatex_m_item_detail.*,
            datatex_m_subcode_detail.dtmsubcodedtl_seq, datatex_m_subcode_detail.dtmsubcodedtl_type,
            datatex_m_subcode_hierarchy.dtmsubcodehierarchy_code, datatex_m_subcode_hierarchy.dtmsubcodehierarchy_name
            FROM datatex_m_item
            LEFT JOIN datatex_m_item_detail ON datatex_m_item_detail.dtmitem_id=datatex_m_item.dtmitem_id
            LEFT JOIN datatex_m_subcode_detail ON datatex_m_subcode_detail.dtmsubcodedtl_id=datatex_m_item_detail.dtmsubcodedtl_id
            LEFT JOIN datatex_m_subcode_hierarchy ON datatex_m_subcode_hierarchy.dtmsubcodehierarchy_id=datatex_m_item_detail.dtmsubcodehierarchy_id
            WHERE datatex_m_item.dtmitem_id = ?
            ORDER BY datatex_m_subcode_detail.dtmsubcodedtl_seq ASC
            ",
			[$dtmitem_id]
		)->result_array();

		$this->load->view($this->class_link_item . '/form_subcode', $data);
	}

	/** View from Item/form_techinf */
	public function form_techinf()
	{
		$dtmsubcode_id = $this->input->get('dtmsubcode_id');
		$dtmitem_id = $this->input->get('dtmitem_id');

		$result = $this->db->query(
			"SELECT datatex_m_subcode_tech_information.*, datatex_m_subcode.dtmsubcode_name 
            FROM datatex_m_subcode_tech_information 
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_subcode_tech_information.dtmsubcode_id
            WHERE datatex_m_subcode_tech_information.dtmsubcode_id = ?
            ORDER BY datatex_m_subcode_tech_information.dtmsubcodetechinf_seq ASC",
			array($dtmsubcode_id)
		)->result_array();

		$data['slug'] = 'EDIT';
		$data['result'] = $result;
		$data['class_link'] = $this->class_link;
		$data['selected'] = $this->db->query(
			"SELECT datatex_m_item.*, datatex_m_item_tech_information.*, datatex_m_subcode_tech_information.dtmsubcodetechinf_seq
            FROM datatex_m_item
            LEFT JOIN datatex_m_item_tech_information ON datatex_m_item_tech_information.dtmitem_id=datatex_m_item.dtmitem_id
            LEFT JOIN datatex_m_subcode_tech_information ON datatex_m_subcode_tech_information.dtmsubcodetechinf_id=datatex_m_item_tech_information.dtmsubcodetechinf_id
            WHERE datatex_m_item.dtmitem_id = ?
            ORDER BY datatex_m_subcode_tech_information.dtmsubcodetechinf_seq ASC
            ",
			[$dtmitem_id]
		)->result_array();

		$this->load->view($this->class_link_item . '/form_techinf', $data);
	}

	public function form_techinf_v2()
	{
		$dtmsubcode_id = $this->input->get('dtmsubcode_id');
		$dtmitem_id = $this->input->get('dtmitem_id');

		if (empty($dtmsubcode_id) || empty($dtmitem_id)) {
			show_error('Cannot Loaded', 200, 'Error load data');
		}

		$result = $this->db->query(
			"SELECT datatex_m_subcode_tech_information.*, datatex_m_subcode.dtmsubcode_name 
            FROM datatex_m_subcode_tech_information 
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_subcode_tech_information.dtmsubcode_id
            WHERE datatex_m_subcode_tech_information.dtmsubcode_id = ?
            ORDER BY datatex_m_subcode_tech_information.dtmsubcodetechinf_seq ASC",
			array($dtmsubcode_id)
		)->result_array();

		$data['slug'] = 'EDIT';
		$data['result'] = $result;
		$data['class_link'] = $this->class_link;
		$data['selected'] = $this->db->query(
			"SELECT datatex_m_item.*, datatex_m_item_tech_information.*, datatex_m_subcode_tech_information.dtmsubcodetechinf_seq,
            datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinfhierarchy_code, datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinfhierarchy_name
            FROM datatex_m_item
            LEFT JOIN datatex_m_item_tech_information ON datatex_m_item_tech_information.dtmitem_id=datatex_m_item.dtmitem_id
            LEFT JOIN datatex_m_subcode_tech_information ON datatex_m_subcode_tech_information.dtmsubcodetechinf_id=datatex_m_item_tech_information.dtmsubcodetechinf_id
            LEFT JOIN datatex_m_subcode_tech_inf_hierarchy ON datatex_m_subcode_tech_inf_hierarchy.dtmsubcodetechinfhierarchy_id=datatex_m_item_tech_information.dtmsubcodetechinfhierarchy_id
            WHERE datatex_m_item.dtmitem_id = ?
            ORDER BY datatex_m_subcode_tech_information.dtmsubcodetechinf_seq ASC
            ",
			[$dtmitem_id]
		)->result_array();

		$this->load->view($this->class_link_item . '/form_techinf_v2', $data);
	}

	public function form_otherinf()
	{
		$dtmitem_id = $this->input->get('dtmitem_id');

		if (empty($dtmitem_id)) {
			show_error('Cannot Loaded', 200, 'Error load data');
		}

		$data['class_link'] = $this->class_link_item;
		$data['row'] = $this->db->query(
			"SELECT datatex_m_item.*, m_um.um_id, m_um.name as um_name
            FROM datatex_m_item
            LEFT JOIN m_um ON m_um.um_id=datatex_m_item.dtmitem_uom_id
            WHERE datatex_m_item.dtmitem_id = ?
            ",
			[$dtmitem_id]
		)->row_array();

		$this->load->view($this->class_link_item . '/form_otherinf', $data);
	}

	public function tablebatch_main()
	{
		$data['class_link'] = $this->class_link;

		$this->load->view($this->class_link . '/tablebatch_main', $data);
	}

	public function action_delete_mitem()
	{
		/** Check permission */
		if (!checkPermission('MASTERITEM.PROCESSED.DELETE')) {
			header('Content-Type: application/json; charset=utf-8');
			$resp['code'] = 400;
			$resp['messages'] = 'Not Allowed';

			echo json_encode($resp);
			die();
		}

		$dtmitem_id = $this->input->get('dtmitem_id');
		if (!empty($dtmitem_id)) {
			$this->db->trans_begin();

			//Log delete
			$log['datatex_m_item'] = $this->db->query(
				"SELECT * FROM datatex_m_item WHERE dtmitem_id = ?",
				array($dtmitem_id)
			)->row_array();
			$log['datatex_m_item_detail'] = $this->db->query(
				"SELECT * FROM datatex_m_item_detail WHERE dtmitem_id = ?",
				array($dtmitem_id)
			)->result_array();
			$log['datatex_m_item_tech_information'] = $this->db->query(
				"SELECT * FROM datatex_m_item_tech_information WHERE dtmitem_id = ?",
				array($dtmitem_id)
			)->result_array();
			$dataLog = [
				'dtmitemlog_data' => json_encode($log),
				'dtmitemlog_action' => 'DELETE',
				'dtmitemlog_created_by' => isset($this->user_id) && !empty($this->user_id) ? $this->user_id : null
			];
			$this->db->insert('datatex_m_item_log', $dataLog);

			$this->db->delete('datatex_m_item', array('dtmitem_id' => $dtmitem_id));

			//Update m_item status NOT ACTIVE
			$this->db->update('m_item', ['item_status' => 1], ['item_id' => $log['datatex_m_item']['item_id']]);

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

	public function action_deletebatch()
	{
		/** Check permission */
		if (!checkPermission('MASTERITEM.PROCESSED.DELETE_BATCH')) {
			header('Content-Type: application/json; charset=utf-8');
			$resp['code'] = 400;
			$resp['messages'] = 'Not Allowed';

			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($resp);
			exit();
		}

		$dtmitem_ids = $this->input->post('dtmitem_ids');
		if (!empty($dtmitem_ids)) {
			$this->db->trans_begin();

			//Log delete
			$log['datatex_m_item'] = $this->db->query(
				"SELECT * FROM datatex_m_item WHERE dtmitem_id IN ?",
				array($dtmitem_ids)
			)->result_array();
			$log['datatex_m_item_detail'] = $this->db->query(
				"SELECT * FROM datatex_m_item_detail WHERE dtmitem_id IN ?",
				array($dtmitem_ids)
			)->result_array();
			$log['datatex_m_item_tech_information'] = $this->db->query(
				"SELECT * FROM datatex_m_item_tech_information WHERE dtmitem_id IN ?",
				array($dtmitem_ids)
			)->result_array();
			$dataLog = [
				'dtmitemlog_data' => json_encode($log),
				'dtmitemlog_action' => 'DELETE_BATCH',
				'dtmitemlog_created_by' => isset($this->user_id) && !empty($this->user_id) ? $this->user_id : null
			];
			$this->db->insert('datatex_m_item_log', $dataLog);

			for ($i = 0; $i < count($dtmitem_ids); $i++) {
				$this->db->delete('datatex_m_item', array('dtmitem_id' => $dtmitem_ids[$i]));
			}

			//UPDATE m_item EIS
			foreach ($log['datatex_m_item'] as $eachItem) {
				$arrayMitemUpdate[] = [
					'item_id' => $eachItem['item_id'],
					'item_status' => 1
				];
			}
			$this->db->update_batch('m_item', $arrayMitemUpdate, 'item_id');

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
			$resp['messages'] = 'No item selected';
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($resp);
	}

	public function action_togglevalidated()
	{
		$dtmitem_id = $this->input->get('dtmitem_id');
		if (!empty($dtmitem_id)) {
			$row = $this->db->query("select a.* from datatex_m_item a where a.dtmitem_id = ?", [$dtmitem_id])->row_array();

			$this->db->trans_begin();

			if ($row['dtmitem_validated'] == 1) {
				$dtmitem_validated = 0;
				$dtmitem_validated_at = null;
			} else {
				$dtmitem_validated = 1;
				$dtmitem_validated_at = date('Y-m-d H:i:s');
			}
			$this->db->update('datatex_m_item', ['dtmitem_validated' => $dtmitem_validated, 'dtmitem_validated_at' => $dtmitem_validated_at], ['dtmitem_id' => $dtmitem_id]);

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

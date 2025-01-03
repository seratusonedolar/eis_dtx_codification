<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Search_processed extends MY_Controller
{
	private $class_link = 'eis/search_processed';

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(['my_helper']);
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

	public function partialtablesearch()
	{
		$jsonRequest = $this->input->post('jsonRequest');

		// $jsonRequest = '
		// {
		// 	"itemtype": {
		// 	  "dtmsubcode_id": 2
		// 	},
		// 	"subcodedetails": [
		// 	  {
		// 		"dtmsubcodedtl_id": 2,
		// 		"dtmitemdtl_code": "WOV"
		// 	  },
		// 	  {
		// 		"dtmsubcodedtl_id": 3,
		// 		"dtmitemdtl_code": "DENIM"
		// 	  }
		// 	],
		// 	"dtmsubcodetechinfhierarchy_ids": [4467]
		// }';
		$arrJsonReq = json_decode($jsonRequest, true);
		$countReqDetails = count($arrJsonReq['subcodedetails']);

		$qString = "
		select a.dtmitem_id, count(a.dtmitem_id) as countitem from datatex_m_item_detail a
		left join datatex_m_item b on b.dtmitem_id = a.dtmitem_id 
		where 
		b.dtmsubcode_id = " . $arrJsonReq['itemtype']['dtmsubcode_id'] . " and 
		(";
		for ($i = 0; $i < $countReqDetails; $i++) {
			$qString .= "(a.dtmsubcodedtl_id = " . $arrJsonReq['subcodedetails'][$i]['dtmsubcodedtl_id'] . " and a.dtmitemdtl_code = '" . $arrJsonReq['subcodedetails'][$i]['dtmitemdtl_code'] . "')";
			if ($i < $countReqDetails - 1) {
				$qString .= " or ";
			}
		}
		$qString .= ")
		group by a.dtmitem_id
		;
		";

		$data['dtmitems'] = $this->db->query($qString)->result_array();
		$dtmitem_ids = array();
		foreach ($data['dtmitems'] as $e) {
			if ($e['countitem'] != $countReqDetails) {
				continue;
			}
			$dtmitem_ids[] = $e['dtmitem_id'];
		}

		// Get dtmitem from tech information
		if (!empty($arrJsonReq['dtmsubcodetechinfhierarchy_ids'])) {
			$qTechinf = $this->db->query(
				"select a.dtmitem_id from datatex_m_item_tech_information a
			where a.dtmsubcodetechinfhierarchy_id in ? and a.dtmitem_id in ? group by a.dtmitem_id",
				[$arrJsonReq['dtmsubcodetechinfhierarchy_ids'], $dtmitem_ids]
			)->result_array();
			
			$dtmitem_ids = array_column($qTechinf, 'dtmitem_id');
		}

		$data['dtmitemfilters'] = [];
		if (!empty($dtmitem_ids)) {
			$data['dtmitemfilters'] = $this->db->query(
				"select g.name as classname, h.name as subclassname,
				a.dtmitem_id, a.item_id, a.dtmitem_uom_id, a.dtmitem_created_by, a.dtmitem_created_at, a.dtmitem_updated_at, a.dtmitem_code, dtmitem_validated_at,
				b.dtmitemdtl_code,
				c.dtmsubcodedtl_type,
				d.dtmsubcodehierarchy_name, d.dtmsubcodehierarchy_state, d.dtmsubcode_note_validate, d.dtmsubcode_upload_qa, d.dtmsubcode_upload_prod,
				e.dtmsubcode_code,
				f.name, f.um_id, a.dtmitem_uom_id
				from datatex_m_item a
				left join datatex_m_item_detail b on b.dtmitem_id = a.dtmitem_id
				left join datatex_m_subcode_detail c on b.dtmsubcodedtl_id = c.dtmsubcodedtl_id 
				left join datatex_m_subcode_hierarchy d on d.dtmsubcodehierarchy_id = b.dtmsubcodehierarchy_id 
				left join datatex_m_subcode e on e.dtmsubcode_id = a.dtmsubcode_id 
				left join m_item f on f.item_id = a.item_id 
				LEFT JOIN m_classification g ON g.classif_id=f.classif_id
				LEFT JOIN m_subclassification h ON h.subclassif_id=f.subclassif_id
				where a.dtmitem_id in ?  order by a.dtmitem_id, c.dtmsubcodedtl_seq; ",
				[$dtmitem_ids]
			)->result_array();

			//Technical information
			$data['techinfsubcode'] = $this->db->query(
				"select * from datatex_m_subcode_tech_information a 
				where a.dtmsubcode_id = ? 
				order by a.dtmsubcodetechinf_seq", [$arrJsonReq['itemtype']['dtmsubcode_id']]
			)->result_array();
			$data['techinfsubcodeData'] = $this->db->query(
					"select * from datatex_m_item_tech_information a 
					left join datatex_m_subcode_tech_information b on b.dtmsubcodetechinf_id = a.dtmsubcodetechinf_id
					left join datatex_m_subcode_tech_inf_hierarchy c on c.dtmsubcodetechinfhierarchy_id = a.dtmsubcodetechinfhierarchy_id
					where a.dtmitem_id in ?
					order by b.dtmsubcodetechinf_seq", [$dtmitem_ids]
			)->result_array();
		}
		$data['class_link'] = $this->class_link;

		$this->load->view($this->class_link . '/partialtablesearch', $data);
	}

	public function partialformsearch()
	{
		$dtmsubcode_id1 = $this->input->get('dtmsubcode_id1');

		$data['class_link'] = $this->class_link;

		$this->load->view($this->class_link . '/partialformsearch', $data);
	}

	public function partialformsearchsubcode()
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

		$this->load->view($this->class_link . '/partialformsearchsubcode', $data);
	}

	public function partialformsearchtechinf()
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
		$data['dtmsubcode_id'] = $dtmsubcode_id;

		$this->load->view($this->class_link . '/partialformsearchtechinf', $data);
	}

	public function search_item()
	{
		$dtmsubcode_id1 = $this->input->post('dtmsubcode_id1');

		$this->load->library(['form_validation']);
		$this->form_validation->set_rules('dtmsubcode_id1', 'Classif', 'required');

		if ($this->form_validation->run() == FALSE) {
			$resp['code'] = 400;
			$resp['messages'] = validation_errors();

			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($resp);
			exit();
		}

		// $jsonRequest = '
		// {
		// 	"itemtype": {
		// 	  "dtmsubcode_id": 2
		// 	},
		// 	"subcodedetails": [
		// 	  {
		// 		"dtmsubcodedtl_id": 2,
		// 		"dtmitemdtl_code": "WOV"
		// 	  },
		// 	  {
		// 		"dtmsubcodedtl_id": 3,
		// 		"dtmitemdtl_code": "DENIM"
		// 	  }
		// 	]
		// }';
		$subcodes = $this->db->query("select * from datatex_m_subcode_detail where dtmsubcode_id = ? order by dtmsubcodedtl_seq asc ", [$dtmsubcode_id1])->result_array();
		$groupSubcodesSeq = [];
		foreach ($subcodes as $esub) {
			$groupSubcodesSeq[$esub['dtmsubcodedtl_seq']] = $esub['dtmsubcodedtl_id'];
		}

		$subcodedetails = array();
		foreach ($subcodes as $eSubc) {
			if (empty($this->input->post('seq' . $eSubc['dtmsubcodedtl_seq'] . 'code'))) {
				continue;
			}
			$dtmsubcodedtl_id = $groupSubcodesSeq[$eSubc['dtmsubcodedtl_seq']] ?? null;
			$subcodedetails[] = [
				'dtmsubcodedtl_id' => (int)$dtmsubcodedtl_id,
				'dtmitemdtl_code' => $this->input->post('seq' . $eSubc['dtmsubcodedtl_seq'] . 'code') ?? null,
				'dtmitemdtl_seq' => $eSubc['dtmsubcodedtl_seq']
			];
		}

		if (empty($subcodedetails)) {
			$resp['code'] = 400;
			$resp['messages'] = "Detail Null";

			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($resp);
			exit();
		}

		$arrJsonRequest['itemtype']['dtmsubcode_id'] = $dtmsubcode_id1;
		$arrJsonRequest['subcodedetails'] = $subcodedetails;
		$arrJsonRequest['dtmsubcodetechinfhierarchy_ids'] = $this->input->post('dtmsubcodetechinfhierarchy_ids');

		$resp['jsonRequest'] = json_encode($arrJsonRequest, true);

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($resp);
	}
}

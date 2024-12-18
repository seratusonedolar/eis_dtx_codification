<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Datatech_dictionary extends MY_Controller
{
	private $class_link = 'eis/datatech_dictionary';

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
		$type_code = $this->input->post('id');

// 		$data['dictionary'] = $this->db->query("select a.item_id,a.itemtypecode,
// case when a.status_subcode = 'confirmed' then a.status_subcode else b.status_subcode end status_subcode,
// case when a.dtxsequence != '' then a.dtxsequence else b.dtxsequence end dtxsequence
// from  
// (select a.dtxsequence, b.item_id, c.status_subcode,b.itemtypecode 
// 		from datatex_productibeandtl_241126 b
// 		LEFT JOIN datatex_productibean_241126 a ON a.dtxproductibeanid = b.dtxproductibeanid 
// 		LEFT JOIN datatex_productibeandtl_status_241126 c ON b.dtmitem_id = c.dtmitem_id 
// 		WHERE b.itemtypecode = '$type_code') a 
// left join 				
// (select a.dtxsequence, b.item_id, c.status_subcode,b.itemtypecode 
// 		from datatex_productibeandtl_240706 b
// 		LEFT JOIN datatex_productibean_240706 a ON a.dtxproductibeanid = b.dtxproductibeanid 
// 		LEFT JOIN datatex_productibeandtl_status_240706 c ON b.dtmitem_id = c.dtmitem_id 
// 		WHERE b.itemtypecode = '$type_code') b on a.item_id=b.item_id")->result_array();

		$data['dictionary'] = $this->db->query("select z.dtxsequence_prod, z.item_id, c.status_subcode,b.itemtypecode 
		from datatex_m_item z
		left join datatex_productibeandtl_241126 b on z.dtmitem_id=b.dtmitem_id
		LEFT JOIN datatex_productibeandtl_status_241126 c ON b.dtmitem_id = c.dtmitem_id 
		WHERE b.itemtypecode = '$type_code'")->result_array();

		$data['class_link'] = $this->class_link;
		$this->load->view($this->class_link . '/partialtablesearch', $data);
	}
}

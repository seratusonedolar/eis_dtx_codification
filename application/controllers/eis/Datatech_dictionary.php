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

		$data['dictionary'] = $this->db->query("select a.dtxsequence, b.item_id, c.status_subcode,b.itemtypecode 
		from datatex_productibeandtl_240706 b
		LEFT JOIN datatex_productibean_240706 a ON a.dtxproductibeanid = b.dtxproductibeanid 
		LEFT JOIN datatex_productibeandtl_status_240706 c ON b.dtmitem_id = c.dtmitem_id 
		WHERE b.itemtypecode = ?", [$type_code])->result_array();

		$data['class_link'] = $this->class_link;
		$this->load->view($this->class_link . '/partialtablesearch', $data);
	}
}

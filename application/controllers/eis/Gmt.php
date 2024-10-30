<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Gmt extends MY_Controller
{
    private $class_link = 'eis/gmt';

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(['my_helper']);
	}

	public function index () {
		parent::baseTemplate();
		parent::datatablesAssets();
		parent::select2Assets();
		parent::toastAssets();

		$data['class_link'] = $this->class_link;

		$this->load->view($this->class_link . '/index', $data);
	}

	public function get_unique_categories() {
        $query = $this->db->query("
            SELECT DISTINCT ON (dtscfinhie_type) dtscfinhie_type
            FROM datatex_scopefin_hierarchy
            ORDER BY dtscfinhie_type;
        ");
        $result = $query->result_array();

		echo json_encode($result);
    }

	// function search data GMT, HARDCODE dtscfinhie_version
	public function partialformsearchcategory() {
		$dtscfinhie_type = $this->input->get('dtscfinhie_type');
		print_r($dtscfinhie_type);
		$result = $this->db->query(
			"SELECT *
			FROM datatex_scopefin_hierarchy
			where dtscfinhie_type = ? 
			and dtscfinhie_version = 11
			ORDER BY sub2_buyer ASC",
			array($dtscfinhie_type)
		)->result_array();

		$data['result'] = $result;
		// $data['dtmsubcode_id'] = $dtmsubcode_id;
		$data['class_link'] = $this->class_link;

		$this->load->view($this->class_link . '/partialtablesearch', $data);
	}

}

<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class BrandModel extends CI_model
{
	private $tbl_name = 'plm_brands';

	public function ssp_table($trash = false)
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$whereParam = '';
		if ($trash == true){
			$whereParam = ' NOT ';
		}

		$data = [];
		$qData = $this->db->query("
			SELECT {$this->tbl_name}.*, m_company.name, m_company.parent_company_id, plm_customers.plmcustomer_node_name FROM {$this->tbl_name} 
			LEFT JOIN m_company ON m_company.company_id={$this->tbl_name}.company_id
			LEFT JOIN plm_customers ON plm_customers.plmcustomer_plm_id={$this->tbl_name}.plmcustomer_plm_id
			WHERE ($this->tbl_name).plmbrand_deleted_at IS $whereParam NULL
			ORDER BY {$this->tbl_name}.plmbrand_modified_at DESC");
		$no = 1;
		foreach ($qData->result_array() as $r) {
			$data[] = [
				'0' => $no,
				'1' => $this->generateAction($r['plmbrand_plm_id'], $trash),
				'2' => $r['plmbrand_plm_id'],
				'3' => $r['plmbrand_code'],
				'4' => $r['plmbrand_node_name'],
				'5' => $r['plmbrand_contribution_machine_shift_min_required'],
				'6' => $r['plmbrand_cm_min_required'],
				'7' => $r['plmbrand_gm_bu_required'],
				'8' => $r['plmcustomer_node_name'],
				'9' => $r['company_id'],
				'10' => $r['parent_company_id'],
				'11' => $r['name'],
				'12' => $r['plmbrand_modified_at'],
				'13' => $r['plmbrand_sync_at']
			];
			$no++;
		}

		$output = array(
			'draw' => $draw,
			'recordsTotal' => count($data),
			'recordsFiltered' => count($data),
			'data' => $data
		);
		return $output;
	}

	private function generateAction($param, $trash = false)
	{
		$param = urlencode($param);
		$actions = [
			'Edit' => "editData('$param')",
			'Delete' => "deleteData('$param')"
		];
		if ($trash == true){
			$actions = [
				'Restore' => "restoreData('$param')",
			];
		}
		return $actions;
	}

	public function insert_data($data)
	{
		$query = $this->db->insert($this->tbl_name, $data);
		return $query ? TRUE : FALSE;
	}

	public function delete_data($id)
	{
		$query = $this->db->delete($this->tbl_name, array($this->p_key => $id));
		return $query ? TRUE : FALSE;
	}

	public function get_by_param($param = [])
	{
		$this->db->where($param);
		$act = $this->db->get($this->tbl_name);
		return $act;
	}

	public function get_all()
	{
		$act = $this->db->get($this->tbl_name);
		return $act;
	}

	public function update_data($aWhere = [], $data)
	{
		$query = $this->db->update($this->tbl_name, $data, $aWhere);
		return $query ? TRUE : FALSE;
	}
	public function insert_batch($data)
	{
		$act = $this->db->insert_batch($this->tbl_name, $data);
		return $act;
	}

	public function get_by_param_in($param, $params = [])
	{
		$this->db->where_in($param, $params);
		$act = $this->db->get($this->tbl_name);
		return $act;
	}
}

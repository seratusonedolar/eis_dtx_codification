<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class ProductTypeSecondModel extends CI_model
{
	private $tbl_name = 'plm_product_type_second';

	public function ssp_table()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$data = [];
		$qData = $this->db->query("
			SELECT {$this->tbl_name}.*, m_prod_types.* FROM {$this->tbl_name} 
			LEFT JOIN m_prod_types ON m_prod_types.product_types_id={$this->tbl_name}.product_types_id
			ORDER BY {$this->tbl_name}.plmproducttypesecond_modified_at DESC");
		$no = 1;
		foreach ($qData->result_array() as $r) {
			$data[] = [
				'0' => $no,
				'1' => $this->generateAction($r['plmproducttypesecond_id']),
				'2' => $r['plmproducttypesecond_node_name'],
				'3' => $r['product_types_id'],
				'4' => $r['product_types_name'],
				'5' => $r['plmproducttypesecond_modified_at'],
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

	private function generateAction($param)
	{
		$param = urlencode($param);
		$actions = [
			'Edit' => "editData('$param')",
			// 'Delete' => "deleteData('$param')"
		];
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

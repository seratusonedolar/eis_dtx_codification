<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class SupplierItemRevisionLogModel extends CI_model
{
	private $tbl_name = 'plm_supplieritemrevision_logs';

	public function ssp_table($transactionDate)
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$data = [];
		$qData = $this->db->query("
			SELECT {$this->tbl_name}.* FROM {$this->tbl_name} 
            WHERE {$this->tbl_name}.plmsupplieritemrevisionlog_sync_at::date = '{$transactionDate}'
			ORDER BY {$this->tbl_name}.plmsupplieritemrevisionlog_sync_at DESC");
		$no = 1;
		foreach ($qData->result_array() as $r) {
			$data[] = [
				'0' => $no,
				'1' => $this->generateAction($r['plmsupplieritemrevisionlog_id']),
				'2' => $r['plmsupplieritemrevisionlog_plm_id'],
				'3' => $r['plmsupplieritemrevisionlog_json_plm'],
				'4' => $r['plmsupplieritemrevisionlog_json_eqs'],
				'5' => $r['plmsupplieritemrevisionlog_image_base64'],
				'6' => $r['plmsupplieritemrevisionlog_validation'],
				'7' => $r['plmsupplieritemrevisionlog_status'],
				'8' => $r['plmsupplieritemrevisionlog_sync_at'],
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
			'View' => "viewData('$param')",
			'View PDF' => "viewDataPDF('$param')",
			'Send to EIS Robot' => "sendData('$param')"
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

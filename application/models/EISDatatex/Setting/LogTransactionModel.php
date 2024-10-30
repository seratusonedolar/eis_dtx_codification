<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class LogTransactionModel extends CI_model
{
    private $tbl_name = 'datatex_m_item_log';

    public function __construct()
    {
        parent::__construct();
    }

    public function generateLog($data = [], $action = '', $createdBy = 0)
    {
        $dataLog = [
            'dtmitemlog_data' => json_encode($data),
            'dtmitemlog_action' => $action,
            'dtmitemlog_created_by' => $createdBy
        ];
        $this->db->trans_begin();

        $this->insert_data($dataLog);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', 'Error Insert Logging');
        } else {
            $this->db->trans_commit();
        }

        return true;
    }

    public function insert_data($data)
    {
        $query = $this->db->insert($this->tbl_name, $data);
        return $query ? TRUE : FALSE;
    }

    // public function delete_data($id)
    // {
    // 	$query = $this->db->delete($this->tbl_name, array($this->p_key => $id));
    // 	return $query ? TRUE : FALSE;
    // }

    // public function get_by_param($param = [])
    // {
    // 	$this->db->where($param);
    // 	$act = $this->db->get($this->tbl_name);
    // 	return $act;
    // }

    // public function update_data($aWhere = [], $data)
    // {
    // 	$query = $this->db->update($this->tbl_name, $data, $aWhere);
    // 	return $query ? TRUE : FALSE;
    // }
    // public function insert_batch($data)
    // {
    // 	$act = $this->db->insert_batch($this->tbl_name, $data);
    // 	return $act;
    // }

    // public function get_by_param_in($param, $params = [])
    // {
    // 	$this->db->where_in($param, $params);
    // 	$act = $this->db->get($this->tbl_name);
    // 	return $act;
    // }
}

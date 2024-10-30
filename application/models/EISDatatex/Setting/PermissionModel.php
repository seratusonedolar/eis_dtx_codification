<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class PermissionModel extends CI_model
{
	public $permissions = array();

	public function __construct()
	{
		parent::__construct();
		$this->permissions = array(
			'SETTING.READ' => 'Setting - Read; Mandatory for administrator role',
			'SETTING.ROLE.READ' => 'Setting - Role Read Sidebar',
			'SETTING.SCOPEITEM.READ' => 'Setting - Role Read Sidebar',
			'MASTERITEM.READ' => 'Master Item - Role Read Sidebar',
			'MASTERITEM.CODIFICATION.READ' => 'Master Item - Role Read Sidebar',
			'MASTERITEM.CODIFICATION.ADD' => 'Master Item - Role Read Sidebar',
			'MASTERITEM.CODIFICATION.EDIT' => 'Master Item - Role edit',
			'MASTERITEM.CODIFICATION.EDIT.CODE' => 'By default cannot edit Code in hierarchy, but if is checked, will be allowed to edit code',
			'MASTERITEM.CODIFICATION.DELETE' => 'Master Item - Role del',
			'MASTERITEM.CODIFICATION.INSERTBATCH' => 'Master Item - Update Batch',

			'MASTERITEM.CODIFICATION.SUBCODEDETAIL.ADD' => 'Mastersubcode 1- 10 Role',
			'MASTERITEM.CODIFICATION.SUBCODEDETAIL.READ' => 'Mastersubcode 1- 10 Role',
			'MASTERITEM.CODIFICATION.SUBCODEDETAIL.EDIT' => 'Mastersubcode 1- 10 Role',
			'MASTERITEM.CODIFICATION.SUBCODEDETAIL.DELETE' => 'Mastersubcode 1- 10 Role',

			'MASTERITEM.CODIFICATION.SUBCODEHIERARCHY.ALL.MAIN_CATEGORY.READ' => 'Special case for ALL.MAIN_CATEGORY',

			'MASTERITEM.EIS.READ' => 'Master Item - EIS Read Sidebar',
			'MASTERITEM.EIS.INSERTBATCH' => 'Master Item - EIS Read Sidebar',
			'MASTERITEM.PROCESSED.READ' => 'Master Item - Processrd Read Sidebar',
			'MASTERITEM.PROCESSED.READ_ALL_RESULT' => 'Item Processed; by default can view only processed by you',
			'MASTERITEM.PROCESSED.EDIT' => 'Master Item - Processed Del',
			'MASTERITEM.PROCESSED.DELETE' => 'Master Item - Processed Del',
			'MASTERITEM.PROCESSED.DELETE_BATCH' => 'Master Item processd - Processed Del batch',

			'MASTERIMTEM.PROCESSEDSEARCH' => "Search Datatex Processed",
			'LOGSYSTEM.READ' => 'Log Sys Read Sidebar'
		);
	}

	public function get_all()
	{
		return $this->permissions;
	}

	public function checkPermission($user_id, $permission_name)
	{
		if (!empty($user_id) && !empty($permission_name)) {
			$userPermission = $this->db->query(
				"SELECT datatex_m_role_permission.dtmrolepermission_id 
				FROM datatex_m_role_user 
				LEFT JOIN datatex_m_role ON datatex_m_role.dtmrole_id = datatex_m_role_user.dtmrole_id 
				LEFT JOIN datatex_m_role_permission ON datatex_m_role_permission.dtmrole_id = datatex_m_role.dtmrole_id
				WHERE datatex_m_role_user.user_id = ? AND datatex_m_role_permission.dtmrolepermission_name = ?",
				array($user_id, $permission_name)
			)->num_rows();

			if (!empty($userPermission)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function check_approval($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('datatex_m_role_user');
        $row = $query->row();
        return !empty($row) && $row->approval;
    }

	public function checkUploaded($dtmitem_id){
		$query = $this->db->query("SELECT dtp.dtxsequence 
			FROM datatex_productibean_240706 dtp
			LEFT JOIN datatex_productibeandtl_240706 dtl 
			ON dtp.dtxproductibeanid = dtl.dtxproductibeanid 
			WHERE dtl.dtmitem_id = ?", array($dtmitem_id));

			if ($query->num_rows() > 0) {
				// Ambil hasil sebagai array asosiatif
				$result = $query->row_array();

				// Cek nilai dari dtxsequence
				if (isset($result['dtxsequence']) && $result['dtxsequence'] !== NULL && trim($result['dtxsequence']) !== '') {
					return TRUE;
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
	}

	// public function insert_data($data)
	// {
	// 	$query = $this->db->insert($this->tbl_name, $data);
	// 	return $query ? TRUE : FALSE;
	// }

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

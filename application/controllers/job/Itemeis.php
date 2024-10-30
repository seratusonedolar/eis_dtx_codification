<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Itemeis extends CI_Controller
{
	private function itemClassifScope()
	{
		$q = $this->db->query("SELECT * FROM datatex_scope_item_sync WHERE scopeitemsync_id = ?", ['ITEMSCOPE'])->row();
		return explode(';', $q->scopeitemsync_string);
	}

	private function getLastSyncTime()
	{
		$q = $this->db->query("SELECT * FROM datatex_scope_item_sync WHERE scopeitemsync_id = ?", ['LASTSYNC'])->row();
		return $q->scopeitemsync_timestamp;
	}

	private function action_updatelastsync()
	{
		return $this->db->update('datatex_scope_item_sync', ['scopeitemsync_timestamp' => date('Y-m-d H:i:s')], ['scopeitemsync_id' => 'LASTSYNC']);
	}

	private function action_submitnewscope()
	{
		$q = $this->db->query("
			SELECT MI.ITEM_ID, STRING_AGG(DISTINCT(PRM.BUYER_ID), ', ') AS DTSCOPEITEM_BUYER_IDS FROM M_ITEM MI
			LEFT JOIN PURCHASE_REQUISITION_DETAIL PRD ON MI.ITEM_ID=PRD.ITEM_ID
			LEFT JOIN PURCHASE_REQUISITION_MASTER PRM ON PRD.PR_NO=PRM.PR_NO
			LEFT JOIN DATATEX_SCOPE_ITEM DSI ON DSI.ITEM_ID = MI.ITEM_ID 
			WHERE MI.CREATED_DATE >= ?
			AND MI.CLASSIF_ID IN ?
			AND MI.PARENT_ITEM_ID IS NULL 
			AND DSI.ITEM_ID IS NULL
			GROUP BY MI.ITEM_ID", [$this->getLastSyncTime(), $this->itemClassifScope()])
			->result();

		$scopeArray = array();
		foreach ($q as $each) {
			$scopeArray[] = [
				'item_id' => $each->item_id,
				'dtscopeitem_buyer_ids' => $each->dtscopeitem_buyer_ids
			];
		}
		$this->db->trans_begin();
		if (!empty($scopeArray)) {
			$this->db->insert_batch('datatex_scope_item', $scopeArray);

			$this->action_updatelastsync();
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}

		return $scopeArray;
	}

	public function sync()
	{
		log_message('ERROR', json_encode($this->action_submitnewscope()));
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class AdstorageBeanDetailService extends CI_model
{
	public function generateTechInformationFAB()
	{
		try {
			$result = $this->db->query("
			select * from datatex_productibeandtl_240706 a
			left join datatex_m_item b on b.dtmitem_id = a.dtmitem_id 
			left join datatex_m_item_tech_information c on c.dtmitem_id = a.dtmitem_id 
			left join datatex_m_subcode_tech_information d on d.dtmsubcodetechinf_id = c.dtmsubcodetechinf_id 
			left join datatex_m_subcode_tech_inf_hierarchy e on e.dtmsubcodetechinfhierarchy_id = c.dtmsubcodetechinfhierarchy_id
			where a.itemtypecode = 'FAB' 
			and d.dtmsubcodetechinf_remark <> 'Pattern#'
		")->result_array();
			$groupByDtmitemid = [];
			foreach ($result as $r0) {
				$groupByDtmitemid[$r0['dtmitem_id']][] = $r0;
			}
			foreach ($groupByDtmitemid as $dtmitemid => $elements) {
				foreach ($elements as $r) {
					$arrData[] = [
						'dtmitem_id' => $r['dtmitem_id'],
						'item_id' => $r['item_id'],
						// 'fatherid' => null,
						// 'importautocounter' => null,
						'nameentityname' => 'Product',
						'namename' => $r['dtmsubcodetechinf_prodnamename'],
						'fieldname' => $r['dtmsubcodetechinf_prodnamename'],
						'codestring' => $r['dtmsubcodetechinfhierarchy_code'],
						'valuestring' => $r['dtmsubcodetechinfhierarchy_name'],
						// 'valueint' => null,
						// 'valueboolean' => null,
						// 'valuedate' => null,
						// 'valuedecimal' => null,
						// 'valuelong' => null,
						// 'valuetime' => null,
						// 'valuetimestamp' => null,
						// 'wsoperation' => null,
						// 'impoperationuser' => null,
						// 'importstatus' => null,
						// 'impcreationdatetime' => null,
						// 'impcreationuser' => null,
						// 'implastupdatedatetime' => null,
						// 'implastupdateuser' => null,
						// 'importdatetime' => null,
						// 'retrynr' => null,
						// 'nextretry' => null,
						// 'importid' => null
					];
				}
				array_push($arrData,  [
					'dtmitem_id' => $r['dtmitem_id'],
					'item_id' => $r['item_id'],
					// 'fatherid' => null,
					// 'importautocounter' => null,
					'nameentityname' => 'Product',
					'namename' => 'Remark',
					'fieldname' => 'Remark',
					'codestring' => null,
					'valuestring' => substr($r['dtmitem_description'], 0, 250),
					// 'valueint' => null,
					// 'valueboolean' => null,
					// 'valuedate' => null,
					// 'valuedecimal' => null,
					// 'valuelong' => null,
					// 'valuetime' => null,
					// 'valuetimestamp' => null,
					// 'wsoperation' => null,
					// 'impoperationuser' => null,
					// 'importstatus' => null,
					// 'impcreationdatetime' => null,
					// 'impcreationuser' => null,
					// 'implastupdatedatetime' => null,
					// 'implastupdateuser' => null,
					// 'importdatetime' => null,
					// 'retrynr' => null,
					// 'nextretry' => null,
					// 'importid' => null
				]);
			}

			$this->db->trans_begin();
			$this->db->insert_batch('datatex_adstoragebeandtl', $arrData);

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				var_dump("FAIL");
				$resp['code'] = 400;
				$resp['messages'] = 'Error';
			} else {
				$this->db->trans_commit();
				var_dump("DONE");
				$resp['code'] = 200;
				$resp['messages'] = 'Success';
			}

			// log_message('debug', json_encode($arrData, JSON_PRETTY_PRINT));
			// var_dump(count($arrData));
			// var_dump("DONE");
			return $resp;
		} catch (Exception $e) {
			var_dump($e);
		}
	}

	public function generateTechInformationTRM()
	{
		try {
			$result = $this->db->query("
			select * from datatex_productibeandtl_240706 a
			left join datatex_m_item b on b.dtmitem_id = a.dtmitem_id 
			left join datatex_m_item_tech_information c on c.dtmitem_id = a.dtmitem_id 
			left join datatex_m_subcode_tech_information d on d.dtmsubcodetechinf_id = c.dtmsubcodetechinf_id 
			left join datatex_m_subcode_tech_inf_hierarchy e on e.dtmsubcodetechinfhierarchy_id = c.dtmsubcodetechinfhierarchy_id
			where a.itemtypecode = 'TRM' 
			and d.dtmsubcodetechinf_remark <> 'Pattern#'
		")->result_array();
			$groupByDtmitemid = [];
			foreach ($result as $r0) {
				$groupByDtmitemid[$r0['dtmitem_id']][] = $r0;
			}
			foreach ($groupByDtmitemid as $dtmitemid => $elements) {
				foreach ($elements as $r) {
					$arrData[] = [
						'dtmitem_id' => $r['dtmitem_id'],
						'item_id' => $r['item_id'],
						// 'fatherid' => null,
						// 'importautocounter' => null,
						'nameentityname' => 'Product',
						'namename' => $r['dtmsubcodetechinf_prodnamename'],
						'fieldname' => $r['dtmsubcodetechinf_prodnamename'],
						'codestring' => $r['dtmsubcodetechinfhierarchy_code'],
						'valuestring' => $r['dtmsubcodetechinfhierarchy_name'],
						// 'valueint' => null,
						// 'valueboolean' => null,
						// 'valuedate' => null,
						// 'valuedecimal' => null,
						// 'valuelong' => null,
						// 'valuetime' => null,
						// 'valuetimestamp' => null,
						// 'wsoperation' => null,
						// 'impoperationuser' => null,
						// 'importstatus' => null,
						// 'impcreationdatetime' => null,
						// 'impcreationuser' => null,
						// 'implastupdatedatetime' => null,
						// 'implastupdateuser' => null,
						// 'importdatetime' => null,
						// 'retrynr' => null,
						// 'nextretry' => null,
						// 'importid' => null
					];
				}
				array_push($arrData,  [
					'dtmitem_id' => $r['dtmitem_id'],
					'item_id' => $r['item_id'],
					// 'fatherid' => null,
					// 'importautocounter' => null,
					'nameentityname' => 'Product',
					'namename' => 'Remark',
					'fieldname' => 'Remark',
					'codestring' => null,
					'valuestring' => substr($r['dtmitem_description'], 0, 250),
					// 'valueint' => null,
					// 'valueboolean' => null,
					// 'valuedate' => null,
					// 'valuedecimal' => null,
					// 'valuelong' => null,
					// 'valuetime' => null,
					// 'valuetimestamp' => null,
					// 'wsoperation' => null,
					// 'impoperationuser' => null,
					// 'importstatus' => null,
					// 'impcreationdatetime' => null,
					// 'impcreationuser' => null,
					// 'implastupdatedatetime' => null,
					// 'implastupdateuser' => null,
					// 'importdatetime' => null,
					// 'retrynr' => null,
					// 'nextretry' => null,
					// 'importid' => null
				]);
			}

			$this->db->trans_begin();
			$this->db->insert_batch('datatex_adstoragebeandtl', $arrData);

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				var_dump("FAIL");
				$resp['code'] = 400;
				$resp['messages'] = 'Error';
			} else {
				$this->db->trans_commit();
				var_dump("DONE");
				$resp['code'] = 200;
				$resp['messages'] = 'Success';
			}

			// log_message('debug', json_encode($arrData, JSON_PRETTY_PRINT));
			// var_dump(count($arrData));
			// var_dump("DONE");
			return $resp;
		} catch (Exception $e) {
			var_dump($e);
		}
	}

	public function generateTechInformationPKG()
	{
		try {
			$result = $this->db->query("
			select * from datatex_productibeandtl_240706 a
			left join datatex_m_item b on b.dtmitem_id = a.dtmitem_id 
			left join datatex_m_item_tech_information c on c.dtmitem_id = a.dtmitem_id 
			left join datatex_m_subcode_tech_information d on d.dtmsubcodetechinf_id = c.dtmsubcodetechinf_id 
			left join datatex_m_subcode_tech_inf_hierarchy e on e.dtmsubcodetechinfhierarchy_id = c.dtmsubcodetechinfhierarchy_id
			where a.itemtypecode = 'PKG' 
			and d.dtmsubcodetechinf_remark <> 'Pattern#'
		")->result_array();
			$groupByDtmitemid = [];
			foreach ($result as $r0) {
				$groupByDtmitemid[$r0['dtmitem_id']][] = $r0;
			}
			foreach ($groupByDtmitemid as $dtmitemid => $elements) {
				foreach ($elements as $r) {
					$arrData[] = [
						'dtmitem_id' => $r['dtmitem_id'],
						'item_id' => $r['item_id'],
						// 'fatherid' => null,
						// 'importautocounter' => null,
						'nameentityname' => 'Product',
						'namename' => $r['dtmsubcodetechinf_prodnamename'],
						'fieldname' => $r['dtmsubcodetechinf_prodnamename'],
						'codestring' => $r['dtmsubcodetechinfhierarchy_code'],
						'valuestring' => $r['dtmsubcodetechinfhierarchy_name'],
						// 'valueint' => null,
						// 'valueboolean' => null,
						// 'valuedate' => null,
						// 'valuedecimal' => null,
						// 'valuelong' => null,
						// 'valuetime' => null,
						// 'valuetimestamp' => null,
						// 'wsoperation' => null,
						// 'impoperationuser' => null,
						// 'importstatus' => null,
						// 'impcreationdatetime' => null,
						// 'impcreationuser' => null,
						// 'implastupdatedatetime' => null,
						// 'implastupdateuser' => null,
						// 'importdatetime' => null,
						// 'retrynr' => null,
						// 'nextretry' => null,
						// 'importid' => null
					];
				}
				array_push($arrData,  [
					'dtmitem_id' => $r['dtmitem_id'],
					'item_id' => $r['item_id'],
					// 'fatherid' => null,
					// 'importautocounter' => null,
					'nameentityname' => 'Product',
					'namename' => 'Remark',
					'fieldname' => 'Remark',
					'codestring' => null,
					'valuestring' => substr($r['dtmitem_description'], 0, 250),
					// 'valueint' => null,
					// 'valueboolean' => null,
					// 'valuedate' => null,
					// 'valuedecimal' => null,
					// 'valuelong' => null,
					// 'valuetime' => null,
					// 'valuetimestamp' => null,
					// 'wsoperation' => null,
					// 'impoperationuser' => null,
					// 'importstatus' => null,
					// 'impcreationdatetime' => null,
					// 'impcreationuser' => null,
					// 'implastupdatedatetime' => null,
					// 'implastupdateuser' => null,
					// 'importdatetime' => null,
					// 'retrynr' => null,
					// 'nextretry' => null,
					// 'importid' => null
				]);
			}

			$this->db->trans_begin();
			$this->db->insert_batch('datatex_adstoragebeandtl', $arrData);

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				var_dump("FAIL");
				$resp['code'] = 400;
				$resp['messages'] = 'Error';
			} else {
				$this->db->trans_commit();
				var_dump("DONE");
				$resp['code'] = 200;
				$resp['messages'] = 'Success';
			}

			// log_message('debug', json_encode($arrData, JSON_PRETTY_PRINT));
			// var_dump(count($arrData));
			// var_dump("DONE");
			return $resp;
		} catch (Exception $e) {
			var_dump($e);
		}
	}
}

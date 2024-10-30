<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class ProductIBeanDetailService extends CI_model
{
	public function generateProductIbeanDetail($itemtype = 'FAB')
	{
		$this->db->trans_begin();

		$result = $this->db->query(
			"select * from datatex_m_item a
			left join datatex_m_subcode b on b.dtmsubcode_id = a.dtmsubcode_id
			left join datatex_m_item_detail c on c.dtmitem_id = a.dtmitem_id
			left join datatex_m_subcode_detail d on d.dtmsubcodedtl_id  = c.dtmsubcodedtl_id  
			where b.dtmsubcode_code = ?
			order by a.item_id, d.dtmsubcodedtl_seq asc",
			[$itemtype]
		)->result_array();

		$aGroupBydtmitemid = [];
		foreach ($result as $r) {
			$aGroupBydtmitemid[$r['item_id']][] = $r;
		}

		$arrData = [];
		foreach ($aGroupBydtmitemid as $item_id => $elements) {
			$aSubcode = [];
			foreach ($elements as $el) {
				switch ($el['dtmsubcodedtl_seq']) {
					case 1:
						$subcode01 = $el['dtmitemdtl_code'];
						break;
					case 2:
						$subcode02 = $el['dtmitemdtl_code'];
						break;
					case 3:
						$subcode03 = $el['dtmitemdtl_code'];
						break;
					case 4:
						$subcode04 = $el['dtmitemdtl_code'];
						break;
					case 5:
						$subcode05 = $el['dtmitemdtl_code'];
						break;
					case 6:
						$subcode06 = $el['dtmitemdtl_code'];
						break;
					case 7:
						$subcode07 = $el['dtmitemdtl_code'];
						break;
					case 8:
						$subcode08 = $el['dtmitemdtl_code'];
						break;
					case 9:
						$subcode09 = $el['dtmitemdtl_code'];
						break;
					case 10:
						$subcode10 = $el['dtmitemdtl_code'];
						break;
				}

				//subcode
				$aSubcode[] = $el['dtmitemdtl_code'];
			}
			$arrData[] = [
				'itemtypecode' => $itemtype,
				'subcode01' => $subcode01 ?? null,
				'subcode02' => $subcode02 ?? null,
				'subcode03' => $subcode03 ?? null,
				'subcode04' => $subcode04 ?? null,
				'subcode05' => $subcode05 ?? null,
				'subcode06' => $subcode06 ?? null,
				'subcode07' => $subcode07 ?? null,
				'subcode08' => $subcode08 ?? null,
				'subcode09' => $subcode09 ?? null,
				'subcode10' => $subcode10 ?? null,
				'dtmitem_id' => $elements[0]['dtmitem_id'],
				'fullsubcode' => implode('-', $aSubcode),
				'item_id' => $item_id
			];
			$subcode01_ = trim($subcode01) ?? null;
			$subcode02_ = trim($subcode02) ?? null;
			$subcode03_ = trim($subcode03) ?? null;
			$subcode04_ = trim($subcode04) ?? null;
			$subcode05_ = trim($subcode05) ?? null;
			$subcode06_ = trim($subcode06) ?? null;
			$subcode07_ = trim($subcode07) ?? null;
			$subcode08_ = trim($subcode08) ?? null;
			$subcode09_ = trim($subcode09) ?? null;
			$subcode10_ = trim($subcode10) ?? null;

			$this->db->query("insert into datatex_productibeandtl_240706 
							(itemtypecode,subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,subcode09,subcode10,
							dtmitem_id,fullsubcode,item_id)
							values ('$itemtype','$subcode01_','$subcode02_','$subcode03_','$subcode04_','$subcode05_','$subcode06_',
							'$subcode07_','$subcode08_',
							'$subcode09_','$subcode10_',
							".$elements[0]['dtmitem_id'].",
							'".implode('-', $aSubcode)."',
							'$item_id') 
						  	ON CONFLICT (item_id) DO UPDATE 
							SET itemtypecode='$itemtype',
								subcode01='$subcode01_',
								subcode02='$subcode02_',
								subcode03='$subcode03_',
								subcode04='$subcode04_',
								subcode05='$subcode05_',
								subcode06='$subcode06_',
								subcode07='$subcode07_',
								subcode08='$subcode08_',
								subcode09='$subcode09_',
								subcode10='$subcode10_',
								dtmitem_id='".$elements[0]['dtmitem_id']."',
								fullsubcode='".implode('-', $aSubcode)."'");
		}
		//$this->db->insert_batch('datatex_productibeandtl', $arrData);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$resp['code'] = 400;
			$resp['messages'] = 'Error';
		} else {
			$this->db->trans_commit();
			$resp['code'] = 200;
			$resp['messages'] = 'Success';
		}
		var_dump('DONE');
		return $resp;
	}

	/** for update parent ibean dari ibeandetailnya */
	public function bulkupdateFAB()
	{
		$this->db->trans_begin();

		$q = $this->db->query("
			update
			datatex_productibeandtl_240706 a
			set dtxproductibeanid = b.dtxproductibeanid  
			from datatex_productibean_240706  b 
			where 
			trim(a.itemtypecode) = trim(b.itemtypecode) and 
			trim(a.subcode01) = trim(b.subcode01) and
			trim(a.subcode02) = trim(b.subcode02) and
			trim(a.subcode03) = trim(b.subcode03) and
			trim(a.subcode04) = trim(b.subcode04) and
			trim(a.subcode05) = trim(b.subcode05) and
			trim(a.subcode06) = trim(b.subcode06) and
			trim(a.subcode07) = trim(b.subcode07) and
			trim(a.subcode08) = trim(b.subcode08) and
			--trim(a.subcode09) = trim(b.dtxproductibeanseq) and
			b.itemtypecode = 'FAB';
		");

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$resp['code'] = 400;
			$resp['messages'] = 'Error';
		} else {
			$this->db->trans_commit();
			$resp['code'] = 200;
			$resp['messages'] = 'Success';
		}
		var_dump("bulkupdateFAB DONE");
		return $resp;
	}

	public function bulkupdateTRM()
	{
		$this->db->trans_begin();

		$q = $this->db->query("
			update
			datatex_productibeandtl_240706 a
			set dtxproductibeanid  = b.dtxproductibeanid  
			from datatex_productibean_240706  b 
			where 
			trim(a.itemtypecode) = trim(b.itemtypecode) and 
			trim(a.subcode01) = trim(b.subcode01) and
			trim(a.subcode02) = trim(b.subcode02) and
			trim(a.subcode03) = trim(b.subcode03) and
			trim(a.subcode04) = trim(b.subcode04) and
			trim(a.subcode05)  = trim(b.subcode05) and
			trim(a.subcode06) = trim(b.subcode06) and
			--trim(a.subcode07) = trim(b.dtxproductibeanseq) and
			b.itemtypecode = 'TRM';
		");

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$resp['code'] = 400;
			$resp['messages'] = 'Error';
		} else {
			$this->db->trans_commit();
			$resp['code'] = 200;
			$resp['messages'] = 'Success';
		}
		var_dump("bulkupdateTRM DONE");
		return $resp;
	}

	public function bulkupdatePKG()
	{
		$this->db->trans_begin();

		$q = $this->db->query("
			update
			datatex_productibeandtl_240706 a
			set dtxproductibeanid  = b.dtxproductibeanid  
			from datatex_productibean_240706  b 
			where 
			trim(a.itemtypecode) = trim(b.itemtypecode) and 
			trim(a.subcode01) = trim(b.subcode01) and
			trim(a.subcode02) = trim(b.subcode02) and
			trim(a.subcode03) = trim(b.subcode03) and
			trim(a.subcode04) = trim(b.subcode04) and
			trim(a.subcode05)  = trim(b.subcode05) and
			trim(a.subcode06) = trim(b.subcode06) and
			trim(a.subcode07) = trim(b.subcode07) and
			--trim(a.subcode08) = trim(b.dtxproductibeanseq) and
			b.itemtypecode = 'PKG';
		");

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$resp['code'] = 400;
			$resp['messages'] = 'Error';
		} else {
			$this->db->trans_commit();
			$resp['code'] = 200;
			$resp['messages'] = 'Success';
		}
		var_dump("bulkupdatePKG DONE");
		return $resp;
	}

	public function bulkupdateINS()
	{
		$this->db->trans_begin();

		$q = $this->db->query("
			update
			datatex_productibeandtl_240706 a
			set dtxproductibeanid  = b.dtxproductibeanid  
			from datatex_productibean_240706  b 
			where 
			trim(a.itemtypecode) = trim(b.itemtypecode) and 
			trim(a.subcode01) = trim(b.subcode01) and
			trim(a.subcode02) = trim(b.subcode02) and
			trim(a.subcode03) = trim(b.subcode03) and
			trim(a.subcode04) = trim(b.subcode04) and
			trim(a.subcode05)  = trim(b.subcode05) and
			trim(a.subcode06) = trim(b.subcode06) and
			trim(a.subcode07) = trim(b.subcode07) and
			trim(a.subcode08) = trim(b.subcode08) and
			--trim(a.subcode09) = trim(b.dtxproductibeanseq) and
			b.itemtypecode = 'INS';

		");

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$resp['code'] = 400;
			$resp['messages'] = 'Error';
		} else {
			$this->db->trans_commit();
			$resp['code'] = 200;
			$resp['messages'] = 'Success';
		}
		var_dump("bulkupdateINS DONE");
		return $resp;
	}

	public function bulkupdateCHE()
	{
		$this->db->trans_begin();

		$q = $this->db->query("
			update
			datatex_productibeandtl_240706 a
			set dtxproductibeanid  = b.dtxproductibeanid  
			from datatex_productibean_240706  b 
			where 
			trim(a.itemtypecode) = trim(b.itemtypecode) and 
			trim(a.subcode01) = trim(b.subcode01) and
			trim(a.subcode02) = trim(b.subcode02) and
			trim(a.subcode03) = trim(b.subcode03) and
			trim(a.subcode04) = trim(b.subcode04) and
			trim(a.subcode05)  = trim(b.subcode05) and
			--trim(a.subcode06) = trim(b.dtxproductibeanseq) and
			b.itemtypecode = 'CHE';
		");

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$resp['code'] = 400;
			$resp['messages'] = 'Error';
		} else {
			$this->db->trans_commit();
			$resp['code'] = 200;
			$resp['messages'] = 'Success';
		}
		var_dump("bulkupdateCHE DONE");
		return $resp;
	}

	/** ========== V2 ========== */
	public function generateProductIbeanDetailV2($itemids = [])
	{
		if (empty($itemids)) {
			log_message('error', "ProductIBeanDetailService->generateProductIbeanDetailV2 itemids null");
			var_dump("itemids null");
			exit();
		}

		$this->db->trans_begin();

		$result = $this->db->query(
			"select * from datatex_m_item a
			left join datatex_m_subcode b on b.dtmsubcode_id = a.dtmsubcode_id
			left join datatex_m_item_detail c on c.dtmitem_id = a.dtmitem_id
			left join datatex_m_subcode_detail d on d.dtmsubcodedtl_id  = c.dtmsubcodedtl_id  
			where a.item_id in ?
			order by a.item_id, d.dtmsubcodedtl_seq asc",
			[$itemids]
		)->result_array();

		$aGroupBydtmitemid = [];
		foreach ($result as $r) {
			$aGroupBydtmitemid[$r['item_id']][] = $r;
		}

		$arrData = [];
		foreach ($aGroupBydtmitemid as $item_id => $elements) {
			$aSubcode = [];
			foreach ($elements as $el) {
				switch ($el['dtmsubcodedtl_seq']) {
					case 1:
						$subcode01 = $el['dtmitemdtl_code'];
						break;
					case 2:
						$subcode02 = $el['dtmitemdtl_code'];
						break;
					case 3:
						$subcode03 = $el['dtmitemdtl_code'];
						break;
					case 4:
						$subcode04 = $el['dtmitemdtl_code'];
						break;
					case 5:
						$subcode05 = $el['dtmitemdtl_code'];
						break;
					case 6:
						$subcode06 = $el['dtmitemdtl_code'];
						break;
					case 7:
						$subcode07 = $el['dtmitemdtl_code'];
						break;
					case 8:
						$subcode08 = $el['dtmitemdtl_code'];
						break;
					case 9:
						$subcode09 = $el['dtmitemdtl_code'];
						break;
					case 10:
						$subcode10 = $el['dtmitemdtl_code'];
						break;
				}

				//subcode
				$aSubcode[] = $el['dtmitemdtl_code'];
			}
			$arrData[] = [
				'itemtypecode' => $elements[0]['dtmsubcode_code'],
				'subcode01' => $subcode01 ?? null,
				'subcode02' => $subcode02 ?? null,
				'subcode03' => $subcode03 ?? null,
				'subcode04' => $subcode04 ?? null,
				'subcode05' => $subcode05 ?? null,
				'subcode06' => $subcode06 ?? null,
				'subcode07' => $subcode07 ?? null,
				'subcode08' => $subcode08 ?? null,
				'subcode09' => $subcode09 ?? null,
				'subcode10' => $subcode10 ?? null,
				'dtmitem_id' => $elements[0]['dtmitem_id'],
				'fullsubcode' => implode('-', $aSubcode),
				'item_id' => $item_id
			];
		}
		$this->db->insert_batch('datatex_productibeandtl', $arrData);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$resp['code'] = 400;
			$resp['messages'] = 'Error';
		} else {
			$this->db->trans_commit();
			$resp['code'] = 200;
			$resp['messages'] = 'Success';
		}
		var_dump('DONE');
		return $resp;
	}
}

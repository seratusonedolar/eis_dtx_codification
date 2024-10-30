<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class AdstorageBeanDetailServiceTrial2 extends CI_model
{
	
	public function generateTechInformationFAB()
	{
		try {
			$result = $this->db->query("
			select a.dtmitem_id,b.item_id,'product' nameentity,
			dtmsubcodetechinf_remark,dtmsubcodetechinf_prodnamename,dtmsubcodetechinf_prodfieldname,
			dtmsubcodetechinfhierarchy_code,dtmsubcodetechinfhierarchy_name,
			dtmitem_description
			from datatex_productibeandtl_240706 a
			left join datatex_m_item b on b.dtmitem_id = a.dtmitem_id 
			left join datatex_m_item_tech_information c on c.dtmitem_id = a.dtmitem_id 
			left join datatex_m_subcode_tech_information d on d.dtmsubcodetechinf_id = c.dtmsubcodetechinf_id 
			left join datatex_m_subcode_tech_inf_hierarchy e 
			on e.dtmsubcodetechinfhierarchy_id = c.dtmsubcodetechinfhierarchy_id
			where a.itemtypecode = 'FAB' 
			AND a.dtmitem_id  in (
			select dtmitem_id
			from (select itemtypecode,max(item_id) item_id,string_agg(item_id,',') search_item,
				  subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,sks,dtxproductibeanid
					from (
							SELECT itemtypecode,
							subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,dtxproductibeanid,
							item_id,
							concat(itemtypecode,'-',trim(subcode01),'-',trim(subcode02),'-',trim(subcode03)
							,'-',trim(subcode04),'-',trim(subcode05),'-',trim(subcode06),'-',trim(subcode07)
							,'-',trim(subcode08)) sks
							FROM datatex_productibeandtl_240706 a
							left join datatex_productibeandtl_status_240706 f on a.dtmitem_id=f.dtmitem_id
							
							where item_id in (
				SELECT item_id from (
				select a.item_id,order_no from purchase_order_detail a 
				join purchase_requisition_master b on a.pr_no=b.pr_no
				where order_no in (

				'23/E/PB/O/UQLM/1957/B',
				'23/E/PB/O/UQLM/2218/C',
				'24/E/PB/O/UQLM/3/D',
				'24/E/PB/O/UQLW/165/A',
				'24/E/PB/O/UQLW/166/A',
				'24/E/PB/O/UQLW/167/A',
				'23/E/PB/O/UQLK/2027/A',
				'24/E/PB/O/UQLK/96/A',
				'23/E/PB/O/UQLK/2207/A',
				'23/E/PB/O/GIOD/1803/A',
				'23/E/PB/O/GIOD/1335/A',
				'23/E/PB/O/GIOD/1299/C',
				'23/E/PB/O/RGUL/1850/A',
				'23/E/PB/O/RGUL/1850/B',
				'23/E/PB/O/RGUL/1850/C',
				'23/E/PB/O/RGUL/1851/A',
				'23/E/PB/O/RGUL/1851/B',
				'23/E/PB/O/RGUL/1851/C',
				'23/E/PB/O/RGUL/1852/A',
				'23/E/PB/O/RGUL/1852/B',
				'23/E/PB/O/RGUL/1852/C',
				'23/E/PB/O/RGUL/1853/A',
				'23/E/PB/O/RGUL/1853/B',
				'23/E/PB/O/RGUL/1853/C',
				'23/E/PB/O/RGUL/547/A',
				'23/E/PB/O/RGUL/547/B',
				'23/E/PB/O/RGUL/547/C',
				'23/E/PB/O/RGUM/377/A',
				'23/E/PB/O/RGUM/377/B',
				'23/E/PB/O/RGUM/377/C',
				'23/E/PB/O/RGUM/484/A',
				'23/E/PB/O/RGUM/699/A',
				'23/E/PB/O/RGUM/699/B',
				'23/E/PB/O/RGUM/699/C',
				'23/E/PB/O/RGUM/701/A',
				'23/E/PB/O/RGUM/701/B',
				'23/E/PB/O/RGUM/701/C',
				'23/E/PB/O/JJIL/1632/A',
				'23/E/PB/O/JJIL/1633/A',
				'23/E/PB/O/JJIL/1889/A',
				'22/E/PB/O/MAWE/02224',
				'22/E/PB/O/MAWE/02223',
				'23/E/PB/O/AFFD/1766/A',
				'23/E/PB/O/AFFD/1767/A',
				'23/E/PB/O/AFFD/1768/A',
				'23/E/PB/O/AFFC/1625/A',
				'23/E/PB/O/AFSE/1281/A',
				'22/E/PB/O/AFFO/1565/A',
				'23/E/PB/O/AFOC/1818/A',
				'23/E/PB/O/AFFS/1652/A',
				'23/E/PB/O/AFFD/1666/A',
				'23/E/PB/O/AFSE/1800/A',
				'23/E/PB/O/AFSE/1798/A',
				'24/E/PB/O/AFFO/40/A',
				'22/E/PB/O/AFFS/2127/A',
				'23/E/PB/O/AFFD/1789/A',
				'23/E/PB/O/AFSE/1797/A',
				'23/E/PB/O/AFSE/1799/A',
				'23/E/PB/O/AFFO/1688/A',
				'23/E/PB/O/POLO/823/A',
				'23/E/PB/O/POLA/525/A',
				'23/E/PB/O/PBSR/444/A',
				'23/E/PB/O/PBSR/839/A',
				'23/E/PB/O/POLA/1216/A',
				'22/E/PB/O/AMEO/2030/B',
				'22/E/PB/O/AMEO/898/A',
				'23/E/PB/O/AMEO/1566/A',
				'24/E/PB/O/AMEO/76/A',
				'24/E/PB/O/AMEO/235/A',
				'23/E/PB/O/DULU/998/A',
				'23/E/PB/O/DULU/2113/A',
				'23/E/PB/O/DULL/878/A',
				'23/E/PB/O/LANB/1060/A',
				'23/E/PB/O/LANB/940/A',
				'23/E/PB/O/LANB/1635/A',
				'23/E/PB/O/CRHA/2172/A',
				'23/E/PB/O/CRHA/2173/A',
				'23/E/PB/O/CRHA/1562/A',
				'23/E/PB/O/BEAN/627/A',
				'23/E/PB/O/BEAN/1866/A',
				'22/E/SB/O/MAWE/2224/A',
				'22/E/SB/O/MAWE/2224/B',
				'22/E/SB/O/MAWE/2224/C',
				'22/E/PB/O/MAWE/2223/B',
				'22/E/PB/O/MAWE/2223/C',
				'22/E/SB/O/MAWE/2223/A'

					) GROUP BY item_id,order_no order by item_id) a GROUP BY item_id) and itemtypecode = 'FAB' 
					 and status_subcode = 'confirmed') af 
					GROUP BY itemtypecode,
					subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,sks,
					dtxproductibeanid
					ORDER BY sks) a 
			left join datatex_m_item e on a.item_id=e.item_id
			left join m_item b on b.item_id = a.item_id 
			left join m_subclassification bb on bb.subclassif_id  = b.subclassif_id
			)
			and d.dtmsubcodetechinf_remark <> 'Pattern#'
			and dtmsubcodetechinf_prodnamename NOTNULL
			and dtmsubcodetechinf_prodfieldname NOTNULL 
			and dtmsubcodetechinfhierarchy_code NOTNULL
			and dtmsubcodetechinfhierarchy_name NOTNULL
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
						'valueboolean' => 0,
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
					'valueboolean' => 0,
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
				array_push($arrData,  [
					'dtmitem_id' => $r['dtmitem_id'],
					'item_id' => $r['item_id'],
					// 'fatherid' => null,
					// 'importautocounter' => null,
					'nameentityname' => 'Product',
					'namename' => 'SendtoPLM',
					'fieldname' => 'SendtoPLM',
					'codestring' => null,
					'valuestring' => null,
					//'valueint' => 0,
					'valueboolean' => 1,
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
			$this->db->insert_batch('datatex_trial_adstoragebeandtl_2_240711', $arrData);

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

	public function generateTechInformationINS()
	{
		try {
			$result = $this->db->query("
			select a.dtmitem_id,b.item_id,'product' nameentity,
			dtmsubcodetechinf_remark,dtmsubcodetechinf_prodnamename,dtmsubcodetechinf_prodfieldname,
			dtmsubcodetechinfhierarchy_code,dtmsubcodetechinfhierarchy_name,
			dtmitem_description
			from datatex_productibeandtl_240706 a
			left join datatex_m_item b on b.dtmitem_id = a.dtmitem_id 
			left join datatex_m_item_tech_information c on c.dtmitem_id = a.dtmitem_id 
			left join datatex_m_subcode_tech_information d on d.dtmsubcodetechinf_id = c.dtmsubcodetechinf_id 
			left join datatex_m_subcode_tech_inf_hierarchy e 
			on e.dtmsubcodetechinfhierarchy_id = c.dtmsubcodetechinfhierarchy_id
			where a.itemtypecode = 'INS' 
			AND a.dtmitem_id  in (
			select dtmitem_id
			from (select itemtypecode,max(item_id) item_id,string_agg(item_id,',') search_item,
				  subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,sks,dtxproductibeanid
					from (
							SELECT itemtypecode,
							subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,dtxproductibeanid,
							item_id,
							concat(itemtypecode,'-',trim(subcode01),'-',trim(subcode02),'-',trim(subcode03)
							,'-',trim(subcode04),'-',trim(subcode05),'-',trim(subcode06),'-',trim(subcode07)
							,'-',trim(subcode08)) sks
							FROM datatex_productibeandtl_240706 a
							left join datatex_productibeandtl_status_240706 f on a.dtmitem_id=f.dtmitem_id
							
							where item_id in (
				SELECT item_id from (
				select a.item_id,order_no from purchase_order_detail a 
				join purchase_requisition_master b on a.pr_no=b.pr_no
				where order_no in (

				'23/E/PB/O/UQLM/1957/B',
				'23/E/PB/O/UQLM/2218/C',
				'24/E/PB/O/UQLM/3/D',
				'24/E/PB/O/UQLW/165/A',
				'24/E/PB/O/UQLW/166/A',
				'24/E/PB/O/UQLW/167/A',
				'23/E/PB/O/UQLK/2027/A',
				'24/E/PB/O/UQLK/96/A',
				'23/E/PB/O/UQLK/2207/A',
				'23/E/PB/O/GIOD/1803/A',
				'23/E/PB/O/GIOD/1335/A',
				'23/E/PB/O/GIOD/1299/C',
				'23/E/PB/O/RGUL/1850/A',
				'23/E/PB/O/RGUL/1850/B',
				'23/E/PB/O/RGUL/1850/C',
				'23/E/PB/O/RGUL/1851/A',
				'23/E/PB/O/RGUL/1851/B',
				'23/E/PB/O/RGUL/1851/C',
				'23/E/PB/O/RGUL/1852/A',
				'23/E/PB/O/RGUL/1852/B',
				'23/E/PB/O/RGUL/1852/C',
				'23/E/PB/O/RGUL/1853/A',
				'23/E/PB/O/RGUL/1853/B',
				'23/E/PB/O/RGUL/1853/C',
				'23/E/PB/O/RGUL/547/A',
				'23/E/PB/O/RGUL/547/B',
				'23/E/PB/O/RGUL/547/C',
				'23/E/PB/O/RGUM/377/A',
				'23/E/PB/O/RGUM/377/B',
				'23/E/PB/O/RGUM/377/C',
				'23/E/PB/O/RGUM/484/A',
				'23/E/PB/O/RGUM/699/A',
				'23/E/PB/O/RGUM/699/B',
				'23/E/PB/O/RGUM/699/C',
				'23/E/PB/O/RGUM/701/A',
				'23/E/PB/O/RGUM/701/B',
				'23/E/PB/O/RGUM/701/C',
				'23/E/PB/O/JJIL/1632/A',
				'23/E/PB/O/JJIL/1633/A',
				'23/E/PB/O/JJIL/1889/A',
				'22/E/PB/O/MAWE/02224',
				'22/E/PB/O/MAWE/02223',
				'23/E/PB/O/AFFD/1766/A',
				'23/E/PB/O/AFFD/1767/A',
				'23/E/PB/O/AFFD/1768/A',
				'23/E/PB/O/AFFC/1625/A',
				'23/E/PB/O/AFSE/1281/A',
				'22/E/PB/O/AFFO/1565/A',
				'23/E/PB/O/AFOC/1818/A',
				'23/E/PB/O/AFFS/1652/A',
				'23/E/PB/O/AFFD/1666/A',
				'23/E/PB/O/AFSE/1800/A',
				'23/E/PB/O/AFSE/1798/A',
				'24/E/PB/O/AFFO/40/A',
				'22/E/PB/O/AFFS/2127/A',
				'23/E/PB/O/AFFD/1789/A',
				'23/E/PB/O/AFSE/1797/A',
				'23/E/PB/O/AFSE/1799/A',
				'23/E/PB/O/AFFO/1688/A',
				'23/E/PB/O/POLO/823/A',
				'23/E/PB/O/POLA/525/A',
				'23/E/PB/O/PBSR/444/A',
				'23/E/PB/O/PBSR/839/A',
				'23/E/PB/O/POLA/1216/A',
				'22/E/PB/O/AMEO/2030/B',
				'22/E/PB/O/AMEO/898/A',
				'23/E/PB/O/AMEO/1566/A',
				'24/E/PB/O/AMEO/76/A',
				'24/E/PB/O/AMEO/235/A',
				'23/E/PB/O/DULU/998/A',
				'23/E/PB/O/DULU/2113/A',
				'23/E/PB/O/DULL/878/A',
				'23/E/PB/O/LANB/1060/A',
				'23/E/PB/O/LANB/940/A',
				'23/E/PB/O/LANB/1635/A',
				'23/E/PB/O/CRHA/2172/A',
				'23/E/PB/O/CRHA/2173/A',
				'23/E/PB/O/CRHA/1562/A',
				'23/E/PB/O/BEAN/627/A',
				'23/E/PB/O/BEAN/1866/A',
				'22/E/SB/O/MAWE/2224/A',
				'22/E/SB/O/MAWE/2224/B',
				'22/E/SB/O/MAWE/2224/C',
				'22/E/PB/O/MAWE/2223/B',
				'22/E/PB/O/MAWE/2223/C',
				'22/E/SB/O/MAWE/2223/A'

					) GROUP BY item_id,order_no order by item_id) a GROUP BY item_id) and itemtypecode = 'INS' 
					 and status_subcode = 'confirmed') af 
					GROUP BY itemtypecode,
					subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,sks,
					dtxproductibeanid
					ORDER BY sks) a 
			left join datatex_m_item e on a.item_id=e.item_id
			left join m_item b on b.item_id = a.item_id 
			left join m_subclassification bb on bb.subclassif_id  = b.subclassif_id
			)
			and d.dtmsubcodetechinf_remark <> 'Pattern#'
			and dtmsubcodetechinf_prodnamename NOTNULL
			and dtmsubcodetechinf_prodfieldname NOTNULL 
			and dtmsubcodetechinfhierarchy_code NOTNULL
			and dtmsubcodetechinfhierarchy_name NOTNULL
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
						'valueboolean' => 0,
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
					'valueboolean' => 0,
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
				array_push($arrData,  [
					'dtmitem_id' => $r['dtmitem_id'],
					'item_id' => $r['item_id'],
					// 'fatherid' => null,
					// 'importautocounter' => null,
					'nameentityname' => 'Product',
					'namename' => 'SendtoPLM',
					'fieldname' => 'SendtoPLM',
					'codestring' => null,
					'valuestring' => null,
					//'valueint' => 0,
					'valueboolean' => 1,
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
			$this->db->insert_batch('datatex_trial_adstoragebeandtl_2_240711', $arrData);

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
			select a.dtmitem_id,b.item_id,'product' nameentity,
			dtmsubcodetechinf_remark,dtmsubcodetechinf_prodnamename,dtmsubcodetechinf_prodfieldname,
			dtmsubcodetechinfhierarchy_code,dtmsubcodetechinfhierarchy_name,
			dtmitem_description
			from datatex_productibeandtl_240706 a
						left join datatex_m_item b on b.dtmitem_id = a.dtmitem_id 
			left join datatex_m_item_tech_information c on c.dtmitem_id = a.dtmitem_id 
			left join datatex_m_subcode_tech_information d on d.dtmsubcodetechinf_id = c.dtmsubcodetechinf_id 
			left join datatex_m_subcode_tech_inf_hierarchy e on e.dtmsubcodetechinfhierarchy_id = c.dtmsubcodetechinfhierarchy_id
			where a.itemtypecode = 'TRM' 
			AND a.dtmitem_id  in (
			select dtmitem_id
			from (select itemtypecode,max(item_id) item_id,string_agg(item_id,',') search_item,
				  subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,sks,dtxproductibeanid
					from (
							SELECT itemtypecode,
							subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,dtxproductibeanid,
							item_id,
							concat(itemtypecode,'-',trim(subcode01),'-',trim(subcode02),'-',trim(subcode03),'-',trim(subcode04),'-',trim(subcode05),'-',trim(subcode06)) sks
							FROM datatex_productibeandtl_240706 a
							left join datatex_productibeandtl_status_240706 f on a.dtmitem_id=f.dtmitem_id
							
							where item_id in (
				SELECT item_id from (
				select a.item_id,order_no from purchase_order_detail a join purchase_requisition_master b on a.pr_no=b.pr_no
				where order_no in (

				'23/E/PB/O/UQLM/1957/B',
				'23/E/PB/O/UQLM/2218/C',
				'24/E/PB/O/UQLM/3/D',
				'24/E/PB/O/UQLW/165/A',
				'24/E/PB/O/UQLW/166/A',
				'24/E/PB/O/UQLW/167/A',
				'23/E/PB/O/UQLK/2027/A',
				'24/E/PB/O/UQLK/96/A',
				'23/E/PB/O/UQLK/2207/A',
				'23/E/PB/O/GIOD/1803/A',
				'23/E/PB/O/GIOD/1335/A',
				'23/E/PB/O/GIOD/1299/C',
				'23/E/PB/O/RGUL/1850/A',
				'23/E/PB/O/RGUL/1850/B',
				'23/E/PB/O/RGUL/1850/C',
				'23/E/PB/O/RGUL/1851/A',
				'23/E/PB/O/RGUL/1851/B',
				'23/E/PB/O/RGUL/1851/C',
				'23/E/PB/O/RGUL/1852/A',
				'23/E/PB/O/RGUL/1852/B',
				'23/E/PB/O/RGUL/1852/C',
				'23/E/PB/O/RGUL/1853/A',
				'23/E/PB/O/RGUL/1853/B',
				'23/E/PB/O/RGUL/1853/C',
				'23/E/PB/O/RGUL/547/A',
				'23/E/PB/O/RGUL/547/B',
				'23/E/PB/O/RGUL/547/C',
				'23/E/PB/O/RGUM/377/A',
				'23/E/PB/O/RGUM/377/B',
				'23/E/PB/O/RGUM/377/C',
				'23/E/PB/O/RGUM/484/A',
				'23/E/PB/O/RGUM/699/A',
				'23/E/PB/O/RGUM/699/B',
				'23/E/PB/O/RGUM/699/C',
				'23/E/PB/O/RGUM/701/A',
				'23/E/PB/O/RGUM/701/B',
				'23/E/PB/O/RGUM/701/C',
				'23/E/PB/O/JJIL/1632/A',
				'23/E/PB/O/JJIL/1633/A',
				'23/E/PB/O/JJIL/1889/A',
				'22/E/PB/O/MAWE/02224',
				'22/E/PB/O/MAWE/02223',
				'23/E/PB/O/AFFD/1766/A',
				'23/E/PB/O/AFFD/1767/A',
				'23/E/PB/O/AFFD/1768/A',
				'23/E/PB/O/AFFC/1625/A',
				'23/E/PB/O/AFSE/1281/A',
				'22/E/PB/O/AFFO/1565/A',
				'23/E/PB/O/AFOC/1818/A',
				'23/E/PB/O/AFFS/1652/A',
				'23/E/PB/O/AFFD/1666/A',
				'23/E/PB/O/AFSE/1800/A',
				'23/E/PB/O/AFSE/1798/A',
				'24/E/PB/O/AFFO/40/A',
				'22/E/PB/O/AFFS/2127/A',
				'23/E/PB/O/AFFD/1789/A',
				'23/E/PB/O/AFSE/1797/A',
				'23/E/PB/O/AFSE/1799/A',
				'23/E/PB/O/AFFO/1688/A',
				'23/E/PB/O/POLO/823/A',
				'23/E/PB/O/POLA/525/A',
				'23/E/PB/O/PBSR/444/A',
				'23/E/PB/O/PBSR/839/A',
				'23/E/PB/O/POLA/1216/A',
				'22/E/PB/O/AMEO/2030/B',
				'22/E/PB/O/AMEO/898/A',
				'23/E/PB/O/AMEO/1566/A',
				'24/E/PB/O/AMEO/76/A',
				'24/E/PB/O/AMEO/235/A',
				'23/E/PB/O/DULU/998/A',
				'23/E/PB/O/DULU/2113/A',
				'23/E/PB/O/DULL/878/A',
				'23/E/PB/O/LANB/1060/A',
				'23/E/PB/O/LANB/940/A',
				'23/E/PB/O/LANB/1635/A',
				'23/E/PB/O/CRHA/2172/A',
				'23/E/PB/O/CRHA/2173/A',
				'23/E/PB/O/CRHA/1562/A',
				'23/E/PB/O/BEAN/627/A',
				'23/E/PB/O/BEAN/1866/A',
				'22/E/SB/O/MAWE/2224/A',
				'22/E/SB/O/MAWE/2224/B',
				'22/E/SB/O/MAWE/2224/C',
				'22/E/PB/O/MAWE/2223/B',
				'22/E/PB/O/MAWE/2223/C',
				'22/E/SB/O/MAWE/2223/A'

				) GROUP BY item_id,order_no order by item_id) a GROUP BY item_id) and itemtypecode = 'TRM' 
				 and status_subcode = 'confirmed') af 
					GROUP BY itemtypecode,
					subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,sks,dtxproductibeanid
					ORDER BY sks) a 
			left join datatex_m_item e on a.item_id=e.item_id
			left join m_item b on b.item_id = a.item_id 
			left join m_subclassification bb on bb.subclassif_id  = b.subclassif_id
			)
			and d.dtmsubcodetechinf_remark <> 'Pattern#'
			and dtmsubcodetechinf_prodnamename NOTNULL
			and dtmsubcodetechinf_prodfieldname NOTNULL 
			and dtmsubcodetechinfhierarchy_code NOTNULL
			and dtmsubcodetechinfhierarchy_name NOTNULL
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
						'valueboolean' => 0,
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
					'valueboolean' => 0,
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
				array_push($arrData,  [
					'dtmitem_id' => $r['dtmitem_id'],
					'item_id' => $r['item_id'],
					// 'fatherid' => null,
					// 'importautocounter' => null,
					'nameentityname' => 'Product',
					'namename' => 'SendtoPLM',
					'fieldname' => 'SendtoPLM',
					'codestring' => null,
					'valuestring' => null,
					//'valueint' => 0,
					'valueboolean' => 1,
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
			$this->db->insert_batch('datatex_trial_adstoragebeandtl_2_240711', $arrData);

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
			select a.dtmitem_id,b.item_id,'product' nameentity,
			dtmsubcodetechinf_remark,dtmsubcodetechinf_prodnamename,dtmsubcodetechinf_prodfieldname,dtmsubcodetechinfhierarchy_code,dtmsubcodetechinfhierarchy_name,
			dtmitem_description
			from datatex_productibeandtl_240706 a
						left join datatex_m_item b on b.dtmitem_id = a.dtmitem_id 
			left join datatex_m_item_tech_information c on c.dtmitem_id = a.dtmitem_id 
			left join datatex_m_subcode_tech_information d on d.dtmsubcodetechinf_id = c.dtmsubcodetechinf_id 
			left join datatex_m_subcode_tech_inf_hierarchy e on e.dtmsubcodetechinfhierarchy_id = c.dtmsubcodetechinfhierarchy_id
			where a.itemtypecode = 'PKG' 
			AND a.dtmitem_id  in (
			select dtmitem_id
			from (select itemtypecode,max(item_id) item_id,string_agg(item_id,',') search_item,
				  subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,sks,dtxproductibeanid
					from (
							SELECT itemtypecode,
							subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,dtxproductibeanid,
							item_id,
							concat(itemtypecode,'-',trim(subcode01),'-',trim(subcode02),'-',trim(subcode03),'-',trim(subcode04),'-',trim(subcode05),'-',trim(subcode06),'-',trim(subcode07)) sks
							FROM datatex_productibeandtl_240706 a
							left join datatex_productibeandtl_status_240706 f on a.dtmitem_id=f.dtmitem_id
							
							where item_id in (
				SELECT item_id from (
				select a.item_id,order_no from purchase_order_detail a join purchase_requisition_master b on a.pr_no=b.pr_no
				where order_no in (

				'23/E/PB/O/UQLM/1957/B',
				'23/E/PB/O/UQLM/2218/C',
				'24/E/PB/O/UQLM/3/D',
				'24/E/PB/O/UQLW/165/A',
				'24/E/PB/O/UQLW/166/A',
				'24/E/PB/O/UQLW/167/A',
				'23/E/PB/O/UQLK/2027/A',
				'24/E/PB/O/UQLK/96/A',
				'23/E/PB/O/UQLK/2207/A',
				'23/E/PB/O/GIOD/1803/A',
				'23/E/PB/O/GIOD/1335/A',
				'23/E/PB/O/GIOD/1299/C',
				'23/E/PB/O/RGUL/1850/A',
				'23/E/PB/O/RGUL/1850/B',
				'23/E/PB/O/RGUL/1850/C',
				'23/E/PB/O/RGUL/1851/A',
				'23/E/PB/O/RGUL/1851/B',
				'23/E/PB/O/RGUL/1851/C',
				'23/E/PB/O/RGUL/1852/A',
				'23/E/PB/O/RGUL/1852/B',
				'23/E/PB/O/RGUL/1852/C',
				'23/E/PB/O/RGUL/1853/A',
				'23/E/PB/O/RGUL/1853/B',
				'23/E/PB/O/RGUL/1853/C',
				'23/E/PB/O/RGUL/547/A',
				'23/E/PB/O/RGUL/547/B',
				'23/E/PB/O/RGUL/547/C',
				'23/E/PB/O/RGUM/377/A',
				'23/E/PB/O/RGUM/377/B',
				'23/E/PB/O/RGUM/377/C',
				'23/E/PB/O/RGUM/484/A',
				'23/E/PB/O/RGUM/699/A',
				'23/E/PB/O/RGUM/699/B',
				'23/E/PB/O/RGUM/699/C',
				'23/E/PB/O/RGUM/701/A',
				'23/E/PB/O/RGUM/701/B',
				'23/E/PB/O/RGUM/701/C',
				'23/E/PB/O/JJIL/1632/A',
				'23/E/PB/O/JJIL/1633/A',
				'23/E/PB/O/JJIL/1889/A',
				'22/E/PB/O/MAWE/02224',
				'22/E/PB/O/MAWE/02223',
				'23/E/PB/O/AFFD/1766/A',
				'23/E/PB/O/AFFD/1767/A',
				'23/E/PB/O/AFFD/1768/A',
				'23/E/PB/O/AFFC/1625/A',
				'23/E/PB/O/AFSE/1281/A',
				'22/E/PB/O/AFFO/1565/A',
				'23/E/PB/O/AFOC/1818/A',
				'23/E/PB/O/AFFS/1652/A',
				'23/E/PB/O/AFFD/1666/A',
				'23/E/PB/O/AFSE/1800/A',
				'23/E/PB/O/AFSE/1798/A',
				'24/E/PB/O/AFFO/40/A',
				'22/E/PB/O/AFFS/2127/A',
				'23/E/PB/O/AFFD/1789/A',
				'23/E/PB/O/AFSE/1797/A',
				'23/E/PB/O/AFSE/1799/A',
				'23/E/PB/O/AFFO/1688/A',
				'23/E/PB/O/POLO/823/A',
				'23/E/PB/O/POLA/525/A',
				'23/E/PB/O/PBSR/444/A',
				'23/E/PB/O/PBSR/839/A',
				'23/E/PB/O/POLA/1216/A',
				'22/E/PB/O/AMEO/2030/B',
				'22/E/PB/O/AMEO/898/A',
				'23/E/PB/O/AMEO/1566/A',
				'24/E/PB/O/AMEO/76/A',
				'24/E/PB/O/AMEO/235/A',
				'23/E/PB/O/DULU/998/A',
				'23/E/PB/O/DULU/2113/A',
				'23/E/PB/O/DULL/878/A',
				'23/E/PB/O/LANB/1060/A',
				'23/E/PB/O/LANB/940/A',
				'23/E/PB/O/LANB/1635/A',
				'23/E/PB/O/CRHA/2172/A',
				'23/E/PB/O/CRHA/2173/A',
				'23/E/PB/O/CRHA/1562/A',
				'23/E/PB/O/BEAN/627/A',
				'23/E/PB/O/BEAN/1866/A',
				'22/E/SB/O/MAWE/2224/A',
				'22/E/SB/O/MAWE/2224/B',
				'22/E/SB/O/MAWE/2224/C',
				'22/E/PB/O/MAWE/2223/B',
				'22/E/PB/O/MAWE/2223/C',
				'22/E/SB/O/MAWE/2223/A'

				) GROUP BY item_id,order_no order by item_id) a GROUP BY item_id) and itemtypecode = 'PKG' and status_subcode = 'confirmed') af 
					GROUP BY itemtypecode,
					subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,sks,dtxproductibeanid
					ORDER BY sks) a 
			left join datatex_m_item e on a.item_id=e.item_id
			left join m_item b on b.item_id = a.item_id 
			left join m_subclassification bb on bb.subclassif_id  = b.subclassif_id
			)
			and d.dtmsubcodetechinf_remark <> 'Pattern#'
			and dtmsubcodetechinf_prodnamename NOTNULL
			and dtmsubcodetechinf_prodfieldname NOTNULL 
			and dtmsubcodetechinfhierarchy_code NOTNULL
			and dtmsubcodetechinfhierarchy_name NOTNULL
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
						'valueboolean' => 0,
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
					'valueboolean' => 0,
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
				array_push($arrData,  [
					'dtmitem_id' => $r['dtmitem_id'],
					'item_id' => $r['item_id'],
					// 'fatherid' => null,
					// 'importautocounter' => null,
					'nameentityname' => 'Product',
					'namename' => 'SendtoPLM',
					'fieldname' => 'SendtoPLM',
					'codestring' => null,
					'valuestring' => null,
					//'valueint' => 0,
					'valueboolean' => 1,
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
			$this->db->insert_batch('datatex_trial_adstoragebeandtl_2_240711', $arrData);

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

<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class FinishgoodServices extends CI_model
{
	// ========== COMMON ==========
	public function getLatestVersion($type = 'FIRST') :int
	{
		$q = $this->db->query("SELECT MAX(dtscfinhie_version) as max from datatex_scopefin_hierarchy WHERE dtscfinhie_type = ?", [$type])->row();
		return $q->max;
	}

	public function getGMTSubcode()
	{
		$q = $this->db->query(
			"select dms.*, dmsd.*, option.dtmsubcode_name as option_name
			from datatex_m_subcode dms 
			left join datatex_m_subcode_detail dmsd on dmsd.dtmsubcode_id = dms.dtmsubcode_id 
			left join datatex_m_subcode option on option.dtmsubcode_id = dmsd.dtmsubcode_option_id
			where dms.dtmsubcode_code = 'GMT'
			order by dmsd.dtmsubcodedtl_seq asc"
		)->result();

		return $q;
	}

	//==========STEP 1==========
	public function generateScopeFinHie_first($version)
	{
		$type = 'FIRST';
		$this->db->trans_begin();

		$q = $this->db->query("
			INSERT INTO datatex_scopefin_hierarchy (
				order_no,
				wo_no,
				item_type,
				sub1_buyerstyle,
				sub2_buyer,
				sub3_season,
				sub4_prodsegment,
				sub5_prodcategory,
				sub6_prodtype,
				sub7_destination,
				sub8_inseam,
				sub9_color,
				sub10_size,
				fulldesc,
				qty,
				dtscfinhie_version,
				dtscfinhie_type
			)
			select vab.order_no, vab.wo_no, 'GMT' as item_type, oi.buyer_style_no as sub1_buyerstyle, oi.buyer_name as sub2_buyer, concat_ws('',oi.season, oi.season_yr) as sub3_season,
			case 
				when oi.buyer_div = 'L' then  'LADIES'
				when oi.buyer_div = 'M' then  'MAN'
				when oi.buyer_div = 'W' then  'LADIES'
				when oi.buyer_div = 'K' then  'KIDS'
				when oi.buyer_div = 'I' then  'INFANT'
				when oi.buyer_div = 'T' then  'TOODLER'
				when oi.buyer_div = 'O' then  'OTHER'
				else 'NA'
			end as sub4_prodsegment,
			'WOV' as sub5_prodcategory,
			mpt2.product_type_name||' '||mpt.product_types_name as sub6_prodtype,
			vab.destination as sub7_destination,
			vab.inseam as sub8_inseam,
			vab.color as sub9_color, 
			vab.size as sub10_size,
			concat_ws('-', 
				oi.buyer_style_no, 
				oi.buyer_name, 
				concat_ws('',oi.season, oi.season_yr),
				case 
					when oi.buyer_div = 'L' then  'LADIES'
					when oi.buyer_div = 'M' then  'MAN'
					when oi.buyer_div = 'W' then  'LADIES'
					when oi.buyer_div = 'K' then  'KIDS'
					when oi.buyer_div = 'I' then  'INFANT'
					when oi.buyer_div = 'T' then  'TOODLER'
					when oi.buyer_div = 'O' then  'OTHER'
					else 'NA'
				end,
				'WOV',
				(mpt2.product_type_name||' '||mpt.product_types_name),
				vab.destination,
				vab.inseam,
				vab.color,
				vab.size
			) as fullcode,
			sum(vab.qty) as qty,
			11 as dtscfinhie_version,
			'FIRST' as dtscfinhie_type
from (
	select rcv.order_no, rcv.po_no, rcv.wo_no, rcv.destination, rcv.color, rcv.inseam, rcv.size, (coalesce(rcv.qty,0)+coalesce(adjp.qty,0))-(coalesce(adjm.qty,0)+coalesce(iss.qty,0)) qty
	from temp_erx_fg1_rcv rcv
	left join temp_erx_fg1_adjp adjp on rcv.order_no=adjp.order_no and rcv.po_no=adjp.po_no and rcv.wo_no=adjp.wo_no and rcv.destination=adjp.destination and rcv.color=adjp.color and rcv.inseam=adjp.inseam and rcv.size=adjp.size 
	left join temp_erx_fg1_adjm adjm on rcv.order_no=adjm.order_no and rcv.po_no=adjm.po_no and rcv.wo_no=adjm.wo_no and rcv.destination=adjm.destination and rcv.color=adjm.color and rcv.inseam=adjm.inseam and rcv.size=adjm.size 
	left join temp_erx_fg1_iss iss on rcv.order_no=iss.order_no and rcv.po_no=iss.po_no and rcv.wo_no=iss.wo_no and rcv.destination=iss.destination and rcv.color=iss.color and rcv.inseam=iss.inseam and rcv.size=iss.size 
	where (coalesce(rcv.qty,0)+coalesce(adjp.qty,0))-(coalesce(adjm.qty,0)+coalesce(iss.qty,0))>0 
) vab
left join order_instructions oi on oi.order_no = vab.order_no 
left join quotation_header qh on oi.quote_no=qh.quote_no and oi.quote_rev_no=qh.rev_no
left join m_prod_types mpt on qh.product_types_id=mpt.product_types_id
left join m_prod_type mpt2 on qh.product_type_id=mpt2.product_type_id
group by vab.order_no, vab.wo_no, oi.buyer_style_no, oi.buyer_name, oi.buyer_div, oi.season, oi.season_yr, mpt2.product_type_name, mpt.product_types_name, vab.destination, vab.color, vab.size, vab.inseam
having sum(vab.qty) <> 0
		", [$version, $type]);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$resp['code'] = 400;
			$resp['messages'] = 'Error';
		} else {
			$this->db->trans_commit();
			$resp['code'] = 200;
			$resp['messages'] = 'Success';
		}
		return $resp;
	}

	public function generateScopeFinHie_secondGradeA($version)
	{
		$type = 'SECOND-GRADE-A';
		$this->db->trans_begin();

		$q = $this->db->query("
		INSERT INTO datatex_scopefin_hierarchy (
			order_no,
			wo_no,
			item_type,
			sub1_buyerstyle,
			sub2_buyer,
			sub3_season,
			sub4_prodsegment,
			sub5_prodcategory,
			sub6_prodtype,
			sub7_destination,
			sub8_inseam,
			sub9_color,
			sub10_size,
			fulldesc,
			qty,
			dtscfinhie_version,
			dtscfinhie_type
		)
		select 
		vab.order_no, 
		vab.wo_no, 
		'GMT' as item_type, 
		oi.buyer_style_no as sub1_buyerstyle,
		oi.buyer_name as sub2_buyer,
		concat_ws('',oi.season, oi.season_yr) as sub3_season,
		case 
			when oi.buyer_div = 'L' then  'LADIES'
			when oi.buyer_div = 'M' then  'MAN'
			when oi.buyer_div = 'W' then  'LADIES'
			when oi.buyer_div = 'K' then  'KIDS'
			when oi.buyer_div = 'I' then  'INFANT'
			when oi.buyer_div = 'T' then  'TOODLER'
			when oi.buyer_div = 'O' then  'OTHER'
			else 'NA'
		end as sub4_prodsegment,
		'WOV' as sub5_prodcategory,
		mpt2.product_type_name||' '||mpt.product_types_name as sub6_prodtype,
		'NA' as sub7_destination,
		vab.inseam as sub8_inseam,
		vab.color as sub9_color, 
		vab.size as sub10_size,
		concat_ws('-', 
			oi.buyer_style_no, 
			oi.buyer_name, 
			concat_ws('',oi.season, oi.season_yr),
			case 
				when oi.buyer_div = 'L' then  'LADIES'
				when oi.buyer_div = 'M' then  'MAN'
				when oi.buyer_div = 'W' then  'LADIES'
				when oi.buyer_div = 'K' then  'KIDS'
				when oi.buyer_div = 'I' then  'INFANT'
				when oi.buyer_div = 'T' then  'TOODLER'
				when oi.buyer_div = 'O' then  'OTHER'
				else 'NA'
			end,
			'WOVEN',
			(mpt2.product_type_name||' '||mpt.product_types_name),
			vab.destination,
			vab.inseam,
			vab.color,
			vab.size
		) as fullcode,
		sum(vab.qty) as qty,
		11 as dtscfinhie_version,
		'SECOND-GRADE-A' as dtscfinhie_type
		from 
		(
select null as destination, rcv.order_no, rcv.wo_no, rcv.color, rcv.inseam, rcv.size, (coalesce(rcv.qty,0)+coalesce(adjp.qty,0))-(coalesce(adjm.qty,0)+coalesce(iss.qty,0)) qty
from temp_erx_fg2_rcv rcv
left join temp_erx_fg2_adjp adjp on rcv.order_no=adjp.order_no and rcv.wo_no=adjp.wo_no and rcv.color=adjp.color and rcv.inseam=adjp.inseam and rcv.size=adjp.size 
left join temp_erx_fg2_adjm adjm on rcv.order_no=adjm.order_no and rcv.wo_no=adjm.wo_no and rcv.color=adjm.color and rcv.inseam=adjm.inseam and rcv.size=adjm.size 
left join temp_erx_fg2_iss iss on rcv.order_no=iss.order_no and rcv.wo_no=iss.wo_no and rcv.color=iss.color and rcv.inseam=iss.inseam and rcv.size=iss.size 
where (coalesce(rcv.qty,0)+coalesce(adjp.qty,0))-(coalesce(adjm.qty,0)+coalesce(iss.qty,0))>0 
		) as vab
left join order_instructions oi on oi.order_no = vab.order_no
left join quotation_header qh on oi.quote_no=qh.quote_no and oi.quote_rev_no=qh.rev_no
left join m_prod_types mpt on qh.product_types_id=mpt.product_types_id
left join m_prod_type mpt2 on qh.product_type_id=mpt2.product_type_id
group by vab.order_no, vab.wo_no, oi.buyer_style_no, oi.buyer_name, oi.buyer_div, oi.season, oi.season_yr, mpt2.product_type_name, mpt.product_types_name,  vab.destination, vab.color, vab.size, vab.inseam
having sum(vab.qty) <> 0
		", [$version, $type]);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$resp['code'] = 400;
			$resp['messages'] = 'Error';
		} else {
			$this->db->trans_commit();
			$resp['code'] = 200;
			$resp['messages'] = 'Success';
		}
		return $resp;
	}

	public function generateScopeFinHie_wip($version){
		$type = 'WIP';
		$this->db->trans_begin();

		$q = $this->db->query("
		INSERT INTO datatex_scopefin_hierarchy (
			order_no,
			wo_no,
			item_type,
			sub1_buyerstyle,
			sub2_buyer,
			sub3_season,
			sub4_prodsegment,
			sub5_prodcategory,
			sub6_prodtype,
			sub7_destination,
			sub8_inseam,
			sub9_color,
			sub10_size,
			fulldesc,
			qty,
			dtscfinhie_version,
			dtscfinhie_type
		)
		select wo.order_no, wo.wo_no, 
		'GMT' as item_type, 
		oi.buyer_style_no as sub1_buyerstyle,
		oi.buyer_name as sub2_buyer,
		concat_ws('',oi.season, oi.season_yr) as sub3_season,
		case 
			when oi.buyer_div = 'L' then  'LADIES'
			when oi.buyer_div = 'M' then  'MAN'
			when oi.buyer_div = 'W' then  'LADIES'
			when oi.buyer_div = 'K' then  'KIDS'
			when oi.buyer_div = 'I' then  'INFANT'
			when oi.buyer_div = 'T' then  'TOODLER'
			when oi.buyer_div = 'O' then  'OTHER'
			else 'NA'
		end as sub4_prodsegment,
		'WOVEN' as sub5_prodcategory,
		mpn.product_name as sub6_prodtype,
		wb.destination as sub7_destination,
		ws.garment_inseams as sub8_inseam,
		ws.garment_colors as sub9_color,
		ws.garment_sizes as sub10_size,
		concat_ws('-', 
			oi.buyer_style_no, 
			oi.buyer_name, 
			concat_ws('',oi.season, oi.season_yr),
			case 
				when oi.buyer_div = 'L' then  'LADIES'
				when oi.buyer_div = 'M' then  'MAN'
				when oi.buyer_div = 'W' then  'LADIES'
				when oi.buyer_div = 'K' then  'KIDS'
				when oi.buyer_div = 'I' then  'INFANT'
				when oi.buyer_div = 'T' then  'TOODLER'
				when oi.buyer_div = 'O' then  'OTHER'
				else 'NA'
			end,
			'WOV',
			mpn.product_name,
			wb.destination,
			ws.garment_inseams,
			ws.garment_colors,
			ws.garment_sizes
		) as fullcode,
		ws.quantity as qty,
		? as dtscfinhie_version,
		? as dtscfinhie_type
		from datatex_scopewip_hierarchy dsh 
		left join work_orders wo on wo.wo_no = dsh.wo_no 
		left join order_instructions oi on oi.order_no = wo.order_no
		left join m_product_name mpn on mpn.product_name_id = oi.fr_product_type
		left join wo_sb ws on ws.wo_no = dsh.wo_no 
		left join wo_bpo wb on wb.wo_no = dsh.wo_no and wb.order_no = oi.order_no and wb.buyer_po_number = ws.buyer_po_number 
		where ws.quantity <> 0 and dtscwiphie_version = $version
		", [$version, $type]);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$resp['code'] = 400;
			$resp['messages'] = 'Error';
		} else {
			$this->db->trans_commit();
			$resp['code'] = 200;
			$resp['messages'] = 'Success';
		}
		return $resp;
	}

	public function getAllScopeHierarchy()
	{
		$lastFirst = $this->getLatestVersion('FIRST');
		$lastSecondeGradeA = $this->getLatestVersion('SECOND-GRADE-A');
		$lastWip = $this->getLatestVersion('WIP');

		$q = $this->db->query(
			"select dsh.* from datatex_scopefin_hierarchy dsh 
			where ((dsh.dtscfinhie_type = 'FIRST' and dsh.dtscfinhie_version = ?) or 
			(dsh.dtscfinhie_type = 'SECOND-GRADE-A' and dsh.dtscfinhie_version = ?) or 
			(dsh.dtscfinhie_type = 'WIP' and dsh.dtscfinhie_version = ?))",
			[$lastFirst, $lastSecondeGradeA, $lastWip]
		)->result();

		return $q;
	}


	//==========STEP 2==========
	public function generateUGG($subcode, $version = 1)
	{
		$allHies = $this->getAllScopeHierarchy();
		$gmtSubcodes = $this->getGMTSubcode();
		$dtmsubcode_id = null;
		foreach($gmtSubcodes as $eSubcode){
			if ($eSubcode->dtmsubcodedtl_seq == $subcode){
				$dtmsubcode_id = $eSubcode->dtmsubcode_option_id;
			}
		}
		

		$colName = '';
		switch ($subcode) {
			case 1:
				$colName = 'sub1_buyerstyle';
				break;
			case 2:
				$colName = 'sub2_buyer';
				break;
			case 3:
				$colName = 'sub3_season';
				break;
			case 4:
				$colName = 'sub4_prodsegment';
				break;
			case 5:
				$colName = 'sub5_prodcategory';
				break;
			case 6:
				$colName = 'sub6_prodtype';
				break;
			case 7:
				$colName = 'sub7_destination';
				break;
			case 8:
				$colName = 'sub8_inseam';
				break;
			case 9:
				$colName = 'sub9_color';
				break;
			case 10:
				$colName = 'sub10_size';
				break;
			default:
				exit("No Column Inf");
		}

		$arrSubcodes = array();
		foreach ($allHies as $e) {
			$arrSubcodes[] = $e->$colName;
		}
		$arrSubcodes = array_values(array_unique($arrSubcodes));

		$this->db->trans_begin();
		$arrBatch = [];
		for ($i = 0; $i < count($arrSubcodes); $i++) {
			$dtscfinopt_code = '';
			// if ($subcode == 2) {
			// 	$dtscfinopt_code = $arrSubcodes[$i];
			// } else {
				$dtscfinopt_code = substr(str_shuffle(str_repeat("012345678ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 5);
			// }
			$arrBatch[] = [
				'dtscfinopt_name' => $arrSubcodes[$i],
				'dtscfinopt_code' => $dtscfinopt_code,
				'dtscfinopt_subcodeseq' => $subcode,
				'dtmsubcode_id' => $dtmsubcode_id,
				'dtscfinopt_version' => $version
			];
		}

		$this->db->insert_batch('datatex_scopefin_options', $arrBatch);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$resp['code'] = 400;
			$resp['messages'] = 'Error';
		} else {
			$this->db->trans_commit();
			$resp['code'] = 200;
			$resp['messages'] = 'Success';
		}

		return $resp;
	}

	public function generateSubcodeHierarchiFromOptions($subcode){
		
	}
}

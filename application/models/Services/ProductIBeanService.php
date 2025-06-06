<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class ProductIBeanService extends CI_model
{
	private function getLastCounter()
	{
		$q = $this->db->query('select importautocounter from datatex_productibean_240706 order by importautocounter desc limit 1')->row_array();
		$curNo = $q['importautocounter'] ?? 50000000000;

		return $curNo + 1;
	}
	public function generateFAB()
	{
		$this->db->trans_begin();

		$prodibeandtls = $this->db->query("
			select a.*,b.name as material_name,
			b.content_name,
			b.material_name,
			b.reference_name ,
			b.construction_name,
			bb.name as subclassif_name,
			e.dtmitem_uom_id			
			from (select itemtypecode,max(item_id) item_id,string_agg(item_id,',') search_item,
				  subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,sks
					from (
							SELECT itemtypecode,
							subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,
							item_id,
							concat(itemtypecode,'-',trim(subcode01),'-',trim(subcode02),'-',trim(subcode03),'-',trim(subcode04),'-',trim(subcode05),'-',trim(subcode06),'-',trim(subcode07),'-',trim(subcode08)) sks
							FROM datatex_productibeandtl_240706 a
							left join datatex_productibeandtl_status_240706 f on a.dtmitem_id=f.dtmitem_id
							where itemtypecode = 'FAB' and status_subcode = 'confirmed') af 
					GROUP BY itemtypecode,
					subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,sks
					ORDER BY sks) a 
			left join datatex_m_item e on a.item_id=e.item_id
			left join m_item b on b.item_id = a.item_id 
			left join m_subclassification bb on bb.subclassif_id  = b.subclassif_id ")
			->result_array();

		$aGroupPrimary = [];
		foreach ($prodibeandtls as $p0) {
			$primarySubcode[] = $p0['subcode01'];
			$primarySubcode[] = $p0['subcode02'];
			$primarySubcode[] = $p0['subcode03'];
			$primarySubcode[] = $p0['subcode04'];
			$primarySubcode[] = $p0['subcode05'];
			$primarySubcode[] = $p0['subcode06'];
			$primarySubcode[] = $p0['subcode07'];
			$primarySubcode[] = $p0['subcode08'];
			//$primarySubcode[] = $p0['subcode09'];
			$sPrimarySubcode = implode('-', $primarySubcode);

			$aGroupPrimary[$sPrimarySubcode][] = $p0;
			$primarySubcode = [];
		}
		
		// print_r($sPrimarySubcode);
		$counter = $this->getLastCounter();
		foreach ($aGroupPrimary as $primary => $elements) {
			foreach($this->db->query("
			select case when max(a.dtxproductibeanid)= max(b.dtxproductibeanid) then 1 else 0 end cekprod
            from
			datatex_productibeandtl_240706 a
			join datatex_productibean_240706  b 
			on trim(a.itemtypecode) = trim(b.itemtypecode) and 
			trim(a.subcode01) = trim(b.subcode01) and
			trim(a.subcode02) = trim(b.subcode02) and
			trim(a.subcode03) = trim(b.subcode03) and
			trim(a.subcode04) = trim(b.subcode04) and
			trim(a.subcode05) = trim(b.subcode05) and
			trim(a.subcode06) = trim(b.subcode06) and
			trim(a.subcode07) = trim(b.subcode07) and
			trim(a.subcode08) = trim(b.subcode08)
			left join datatex_productibeandtl_status_240706 c on a.dtmitem_id=c.dtmitem_id
			where b.itemtypecode = 'FAB' and 
			trim(a.subcode01) = '".trim($elements[0]['subcode01'])."' and
			trim(a.subcode02) = '".trim($elements[0]['subcode02'])."' and
			trim(a.subcode03) = '".trim($elements[0]['subcode03'])."' and
			trim(a.subcode04) = '".trim($elements[0]['subcode04'])."' and
			trim(a.subcode05) = '".trim($elements[0]['subcode05'])."' and
			trim(a.subcode06) = '".trim($elements[0]['subcode06'])."' and
			trim(a.subcode07) = '".trim($elements[0]['subcode07'])."' and
			trim(a.subcode08) = '".trim($elements[0]['subcode08'])."'
			and c.status_subcode = 'confirmed'
			;")->result_array() as $gkw);
		$cno = 1;
			if($gkw['cekprod'] == 0){
				$desc = "{$elements[0]['subclassif_name']} {$elements[0]['material_name']} {$elements[0]['content_name']} {$elements[0]['reference_name']} {$elements[0]['construction_name']}";
				$itemids = '';
				$aItemids = [];
				foreach ($elements as $el) {
					$aItemids[] = trim($el['item_id']);
				}
				$itemids = implode(',', $aItemids);
				$arrData = array(
						'companycode' => 'BAG',
						'importautocounter' => $counter,
						'divisioncode' => null,
						'previousdescription' => null,
						'logincompanycode' => null,
						'descriptionchanged' => 0,
						'itemtypecode' => 'FAB',
						'subcode01' => trim($elements[0]['subcode01']),
						'subcode02' => trim($elements[0]['subcode02']),
						'subcode03' => trim($elements[0]['subcode03']),
						'subcode04' => trim($elements[0]['subcode04']),
						'subcode05' => trim($elements[0]['subcode05']),
						'subcode06' => trim($elements[0]['subcode06']),
						'subcode07' => trim($elements[0]['subcode07']),
						'subcode08' => trim($elements[0]['subcode08']),
						'subcode09' => null, //secondary subcode
						'subcode10' => null, //secondary subcode
						'longdescription' =>  substr($desc, 0, 200), //check desc
						'shortdescription' => substr($desc, 0, 80),
						'searchdescription' => substr(trim($elements[0]['search_item']), 0, 120),
						'externalcode' => null,
						'baseprimaryunitcode' => $elements[0]['dtmitem_uom_id'], //check uom
						'basecostunitcode' => $elements[0]['dtmitem_uom_id'], //check uom
						'basesecondaryunitcode' => null,
						'secondaryunsteadycvsfactor' => 0,
						'conversionfactortype' => 1,
						'multiplier' => 0,
						'conversionfactorpolicycode' => null,
						'createsellingitem' => 1,
						'createpurchaseorderitem' => 1,
						'createinternalorderitem' => 1,
						'lotcontrolled' => 1,
						'existentlotsloading' => 3,
						'lotcountercode' => 'LOTMNL01',
						'chooselotcode' => 'LOTDEFAULTORDER',
						'checklotcode' => 'DEFAULT',
						'lotexpirationcode' => 'NEVER',
						'containercontrolled' => 0,
						'severalcontainertypeallowed' => 0,
						'containeritemtypecode' => null,
						'containersubcode01' => null,
						'choosecontainercode' => null,
						'elementcontrolled' => 1,
						'elementcountercode' => 'ROLL01',
						'chooseelementscode' => 'ELEMENTSDEFAULT',
						'checkelementscode' => 'DEFAULT',
						'qualitycontrolled' => 2,
						'qualitygroupcode' => '001',
						'projectcontrolled' => 1,
						'statisticalgroupcontrolled' => 0,
						'customercontrolled' => 0,
						'suppliercontrolled' => 0,
						'takeallqadefinitions' => 1,
						'prototype' => 0,
						'bartypecode' => null,
						'barcode' => null,
						'drawingnumber' => null,
						'manufacturercode' => null,
						'compositioncode' => null,
						'intrastatcode' => null,
						'origincountrycode' => null,
						'lifogrpcode' => null,
						'foreusestandardgrouptypecode' => '101',
						'foreusecode' => null,
						'stocktakestandardgrouptypecode' => '104',
						'stocktakecode' => null,
						'replenstandardgrouptypecode' => '102',
						'replencode' => null,
						'familygrpcode' => null,
						'qaitemgroupcode' => null,
						'budgetusergrpusergengrptypecod' => null,
						'budgetusergrpcode' => null,
						'status' => 0,
						'approvaldate' => null,
						'approvaluser' => null,
						'releasedate' => null,
						'releaseuser' => null,
						'validitystatus' => 0,
						'initialdate' => null,
						'finaldate' => null,
						'firstusergrpusergengrptypecod' => null,
						'firstusergrpcode' => null,
						'sndusergrpusergengrptypecode' => null,
						'secondusergrpcode' => null,
						'thirdusergrpusergengrptypecod' => null,
						'thirdusergrpcode' => null,
						'fourthusergrpusergengrptypecod' => null,
						'fourthusergrpcode' => null,
						'fifthusergrpusergengrptypecod' => null,
						'fifthusergrpcode' => null,
						'productionuomtype' => 1,
						'productionunitcode' => $elements[0]['dtmitem_uom_id'],
						'stdproductionbatch' => 1,
						'subcontractorsupplytype' => 0,
						'customersupplytype' => 0,
						'costcategorycode' => 'C000',
						'costlevelcode' => null,
						'wasteproduct' => 1,
						'productiongroupcode' => null,
						'bomsubcode01' => null,
						'bomvirtualreturnsubcode' => null,
						'bomsubcode02' => null,
						'bomsubcode03' => null,
						'bomsubcode04' => null,
						'bomsubcode05' => null,
						'bomsubcode06' => null,
						'bomsubcode07' => null,
						'bomsubcode08' => null,
						'bomsubcode09' => null,
						'bomsubcode10' => null,
						'rtgsubcode01' => null,
						'rtgvirtualreturnsubcode' => null,
						'rtgsubcode02' => null,
						'rtgsubcode03' => null,
						'rtgsubcode04' => null,
						'rtgsubcode05' => null,
						'rtgsubcode06' => null,
						'rtgsubcode07' => null,
						'rtgsubcode08' => null,
						'rtgsubcode09' => null,
						'rtgsubcode10' => null,
						'pickuppercentage' => 0,
						'consumptionfactor' => 0,
						'keepoldprice' => 0,
						'internalprice' => 0,
						'internalpriceuomcode' => null,
						'validfromdate' => null,
						'validtodate' => null,
						'intpricelistcode' => null,
						'intpricecostgroupcode' => null,
						'intpriceplantcode' => null,
						'numberofkeystoinput' => 0,
						'translatedlongdescription' => null,
						'translatedlanguagecode' => null,
						'translatedshortdescription' => null,
						'prodwashsymbol01code' => null,
						'prodwashsymbol02code' => null,
						'prodwashsymbol03code' => null,
						'prodwashsymbol04code' => null,
						'prodwashsymbol05code' => null,
						'prodwashsymbol06code' => null,
						'maxlaylength' => 0,
						'maxnolayers' => 0,
						'widthrangefrom' => 0,
						'widthrangeto' => 0,
						'gsmrangefrom' => 0,
						'gsmrangeto' => 0,
						'shrinkage' => 0,
						'siitemtypecode' => null,
						'sisubcode01' => null,
						'sisubcode02' => null,
						'sisubcode03' => null,
						'sisubcode04' => null,
						'sisubcode05' => null,
						'sisubcode06' => null,
						'sisubcode07' => null,
						'sisubcode08' => null,
						'sisubcode09' => null,
						'sisubcode10' => null,
						'fncstandardordergroupcode' => null,
						'netweight' => 0,
						'grossweight' => 0,
						'realnetweight' => 0,
						'weightuomcode' => null,
						'price' => 0,
						'alloweddivisionsstr' => null,
						'owningcompanycode' => '301',
						'tariffcode' => 'NA',
						'taxtemplatedetailtemplatetype' => 2,
						'taxtemplatedetailcode' => null,
						'gstwithinstatetemplatetype' => 2,
						'gstwithinstatecode' => null,
						'gstinterstatetemplatetype' => 2,
						'gstinterstatecode' => null,
						'shipmentarticlecode' => null,
						'taxtemplateheadertemplatetype' => 1,
						'taxtemplateheadercode' => null,
						'inputcapital' => 0,
						'prodpricecontrol' => 0,
						'comtransitflag' => 0,
						'servicebillflag' => 0,
						'wsoperation' => 1,
						'impoperationuser' => null,
						'importstatus' => 3,
						'impcreationdatetime' => null,
						'impcreationuser' => 'system',
						'implastupdatedatetime' => date('Y-m-d H:i:s'),
						'implastupdateuser' => 'system',
						'importdatetime' => date('Y-m-d H:i:s'),
						'retrynr' => 0,
						'nextretry' => 0,
						'importid' => 0,
						'relateddependentid' => $counter,
						'timetype' => 0,
						'fixedhours' => 0,
						'speed' => 0,
						'speedunitofmeasurecode' => null,
						'dtxproductibeanseq' => 1, // helper column
						'item_grouping' => trim($elements[0]['search_item']) //helper column
				);
				$counter++;
				$cno++;

				$this->db->insert('datatex_productibean_240706', $arrData);
			}
		
		}
		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$resp['code'] = 400;
			$resp['messages'] = 'Error';
		} else {
			$this->db->trans_commit();
			$resp['code'] = 200;
			$resp['messages'] = 'Success';
		}
		var_dump("DONE");
		
		return $resp;
	}

	public function generateTRM()
	{
		$this->db->trans_begin();

		$prodibeandtls = $this->db->query("
			select a.*,b.name as material_name,
			b.content_name,
			b.material_name,
			b.reference_name ,
			b.construction_name,
			bb.name as subclassif_name,
			e.dtmitem_uom_id			
			from (select itemtypecode,max(item_id) item_id,string_agg(item_id,',') search_item,
				  subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,sks
					from (
							SELECT itemtypecode,
							subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,
							item_id,
							concat(itemtypecode,'-',trim(subcode01),'-',trim(subcode02),'-',trim(subcode03),'-',trim(subcode04),'-',trim(subcode05),'-',trim(subcode06)) sks
							FROM datatex_productibeandtl_240706 a
							left join datatex_productibeandtl_status_240706 f on a.dtmitem_id=f.dtmitem_id
							where itemtypecode = 'TRM' and status_subcode = 'confirmed') af 
					GROUP BY itemtypecode,
					subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,sks
					ORDER BY sks) a 
			left join datatex_m_item e on a.item_id=e.item_id
			left join m_item b on b.item_id = a.item_id 
			left join m_subclassification bb on bb.subclassif_id  = b.subclassif_id ")
			->result_array();

		$aGroupPrimary = [];
		foreach ($prodibeandtls as $p0) {
			$primarySubcode[] = $p0['subcode01'];
			$primarySubcode[] = $p0['subcode02'];
			$primarySubcode[] = $p0['subcode03'];
			$primarySubcode[] = $p0['subcode04'];
			$primarySubcode[] = $p0['subcode05'];
			$primarySubcode[] = $p0['subcode06'];
			//$primarySubcode[] = $p0['subcode07'];
			// $primarySubcode[] = $p0['subcode08'];
			// $primarySubcode[] = $p0['subcode09'];
			$sPrimarySubcode = implode('-', $primarySubcode);

			$aGroupPrimary[$sPrimarySubcode][] = $p0;
			$primarySubcode = [];
		}

		$counter = $this->getLastCounter();
		foreach ($aGroupPrimary as $primary => $elements) {
			foreach($this->db->query("
			select case when max(a.dtxproductibeanid)= max(b.dtxproductibeanid) then 1 else 0 end cekprod
            from
			datatex_productibeandtl_240706 a
			join datatex_productibean_240706  b 
			on trim(a.itemtypecode) = trim(b.itemtypecode) and 
			trim(a.subcode01) = trim(b.subcode01) and
			trim(a.subcode02) = trim(b.subcode02) and
			trim(a.subcode03) = trim(b.subcode03) and
			trim(a.subcode04) = trim(b.subcode04) and
			trim(a.subcode05) = trim(b.subcode05) and
			trim(a.subcode06) = trim(b.subcode06)
			left join datatex_productibeandtl_status_240706 c on a.dtmitem_id=c.dtmitem_id
			where b.itemtypecode = 'TRM' and 
			trim(a.subcode01) = '".trim($elements[0]['subcode01'])."' and
			trim(a.subcode02) = '".trim($elements[0]['subcode02'])."' and
			trim(a.subcode03) = '".trim($elements[0]['subcode03'])."' and
			trim(a.subcode04) = '".trim($elements[0]['subcode04'])."' and
			trim(a.subcode05) = '".trim($elements[0]['subcode05'])."' and
			trim(a.subcode06) = '".trim($elements[0]['subcode06'])."' and
			c.status_subcode = 'confirmed'
			;")->result_array() as $gkw);
			$cno = 1;
			if($gkw['cekprod'] == 0){
				$desc = "{$elements[0]['subclassif_name']} {$elements[0]['material_name']} {$elements[0]['content_name']} {$elements[0]['reference_name']} {$elements[0]['construction_name']}";
				$itemids = '';
				$aItemids = [];
				foreach ($elements as $el) {
					$aItemids[] = trim($el['item_id']);
				}
				$itemids = implode(',', $aItemids);
				$arrData = array(
					'companycode' => 'BAG',
					'importautocounter' => $counter,
					'divisioncode' => null,
					'previousdescription' => null,
					'logincompanycode' => null,
					'descriptionchanged' => 0,
					'itemtypecode' => 'TRM',
					//'subcode01' => str_replace(' ','_',trim($elements[0]['subcode01'])),
					'subcode01' => trim($elements[0]['subcode01']),
					'subcode02' => trim($elements[0]['subcode02']),
					'subcode03' => trim($elements[0]['subcode03']),
					'subcode04' => trim($elements[0]['subcode04']),
					'subcode05' => trim($elements[0]['subcode05']),
					'subcode06' => trim($elements[0]['subcode06']),
					'subcode07' => null, //trim($elements[0]['subcode07']),
					'subcode08' => null, //trim($elements[0]['subcode08']),
					'subcode09' => null, //secondary subcode
					'subcode10' => null, //secondary subcode
					'longdescription' =>  substr($desc, 0, 200), //check desc
					'shortdescription' => substr($desc, 0, 80),
					'searchdescription' => substr(trim($elements[0]['search_item']), 0, 120),
					'externalcode' => null,
					'baseprimaryunitcode' => $elements[0]['dtmitem_uom_id'], //check uom
					'basecostunitcode' => $elements[0]['dtmitem_uom_id'], //check uom
					'basesecondaryunitcode' => null,
					'secondaryunsteadycvsfactor' => 0,
					'conversionfactortype' => 1,
					'multiplier' => 0,
					'conversionfactorpolicycode' => null,
					'createsellingitem' => 1,
					'createpurchaseorderitem' => 1,
					'createinternalorderitem' => 1,
					'lotcontrolled' => 1,
					'existentlotsloading' => 3,
					'lotcountercode' => 'LOTMNL01',
					'chooselotcode' => 'LOTDEFAULTORDER',
					'checklotcode' => 'DEFAULT',
					'lotexpirationcode' => 'NEVER',
					'containercontrolled' => 0,
					'severalcontainertypeallowed' => 0,
					'containeritemtypecode' => null,
					'containersubcode01' => null,
					'choosecontainercode' => null,
					'elementcontrolled' => 0,
					'elementcountercode' => null, //'ROLL01',
					'chooseelementscode' => null, //'ELEMENTSDEFAULT',
					'checkelementscode' => null, //'DEFAULT',
					'qualitycontrolled' => 2,
					'qualitygroupcode' => '001',
					'projectcontrolled' => 1,
					'statisticalgroupcontrolled' => 0,
					'customercontrolled' => 0,
					'suppliercontrolled' => 0,
					'takeallqadefinitions' => 1,
					'prototype' => 0,
					'bartypecode' => null,
					'barcode' => null,
					'drawingnumber' => null,
					'manufacturercode' => null,
					'compositioncode' => null,
					'intrastatcode' => null,
					'origincountrycode' => null,
					'lifogrpcode' => null,
					'foreusestandardgrouptypecode' => '101',
					'foreusecode' => null,
					'stocktakestandardgrouptypecode' => '104',
					'stocktakecode' => null,
					'replenstandardgrouptypecode' => '102',
					'replencode' => null,
					'familygrpcode' => null,
					'qaitemgroupcode' => null,
					'budgetusergrpusergengrptypecod' => null,
					'budgetusergrpcode' => null,
					'status' => 0,
					'approvaldate' => null,
					'approvaluser' => null,
					'releasedate' => null,
					'releaseuser' => null,
					'validitystatus' => 0,
					'initialdate' => null,
					'finaldate' => null,
					'firstusergrpusergengrptypecod' => null,
					'firstusergrpcode' => null,
					'sndusergrpusergengrptypecode' => null,
					'secondusergrpcode' => null,
					'thirdusergrpusergengrptypecod' => null,
					'thirdusergrpcode' => null,
					'fourthusergrpusergengrptypecod' => null,
					'fourthusergrpcode' => null,
					'fifthusergrpusergengrptypecod' => null,
					'fifthusergrpcode' => null,
					'productionuomtype' => 1,
					'productionunitcode' => $elements[0]['dtmitem_uom_id'],
					'stdproductionbatch' => 1,
					'subcontractorsupplytype' => 0,
					'customersupplytype' => 0,
					'costcategorycode' => 'C001',
					'costlevelcode' => null,
					'wasteproduct' => 1,
					'productiongroupcode' => null,
					'bomsubcode01' => null,
					'bomvirtualreturnsubcode' => null,
					'bomsubcode02' => null,
					'bomsubcode03' => null,
					'bomsubcode04' => null,
					'bomsubcode05' => null,
					'bomsubcode06' => null,
					'bomsubcode07' => null,
					'bomsubcode08' => null,
					'bomsubcode09' => null,
					'bomsubcode10' => null,
					'rtgsubcode01' => null,
					'rtgvirtualreturnsubcode' => null,
					'rtgsubcode02' => null,
					'rtgsubcode03' => null,
					'rtgsubcode04' => null,
					'rtgsubcode05' => null,
					'rtgsubcode06' => null,
					'rtgsubcode07' => null,
					'rtgsubcode08' => null,
					'rtgsubcode09' => null,
					'rtgsubcode10' => null,
					'pickuppercentage' => 0,
					'consumptionfactor' => 0,
					'keepoldprice' => 0,
					'internalprice' => 0,
					'internalpriceuomcode' => null,
					'validfromdate' => null,
					'validtodate' => null,
					'intpricelistcode' => null,
					'intpricecostgroupcode' => null,
					'intpriceplantcode' => null,
					'numberofkeystoinput' => 0,
					'translatedlongdescription' => null,
					'translatedlanguagecode' => null,
					'translatedshortdescription' => null,
					'prodwashsymbol01code' => null,
					'prodwashsymbol02code' => null,
					'prodwashsymbol03code' => null,
					'prodwashsymbol04code' => null,
					'prodwashsymbol05code' => null,
					'prodwashsymbol06code' => null,
					'maxlaylength' => 0,
					'maxnolayers' => 0,
					'widthrangefrom' => 0,
					'widthrangeto' => 0,
					'gsmrangefrom' => 0,
					'gsmrangeto' => 0,
					'shrinkage' => 0,
					'siitemtypecode' => null,
					'sisubcode01' => null,
					'sisubcode02' => null,
					'sisubcode03' => null,
					'sisubcode04' => null,
					'sisubcode05' => null,
					'sisubcode06' => null,
					'sisubcode07' => null,
					'sisubcode08' => null,
					'sisubcode09' => null,
					'sisubcode10' => null,
					'fncstandardordergroupcode' => null,
					'netweight' => 0,
					'grossweight' => 0,
					'realnetweight' => 0,
					'weightuomcode' => null,
					'price' => 0,
					'alloweddivisionsstr' => null,
					'owningcompanycode' => '301',
					'tariffcode' => 'NA',
					'taxtemplatedetailtemplatetype' => 2,
					'taxtemplatedetailcode' => null,
					'gstwithinstatetemplatetype' => 2,
					'gstwithinstatecode' => null,
					'gstinterstatetemplatetype' => 2,
					'gstinterstatecode' => null,
					'shipmentarticlecode' => null,
					'taxtemplateheadertemplatetype' => 1,
					'taxtemplateheadercode' => null,
					'inputcapital' => 0,
					'prodpricecontrol' => 0,
					'comtransitflag' => 0,
					'servicebillflag' => 0,
					'wsoperation' => 1,
					'impoperationuser' => null,
					'importstatus' => 3,
					'impcreationdatetime' => null,
					'impcreationuser' => 'system',
					'implastupdatedatetime' => date('Y-m-d H:i:s'),
					'implastupdateuser' => 'system',
					'importdatetime' => date('Y-m-d H:i:s'),
					'retrynr' => 0,
					'nextretry' => 0,
					'importid' => 0,
					'relateddependentid' => $counter,
					'timetype' => 0,
					'fixedhours' => 0,
					'speed' => 0,
					'speedunitofmeasurecode' => null,
					'dtxproductibeanseq' => 1, // helper column 
					'item_grouping' => trim($elements[0]['search_item']) //helper column
				);
				$counter++;
				
				$this->db->insert('datatex_productibean_240706', $arrData);
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$resp['code'] = 400;
			$resp['messages'] = 'Error';
		} else {
			$this->db->trans_commit();
			$resp['code'] = 200;
			$resp['messages'] = 'Success';
		}
		var_dump("DONE");
		return $resp;
	}

	public function generatePKG()
	{
		$this->db->trans_begin();

		$prodibeandtls = $this->db->query("
			select a.*,b.name as material_name,
			b.content_name,
			b.material_name,
			b.reference_name ,
			b.construction_name,
			bb.name as subclassif_name,
			e.dtmitem_uom_id			
			from (select itemtypecode,max(item_id) item_id,string_agg(item_id,',') search_item,
				  subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,sks
					from (
							SELECT itemtypecode,
							subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,
							item_id,
							concat(itemtypecode,'-',trim(subcode01),'-',trim(subcode02),'-',trim(subcode03),'-',trim(subcode04),'-',trim(subcode05),'-',trim(subcode06),'-',trim(subcode07)) sks
							FROM datatex_productibeandtl_240706 a
							left join datatex_productibeandtl_status_240706 f on a.dtmitem_id=f.dtmitem_id
							where itemtypecode = 'PKG' and status_subcode = 'confirmed') af 
					GROUP BY itemtypecode,
					subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,sks
					ORDER BY sks) a 
			left join datatex_m_item e on a.item_id=e.item_id
			left join m_item b on b.item_id = a.item_id 
			left join m_subclassification bb on bb.subclassif_id  = b.subclassif_id ")
			->result_array();

		$aGroupPrimary = [];
		foreach ($prodibeandtls as $p0) {
			$primarySubcode[] = $p0['subcode01'];
			$primarySubcode[] = $p0['subcode02'];
			$primarySubcode[] = $p0['subcode03'];
			$primarySubcode[] = $p0['subcode04'];
			$primarySubcode[] = $p0['subcode05'];
			$primarySubcode[] = $p0['subcode06'];
			$primarySubcode[] = $p0['subcode07'];
			//$primarySubcode[] = $p0['subcode08'];
			// $primarySubcode[] = $p0['subcode09'];
			$sPrimarySubcode = implode('-', $primarySubcode);

			$aGroupPrimary[$sPrimarySubcode][] = $p0;
			$primarySubcode = [];
		}

		$counter = $this->getLastCounter();
		foreach ($aGroupPrimary as $primary => $elements) {
			foreach($this->db->query("
				select case when max(a.dtxproductibeanid)= max(b.dtxproductibeanid) then 1 else 0 end cekprod
				from
				datatex_productibeandtl_240706 a
				join datatex_productibean_240706  b 
				on trim(a.itemtypecode) = trim(b.itemtypecode) and 
				trim(a.subcode01) = trim(b.subcode01) and
				trim(a.subcode02) = trim(b.subcode02) and
				trim(a.subcode03) = trim(b.subcode03) and
				trim(a.subcode04) = trim(b.subcode04) and
				trim(a.subcode05) = trim(b.subcode05) and
				trim(a.subcode06) = trim(b.subcode06) and
				trim(a.subcode07) = trim(b.subcode07)
				left join datatex_productibeandtl_status_240706 c on a.dtmitem_id=c.dtmitem_id
				where b.itemtypecode = 'PKG' and 
				trim(a.subcode01) = '".trim($elements[0]['subcode01'])."' and
				trim(a.subcode02) = '".trim($elements[0]['subcode02'])."' and
				trim(a.subcode03) = '".trim($elements[0]['subcode03'])."' and
				trim(a.subcode04) = '".trim($elements[0]['subcode04'])."' and
				trim(a.subcode05) = '".trim($elements[0]['subcode05'])."' and
				trim(a.subcode06) = '".trim($elements[0]['subcode06'])."' and
				trim(a.subcode07) = '".trim($elements[0]['subcode07'])."' and
				c.status_subcode = 'confirmed'
				;")->result_array() as $gkw);
		
			if($gkw['cekprod'] == 0){
				$desc = "{$elements[0]['subclassif_name']} {$elements[0]['material_name']} {$elements[0]['content_name']} {$elements[0]['reference_name']} {$elements[0]['construction_name']}";
				$itemids = '';
				$aItemids = [];
				foreach ($elements as $el) {
					$aItemids[] = trim($el['item_id']);
				}
				$itemids = implode(',', $aItemids);
				$arrData = array(
					'companycode' => 'BAG',
					'importautocounter' => $counter,
					'divisioncode' => null,
					'previousdescription' => null,
					'logincompanycode' => null,
					'descriptionchanged' => 0,
					'itemtypecode' => 'PKG',
					'subcode01' => trim($elements[0]['subcode01']),
					'subcode02' => trim($elements[0]['subcode02']),
					'subcode03' => trim($elements[0]['subcode03']),
					'subcode04' => trim($elements[0]['subcode04']),
					'subcode05' => trim($elements[0]['subcode05']),
					'subcode06' => trim($elements[0]['subcode06']),
					'subcode07' => trim($elements[0]['subcode07']),
					'subcode08' => null, //trim($elements[0]['subcode08']),
					'subcode09' => null, //secondary subcode
					'subcode10' => null, //secondary subcode
					'longdescription' =>  substr($desc, 0, 200), //check desc
					'shortdescription' => substr($desc, 0, 80),
					'searchdescription' => substr(trim($elements[0]['search_item']), 0, 120),
					'externalcode' => null,
					'baseprimaryunitcode' => $elements[0]['dtmitem_uom_id'], //check uom
					'basecostunitcode' => $elements[0]['dtmitem_uom_id'], //check uom
					'basesecondaryunitcode' => null,
					'secondaryunsteadycvsfactor' => 0,
					'conversionfactortype' => 1,
					'multiplier' => 0,
					'conversionfactorpolicycode' => null,
					'createsellingitem' => 1,
					'createpurchaseorderitem' => 1,
					'createinternalorderitem' => 1,
					'lotcontrolled' => 1,
					'existentlotsloading' => 3,
					'lotcountercode' => 'LOTMNL01',
					'chooselotcode' => 'LOTDEFAULTORDER',
					'checklotcode' => 'DEFAULT',
					'lotexpirationcode' => 'NEVER',
					'containercontrolled' => 0,
					'severalcontainertypeallowed' => 0,
					'containeritemtypecode' => null,
					'containersubcode01' => null,
					'choosecontainercode' => null,
					'elementcontrolled' => 0,
					'elementcountercode' => null, //'ROLL01',
					'chooseelementscode' => null, //'ELEMENTSDEFAULT',
					'checkelementscode' => null, //'DEFAULT',
					'qualitycontrolled' => 2,
					'qualitygroupcode' => '001',
					'projectcontrolled' => 1,
					'statisticalgroupcontrolled' => 0,
					'customercontrolled' => 0,
					'suppliercontrolled' => 0,
					'takeallqadefinitions' => 1,
					'prototype' => 0,
					'bartypecode' => null,
					'barcode' => null,
					'drawingnumber' => null,
					'manufacturercode' => null,
					'compositioncode' => null,
					'intrastatcode' => null,
					'origincountrycode' => null,
					'lifogrpcode' => null,
					'foreusestandardgrouptypecode' => '101',
					'foreusecode' => null,
					'stocktakestandardgrouptypecode' => '104',
					'stocktakecode' => null,
					'replenstandardgrouptypecode' => '102',
					'replencode' => null,
					'familygrpcode' => null,
					'qaitemgroupcode' => null,
					'budgetusergrpusergengrptypecod' => null,
					'budgetusergrpcode' => null,
					'status' => 0,
					'approvaldate' => null,
					'approvaluser' => null,
					'releasedate' => null,
					'releaseuser' => null,
					'validitystatus' => 0,
					'initialdate' => null,
					'finaldate' => null,
					'firstusergrpusergengrptypecod' => null,
					'firstusergrpcode' => null,
					'sndusergrpusergengrptypecode' => null,
					'secondusergrpcode' => null,
					'thirdusergrpusergengrptypecod' => null,
					'thirdusergrpcode' => null,
					'fourthusergrpusergengrptypecod' => null,
					'fourthusergrpcode' => null,
					'fifthusergrpusergengrptypecod' => null,
					'fifthusergrpcode' => null,
					'productionuomtype' => 1,
					'productionunitcode' => $elements[0]['dtmitem_uom_id'],
					'stdproductionbatch' => 1,
					'subcontractorsupplytype' => 0,
					'customersupplytype' => 0,
					'costcategorycode' => 'C002',
					'costlevelcode' => null,
					'wasteproduct' => 1,
					'productiongroupcode' => null,
					'bomsubcode01' => null,
					'bomvirtualreturnsubcode' => null,
					'bomsubcode02' => null,
					'bomsubcode03' => null,
					'bomsubcode04' => null,
					'bomsubcode05' => null,
					'bomsubcode06' => null,
					'bomsubcode07' => null,
					'bomsubcode08' => null,
					'bomsubcode09' => null,
					'bomsubcode10' => null,
					'rtgsubcode01' => null,
					'rtgvirtualreturnsubcode' => null,
					'rtgsubcode02' => null,
					'rtgsubcode03' => null,
					'rtgsubcode04' => null,
					'rtgsubcode05' => null,
					'rtgsubcode06' => null,
					'rtgsubcode07' => null,
					'rtgsubcode08' => null,
					'rtgsubcode09' => null,
					'rtgsubcode10' => null,
					'pickuppercentage' => 0,
					'consumptionfactor' => 0,
					'keepoldprice' => 0,
					'internalprice' => 0,
					'internalpriceuomcode' => null,
					'validfromdate' => null,
					'validtodate' => null,
					'intpricelistcode' => null,
					'intpricecostgroupcode' => null,
					'intpriceplantcode' => null,
					'numberofkeystoinput' => 0,
					'translatedlongdescription' => null,
					'translatedlanguagecode' => null,
					'translatedshortdescription' => null,
					'prodwashsymbol01code' => null,
					'prodwashsymbol02code' => null,
					'prodwashsymbol03code' => null,
					'prodwashsymbol04code' => null,
					'prodwashsymbol05code' => null,
					'prodwashsymbol06code' => null,
					'maxlaylength' => 0,
					'maxnolayers' => 0,
					'widthrangefrom' => 0,
					'widthrangeto' => 0,
					'gsmrangefrom' => 0,
					'gsmrangeto' => 0,
					'shrinkage' => 0,
					'siitemtypecode' => null,
					'sisubcode01' => null,
					'sisubcode02' => null,
					'sisubcode03' => null,
					'sisubcode04' => null,
					'sisubcode05' => null,
					'sisubcode06' => null,
					'sisubcode07' => null,
					'sisubcode08' => null,
					'sisubcode09' => null,
					'sisubcode10' => null,
					'fncstandardordergroupcode' => null,
					'netweight' => 0,
					'grossweight' => 0,
					'realnetweight' => 0,
					'weightuomcode' => null,
					'price' => 0,
					'alloweddivisionsstr' => null,
					'owningcompanycode' => '301',
					'tariffcode' => 'NA',
					'taxtemplatedetailtemplatetype' => 2,
					'taxtemplatedetailcode' => null,
					'gstwithinstatetemplatetype' => 2,
					'gstwithinstatecode' => null,
					'gstinterstatetemplatetype' => 2,
					'gstinterstatecode' => null,
					'shipmentarticlecode' => null,
					'taxtemplateheadertemplatetype' => 1,
					'taxtemplateheadercode' => null,
					'inputcapital' => 0,
					'prodpricecontrol' => 0,
					'comtransitflag' => 0,
					'servicebillflag' => 0,
					'wsoperation' => 1,
					'impoperationuser' => null,
					'importstatus' => 3,
					'impcreationdatetime' => null,
					'impcreationuser' => 'system',
					'implastupdatedatetime' => date('Y-m-d H:i:s'),
					'implastupdateuser' => 'system',
					'importdatetime' => date('Y-m-d H:i:s'),
					'retrynr' => 0,
					'nextretry' => 0,
					'importid' => 0,
					'relateddependentid' => $counter,
					'timetype' => 0,
					'fixedhours' => 0,
					'speed' => 0,
					'speedunitofmeasurecode' => null,
					'dtxproductibeanseq' => 1, // helper column 
					'item_grouping' => trim($elements[0]['search_item']) //helper column
				);
				$counter++;

				$this->db->insert('datatex_productibean_240706', $arrData);
			}
		}

		

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$resp['code'] = 400;
			$resp['messages'] = 'Error';
		} else {
			$this->db->trans_commit();
			$resp['code'] = 200;
			$resp['messages'] = 'Success';
		}
		var_dump("DONE");
		return $resp;
	}

	public function generateINS()
	{
		$this->db->trans_begin();

		$prodibeandtls = $this->db->query("
			select a.*,b.name as material_name,
			b.content_name,
			b.material_name,
			b.reference_name ,
			b.construction_name,
			bb.name as subclassif_name,
			e.dtmitem_uom_id			
			from (select itemtypecode,max(item_id) item_id,string_agg(item_id,',') search_item,
				  subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,sks
					from (
							SELECT itemtypecode,
							subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,
							item_id,
							concat(itemtypecode,'-',trim(subcode01),'-',trim(subcode02),'-',trim(subcode03),'-',trim(subcode04),'-',trim(subcode05),'-',trim(subcode06),'-',trim(subcode07),'-',trim(subcode08)) sks
							FROM datatex_productibeandtl_240706 a
							left join datatex_productibeandtl_status_240706 f on a.dtmitem_id=f.dtmitem_id
							where itemtypecode = 'INS' and status_subcode = 'confirmed') af 
					GROUP BY itemtypecode,
					subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,sks
					ORDER BY sks) a 
			left join datatex_m_item e on a.item_id=e.item_id
			left join m_item b on b.item_id = a.item_id 
			left join m_subclassification bb on bb.subclassif_id  = b.subclassif_id")
			->result_array();

		$aGroupPrimary = [];
		foreach ($prodibeandtls as $p0) {
			$primarySubcode[] = $p0['subcode01'];
			$primarySubcode[] = $p0['subcode02'];
			$primarySubcode[] = $p0['subcode03'];
			$primarySubcode[] = $p0['subcode04'];
			$primarySubcode[] = $p0['subcode05'];
			$primarySubcode[] = $p0['subcode06'];
			$primarySubcode[] = $p0['subcode07'];
			$primarySubcode[] = $p0['subcode08'];
			//$primarySubcode[] = $p0['subcode09'];
			$sPrimarySubcode = implode('-', $primarySubcode);

			$aGroupPrimary[$sPrimarySubcode][] = $p0;
			$primarySubcode = [];
		}

		$counter = $this->getLastCounter();
		foreach ($aGroupPrimary as $primary => $elements) {
			foreach($this->db->query("
				select case when max(a.dtxproductibeanid)= max(b.dtxproductibeanid) then 1 else 0 end cekprod
				from
				datatex_productibeandtl_240706 a
				join datatex_productibean_240706  b 
				on trim(a.itemtypecode) = trim(b.itemtypecode) and 
				trim(a.subcode01) = trim(b.subcode01) and
				trim(a.subcode02) = trim(b.subcode02) and
				trim(a.subcode03) = trim(b.subcode03) and
				trim(a.subcode04) = trim(b.subcode04) and
				trim(a.subcode05) = trim(b.subcode05) and
				trim(a.subcode06) = trim(b.subcode06) and
				trim(a.subcode07) = trim(b.subcode07) and
				trim(a.subcode08) = trim(b.subcode08)
				left join datatex_productibeandtl_status_240706 c on a.dtmitem_id=c.dtmitem_id
				where b.itemtypecode = 'INS' and 
				trim(a.subcode01) = '".trim($elements[0]['subcode01'])."' and
				trim(a.subcode02) = '".trim($elements[0]['subcode02'])."' and
				trim(a.subcode03) = '".trim($elements[0]['subcode03'])."' and
				trim(a.subcode04) = '".trim($elements[0]['subcode04'])."' and
				trim(a.subcode05) = '".trim($elements[0]['subcode05'])."' and
				trim(a.subcode06) = '".trim($elements[0]['subcode06'])."' and
				trim(a.subcode07) = '".trim($elements[0]['subcode07'])."' and
				trim(a.subcode08) = '".trim($elements[0]['subcode08'])."'
				and c.status_subcode = 'confirmed'
				;")->result_array() as $gkw);
		
			if($gkw['cekprod'] == 0){
				$desc = "{$elements[0]['subclassif_name']} {$elements[0]['material_name']} {$elements[0]['content_name']} {$elements[0]['reference_name']} {$elements[0]['construction_name']}";
				$itemids = '';
				$aItemids = [];
				foreach ($elements as $el) {
					$aItemids[] = trim($el['item_id']);
				}
				$itemids = implode(',', $aItemids);
				$arrData = array(
					'companycode' => 'BAG',
					'importautocounter' => $counter,
					'divisioncode' => null,
					'previousdescription' => null,
					'logincompanycode' => null,
					'descriptionchanged' => 0,
					'itemtypecode' => 'INS',
					'subcode01' => trim($elements[0]['subcode01']),
					'subcode02' => trim($elements[0]['subcode02']),
					'subcode03' => trim($elements[0]['subcode03']),
					'subcode04' => trim($elements[0]['subcode04']),
					'subcode05' => trim($elements[0]['subcode05']),
					'subcode06' => trim($elements[0]['subcode06']),
					'subcode07' => trim($elements[0]['subcode07']),
					'subcode08' => trim($elements[0]['subcode08']),
					'subcode09' => null, //secondary subcode
					'subcode10' => null, //secondary subcode
					'longdescription' =>  substr($desc, 0, 200), //check desc
					'shortdescription' => substr($desc, 0, 80),
					'searchdescription' => substr(trim($elements[0]['search_item']), 0, 120),
					'externalcode' => null,
					'baseprimaryunitcode' => $elements[0]['dtmitem_uom_id'], //check uom
					'basecostunitcode' => $elements[0]['dtmitem_uom_id'], //check uom
					'basesecondaryunitcode' => null,
					'secondaryunsteadycvsfactor' => 0,
					'conversionfactortype' => 1,
					'multiplier' => 0,
					'conversionfactorpolicycode' => null,
					'createsellingitem' => 1,
					'createpurchaseorderitem' => 1,
					'createinternalorderitem' => 1,
					'lotcontrolled' => 1,
					'existentlotsloading' => 3,
					'lotcountercode' => 'LOTMNL01',
					'chooselotcode' => 'LOTDEFAULTORDER',
					'checklotcode' => 'DEFAULT',
					'lotexpirationcode' => 'NEVER',
					'containercontrolled' => 0,
					'severalcontainertypeallowed' => 0,
					'containeritemtypecode' => null,
					'containersubcode01' => null,
					'choosecontainercode' => null,
					'elementcontrolled' => 0,
					'elementcountercode' => null, //'ROLL01',
					'chooseelementscode' => null, //'ELEMENTSDEFAULT',
					'checkelementscode' => null, //'DEFAULT',
					'qualitycontrolled' => 2,
					'qualitygroupcode' => '001',
					'projectcontrolled' => 1,
					'statisticalgroupcontrolled' => 0,
					'customercontrolled' => 0,
					'suppliercontrolled' => 0,
					'takeallqadefinitions' => 1,
					'prototype' => 0,
					'bartypecode' => null,
					'barcode' => null,
					'drawingnumber' => null,
					'manufacturercode' => null,
					'compositioncode' => null,
					'intrastatcode' => null,
					'origincountrycode' => null,
					'lifogrpcode' => null,
					'foreusestandardgrouptypecode' => '101',
					'foreusecode' => null,
					'stocktakestandardgrouptypecode' => '104',
					'stocktakecode' => null,
					'replenstandardgrouptypecode' => '102',
					'replencode' => null,
					'familygrpcode' => null,
					'qaitemgroupcode' => null,
					'budgetusergrpusergengrptypecod' => null,
					'budgetusergrpcode' => null,
					'status' => 0,
					'approvaldate' => null,
					'approvaluser' => null,
					'releasedate' => null,
					'releaseuser' => null,
					'validitystatus' => 0,
					'initialdate' => null,
					'finaldate' => null,
					'firstusergrpusergengrptypecod' => null,
					'firstusergrpcode' => null,
					'sndusergrpusergengrptypecode' => null,
					'secondusergrpcode' => null,
					'thirdusergrpusergengrptypecod' => null,
					'thirdusergrpcode' => null,
					'fourthusergrpusergengrptypecod' => null,
					'fourthusergrpcode' => null,
					'fifthusergrpusergengrptypecod' => null,
					'fifthusergrpcode' => null,
					'productionuomtype' => 1,
					'productionunitcode' => $elements[0]['dtmitem_uom_id'],
					'stdproductionbatch' => 1,
					'subcontractorsupplytype' => 0,
					'customersupplytype' => 0,
					'costcategorycode' => 'C000',
					'costlevelcode' => null,
					'wasteproduct' => 1,
					'productiongroupcode' => null,
					'bomsubcode01' => null,
					'bomvirtualreturnsubcode' => null,
					'bomsubcode02' => null,
					'bomsubcode03' => null,
					'bomsubcode04' => null,
					'bomsubcode05' => null,
					'bomsubcode06' => null,
					'bomsubcode07' => null,
					'bomsubcode08' => null,
					'bomsubcode09' => null,
					'bomsubcode10' => null,
					'rtgsubcode01' => null,
					'rtgvirtualreturnsubcode' => null,
					'rtgsubcode02' => null,
					'rtgsubcode03' => null,
					'rtgsubcode04' => null,
					'rtgsubcode05' => null,
					'rtgsubcode06' => null,
					'rtgsubcode07' => null,
					'rtgsubcode08' => null,
					'rtgsubcode09' => null,
					'rtgsubcode10' => null,
					'pickuppercentage' => 0,
					'consumptionfactor' => 0,
					'keepoldprice' => 0,
					'internalprice' => 0,
					'internalpriceuomcode' => null,
					'validfromdate' => null,
					'validtodate' => null,
					'intpricelistcode' => null,
					'intpricecostgroupcode' => null,
					'intpriceplantcode' => null,
					'numberofkeystoinput' => 0,
					'translatedlongdescription' => null,
					'translatedlanguagecode' => null,
					'translatedshortdescription' => null,
					'prodwashsymbol01code' => null,
					'prodwashsymbol02code' => null,
					'prodwashsymbol03code' => null,
					'prodwashsymbol04code' => null,
					'prodwashsymbol05code' => null,
					'prodwashsymbol06code' => null,
					'maxlaylength' => 0,
					'maxnolayers' => 0,
					'widthrangefrom' => 0,
					'widthrangeto' => 0,
					'gsmrangefrom' => 0,
					'gsmrangeto' => 0,
					'shrinkage' => 0,
					'siitemtypecode' => null,
					'sisubcode01' => null,
					'sisubcode02' => null,
					'sisubcode03' => null,
					'sisubcode04' => null,
					'sisubcode05' => null,
					'sisubcode06' => null,
					'sisubcode07' => null,
					'sisubcode08' => null,
					'sisubcode09' => null,
					'sisubcode10' => null,
					'fncstandardordergroupcode' => null,
					'netweight' => 0,
					'grossweight' => 0,
					'realnetweight' => 0,
					'weightuomcode' => null,
					'price' => 0,
					'alloweddivisionsstr' => null,
					'owningcompanycode' => '301',
					'tariffcode' => 'NA',
					'taxtemplatedetailtemplatetype' => 2,
					'taxtemplatedetailcode' => null,
					'gstwithinstatetemplatetype' => 2,
					'gstwithinstatecode' => null,
					'gstinterstatetemplatetype' => 2,
					'gstinterstatecode' => null,
					'shipmentarticlecode' => null,
					'taxtemplateheadertemplatetype' => 1,
					'taxtemplateheadercode' => null,
					'inputcapital' => 0,
					'prodpricecontrol' => 0,
					'comtransitflag' => 0,
					'servicebillflag' => 0,
					'wsoperation' => 1,
					'impoperationuser' => null,
					'importstatus' => 3,
					'impcreationdatetime' => null,
					'impcreationuser' => 'system',
					'implastupdatedatetime' => date('Y-m-d H:i:s'),
					'implastupdateuser' => 'system',
					'importdatetime' => date('Y-m-d H:i:s'),
					'retrynr' => 0,
					'nextretry' => 0,
					'importid' => 0,
					'relateddependentid' => $counter,
					'timetype' => 0,
					'fixedhours' => 0,
					'speed' => 0,
					'speedunitofmeasurecode' => null,
					'dtxproductibeanseq' => 1, // helper column 
					'item_grouping' => trim($elements[0]['search_item']) //helper column
				);
				// $desclong = substr($desc, 0, 200);
				// $descshort = substr($desc, 0, 80);
				// $descsearch =  substr(trim($elements[0]['search_item']), 0, 120);
				// $datess = date('Y-m-d H:i:s');
				// $itemgrouping = trim($elements[0]['search_item']);
				
				// $this->db->query(
				// 		"insert into datatex_productibean_240706_testing (companycode ,
				// 		importautocounter ,
				// 		divisioncode ,
				// 		previousdescription ,
				// 		logincompanycode ,
				// 		descriptionchanged ,
				// 		itemtypecode ,
				// 		subcode01 ,
				// 		subcode02 ,
				// 		subcode03 ,
				// 		subcode04 ,
				// 		subcode05 ,
				// 		subcode06 ,
				// 		subcode07 ,
				// 		subcode08 ,
				// 		subcode09 ,
				// 		subcode10 ,
				// 		longdescription ,
				// 		shortdescription ,
				// 		searchdescription ,
				// 		externalcode ,
				// 		baseprimaryunitcode ,
				// 		basecostunitcode ,
				// 		basesecondaryunitcode ,
				// 		secondaryunsteadycvsfactor ,
				// 		conversionfactortype ,
				// 		multiplier ,
				// 		conversionfactorpolicycode ,
				// 		createsellingitem ,
				// 		createpurchaseorderitem ,
				// 		createinternalorderitem ,
				// 		lotcontrolled ,
				// 		existentlotsloading ,
				// 		lotcountercode ,
				// 		chooselotcode ,
				// 		checklotcode ,
				// 		lotexpirationcode ,
				// 		containercontrolled ,
				// 		severalcontainertypeallowed ,
				// 		containeritemtypecode ,
				// 		containersubcode01 ,
				// 		choosecontainercode ,
				// 		elementcontrolled ,
				// 		elementcountercode ,
				// 		chooseelementscode ,
				// 		checkelementscode ,
				// 		qualitycontrolled ,
				// 		qualitygroupcode ,
				// 		projectcontrolled ,
				// 		statisticalgroupcontrolled ,
				// 		customercontrolled ,
				// 		suppliercontrolled ,
				// 		takeallqadefinitions ,
				// 		prototype ,
				// 		bartypecode ,
				// 		barcode ,
				// 		drawingnumber ,
				// 		manufacturercode ,
				// 		compositioncode ,
				// 		intrastatcode ,
				// 		origincountrycode ,
				// 		lifogrpcode ,
				// 		foreusestandardgrouptypecode ,
				// 		foreusecode ,
				// 		stocktakestandardgrouptypecode ,
				// 		stocktakecode ,
				// 		replenstandardgrouptypecode ,
				// 		replencode ,
				// 		familygrpcode ,
				// 		qaitemgroupcode ,
				// 		budgetusergrpusergengrptypecod ,
				// 		budgetusergrpcode ,
				// 		status ,
				// 		approvaldate ,
				// 		approvaluser ,
				// 		releasedate ,
				// 		releaseuser ,
				// 		validitystatus ,
				// 		initialdate ,
				// 		finaldate ,
				// 		firstusergrpusergengrptypecod ,
				// 		firstusergrpcode ,
				// 		sndusergrpusergengrptypecode ,
				// 		secondusergrpcode ,
				// 		thirdusergrpusergengrptypecod ,
				// 		thirdusergrpcode ,
				// 		fourthusergrpusergengrptypecod ,
				// 		fourthusergrpcode ,
				// 		fifthusergrpusergengrptypecod ,
				// 		fifthusergrpcode ,
				// 		productionuomtype ,
				// 		productionunitcode ,
				// 		stdproductionbatch ,
				// 		subcontractorsupplytype ,
				// 		customersupplytype ,
				// 		costcategorycode ,
				// 		costlevelcode ,
				// 		wasteproduct ,
				// 		productiongroupcode ,
				// 		bomsubcode01 ,
				// 		bomvirtualreturnsubcode ,
				// 		bomsubcode02 ,
				// 		bomsubcode03 ,
				// 		bomsubcode04 ,
				// 		bomsubcode05 ,
				// 		bomsubcode06 ,
				// 		bomsubcode07 ,
				// 		bomsubcode08 ,
				// 		bomsubcode09 ,
				// 		bomsubcode10 ,
				// 		rtgsubcode01 ,
				// 		rtgvirtualreturnsubcode ,
				// 		rtgsubcode02 ,
				// 		rtgsubcode03 ,
				// 		rtgsubcode04 ,
				// 		rtgsubcode05 ,
				// 		rtgsubcode06 ,
				// 		rtgsubcode07 ,
				// 		rtgsubcode08 ,
				// 		rtgsubcode09 ,
				// 		rtgsubcode10 ,
				// 		pickuppercentage ,
				// 		consumptionfactor ,
				// 		keepoldprice ,
				// 		internalprice ,
				// 		internalpriceuomcode ,
				// 		validfromdate ,
				// 		validtodate ,
				// 		intpricelistcode ,
				// 		intpricecostgroupcode ,
				// 		intpriceplantcode ,
				// 		numberofkeystoinput ,
				// 		translatedlongdescription ,
				// 		translatedlanguagecode ,
				// 		translatedshortdescription ,
				// 		prodwashsymbol01code ,
				// 		prodwashsymbol02code ,
				// 		prodwashsymbol03code ,
				// 		prodwashsymbol04code ,
				// 		prodwashsymbol05code ,
				// 		prodwashsymbol06code ,
				// 		maxlaylength ,
				// 		maxnolayers ,
				// 		widthrangefrom ,
				// 		widthrangeto ,
				// 		gsmrangefrom ,
				// 		gsmrangeto ,
				// 		shrinkage ,
				// 		siitemtypecode ,
				// 		sisubcode01 ,
				// 		sisubcode02 ,
				// 		sisubcode03 ,
				// 		sisubcode04 ,
				// 		sisubcode05 ,
				// 		sisubcode06 ,
				// 		sisubcode07 ,
				// 		sisubcode08 ,
				// 		sisubcode09 ,
				// 		sisubcode10 ,
				// 		fncstandardordergroupcode ,
				// 		netweight ,
				// 		grossweight ,
				// 		realnetweight ,
				// 		weightuomcode ,
				// 		price ,
				// 		alloweddivisionsstr ,
				// 		owningcompanycode ,
				// 		tariffcode ,
				// 		taxtemplatedetailtemplatetype ,
				// 		taxtemplatedetailcode ,
				// 		gstwithinstatetemplatetype ,
				// 		gstwithinstatecode ,
				// 		gstinterstatetemplatetype ,
				// 		gstinterstatecode ,
				// 		shipmentarticlecode ,
				// 		taxtemplateheadertemplatetype ,
				// 		taxtemplateheadercode ,
				// 		inputcapital ,
				// 		prodpricecontrol ,
				// 		comtransitflag ,
				// 		servicebillflag ,
				// 		wsoperation ,
				// 		impoperationuser ,
				// 		importstatus ,
				// 		impcreationdatetime ,
				// 		impcreationuser ,
				// 		implastupdatedatetime ,
				// 		implastupdateuser ,
				// 		importdatetime ,
				// 		retrynr ,
				// 		nextretry ,
				// 		importid ,
				// 		relateddependentid ,
				// 		timetype ,
				// 		fixedhours ,
				// 		speed ,
				// 		speedunitofmeasurecode ,
				// 		dtxproductibeanseq ,
				// 		item_grouping 
				// 		) values (
				// 			 	'BAG',
				// 				$counter,
				// 				null,
				// 				null,
				// 				null,
				// 				0,
				// 				'INS',
				// 				'".trim($elements[0]['subcode01'])."',
				// 				'".trim($elements[0]['subcode02'])."',
				// 				'".trim($elements[0]['subcode03'])."',
				// 				'".trim($elements[0]['subcode04'])."',
				// 				'".trim($elements[0]['subcode05'])."',
				// 				'".trim($elements[0]['subcode06'])."',
				// 				'".trim($elements[0]['subcode07'])."',
				// 				'".trim($elements[0]['subcode08'])."',
				// 				null,
				// 				null,
				// 				'".$desclong."',
				// 				'".$descshort."',
				// 				'".$descsearch."',
				// 				null,
				// 				'".$elements[0]['dtmitem_uom_id']."', 
				// 				'".$elements[0]['dtmitem_uom_id']."', 
				// 				null,
				// 				0,
				// 				1,
				// 				0,
				// 				null,
				// 				1,
				// 				1,
				// 				1,
				// 				1,
				// 				3,
				// 				'LOTMNL01',
				// 				'LOTDEFAULTORDER',
				// 				'DEFAULT',
				// 				'NEVER',
				// 				0,
				// 				0,
				// 				null,
				// 				null,
				// 				null,
				// 				0,
				// 				null, 
				// 				null, 
				// 				null, 
				// 				2,
				// 				'001',
				// 				1,
				// 				0,
				// 				0,
				// 				0,
				// 				1,
				// 				0,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				'101',
				// 				null,
				// 				'104',
				// 				null,
				// 				'102',
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				0,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				0,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				1,
				// 				'".$elements[0]['dtmitem_uom_id']."',
				// 				1,
				// 				0,
				// 				0,
				// 				'C000',
				// 				null,
				// 				1,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				0,
				// 				0,
				// 				0,
				// 				0,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				0,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				0,
				// 				0,
				// 				0,
				// 				0,
				// 				0,
				// 				0,
				// 				0,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				null,
				// 				0,
				// 				0,
				// 				0,
				// 				null,
				// 				0,
				// 				null,
				// 				'301',
				// 				'NA',
				// 				2,
				// 				null,
				// 				2,
				// 				null,
				// 				2,
				// 				null,
				// 				null,
				// 				1,
				// 				null,
				// 				0,
				// 				0,
				// 				0,
				// 				0,
				// 				1,
				// 				null,
				// 				3,
				// 				null,
				// 				'system',
				// 				'".$datess."',
				// 				'system',
				// 				'".$datess."',
				// 				0,
				// 				0,
				// 				0,
				// 				$counter,
				// 				0,
				// 				0,
				// 				0,
				// 				null,
				// 				1, 
				// 				'".$itemgrouping."'
				// 			) 
				// 			ON CONFLICT (dtxproductibeanid) DO UPDATE 
				// 			SET subcode01= '".trim($elements[0]['subcode01'])."',
				// 					subcode02= '".trim($elements[0]['subcode02'])."',
				// 					subcode03= '".trim($elements[0]['subcode03'])."',
				// 					subcode04= '".trim($elements[0]['subcode04'])."',
				// 					subcode05= '".trim($elements[0]['subcode05'])."',
				// 					subcode06= '".trim($elements[0]['subcode06'])."',
				// 					subcode07= '".trim($elements[0]['subcode07'])."',
				// 					subcode08= '".trim($elements[0]['subcode08'])."'"
				// );

				$counter++;
				$this->db->insert('datatex_productibean_240706', $arrData);
			
			} 
		}
		

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$resp['code'] = 400;
			$resp['messages'] = 'Error';
		} else {
			$this->db->trans_commit();
			$resp['code'] = 200;
			$resp['messages'] = 'Success';
		}
		var_dump("DONE");
		return $resp;
	}

	public function generateCHE()
	{
		$this->db->trans_begin();

		$prodibeandtls = $this->db->query("
			select a.*,b.name as material_name,
			b.content_name,
			b.material_name,
			b.reference_name ,
			b.construction_name,
			bb.name as subclassif_name,
			e.dtmitem_uom_id			
			from (select itemtypecode,max(item_id) item_id,string_agg(item_id,',') search_item,
				  subcode01,subcode02,subcode03,subcode04,subcode05,sks
					from (
							SELECT itemtypecode,
							subcode01,subcode02,subcode03,subcode04,subcode05,
							item_id,
							concat(itemtypecode,'-',trim(subcode01),'-',trim(subcode02),'-',trim(subcode03),'-',trim(subcode04),'-',trim(subcode05)) sks
							FROM datatex_productibeandtl_240706 a
							left join datatex_productibeandtl_status_240706 f on a.dtmitem_id=f.dtmitem_id
							where itemtypecode = 'CHE' and status_subcode = 'confirmed') af 
					GROUP BY itemtypecode,
					subcode01,subcode02,subcode03,subcode04,subcode05,sks
					ORDER BY sks) a 
			left join datatex_m_item e on a.item_id=e.item_id
			left join m_item b on b.item_id = a.item_id 
			left join m_subclassification bb on bb.subclassif_id  = b.subclassif_id ")
			->result_array();

		$aGroupPrimary = [];
		foreach ($prodibeandtls as $p0) {
			$primarySubcode[] = $p0['subcode01'];
			$primarySubcode[] = $p0['subcode02'];
			$primarySubcode[] = $p0['subcode03'];
			$primarySubcode[] = $p0['subcode04'];
			$primarySubcode[] = $p0['subcode05'];
		    //$primarySubcode[] = $p0['subcode06'];
			// $primarySubcode[] = $p0['subcode07'];
			// $primarySubcode[] = $p0['subcode08'];
			// $primarySubcode[] = $p0['subcode09'];
			$sPrimarySubcode = implode('-', $primarySubcode);

			$aGroupPrimary[$sPrimarySubcode][] = $p0;
			$primarySubcode = [];
		}

		$counter = $this->getLastCounter();
		foreach ($aGroupPrimary as $primary => $elements) {
			foreach($this->db->query("
			select case when max(a.dtxproductibeanid)= max(b.dtxproductibeanid) then 1 else 0 end cekprod
            from
			datatex_productibeandtl_240706 a
			join datatex_productibean_240706  b 
			on trim(a.itemtypecode) = trim(b.itemtypecode) and 
			trim(a.subcode01) = trim(b.subcode01) and
			trim(a.subcode02) = trim(b.subcode02) and
			trim(a.subcode03) = trim(b.subcode03) and
			trim(a.subcode04) = trim(b.subcode04) and
			trim(a.subcode05) = trim(b.subcode05) 
			left join datatex_productibeandtl_status_240706 c on a.dtmitem_id=c.dtmitem_id
			where b.itemtypecode = 'CHE' and 
			trim(a.subcode01) = '".trim($elements[0]['subcode01'])."' and
			trim(a.subcode02) = '".trim($elements[0]['subcode02'])."' and
			trim(a.subcode03) = '".trim($elements[0]['subcode03'])."' and
			trim(a.subcode04) = '".trim($elements[0]['subcode04'])."' and
			trim(a.subcode05) = '".trim($elements[0]['subcode05'])."' and
			c.status_subcode = 'confirmed'
			;")->result_array() as $gkw);
			$cno = 1;
			if($gkw['cekprod'] == 0){
				$desc = "{$elements[0]['subclassif_name']} {$elements[0]['material_name']} {$elements[0]['content_name']} {$elements[0]['reference_name']} {$elements[0]['construction_name']}";
				$itemids = '';
				$aItemids = [];
				foreach ($elements as $el) {
					$aItemids[] = trim($el['item_id']);
				}
				$itemids = implode(',', $aItemids);
				$arrData = array(
					'companycode' => 'BAG',
					'importautocounter' => $counter,
					'divisioncode' => null,
					'previousdescription' => null,
					'logincompanycode' => null,
					'descriptionchanged' => 0,
					'itemtypecode' => 'CHE',
					'subcode01' => trim($elements[0]['subcode01']),
					'subcode02' => trim($elements[0]['subcode02']),
					'subcode03' => trim($elements[0]['subcode03']),
					'subcode04' => trim($elements[0]['subcode04']),
					'subcode05' => trim($elements[0]['subcode05']),
					'subcode06' => null, //trim($elements[0]['subcode06']),
					'subcode07' => null, //trim($elements[0]['subcode07']),
					'subcode08' => null, //trim($elements[0]['subcode08']),
					'subcode09' => null, //secondary subcode
					'subcode10' => null, //secondary subcode
					'longdescription' =>  substr($desc, 0, 200), //check desc
					'shortdescription' => substr($desc, 0, 80),
					'searchdescription' => substr(trim($elements[0]['search_item']), 0, 120),
					'externalcode' => null,
					'baseprimaryunitcode' => $elements[0]['dtmitem_uom_id'], //check uom
					'basecostunitcode' => $elements[0]['dtmitem_uom_id'], //check uom
					'basesecondaryunitcode' => null,
					'secondaryunsteadycvsfactor' => 0,
					'conversionfactortype' => 1,
					'multiplier' => 0,
					'conversionfactorpolicycode' => null,
					'createsellingitem' => 1,
					'createpurchaseorderitem' => 1,
					'createinternalorderitem' => 1,
					'lotcontrolled' => 1,
					'existentlotsloading' => 3,
					'lotcountercode' => 'LOTMNL01',
					'chooselotcode' => 'LOTDEFAULTORDER',
					'checklotcode' => 'DEFAULT',
					'lotexpirationcode' => 'NEVER',
					'containercontrolled' => 0,
					'severalcontainertypeallowed' => 0,
					'containeritemtypecode' => null,
					'containersubcode01' => null,
					'choosecontainercode' => null,
					'elementcontrolled' => 0,
					'elementcountercode' => null, //'ROLL01',
					'chooseelementscode' => null, //'ELEMENTSDEFAULT',
					'checkelementscode' => null, //'DEFAULT',
					'qualitycontrolled' => 2,
					'qualitygroupcode' => '001',
					'projectcontrolled' => 1,
					'statisticalgroupcontrolled' => 0,
					'customercontrolled' => 0,
					'suppliercontrolled' => 0,
					'takeallqadefinitions' => 1,
					'prototype' => 0,
					'bartypecode' => null,
					'barcode' => null,
					'drawingnumber' => null,
					'manufacturercode' => null,
					'compositioncode' => null,
					'intrastatcode' => null,
					'origincountrycode' => null,
					'lifogrpcode' => null,
					'foreusestandardgrouptypecode' => '101',
					'foreusecode' => null,
					'stocktakestandardgrouptypecode' => '104',
					'stocktakecode' => null,
					'replenstandardgrouptypecode' => '102',
					'replencode' => null,
					'familygrpcode' => null,
					'qaitemgroupcode' => null,
					'budgetusergrpusergengrptypecod' => null,
					'budgetusergrpcode' => null,
					'status' => 0,
					'approvaldate' => null,
					'approvaluser' => null,
					'releasedate' => null,
					'releaseuser' => null,
					'validitystatus' => 0,
					'initialdate' => null,
					'finaldate' => null,
					'firstusergrpusergengrptypecod' => null,
					'firstusergrpcode' => null,
					'sndusergrpusergengrptypecode' => null,
					'secondusergrpcode' => null,
					'thirdusergrpusergengrptypecod' => null,
					'thirdusergrpcode' => null,
					'fourthusergrpusergengrptypecod' => null,
					'fourthusergrpcode' => null,
					'fifthusergrpusergengrptypecod' => null,
					'fifthusergrpcode' => null,
					'productionuomtype' => 1,
					'productionunitcode' => $elements[0]['dtmitem_uom_id'],
					'stdproductionbatch' => 1,
					'subcontractorsupplytype' => 0,
					'customersupplytype' => 0,
					'costcategorycode' => 'C001',
					'costlevelcode' => null,
					'wasteproduct' => 1,
					'productiongroupcode' => null,
					'bomsubcode01' => null,
					'bomvirtualreturnsubcode' => null,
					'bomsubcode02' => null,
					'bomsubcode03' => null,
					'bomsubcode04' => null,
					'bomsubcode05' => null,
					'bomsubcode06' => null,
					'bomsubcode07' => null,
					'bomsubcode08' => null,
					'bomsubcode09' => null,
					'bomsubcode10' => null,
					'rtgsubcode01' => null,
					'rtgvirtualreturnsubcode' => null,
					'rtgsubcode02' => null,
					'rtgsubcode03' => null,
					'rtgsubcode04' => null,
					'rtgsubcode05' => null,
					'rtgsubcode06' => null,
					'rtgsubcode07' => null,
					'rtgsubcode08' => null,
					'rtgsubcode09' => null,
					'rtgsubcode10' => null,
					'pickuppercentage' => 0,
					'consumptionfactor' => 0,
					'keepoldprice' => 0,
					'internalprice' => 0,
					'internalpriceuomcode' => null,
					'validfromdate' => null,
					'validtodate' => null,
					'intpricelistcode' => null,
					'intpricecostgroupcode' => null,
					'intpriceplantcode' => null,
					'numberofkeystoinput' => 0,
					'translatedlongdescription' => null,
					'translatedlanguagecode' => null,
					'translatedshortdescription' => null,
					'prodwashsymbol01code' => null,
					'prodwashsymbol02code' => null,
					'prodwashsymbol03code' => null,
					'prodwashsymbol04code' => null,
					'prodwashsymbol05code' => null,
					'prodwashsymbol06code' => null,
					'maxlaylength' => 0,
					'maxnolayers' => 0,
					'widthrangefrom' => 0,
					'widthrangeto' => 0,
					'gsmrangefrom' => 0,
					'gsmrangeto' => 0,
					'shrinkage' => 0,
					'siitemtypecode' => null,
					'sisubcode01' => null,
					'sisubcode02' => null,
					'sisubcode03' => null,
					'sisubcode04' => null,
					'sisubcode05' => null,
					'sisubcode06' => null,
					'sisubcode07' => null,
					'sisubcode08' => null,
					'sisubcode09' => null,
					'sisubcode10' => null,
					'fncstandardordergroupcode' => null,
					'netweight' => 0,
					'grossweight' => 0,
					'realnetweight' => 0,
					'weightuomcode' => null,
					'price' => 0,
					'alloweddivisionsstr' => null,
					'owningcompanycode' => '301',
					'tariffcode' => 'NA',
					'taxtemplatedetailtemplatetype' => 2,
					'taxtemplatedetailcode' => null,
					'gstwithinstatetemplatetype' => 2,
					'gstwithinstatecode' => null,
					'gstinterstatetemplatetype' => 2,
					'gstinterstatecode' => null,
					'shipmentarticlecode' => null,
					'taxtemplateheadertemplatetype' => 1,
					'taxtemplateheadercode' => null,
					'inputcapital' => 0,
					'prodpricecontrol' => 0,
					'comtransitflag' => 0,
					'servicebillflag' => 0,
					'wsoperation' => 1,
					'impoperationuser' => null,
					'importstatus' => 3,
					'impcreationdatetime' => null,
					'impcreationuser' => 'system',
					'implastupdatedatetime' => date('Y-m-d H:i:s'),
					'implastupdateuser' => 'system',
					'importdatetime' => date('Y-m-d H:i:s'),
					'retrynr' => 0,
					'nextretry' => 0,
					'importid' => 0,
					'relateddependentid' => $counter,
					'timetype' => 0,
					'fixedhours' => 0,
					'speed' => 0,
					'speedunitofmeasurecode' => null,
					'dtxproductibeanseq' => 1, // helper column 
					'item_grouping' => trim($elements[0]['search_item']) //helper column
				);
				$counter++;

				$this->db->insert('datatex_productibean_240706', $arrData);
			}
		}

		

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$resp['code'] = 400;
			$resp['messages'] = 'Error';
		} else {
			$this->db->trans_commit();
			$resp['code'] = 200;
			$resp['messages'] = 'Success';
		}
		var_dump("DONE");
		return $resp;
	}

	// ======================== Generate per itemId ========================
	public function generateByItemId($itemids = [])
	{
		$itemids = [];
		if (empty($itemids)) {
			log_message('error', "ProductIBeanService->generateByItemId itemids null");
			var_dump("itemids null");
			exit();
		}

		$this->load->model('Services/ProductIBeanDetailService');
		$this->ProductIBeanDetailService->generateProductIbeanDetailV2($itemids);

	}
}

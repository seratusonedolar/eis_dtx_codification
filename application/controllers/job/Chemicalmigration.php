
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chemicalmigration extends CI_Controller
{
	public function run($startCounter)
	{
		$this->processdataByTemplate($startCounter);
	}

	private function templatetrmQA()
	{
		return [
			'COMPANYCODE'	=>	'BAG',
			'IMPORTAUTOCOUNTER'	=>	3010001,
			'DIVISIONCODE'	=>	null,
			'PREVIOUSDESCRIPTION'	=>	null,
			'LOGINCOMPANYCODE'	=>	null,
			'DESCRIPTIONCHANGED'	=>	0,
			'ITEMTYPECODE'	=>	'CHE',
			'SUBCODE01'	=>	null,
			'SUBCODE02'	=>	null,
			'SUBCODE03'	=>	null,
			'SUBCODE04'	=>	null,
			'SUBCODE05'	=>	null,
			'SUBCODE06'	=>	null,
			'SUBCODE07'	=>	null,
			'SUBCODE08'	=>	null,
			'SUBCODE09'	=>	null,
			'SUBCODE10'	=>	null,
			'LONGDESCRIPTION'	=>	null,
			'SHORTDESCRIPTION'	=>	null,
			'SEARCHDESCRIPTION'	=>	null,
			'EXTERNALCODE'	=>	null,
			'BASEPRIMARYUNITCODE'	=>	'yd',
			'BASECOSTUNITCODE'	=>	'yd',
			'BASESECONDARYUNITCODE'	=>	null,
			'SECONDARYUNSTEADYCVSFACTOR'	=>	0,
			'CONVERSIONFACTORTYPE'	=>	1,
			'MULTIPLIER'	=>	0,
			'CONVERSIONFACTORPOLICYCODE'	=>	null,
			'CREATESELLINGITEM'	=>	1,
			'CREATEPURCHASEORDERITEM'	=>	1,
			'CREATEINTERNALORDERITEM'	=>	1,
			'LOTCONTROLLED'	=>	1,
			'EXISTENTLOTSLOADING'	=>	3,
			'LOTCOUNTERCODE'	=>	'LOTMNL01',
			'CHOOSELOTCODE'	=>	'LOTDEFAULTORDER',
			'CHECKLOTCODE'	=>	'DEFAULT',
			'LOTEXPIRATIONCODE'	=>	'NEVER',
			'CONTAINERCONTROLLED'	=>	0,
			'SEVERALCONTAINERTYPEALLOWED'	=>	0,
			'CONTAINERITEMTYPECODE'	=>	null,
			'CONTAINERSUBCODE01'	=>	null,
			'CHOOSECONTAINERCODE'	=>	null,
			'ELEMENTCONTROLLED'	=>	1,
			'ELEMENTCOUNTERCODE'	=>	null,
			'CHOOSEELEMENTSCODE'	=>	null,
			'CHECKELEMENTSCODE'	=>	null,
			'QUALITYCONTROLLED'	=>	2,
			'QUALITYGROUPCODE'	=>	1,
			'PROJECTCONTROLLED'	=>	1,
			'STATISTICALGROUPCONTROLLED'	=>	0,
			'CUSTOMERCONTROLLED'	=>	0,
			'SUPPLIERCONTROLLED'	=>	0,
			'TAKEALLQADEFINITIONS'	=>	1,
			'PROTOTYPE'	=>	0,
			'BARTYPECODE'	=>	null,
			'BARCODE'	=>	null,
			'DRAWINGNUMBER'	=>	null,
			'MANUFACTURERCODE'	=>	null,
			'COMPOSITIONCODE'	=>	null,
			'INTRASTATCODE'	=>	null,
			'ORIGINCOUNTRYCODE'	=>	null,
			'LIFOGRPCODE'	=>	null,
			'FOREUSESTANDARDGROUPTYPECODE'	=>	'101',
			'FOREUSECODE'	=>	null,
			'STOCKTAKESTANDARDGROUPTYPECODE'	=>	'104',
			'STOCKTAKECODE'	=>	null,
			'REPLENSTANDARDGROUPTYPECODE'	=>	'102',
			'REPLENCODE'	=>	null,
			'FAMILYGRPCODE'	=>	null,
			'QAITEMGROUPCODE'	=>	null,
			'BUDGETUSERGRPUSERGENGRPTYPECOD'	=>	null,
			'BUDGETUSERGRPCODE'	=>	null,
			'STATUS'	=>	0,
			'APPROVALDATE'	=>	null,
			'APPROVALUSER'	=>	null,
			'RELEASEDATE'	=>	null,
			'RELEASEUSER'	=>	null,
			'VALIDITYSTATUS'	=>	0,
			'INITIALDATE'	=>	null,
			'FINALDATE'	=>	null,
			'FIRSTUSERGRPUSERGENGRPTYPECOD'	=>	null,
			'FIRSTUSERGRPCODE'	=>	null,
			'SNDUSERGRPUSERGENGRPTYPECODE'	=>	null,
			'SECONDUSERGRPCODE'	=>	null,
			'THIRDUSERGRPUSERGENGRPTYPECOD'	=>	null,
			'THIRDUSERGRPCODE'	=>	null,
			'FOURTHUSERGRPUSERGENGRPTYPECOD'	=>	null,
			'FOURTHUSERGRPCODE'	=>	null,
			'FIFTHUSERGRPUSERGENGRPTYPECOD'	=>	null,
			'FIFTHUSERGRPCODE'	=>	null,
			'PRODUCTIONUOMTYPE'	=>	1,
			'PRODUCTIONUNITCODE'	=>	'yd',
			'STDPRODUCTIONBATCH'	=>	1,
			'SUBCONTRACTORSUPPLYTYPE'	=>	0,
			'CUSTOMERSUPPLYTYPE'	=>	0,
			'COSTCATEGORYCODE'	=>	'C000',
			'COSTLEVELCODE'	=>	null,
			'WASTEPRODUCT'	=>	1,
			'PRODUCTIONGROUPCODE'	=>	null,
			'BOMSUBCODE01'	=>	null,
			'BOMVIRTUALRETURNSUBCODE'	=>	null,
			'BOMSUBCODE02'	=>	null,
			'BOMSUBCODE03'	=>	null,
			'BOMSUBCODE04'	=>	null,
			'BOMSUBCODE05'	=>	null,
			'BOMSUBCODE06'	=>	null,
			'BOMSUBCODE07'	=>	null,
			'BOMSUBCODE08'	=>	null,
			'BOMSUBCODE09'	=>	null,
			'BOMSUBCODE10'	=>	null,
			'RTGSUBCODE01'	=>	null,
			'RTGVIRTUALRETURNSUBCODE'	=>	null,
			'RTGSUBCODE02'	=>	null,
			'RTGSUBCODE03'	=>	null,
			'RTGSUBCODE04'	=>	null,
			'RTGSUBCODE05'	=>	null,
			'RTGSUBCODE06'	=>	null,
			'RTGSUBCODE07'	=>	null,
			'RTGSUBCODE08'	=>	null,
			'RTGSUBCODE09'	=>	null,
			'RTGSUBCODE10'	=>	null,
			'PICKUPPERCENTAGE'	=>	0,
			'CONSUMPTIONFACTOR'	=>	0,
			'KEEPOLDPRICE'	=>	0,
			'INTERNALPRICE'	=>	0,
			'INTERNALPRICEUOMCODE'	=>	null,
			'VALIDFROMDATE'	=>	null,
			'VALIDTODATE'	=>	null,
			'INTPRICELISTCODE'	=>	null,
			'INTPRICECOSTGROUPCODE'	=>	null,
			'INTPRICEPLANTCODE'	=>	null,
			'NUMBEROFKEYSTOINPUT'	=>	0,
			'TRANSLATEDLONGDESCRIPTION'	=>	null,
			'TRANSLATEDLANGUAGECODE'	=>	null,
			'TRANSLATEDSHORTDESCRIPTION'	=>	null,
			'PRODWASHSYMBOL01CODE'	=>	null,
			'PRODWASHSYMBOL02CODE'	=>	null,
			'PRODWASHSYMBOL03CODE'	=>	null,
			'PRODWASHSYMBOL04CODE'	=>	null,
			'PRODWASHSYMBOL05CODE'	=>	null,
			'PRODWASHSYMBOL06CODE'	=>	null,
			'MAXLAYLENGTH'	=>	0,
			'MAXNOLAYERS'	=>	0,
			'WIDTHRANGEFROM'	=>	0,
			'WIDTHRANGETO'	=>	0,
			'GSMRANGEFROM'	=>	0,
			'GSMRANGETO'	=>	0,
			'SHRINKAGE'	=>	0,
			'SIITEMTYPECODE'	=>	null,
			'SISUBCODE01'	=>	null,
			'SISUBCODE02'	=>	null,
			'SISUBCODE03'	=>	null,
			'SISUBCODE04'	=>	null,
			'SISUBCODE05'	=>	null,
			'SISUBCODE06'	=>	null,
			'SISUBCODE07'	=>	null,
			'SISUBCODE08'	=>	null,
			'SISUBCODE09'	=>	null,
			'SISUBCODE10'	=>	null,
			'FNCSTANDARDORDERGROUPCODE'	=>	null,
			'NETWEIGHT'	=>	0,
			'GROSSWEIGHT'	=>	0,
			'REALNETWEIGHT'	=>	0,
			'WEIGHTUOMCODE'	=>	null,
			'PRICE'	=>	0,
			'ALLOWEDDIVISIONSSTR'	=>	null,
			'OWNINGCOMPANYCODE'	=>	'301',
			'TARIFFCODE'	=>	'NA',
			'TAXTEMPLATEDETAILTEMPLATETYPE'	=>	2,
			'TAXTEMPLATEDETAILCODE'	=>	null,
			'GSTWITHINSTATETEMPLATETYPE'	=>	2,
			'GSTWITHINSTATECODE'	=>	null,
			'GSTINTERSTATETEMPLATETYPE'	=>	2,
			'GSTINTERSTATECODE'	=>	null,
			'SHIPMENTARTICLECODE'	=>	null,
			'TAXTEMPLATEHEADERTEMPLATETYPE'	=>	1,
			'TAXTEMPLATEHEADERCODE'	=>	null,
			'INPUTCAPITAL'	=>	0,
			'PRODPRICECONTROL'	=>	0,
			'COMTRANSITFLAG'	=>	0,
			'SERVICEBILLFLAG'	=>	0,
			'WSOPERATION'	=>	1,
			'IMPOPERATIONUSER'	=>	null,
			'IMPORTSTATUS'	=>	0,
			'IMPCREATIONDATETIME'	=>	null,
			'IMPCREATIONUSER'	=>	'system',
			'IMPLASTUPDATEDATETIME'	=>	null,
			'IMPLASTUPDATEUSER'	=>	'system',
			'IMPORTDATETIME'	=>	null,
			'RETRYNR'	=>	0,
			'NEXTRETRY'	=>	0,
			'IMPORTID'	=>	0,
			'RELATEDDEPENDENTID'	=>	3010001,
			'TIMETYPE'	=>	0,
			'FIXEDHOURS'	=>	0,
			'SPEED'	=>	0,
			'SPEEDUNITOFMEASURECODE'	=>	null,
		];
		[
			// 	'COMPANYCODE' => 'BAG',
			// 	'IMPORTAUTOCOUNTER' => NULL,
			// 	'DIVISIONCODE',
			// 	'PREVIOUSDESCRIPTION',
			// 	'LOGINCOMPANYCODE',
			// 	'DESCRIPTIONCHANGED',
			'ITEMTYPECODE',
			'SUBCODE01',
			'SUBCODE02',
			'SUBCODE03',
			'SUBCODE04',
			'SUBCODE05',
			'SUBCODE06',
			'SUBCODE07',
			'SUBCODE08',
			'SUBCODE09',
			'SUBCODE10',
			// 'LONGDESCRIPTION',
			// 'SHORTDESCRIPTION',
			// 'SEARCHDESCRIPTION',
			// 'EXTERNALCODE',
			// 'BASEPRIMARYUNITCODE',
			// 'BASECOSTUNITCODE',
			// 'BASESECONDARYUNITCODE',
			// 'SECONDARYUNSTEADYCVSFACTOR',
			// 'CONVERSIONFACTORTYPE',
			// 'MULTIPLIER',
			// 'CONVERSIONFACTORPOLICYCODE',
			// 'CREATESELLINGITEM',
			// 'CREATEPURCHASEORDERITEM',
			// 'CREATEINTERNALORDERITEM',
			// 'LOTCONTROLLED',
			// 'EXISTENTLOTSLOADING',
			// 'LOTCOUNTERCODE',
			// 'CHOOSELOTCODE',
			// 'CHECKLOTCODE',
			// 'LOTEXPIRATIONCODE',
			// 'CONTAINERCONTROLLED',
			// 'SEVERALCONTAINERTYPEALLOWED',
			// 'CONTAINERITEMTYPECODE',
			// 'CONTAINERSUBCODE01',
			// 'CHOOSECONTAINERCODE',
			// 'ELEMENTCONTROLLED',
			// 'ELEMENTCOUNTERCODE',
			// 'CHOOSEELEMENTSCODE',
			// 'CHECKELEMENTSCODE',
			// 'QUALITYCONTROLLED',
			// 'QUALITYGROUPCODE',
			// 'PROJECTCONTROLLED',
			// 'STATISTICALGROUPCONTROLLED',
			// 'CUSTOMERCONTROLLED',
			// 'SUPPLIERCONTROLLED',
			// 'TAKEALLQADEFINITIONS',
			// 'PROTOTYPE',
			// 'BARTYPECODE',
			// 'BARCODE',
			// 'DRAWINGNUMBER',
			// 'MANUFACTURERCODE',
			// 'COMPOSITIONCODE',
			// 'INTRASTATCODE',
			// 'ORIGINCOUNTRYCODE',
			// 'LIFOGRPCODE',
			// 'FOREUSESTANDARDGROUPTYPECODE',
			// 'FOREUSECODE',
			// 'STOCKTAKESTANDARDGROUPTYPECODE',
			// 'STOCKTAKECODE',
			// 'REPLENSTANDARDGROUPTYPECODE',
			// 'REPLENCODE',
			// 'FAMILYGRPCODE',
			// 'QAITEMGROUPCODE',
			// 'BUDGETUSERGRPUSERGENGRPTYPECOD',
			// 'BUDGETUSERGRPCODE',
			// 'STATUS',
			// 'APPROVALDATE',
			// 'APPROVALUSER',
			// 'RELEASEDATE',
			// 'RELEASEUSER',
			// 'VALIDITYSTATUS',
			// 'INITIALDATE',
			// 'FINALDATE',
			// 'FIRSTUSERGRPUSERGENGRPTYPECOD',
			// 'FIRSTUSERGRPCODE',
			// 'SNDUSERGRPUSERGENGRPTYPECODE',
			// 'SECONDUSERGRPCODE',
			// 'THIRDUSERGRPUSERGENGRPTYPECOD',
			// 'THIRDUSERGRPCODE',
			// 'FOURTHUSERGRPUSERGENGRPTYPECOD',
			// 'FOURTHUSERGRPCODE',
			// 'FIFTHUSERGRPUSERGENGRPTYPECOD',
			// 'FIFTHUSERGRPCODE',
			// 'PRODUCTIONUOMTYPE',
			// 'PRODUCTIONUNITCODE',
			// 'STDPRODUCTIONBATCH',
			// 'SUBCONTRACTORSUPPLYTYPE',
			// 'CUSTOMERSUPPLYTYPE',
			// 'COSTCATEGORYCODE',
			// 'COSTLEVELCODE',
			// 'WASTEPRODUCT',
			// 'PRODUCTIONGROUPCODE',
			// 'BOMSUBCODE01',
			// 'BOMVIRTUALRETURNSUBCODE',
			// 'BOMSUBCODE02',
			// 'BOMSUBCODE03',
			// 'BOMSUBCODE04',
			// 'BOMSUBCODE05',
			// 'BOMSUBCODE06',
			// 'BOMSUBCODE07',
			// 'BOMSUBCODE08',
			// 'BOMSUBCODE09',
			// 'BOMSUBCODE10',
			// 'RTGSUBCODE01',
			// 'RTGVIRTUALRETURNSUBCODE',
			// 'RTGSUBCODE02',
			// 'RTGSUBCODE03',
			// 'RTGSUBCODE04',
			// 'RTGSUBCODE05',
			// 'RTGSUBCODE06',
			// 'RTGSUBCODE07',
			// 'RTGSUBCODE08',
			// 'RTGSUBCODE09',
			// 'RTGSUBCODE10',
			// 'PICKUPPERCENTAGE',
			// 'CONSUMPTIONFACTOR',
			// 'KEEPOLDPRICE',
			// 'INTERNALPRICE',
			// 'INTERNALPRICEUOMCODE',
			// 'VALIDFROMDATE',
			// 'VALIDTODATE',
			// 'INTPRICELISTCODE',
			// 'INTPRICECOSTGROUPCODE',
			// 'INTPRICEPLANTCODE',
			// 'NUMBEROFKEYSTOINPUT',
			// 'TRANSLATEDLONGDESCRIPTION',
			// 'TRANSLATEDLANGUAGECODE',
			// 'TRANSLATEDSHORTDESCRIPTION',
			// 'PRODWASHSYMBOL01CODE',
			// 'PRODWASHSYMBOL02CODE',
			// 'PRODWASHSYMBOL03CODE',
			// 'PRODWASHSYMBOL04CODE',
			// 'PRODWASHSYMBOL05CODE',
			// 'PRODWASHSYMBOL06CODE',
			// 'MAXLAYLENGTH',
			// 'MAXNOLAYERS',
			// 'WIDTHRANGEFROM',
			// 'WIDTHRANGETO',
			// 'GSMRANGEFROM',
			// 'GSMRANGETO',
			// 'SHRINKAGE',
			// 'SIITEMTYPECODE',
			// 'SISUBCODE01',
			// 'SISUBCODE02',
			// 'SISUBCODE03',
			// 'SISUBCODE04',
			// 'SISUBCODE05',
			// 'SISUBCODE06',
			// 'SISUBCODE07',
			// 'SISUBCODE08',
			// 'SISUBCODE09',
			// 'SISUBCODE10',
			// 'FNCSTANDARDORDERGROUPCODE',
			// 'NETWEIGHT',
			// 'GROSSWEIGHT',
			// 'REALNETWEIGHT',
			// 'WEIGHTUOMCODE',
			// 'PRICE',
			// 'ALLOWEDDIVISIONSSTR',
			// 'OWNINGCOMPANYCODE',
			// 'TARIFFCODE',
			// 'TAXTEMPLATEDETAILTEMPLATETYPE',
			// 'TAXTEMPLATEDETAILCODE',
			// 'GSTWITHINSTATETEMPLATETYPE',
			// 'GSTWITHINSTATECODE',
			// 'GSTINTERSTATETEMPLATETYPE',
			// 'GSTINTERSTATECODE',
			// 'SHIPMENTARTICLECODE',
			// 'TAXTEMPLATEHEADERTEMPLATETYPE',
			// 'TAXTEMPLATEHEADERCODE',
			// 'INPUTCAPITAL',
			// 'PRODPRICECONTROL',
			// 'COMTRANSITFLAG',
			// 'SERVICEBILLFLAG',
			// 'WSOPERATION',
			// 'IMPOPERATIONUSER',
			// 'IMPORTSTATUS',
			// 'IMPCREATIONDATETIME',
			// 'IMPCREATIONUSER',
			// 'IMPLASTUPDATEDATETIME',
			// 'IMPLASTUPDATEUSER',
			// 'IMPORTDATETIME',
			// 'RETRYNR',
			// 'NEXTRETRY',
			// 'IMPORTID',
			// 'RELATEDDEPENDENTID',
			// 'TIMETYPE',
			// 'FIXEDHOURS',
			// 'SPEED',
			// 'SPEEDUNITOFMEASURECODE'
		];
	}

	private function collectdatatrim()
	{
		// $q = $this->db->query("
		// 	SELECT * FROM datatex_m_item dmi
		// 	LEFT JOIN datatex_m_item_detail dmid ON dmid.dtmitem_id = dmi.dtmitem_id
		// 	LEFT JOIN datatex_m_subcode dms on dms.dtmsubcode_id = dmi.dtmsubcode_id 
		// 	LEFT JOIN datatex_m_subcode_detail dmsd on dmsd.dtmsubcodedtl_id = dmid.dtmsubcodedtl_id 
		// 	WHERE dmi.dtmsubcode_id = 2 
		// 	AND dmi.dtmitem_code IN (
		// 		select dmi2.dtmitem_code from datatex_m_item dmi2
		// 		where dmi2.dtmsubcode_id = 2
		// 		group by dmi2.dtmitem_code
		// 		having count(dmi2.dtmitem_id) = 1
		// 	)
		// 	")->result_array();
			// AND dmi.item_id = 'F/1/415770'

		// Uniq union not uniq
		$q = $this->db->query("
			-- uniq
			SELECT * FROM datatex_m_item dmi
			LEFT JOIN datatex_m_item_detail dmid ON dmid.dtmitem_id = dmi.dtmitem_id
			LEFT JOIN datatex_m_subcode dms on dms.dtmsubcode_id = dmi.dtmsubcode_id 
			LEFT JOIN datatex_m_subcode_detail dmsd on dmsd.dtmsubcodedtl_id = dmid.dtmsubcodedtl_id 
			WHERE dmi.dtmsubcode_id = 70 
			AND dmi.dtmitem_code IN (
				select dmi2.dtmitem_code from datatex_m_item dmi2
				where dmi2.dtmsubcode_id = 70
				group by dmi2.dtmitem_code
				having count(dmi2.dtmitem_id) = 1
			)
			union all
			-- not uniq pick 1 row
			SELECT * FROM datatex_m_item dmi
			LEFT JOIN datatex_m_item_detail dmid ON dmid.dtmitem_id = dmi.dtmitem_id
			LEFT JOIN datatex_m_subcode dms on dms.dtmsubcode_id = dmi.dtmsubcode_id 
			LEFT JOIN datatex_m_subcode_detail dmsd on dmsd.dtmsubcodedtl_id = dmid.dtmsubcodedtl_id 
			WHERE dmi.dtmsubcode_id = 70 
			AND dmi.dtmitem_id IN (
				select distinct on (dtmitem_code)
				dmi.dtmitem_id from datatex_m_item dmi
				where dmi.dtmitem_code in(
					select dmi2.dtmitem_code from datatex_m_item dmi2
					where dmi2.dtmsubcode_id = 70
					group by dmi2.dtmitem_code
					having count(dmi2.dtmitem_id) > 1
				)
			);
		")->result_array();
			
		return $q;
	}

	private function groupBydtmitemId($datas)
	{
		$groupByitems = [];
		foreach ($datas as $data0) {
			$groupByitems[$data0['dtmitem_id']][] = $data0;
		}
		return $groupByitems;
	}

	// not use
	private function processdata()
	{
		$datas = $this->collectdatatrim();
		$groupByitems = [];
		foreach ($datas as $data0) {
			$groupByitems[$data0['dtmitem_id']][] = $data0;
		}

		foreach ($groupByitems as $dt => $el) {
			$lineCode = [];
			foreach ($el as $e) {
				$dtmitemdtl_code = $e['dtmitemdtl_code'];
				if ($e['dtmsubcodedtl_seq'] == 1) {
					//remove spasi
					$dtmitemdtl_code = str_replace(' ', '', $dtmitemdtl_code);
				}
				$lineCode[] = $dtmitemdtl_code;
			}
			$dtmitem_description = $groupByitems[$dt][0]['dtmitem_description'];
			$desc = [
				substr($dtmitem_description, 0, 200),
				substr($dtmitem_description, 0, 80),
				substr($dtmitem_description, 0, 120)
			];
			$merge1 = array_merge(['CHE'], $lineCode);
			$merge2 = array_merge($merge1, $desc);

			$this->createLinecsv(implode(';', $merge2));
		}
	}

	private function processdataByTemplate($IMPORTAUTOCOUNTER)
	{
		$datas = $this->collectdatatrim();
		$templates = $this->templatetrmQA();
		$groupBydtmitemId = $this->groupBydtmitemId($datas);

		//TODO rubah start pointnya 
		// $IMPORTAUTOCOUNTER = 3010002;
		$this->generateHeaderCsv();

		foreach ($groupBydtmitemId as $eGroup => $elements) {
			foreach ($elements as $e) {
				switch ($e['dtmsubcodedtl_seq']) {
					case 1:
						$templates['SUBCODE01'] = str_replace(' ', '', $e['dtmitemdtl_code']);
						break;
					case 2:
						$templates['SUBCODE02'] = strval($e['dtmitemdtl_code']);
						break;
					case 3:
						$templates['SUBCODE03'] = strval($e['dtmitemdtl_code']);
						break;
					case 4:
						$templates['SUBCODE04'] = strval($e['dtmitemdtl_code']);
						break;
					case 5:
						$templates['SUBCODE05'] = strval($e['dtmitemdtl_code']);
						break;
					case 6:
						$templates['SUBCODE06'] = strval($e['dtmitemdtl_code']);
						break;
					case 7:
						$templates['SUBCODE07'] = strval($e['dtmitemdtl_code']);
						break;
					case 8:
						$templates['SUBCODE08'] = strval($e['dtmitemdtl_code']);
					case 9:
						// $templates['SUBCODE09'] = strval($e['dtmitemdtl_code']);
						$templates['SUBCODE09'] = null;
						break;
					case 10:
						// $templates['SUBCODE10'] = strval($e['dtmitemdtl_code']);
						$templates['SUBCODE10'] = null;
						break;
				}
			}
			$dtmitem_description = str_replace(array("\r", "\n"), ' ', $groupBydtmitemId[$eGroup][0]['dtmitem_description']);
	
			$templates['IMPORTAUTOCOUNTER'] = $IMPORTAUTOCOUNTER;
			//UOM
			$templates['BASEPRIMARYUNITCODE'] = $groupBydtmitemId[$eGroup][0]['dtmitem_uom_id'];
			$templates['BASECOSTUNITCODE'] = $groupBydtmitemId[$eGroup][0]['dtmitem_uom_id'];

			$templates['LONGDESCRIPTION'] = substr($dtmitem_description, 0, 200);
			$templates['SHORTDESCRIPTION'] = substr($dtmitem_description, 0, 80);
			$templates['SEARCHDESCRIPTION'] = substr($dtmitem_description, 0, 120);
			$templates['RELATEDDEPENDENTID'] =	$IMPORTAUTOCOUNTER;

			$IMPORTAUTOCOUNTER++;

			$txtLineVal = implode(';', array_values($templates));
			$this->createLinecsv($txtLineVal);
		}
		return true;
	}

	private function generateHeaderCsv()
	{
		$this->load->helper('file');

		$templates = $this->templatetrmQA();
		$txtLineVal = implode(';', array_keys($templates));
		if (!write_file('./public/csv/' . date('ymd') . 'che.csv', $txtLineVal . PHP_EOL, 'a')) {
			echo 'Error File written!' . PHP_EOL;
		} else {
			print_r($txtLineVal) . PHP_EOL;
			// echo "...Loading KEY" . PHP_EOL;
		}
	}

	private function createLinecsv($txtLineVal)
	{
		$this->load->helper('file');

		if (!write_file('./public/csv/' . date('ymd') . 'che.csv', $txtLineVal . PHP_EOL, 'a')) {
			echo 'Error File written!' . PHP_EOL;
		} else {
			print_r($txtLineVal) . PHP_EOL;
			// echo "...Loading KEY" . PHP_EOL;
		}
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Material20240318 extends CI_Controller
{
	public function run(){
//insert into productibeandtl
		$this->load->model('Services/ProductIBeanDetailService');
		//  $this->ProductIBeanDetailService->generateProductIbeanDetail('FAB');
		//  $this->ProductIBeanDetailService->generateProductIbeanDetail('TRM');
		//  $this->ProductIBeanDetailService->generateProductIbeanDetail('PKG');
		//  $this->ProductIBeanDetailService->generateProductIbeanDetail('INS');
		//  $this->ProductIBeanDetailService->generateProductIbeanDetail('CHE');
		
//insert into productibean
		 $this->load->model('Services/ProductIBeanService');
		// $this->ProductIBeanService->generateFAB();
		// $this->ProductIBeanService->generateTRM();
		// $this->ProductIBeanService->generatePKG();
		// $this->ProductIBeanService->generateINS();
		// $this->ProductIBeanService->generateCHE();
		
		//bulk update cari parentnnya dari ibean di ibeandetail
	    // $this->ProductIBeanDetailService->bulkupdateFAB();
		// $this->ProductIBeanDetailService->bulkupdateTRM();
		// $this->ProductIBeanDetailService->bulkupdatePKG();
		// $this->ProductIBeanDetailService->bulkupdateINS();
		// $this->ProductIBeanDetailService->bulkupdateCHE();

		//bulk update cari parentnnya dari ibean di ibeandetail (241126) NEW
	    $this->ProductIBeanDetailService->bulkupdateFABnew();
		$this->ProductIBeanDetailService->bulkupdateTRMnew();
		$this->ProductIBeanDetailService->bulkupdatePKGnew();
		$this->ProductIBeanDetailService->bulkupdateINSnew();

		// $this->load->model('Services/AdstorageBeanDetailService');
		// $this->AdstorageBeanDetailService->generateTechInformationFAB();
		// $this->AdstorageBeanDetailService->generateTechInformationINS();
		// $this->AdstorageBeanDetailService->generateTechInformationPKG();
		// $this->AdstorageBeanDetailService->generateTechInformationTRM();

		$this->load->model('Services/AdstorageBeanDetailServiceTrial2');
		// $this->AdstorageBeanDetailServiceTrial2->generateTechInformationFAB();
		// $this->AdstorageBeanDetailServiceTrial2->generateTechInformationINS();
		// $this->AdstorageBeanDetailServiceTrial2->generateTechInformationPKG();
		// $this->AdstorageBeanDetailServiceTrial2->generateTechInformationTRM();

		$this->load->model('Services/AdstorageBeanService');
			//$this->AdstorageBeanService->generateAdStorageBean();
		
	}

	public function runv2(){
		$this->load->model('Services/ProductIBeanDetailService');
		// get itemids
		$qItemid = $this->db->query("
		select a.item_id  from datatex_m_item a
		left join datatex_m_subcode b on b.dtmsubcode_id = a.dtmsubcode_id 
		where b.dtmsubcode_code in ('PKG')
		")->result_array();
		// where b.dtmsubcode_code in ('FAB', 'INS', 'TRM','PKG')

		$itemids = array_column($qItemid, 'item_id');

		// $itemids = ['F/2/362353', 'F/1/361415'];
		$this->ProductIBeanDetailService->generateProductIbeanDetailV2($itemids);
	}
}

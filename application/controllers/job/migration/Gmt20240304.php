<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gmt20240304 extends CI_Controller
{
	public function run(){
		//20240304
		$version = 10;

		$this->load->model('Services/FinishgoodServices');
		//$act[] = $this->FinishgoodServices->generateScopeFinHie_first($version);
		$act[] = $this->FinishgoodServices->generateScopeFinHie_secondGradeA($version);
		// $act[] = $this->FinishgoodServices->generateScopeFinHie_wip($version);
		// $act[] = $this->FinishgoodServices->generateUGG(2, $version);
		//$act[] = $this->FinishgoodServices->generateUGG(3, $version);
		// $act[] = $this->FinishgoodServices->generateUGG(4, $version);
		// $act[] = $this->FinishgoodServices->generateUGG(5, $version);
		// $act[] = $this->FinishgoodServices->generateUGG(6, $version);
		// $act[] = $this->FinishgoodServices->generateUGG(7, $version);
		// $act[] = $this->FinishgoodServices->generateUGG(8, $version);
		// $act[] = $this->FinishgoodServices->generateUGG(9, $version);
		//$act[] = $this->FinishgoodServices->generateUGG(10, $version);
		echo json_encode($act);
	}	
}

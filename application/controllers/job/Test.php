<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
	public function run()
	{
		$param = "hel low";		
		if(strpos($param, ' ') !== false){
			echo "containSpace";
		}else{
			echo "NOTcontainSpace";
		}

		// $this->load->model('Services/FinishgoodServices');
		// $act[] = $this->FinishgoodServices->generateScopeFinHie_first(1);
		// $act[] = $this->FinishgoodServices->generateScopeFinHie_secondGradeA(1);
		// $act[] = $this->FinishgoodServices->generateScopeFinHie_wip(1);
		// $act[] = $this->FinishgoodServices->getGMTSubcode();
		// $act[] = $this->FinishgoodServices->getLatestVersion('SECOND-GRADE-A');
		// $act[] = $this->FinishgoodServices->generateUGG(2);
		// $act[] = $this->FinishgoodServices->generateUGG(3);
		// $act[] = $this->FinishgoodServices->generateUGG(4);
		// $act[] = $this->FinishgoodServices->generateUGG(5);
		// $act[] = $this->FinishgoodServices->generateUGG(6);
		// $act[] = $this->FinishgoodServices->generateUGG(7);
		// $act[] = $this->FinishgoodServices->generateUGG(8);
		// $act[] = $this->FinishgoodServices->generateUGG(9);
		// $act[] = $this->FinishgoodServices->generateUGG(10);
		// echo json_encode($act);
	}
}

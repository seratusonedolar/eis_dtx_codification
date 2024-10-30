<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array('PLM/SupplierItemRevisionLogModel', 'Mambo/Mos_usersModel'));
	}

	public function index()
	{
		parent::baseTemplate();
		parent::inputmaskAssets();
		parent::datetimepickerAssets();

		$data['user'] = $this->Mos_usersModel->get_by_param(['id' => $this->user_id, 'block' => '0'])->row_array();
		
		$this->load->view('home', $data);
	}

	public function getProcessed()
	{
		$qResult = $this->db->select('count(plmsupplieritemrevisionlog_id) as countid')->get('plm_supplieritemrevision_logs')->row_array();

		$data['code'] = 200;
		$data['data'] = null;
		$data['data_count'] = $qResult['countid'];

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data);
	}

	public function getSuccessValidation()
	{
		$qResult = $this->db->query("select count(qh.quote_no) as countid from quotation_header qh where qh.cost_no ilike '%/pm/%'")->row_array();

		$data['code'] = 200;
		$data['data'] = null;
		$data['data_count'] = $qResult['countid'];

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data);
	}

	public function getProcessedToday()
	{
		$qResult = $this->db->select('count(plmsupplieritemrevisionlog_id) as countid')
			->where('DATE(plmsupplieritemrevisionlog_sync_at)', date('Y-m-d'))
			->get('plm_supplieritemrevision_logs')->row_array();

		$data['code'] = 200;
		$data['data'] = null;
		$data['data_count'] = $qResult['countid'];

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data);
	}

	public function getChartByUserPeriod()
	{
		$startdate = $this->input->get('startdate');
		$enddate = $this->input->get('enddate');

		$arrColor = [
			'#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de',
			'#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de',
			'#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de',
			'#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'
		];

		$qResult = $this->db->query("
			select qh.confirmed_by, mu.name, count(mu.user_id) as countid  from quotation_header qh 
			left join m_users mu on mu.user_id = cast (qh.confirmed_by as decimal)
			where qh.cost_no ilike '%/pm/%'
			and date(qh.confirmed_date) >= '$startdate' and date(qh.confirmed_date) <= '$enddate'
			group by qh.confirmed_by, mu.name")->result_array();
		$bgColor = array();
		for ($i = 0; $i < count($qResult); $i++) {
			$bgColor[] = $arrColor[$i];
		}

		$resp['labels'] = array_column($qResult, 'name');
		$resp['datasets'] = array(
			[
				'data' => array_map('intval', array_column($qResult, 'countid')),
				'backgroundColor' => $bgColor
			]
		);

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($resp);
	}

	public function getChartByBuyerPeriod()
	{
		$startdate = $this->input->get('startdate');
		$enddate = $this->input->get('enddate');

		$arrColor = [
			'#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de',
			'#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de',
			'#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de',
			'#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'
		];

		$qResult = $this->db->query("
			select qh.buyer_id , mc.name , count(mc.company_id) as countid  
			from quotation_header qh 
			left join m_company mc  on mc.company_id  = qh.buyer_id 
			where qh.cost_no ilike '%/pm/%'
			and date(qh.confirmed_date) >= '$startdate' and date(qh.confirmed_date) <= '$enddate'
			group by qh.buyer_id, mc.name")->result_array();
		$bgColor = array();
		for ($i = 0; $i < count($qResult); $i++) {
			$bgColor[] = $arrColor[$i];
		}

		$resp['labels'] = array_column($qResult, 'name');
		$resp['datasets'] = array(
			[
				'data' => array_map('intval', array_column($qResult, 'countid')),
				'backgroundColor' => $bgColor
			]
		);

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($resp);
	}
}

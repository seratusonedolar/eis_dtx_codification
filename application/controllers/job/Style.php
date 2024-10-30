<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
use FuzzyWuzzy\Fuzz;
use FuzzyWuzzy\Process;

class Style extends CI_Controller
{
    /**
     * GENERATE STYLE DATA FROM EIS
     */
    public function get_eis($year)
    {
        try {
            $this->load->helper('file');

            $styleEis = $this->db->query(
                "select oi.order_no, oi.order_date, oi.season, oi.season_yr , oi.garment_type, oi.buyer_id, oi.buyer_name, oi.buyer_style_no, oi.repeat_order_no, oi.total_qty, oi.created_by, mu.name as user_name,
                qh.style_id as quotation_style, qh.quote_no, qh.rev_no, qh.cost_no, qh.cost_rev
                from order_instructions oi 
                left join quotation_header qh on qh.quote_no = oi.quote_no and qh.rev_no = oi.quote_rev_no 
                left join m_users mu on mu.user_id = oi.created_by 
                where extract(year from oi.order_date) >= ?
                order by oi.order_date desc",
                array($year)
            )->result();

            $txt = json_encode($styleEis, JSON_PRETTY_PRINT);
            if (!write_file('./public/jsonfile/eis-style.json', $txt)) {
                echo 'Unable to write the file';
            } else {
                echo 'File written!';
            }

            print_r("OK");
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    public function get_plmdata(){
        $jsonString = file_get_contents('./public/jsonfile/eis-style.json');
        $jsonArray = json_decode($jsonString, true);

        $groupByBuyer = array();
        
        print_r(count($jsonArray));
    }

    // private function serviceCheckDupplicationByBuyer()
}


<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Finishgarment extends CI_Controller
{
	private function finsubcode_structure()
	{
		$subcode[1] = '(1)BuyerStyle'; //buyer_style_no
		$subcode[2] = '(2)Buyer'; //buyer_id
		$subcode[3] = '(3)Season'; //season; season_yr
		$subcode[4] = '(4)Product Segment'; // BELUM ?
		$subcode[5] = '(5)Product Category'; // WOV ?
		$subcode[6] = '(6)Product Type'; //fr_product_type ? lihat join kmana
		$subcode[7] = '(7)Desination'; //destination
		$subcode[8] = '(8)Inseam'; // garment_inseams
		$subcode[9] = '(9)Color'; //garment_colors
		$subcode[10] = '(10)Size'; // garment_sizes

		return $subcode;
	}

	private function orderTypes($key){
		$arayTypes['L'] = 'LADIES';
		$arayTypes['M'] = 'MAN';
		$arayTypes['W'] = 'WOMEN';
		$arayTypes['K'] = 'KIDS';
		$arayTypes['I'] = 'INFANT';
		$arayTypes['T'] = 'TOODLER';
		$arayTypes['O'] = 'OTHER';

		return $arayTypes[$key];
	}

	private function serviceGetOrderSizeBreadown($order_no)
    {
        // $q = $this->db->query("
        //     SELECT order_size_breakdown.*, order_buyer_po.*, order_instructions.*
        //     FROM order_size_breakdown 
        //     LEFT JOIN order_buyer_po ON order_buyer_po.order_no = order_size_breakdown.order_no AND order_buyer_po.buyer_po_number = order_size_breakdown.buyer_po_number
        //     LEFT JOIN order_instructions ON order_instructions.order_no = order_buyer_po.order_no
        //     LEFT JOIN datatex_fin ON datatex_fin.order_no = order_size_breakdown.order_no AND datatex_fin.buyer_po_number=order_size_breakdown.buyer_po_number 
        //         AND datatex_fin.garment_colors = order_size_breakdown.garment_colors AND datatex_fin.garment_sizes = order_size_breakdown.garment_sizes 
        //         AND datatex_fin.garment_inseams = order_size_breakdown.garment_inseams AND datatex_fin.sequence=order_size_breakdown.sequence
        //     WHERE order_instructions.order_no = ?
        //     AND datatex_fin.order_no IS NULL 
        //     AND datatex_fin.buyer_po_number IS NULL 
        //     AND datatex_fin.garment_colors IS NULL
        //     AND datatex_fin.garment_sizes IS NULL
        //     AND datatex_fin.garment_inseams IS NULL
        //     AND datatex_fin.sequence IS NULL
        //     ORDER BY order_size_breakdown.sequence ASC
        // ", array($order_no))->result_array();
        $q = $this->db->query("
            SELECT order_size_breakdown.*, order_buyer_po.*, order_instructions.*, m_product_name.*
            FROM order_size_breakdown 
            LEFT JOIN order_buyer_po ON order_buyer_po.order_no = order_size_breakdown.order_no AND order_buyer_po.buyer_po_number = order_size_breakdown.buyer_po_number
            LEFT JOIN order_instructions ON order_instructions.order_no = order_buyer_po.order_no
			LEFT JOIN m_product_name ON m_product_name.product_name_id = order_instructions.fr_product_type
            WHERE order_instructions.order_no = ?
            ORDER BY order_size_breakdown.sequence ASC
        ", array($order_no))->result_array();

        return $q;
    }

	private function service_generatetempate_leftover($order_no, $sourching){
		$this->load->helper('file');

		$los = $this->serviceGetOrderSizeBreadown($order_no);
		foreach($los as $lo){
			$arraySubcode = [
				strval($lo['buyer_style_no']),
				$lo['buyer_id'],
				$lo['season'].'-'.$lo['season_yr'],
				$this->orderTypes($lo['buyer_div']),
				'WOV',
				$lo['product_name'],
				$lo['destination'],
				strval($lo['garment_inseams']),
				$lo['garment_colors'],
				strval($lo['garment_sizes'])
			];
			$arrayLine = array_merge(array_values($lo), $arraySubcode);
			$arrayLine = array_merge($arrayLine, [$sourching]);
			$txtLineVal = implode(';', $arrayLine);
			if (!write_file('./public/jsonfile/fin2311.csv', $txtLineVal . PHP_EOL, 'a')) {
				echo 'Error File written!' . PHP_EOL;
			} else {
				echo "...Loading KEY" . PHP_EOL;
			}

			//to db
			$this->service_submittemp($arraySubcode, $lo, $sourching);
		}
		echo "...DONE" . PHP_EOL;

	}

	private function service_submittemp($subcode,$lo, $sourching){
		$arrayFin = [
			'dttempfin_orderno' => $lo['order_no'],
			'dttempfin_itemtype' => 'GMT',
			'dttempfin_subcode1' => $subcode[0],
			'dttempfin_subcode2' => $subcode[1],
			'dttempfin_subcode3' => $subcode[2],
			'dttempfin_subcode4' => $subcode[3],
			'dttempfin_subcode5' => $subcode[4],
			'dttempfin_subcode6' => $subcode[5],
			'dttempfin_subcode7' => $subcode[6],
			'dttempfin_subcode8' => $subcode[7],
			'dttempfin_subcode9' => $subcode[8],
			'dttempfin_subcode10' => $subcode[9],
			'dttempfin_source' => $sourching
		];
		$this->db->insert('datatex_tempfin', $arrayFin);
	}

	private function service_getlomaster($year=2023, $month=11)
	{
		$q = $this->db->query(
			"select lom.ref_no from left_over_mst lom 
			where extract(year from lom.lo_date) = ? and extract(month from lom.lo_date) = ?
			group by lom.ref_no ; ",
			[$year, $month]
		)->result();
		return $q;
	}

	private function service_getfgstock($year = 2023, $month = 11){
		$q = $this->db->query(
			"
			select vv2.order_no from (
				select vv.order_no from (
				select li.order_no, li.po_no, efce.wo_no, li.color, li.inseam, li.size
				from getDataWHTxType('RCV') li
				left join erx_fg_clistcode_eis efce on li.bcode_id=efce.clistbar_id
				group by li.order_no, li.po_no, efce.wo_no, li.color, li.inseam, li.size
				union all
				select order_no, '' as po_no, wo_no, color, inseam, size from getListItemGarmentWHTxType('ADJP') 
				group by order_no, wo_no, color, inseam, size
				union all
				select order_no, '' as po_no, wo_no, color, inseam, size 
				from getBCodeGarmentWHTxType('RCV') group by order_no, wo_no, color, inseam, size
				union all
				select la.order_no, esw.buyer_po_number, la.wo_no, la.garment_colors, la.garment_inseams, la.garment_sizes
				from getSampleGarmentWHTxType('RCV') la
				left join erx_sample_wo esw on la.sample_id = esw.id
				where la.order_no is not null
				group by la.order_no, esw.buyer_po_number, la.wo_no, la.garment_colors, la.garment_inseams, la.garment_sizes
				) as vv group by vv.order_no
				) as vv2
				left join (
				select lom.ref_no from left_over_mst lom 
				where extract(year from lom.lo_date) = ? and extract(month from lom.lo_date) = ?
				group by lom.ref_no
				)as vlom on vlom.ref_no = vv2.order_no
				where vlom.ref_no is null;
			", [$year, $month]
		)->result();
		return $q;
	}

	public function run()
	{
		$this->load->helper('file');

		$breakdowns = $this->serviceGetOrderSizeBreadown('23/E/PB/O/AFFD/1013/A');
	// print_r($breakdowns);die();
		$columns = array_merge(array_keys($breakdowns[0]), array_values($this->finsubcode_structure()));
		$columns = array_merge($columns, ['sourcing']);
		$txtLineKey = implode(';', $columns);
		if (!write_file('./public/jsonfile/fin2311.csv', $txtLineKey . PHP_EOL, 'a')) {
			echo 'Error File written!' . PHP_EOL;
		} else {
			echo "...Loading KEY" . PHP_EOL;
		}
		// print_r($this->finsubcode_structure());
		// print_r($this->service_getlomaster());
		// print_r($this->serviceGetOrderSizeBreadown('23/E/PB/O/AFFD/1014/A'));
		$los = $this->service_getlomaster();
		foreach($los as $lo){
			$this->service_generatetempate_leftover($lo->ref_no, 'LO');
		}	

		$stocks = $this->service_getfgstock();
		foreach($stocks as $stock){
			$this->service_generatetempate_leftover($stock->order_no, 'STOCK');
		}

		// print_r($this->service_generatetempate_leftover('23/E/PB/O/AFFD/1014/A'));
	}

	public function runtemp(){
		// $rr = $this->finsubcode_structure();
		// print_r(array_values($rr));
		echo json_encode(['1','2','3']);
	}
}

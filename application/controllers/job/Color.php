<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
use FuzzyWuzzy\Fuzz;
use FuzzyWuzzy\Process;

class Color extends CI_Controller
{
	private $type = "COLOR";

	public function generate($year = "2023", $th = "90")
	{
		$colors = $this->db->query(
			"select osb.garment_colors from order_instructions oi 
            left join order_size_breakdown osb on osb.order_no = oi.order_no
            where extract(year from oi.order_date) >= ?
            group by osb.garment_colors",
			array($year)
		)->result();
		$listColors = array();
		foreach ($colors as $color) {
			$listColors[] = strtoupper($color->garment_colors);
		}
		echo "=== total : " . count($listColors);
		$fuzz = new Fuzz;
		$process = new Process($fuzz);

		$txts = '';
		$txtDiffs = '';
		$arrayHierarchys = array();
		for ($i = 0; $i < count($listColors); $i++) {
			$sliceList = array_slice($listColors, $i + 1);
			$fuzzcheck = $process->extractOne($listColors[$i], $sliceList, null, [$fuzz, 'tokenSortRatio']);
			if ($fuzzcheck[1] <= (int)$th) {
				$txts .= $listColors[$i] . "({$fuzzcheck[1]}) RESULT: ($fuzzcheck[0])" . PHP_EOL;
				// $txts .= $listColors[$i]." POIN : ". $fuzzcheck[1] . PHP_EOL;
				$arrayHierarchys[] = $listColors[$i];
				//SUBIT TO DB
				$this->submit_to_db($listColors[$i], $fuzzcheck[1], $fuzzcheck[0], 1);
			} else {
				$txtDiffs .= $listColors[$i] . "({$fuzzcheck[1]}) RESULT: ($fuzzcheck[0])" . PHP_EOL;
				//SUBIT TO DB
				$this->submit_to_db($listColors[$i], $fuzzcheck[1], $fuzzcheck[0], 0);
			}
			echo "== count-" . $i . PHP_EOL;
		}
		echo "*****FINISH*****";
	}

	private function submit_to_db($dthietemp_name, $dthietemp_th, $dthietemp_th_result, $dthietemp_is_include)
	{
		$arrayMitem = [
			'dthietemp_name' => $dthietemp_name,
			'dthietemp_th' => $dthietemp_th,
			'dthietemp_th_result' => $dthietemp_th_result,
			'dthietemp_type' => $this->type,
			'dthietemp_is_include' => $dthietemp_is_include,
		];

		$this->db->insert('datatex_hierarchy_temp', $arrayMitem);
		return true;
	}

	/** 
	 * Generate color with check dupplication data color 
	 */
	public function generate_color_2021()
	{
		$this->load->helper('file');
		try {
			$colors = $this->db->query(
				"select oi.order_no, oi.order_date, oi.season, oi.season_yr , oi.garment_type, oi.buyer_id, oi.buyer_name, oi.buyer_style_no, oi.repeat_order_no, oi.total_qty, oi.created_by, mu.name as user_name,
                osb.order_no, osb.garment_inseams, osb.garment_sizes, osb.garment_colors,
                mcparent.company_id as parentcompany_id, mcparent.name as parentcompany_name
                from order_size_breakdown osb 
                left join order_instructions oi on oi.order_no = osb.order_no 
                left join m_users mu on mu.user_id = oi.created_by 
                left join m_company mc on mc.company_id = oi.buyer_id
                left join m_company mcparent on mcparent.company_id  = mc.parent_company_id 
                where extract(year from oi.order_date) >= 2021 "
			)->result();
			$gorupByParentCompany = array();
			foreach ($colors as $eColor) {
				$gorupByParentCompany[$eColor->parentcompany_id][] = $eColor->garment_colors;
			}
			// echo json_encode( 
			//     array_values(

			//         array_diff(
			//         array_values(array_unique($gorupByParentCompany['ATLF ']))
			// ,['LIGHT PEBBLE']
			//     )  
			//     )
			// , JSON_PRETTY_PRINT);
			// die();

			$txtLineKey = implode(';', array_merge(array_keys(json_decode(json_encode($colors[0]), true)), ['fuzzResult', 'fuzzPoint']));
			if (!write_file('./public/jsonfile/color-analyst.csv', $txtLineKey . PHP_EOL, 'a')) {
				echo 'Error File written!' . PHP_EOL;
			} else {
				echo "...Loading KEY" . PHP_EOL;
			}

			$fuzz = new Fuzz;
			$process = new Process($fuzz);
			$fuzzResult = array();
			$iLoading = 1;
			foreach ($colors as $eColor2) {
				$listUniqRef = array_values(array_unique($gorupByParentCompany[$eColor2->parentcompany_id]));
				$fuzzcheck = $process->extractOne($eColor2->garment_colors, array_values(array_diff($listUniqRef, [$eColor2->garment_colors])), null, [$fuzz, 'tokenSortRatio']);

				$eColor2->fuzzResult = $fuzzcheck[0];
				$eColor2->fuzzPoint = $fuzzcheck[1];
				// $eColor2->references = json_encode(array_values(array_diff($listUniqRef, [$eColor2->garment_colors])));
				//TODO save append to file
				$txtLine = implode(';', array_values(json_decode(json_encode($eColor2), true)));
				if (!write_file('./public/jsonfile/color-analyst.csv', $txtLine . PHP_EOL, 'a')) {
					echo 'Error File written!' . $iLoading . PHP_EOL;
				} else {
					echo "...Loading " . $iLoading . PHP_EOL;
				}
				$iLoading++;
			}

			print_r("== DONE ==");
		} catch (Exception $e) {
			print_r($e);
		}
	}

	public function check_csv()
	{
		$this->load->helper('file');

		// $stringFile = file_get_contents('./public/jsonfile/color-analyst.csv');
		$stringFile = fopen('./public/jsonfile/color-analyst.csv', 'r');
		$errLine = 1;
		while (($line = fgetcsv($stringFile)) !== FALSE) {
			if (count(fgetcsv($stringFile, 10000, ';')) != 19) {
				//err line
				write_file('./public/jsonfile/color-analyst-second.csv', $line[0] . PHP_EOL, 'a');
				$errLine++;
			} else {
				write_file('./public/jsonfile/color-analyst-good.csv', $line[0] . PHP_EOL, 'a');
			}
			// print_r($line);
		}
		fclose($stringFile);
		print_r("ERROR LINE : " . $errLine . PHP_EOL);
		print_r('==DONE==');
	}

	public function check_csv_second()
	{
		$this->load->helper('file');

		$stringFile = fopen('./public/jsonfile/color-analyst-second.csv', 'r');
		$errLine = 1;
		while (($line = fgetcsv($stringFile)) !== FALSE) {
			if (count(fgetcsv($stringFile, 100000, ';')) != 19) {
				//err line
				write_file('./public/jsonfile/color-analyst-phase2-second.csv', $line[0] . PHP_EOL, 'a');
				$errLine++;
			} else {
				write_file('./public/jsonfile/color-analyst-phase2-good.csv', $line[0] . PHP_EOL, 'a');
			}
			// print_r($line);
		}
		fclose($stringFile);
		print_r("ERROR LINE : " . $errLine . PHP_EOL);
		print_r('==DONE==');
	}

	public function check_csv_removeamp()
	{
		$this->load->helper('file');

		$stringFile = fopen('./public/jsonfile/color-analyst.csv', 'r');
		$errLine = 1;
		while (($line = fgetcsv($stringFile, 10000, '^')) !== FALSE) {
			$line = fgetcsv($stringFile, 10000, '^');
			$strLine = str_replace('&amp;', '', $line[0]);
			if (explode(';', $strLine) != 19) {
				$errLine++;
				write_file('./public/jsonfile/color-analyst-second.csv', $strLine . PHP_EOL, 'a');
			} else {
				write_file('./public/jsonfile/color-analyst-removeamp.csv', $strLine . PHP_EOL, 'a');
			}
		}
		fclose($stringFile);
		print_r("ERROR LINE : " . $errLine . PHP_EOL);
		print_r('==DONE==');
	}
}

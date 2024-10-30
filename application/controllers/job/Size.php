<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
use FuzzyWuzzy\Fuzz;
use FuzzyWuzzy\Process;

class Size extends CI_Controller
{
    private $type = "SIZE";

    public function generate($year = "2023", $th = "90")
    {
        $sizes = $this->db->query(
            "select osb.garment_sizes from order_instructions oi 
            left join order_size_breakdown osb on osb.order_no = oi.order_no
            where extract(year from oi.order_date) >= ?
            group by osb.garment_sizes",
            array($year)
        )->result();

        $listSizes = array();
        foreach ($sizes as $ss) {
            $listSizes[] = strtoupper($ss->garment_sizes);
        }
    echo "=== total : ".count($listSizes);

        $fuzz = new Fuzz;
        $process = new Process($fuzz);

        $txts = '';
        $txtDiffs = '';
        $arrayHierarchys = array();
        for ($i = 0; $i < count($listSizes); $i++) {
            $sliceList = array_slice($listSizes, $i + 1);
            $fuzzcheck = $process->extractOne($listSizes[$i], $sliceList, null, [$fuzz, 'tokenSortRatio']);
            if ($fuzzcheck[1] <= (int)$th) {
                $txts .= $listSizes[$i] . "({$fuzzcheck[1]}) RESULT: ($fuzzcheck[0])" . PHP_EOL;
                // $txts .= $listSizes[$i]." POIN : ". $fuzzcheck[1] . PHP_EOL;
                $arrayHierarchys[] = $listSizes[$i];
                //SUBIT TO DB
                $this->submit_to_db($listSizes[$i], $fuzzcheck[1], $fuzzcheck[0], 1);
            } else {
                $txtDiffs .= $listSizes[$i] . "({$fuzzcheck[1]}) RESULT: ($fuzzcheck[0])" . PHP_EOL;
                //SUBIT TO DB
                $this->submit_to_db($listSizes[$i], $fuzzcheck[1], $fuzzcheck[0], 0);
            }
            echo "== count-".$i.PHP_EOL;
        }

        // // generate captured
        // $this->generate_with_randomcode($arrayHierarchys);

        // $file = fopen(__DIR__ . "./size-$year-$th.csv", "w") or die("Unable to open file!");
        // fwrite($file, $txts);

        // fwrite($file, '=========================================' . PHP_EOL);
        // fwrite($file, $txtDiffs);

        // fclose($file);
echo "*****FINISH*****";

    }

    public function generate_with_randomcode($arrayHierarchys)
    {
        //sesuai dengan format db batch
        $arrayResult = array();
        foreach ($arrayHierarchys as $eHie) {
            $arrayResult[] = [
                'dtmsubcodehierarchy_code' => 'code',
                'dtmsubcodehierarchy_name' => $eHie,
                'dtmsubcode_id' => 12, //ganti yg sesuai
                'dtmsubcodehierarchy_user_id' => 0,
                'dtmsubcodehierarchy_created_by' => 0,
            ];
        }

        //TODO add insert batch to DB

        $file = fopen(__DIR__ . "./sizeresult.csv", "w") or die("Unable to open file!");
        fwrite($file, json_encode($arrayResult));

        fclose($file);
        return 1;
    }

    private function submit_to_db($dthietemp_name, $dthietemp_th, $dthietemp_th_result, $dthietemp_is_include){
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


    public function generate_code(){
        $rr = $this->db->query("
        SELECT * FROM datatex_hierarchy_temp t
        ")->result();

        $i=0;
        foreach ($rr as $r){
            $code = substr(str_shuffle(str_repeat("012345678ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 5);
            $this->db->update('datatex_hierarchy_temp', ['dthietemp_code' => $code], array('dthietemp_id' => $r->dthietemp_id));
            $i++;
    echo "== count-".$i.PHP_EOL;
        } 
        echo "*****FINISH*****";

        // substr(str_shuffle(str_repeat("012345678ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 5);
    }

    public function generate_code_inseam(){
        $rr = $this->db->query("
        SELECT * FROM datatex_hierarchy_temp t where t.dthietemp_type = 'INSEAM'
        ")->result();

        $i=0;
        foreach ($rr as $r){
            $code = substr(str_shuffle(str_repeat("012345678ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 5);
            $this->db->update('datatex_hierarchy_temp', ['dthietemp_code' => $code], array('dthietemp_id' => $r->dthietemp_id));
            $i++;
    echo "== count-".$i.PHP_EOL;
        } 
        echo "*****FINISH*****";
    }

    
}

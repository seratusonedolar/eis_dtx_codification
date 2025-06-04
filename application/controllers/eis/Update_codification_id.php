<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Update_codification_id extends MY_Controller
{
	private $class_link = 'eis/update_codification_id';

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(['my_helper']);
		$this->load->model(['EISDatatex/Setting/PermissionModel']);
	}

	public function index()
	{
		parent::baseTemplate();
		parent::datatablesAssets();
		parent::select2Assets();
		parent::toastAssets();

		$data['class_link'] = $this->class_link;

		$this->load->view($this->class_link . '/index', $data);
	}

	public function checkUploadedItem(){
		$dtmitem_id = $this->input->post('dtmitem_id');
		$is_valid = $this->PermissionModel->checkUploaded($dtmitem_id);

        echo json_encode($is_valid);
	}

	public function partialtablesearch()
	{
		$jsonRequest = $this->input->post('jsonRequest');
        $dtmitem_item = explode(',', $jsonRequest);
		// remove whitespace
		$dtmitem_item = array_map('trim', $dtmitem_item);

		$data['dtmitemfilters'] = [];
		if (!empty($dtmitem_item)) {
			$data['dtmitemfilters'] = $this->db->query(
				"WITH es AS (
					SELECT  a.dtmitem_id, a.item_id, a.dtmitem_created_by, 
							a.dtmitem_code,a.approval_status,
							b.dtmitemdtl_code, c.dtmsubcodedtl_type, c.dtmsubcodedtl_seq, d.dtmsubcodehierarchy_name, d.dtmsubcodehierarchy_code, 
							d.dtmsubcodehierarchy_state, e.dtmsubcode_code, e.dtmsubcode_id , f.um_id,a.dtmitem_uom_id, u.name,
							i.name as item_name,a.dtmitem_description,a.dtxsequence_prod,
							CASE 
							WHEN d.dtmsubcodehierarchy_state = 'reject' 
							THEN 1 
							ELSE 0 
							END AS error_subcode
					FROM datatex_m_item a
					LEFT JOIN datatex_m_item_detail b ON b.dtmitem_id = a.dtmitem_id
					LEFT JOIN datatex_m_subcode_detail c ON b.dtmsubcodedtl_id = c.dtmsubcodedtl_id 
					LEFT JOIN datatex_m_subcode_hierarchy d ON d.dtmsubcodehierarchy_id = b.dtmsubcodehierarchy_id 
					LEFT JOIN datatex_m_subcode e ON e.dtmsubcode_id = a.dtmsubcode_id 
					LEFT JOIN m_item f ON f.item_id = a.item_id 
					LEFT JOIN m_classification g ON g.classif_id = f.classif_id
					LEFT JOIN m_subclassification h ON h.subclassif_id = f.subclassif_id
					LEFT JOIN m_users u ON u.user_id=a.dtmitem_created_by
					LEFT JOIN m_item i on i.item_id = a.item_id
					WHERE upload_status = 0 and a.item_id IN ?
					),
					vs AS (
					SELECT 
						es.*,
						CASE 
						WHEN MAX(error_subcode) OVER (PARTITION BY dtmitem_id) = 1 
						THEN 1 ELSE 0 
						END AS view_status,
						(select case when a.dtxsequence != '' then a.dtxsequence else b.dtxsequence end dtxsequence
							from  
							(select a.dtxsequence, b.item_id, c.status_subcode,b.itemtypecode 
									from datatex_productibeandtl_241126 b
									LEFT JOIN datatex_productibean_241126 a ON a.dtxproductibeanid = b.dtxproductibeanid 
									LEFT JOIN datatex_productibeandtl_status_241126 c ON b.dtmitem_id = c.dtmitem_id 
									WHERE b.item_id = es.item_id) a 
									left join 				
							(select a.dtxsequence, b.item_id, c.status_subcode,b.itemtypecode 
									from datatex_productibeandtl_240706 b
									LEFT JOIN datatex_productibean_240706 a ON a.dtxproductibeanid = b.dtxproductibeanid 
									LEFT JOIN datatex_productibeandtl_status_240706 c ON b.dtmitem_id = c.dtmitem_id 
									WHERE b.item_id = es.item_id) b on a.item_id=b.item_id
						) dtxsequence
					FROM es
					)
					SELECT *
					FROM vs
					ORDER BY dtmitem_id, dtmsubcodedtl_seq",
				[$dtmitem_item]
			)->result_array();
		}

		if(count($data['dtmitemfilters']) > 0){
			$dtmitem_ids = [];
			$dtmsubcode_ids = [];

			foreach ($data['dtmitemfilters'] as $row) {
				$dtmitem_ids[] = $row['dtmitem_id'];
				$dtmsubcode_ids[] = $row['dtmsubcode_id'];
			}

			$dtmitem_ids = array_unique($dtmitem_ids);
			$dtmsubcode_ids = array_unique($dtmsubcode_ids);

			//Technical information
			$data['techinfsubcode'] = $this->db->query(
				"select * from datatex_m_subcode_tech_information a 
				where a.dtmsubcode_id = ? 
				order by a.dtmsubcodetechinf_seq", [$dtmsubcode_ids]
			)->result_array();

			$data['techinfsubcodeData'] = $this->db->query(
					"select * from datatex_m_item_tech_information a 
					left join datatex_m_subcode_tech_information b on b.dtmsubcodetechinf_id = a.dtmsubcodetechinf_id
					left join datatex_m_subcode_tech_inf_hierarchy c on c.dtmsubcodetechinfhierarchy_id = a.dtmsubcodetechinfhierarchy_id
					where a.dtmitem_id in ?
					order by b.dtmsubcodetechinf_seq", [$dtmitem_ids]
			)->result_array();

			$data['class_link'] = $this->class_link;
			$data['array'] = $dtmitem_ids;
			$this->load->view($this->class_link . '/partialtablesearch', $data);
		} else {
			echo "Data Not Found";
		}
	}

	public function searchsubcode(){
		$dtmsubcode_id = $this->input->get('dtmsubcode_id');

		$result = $this->db->query(
			"SELECT a.dtmsubcode_id, a.dtmsubcodedtl_id, a.dtmsubcodedtl_seq, a.dtmsubcodedtl_type, a.dtmsubcode_option_id, a.dtxuggqa_code, a.dtxuggprod_code,
			b.dtmsubcode_name
            FROM datatex_m_subcode_detail a
            LEFT JOIN datatex_m_subcode b ON b.dtmsubcode_id=a.dtmsubcode_option_id
            WHERE a.dtmsubcode_id = ?
            ORDER BY a.dtmsubcodedtl_seq ASC",
			array($dtmsubcode_id)
		)->result_array();

		echo json_encode($result);
	}

	public function updatesubcode(){
		$dtmitem_id = $this->input->post('dtmitem_id');
		$new_value_id = $this->input->post('new_value_id');
		$split_value = $this->input->post('new_value_name');
		$split_values = explode('|', $split_value);
		$new_value_name = trim($split_values[0]); 
		$old_name = $this->input->post('old_name'); 
		$dtmsubcode_seq = $this->input->post('subcode_seq'); 
		$validate = $this->validateuser($dtmitem_id);

		if($validate){
			$query = "UPDATE datatex_m_item_detail 
			SET dtmsubcodehierarchy_id = ?, 
			dtmitemdtl_code = ?,
			dtmitemdtl_updated_status = 1, 
			dtmitemdtl_updated_at = NOW() 
			WHERE dtmitem_id = ? AND dtmitemdtl_code = ? AND dtmsubcodedtl_id = ?";

			$this->db->query($query, array($new_value_id, $new_value_name, $dtmitem_id, $old_name, $dtmsubcode_seq));

			if ($this->db->affected_rows() > 0) {
				$this->updatefullsubcodes($dtmitem_id);

				$response = array(
					'status' => 200,
					'message' => 'Data updated successfully. Changed data from: ' . $old_name . ' to: ' . $new_value_name
				);
			} else {
				$db_error = $this->db->error();
				$response = array(
					'status' => 400,
					'message' => 'Failed to update database. Error: ' . $db_error['message']
				);
			}

			echo json_encode($response);
		}else {
			$response = array(
				'status' => 400,
				'message' => 'Failed to update!, you dont have access to edit this data, please check CreatedBy column'
			);
			
			echo json_encode($response);
		}
	
	}

	public function updateremark(){
		$dtmitem_id = $this->input->post('dtmitem_id');
		$new_value = str_replace("'", "", $this->input->post('new_value'));
		$old_value = str_replace("'", "", $this->input->post('old_value'));
		$itemtipe = $this->input->post('itemtipe');
		if ($itemtipe == 'FAB'){$dtltype = "AND dtmsubcodedtl_id = '1'";}
		else if ($itemtipe == 'INS'){$dtltype = "AND dtmsubcodedtl_id = '11'";}
		else if ($itemtipe == 'PKG'){$dtltype = "AND dtmsubcodedtl_id = '42'";}
		else if ($itemtipe == 'TRM'){$dtltype = "AND dtmsubcodedtl_id = '21'";}
		else {$dtltype = "AND dtmsubcodedtl_id = '$old_value'";}
		
		$query = "UPDATE datatex_m_item SET dtmitem_description = '$new_value' 
					WHERE dtmitem_id = '$dtmitem_id'";
	//echo $query;
		$this->db->query($query);

		$query_updated_by = "UPDATE datatex_m_item
			SET dtmitem_updated_by = ?,
			dtmitem_updated_at = NOW()
			WHERE dtmitem_id = ?";
			
			$this->db->query($query_updated_by, array($this->user_id, $dtmitem_id));

		if ($this->db->affected_rows() > 0) {
			$this->updatefullsubcodes($dtmitem_id);
			$response = array(
				'status' => 200,
				'message' => 'Data updated successfully. Changed data from: ' . $old_value . ' to: ' . $new_value
			);
		} else {
			$db_error = $this->db->error();
			$response = array(
				'status' => 400,
				'message' => 'Failed to update database. Please Refresh the page'
			);
		}
		
		echo json_encode($response);
	}
	
	public function updatemajorfiber(){
		$dtmitem_id = $this->input->post('dtmitem_id');
		$new_value_id = $this->input->post('new_value_id');
		$split_value = $this->input->post('new_value_name');
		$split_values = explode('|', $split_value);
		$new_value_name = trim($split_values[0]); 
		$old_id = $this->input->post('old_id'); 
		$dtmsubcodetechinf_id = $this->input->post('dtmsubcodetechinf_id'); 
		$validate = $this->validateuser($dtmitem_id);

		if($validate){
			$query = "UPDATE datatex_m_item_tech_information 
			SET dtmsubcodetechinfhierarchy_id = ?,
			dtmitemtechinf_note = ?, 
			dtmitemtechinf_updated_at = NOW() 
			WHERE dtmitem_id = ? AND dtmsubcodetechinfhierarchy_id = ? AND dtmsubcodetechinf_id = ?";

			$this->db->query($query, array($new_value_id, $new_value_name, $dtmitem_id, $old_id, $dtmsubcodetechinf_id));

			if ($this->db->affected_rows() > 0) {
				$this->updatefullsubcodes($dtmitem_id);

				$response = array(
					'status' => 200,
					'message' => 'Data updated successfully. Changed data to: ' . $new_value_name
				);
			} else {
				$db_error = $this->db->error();
				$response = array(
					'status' => 400,
					'message' => 'Failed to update database. Please Refresh the page'
				);
			}

			echo json_encode($response);
		}else {
			$response = array(
				'status' => 400,
				'message' => 'Failed to update!, you dont have access to edit this data, please check CreatedBy column'
			);
			
			echo json_encode($response);
		}
	}

	public function insertmajorfiber(){
		$dtmitem_id = $this->input->post('dtmitem_id');
		$new_value_id = $this->input->post('new_value_id');
		$split_value = $this->input->post('new_value_name');
		$split_values = explode('|', $split_value);
		$new_value_name = trim($split_values[0]);
		$old_id = $this->input->post('old_id'); 
		$dtmsubcodetechinf_id = $this->input->post('dtmsubcodetechinf_id'); 
		$validate = $this->validateuser($dtmitem_id);
		$dtmsubcode_id = $this->input->post('dtmsubcode_id'); 

		$query = "SELECT * FROM datatex_m_item_tech_information WHERE dtmsubcodetechinf_id = ? AND dtmitem_id = ?";
		$checkseq = $this->db->query($query, array($dtmsubcodetechinf_id, $dtmitem_id));
		if ($checkseq->num_rows() > 0) {
			if($validate){
				$query = "UPDATE datatex_m_item_tech_information 
				SET dtmsubcodetechinfhierarchy_id = ?,
				dtmitemtechinf_note = ?, 
				dtmitemtechinf_updated_at = NOW() 
				WHERE dtmitem_id = ? AND dtmsubcodetechinf_id = ?";
	
				$this->db->query($query, array($new_value_id, $new_value_name, $dtmitem_id, $dtmsubcodetechinf_id));
	
				if ($this->db->affected_rows() > 0) {
					$this->updatefullsubcodes($dtmitem_id);
	
					$response = array(
						'status' => 200,
						'message' => 'Data updated successfully. Changed data to: ' . $new_value_name
					);
				} else {
					$db_error = $this->db->error();
					$response = array(
						'status' => 400,
						'message' => 'Failed to update database. Please Refresh the page'
					);
				}
	
				echo json_encode($response);
			}else {
				$response = array(
					'status' => 400,
					'message' => 'Failed to update!, you dont have access to edit this data, please check CreatedBy column'
				);
				
				echo json_encode($response);
			}
		} else {
			if($validate){
				$query ="INSERT INTO datatex_m_item_tech_information 
						(dtmitem_id, dtmsubcodetechinf_id, dtmitemtechinf_note, dtmitemtechinf_created_at, dtmsubcodetechinfhierarchy_id)
						VALUES (?, ?, ?, NOW(), ?)";
				
				$this->db->query($query, array($dtmitem_id, $dtmsubcodetechinf_id, $new_value_name, $new_value_id));

				$valuesToDelete = [];
				if ($dtmsubcode_id == 2){
					$valuesToDelete = [1, 2, 3, 4, 15, 35, 36, 37, 38, 39, 40];
				}else if($dtmsubcode_id == 12){
					$valuesToDelete = [5, 6, 16];
				}else if($dtmsubcode_id == 22){
					$valuesToDelete = [7, 8, 9, 10, 11, 12, 13, 14, 25, 26, 27, 28, 30];
				}else if($dtmsubcode_id == 31){
					$valuesToDelete = [17, 18, 19, 20, 21, 22, 23, 24];
				}else if($dtmsubcode_id == 41){
					$valuesToDelete = [33, 34];
				}else if($dtmsubcode_id == 58){
					$valuesToDelete = [29];
				}else if($dtmsubcode_id == 70){
					$valuesToDelete = [31, 32];
				}else {
					$valuesToDelete = null;
				}
				
				$querydata = "SELECT dtmsubcodetechinf_id
							FROM datatex_m_item_tech_information
							WHERE dtmitem_id = ?
							ORDER BY dtmsubcodetechinf_id ASC";
							
				$existingValues = $this->db->query($querydata, array($dtmitem_id))->result_array();
				$existingValues = array_column($existingValues, 'dtmsubcodetechinf_id');

				// Mengambil nilai yang hanya ada di valuesToDelete tetapi tidak ada di existingValues
				$cleanedValues = array_diff($valuesToDelete, $existingValues);

				foreach ($cleanedValues as $dtmsubcodetechinf_id) {
					// Query untuk menginsert data baru ke dalam database
					$query = "INSERT INTO datatex_m_item_tech_information 
							(dtmitem_id, dtmsubcodetechinf_id, dtmitemtechinf_created_at)
							VALUES (?, ?, NOW())";

					$this->db->query($query, array($dtmitem_id, $dtmsubcodetechinf_id));
				}
	
				if ($this->db->affected_rows() > 0) {
					$this->updatefullsubcodes($dtmitem_id);
	
					$response = array(
						'status' => 200,
						'message' => 'Data updated successfully. Changed data to: ' . $new_value_name
					);
				} else {
					$db_error = $this->db->error();
					$response = array(
						'status' => 400,
						'message' => 'Failed to update database. Please Refresh the page'
					);
				}
	
				echo json_encode($response);
			}else {
				$response = array(
					'status' => 400,
					'message' => 'Failed to update!, you dont have access to edit this data, please check CreatedBy column'
				);
				
				echo json_encode($response);
			}
		}
		
	}

	public function updatearticel(){
		$dtmitem_id = $this->input->post('dtmitem_id');
		$new_value = preg_replace('/[^a-zA-Z0-9-_]/', '', $this->input->post('new_value'));
		$old_value = preg_replace('/[^a-zA-Z0-9-_]/', '', $this->input->post('old_value'));
		$validate = $this->validateuser($dtmitem_id);
		if($validate){
			$query = "UPDATE datatex_m_item_detail SET dtmitemdtl_code = ? 
					  WHERE dtmitem_id = ? AND dtmitemdtl_code = ? AND dtmsubcodehierarchy_id isnull";
	
			$this->db->query($query, array($new_value, $dtmitem_id, $old_value));
	
			if ($this->db->affected_rows() > 0) {
				$this->updatefullsubcodes($dtmitem_id);
				$response = array(
					'status' => 200,
					'message' => 'Data updated successfully. Changed data from: ' . $old_value . ' to: ' . $new_value
				);
			} else {
				$db_error = $this->db->error();
				$response = array(
					'status' => 400,
					'message' => 'Failed to update database. Error: ' . $db_error['message']
				);
			}
		
			echo json_encode($response);
		}else{
			$response = array(
				'status' => 400,
				'message' => 'Failed to update!, you dont have access to edit this data, please check CreatedBy column'
			);
			
			echo json_encode($response);
		}
	}

	public function combinesubcodes($dtmitem_id){
		$query = $this->db->query("
			WITH ItemDetails AS (
				SELECT 
					a.dtmitem_id, 
					b.dtmitemdtl_code,
					ROW_NUMBER() OVER (PARTITION BY a.dtmitem_id ORDER BY c.dtmsubcodedtl_seq) AS row_num
				FROM datatex_m_item a
				LEFT JOIN datatex_m_item_detail b ON b.dtmitem_id = a.dtmitem_id
				LEFT JOIN datatex_m_subcode_detail c ON b.dtmsubcodedtl_id = c.dtmsubcodedtl_id
				WHERE a.dtmitem_id IN ($dtmitem_id)
			),
			MaxDetails AS (
				SELECT 
					dtmitem_id, 
					MAX(row_num) AS max_row_num
				FROM ItemDetails
				GROUP BY dtmitem_id
			),
			CrossJoined AS (
				SELECT 
					a.*, 
					md.max_row_num
				FROM datatex_m_item a
				LEFT JOIN MaxDetails md ON a.dtmitem_id = md.dtmitem_id
				WHERE a.dtmitem_id IN ($dtmitem_id)
			),
			Transposed AS (
				SELECT 
					cj.dtmitem_id, 
					cj.max_row_num, 
					cj.item_id, 
					cj.dtmsubcode_id, 
					cj.dtmitem_uom_id, 
					cj.dtmitem_created_by, 
					cj.dtmitem_created_at, 
					cj.dtmitem_updated_at, 
					cj.dtmitem_updated_by, 
					cj.dtmitem_code, 
					cj.dtmitem_validated_at, 
					cj.dtmitem_description,
					MAX(CASE WHEN id.row_num = 1 THEN id.dtmitemdtl_code END) AS subcode1,
					MAX(CASE WHEN id.row_num = 2 THEN id.dtmitemdtl_code END) AS subcode2,
					MAX(CASE WHEN id.row_num = 3 THEN id.dtmitemdtl_code END) AS subcode3,
					MAX(CASE WHEN id.row_num = 4 THEN id.dtmitemdtl_code END) AS subcode4,
					MAX(CASE WHEN id.row_num = 5 THEN id.dtmitemdtl_code END) AS subcode5,
					MAX(CASE WHEN id.row_num = 6 THEN id.dtmitemdtl_code END) AS subcode6,
					MAX(CASE WHEN id.row_num = 7 THEN id.dtmitemdtl_code END) AS subcode7,
					MAX(CASE WHEN id.row_num = 8 THEN id.dtmitemdtl_code END) AS subcode8,
					MAX(CASE WHEN id.row_num = 9 THEN id.dtmitemdtl_code END) AS subcode9,
					MAX(CASE WHEN id.row_num = 10 THEN id.dtmitemdtl_code END) AS subcode10
				FROM CrossJoined cj
				LEFT JOIN ItemDetails id ON cj.dtmitem_id = id.dtmitem_id
				GROUP BY cj.dtmitem_id, cj.max_row_num, cj.item_id, cj.dtmsubcode_id, cj.dtmitem_uom_id, cj.dtmitem_created_by, 
						 cj.dtmitem_created_at, cj.dtmitem_updated_at, cj.dtmitem_updated_by, cj.dtmitem_code, cj.dtmitem_validated_at, cj.dtmitem_description
			)
			SELECT 
				t.dtmitem_id, 
				t.item_id, 
				t.dtmitem_uom_id, 
				t.dtmitem_created_by, 
				t.dtmitem_created_at, 
				t.dtmitem_updated_at, 
				t.dtmitem_code, 
				t.dtmitem_validated_at,
				t.dtmsubcode_id,
				e.dtmsubcode_code,
				t.subcode1,
				t.subcode2,
				t.subcode3,
				t.subcode4,
				t.subcode5,
				t.subcode6,
				t.subcode7,
				t.subcode8,
				t.subcode9,
				t.subcode10,
				f.name AS classname, 
				f.um_id AS subclassname
			FROM Transposed t
			LEFT JOIN datatex_m_subcode_detail c ON t.dtmitem_id = c.dtmsubcodedtl_id 
			LEFT JOIN datatex_m_subcode_hierarchy d ON d.dtmsubcodehierarchy_id = t.dtmitem_id 
			LEFT JOIN datatex_m_subcode e ON e.dtmsubcode_id = t.dtmsubcode_id 
			LEFT JOIN m_item f ON f.item_id = t.item_id 
			LEFT JOIN m_classification g ON g.classif_id = f.classif_id
			LEFT JOIN m_subclassification h ON h.subclassif_id = f.subclassif_id
			ORDER BY t.dtmitem_id;
		");
		$results = $query->result_array();

		foreach ($results as &$row) {
			$subcodes = array($row['dtmsubcode_code'], $row['subcode1'], $row['subcode2'], $row['subcode3'], $row['subcode4'], $row['subcode5'], $row['subcode6'], $row['subcode7'], $row['subcode8'], $row['subcode9'], $row['subcode10']);
			$combined = implode("-", array_filter($subcodes));
			$row['combined_subcodes'] = $combined;
		}
	
		$combinedSubcodesArray = array_column($results, 'combined_subcodes');
		return implode(", ", $combinedSubcodesArray);
	
		return $results;
	}	

	public function updatefullsubcodes($dtmitem_id){
		$combine = $this->combinesubcodes($dtmitem_id);
		$query_update = "UPDATE datatex_m_item SET dtmitem_code = ?
						 WHERE dtmitem_id = ?";
		$this->db->query($query_update, array($combine, $dtmitem_id));
	}

	public function validateuser($dtmitem_id){
		$query = $this->db->query("SELECT dtmitem_created_by FROM datatex_m_item WHERE dtmitem_id = $dtmitem_id");
    
		$row = $query->row();
		
		if ($row && $row->dtmitem_created_by == $this->user_id OR $this->user_id = 664) {
			return true;
		} else {
			return false;
		}
	}

	public function partialformsearch()
	{
		$dtmsubcode_id1 = $this->input->get('dtmsubcode_id1');

		$data['class_link'] = $this->class_link;

		$this->load->view($this->class_link . '/partialformsearch', $data);
	}

	public function partialformsearchsubcode()
	{
		$dtmsubcode_id = $this->input->get('dtmsubcode_id');

		$result = $this->db->query(
			"SELECT datatex_m_subcode_detail.*, datatex_m_subcode.dtmsubcode_name 
            FROM datatex_m_subcode_detail 
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_subcode_detail.dtmsubcode_option_id
            WHERE datatex_m_subcode_detail.dtmsubcode_id = ? AND datatex_m_subcode_detail.dtmsubcodedtl_seq IN (1,2)
            ORDER BY datatex_m_subcode_detail.dtmsubcodedtl_seq ASC",
			array($dtmsubcode_id)
		)->result_array();

		$data['result'] = $result;
		$data['dtmsubcode_id'] = $dtmsubcode_id;
		$data['class_link'] = $this->class_link;

		$this->load->view($this->class_link . '/partialformsearchsubcode', $data);
	}

	public function partialformsearchtechinf()
	{
		$dtmsubcode_id = $this->input->get('dtmsubcode_id');

		$result = $this->db->query(
			"SELECT datatex_m_subcode_tech_information.*, datatex_m_subcode.dtmsubcode_name 
            FROM datatex_m_subcode_tech_information 
            LEFT JOIN datatex_m_subcode ON datatex_m_subcode.dtmsubcode_id=datatex_m_subcode_tech_information.dtmsubcode_id
            WHERE datatex_m_subcode_tech_information.dtmsubcode_id = ?
            AND datatex_m_subcode_tech_information.dtmsubcodetechinf_is_active = ?
            ORDER BY datatex_m_subcode_tech_information.dtmsubcodetechinf_seq ASC",
			array($dtmsubcode_id, true)
		)->result_array();

		$data['class_link'] = $this->class_link;
		$data['result'] = $result;
		$data['dtmsubcode_id'] = $dtmsubcode_id;

		$this->load->view($this->class_link . '/partialformsearchtechinf', $data);
	}

	public function search_item()
	{
		$dtmsubcode_id1 = $this->input->post('dtmsubcode_id1');

		$this->load->library(['form_validation']);
		$this->form_validation->set_rules('dtmsubcode_id1', 'Classif', 'required');

		if ($this->form_validation->run() == FALSE) {
			$resp['code'] = 400;
			$resp['messages'] = validation_errors();

			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($resp);
			exit();
		}

		$subcodes = $this->db->query("select * from datatex_m_subcode_detail where dtmsubcode_id = ? order by dtmsubcodedtl_seq asc ", [$dtmsubcode_id1])->result_array();
		$groupSubcodesSeq = [];
		foreach ($subcodes as $esub) {
			$groupSubcodesSeq[$esub['dtmsubcodedtl_seq']] = $esub['dtmsubcodedtl_id'];
		}

		$subcodedetails = array();
		foreach ($subcodes as $eSubc) {
			if (empty($this->input->post('seq' . $eSubc['dtmsubcodedtl_seq'] . 'code'))) {
				continue;
			}
			$dtmsubcodedtl_id = $groupSubcodesSeq[$eSubc['dtmsubcodedtl_seq']] ?? null;
			$subcodedetails[] = [
				'dtmsubcodedtl_id' => (int)$dtmsubcodedtl_id,
				'dtmitemdtl_code' => $this->input->post('seq' . $eSubc['dtmsubcodedtl_seq'] . 'code') ?? null,
				'dtmitemdtl_seq' => $eSubc['dtmsubcodedtl_seq']
			];
		}

		if (empty($subcodedetails)) {
			$resp['code'] = 400;
			$resp['messages'] = "Detail Null";

			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($resp);
			exit();
		}

		$arrJsonRequest['itemtype']['dtmsubcode_id'] = $dtmsubcode_id1;
		$arrJsonRequest['subcodedetails'] = $subcodedetails;
		$arrJsonRequest['dtmsubcodetechinfhierarchy_ids'] = $this->input->post('dtmsubcodetechinfhierarchy_ids');

		$resp['jsonRequest'] = json_encode($arrJsonRequest, true);

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($resp);
	}
}

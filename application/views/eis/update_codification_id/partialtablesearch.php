<button class="btn btn-sm btn-warning" style="margin-bottom: 10px;" id="idbtnsync" onclick="reload()"> <i class="fas fa-sync"></i> Refresh </button>
<div class="card-body table-responsive p-0">
	<table id="idTable" class="table table-bordered table-striped table-hover" style="font-size: 80%;">
		<thead>
			<tr style="text-align: center;">
				<th>DatatexID</th>
				<th>ItemID</th>
				<th>ItemName</th>
				<th style="background-color: burlywood;">Remark Datatex</th>
				<th style="background-color: burlywood;">DatatexCode</th>
				<th style="background-color: burlywood;">DatatexSubcode1</th>
				<th style="background-color: burlywood;">DatatexSubcode2</th>
				<th style="background-color: burlywood;">DatatexSubcode3</th>
				<th style="background-color: burlywood;">DatatexSubcode4</th>
				<th style="background-color: burlywood;">DatatexSubcode5</th>
				<th style="background-color: burlywood;">DatatexSubcode6</th>
				<th style="background-color: burlywood;">DatatexSubcode7</th>
				<th style="background-color: burlywood;">DatatexSubcode8</th>
				<th style="background-color: burlywood;">DatatexSubcode9</th>
				<th style="background-color: burlywood;">DatatexSubcode10</th>
				<th>UmID</th>
				<th>CreatedBy</th>
				<!-- Tech Inf -->
				<?php foreach($techinfsubcode as $eTechinfsubcode): ?>
					<th style="background-color: aqua;"><?php echo "TechInf({$eTechinfsubcode['dtmsubcodetechinf_seq']}) <br>".$eTechinfsubcode['dtmsubcodetechinf_remark']; ?></th>
				<?php endforeach;?>
				<th style="background-color: powderblue;">Status Approve</th>
				<th style="background-color: powderblue;">Dtx Sequence Prod</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$groupDtmitemfilters = array();
			foreach ($dtmitemfilters as $e) {
				$groupDtmitemfilters[$e['dtmitem_id']][] = $e;
			}
			$item_ids = [];

			// Tech inf
			$groupTechinfData = [];
			foreach($techinfsubcodeData as $eTechinfdata):
				$groupTechinfData[$eTechinfdata['dtmitem_id']][] = $eTechinfdata;
			endforeach;

			foreach ($groupDtmitemfilters as $dtmitem_id => $elements) : ?>
			<?php $item_ids[] = $groupDtmitemfilters[$dtmitem_id][0]['item_id']; ?>
				<tr data-dtmsubcode-id="<?= $groupDtmitemfilters[$dtmitem_id][0]['dtmsubcode_id'] ?>" data-approval="<?= $groupDtmitemfilters[$dtmitem_id][0]['approval_status'] ?>">
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['dtmitem_id'] ?></td>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['item_id'] ?></td>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['item_name'] ?></td>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['dtmitem_description'] ?></td>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['dtmsubcode_code'] ?></td>
					<?php
					$j = 0;
					foreach ($elements as $el) :
						$dtmsubcodehierarchy_code = $el['dtmsubcodehierarchy_code'];
						$dtmsubcodehierarchy_name = $el['dtmsubcodehierarchy_name'];
						$dtmsubcodehierarchy_state = $el['dtmsubcodehierarchy_state'];
						if ($el['dtmsubcodedtl_type'] == 'TEXT') {
							$dtmsubcodehierarchy_code = $el['dtmitemdtl_code'];
							$dtmsubcodehierarchy_state = 'confirmed';
						}
						$span = 'success';
						if ($dtmsubcodehierarchy_state != 'confirmed') {
							$span = 'warning';
						}
						// Cek error_subcode
						$errorStyle = '';
						if ($el['error_subcode'] == 1) {
							$errorStyle = 'background-color:#F3B6AA; color:black';
						}
					?>
						<td style="<?= $errorStyle ?>"><?= $dtmsubcodehierarchy_code; ?> | <?= $dtmsubcodehierarchy_name; ?></td>
					<?php
						$j++;
					endforeach; ?>
					<!-- Check for subcode not 10 -->
					<?php
					if ($j < 10) :
						for ($jj = 0; $jj < (10 - $j); $jj++) :
					?>
							<td></td>
					<?php
						endfor;
					endif;
					?>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['dtmitem_uom_id'] ?></td>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['name'] ?></td>
					<!-- Tech Inf -->
					<?php 
					if (isset($groupTechinfData[$dtmitem_id])):
						$k = 0;
						foreach ($groupTechinfData[$dtmitem_id] as $techinfdtmitemid => $techinfElements): ?>
							<td data-dtmtechinf-id<?= $techinfElements['dtmsubcodetechinfhierarchy_code'] ?>-<?= $groupDtmitemfilters[$dtmitem_id][0]['dtmitem_id'] ?>='<?= $techinfElements['dtmsubcodetechinfhierarchy_id'] ?>'><?php echo !empty($techinfElements['dtmsubcodetechinfhierarchy_code']) ? htmlspecialchars($techinfElements['dtmsubcodetechinfhierarchy_code']. " | " .$techinfElements['dtmsubcodetechinfhierarchy_name']) : null; ?></td>
							<?php 
							$k++;
						endforeach;
					else:
						$k = 0;
						for ($ll = 0; $ll < count($techinfsubcode); $ll++):
							$k++; ?>
							<td></td>
							<?php
						endfor;
					endif;					
					?>
					<!-- additional td techinf -->
					<?php if ($k != count($techinfsubcode)):
						for($kk=0; $kk<(count($techinfsubcode)-$k); $kk++):
						?>
							<td></td>
					<?php 
						endfor;
					endif;?>
					<td style="text-align: center;">
						<?php if($groupDtmitemfilters[$dtmitem_id][0]['approval_status'] == 'confirmed'){
							     echo 'Approved'; } else {echo $groupDtmitemfilters[$dtmitem_id][0]['approval_status']; 
								 } ?>
					</td>
					<td style="text-align: center;">
						<?php echo $groupDtmitemfilters[$dtmitem_id][0]['dtxsequence_prod'];?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr style="text-align: center;">
				<th>DatatexID</th>
				<th>ItemID</th>
				<th>ItemName</th>
				<th style="background-color: burlywood;">Remark Datatex</th>
				<th style="background-color: burlywood;">DatatexCode</th>
				<th style="background-color: burlywood;">DatatexSubcode1</th>
				<th style="background-color: burlywood;">DatatexSubcode2</th>
				<th style="background-color: burlywood;">DatatexSubcode3</th>
				<th style="background-color: burlywood;">DatatexSubcode4</th>
				<th style="background-color: burlywood;">DatatexSubcode5</th>
				<th style="background-color: burlywood;">DatatexSubcode6</th>
				<th style="background-color: burlywood;">DatatexSubcode7</th>
				<th style="background-color: burlywood;">DatatexSubcode8</th>
				<th style="background-color: burlywood;">DatatexSubcode9</th>
				<th style="background-color: burlywood;">DatatexSubcode10</th>
				<th>UmID</th>
				<th>CreatedBy</th>
				<!-- Tech Inf -->
				<?php foreach($techinfsubcode as $eTechinfsubcode2): ?>
					<th style="background-color: aqua;"><?php echo "TechInf({$eTechinfsubcode2['dtmsubcodetechinf_seq']})".$eTechinfsubcode2['dtmsubcodetechinf_remark']; ?></th>
				<?php endforeach;?>
				<th style="background-color: powderblue;">Status Approve</th>
				<th style="background-color: powderblue;">Dtx Sequence Prod</th>
			</tr>
		</tfoot>
	</table>
</div>

<script type="text/javascript">
function reload(){
	const itemIDs = "<?php echo implode(',', $item_ids); ?>";
	submitData(itemIDs);
}

$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#idTable tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    });

    var tbl = $("#idTable").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "search": {
            return: true,
        },
        "searchDelay": 500,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "scrollX": true,
        "scrollY": "250",
        "initComplete": function() {
            // Apply the search
            this.api().columns().every(function() {
                var that = this;
                $('input', this.footer()).on('keyup', function(e) {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
            });
        },
        "dom": 'Blfrtip',
        "buttons": [
            'excel',
        ]
    });

	function cekDtxsequence(dtmitem_id) {
        return $.ajax({
			url: '<?php echo base_url() . $class_link . '/checkUploadedItem'?>',
            type: 'POST',
			data: { dtmitem_id: dtmitem_id },
            dataType: 'json'
        });
    }

    // Click event for each row
	
	// $('#idTable tbody').on('click', 'tr', function(event) {
	// 	const itemIDs = "<?php echo implode(',', $item_ids); ?>";
	// 	const dtmitem_id = $(this).closest('tr').find('td:first').text();
	// 	var approval_status = $(this).data('approval');

	// 	//if(approval_status === 'confirmed'){
	// 	//	console.log('confirmed')
	// 	//}else{
	// 		var dtmsubcode_id = $(this).data('dtmsubcode-id');
	// 		var clickedValue = null;
	// 		var clickedName = null;
			
	// 		clickedValue = $(event.target).text().replace(/[^a-zA-Z0-9 ./%"'-,|]/g, '');
	// 		splitValue = clickedValue.split('|');
	// 		clickedValue = splitValue[0].replace(/\s+/g, '');
	// 		clickedName = splitValue[1];

	// 		if (dtmsubcode_id) {
	// 			// Get the column index that was clicked
	// 			var columnIndex = $(this).children('td').index($(event.target));
	// 			var rowData = tbl.row($(this)).data();
	// 			var dtmsubcodedtl_seq;
	// 			var dtmsubcodetechinf_id;

	// 		//	cekDtxsequence(dtmitem_id).then(function(isValid) {
	// 		//		if (isValid === false) {
	// 				// Determine dtmsubcodedtl_seq based on the column index
	// 				switch (columnIndex) {
	// 					case 3: 
	// 						var previousValue = $(event.target).text();
	// 						var textInput = $('<textarea class="form-control" maxlength="200">' + previousValue + '</textarea>');
	// 						$(event.target).html(textInput);

	// 						textInput.on('keypress', function(e) {
	// 							if (e.which === 13) { // If Enter key is pressed
	// 								var newValue = $(this).val();
	// 								var dtmitem_id = $(this).closest('tr').find('td:first').text();
	// 								var oldValue = previousValue;
	// 								var itemtipe = $(this).closest('tr').find('td:eq(4)').text();
	// 								$(this).prop('disabled', true);

	// 								$.ajax({
	// 									url: '<?php echo base_url() . $class_link . '/updateremark'?>',
	// 									type: 'POST',
	// 									data: {
	// 										dtmitem_id: dtmitem_id,
	// 										old_value: oldValue,
	// 										new_value: newValue,
	// 										itemtipe: itemtipe
	// 									},
	// 									success: function(response) {
	// 										const responseData = JSON.parse(response);
	// 										if(responseData.status == 200){
	// 											alert(responseData.message);
	// 											//submitData(dtmsubcode_id)
	// 										}else {
	// 											alert(responseData.message);
	// 											textInput.prop('disabled', false);
	// 										}
	// 									},
	// 									beforeSend: function() {
	// 										$('.preloader-custom').fadeIn('xfast');
	// 									},
	// 									complete: function() {
	// 										$('.preloader-custom').fadeOut('xfast');
	// 									},
	// 									error: function(xhr, status, error) {
	// 										console.error("Error: " + error);
	// 										textInput.prop('disabled', false);
	// 									}
	// 								});
	// 							}
	// 						});
	// 						return;
	// 					case 5: 
	// 						var previousValue = $(event.target).text();
	// 						var textInput = $('<input type="text" class="form-control" value="' + previousValue + '" />');
	// 						$(event.target).html(textInput);

	// 						textInput.on('keypress', function(e) {
	// 							if (e.which === 13) { // If Enter key is pressed
	// 								var newValue = $(this).val();
	// 								var dtmitem_id = $(this).closest('tr').find('td:first').text();
	// 								var oldValue = previousValue;
	// 								$(this).prop('disabled', true);

	// 								$.ajax({
	// 									url: '<?php echo base_url() . $class_link . '/updatearticel'?>',
	// 									type: 'POST',
	// 									data: {
	// 										dtmitem_id: dtmitem_id,
	// 										old_value: oldValue,
	// 										new_value: newValue
	// 									},
	// 									success: function(response) {
	// 										const responseData = JSON.parse(response);
	// 										if(responseData.status == 200){
	// 											alert(responseData.message);
	// 											submitData(dtmsubcode_id)
	// 										}else {
	// 											alert(responseData.message);
	// 											textInput.prop('disabled', false);
	// 										}
	// 									},
	// 									beforeSend: function() {
	// 										$('.preloader-custom').fadeIn('xfast');
	// 									},
	// 									complete: function() {
	// 										$('.preloader-custom').fadeOut('xfast');
	// 									},
	// 									error: function(xhr, status, error) {
	// 										console.error("Error: " + error);
	// 										textInput.prop('disabled', false);
	// 									}
	// 								});
	// 							}
	// 						});
	// 						return;
	// 					case 6:
	// 						const subcode02Map = {
	// 							2: 2,
	// 							12: 12,
	// 							22: 22,
	// 							31: 43,
	// 							41: 31,
	// 							47: 38,
	// 							53: 72,
	// 							58: 54,
	// 							70: 65,
	// 							84: 80
	// 						}
	// 						dtmsubcodedtl_id = subcode02Map[dtmsubcode_id] || null;
	// 						dtmsubcodedtl_seq = 2;
	// 						break;
	// 					case 7:
	// 						const subcode03Map = {
	// 							2: 3,
	// 							12: 13,
	// 							22: 23,
	// 							31: 44,
	// 							41: 33,
	// 							47: 39,
	// 							53: 73,
	// 							58: 55,
	// 							70: 66,
	// 							84: 81
	// 						}
	// 						dtmsubcodedtl_id = subcode03Map[dtmsubcode_id] || null;
	// 						dtmsubcodedtl_seq = 3;
	// 						break;
	// 					case 8:
	// 						const subcode04Map = {
	// 							2: 4,
	// 							12: 14,
	// 							22: 24,
	// 							31: 45,
	// 							41: 34,
	// 							47: 63,
	// 							53: 74,
	// 							58: 56,
	// 							70: 67,
	// 							84: 82
	// 						}
	// 						dtmsubcodedtl_id = subcode04Map[dtmsubcode_id] || null;
	// 						dtmsubcodedtl_seq = 4;
	// 						break;
	// 					case 9:
	// 						const subcode05Map = {
	// 							2: 5,
	// 							12: 15,
	// 							22: 25,
	// 							31: 46,
	// 							41: 35,
	// 							47: 40,
	// 							53: 75,
	// 							58: 57,
	// 							70: 68,
	// 							84: 83
	// 						}
	// 						dtmsubcodedtl_id = subcode05Map[dtmsubcode_id] || null;
	// 						dtmsubcodedtl_seq = 5;
	// 						break;
	// 					case 10:
	// 						const subcode06Map = {
	// 							2: 6,
	// 							12: 16,
	// 							22: 26,
	// 							31: 47,
	// 							41: 36,
	// 							47: 41,
	// 							53: 76,
	// 							58: 58,
	// 							70: 69,
	// 							84: 84
	// 						}
	// 						dtmsubcodedtl_id = subcode06Map[dtmsubcode_id] || null;
	// 						dtmsubcodedtl_seq = 6;
	// 						break;
	// 					case 11:
	// 						const subcode07Map = {
	// 							2: 7,
	// 							12: 17,
	// 							22: 27,
	// 							31: 48,
	// 							41: 62,
	// 							53: 77,
	// 							58: 59,
	// 							70: 70,
	// 							84: 85
	// 						}
	// 						dtmsubcodedtl_id = subcode07Map[dtmsubcode_id] || null;
	// 						dtmsubcodedtl_seq = 7;
	// 						break;
	// 					case 12:
	// 						const subcode08Map = {
	// 							2: 8,
	// 							12: 18,
	// 							22: 28,
	// 							31: 49,
	// 							53: 78,
	// 							58: 60,
	// 							84: 86
	// 						}
	// 						dtmsubcodedtl_id = subcode08Map[dtmsubcode_id] || null;
	// 						dtmsubcodedtl_seq = 8;
	// 						break;
	// 					case 13:
	// 						const subcode09Map = {
	// 							2: 9,
	// 							12: 19,
	// 							22: 29,
	// 							31: 50
	// 						}
	// 						dtmsubcodedtl_id = subcode09Map[dtmsubcode_id] || null;
	// 						dtmsubcodedtl_seq = 9;
	// 						break;
	// 					case 14:
	// 						const subcode10Map = {
	// 							2: 10,
	// 							12: 20,
	// 							31: 51
	// 						}
	// 						dtmsubcodedtl_id = subcode10Map[dtmsubcode_id] || null;
	// 						dtmsubcodedtl_seq = 10;
	// 						break;
	// 						// case 22:
	// 						// dtmsubcodetechinf_id = 35;
	// 						// break;
	// 					case 17:
	// 					const techinf01Map = {
	// 						2: 1,
	// 						12: 5,
	// 						22: 7,
	// 						31: 17,
	// 						41: 33,
	// 						58: 29,
	// 						70: 31
	// 					}
	// 					dtmsubcodetechinf_id = techinf01Map[dtmsubcode_id] || null;
	// 					break;
	// 					case 18:
	// 						const techinf02Map = {
	// 							2: 2,
	// 							12: 6,
	// 							22: 8,
	// 							31: 18,
	// 							41: 34,
	// 							70: 32
	// 						}
	// 						dtmsubcodetechinf_id = techinf02Map[dtmsubcode_id] || null;
	// 						break;
	// 					case 19:
	// 						const techinf03Map = {
	// 							2: 3,
	// 							12: 16,
	// 							22: 9,
	// 							31: 19
	// 						}
	// 						dtmsubcodetechinf_id = techinf03Map[dtmsubcode_id] || null;
	// 						break;
	// 					case 20:
	// 						const techinf04Map = {
	// 							2: 4,
	// 							22: 10,
	// 							31: 20
	// 						}
	// 						dtmsubcodetechinf_id = techinf04Map[dtmsubcode_id] || null;
	// 						break;
	// 					case 21:
	// 						const techinf05Map = {
	// 							2: 15,
	// 							22: 11,
	// 							31: 21
	// 						}
	// 						dtmsubcodetechinf_id = techinf05Map[dtmsubcode_id] || null;
	// 						break;
	// 					case 22:
	// 						const techinf06Map = {
	// 							2: 35,
	// 							22: 12,
	// 							31: 22
	// 						}
	// 						dtmsubcodetechinf_id = techinf06Map[dtmsubcode_id] || null;
	// 						break;
	// 					case 23:
	// 						const techinf07Map = {
	// 							2: 36,
	// 							22: 13,
	// 							31: 23
	// 						}
	// 						dtmsubcodetechinf_id = techinf07Map[dtmsubcode_id] || null;
	// 						break;
	// 					case 24:
	// 						const techinf08Map = {
	// 							2: 37,
	// 							22: 14,
	// 							31: 24
	// 						}
	// 						dtmsubcodetechinf_id = techinf08Map[dtmsubcode_id] || null;
	// 						break;
	// 					case 25:
	// 						const techinf09Map = {
	// 							2: 38,
	// 							22: 25
	// 						}
	// 						dtmsubcodetechinf_id = techinf09Map[dtmsubcode_id] || null;
	// 						break;
	// 					case 26:
	// 						const techinf10Map = {
	// 							2: 39,
	// 							22: 26
	// 						}
	// 						dtmsubcodetechinf_id = techinf10Map[dtmsubcode_id] || null;
	// 						break;
	// 					case 27:
	// 						const techinf11Map = {
	// 							2: 40,
	// 							22: 27
	// 						}
	// 						dtmsubcodetechinf_id = techinf11Map[dtmsubcode_id] || null;
	// 						break;
	// 					case 28:
	// 						const techinf12Map = {
	// 							22: 28
	// 						}
	// 						dtmsubcodetechinf_id = techinf12Map[dtmsubcode_id] || null;
	// 						break;
	// 					case 29:
	// 						const techinf13Map = {
	// 							22: 30
	// 						}
	// 						dtmsubcodetechinf_id = techinf13Map[dtmsubcode_id] || null;
	// 						break;
	// 					default:
	// 						dtmsubcodedtl_seq = null;
	// 						dtmsubcodetechinf_id = null;
	// 						break;
	// 					}

	// 				if (dtmsubcodedtl_seq !== null) {
	// 					$.ajax({
	// 						url: '<?php echo base_url() . $class_link . '/searchsubcode'?>',
	// 						type: 'GET',
	// 						data: { dtmsubcode_id: dtmsubcode_id },
	// 						success: function(response) {
	// 							const data = JSON.parse(response); //parsing json data
	// 							const dtmsubcodedtlSeqs = data.map(item => item.dtmsubcodedtl_seq);

	// 							if (dtmsubcodedtlSeqs.includes(dtmsubcodedtl_seq)) {
	// 								const dtmsubcode_option_id = data.find(item => item.dtmsubcodedtl_seq === dtmsubcodedtl_seq).dtmsubcode_option_id;

	// 								if (dtmsubcode_option_id) {
	// 									$.ajax({
	// 										url: '<?php echo base_url() . 'eis/datatech_itemcodification/autocomplete_subcode_hierarchy?dtmsubcode_id='?>' + dtmsubcode_option_id,
	// 										type: 'GET',
	// 										success: function(response) {
	// 											// Store the result in a variable named subcode{dtmsubcodedtl_seq}
	// 											window[`subcode${dtmsubcodedtl_seq}`] = JSON.parse(response);

	// 											// Create a dropdown with Select2
	// 											const subcode = window[`subcode${dtmsubcodedtl_seq}`];
	// 											const dropdown = $('<select class="select2-dropdown"></select>');
	// 											subcode.forEach(function(item) {
	// 												dropdown.append(`<option value="${item.dtmsubcodehierarchy_id}">${item.dtmsubcodehierarchy_code} | ${item.dtmsubcodehierarchy_name}</option>`);
	// 											});
												
	// 											// Replace the clicked cell with the dropdown
	// 											$(event.target).html(dropdown);

	// 											// Initialize Select2 on the dropdown
	// 											dropdown.select2({
	// 												placeholder: 'Select an option',
	// 												allowClear: false,
	// 												width: 'style',
	// 												dropdownAutoWidth : true,
	// 												dropdownCssClass: 'select2-dropdown-custom' // Custom class for dropdown
	// 											});

	// 											dropdown.val(clickedValue).trigger('change');
												
	// 											dropdown.on('select2:select', function() {
	// 											var newValueName = null;
	// 											newValueName = $(this).find('option:selected').text();
	// 											splitName = newValueName.split('|');
	// 											newValueName = splitName[0].replace(/\s+/g, '');

	// 											const newValueId = $(this).val();
	// 											const columnIndex = $(this).closest('td').index();
	// 											const dtmitem_id = $(this).closest('tr').find('td:first').text(); // Get old value id for this column index
	// 											const $select = $(this);
	// 												if (columnIndex >= 4 && columnIndex <= 14) {
	// 													$.ajax({
	// 														url: '<?php echo base_url() . $class_link . '/updatesubcode'?>',
	// 														type: 'POST',
	// 														data: {
	// 															dtmitem_id: dtmitem_id,
	// 															old_name: clickedValue,
	// 															new_value_id: newValueId,
	// 															new_value_name: newValueName,
	// 															subcode_seq: dtmsubcodedtl_id
	// 														},
	// 														success: function(response) {
	// 															const responseData = JSON.parse(response);
	// 															if(responseData.status == 200){
	// 																alert(responseData.message);
	// 																$select.prop('disabled', true); 
	// 																submitData(itemIDs)
	// 															}else {
	// 																alert(responseData.message);
	// 																$select.prop('disabled', false); 
	// 															}
	// 														},
	// 														beforeSend: function() {
	// 															$('.preloader-custom').fadeIn('xfast');
	// 														},
	// 														complete: function() {
	// 															$('.preloader-custom').fadeOut('xfast');
	// 														},
	// 														error: function(xhr, status, error) {
	// 															console.log('Error status:', status);
	// 															console.log('Error:', error);
	// 															console.log('Response Text:', xhr.responseText);
	// 														}
	// 													});
	// 												}
	// 												$select.prop('disabled', true); 
	// 											});
	// 										},
	// 										beforeSend: function() {
	// 											$('.preloader-custom').fadeIn('xfast');
	// 										},
	// 										complete: function() {
	// 											$('.preloader-custom').fadeOut('xfast');
	// 										},
	// 										error: function(xhr, status, error) {
	// 											console.error("Error: " + error);
	// 										}
	// 									});
	// 								}
	// 							}
	// 						},
	// 						error: function(xhr, status, error) {
	// 							console.error("Error: " + error);
	// 						}
	// 				});
	// 			}

	// 			if (dtmsubcodetechinf_id != null){
	// 				const dtmitem_id = $(this).closest('tr').find('td:first').text();
	// 				const selector = `td[data-dtmtechinf-id${clickedValue}-${dtmitem_id}]`;
	// 				const value = $(selector).attr(`data-dtmtechinf-id${clickedValue}-${dtmitem_id}`);
	// 				const oldtechvalue = value;

	// 				$.ajax({
	// 						url: '<?php echo base_url() . 'eis/item/autocomplete_techinf_hierarchy?dtmsubcodetechinf_id='?>' + dtmsubcodetechinf_id,
	// 						type: 'GET',
	// 						success: function(response) {
	// 							// Store the result in a variable named techinf{dtmsubcodetechinf_seq}
	// 							const data = JSON.parse(response);
	// 							// Create a dropdown with Select2
	// 							const techinf = data;
	// 							const dropdown = $('<select class="select2-dropdown"></select>');
	// 							techinf.forEach(function(item) {
	// 								dropdown.append(`<option value="${item.dtmsubcodetechinfhierarchy_id}">${item.dtmsubcodetechinfhierarchy_code} | ${item.dtmsubcodetechinfhierarchy_name}</option>`);
	// 							});
								
	// 							// Replace the clicked cell with the dropdown
	// 							$(event.target).html(dropdown);

	// 							// Initialize Select2 on the dropdown
	// 							dropdown.select2({
	// 								placeholder: 'Select an option',
	// 								allowClear: false,
	// 								width: 'style',
	// 								dropdownAutoWidth : true,
	// 								dropdownCssClass: 'select2-dropdown-custom' // Custom class for dropdown
	// 							});

	// 							dropdown.val(clickedValue).trigger('change');
								
	// 							dropdown.on('select2:select', function() {
	// 							var newTechName = null;
	// 							newTechName = $(this).find('option:selected').text();
	// 							splitName = newTechName.split('|');
	// 							newTechName = splitName[1];

	// 							const newValueId = $(this).val();
	// 							const columnIndex = $(this).closest('td').index();
	// 							const dtmitem_id = $(this).closest('tr').find('td:first').text(); // Get old value id for this column index
	// 							const $select = $(this);
								
	// 								if (columnIndex >= 22 && columnIndex <= 27 && selector != `td[data-dtmtechinf-id-${dtmitem_id}]`) {
	// 									$.ajax({
	// 										url: '<?php echo base_url() . $class_link . '/updatemajorfiber'?>',
	// 										type: 'POST',
	// 										data: {
	// 											dtmitem_id: dtmitem_id,
	// 											old_id: oldtechvalue,
	// 											new_value_id: newValueId,
	// 											new_value_name: newTechName,
	// 											dtmsubcodetechinf_id: dtmsubcodetechinf_id
	// 										},
	// 										success: function(response) {
	// 											const responseData = JSON.parse(response);
	// 											if(responseData.status == 200){
	// 												alert(responseData.message);
	// 												$select.prop('disabled', true); 
	// 												submitData(itemIDs)
	// 											}else {
	// 												alert(responseData.message);
	// 												$select.prop('disabled', false); 
	// 											}
	// 										},
	// 										beforeSend: function() {
	// 											$('.preloader-custom').fadeIn('xfast');
	// 										},
	// 										complete: function() {
	// 											$('.preloader-custom').fadeOut('xfast');
	// 										},
	// 										error: function(xhr, status, error) {
	// 											console.log('Error status:', status);
	// 											console.log('Error:', error);
	// 											console.log('Response Text:', xhr.responseText);
	// 										}
	// 									});
	// 								}else {
	// 									$.ajax({
	// 										url: '<?php echo base_url() . $class_link . '/insertmajorfiber'?>',
	// 										type: 'POST',
	// 										data: {
	// 											dtmitem_id: dtmitem_id,
	// 											old_id: oldtechvalue,
	// 											new_value_id: newValueId,
	// 											new_value_name: newTechName,
	// 											dtmsubcodetechinf_id: dtmsubcodetechinf_id
	// 										},
	// 										success: function(response) {
	// 											const responseData = JSON.parse(response);
	// 											if(responseData.status == 200){
	// 												alert(responseData.message);
	// 												$select.prop('disabled', true); 
	// 												submitData(itemIDs)
	// 											}else {
	// 												alert(responseData.message);
	// 												$select.prop('disabled', false); 
	// 											}
	// 										},
	// 										beforeSend: function() {
	// 											$('.preloader-custom').fadeIn('xfast');
	// 										},
	// 										complete: function() {
	// 											$('.preloader-custom').fadeOut('xfast');
	// 										},
	// 										error: function(xhr, status, error) {
	// 											console.log('Error status:', status);
	// 											console.log('Error:', error);
	// 											console.log('Response Text:', xhr.responseText);
	// 										}
	// 									});
	// 								}
	// 								$select.prop('disabled', true); 
	// 							});
	// 						},
	// 						beforeSend: function() {
	// 							$('.preloader-custom').fadeIn('xfast');
	// 						},
	// 						complete: function() {
	// 							$('.preloader-custom').fadeOut('xfast');
	// 						},
	// 						error: function(xhr, status, error) {
	// 							console.log('Error status:', status);
	// 							console.log('Error:', error);
	// 							console.log('Response Text:', xhr.responseText);
	// 						}
	// 					});
	// 			}
	// 	// 	} else {
	// 	// 		alert("Data has been uploaded to the datatex server");
	// 	// 	}
	// 	// }).catch(function(error) {
	// 	// 	console.error("Terjadi kesalahan: " + error);
	// 	// });

	// 		}
	// 	//}
        
    // });
});

</script>

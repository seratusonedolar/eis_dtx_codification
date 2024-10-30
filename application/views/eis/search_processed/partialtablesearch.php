<div class="card-body table-responsive p-0">
	<table id="idTable" class="table table-bordered table-striped table-hover" style="font-size: 80%;">
		<thead>
			<tr style="text-align: center;">
				<th style="background-color: burlywood;">DatatexIT</th>
				<th style="background-color: burlywood;">DatatexCode</th>
				<th style="background-color: burlywood;">DatatexSubcode1 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode1 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode1 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode1 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode1 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode1 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode2 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode2 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode2 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode2 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode2 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode2 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode3 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode3 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode3 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode3 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode3 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode3 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode4 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode4 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode4 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode4 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode4 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode4 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode5 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode5 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode5 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode5 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode5 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode5 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode6 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode6 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode6 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode6 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode6 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode6 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode7 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode7 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode7 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode7 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode7 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode7 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode8 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode8 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode8 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode8 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode8 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode8 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode9 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode9 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode9 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode9 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode9 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode9 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode10 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode10 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode10 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode10 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode10 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode10 Upload Prod</th>
				<th>ItemID</th>
				<th>Classif</th>
				<th>SubClassif</th>
				<th>EISName</th>
				<th>UmID</th>
				<th style="background-color: burlywood;">DatatexUmID</th>
				<th>CreatedBy</th>
				<th>CreatedAt</th>
				<th>UpdatedAt</th>
				<th>ValidatedAt</th>
				<!-- Tech Inf -->
				<?php foreach($techinfsubcode as $eTechinfsubcode): ?>
					<th style="background-color: aqua;"><?php echo "TechInf({$eTechinfsubcode['dtmsubcodetechinf_seq']}) <br>".$eTechinfsubcode['dtmsubcodetechinf_remark']; ?></th>
				<?php endforeach;?>
			</tr>
		</thead>
		<tbody>
			<?php
			$groupDtmitemfilters = array();
			foreach ($dtmitemfilters as $e) {
				$groupDtmitemfilters[$e['dtmitem_id']][] = $e;
				
			}
			// Tech inf
			$groupTechinfData = [];
			foreach($techinfsubcodeData as $eTechinfdata):
				$groupTechinfData[$eTechinfdata['dtmitem_id']][] = $eTechinfdata;
			endforeach;
					
			foreach ($groupDtmitemfilters as $dtmitem_id => $elements) : ?>
			
				<tr>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['dtmsubcode_code'] ?></td>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['dtmitem_code'] ?></td>
					<?php
					$j = 0;
					foreach ($elements as $el) :
						$dtmsubcodehierarchy_name = $el['dtmsubcodehierarchy_name'];
						$dtmsubcodehierarchy_state = $el['dtmsubcodehierarchy_state'];
						$dtmsubcode_note_validate = $el['dtmsubcode_note_validate'];
						$dtmsubcode_upload_qa = $el['dtmsubcode_upload_qa'];
						$dtmsubcode_upload_prod = $el['dtmsubcode_upload_prod'];
						if ($el['dtmsubcodedtl_type'] == 'TEXT') {
							$dtmsubcodehierarchy_name = $el['dtmitemdtl_code'];
							$dtmsubcodehierarchy_state = 'confirmed';
						}
						$span = 'success';
						if ($dtmsubcodehierarchy_state != 'confirmed') {
							$span = 'warning';
						}
						if ($dtmsubcode_note_validate != null){
							$dtmsubcode_note_validate_state = 'confirmed';
						}
						$dtmsubcode_note_validate_state = 'NA';

						if ($dtmsubcode_upload_qa != null){
							$dtmsubcode_upload_qa_state = 'confirmed';
						}
						$dtmsubcode_upload_qa_state = 'NA';
						
						if ($dtmsubcode_upload_prod != null){
							$dtmsubcode_upload_prod_state = 'confirmed';
						}
						$dtmsubcode_upload_prod_state = 'NA';

					?>
						<td><?= $el['dtmitemdtl_code'] ?>
						</td>
						<td><?= $dtmsubcodehierarchy_name; ?>
						</td>
						<td>
						<span class="badge bg-<?= $span ?>"><?= $dtmsubcodehierarchy_state ?></span>
						</td>
						<td>
							<?= $dtmsubcode_note_validate_state; ?>
						</td>
						<td>
							<?= $dtmsubcode_upload_qa_state; ?>
						</td>
						<td>
							<?= $dtmsubcode_upload_prod_state; ?>
						</td>
					<?php
						$j++;
					endforeach; ?>
					<!-- Check for subcode not 10 -->
					<?php
					if ($j < 10) :
						for ($jj = 0; $jj < (10 - $j); $jj++) :
					?>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
					<?php
						endfor;
					endif;
					?>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['item_id'] ?></td>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['classname']?></td>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['subclassname']?></td>
					<td style="font-size: 90%;"><?= substr($groupDtmitemfilters[$dtmitem_id][0]['name'],0,50).'...' ?></td>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['um_id'] ?></td>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['dtmitem_uom_id'] ?></td>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['dtmitem_created_by'] ?></td>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['dtmitem_created_at'] ?></td>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['dtmitem_updated_at'] ?></td>
					<td><?= $groupDtmitemfilters[$dtmitem_id][0]['dtmitem_validated_at'] ?></td>
					<!-- Tech Inf -->
					<?php 
					if(isset($groupTechinfData[$dtmitem_id])):
						$k = 0;
						foreach($groupTechinfData[$dtmitem_id] as $techinfdtmitemid => $techinfElements):?>
							<td><?php echo !empty($techinfElements['dtmsubcodetechinfhierarchy_code']) ? $techinfElements['dtmsubcodetechinfhierarchy_code'].' | '.$techinfElements['dtmsubcodetechinfhierarchy_name'] : null; ?></td>
					<?php 
							$k++;
						endforeach;
					else:
						$k = 0;
						for($ll=0; $ll<(count($techinfsubcode)); $ll++):
							$k++;
						?>
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
				</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr style="text-align: center;">
				<th style="background-color: burlywood;">DatatexIT</th>
				<th style="background-color: burlywood;">DatatexCode</th>
				<th style="background-color: burlywood;">DatatexSubcode1 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode1 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode1 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode1 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode1 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode1 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode2 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode2 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode2 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode2 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode2 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode2 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode3 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode3 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode3 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode3 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode3 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode3 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode4 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode4 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode4 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode4 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode4 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode4 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode5 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode5 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode5 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode5 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode5 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode5 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode6 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode6 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode6 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode6 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode6 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode6 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode7 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode7 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode7 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode7 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode7 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode7 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode8 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode8 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode8 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode8 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode8 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode8 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode9 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode9 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode9 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode9 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode9 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode9 Upload Prod</th>
				<th style="background-color: burlywood;">DatatexSubcode10 Code</th>
				<th style="background-color: burlywood;">DatatexSubcode10 Desc</th>
				<th style="background-color: burlywood;">DatatexSubcode10 Status</th>
				<th style="background-color: burlywood;">DatatexSubcode10 Validate</th>
				<th style="background-color: burlywood;">DatatexSubcode10 Upload QA</th>
				<th style="background-color: burlywood;">DatatexSubcode10 Upload Prod</th>
				<th>ItemID</th>
				<th>Classif</th>
				<th>SubClassif</th>
				<th>EISName</th>
				<th>UmID</th>
				<th style="background-color: burlywood;">DatatexUmID</th>
				<th>CreatedBy</th>
				<th>CreatedAt</th>
				<th>UpdatedAt</th>
				<th>ValidatedAt</th>
				<!-- Tech Inf -->
				<?php foreach($techinfsubcode as $eTechinfsubcode2): ?>
					<th style="background-color: aqua;"><?php echo "TechInf({$eTechinfsubcode2['dtmsubcodetechinf_seq']})".$eTechinfsubcode2['dtmsubcodetechinf_remark']; ?></th>
				<?php endforeach;?>
			</tr>
		</tfoot>
	</table>
</div>

<script type="text/javascript">
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
        "autoWidth": false,
        // "serverSide": true,
        "scrollX": true,
        "scrollY": "250",
    //     "select": true,
        // "pageLength": 50,
    //     "lengthMenu": [50, 100, 150, 200, 250],
    //     "fixedColumns": {
    //         left: 4,
    //     },
    //     "ajax": "<?php echo base_url() . $class_link; ?>/ajax",
    //     "order": [17, 'desc'],

        "initComplete": function() {
            // Apply the search
            this.api()
                .columns()
                .every(function() {
                    var that = this;

                    $('input', this.footer()).on('keyup', function(e) {
                        // if (e.keyCode == 13) {
                            if (that.search() !== this.value) {
                                that.search(this.value).draw();
                            }
                        // }
                    });
                });
        },

    //     "columnDefs": [{
    //             "searchable": false,
    //             "orderable": true,
    //             "targets": [16, 17]
    //         },
    //         //     {
    //         //         "searchable": false,
    //         //         "orderable": false,
    //         //         "targets": 1,
    //         //         "data": null,
    //         //         "render": function(data, type, row, meta) {
    //         //             var dt = Object.entries(data[1]);
    //         //             var html = 
    //         //                 `<div class="btn-group">
    //         //                     <button type="button" class="btn btn-sm btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"> \n
    //         //                     Act <span class="sr-only">Toggle Dropdown</span>
    //         //                 </button>
    //         //                 <div class="dropdown-menu" role="menu">`;
    //         //             for (var i=0; i < dt.length; i++){
    //         //                 html += `<a class="dropdown-item" href="javascript:void(0)" onclick="`+dt[i][1]+`">`+dt[i][0]+`</a>`;
    //         //             }
    //         //             html += `</div>`;
    //         //             return html;
    //         //         }
    //         //     },
    //         //     {
    //         //         "targets": [4, 5, 6],
    //         //         className: 'dt-body-right'
    //         //     }
    //     ],
	"dom": 'Blfrtip',
        "buttons": [
            'excel',
            //     // {
            //     //     extend: 'collection',
            //     //     text: 'Action',
            //     //     buttons: [{
            //     //             text: 'Edit',
            //     //             action: function(e, dt, node, config) {
            //     //                 alert('Button Edit');
            //     //             }
            //     //         },
            //     //         {
            //     //             text: 'Sync',
            //     //             action: function(e, dt, node, config) {
            //     //                 alert('Button Sync');
            //     //             }
            //     //         }
            //     //     ]

            //     // }
        ]
    });
</script>

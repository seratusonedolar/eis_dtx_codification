<div class="card-body table-responsive p-0">
	<table id="idTable" class="table table-bordered table-striped table-hover" style="font-size: 80%;">
		<thead>
			<tr style="text-align: center;">
				<th style="background-color: burlywood;">code</th>
				<th style="background-color: burlywood;">buyerstyle_subcode1</th>
				<th style="background-color: burlywood;">buyer_subcode2</th>
				<th style="background-color: burlywood;">season_subcode3</th>
				<th style="background-color: burlywood;">productsegment_subcode4</th>
				<th style="background-color: burlywood;">productcategory_subcode5</th>
				<th style="background-color: burlywood;">producttype_subcode6</th>
				<th style="background-color: burlywood;">destination_subcode7</th>
				<th style="background-color: burlywood;">inseam_subcode8</th>
				<th style="background-color: burlywood;">color_subcode9</th>
				<th style="background-color: burlywood;">size_subcode10</th>
				<th style="background-color: burlywood;">order_no</th>
				<th style="background-color: burlywood;">wo_no</th>
				<th style="background-color: burlywood;">data_type</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($result as $item): ?>
            <tr>
                <td><?php echo $item['fulldesc']; ?></td>
                <td><?php echo $item['sub1_buyerstyle']; ?></td>
                <td><?php echo $item['sub2_buyer']; ?></td>
                <td><?php echo $item['sub3_season']; ?></td>
                <td><?php echo $item['sub4_prodsegment']; ?></td>
                <td><?php echo $item['sub5_prodcategory']; ?></td>
                <td><?php echo $item['sub6_prodtype']; ?></td>
                <td><?php echo $item['sub7_destination']; ?></td>
                <td><?php echo $item['sub8_inseam']; ?></td>
                <td><?php echo $item['sub9_color']; ?></td>
                <td><?php echo $item['sub10_size']; ?></td>
                <td><?php echo $item['order_no']; ?></td>
                <td><?php echo $item['wo_no']; ?></td>
                <td><?php echo $item['dtscfinhie_type']; ?></td>
            </tr>
            <?php endforeach; ?>
		</tbody>
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
	"dom": 'Blfrtip',
        "buttons": [
            'excel',
        ]
    });
</script>

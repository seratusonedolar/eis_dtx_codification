<div class="card-body table-responsive p-0">
<table id="idTable" class="table table-bordered table-striped table-hover" style="font-size: 80%;">
				<thead>
					<tr style="text-align: center;">
						<th style="background-color: burlywood;">Item Type</th>
						<th style="background-color: burlywood;">Item ID</th>
						<th style="background-color: burlywood;">Datatex Sequence</th>
						<th style="background-color: burlywood;">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($dictionary)): ?>
						<?php foreach ($dictionary as $row): ?>
							<tr>
								<td><?php echo htmlspecialchars($row['itemtypecode']); ?></td>
								<td><?php echo htmlspecialchars($row['item_id']); ?></td>
								<td style="text-align: center;"><?php echo htmlspecialchars($row['dtxsequence'] !== null ? $row['dtxsequence'] : '-'); ?></td>
								<td style="text-align: center;"><?php echo htmlspecialchars($row['status_subcode']); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="4" style="text-align: center;">No data available</td>
						</tr>
					<?php endif; ?>
				</tbody>
				<tfoot>
					<tr style="text-align: center;">
					<th style="background-color: burlywood;">Item Type</th>
					<th style="background-color: burlywood;">Item ID</th>
					<th style="background-color: burlywood;">Datatex Sequence</th>
					<th style="background-color: burlywood;">Status</th>
					</tr>
				</tfoot>
			</table>
</div>

<script type="text/javascript">
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
        "autoWidth": false,
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
});
</script>

<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- Default box -->
<div class="card-body table-responsive p-0">
    <table id="idTableProcessed" class="table table-bordered table-striped table-hover" style="font-size: 75%;">
        <thead>
            <tr style="text-align: center;">
                <th style="background-color: burlywood;">#</th>
                <th style="background-color: burlywood;">DatatechCode</th>
                <th style="background-color: burlywood;">DatatechClassif</th>
                <th>ItemID</th>
                <th>Buyers</th>
                <th>Classif</th>
                <th>SubClassif</th>
                <th>ContentName</th>
                <th>Material</th>
                <th>ReferenceName</th>
                <th>ColorName</th>
                <th>ConstructionName</th>
                <th>SpecType</th>
                <th>SpecName</th>
                <th>ItemType</th>
                <th>Source</th>
                <th>UmID</th>
                <th>CreatedBy</th>
                <th>CreatedAt</th>
            </tr>
        </thead>
        <tfoot>
            <tr style="text-align: center;">
                <th>#</th>
                <th>DatatechCode</th>
                <th>DatatechClassif</th>
                <th>ItemID</th>
                <th>Buyers</th>
                <th>Classif</th>
                <th>SubClassif</th>
                <th>ContentName</th>
                <th>Material</th>
                <th>ReferenceName</th>
                <th>ColorName</th>
                <th>ConstructionName</th>
                <th>SpecType</th>
                <th>SpecName</th>
                <th>ItemType</th>
                <th>Source</th>
                <th>UmID</th>
                <th>CreatedBy</th>
                <th>CreatedAt</th>
            </tr>
        </tfoot>
    </table>
</div>
<!-- /.card-body -->

<script type="text/javascript">
    // Setup - add a text input to each footer cell
    $('#idTableProcessed tfoot th').each(function() {
        var title = $(this).text();
        if (title != '#' && title != 'CreatedBy' && title != 'CreatedAt') {
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        }
    });

    var tblBatch = $("#idTableProcessed").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "search": {
            return: true,
        },
        "seacrhDelay": 500,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "serverSide": true,
        "scrollX": true,
        "scrollY": "250",
        "select": true,
        "pageLength": 50,
        "lengthMenu": [50, 100, 150, 200, 250],
        "fixedColumns": {
            left: 2,
        },
        "ajax": {
            url: "<?php echo base_url() . $class_link; ?>/ajax_itemprocessed",
            async: false,
        },
        "order": [17, 'desc'],

        "initComplete": function() {
            // Apply the search
            this.api()
                .columns()
                .every(function() {
                    var that = this;

                    $('input', this.footer()).on('keydown', function(e) {
                        if (e.keyCode == 13) {
                            e.preventDefault();
                        }
                    });
                    $('input', this.footer()).on('keyup', function(e) {
                        if (e.keyCode == 13) {
                            if (that.search() !== this.value) {
                                that.search(this.value).draw();
                            }
                        }
                    });
                });
        },

        "columnDefs": [
            {
                "searchable": false,
                "orderable": true,
                "targets": [0, 17, 18]
            },
        //     {
        //         "searchable": false,
        //         "orderable": false,
        //         "targets": 1,
        //         "data": null,
        //         "render": function(data, type, row, meta) {
        //             var dt = Object.entries(data[1]);
        //             var html = 
        //                 `<div class="btn-group">
        //                     <button type="button" class="btn btn-sm btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"> \n
        //                     Act <span class="sr-only">Toggle Dropdown</span>
        //                 </button>
        //                 <div class="dropdown-menu" role="menu">`;
        //             for (var i=0; i < dt.length; i++){
        //                 html += `<a class="dropdown-item" href="javascript:void(0)" onclick="`+dt[i][1]+`">`+dt[i][0]+`</a>`;
        //             }
        //             html += `</div>`;
        //             return html;
        //         }
        //     },
        //     {
        //         "targets": [4, 5, 6],
        //         className: 'dt-body-right'
        //     }
        ],
    });

    function reload_tableBatch() {
        tblBatch.ajax.reload();
    }
</script>
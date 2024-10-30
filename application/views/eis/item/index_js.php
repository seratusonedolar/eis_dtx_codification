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
            left: 3,
        },
        "ajax": "<?php echo base_url() . $class_link; ?>/ajax",

        "initComplete": function() {
            // Apply the search
            this.api()
                .columns()
                .every(function() {
                    var that = this;

                    $('input', this.footer()).on('keyup', function(e) {
                        if (e.keyCode == 13) {
                            if (that.search() !== this.value) {
                                that.search(this.value).draw();
                            }
                        }
                    });
                });
        },

        // "columnDefs": [{
        //         "searchable": false,
        //         "orderable": true,
        //         "targets": 0
        //     },
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
        // ],
    });

    function reload_table() {
        tbl.ajax.reload();
    }

    function edit_data(item_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/form_main'; ?>',
            data: {
                item_id: item_id
            },
            success: function(html) {
                toggle_modal(item_id, html);
            }
        });
    }

    function formbatch_main() {
        event.preventDefault();
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/formbatch_main'; ?>',
            success: function(html) {
                toggle_modal('Batch Process', html);
            }
        });
    }

    function toggle_modal(modalTitle, htmlContent) {
        $('#modal-lg').modal('toggle');
        $('.modal-title').text(modalTitle);
        $('#idmodalbody').html(htmlContent);
    }

    function toggle_modal_warning(modalTitle, htmlContent) {
        $('#modal-warning').modal('toggle');
        $('#idmodalwarning-title').text(modalTitle);
        $('#idmodalwarning-body').html(htmlContent);
    }
</script>
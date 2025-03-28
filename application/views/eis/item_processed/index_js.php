<script type="text/javascript">
    // Setup - add a text input to each footer cell
    $('#idTable tfoot th').each(function() {
        var title = $(this).text();
        if ((title != 'CreatedBy') && (title != 'CreatedAt') && (title != 'UpdatedAt') && (title != 'ValidatedAt')) {
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        }
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
            left: 4,
        },
        "ajax": "<?php echo base_url() . $class_link; ?>/ajax",
        "order": [19, 'desc'],

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

        "columnDefs": [{
                "searchable": false,
                "orderable": true,
                "targets": [16, 17, 18]
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

    function reload_table() {
        tbl.ajax.reload();
    }

    function view_data(dtmitem_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/form_main'; ?>',
            data: {
                dtmitem_id: dtmitem_id
            },
            success: function(html) {
                toggle_modal('Datatech Item Form', html);
            }
        });
    }

    function delete_batch() {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/tablebatch_main'; ?>',
            success: function(html) {
                toggle_modal('Delete Batch', html);
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

    function toastAlert(type, title) {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        switch (type) {
            case 'success':
                toastr.success(title);
                break;
            case 'info':
                toastr.info(title);
                break;
            case 'warning':
                toastr.warning(title);
                break;
            default:
                toastr.error(title);
        }
    }
</script>

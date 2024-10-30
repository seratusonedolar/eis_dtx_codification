<script type="text/javascript">
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
        "fixedColumns": {
            left: 3,
        },
        "ajax": "<?php echo base_url() . $class_link; ?>/ajax",

        "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": [0, 3],
            },
            //     {
            //         "targets": 1,
            //         "data": "dtmrole_name",
            //     },
            //     {
            //         "targets": 2,
            //         "data": "dtmrole_desc",
            //     },
            //     {
            //         "targets": 3,
            //         "data": "dtmrole_is_active",
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
        ],
    });

    function reload_table() {
        tbl.ajax.reload();
    }

    function detail_rolepermission(dtmrole_id) {
        window.location.assign("<?php echo base_url() . $class_link; ?>/permission?dtmrole_id=" + dtmrole_id);
    }

    function detail_roleuser(dtmrole_id) {
        window.location.assign("<?php echo base_url() . $class_link; ?>/user?dtmrole_id=" + dtmrole_id);
    }

    function role_form(slug, dtmrole_id = '') {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/role_form'; ?>',
            data: {
                slug: slug,
                dtmrole_id: dtmrole_id
            },
            success: function(html) {
                toggle_modal(slug.toUpperCase(), html);
            }
        });
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

    function delete_role(dtmrole_id) {
        var conf = confirm('Are you sure ?');
        if (conf) {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() . $class_link . '/action_delete_role'; ?>',
                data: {
                    dtmrole_id: dtmrole_id
                },
                success: function(data) {
                    if (data.code == 200) {
                        toastAlert('success', data.messages);
                        reload_table();
                    } else {
                        toastAlert('error', data.messages);
                    }
                }
            });
        }
    }

    function toggle_modal(modalTitle, htmlContent) {
        $('#modal-lg').modal('toggle');
        $('.modal-title').text(modalTitle);
        $('#idmodalbody').html(htmlContent);
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
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
        "ajax": {
            "url": "<?php echo base_url() . $class_link; ?>/user_ajax?dtmrole_id=<?php echo $dtmrole_id; ?>",
            "async": false
        },

        "columnDefs": [{
                "searchable": false,
                "targets": [0,1,3],
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
        "order": [
            [3, 'desc']
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

    user_form('<?php echo $dtmrole_id; ?>');

    function user_form(dtmrole_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/user_form'; ?>',
            data: {
                dtmrole_id: dtmrole_id
            },
            success: function(html) {
                $('#idroleuserform').html(html);
            }
        });
    }

    function delete_data(dtmroleuser_id) {
        var conf = confirm('Are you sure ?');
        if (conf) {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() . $class_link . '/action_delete_roleuser'; ?>',
                data: {
                    dtmroleuser_id: dtmroleuser_id
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
</script>
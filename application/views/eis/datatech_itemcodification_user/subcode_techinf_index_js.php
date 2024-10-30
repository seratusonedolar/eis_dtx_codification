<script type="text/javascript">
    // Setup - add a text input to each footer cell
    $('#idTable tfoot th').each(function(e) {
        let columnAllowedFilter = [1, 2];
		if (columnAllowedFilter.includes(e)){
            var title = $(this).text();
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
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "serverSide": true,
        "scrollX": true,
        "scrollY": "250",
        "select": true,
        "ajax": {
            "url": "<?php echo base_url() . $class_link; ?>/subcode_techinf_ajax?id=<?php echo $id ?>",
            "async": false
        },
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
            "targets": [0, 3, 4]
        }, ],
        order: [
            [4, 'desc']
        ]
    });

    subcode_techinfhierarchy_form('add', '<?php echo $id; ?>', '');

    function subcode_techinfhierarchy_form(slug, dtmsubcodetechinf_id, dtmsubcodetechinfhierarchy_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/subcode_techinfhierarchy_form'; ?>',
            async: false,
            data: {
                slug: slug,
                dtmsubcodetechinf_id: dtmsubcodetechinf_id,
                dtmsubcodetechinfhierarchy_id: dtmsubcodetechinfhierarchy_id
            },
            success: function(html) {
                $('#idsubcodehierarchyform').html(html);
            }
        });
    }

    function subcode_techinfhierarchy_formbatch(dtmsubcodetechinf_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/subcode_techinfhierarchy_formbatch'; ?>',
            async: false,
            data: {
                slug: 'add',
                dtmsubcodetechinf_id: dtmsubcodetechinf_id
            },
            success: function(html) {
                toggle_modal('Form batch', html);
            }
        });
    }

    function reload_table() {
        tbl.ajax.reload();
    }

    function edit_data(dtmsubcodetechinfhierarchy_id) {
        subcode_techinfhierarchy_form('edit', '<?php echo $id; ?>', dtmsubcodetechinfhierarchy_id);
        $('#dtmsubcodetechinfhierarchy_code').focus();
    }

    function delete_data(dtmsubcodetechinfhierarchy_id) {
        var conf = confirm('Are you sure ?');
        if (conf) {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() . $class_link . '/action_delete_techinfhierarchy'; ?>',
                data: {
                    dtmsubcodetechinfhierarchy_id: dtmsubcodetechinfhierarchy_id
                },
                success: function(data) {
                    if (data.code == 200) {
                        toastAlert('success', data.messages);
                        reload_table();
                    } else {
                        toastAlert('error', data.messages);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    toastAlert('error', thrownError);
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
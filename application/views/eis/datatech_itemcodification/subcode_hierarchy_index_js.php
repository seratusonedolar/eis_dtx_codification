<script type="text/javascript">
    // Setup - add a text input to each footer cell
    $('#idTable tfoot th').each(function(e) {
        let columnAllowedFilter = [1, 2, 4];
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
            "url": "<?php echo base_url() . $class_link; ?>/subcode_hierarchy_ajax?id=<?php echo $id ?>",
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
            "targets": [0, 3, 5]
        }, ],
        order: [
            [5, 'desc']
        ]
    });

    subcode_hierarchy_form('<?php echo $slug; ?>', '<?php echo $id; ?>', '', '<?php echo urlencode($dtmsubcodehierarchy_name); ?>');

    function subcode_hierarchy_form(slug, dtmsubcode_id, dtmsubcodehierarchy_id = null, dtmsubcodehierarchy_name = '') {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/subcode_hierarchy_form'; ?>',
            async: false,
            data: {
                slug: slug,
                dtmsubcode_id: dtmsubcode_id,
                dtmsubcodehierarchy_id: dtmsubcodehierarchy_id,
                dtmsubcodehierarchy_name: dtmsubcodehierarchy_name
            },
            success: function(html) {
                $('#idsubcodehierarchyform').html(html);
            }
        });
    }

    function subcode_hierarchy_formbatch(dtmsubcode_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/subcode_hierarchy_formbatch'; ?>',
            async: false,
            data: {
                slug: 'add',
                dtmsubcode_id: dtmsubcode_id
            },
            success: function(html) {
                toggle_modal('Form batch', html);
            }
        });
    }

    function reload_table() {
        tbl.ajax.reload();
    }

    function edit_data(dtmsubcodehierarchy_id) {
        subcode_hierarchy_form('edit', '<?php echo $id; ?>', dtmsubcodehierarchy_id);
        $('#iddtmsubcodehierarchy_code').focus();
    }

    function delete_data(dtmsubcodehierarchy_id) {
        var conf = confirm('Are you sure ?');
        if (conf) {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() . $class_link . '/action_delete_hierarchy'; ?>',
                data: {
                    dtmsubcodehierarchy_id: dtmsubcodehierarchy_id
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
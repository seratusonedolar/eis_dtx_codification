<script type="text/javascript">
    var tbl = $("#idTable").DataTable({
        "paging": false,
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
            "url": "<?php echo base_url() . $class_link; ?>/subcode_detail_ajax?id=<?php echo $id ?>",
            "async": false
        },
        "columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": [0, 3, 4]
        }, ],
        order: [
            [1, 'asc']
        ]
    });

    var tbl_techinformation = $("#idTabletechinformation").DataTable({
        "paging": false,
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
            "url": "<?php echo base_url() . $class_link; ?>/subcode_techinformation_ajax?id=<?php echo $id ?>",
            "async": false
        },
        "columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": [0, 3]
        }, ],
        order: [
            [1, 'asc']
        ]
    });

    subcode_detail_form('add', '<?php echo $id; ?>', '');
    subcode_techinformation_form('add', '<?php echo $id; ?>', '')

    function subcode_detail_form(slug, dtmsubcode_id, dtmsubcodedtl_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/subcode_detail_form'; ?>',
            async: false,
            data: {
                slug: slug,
                dtmsubcode_id: dtmsubcode_id,
                dtmsubcodedtl_id: dtmsubcodedtl_id
            },
            success: function(html) {
                $('#idsubcodedetailform').html(html);
            }
        });
    }

    function subcode_techinformation_form(slug, dtmsubcode_id, dtmsubcodetechinf_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/subcode_techinformation_form'; ?>',
            async: false,
            data: {
                slug: slug,
                dtmsubcode_id: dtmsubcode_id,
                dtmsubcodetechinf_id: dtmsubcodetechinf_id
            },
            success: function(html) {
                $('#idsubcodetechinformationform').html(html);
            }
        });
    }

    function reload_table() {
        tbl.ajax.reload();
    }

    function reload_table_techinformation() {
        tbl_techinformation.ajax.reload();
    }

    function edit_data(dtmsubcodedtl_id) {
        subcode_detail_form('edit', '<?php echo $id; ?>', dtmsubcodedtl_id);
        $('#iddtmsubcodedtl_seq').focus();
    }

    function delete_data(dtmsubcodedtl_id) {
        var conf = confirm('Are you sure ?');
        if (conf) {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() . $class_link . '/action_delete_detail'; ?>',
                data: {
                    dtmsubcodedtl_id: dtmsubcodedtl_id
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

    function delete_data_techinf(dtmsubcodetechinf_id) {
        var conf = confirm('Are you sure ?');
        if (conf) {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() . $class_link . '/action_delete_data_techinf'; ?>',
                data: {
                    dtmsubcodetechinf_id: dtmsubcodetechinf_id
                },
                success: function(data) {
                    if (data.code == 200) {
                        toastAlert('success', data.messages);
                        reload_table_techinformation();
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
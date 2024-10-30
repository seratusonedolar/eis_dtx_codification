<script type="text/javascript">
    render_subcode('iddtmsubcode_id1', 1, '<?php echo $selected['dtmsubcode_id']; ?>');
    parent_formmain('<?php echo isset($slug) ? $slug : 'ADD'; ?>', '<?php echo isset($parent_item_id_base64) ? $parent_item_id_base64 : null; ?>', '<?php echo isset($dtmitem_id) ? $dtmitem_id : null; ?>');
    processed_item('<?php echo $dtmitem_id; ?>');

    function parent_formmain(slug, parent_item_id, dtmitem_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/parent_formmain'; ?>',
            data: {
                slug: slug,
                parent_item_id: parent_item_id,
                dtmitem_id: dtmitem_id
            },
            success: function(html) {
                $('#idvwparentformmain').html(html);
            }
        });
    }

    function processed_item(dtmitem_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . '/eis/item_processed/form_main'; ?>',
            data: {
                slug: 'VIEW',
                dtmitem_id: dtmitem_id
            },
            success: function(html) {
                $('#idvwprocesseditem').html(html);
            }
        });
    }

    function render_subcode(attributID, dtmsubcode_level, dtmsubcode_parent) {
        $("#" + attributID).select2({
            theme: 'bootstrap4',
            placeholder: '--Select Option--',
            minimumInputLength: 0,
            ajax: {
                url: '<?php echo base_url(); ?>/eis/datatech_itemcodification/autocomplete_subcode?dtmsubcode_level=' + dtmsubcode_level + '&dtmsubcode_parent=' + dtmsubcode_parent,
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        param_search: params.term,
                    };
                },
                processResults: function(response) {
                    return {
                        results: $.map(response, function(item) {
                            return {
                                id: item.dtmsubcode_id,
                                text: item.dtmsubcode_code + ' | ' + item.dtmsubcode_name
                            };
                        })
                    };
                },
                cache: false
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
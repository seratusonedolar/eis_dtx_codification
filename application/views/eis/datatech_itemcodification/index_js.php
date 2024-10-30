<script type="text/javascript">
    function form_main(slug, dtmsubcode_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . $class_link . '/form_main'; ?>',
            data: {
                slug: slug,
                dtmsubcode_id: dtmsubcode_id
            },
            success: function(html) {
                toggle_modal(slug, html);
            }
        });
    }

    function toggle_modal(modalTitle, htmlContent) {
        $('#modal-lg').modal('toggle');
        $('.modal-title').text(modalTitle);
        $('#idmodalbody').html(htmlContent);
    }
</script>
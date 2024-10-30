<?php
defined('BASEPATH') or exit('No direct script access allowed');

$dataJS['class_link'] = $class_link;
// $this->load->section('scriptJS', $class_link . '/index_js', $dataJS);

?>
<div class="row">
    <div class="col-md-12">
        <?php foreach ($itemChilds['result'] as $e) : ?>
            <div class="card card-secondary collapsed-card">
                <!-- <div class="overlay">
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
            </div> -->
                <div class="card-header">
                    <h3 class="card-title"><?php echo $e['item_id']; ?></h3>
                    <div class="card-tools">
                        <button class="btn btn-xs btn-info" id="idbtnsync"> <i class="fas fa-save"></i> Save </button>
                        <button type="button" class="btn btn-tool clviewedit" data-card-widget="collapse" data-dtscopeitem_id="<?php echo $e['dtscopeitem_id']; ?>">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                </div>
                <div class="card-body" style="height: 250px; overflow-y: auto;">

                    <div id="idformbatch<?php echo ($e['dtscopeitem_id']); ?>"></div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- <div id="tt"></div> -->
    </div>
</div>

<script type="text/javascript">
    $('.clviewedit').click(function() {
        let dtscopeitem_id = $(this).data("dtscopeitem_id");
        formedit_main('<?php echo $dtmitem_id; ?>', 'idformbatch' + dtscopeitem_id);
    });

    // from ItemProcessd
    function formedit_main(dtmitem_id, elementId) {
        $('.preloader-custom').fadeIn('xfast');
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . 'eis/item_processed/formedit_main'; ?>',
            data: {
                dtmitem_id: dtmitem_id
            },
            success: function(html) {
                $('#' + elementId).html(html);
            },
            complete: function() {
                $('.preloader-custom').fadeOut('xfast');
            }
        });
    }
</script>
<?php
defined('BASEPATH') or exit('No direct script access allowed');

$dataJS['class_link'] = $class_link;
$dataJS['selected'] = $selected;
$dataJS['slug'] = $slug;
$dataJS['dtmitem_id'] = $dtmitem_id;
$dataJS['parent_item_id_base64'] = $parent_item_id_base64;
$this->load->section('scriptJS', $class_link . '/parent_js', $dataJS);

?>
<style type="text/css">
    .modal-dialog {
        width: 1800px;
    }
</style>
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Process Same ParentID</h3>

        <div class="card-tools">
            <!-- <button class="btn btn-tool" title="Removed Data" onclick="window.location.assign('<?php echo base_url() . $class_link ?>/trash')"> <i class="fas fa-trash"></i> </button> -->
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <button class="btn btn-sm btn-warning" id="idbtnsync" onclick="window.location.reload()"> <i class="fas fa-sync"></i> Refresh </button>
        <hr>
        <div class="row">
            <h5>Processed Item:</h5>
            <div class="col-md-12">
                <div class="card card-primary collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $datatex_item['item_id']; ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                    </div>
                    <div class="card-body" style="height: 250px; overflow-y: auto;">
                        <div id="idvwprocesseditem"></div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <!-- <div class="card bg-secondary collapsed-card" style="font-size: 90%;">
            <div class="card-header">
                <h3 class="card-title">Hint</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <ul>
                    <li>Select the <strong>Checkbox</strong> items to process</li>
                    <li>Press <strong>Search Size</strong> and <strong>Search Color</strong>, if already exist will be selected in the all option already Checkbox selected</li>
                    <li>Press <strong>+</strong> button if no Color/Size exist, and create new item hierarchy for the item</li>
                    <li>Press <strong>Search Size</strong> and <strong>Search Color</strong> again, system will search the new item and set to selected</li>
                    <li>Submit <strong>Save</strong> button, will submit only <strong>Checked</strong> item</li>
                </ul>
            </div>
        </div> -->
        <h5>Outstanding Item:</h5>
        <div id="idvwparentformmain"></div>

    </div>
    <!-- /.card-body -->
    <div class="card-footer">
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->

<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Large Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="idmodalbody"></div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Warning Modal -->
<div class="modal fade" id="modal-warning">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-warning">
            <div class="modal-header">
                <h4 class="modal-title" id="idmodalwarning-title">Warning Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="idmodalwarning-body"></div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
defined('BASEPATH') or exit('No direct script access allowed');

$dataJS['class_link'] = $class_link;
$this->load->section('scriptJS', $class_link . '/index_js', $dataJS);

?>
<style type="text/css">
    .modal-dialog {
        width: 1800px;
    }
</style>
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">EIS Item Unprocess</h3>

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
        <?php if (checkPermission('MASTERITEM.EIS.INSERTBATCH')) : ?>
            <button class="btn btn-sm btn-secondary" id="idbtnbatchprocess" onclick="formbatch_main()"> <i class="fas fa-list"></i> Batch Process </button>
        <?php endif; ?>
        <hr>
        <div class="card-body table-responsive p-0">
            <table id="idTable" class="table table-bordered table-striped table-hover" style="font-size: 80%;">
                <thead>
                    <tr style="text-align: center;">
                        <th>ItemID</th>
                        <th style="background-color: burlywood;">Buyers</th>
                        <th style="background-color: burlywood;">MainCategoryEIS</th>
                        <th>Classif</th>
                        <th>SubClassif</th>
                        <th>ContentName</th>
                        <th>Material</th>
                        <th>ReferenceName</th>
                        <th>ColorName</th>
                        <th>ConstructionName</th>
                        <th>SpecType</th>
                        <th>SpecName</th>
                        <th>ItemType</th>
                        <th>Source</th>
                        <th>UmID</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr style="text-align: center;">
                        <th>ItemID</th>
                        <th>Buyers</th>
                        <th>MainCategoryEIS</th>
                        <th>Classif</th>
                        <th>SubClassif</th>
                        <th>ContentName</th>
                        <th>Material</th>
                        <th>ReferenceName</th>
                        <th>ColorName</th>
                        <th>ConstructionName</th>
                        <th>SpecType</th>
                        <th>SpecName</th>
                        <th>ItemType</th>
                        <th>Source</th>
                        <th>UmID</th>
                    </tr>
                </tfoot>
            </table>
        </div>
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
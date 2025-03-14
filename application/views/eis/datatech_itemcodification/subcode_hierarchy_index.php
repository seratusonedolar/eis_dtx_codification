<?php
defined('BASEPATH') or exit('No direct script access allowed');

$dataJS['class_link'] = $class_link;
$dataJS['id'] = $id;
$dataJS['slug'] = $slug;
$dataJS['dtmsubcodehierarchy_name'] = $dtmsubcodehierarchy_name;

$this->load->section('scriptJS', $class_link . '/subcode_hierarchy_index_js', $dataJS);
?>
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Subcode Hierarchy </h3>

        <div class="card-tools">
            <?php if (checkPermission('MASTERITEM.CODIFICATION.INSERTBATCH')) : ?>
                <button class="btn btn-sm btn-default" onclick="subcode_hierarchy_formbatch('<?= $id ?>')"> <i class="fa fa-upload"></i> Batch</button>
            <?php endif; ?>
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">

            <div class="col-sm-5">
                <h6> <strong> <u> <?php echo !empty($caption) ? $caption : '-'; ?> </u></strong> </h6>
                <div id="idsubcodehierarchyform"></div>
            </div>

            <div class="col-sm-7">
                <div class="card-body table-responsive p-0">
                    <table id="idTable" class="table table-bordered table-striped table-hover" style="font-size: 90%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th>HierarchyID</th>
								<th>ID</th>
                                <th>HierarchyCode</th>
                                <th>HierarchyName</th>
                                <th>IsActive</th>
                                <th>State</th>
                                <th>UpdatedAt</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr style="text-align: center;">
                                <th>HierarchyID</th>
								<th>ID</th>
                                <th>HierarchyCode</th>
                                <th>HierarchyName</th>
                                <th>IsActive</th>
                                <th>State</th>
                                <th>UpdatedAt</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
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

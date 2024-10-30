<?php
defined('BASEPATH') or exit('No direct script access allowed');

$dataJS['class_link'] = $class_link;
$dataJS['id'] = $id;
$this->load->section('scriptJS', $class_link . '/subcode_detail_index_js', $dataJS);
?>
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Subcode Detail </h3>

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
        <div class="row">

            <div class="col-sm-5">
                <h6> <strong> <u> <?php echo !empty($caption) ? $caption : '-'; ?> </u></strong> </h6>
                <div id="idsubcodedetailform"></div>
            </div>

            <div class="col-sm-7">
                <div class="card-body table-responsive p-0">
                    <table id="idTable" class="table table-bordered table-striped table-hover" style="font-size: 90%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th>DetailID</th>
                                <th>DetailSubcode</th>
                                <th>DetailType</th>
                                <th>DetailOption</th>
                                <th>DetailRemark</th>
                                <th>DetailIsRequired</th>
                                <th>CreatedAt</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Default box technical information -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Technical Information</h3>

        <div class="card-tools">
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
                <div id="idsubcodetechinformationform"></div>
            </div>

            <div class="col-sm-7">
                <div class="card-body table-responsive p-0">
                    <table id="idTabletechinformation" class="table table-bordered table-striped table-hover" style="font-size: 90%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th>TechInfID</th>
                                <th>TechInfSeq</th>
                                <th>TechInfRemark</th>
                                <th>TechInfRequired</th>
                                <th>IsActive</th>
                                <th>CreatedAt</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
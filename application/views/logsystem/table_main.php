<?php
defined('BASEPATH') or exit('No direct script access allowed');

$dataJS['class_link'] = $class_link;
$dataJS['logDate'] = $logDate;
$this->load->section('scriptJS', $class_link . '/table_main_js', $dataJS);
?>

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Log System</h3>

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
        <div class="form-group row">
            <div class="col-sm-2 col-xs-12">
                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                    </div>
                    <input type="text" id="idlogdate" class="form-control form-control-sm datetimepicker-input" data-target="#reservationdate" placeholder="yyyy-mm-dd" value="<?php echo !empty($logDate) ? $logDate : date('Y-m-d'); ?>" />
                </div>
            </div>
            <button class="btn btn-sm btn-warning" id="idbtnsync" onclick="viewData()"> <i class="fas fa-search"></i> View </button>
        </div>
        <hr>
        <textarea name="" class="form-control" id="idtextlog" cols="30" rows="20" readonly="readonly" style="font-size: 80%;"></textarea>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->

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
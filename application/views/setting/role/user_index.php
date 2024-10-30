<?php
defined('BASEPATH') or exit('No direct script access allowed');

$dataJS['class_link'] = $class_link;
$dataJS['dtmrole_id'] = $dtmrole_id;

$this->load->section('scriptJS', $class_link . '/user_index_js', $dataJS);

?>

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Role - User</h3>

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
        <!-- <button class="btn btn-sm btn-warning" id="idbtnsync" onclick="reload_table()"> <i class="fas fa-sync"></i> Refresh </button> -->
        <h6> <u> <?php echo $role['dtmrole_name']; ?> </u></h6>
        <hr>
        <div class="row">

            <div class="col-sm-5">
                <div id="idroleuserform"></div>
            </div>

            <div class="col-sm-7">
                <div class="card-body table-responsive p-0">
                    <table id="idTable" class="table table-bordered table-striped table-hover" style="font-size: 80%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th>RoleUserID</th>
                                <th>UserID</th>
                                <th>Username</th>
                                <th>CreatedAt</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

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
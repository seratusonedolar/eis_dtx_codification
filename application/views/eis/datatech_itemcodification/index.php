<?php
defined('BASEPATH') or exit('No direct script access allowed');

$dataJS['class_link'] = $class_link;
$this->load->section('scriptJS', $class_link . '/index_js', $dataJS);
?>

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Datatex Codification</h3>

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
            <div class="col-sm-12">
                <div class="card-body table-responsive p-0">
                    <table id="idTable" class="table table-bordered" style="font-size: 90%;">
                        <thead>
                        </thead>
                        <tbody>
                            <?php foreach ($msubcodes as $e) :
                                if ($e['dtmsubcode_level'] == 0) :
                            ?>
                                    <tr>
                                        <td>
                                            <u> <?php echo $e['dtmsubcode_name'] ?> </u>
                                            <?php if (checkPermission('MASTERITEM.CODIFICATION.ADD')) : ?>
                                                <a href="javascript:void(0);" onclick="form_main('add', '<?php echo $e['dtmsubcode_id']; ?>')" class="btn btn-tool btn-sm" title="Add">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (checkPermission('MASTERITEM.CODIFICATION.EDIT')) : ?>
                                                <a href="javascript:void(0);" onclick="form_main('edit', '<?php echo $e['dtmsubcode_id']; ?>')" class="btn btn-tool btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <ol>
                                                <?php foreach ($msubcodes as $e1) :
                                                    if ($e1['dtmsubcode_level'] == 1 && $e1['dtmsubcode_parent'] == $e['dtmsubcode_id']) : ?>
                                                        <li>
                                                            <strong><?php echo $e1['dtmsubcode_name'] . " ({$e1['dtmsubcode_code']})"; ?> <?php echo empty($e1['dtmsubcode_is_active']) ? '<strong style="color:red;">NOT ACTIVE </strong>' : ''; ?> </strong>

                                                            <?php if (checkPermission('MASTERITEM.CODIFICATION.EDIT')) : ?>
                                                                <a href="javascript:void(0);" onclick="form_main('edit', '<?php echo $e1['dtmsubcode_id']; ?>')" class="btn btn-tool btn-sm" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            <?php endif; ?>

                                                            <?php if (checkPermission('MASTERITEM.CODIFICATION.SUBCODEDETAIL.READ')) : ?>
                                                            <a href="<?php echo base_url() . $class_link; ?>/subcode_detail?id=<?php echo base64_encode($e1['dtmsubcode_id']); ?>" class="btn btn-tool btn-sm" title="Detail Subcode">
                                                                <i class="fas fa-search"></i>
                                                            </a>
                                                            <?php endif; ?>

                                                            <table border="1" style="width: 100%;">
                                                                <tr>
                                                                    <td style="width: 50%;"> <u> Subcode : </u>
                                                                        <?php if (checkPermission('MASTERITEM.CODIFICATION.ADD')) : ?>
                                                                            <a href="javascript:void(0);" onclick="form_main('add', '<?php echo $e1['dtmsubcode_id']; ?>')" class="btn btn-tool btn-sm" title="Add">
                                                                                <i class="fas fa-plus"></i>
                                                                            </a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td style="width: 50%;"> <u> Technical Information : </u></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <!-- Subcode List -->
                                                                        <ul>
                                                                            <?php foreach ($msubcodes as $e2) :
                                                                                if ($e2['dtmsubcode_level'] == 2 && $e2['dtmsubcode_parent'] == $e1['dtmsubcode_id']) : ?>
                                                                                    <li>
                                                                                        <?php echo $e2['dtmsubcode_name']; ?> <?php echo empty($e2['dtmsubcode_is_active']) ? '<strong style="color:red;">NOT ACTIVE </strong>' : ''; ?>
                                                                                        <a href="<?php echo base_url() . $class_link; ?>/subcode_hierarchy?id=<?php echo base64_encode($e2['dtmsubcode_id']); ?>" class="btn btn-tool btn-sm">
                                                                                            <i class="fas fa-search"></i>
                                                                                        </a>
                                                                                        <?php if (checkPermission('MASTERITEM.CODIFICATION.EDIT')) : ?>
                                                                                            <a href="javascript:void(0);" onclick="form_main('edit', '<?php echo $e2['dtmsubcode_id']; ?>')" class="btn btn-tool btn-sm" title="Edit">
                                                                                                <i class="fas fa-edit"></i>
                                                                                            </a>
                                                                                        <?php endif; ?>

                                                                                    </li>
                                                                            <?php
                                                                                endif;
                                                                            endforeach; ?>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        <!-- Tech Information List -->
                                                                        <ul>
                                                                            <?php foreach ($techInfs as $eTechInf) :
                                                                                if ($eTechInf['dtmsubcode_id'] == $e1['dtmsubcode_id']) : ?>
                                                                                    <li>
                                                                                        <?php echo $eTechInf['dtmsubcodetechinf_remark']; ?> <?php echo empty($eTechInf['dtmsubcodetechinf_is_active']) ? '<strong style="color:red;">NOT ACTIVE </strong>' : ''; ?>
                                                                                        <a href="<?php echo base_url() . $class_link; ?>/subcode_techinf?id=<?php echo base64_encode($eTechInf['dtmsubcodetechinf_id']); ?>" class="btn btn-tool btn-sm">
                                                                                            <i class="fas fa-search"></i>
                                                                                        </a>
                                                                                    </li>
                                                                            <?php
                                                                                endif;
                                                                            endforeach; ?>
                                                                        </ul>

                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </li>
                                                <?php
                                                    endif;
                                                endforeach; ?>
                                            </ol>
                                        </td>
                                    </tr>
                            <?php
                                endif;
                            endforeach; ?>
                        </tbody>
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
<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$form_id = 'idForm';
?>
<?php if (($slug != 'VIEW') && ($datatech_item['dtmitem_validated'] != 1)) : ?>
    <?php if (checkPermission('MASTERITEM.PROCESSED.DELETE')) : ?>
        <!-- <button 
            class="btn btn-sm btn-danger float-right" 
            title="Delete"
            <?php if ($uploaded === TRUE) : ?>
                onclick="toastAlert('danger', 'Deletion is not allowed. The data has been uploaded to the Datatex server.'); return false;" 
                style="cursor: not-allowed; opacity: 0.65;"
            <?php else : ?>
                onclick="action_delete_mitem('<?php echo $datatech_item['dtmitem_id']; ?>');"
            <?php endif; ?>
        >
            <i class="fas fa-trash"></i> 
        </button> -->
    <?php endif; ?>
    
    <?php if (checkPermission('MASTERITEM.PROCESSED.EDIT')) : ?>
        <!-- <button 
            class="btn btn-sm btn-warning float-right" 
            title="Edit"
            <?php if ($uploaded === TRUE) : ?>
                onclick="toastAlert('danger', 'Editing is not allowed. The data has been uploaded to the Datatex server.'); return false;" 
                style="cursor: not-allowed; opacity: 0.65;"
            <?php else : ?>
                onclick="action_edit_mitem('<?php echo $datatech_item['dtmitem_id']; ?>');"
            <?php endif; ?>
        >
            <i class="fas fa-edit"></i> 
        </button> -->
        <!-- <button 
            class="btn btn-sm btn-warning float-right" 
            title="Edit"
            onclick="action_edit_mitem('<?php echo $datatech_item['dtmitem_id']; ?>');"
        >
            <i class="fas fa-edit"></i> 
        </button> -->
    <?php endif; ?>
<?php endif; ?>
<h5>EIS</h5>

<div id="idformview">
    <?php if (isset($parentRelated['count']) && $parentRelated['count'] > 0) : ?>
        <div class="col-md-12">
            <div class="card bg-secondary">
                <div class="card-header">
                    <h4 class="card-title"><strong>Notice !</strong></h4>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    There are <strong><?php echo $parentRelated['count']; ?></strong> item related with same ParentID, you can select <strong>Go</strong> to process other related ItemID
                    <button type="submit" name="btnSubmit" id="idbtnSubmitSaveGo<?php echo $form_id; ?>" onclick="window.open('<?php echo base_url() . 'eis/item/parent_index?dtmitem_id=' . base64_encode($datatech_item['dtmitem_id']); ?>')" class="btn btn-sm btn-info">
                        <i class="fas fa-paper-plane"></i> Go
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <hr>
    <table border="1" style="width: 100%;">
        <tr>
            <td style="font-weight: bold;">Item ID</td>
            <td colspan="3">: <?php echo $datatech_item['item_id']; ?></td>
        </tr>
        <tr>
            <td style="width: 20%; font-weight: bold;">Classif</td>
            <td style="width: 30%;">: <?php echo $eis_item['classif_name']; ?></td>
            <td style="width: 20%; font-weight: bold;">SubClassif</td>
            <td style="width: 30%;">: <?php echo $eis_item['subclassif_name']; ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Name</td>
            <td colspan="3">: <?php echo $eis_item['name']; ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">UOM</td>
            <td colspan="3">: <?php echo $eis_item['um_name']; ?></td>
        </tr>
    </table>
    <hr>
    <h5>Datatex</h5>
    <h6> <u> Subcode : </u></h6>
	<div class="custom-control custom-checkbox float-right checkboxconfirmed" onchange="action_togglevalidated(this)" data-dtmitemid="<?php echo $datatech_item['dtmitem_id']?>">
		<input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" <?php echo ($datatech_item['dtmitem_validated'] == 1) ? 'checked' : '' ?> >
		<label for="customCheckbox1" class="custom-control-label">Validated</label>
	</div>
    <table border="1" style="width: 100%;">
        <tr>
            <td style="font-weight: bold;">Item ID</td>
            <td colspan="2">: <?php echo $datatech_item['dtmitem_code']; ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Item Type (<?php echo $datatech_item['dtmsubcode_name']; ?>)</td>
            <td colspan="2">: <?php echo $datatech_item['dtmsubcode_code']; ?></td>
        </tr>
        <?php foreach ($datatech_item_detail as $eDetail) : ?>
            <tr>
                <?php
                $optionName = null;
                $optionType = null;
                if ($eDetail['dtmsubcodedtl_type'] == 'OPTION') {
                    $optionName = $eDetail['dtmsubcodehierarchy_name'];
                    $optionType = $eDetail['dtmsubcode_name'];
                } else {
                    $optionType = $eDetail['dtmsubcodedtl_remark'];
                }
                ?>
                <td style="font-weight: bold;"><?php echo $eDetail['dtmsubcodedtl_seq'] . " ($optionType)"; ?></td>
                <td>: <?php echo $eDetail['dtmitemdtl_code']; ?> </td>
                <td><?php echo $optionName; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <hr>
    <!-- Technical Information -->
    <h6> <u> Technical Information : </u></h6>
    <table border="1" style="width: 100%;">
        <?php foreach ($datatex_item_tech_information as $eTechInf) : ?>
            <tr>
                <td style="font-weight: bold; width: 30%;"><?php echo $eTechInf['dtmsubcodetechinf_seq'] . "({$eTechInf['dtmsubcodetechinf_remark']})"; ?></td>
                <td style="width: 70%;">: <?php echo !empty($eTechInf['dtmsubcodetechinfhierarchy_code']) ? $eTechInf['dtmsubcodetechinfhierarchy_code'].' | '.$eTechInf['dtmsubcodetechinfhierarchy_name'] : ''; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <hr>
    <!-- Other Information -->
    <h6> <u> Other Information : </u></h6>
    <table border="1" style="width: 100%;">
        <tr>
            <td style="font-weight: bold; width: 30%;">UOM</td>
            <td style="width: 70%;">: <?php echo $datatech_item['um_name']; ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold; width: 30%;">Item Description</td>
            <td style="width: 70%;">: <?php echo $datatech_item['dtmitem_description']; ?></td>
        </tr>
    </table>
    <hr>

    <!-- <div class="callout callout-info">
        <p><i> ProcessedBy : <?php echo $datatech_item['auth_email']; ?> <br>
                ProcessedAt : <?php echo $datatech_item['dtmitem_updated_at']; ?></i></p>
    </div> -->
    <div class="timeline">
        <div>
            <i class="fas fa-user bg-green"></i>
            <div class="timeline-item">
                <span class="time"><i class="fas fa-clock"></i> <?php echo $datatech_item['dtmitem_updated_at']; ?></span>
                <h3 class="timeline-header no-border"><a href="mailto:<?php echo $datatech_item['auth_email']; ?>"><?php echo $datatech_item['auth_email']; ?></a> Processed Item</h3>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	function action_togglevalidated(element){
		let dtmitem_id = $(element).data('dtmitemid');
		console.log(dtmitem_id);
		var conf = confirm('Are you sure ?');
        if (conf) {
			$.ajax({
                type: 'GET',
                url: '<?php echo base_url() . $class_link . '/action_togglevalidated'; ?>',
                data: {
                    dtmitem_id: dtmitem_id
                },
                success: function(data) {
                    if (data.code == 200) {
                        toastAlert('success', data.messages);
                        reload_table();
                        toggle_modal('', '');
                    } else {
                        toastAlert('error', data.messages);
                    }
                }
            });
        }
	}

    function action_delete_mitem(dtmitem_id) {
        var conf = confirm('Are you sure ?');
        if (conf) {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() . $class_link . '/action_delete_mitem'; ?>',
                data: {
                    dtmitem_id: dtmitem_id
                },
                success: function(data) {
                    if (data.code == 200) {
                        toastAlert('success', data.messages);
                        reload_table();
                        toggle_modal('', '');
                    } else {
                        toastAlert('error', data.messages);
                    }
                }
            });
        }
    }

    function action_edit_mitem(dtmitem_id) {
        var conf = confirm('Are you sure ?');
        if (conf) {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() . $class_link . '/formedit_main'; ?>',
                data: {
                    dtmitem_id: dtmitem_id
                },
                success: function(html) {
                    $('#idformview').html(html);
                }
            });
        }
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

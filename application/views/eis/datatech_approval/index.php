<?php
defined('BASEPATH') or exit('No direct script access allowed');

$dataJS['class_link'] = $class_link;
$this->load->section('scriptJS', $class_link . '/index_js', $dataJS);

?>

<!-- Filter -->
<!-- Default box -->
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Filter</h3>

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
		<hr>
		<button class="btn btn-sm btn-warning" style="float: right;" id="idbtnsyncrefresh" onclick="window.location.href='<?php echo base_url().'eis/datatech_approval' ?>'"> <i class="fas fa-sync"></i> Refresh </button>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group row">
					<label class="col-md-1 col-form-label text-right">Pilih Filter</label>
					<div class="col-sm-5 col-xs-12">
						<select name="filter_pilih" id="filter_pilih" onchange="filterpilih(this.value)" class="form-control form-control-sm">
							<option value="0">Choose Filter</option>
							<option value="1">Item Type</option>
							<option value="2">Item ID</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div id="search_1" style="display: none;">
			<form action="" id="idformsearch">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group row">
							<label for="iddtmsubcode_id1" class="col-md-1 col-form-label text-right">Dttech. Classif 1</label>
							<div class="col-sm-5 col-xs-12">
								<select name="dtmsubcode_id1" id="iddtmsubcode_id1" class="form-control form-control-sm">
								</select>
							</div>
						</div>
					</div>

				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="partialformsubcode" style="font-size: 90%;"></div>
					</div>
				</div>
				<div class="row" id="approvechange" style="display: none;">
					<div class="col-md-12">
						<div class="form-group row">
							<label for="iddtmsubcode_id1" class="col-md-1 col-form-label text-right">Approval Status</label>
							<div class="col-sm-5 col-xs-12">
								<select name="app_status" id="app_status" class="form-control form-control-sm">
									<option value="0">All</option>
									<option value="1">Pending Approve</option>
									<option value="2">Approve</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				
			</form>
			<button class="btn btn-sm btn-primary" id="idbtnSubmitidformsearch" onclick="submitData(iddtmsubcode_id1.value,idseq2.value,app_status.value)" style="display: none; float:right"> <i class="fa fa-search"></i> Search</button>
				
		</div>
		<div id="search_2"  style="display: none;">
			<form id="dataForm">
				<div class="row mb-3">
					<div class="col-md-12">
						<div class="form-group row">
							<label for="itemID" class="col-md-1 col-form-label text-right">Item ID</label>
							<div class="col-sm-5 col-xs-12">
								<textarea name="itemID" id="itemID" class="form-control form-control-sm" rows="3" placeholder="Enter the Item IDs, separated by commas."></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- /.card-body -->
	<div class="card-footer">
		
	</div>
	<!-- /.card-footer-->
</div>
<!-- /.card -->


<!-- Default box -->
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Pending Approval</h3>
		<hr>
		<a href="<?php echo base_url(); ?>eis/datatech_itemcodification_user" class="btn btn-sm btn-danger" target="_blank">  Add Master </a>
		&emsp;&emsp;
		<button class="btn btn-sm btn-success" id="idbtnsync" style="display: none;" onclick="submitData(iddtmsubcode_id1.value,idseq2.value,app_status.value)"> <i class="fas fa-sync"></i> Submit Data </button>
		
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
		<!-- <button class="btn btn-sm btn-warning" id="idbtnsync" onclick="window.location.reload()"> <i class="fas fa-sync"></i> Refresh </button> -->
		<!-- <hr> -->
		<div class="partialtablesearch"></div>
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

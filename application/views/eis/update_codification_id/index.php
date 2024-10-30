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
	<!-- /.card-body -->
	<div class="card-footer">
	</div>
	<!-- /.card-footer-->
</div>
<!-- /.card -->


<!-- Default box -->
<div class="card">
	
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

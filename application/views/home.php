<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->section('scriptJS', '/home_js', []);
?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><?php echo getenv('APP_NAME'); ?></h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
						<i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body">
				Hi <strong><?php echo $user['name']; ?></strong>, Welcome to <strong> <?php echo getenv('APP_NAME'); ?> </strong>
			</div>

			<div class="card-footer">
			</div>
		</div>
		<!-- Iframe dashboard -->
		<!-- <div class="card">
			<div class="card-header">
				<h3 class="card-title">Chart</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
						<i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body">
				<iframe src="http://192.168.31.190:8088/superset/dashboard/18/?native_filters_key=NDJwQ0dkR4sdg_tX_clSUajr1CLb-GizQOb23F5ebNu6cZejkxR4kjF0WYlGnU3e" width="100%" height="800" seamless frameBorder="0" scrolling="yes">
				</iframe>
			</div>
		</div> -->
	</div>
</div>
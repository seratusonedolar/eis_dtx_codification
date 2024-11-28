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
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Chart</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
						<i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body">
				<iframe
					width="600"
					height="400"
					seamless
					frameBorder="0"
					scrolling="no"
					src="http://192.168.31.25:8088/superset/explore/p/mbkzKP5aB8E/?standalone=1&height=400">
				</iframe>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function submitData(itemIDs) {
		var jsonRequest = itemIDs;

		$.ajax({
			type: 'POST',
			url: '<?php echo base_url() . $class_link . '/partialtablesearch'; ?>',
			data: {
				jsonRequest: jsonRequest
			},
			success: function(html) {
				$('.partialtablesearch').html(html);
			},
			beforeSend: function() {
				$('.preloader-custom').fadeIn('xfast');
			},
			complete: function() {
				$('.preloader-custom').fadeOut('xfast');
			}
		});
	}

	$(document).ready(function() {
		$('#dataForm').submit(function(event) {
			event.preventDefault();

			var itemIDs = $('#itemID').val().split(',').map(id => id.trim()).join(',');
			submitData(itemIDs);
		});
	});

	function toggle_modal(modalTitle, htmlContent) {
		$('#modal-lg').modal('toggle');
		$('.modal-title').text(modalTitle);
		$('#idmodalbody').html(htmlContent);
	}

	function toggle_modal_warning(modalTitle, htmlContent) {
		$('#modal-warning').modal('toggle');
		$('#idmodalwarning-title').text(modalTitle);
		$('#idmodalwarning-body').html(htmlContent);
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

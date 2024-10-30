<script type="text/javascript">
	function submitData(id) {
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url() . $class_link . '/partialtablesearch'; ?>',
			data: {
				id: id
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

	render_subcode('iddtmsubcode_id1', 1, '')

	function render_subcode(attributID, dtmsubcode_level, dtmsubcode_parent) {
		$("#" + attributID).select2({
			theme: 'bootstrap4',
			placeholder: '--Select Option--',
			minimumInputLength: 0,
			// allowClear: true,
			// dropdownParent: $("#modal-lg .modal-content"),
			ajax: {
				url: '<?php echo base_url(); ?>/eis/datatech_itemcodification/autocomplete_subcode?dtmsubcode_level=' + dtmsubcode_level + '&dtmsubcode_parent=' + dtmsubcode_parent,
				type: "get",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						param_search: params.term,
					};
				},
				processResults: function(response) {
					return {
						results: $.map(response, function(item) {
							return {
								id: item.dtmsubcode_id,
								text: item.dtmsubcode_code + ' | ' + item.dtmsubcode_name
							};
						})
					};
				},
				cache: false
			}
		});
	}

	$('#iddtmsubcode_id1').on('select2:select', function(e) {
		var data = e.params.data;
		submitData(data.id)
	});

	function search_item(form_id) {
		event.preventDefault();
		var form = $('#' + form_id)[0];

		// Loading animate
		$('#idbtnSubmit' + form_id).html('<i class="fa fa-spinner fa-pulse"></i> Loading');
		$('#idbtnSubmit' + form_id).attr('disabled', true);

		$.ajax({
			url: '<?php echo base_url() . $class_link . '/search_item' ?>',
			type: "POST",
			data: new FormData(form),
			contentType: false,
			cache: false,
			processData: false,
			success: function(data) {
				if (data.code == 400) {
					toastAlert('warning', data.messages);
				} else {
					partialtablesearch(data.jsonRequest);
				}
			},
			complete: function(dt) {
				// Loading animate
				$('#idbtnSubmit' + form_id).html('<i class="fa fa-search"></i> Search');
				$('#idbtnSubmit' + form_id).attr('disabled', false);
			}
		});
	}

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

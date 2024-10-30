<script type="text/javascript">
	function partialformsearchcategory(dtscfinhie_type) {
		$.ajax({
			type: 'GET',
			url: '<?php echo base_url() . $class_link . '/partialformsearchcategory'; ?>',
			async: false,
			data: {
				dtscfinhie_type: dtscfinhie_type,
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

	render_filter_category('iddtmsubcode_id1')

	function render_filter_category(attributID) {
		$("#" + attributID).select2({
			theme: 'bootstrap4',
			placeholder: '--Select Option--',
			minimumInputLength: 0,
			// allowClear: true,
			// dropdownParent: $("#modal-lg .modal-content"),
			ajax: {
				url: '<?php echo base_url(); ?>/eis/gmt/get_unique_categories',
				type: "get",
				dataType: 'json',
				delay: 250,
				processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.dtscfinhie_type,
                            text: item.dtscfinhie_type
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
		partialformsearchcategory(data.id);
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

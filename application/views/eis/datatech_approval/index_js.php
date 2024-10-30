<script type="text/javascript">
	$(document).ready(function() {
		$('#iddtmsubcode_id1').on('change', function() {
			if ($(this).val() !== "") {
				$('#idbtnsync').show();
				$('#idbtnSubmitidformsearch').show();
				$('#approvechange').show();
			} else {
				$('#idbtnsync').hide();
				$('#idbtnSubmitidformsearch').hide();
				$('#approvechange').hide();
			}
		});
	});

	function submitData(id,idseq2,appst) {
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url() . $class_link . '/partialtablesearch'; ?>',
			data: {
				id: id,
				idseq2 : idseq2,
				appst : appst
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

	function approveItem(button) {
		var dtmsubcode_id = $(button).data('dtmsubcode-id');
        var dtmitemId = $(button).data('dtmitem-id');
        var confirmed = confirm(`Are you sure you want to approve the item with ID ${dtmitemId} ?`);
		var seqdtl = $('#idseq2').val();
		var appst = $('#app_status').val();
        if (confirmed) {
            $.ajax({
                url: '<?php echo base_url() . $class_link . '/approval' ?>',
                type: 'POST',
                data: {
                    dtmitem_id: dtmitemId,
                },
                success: function(response) {
                    const responseData = JSON.parse(response);
                    if (responseData.status == 200) {
                        alert(responseData.message);
						 submitData(dtmsubcode_id,seqdtl,appst);
                    } else {
                        alert(responseData.message);
                    }
                },
                beforeSend: function() {
					submitData(dtmsubcode_id,seqdtl,appst)
                    $('.preloader-custom').fadeIn('fast');
                },
                complete: function() {
                    $('.preloader-custom').fadeOut('fast');
                },
                error: function(xhr, status, error) {
                    console.log('Error status:', status);
                    console.log('Error:', error);
                    console.log('Response Text:', xhr.responseText);
                }
            });
        } else {
            console.log('Approval canceled.');
        }
    }

	function unapproveItem(button) {
		var dtmsubcode_id = $(button).data('dtmsubcode-id');
        var dtmitemId = $(button).data('dtmitem-id');
        var confirmed = confirm(`Are you sure you want to unapprove the item with ID ${dtmitemId} ?`);
		var seqdtl = $('#idseq2').val();
		var appst = $('#app_status').val();
        if (confirmed) {
            $.ajax({
                url: '<?php echo base_url() . $class_link . '/unapprove' ?>',
                type: 'POST',
                data: {
                    dtmitem_id: dtmitemId,
                },
                success: function(response) {
                    const responseData = JSON.parse(response);
                    if (responseData.status == 200) {
                        alert(responseData.message);
						//alert(seqdtl);
						 submitData(dtmsubcode_id,seqdtl,appst);
                    } else {
                        alert(responseData.message);
                    }
                },
                beforeSend: function() {
					submitData(dtmsubcode_id,seqdtl,appst)
                    $('.preloader-custom').fadeIn('fast');
                },
                complete: function() {
                    $('.preloader-custom').fadeOut('fast');
                },
                error: function(xhr, status, error) {
                    console.log('Error status:', status);
                    console.log('Error:', error);
                    console.log('Response Text:', xhr.responseText);
                }
            });
        } else {
            console.log('Approval canceled.');
        }
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

	// $('#iddtmsubcode_id1').on('select2:select', function(e) {
	// 	var data = e.params.data;
	// 	submitData(data.id)
	// });

	
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

	function partialformsearchsubcode(dtmsubcode_id, dtmitem_id = '', slug = '') {
		$.ajax({
			type: 'GET',
			url: '<?php echo base_url() . $class_link . '/partialformsearchsubcode'; ?>',
			async: false,
			data: {
				dtmsubcode_id: dtmsubcode_id,
				dtmitem_id: dtmitem_id,
				slug: slug
			},
			success: function(html) {
				$('.partialformsubcode').html(html);
			}
		});
	}

	$('#iddtmsubcode_id1').on('select2:select', function(e) {
		var data = e.params.data;
		partialformsearchsubcode(data.id);
		//partialformsearchtechinf(data.id);
	});

	function filterpilih(vals) {
		if(vals==1){
			$('#search_1').show();
			$('#search_2').hide();
			$('#idbtnsync').show();
			
			//$(".partialtablesearch" ).load(window.location.href + " .partialtablesearch" );
		} else if (vals==2){
			$('#search_1').hide();
			$('#search_2').show();
			$('#idbtnsync').hide();
			//$(".partialtablesearch" ).load(window.location.href + " .partialtablesearch" );
		} else {
			$('#search_1').hide();
			$('#search_2').hide();
			$('#idbtnsync').hide();
			//$(".partialtablesearch" ).load(window.location.href + " .partialtablesearch" );
		}
	}
	
	$(document).ready(function() {
		$('#dataForm').submit(function(event) {
			event.preventDefault();

			var itemIDs = $('#itemID').val().split(',').map(id => id.trim()).join(',');
			submitData_itemid(itemIDs);
		});
	});

	function submitData_itemid(itemIDs) {
		var jsonRequest = itemIDs;

		$.ajax({
			type: 'POST',
			url: '<?php echo base_url() . $class_link . '/partialtablesearch2'; ?>',
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
</script>

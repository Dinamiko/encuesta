jQuery(document).ready(function($) {

	var form = $( "#form-encuesta" );

	jQuery.validator.setDefaults({
	  debug: false,
	  success: "valid"
	});

	jQuery.extend(jQuery.validator.messages, {
	    required: "<div style='margin-top:10px;margin-bottom:15px;width:100%;float:left;'>Campo obligatorio.</div>",
	    email: "Email incorrecto.",
	});

	form.validate({
		success: function(label,element) {
			$.validator.messages.required = '';
		},

	});

	$( "#form-encuesta" ).submit(function(e) {

		e.preventDefault();

		if( form.valid() ) {

			var encuesta_radiochoices = $('input[name=encuesta_radiochoices]:checked', '#encuesta-container').val();
			var encuesta_email = $('#encuesta_email').val();
			var encuesta_nonce = $('#encuesta-nonce').val();

			jQuery.ajax({
				type : 'post',
				dataType : 'json',
				url : ajaxurl,
				data : {
					action: 'encuesta_ajax',
					encuesta_radiochoices:encuesta_radiochoices,
					encuesta_email:encuesta_email,
					encuesta_nonce:encuesta_nonce
				},
				success: function( response ) {
					if( response.success ) {
						$('#encuesta-container').html('<h3>' + response.data.msg + '</h3>');
					} else {
						$('#encuesta-container').html(response.data.msg);
					}
				}
			});

		}

	});

});

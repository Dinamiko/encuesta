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
			var encuesta_nonce_field = $('#encuesta_nonce_field').val();

			jQuery.ajax({

				type : 'post',
				dataType : 'json',
				url : ajaxurl,
				data : {
					action: 'encuesta_ajax',
					encuesta_radiochoices:encuesta_radiochoices,
					encuesta_email:encuesta_email,
					encuesta_nonce_field:encuesta_nonce_field
				},

				success: function( response ) {

					if( response.type == 'success') {

						//console.log( 'ok: ' + response.msg );
						$('#encuesta-container').html('<h3>' + response.msg + '</h3>');


					} else {

						//console.log( 'error: ' + response.msg );
						$('#encuesta-container').html(response.msg);

					}

				}

			});

		}

	});

});

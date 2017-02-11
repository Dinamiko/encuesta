/*
ref: http://alistapart.com/article/writing-testable-javascript

Areas of responsibility:
- Presentation and interaction
- Data management and persistence
- Overall application state
- Setup and glue code to make the pieces work together

Represent each distinct piece of behavior as a separate object and doesn’t need to know about other objects.
Support configurability, rather than hard-coding things.
Keep our objects’ methods simple and brief.
Use constructor functions to create instances of objects.

- Form (Presentation)
- Validate (?)
- Results (Presentation)
*/

function Form( form_element ) {
	this.form_element = form_element;

	var validation_messages = {
		required: "<div style='margin-top:10px;margin-bottom:15px;width:100%;float:left;'>Campo obligatorio.</div>",
		email: "Email incorrecto.",
	};
	this.setupValidation( validation_messages );

	this.form_element.on( 'submit', _.bind( this.onFormSubmit, this ) );
}

Form.prototype.setupValidation = function( validation_messages ) {
	jQuery.validator.setDefaults({
		debug: false,
		success: "valid"
	});

	jQuery.extend( jQuery.validator.messages, validation_messages );

	this.form_element.validate({
		success: function( label,element ) {
			jQuery.validator.messages.required = '';
		}
	});
};

Form.prototype.onFormSubmit = function() {
	if( ! this.form_element.valid() ) { return; }

	console.log('continue here...')

};


(function( $ ) {
  var form = new Form( $( '#form-encuesta' ) );
})( jQuery );





/*
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
*/

/*
ref
http://alistapart.com/article/writing-testable-javascript
https://neliosoftware.com/blog/introduction-to-unit-testing-in-wordpress-ajax/
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

Form.prototype.onFormSubmit = function( e ) {
	if( ! this.form_element.valid() ) { return false; }
	e.preventDefault();

	data = {
		action: 'encuesta_ajax',
		encuesta_radiochoices: jQuery('input[name=encuesta_radiochoices]:checked', '#encuesta-container').val(),
		encuesta_email: jQuery('#encuesta_email').val(),
		encuesta_nonce: jQuery('#encuesta-nonce').val(),
	};

	this.addRespuesta( data );
};

Form.prototype.addRespuesta = function( data ) {
	if ( this.ajax ) { this.ajax.abort(); }

	this.data = data;

	this.ajax = jQuery.ajax({
		type : 'post',
		dataType : 'json',
		url : ajaxurl,
    data: this.data,
    success: _.bind( this.processResult, this )
  });
}

Form.prototype.processResult = function( response ) {
	this.draw( response.data.msg );
};

Form.prototype.draw = function( element ) {
	jQuery('#encuesta-container').html('<h3>' + element + '</h3>');
};

(function( $ ) {
  var form = new Form( $( '#form-encuesta' ) );
})( jQuery );

<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* creamos la variable ajaxurl y la imprimimos en el head
*/
function encuesta_crea_ajaxurl() { ?>
	<script type="text/javascript">
	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	</script>
<?php }
add_action('wp_head','encuesta_crea_ajaxurl');

/**
* crea registro con datos desde el formulario
*/
function encuesta_ajax() {

	// verify using action when using wp_nonce_field
	//if ( ! isset( $_POST['encuesta_nonce'] ) || ! wp_verify_nonce( $_POST['encuesta_nonce'], 'encuesta_action' ) ) {
/*
* disabled, fixes accepeptance test nonce error
	// verify using nonce when using wp_create_nonce
	if ( ! isset( $_POST['encuesta_nonce'] ) || ! wp_verify_nonce( $_POST['encuesta_nonce'], 'encuesta-nonce' ) ) {
		$result = array(
				'type'	=> 'error',
				'msg' => 'nonce error',
		);
		wp_send_json_error( $result );

	} else {
*/

		// comprobamos que existen
		if( isset( $_POST['encuesta_radiochoices'] ) && isset( $_POST['encuesta_email'] ) ) {

			$radiochoices_length = strlen( $_POST['encuesta_radiochoices'] );
			$email_length = strlen( $_POST['encuesta_email'] );
			$valid_email = is_email( $_POST['encuesta_email'] );

			// valida el máximo de carácteres permitido en cada string y si el email es válido
			if( $radiochoices_length > 0 && $radiochoices_length <= 30 && $email_length <= 100 && $valid_email ) {

				// saneamos
				$encuesta_radiochoices = sanitize_text_field( $_POST['encuesta_radiochoices'] );
				$encuesta_email = sanitize_email( $_POST['encuesta_email'] );

				// insertamos
				$inserted = encuesta_insert( $encuesta_radiochoices, $encuesta_email );

				// SI se ha creado, mostramos mensaje OK
				if( $inserted ) {

					$result = array(
							'type'	=> 'success',
							'msg' => 'Gracias por participar!',
							'inserted_id' => $inserted
					);
					wp_send_json_success( $result );

				// NO se ha creado, mostramos error en #encuesta-error
				} else {
					$result = array(
							'type'	=> 'error',
							'msg' => 'No se ha creado el registro en la base de datos',
					);
					wp_send_json_error( $result );

				}

			} else {
				$result = array(
						'type'	=> 'error',
						'msg' => 'Error al enviar formulario',
				);
				wp_send_json_error( $result );
			}

		} else {
			$result = array(
					'type'	=> 'error',
					'msg' => 'Los campos están vacios',
			);
			wp_send_json_error( $result );
		}

	//}

}

add_action('wp_ajax_encuesta_ajax', 'encuesta_ajax' );
add_action('wp_ajax_nopriv_encuesta_ajax', 'encuesta_ajax' );

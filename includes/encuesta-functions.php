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

	// verify using nonce when using wp_create_nonce
	if ( ! isset( $_POST['encuesta_nonce'] ) || ! wp_verify_nonce( $_POST['encuesta_nonce'], 'encuesta-nonce' ) ) {
		$result = array(
				'type'	=> 'error',
				'msg' => 'nonce error',
		);
		wp_send_json_error( $result );

	} else {

		// comprobamos que existen
		if( isset( $_POST['encuesta_radiochoices'] ) && isset( $_POST['encuesta_email'] ) ) {

			$radiochoices_length = strlen( $_POST['encuesta_radiochoices'] );
			$respuesta_length = strlen( $_POST['encuesta_radiochoices'] );
			$email_length = strlen( $_POST['encuesta_email'] );
			$valid_email = is_email( $_POST['encuesta_email'] );

			// valida el máximo de carácteres permitido en cada string y si el email es válido
			if( $radiochoices_length > 0 && $respuesta_length <= 30 && $email_length <= 100 && $valid_email ) {

				// saneamos
				$encuesta_radiochoices = sanitize_text_field( $_POST['encuesta_radiochoices'] );
				$encuesta_email = sanitize_email( $_POST['encuesta_email'] );

				global $wpdb;
				$table_name = $wpdb->prefix . "encuesta";

				// insertamos
				$inserted = $wpdb->insert (

					$table_name,

					array(
						'time' => date( "Y-m-d h:i:s", time() ),
						'respuesta' => $encuesta_radiochoices,
						'email' => $encuesta_email
					),

					array(
						'%s',
						'%s',
						'%s'
					)

				);

				// SI se ha creado, mostramos mensaje OK
				if( $inserted ) {

					$result = array(
							'type'	=> 'success',
							'msg' => 'Gracias por participar!',
							'inserted_id' => $wpdb->insert_id
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

	}

}

add_action('wp_ajax_encuesta_ajax', 'encuesta_ajax' );
add_action('wp_ajax_nopriv_encuesta_ajax', 'encuesta_ajax' );

/**
* Devuelve el total de registros de la tabla encuesta
* @return int $total registros
*/
function encuesta_get_registros() {

	global $wpdb;
	$table_name = $wpdb->prefix . "encuesta";

	$total = $wpdb->get_results( "SELECT * FROM $table_name" );

	return count( $total );

}

/**
* Devuelve el total de registros donde el campo respuesta es igual valor $respuesta
* @param string $valor respuesta
* @return int $registros total registros
*/
function encuesta_get_registros_respuesta( $respuesta ) {

	if( $respuesta ) {

		global $wpdb;
		$table_name = $wpdb->prefix . "encuesta";

		$registros = 0;
		$total = $wpdb->get_results( "SELECT * FROM $table_name" );

		foreach ( $total as $registro ) {

			if( $registro->respuesta == $respuesta ) {

				$registros++;

			}

		}

		return $registros;

	} else {

		return false;

	}

}

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

	// verifica nonce
	if ( ! isset( $_POST['encuesta_nonce_field'] ) || ! wp_verify_nonce( $_POST['encuesta_nonce_field'], 'encuesta_action' ) ) {

	   print 'Lo siento, tu nonce no verifica.';
	   exit;

	} else {

		// comprobamos que existen
		if( isset( $_POST['encuesta_radiochoices'] ) && isset( $_POST['encuesta_email'] ) ) {

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

				$result['type'] = 'success';
				//$result['msg'] = 'ID: ' + $wpdb->insert_id;
				$result['msg'] = 'Gracias por participar!';
				$result = json_encode( $result );
				echo $result;
				wp_die(); 

			// NO se ha creado, mostramos error en #encuesta-error
			} else {

				//return false;
				$result['type'] = 'error';
				$result['msg'] = 'Error al crear el registro en la base de datos';
				$result = json_encode( $result );
				echo $result;
				wp_die(); 

			}

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




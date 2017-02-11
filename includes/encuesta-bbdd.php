<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Crea la tabla encuesta en la base de datos o la actualiza
*/
function encuesta_database_install() {

	global $wpdb;
	//$installed_ver = get_option( "encuesta_db_version", '1.0' );

	//if ( $installed_ver != ENCUESTA_BBDD_VERSION ) {

		$table_name = $wpdb->prefix . 'encuesta';

		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			respuesta VARCHAR(30) DEFAULT '' NOT NULL,
			email VARCHAR(100) DEFAULT '' NOT NULL,
			UNIQUE KEY id (id)
		);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		update_option( "encuesta_db_version", ENCUESTA_BBDD_VERSION );

	//}

}

/**
* Comprueba si ha cambiado la versión de la base de datos
* y ejecuta la función encuesta_database_install en caso afirmativo
*/
function encuesta_update_db_check() {

	$installed_ver = get_option( "encuesta_db_version", '1.0' );

    if ( $installed_ver != ENCUESTA_BBDD_VERSION ) {

        encuesta_database_install();

    }

}

add_action( 'plugins_loaded', 'encuesta_update_db_check' );

/**
* Crea un registro en la tabla encuesta
* @param string $encuesta_radiochoices
* @param string $encuesta_email
* @return mixed int $wpdb->insert_id | bool(false)
*/
function encuesta_insert( $encuesta_radiochoices, $encuesta_email ) {
	$radiochoices_length = strlen( $encuesta_radiochoices );
	if( $radiochoices_length == 0 || $radiochoices_length >= 30  ) {
		return false;
	}
	$email_length = strlen( $encuesta_email );
	$valid_email = is_email( $encuesta_email );
	if( $email_length == 0 || $email_length >= 100 || ! $valid_email ) {
		return false;
	}

	global $wpdb;
	$table_name = $wpdb->prefix . "encuesta";

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

	if( $inserted ) {
		return $wpdb->insert_id;
	} else {
		return false;
	}

}

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
* @param string respuesta
* @return int total registros
*/
function encuesta_get_registros_respuesta( $respuesta = NULL ) {

	if( $respuesta ) {

		global $wpdb;
		$table_name = $wpdb->prefix . "encuesta";

		$results = $wpdb->query(
			$wpdb->prepare("SELECT * FROM $table_name WHERE respuesta = %s", $respuesta )
		);

		return $results;

	} else {

		return false;

	}

}

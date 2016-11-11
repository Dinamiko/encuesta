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


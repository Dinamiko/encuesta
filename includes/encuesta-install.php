<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function encuesta_activation() {
	encuesta_database_install();
}

register_activation_hook( ENCUESTA_PLUGIN_FILE, 'encuesta_activation' );

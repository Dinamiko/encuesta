<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* [encuesta]
* Imprime la aplicación encuesta
*/
function encuesta_shortcode( $atts, $content = null ) {

	global $encuesta_resultados_atts;

	$encuesta_resultados_atts = shortcode_atts( array(), $atts );

	$template = new Encuesta_Template_Loader;

	ob_start();

	$template->get_template_part( 'encuesta' );

	return ob_get_clean();

}

add_shortcode( 'encuesta', 'encuesta_shortcode' );

/**
* [encuesta-resultados]
* Imprime los resultados de la encuesta
*/
function encuesta_resultados_shortcode( $atts, $content = null ) {

	global $encuesta_resultados_atts;

	$encuesta_resultados_atts = shortcode_atts( array(), $atts );

	$template = new Encuesta_Template_Loader;

	ob_start();

	$template->get_template_part( 'encuesta-resultados' );

	return ob_get_clean();

}

add_shortcode( 'encuesta-resultados', 'encuesta_resultados_shortcode' );



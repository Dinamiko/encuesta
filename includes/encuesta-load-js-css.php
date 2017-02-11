<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', 'encuesta_enqueue_styles', 15 );
add_action( 'wp_enqueue_scripts', 'encuesta_enqueue_scripts', 10 );
add_action( 'admin_enqueue_scripts', 'encuesta_admin_enqueue_scripts', 10, 1 );
add_action( 'admin_enqueue_scripts', 'encuesta_admin_enqueue_styles', 10, 1 );

function encuesta_enqueue_styles() {

	wp_register_style( 'encuesta-frontend', plugins_url( 'encuesta/assets/css/frontend.css' ), array(), ENCUESTA_VERSION );
	wp_enqueue_style( 'encuesta-frontend' );

}

function encuesta_enqueue_scripts() {
	
	wp_register_script( 'encuesta-validate', plugins_url( 'encuesta/assets/js/jquery.validate.min.js' ), array( 'jquery' ), '1.13.1', true );
	wp_enqueue_script( 'encuesta-validate' );

	wp_register_script( 'encuesta-frontend', plugins_url( 'encuesta/assets/js/frontend.js' ), array( 'jquery' ), ENCUESTA_VERSION, true );
	wp_enqueue_script( 'encuesta-frontend' );

}

function encuesta_admin_enqueue_styles( $hook = '' ) {

	wp_register_style( 'encuesta-admin', plugins_url( 'encuesta/assets/css/admin.css' ), array(), ENCUESTA_VERSION );
	wp_enqueue_style( 'encuesta-admin' );

}

function encuesta_admin_enqueue_scripts( $hook = '' ) {

	wp_register_script( 'encuesta-admin', plugins_url( 'encuesta/assets/js/admin.js' ), array( 'jquery' ), ENCUESTA_VERSION );
	wp_enqueue_script( 'encuesta-admin' );

}

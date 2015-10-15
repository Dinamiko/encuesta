<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function register_encuesta_menu_page (){

  add_menu_page( 'Encuesta', 'Encuesta', 'manage_options', 'encuesta-registros', 'encuesta_menu_page' , 'dashicons-groups', 31 ); 

}

add_action( 'admin_menu', 'register_encuesta_menu_page' );

function encuesta_menu_page () { ?>

  <div class="wrap">

      <?php require_once( 'class-encuesta-list-table.php' );

      $wp_list_table = new Encuesta_List_Table();

      if( isset( $_POST['s'] ) ){

          $wp_list_table->prepare_items( $_POST['s'] );

      } else {

          $wp_list_table->prepare_items();

      } 

      ?>

      <?php $wp_list_table->display(); ?>

  </div>

<?php }

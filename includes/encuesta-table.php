<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function register_encuesta_menu_page (){

  add_menu_page( 'Encuesta', 'Encuesta', 'manage_options', 'encuesta-registros', 'encuesta_menu_page' , 'dashicons-groups', 31 ); 

}

add_action( 'admin_menu', 'register_encuesta_menu_page' );

function encuesta_menu_page () { ?>

  <div class="wrap">

      <h2 style="position:relative;width:100%;float:left;margin-bottom:15px;"><?php _e('Encuesta', 'encuesta');?>
          <a style="position:absolute;top:10px;right:15px;" class="button-primary" href="admin.php?page=encuesta-registros&action=download&total=-1"><?php _e('Descargar Excel (.xls)', 'encuesta');?></a>
      </h2>

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

/**
* Descarga un excel con los registros
*/
function encuesta_download() {

  if( current_user_can('manage_options' ) ) {

        if( isset( $_GET['total'] ) && $_GET['action'] == 'download' ) {

            $data = array();

            global $wpdb;
            $table_name = $wpdb->prefix . 'encuesta';
            $id = $_GET['total'];

            $rows = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY id DESC" );

            foreach ( $rows as $row ) {
     
                array_push( $data, array(
                    "ID" => $row->id,
                    "Fecha registro" => $row->time,
                    "Respuesta" => $row->respuesta,
                    "Email" => $row->email,
                  ) 
                );

            }

            function cleanData(&$str) {
              $str = preg_replace("/\t/", "\\t", $str);
              $str = preg_replace("/\r?\n/", "\\n", $str);
              if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            }

            // filename for download
            $filename = "encuesta-" . date('d-m-Y') . ".xls";

            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Content-Type: application/vnd.ms-excel");

            $flag = false;

            foreach($data as $row) {
              if(!$flag) {
                // display field/column names as first row
                echo implode("\t", array_keys($row)) . "\r\n";
                $flag = true;
              }
              array_walk($row, 'cleanData');
              echo implode("\t", array_values($row)) . "\r\n";
            }

            exit;        

        }

  }



}

add_action('init', 'encuesta_download' );



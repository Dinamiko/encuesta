<?php
class Ajax_Test extends WP_Ajax_UnitTestCase {

  function test_ajax_response_ok() {
    encuesta_activation();
    //$_REQUEST['security'] = wp_create_nonce( $this->admin-> );
    //wp_nonce_field( 'encuesta_action', 'encuesta_nonce_field' );
    //$nonce = wp_create_nonce( 'encuesta_nonce_field' );


    try {
      $_POST['encuesta_radiochoices'] = 'Huevo';
      $_POST['encuesta_email'] = 'aaa@bbbb.com';
      //$_POST['encuesta_nonce_field'] = $nonce;
      $this->_handleAjax( 'encuesta_ajax' );
      $this->fail( 'Expected exception: WPAjaxDieContinueException' );
    } catch ( WPAjaxDieContinueException $e ) {}

    $response = json_decode( $this->_last_response, true );
    $this->assertTrue( $response['success'] );
    $this->assertInternalType( 'array', $response['data'] );
    $this->assertEquals( 'success', $response['data']['type'] );
    $this->assertEquals( 'Gracias por participar!', $response['data']['msg'] );
    $this->assertInternalType( 'integer', $response['data']['inserted_id'] );
  }

  function test_ajax_response_ko_no_fields() {
    try {
      $this->_handleAjax( 'encuesta_ajax' );
      $this->fail( 'Expected exception: WPAjaxDieContinueException' );
    } catch ( WPAjaxDieContinueException $e ) {}

    $response = json_decode( $this->_last_response, true );
    $this->assertFalse( $response['success'] );
  }

  function test_ajax_response_ko_empty_radiochoices() {
    encuesta_activation();
    $_POST['encuesta_radiochoices'] = '';
    $_POST['encuesta_email'] = 'aaa@bbbb.com';
    try {
      $this->_handleAjax( 'encuesta_ajax' );
      $this->fail( 'Expected exception: WPAjaxDieContinueException' );
    } catch ( WPAjaxDieContinueException $e ) {}

    $response = json_decode( $this->_last_response, true );
    $this->assertFalse( $response['success'] );
  }

  function test_ajax_response_ko_empty_email() {
    encuesta_activation();
    $_POST['encuesta_radiochoices'] = 'Lorem';
    $_POST['encuesta_email'] = '';
    try {
      $this->_handleAjax( 'encuesta_ajax' );
      $this->fail( 'Expected exception: WPAjaxDieContinueException' );
    } catch ( WPAjaxDieContinueException $e ) {}

    $response = json_decode( $this->_last_response, true );
    $this->assertFalse( $response['success'] );
  }

  function test_ajax_response_ko_incorrect_email() {
    encuesta_activation();
    $_POST['encuesta_radiochoices'] = 'Lorem';
    $_POST['encuesta_email'] = 'lorem-ipsum.com';
    try {
      $this->_handleAjax( 'encuesta_ajax' );
      $this->fail( 'Expected exception: WPAjaxDieContinueException' );
    } catch ( WPAjaxDieContinueException $e ) {}

    $response = json_decode( $this->_last_response, true );
    $this->assertFalse( $response['success'] );
  }

}
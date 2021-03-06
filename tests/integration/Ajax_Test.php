<?php
class Ajax_Test extends \Codeception\TestCase\WPAjaxTestCase {
  public function setUp() {
		parent::setUp();
    encuesta_activation();
  }

  function test_ajax_not_verified_nonce() {
    try {
      //$_POST['encuesta_nonce'] = '';
      $_POST['encuesta_radiochoices'] = 'Huevo';
      $_POST['encuesta_email'] = 'aaa@bbbb.com';
      $this->_handleAjax( 'encuesta_ajax' );
      $this->fail( 'Expected exception: WPAjaxDieContinueException' );
    } catch ( WPAjaxDieContinueException $e ) {}

    $response = json_decode( $this->_last_response, true );
    $this->assertFalse( $response['success'] );
  }

  function test_ajax_response_ok() {
    try {
      $_POST['encuesta_nonce'] = wp_create_nonce( 'encuesta-nonce' );
      $_POST['encuesta_radiochoices'] = 'Huevo';
      $_POST['encuesta_email'] = 'aaa@bbbb.com';
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
      $_POST['encuesta_nonce'] = wp_create_nonce( 'encuesta-nonce' );
      $this->_handleAjax( 'encuesta_ajax' );
      $this->fail( 'Expected exception: WPAjaxDieContinueException' );
    } catch ( WPAjaxDieContinueException $e ) {}

    $response = json_decode( $this->_last_response, true );
    $this->assertFalse( $response['success'] );
  }

  function test_ajax_response_ko_empty_radiochoices() {
    $_POST['encuesta_nonce'] = wp_create_nonce( 'encuesta-nonce' );
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
    $_POST['encuesta_nonce'] = wp_create_nonce( 'encuesta-nonce' );
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
    $_POST['encuesta_nonce'] = wp_create_nonce( 'encuesta-nonce' );
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

<?php
class BBDD_Test extends \Codeception\TestCase\WPAjaxTestCase {
  public function setUp() {
		parent::setUp();
    encuesta_activation();
  }

  /**
  * TODO test_encuesta_database_install() {}
  */

  function test_encuesta_insert_ok() {
    $this->assertEquals( 0, encuesta_get_registros() );

    $encuesta_radiochoices = 'Huevo';
    $encuesta_email = 'aaa@bbbb.com';
    $inserted = encuesta_insert( $encuesta_radiochoices, $encuesta_email );
    $this->assertEquals( 1, encuesta_get_registros() );
  }

  function test_encuesta_insert_ko() {
    $encuesta_radiochoices = '';
    $encuesta_email = '';
    $inserted = encuesta_insert( $encuesta_radiochoices, $encuesta_email );
    $this->assertFalse( $inserted );

    $encuesta_radiochoices = 'Huevo';
    $encuesta_email = '';
    $inserted = encuesta_insert( $encuesta_radiochoices, $encuesta_email );
    $this->assertFalse( $inserted );

    $encuesta_radiochoices = '';
    $encuesta_email = 'aaa@bbbb.com';
    $inserted = encuesta_insert( $encuesta_radiochoices, $encuesta_email );
    $this->assertFalse( $inserted );

    $encuesta_radiochoices = 'HuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevoHuevo';
    $encuesta_email = 'aaa@bbbb.com';
    $inserted = encuesta_insert( $encuesta_radiochoices, $encuesta_email );
    $this->assertFalse( $inserted );
  }

  function test_encuesta_get_registros() {
    $encuesta_radiochoices = 'Huevo';
    $encuesta_email = 'aaa@bbbb.com';
    $inserted = encuesta_insert( $encuesta_radiochoices, $encuesta_email );
    $this->assertEquals( 1, encuesta_get_registros() );

    $encuesta_radiochoices = 'Huevo';
    $encuesta_email = 'aaa@bbbb.com';
    $inserted = encuesta_insert( $encuesta_radiochoices, $encuesta_email );
    $this->assertEquals( 2, encuesta_get_registros() );
  }

  function test_encuesta_get_registros_respuesta() {
    $encuesta_radiochoices = 'Huevo';
    $encuesta_email = 'aaa@bbbb.com';
    $inserted = encuesta_insert( $encuesta_radiochoices, $encuesta_email );
    $this->assertEquals( 1, encuesta_get_registros_respuesta( 'Huevo' ) );
    $this->assertEquals( 0, encuesta_get_registros_respuesta( 'Gallina' ) );
    $this->assertFalse( encuesta_get_registros_respuesta() );
  }

}

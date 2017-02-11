<?php
class Load_JS_CSS_Test extends WP_UnitTestCase {

  public function test_file_hooks() {
		$this->assertNotFalse( has_action( 'wp_enqueue_scripts', 'encuesta_enqueue_styles' ) );
    $this->assertNotFalse( has_action( 'wp_enqueue_scripts', 'encuesta_enqueue_scripts' ) );
    $this->assertNotFalse( has_action( 'admin_enqueue_scripts', 'encuesta_admin_enqueue_scripts' ) );
    $this->assertNotFalse( has_action( 'admin_enqueue_scripts', 'encuesta_admin_enqueue_styles' ) );
	}

  function test_enqueued_styles() {
		encuesta_enqueue_styles();
		$this->assertTrue( wp_style_is( 'encuesta-frontend', 'enqueued' ) );

    encuesta_admin_enqueue_scripts();
    $this->assertTrue( wp_script_is( 'encuesta-admin', 'enqueued' ) );
	}

	function test_enqueued_scripts() {
		encuesta_enqueue_scripts();
		$this->assertTrue( wp_script_is( 'encuesta-validate', 'enqueued' ) );
		$this->assertTrue( wp_script_is( 'encuesta-frontend', 'enqueued' ) );

    encuesta_admin_enqueue_scripts();
    $this->assertTrue( wp_script_is( 'encuesta-admin', 'enqueued' ) );
	}

}

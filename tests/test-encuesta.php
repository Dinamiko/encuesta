<?php
class Encuesta_Test extends WP_UnitTestCase {

  public function test_instance() {
		$this->assertClassHasStaticAttribute( 'instance', 'Encuesta' );
	}

	public function test_constants() {
		$path = str_replace( 'tests/', '', plugin_dir_url( __FILE__ ) );
		$this->assertSame( ENCUESTA_PLUGIN_URL, $path );

		$path = str_replace( 'tests/', '', plugin_dir_path( __FILE__ ) );
		$path = substr( $path, 0, -1 );
		$edd  = substr( ENCUESTA_PLUGIN_DIR, 0, -1 );
		$this->assertSame( $edd, $path );

		$path = str_replace( 'tests/', '', plugin_dir_path( __FILE__ ) );
		$this->assertSame( ENCUESTA_PLUGIN_FILE, $path.'encuesta.php' );
	}

  public function test_includes() {
    $this->assertFileExists( ENCUESTA_PLUGIN_DIR . 'includes/encuesta-load-js-css.php' );
    $this->assertFileExists( ENCUESTA_PLUGIN_DIR . 'includes/encuesta-functions.php' );
    $this->assertFileExists( ENCUESTA_PLUGIN_DIR . 'includes/class-encuesta-template-loader.php' );
    $this->assertFileExists( ENCUESTA_PLUGIN_DIR . 'includes/encuesta-shortcodes.php' );
    $this->assertFileExists( ENCUESTA_PLUGIN_DIR . 'includes/encuesta-bbdd.php' );
    $this->assertFileExists( ENCUESTA_PLUGIN_DIR . 'includes/encuesta-table.php' );
    $this->assertFileExists( ENCUESTA_PLUGIN_DIR . 'includes/encuesta-install.php' );
  }

}

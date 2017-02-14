<?php
class Shortcodes_Test extends \Codeception\TestCase\WPAjaxTestCase {
  public function setUp() {
		parent::setUp();
    encuesta_activation();
  }

  public function test_shortcodes_are_registered() {

		global $shortcode_tags;
		$this->assertArrayHasKey( 'encuesta', $shortcode_tags );
    $this->assertArrayHasKey( 'encuesta-resultados', $shortcode_tags );
  }

  public function test_encuesta_shortcode() {
		$this->assertInternalType( 'string', encuesta_shortcode( array() ) );
    $this->assertContains( '<div id="encuesta-container">', encuesta_shortcode( array() ) );
    $this->assertContains( '<form id="form-encuesta">', encuesta_shortcode( array() ) );
    $this->assertContains( '<input type="hidden" id="encuesta-nonce', encuesta_shortcode( array() ) );
	}

  public function test_form_should_appear_at_the_end_of_the_content() {
    $pid = $this->factory->post->create( array(
      'post_title'   => 'A Title',
      'post_content' => '[encuesta]'
    ) );
    $post = get_post( $pid );
    $content = apply_filters( 'the_content', $post->post_content );

    $this->assertContains( 'form-encuesta', $content );
  }

  public function test_encuesta_resultados_shortcode() {
		$this->assertInternalType( 'string', encuesta_resultados_shortcode( array() ) );
    $this->assertContains( '<div class="encuesta-resultados-container">', encuesta_resultados_shortcode( array() ) );
	}

  public function test_results_should_appear_at_the_end_of_the_content() {
    $pid = $this->factory->post->create( array(
      'post_title'   => 'A Title',
      'post_content' => '[encuesta-resultados]'
    ) );
    $post = get_post( $pid );
    $content = apply_filters( 'the_content', $post->post_content );

    $this->assertContains( 'encuesta-resultados-container', $content );
  }

}

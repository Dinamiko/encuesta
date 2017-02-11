<?php
class Form_Test extends WP_UnitTestCase {

  function test_form_should_appear_at_the_end_of_the_content() {
    $pid = $this->factory->post->create( array(
      'post_title'   => 'A Title',
      'post_content' => '[encuesta]'
    ) );
    $post = get_post( $pid );
    $content = apply_filters( 'the_content', $post->post_content );

    $this->assertContains( 'form-encuesta', $content );
  }

}

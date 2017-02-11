QUnit.module( 'Form', {}, function() {

  QUnit.module( 'lorem ipsum', {}, function() {

    QUnit.test( 'dolor sit amet', function( assert ) {
      var el = jQuery('#form-encuesta');
      var form = new Form( el );

      assert.ok( true );
    });

  });

});

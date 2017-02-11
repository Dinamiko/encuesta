
QUnit.module( 'The function "getVat"', {}, function() {

  QUnit.module( 'when the quantity is an integer', {}, function() {

    QUnit.test( 'should return 21% of the given value', function( assert ) {
      var result = getVat( 1000 );
      assert.equal( result, 210 );
    });

  });

  QUnit.module( 'when the quantity is a string', {}, function() {

    QUnit.test( 'should accept values that use dot as the thousands separator and return 21% of the given value', function( assert ) {
      var result = getVat( '1.000' );
      assert.equal( result, 210 );
    });

    QUnit.test( 'should accept values that use comma as the decimal separator and return 21% of the given value', function( assert ) {
      var result = getVat( '100,00' );
      assert.equal( result, 21 );
    });

    // ...

  });

});

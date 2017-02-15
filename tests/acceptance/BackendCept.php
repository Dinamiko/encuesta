<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('backend');

$I->am( 'visitor' );
$I->amOnPage( '/' );
$I->amGoingTo('send encuesta form');
$I->sendAjaxPostRequest('http://wp-test.dev/wp-admin/admin-ajax.php',
  array(
    'action' => 'encuesta_ajax',
    'encuesta_radiochoices' => 'Gallina',
    'encuesta_email' => 'lorem@ipsum.com',
    // TODO function for checking nonce
    //'encuesta_nonce' => ''
  )
);
$I->see('Gracias por participar!');

$I->am( 'admin' );
$I->loginAsAdmin();
$I->amOnPage( 'wp-admin/admin.php?page=encuesta-registros' );
$I->expect('see list table');
$I->seeElement('.wp-list-table');
$I->expect('see email');
$I->see('lorem@ipsum.com');

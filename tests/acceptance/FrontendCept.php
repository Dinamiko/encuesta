<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('test frontend');

$I->am( 'site visitor' );
$I->amOnPage('/');
$I->seeElement('#form-encuesta');

$I->amGoingTo('send encuesta form');
$I->sendAjaxPostRequest('http://wp-test.dev/wp-admin/admin-ajax.php',
  array(
    'action' => 'encuesta_ajax',
    'encuesta_radiochoices' => 'Gallina',
    'encuesta_email' => 'aaa@bbb.com',
    // TODO function for checking nonce
    //'encuesta_nonce' => ''
  )
);
$I->expect('is sent correctly');
$I->see('Gracias por participar!');

//$I->loginAsAdmin();
/*
$I->am( 'an admin' );
$I->wantToTest( 'create a post' );
$I->amOnPage( 'wp-admin/edit.php' );
$I->see( 'Add New' );
$I->seeElement('.page-title-action');
$I->click( '.page-title-action' );
$I->see( 'Publish' );
$I->fillField('#post input[type=text]', 'Test Post');
$I->click( 'publish' );
$I->see( 'Post published.' );
*/

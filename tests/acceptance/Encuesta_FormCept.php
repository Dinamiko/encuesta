<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('perform actions and see result');

$I->amOnPage('/');
$I->seeElement('#form-encuesta');

$I->loginAsAdmin();

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

<?php
// Login to the demo site
$I = new AcceptanceTester($scenario);
$I->wantTo('Login to the demo site');
$I->amonPage('/');
$I->fillfield( 'input#bp-login-widget-user-login', 'demo' );
$I->fillfield( 'input#bp-login-widget-user-pass', 'demo' );
$I->click('Log In');

?>

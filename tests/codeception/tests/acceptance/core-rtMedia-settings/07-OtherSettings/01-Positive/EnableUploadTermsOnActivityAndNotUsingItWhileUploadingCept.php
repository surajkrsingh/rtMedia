<?php

/**
* Scenario : Enable Upload terms on Activity Page and NOT using it while posting the status.
*/

    use Page\Login as LoginPage;
    use Page\UploadMedia as UploadMediaPage;
    use Page\DashboardSettings as DashboardSettingsPage;
    use Page\Constants as ConstantsPage;
    use Page\BuddypressSettings as BuddypressSettingsPage;

    $clickonCheckbox = false;

    $I = new AcceptanceTester( $scenario );
    $I->wantTo( 'Enable Upload terms on Activity Page and NOT using it while posting the status.' );

    $loginPage = new LoginPage( $I );
    $loginPage->loginAsAdmin( ConstantsPage::$userName, ConstantsPage::$password );

    $settings = new DashboardSettingsPage( $I );
    $settings->gotoSettings( ConstantsPage::$otherSettingsUrl );

    $verifyEnableStatusOfTermsOfServicesCheckboxOnActivity = $settings->verifyStatus( ConstantsPage::$activityUploadTermsLabel, ConstantsPage::$activityUploadTermsCheckbox, ConstantsPage::$scrollPosForOtherSettingsTab );

    if ( $verifyEnableStatusOfTermsOfServicesCheckboxOnActivity ) {
        echo nl2br( ConstantsPage::$enabledSettingMsg . "\n" );
    } else {
        $settings->enableSetting( ConstantsPage::$activityUploadTermsCheckbox );
        $settings->setValue( ConstantsPage::$termsOfServicePageLinkLabel, ConstantsPage::$termsOfServicePageLinkTextbox, ConstantsPage::$termsOfServicePageLinkValue );
        $settings->saveSettings();
    }

    $settings->assertTextboxNotEmpty();
    $settings->enableUploadFromActivity();
    $settings->disableDirectUpload();
    $settings->enableRequestedMediaTypes( ConstantsPage::$photoLabel, ConstantsPage::$photoCheckbox );

    $buddypress = new BuddypressSettingsPage( $I );
    $buddypress->gotoActivity();

    $uploadmedia = new UploadMediaPage( $I );
    $uploadmedia->addStatus( "Testing when Upload Terms of Services add-on is enabled and NOT Using it." );
    $I->seeElement( ConstantsPage::$uploadTermsCheckbox );
    $uploadmedia->uploadMediaFromActivity( ConstantsPage::$imageName, ConstantsPage::$numOfMedia, $clickonCheckbox );
?>

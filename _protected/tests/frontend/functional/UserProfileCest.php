<?php

namespace tests\frontend;

class UserProfileCest
{
    // tests
    public function testUserProfileList(FunctionalTester $I)
    {
        $I->amOnPage(['user-profile']);
        $I->canSee('About');
        //$I->seeLink('Profile');
        //$I->dontSee('EVENTS','.panel-heading');
    }

    public function testArticleAdmin(FunctionalTester $I)
    {
        $I->amOnPage(['user-profile/admin']);
        //$I->canSee('About');
        //$I->canSee('First');
        //$I->dontSee('EVENTS','.panel-heading');
    }
}

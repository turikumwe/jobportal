<?php

use tests\frontend\FunctionalTester;

/* @var $scenario Codeception\Scenario */

$I = new FunctionalTester($scenario);
$I->wantTo('ensure that home page works');
$I->amOnPage(Yii::$app->homeUrl);
$I->see('My name is kora and I am a job agent, how about you?');

$I->seeLink('How to Apply');
$I->click('How to Apply');
$I->see('How to Apply');

// $I->seeLink('NEP Kora Wigire');
// $I->click('NEP Kora Wigire');
// $I->see('Welcome on the page of NEP interventions, how can I help you?');


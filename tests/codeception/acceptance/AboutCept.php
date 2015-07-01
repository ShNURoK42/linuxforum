<?php

use tests\codeception\_pages\AboutPage;

/* @var $scenario Codeception\Scenario */

$I = new AcceptanceTester($scenario);
$I->wantTo('Ensure work feedback page');
AboutPage::openBy($I);
$I->see('за полезный совет');
$I->click('Отправить сообщение');
$I->see('Введите имя пользователя.');
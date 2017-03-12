<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Cadastrar um registro');

$I->amOnPage('/');
$I->fillField('Nome', 'admin');
$I->fillField('Senha', '123');
$I->click('Login');

$I->click('a[href="/l/chuva/cadastrar"]');

$I->submitForm('#chuva-cadastrar', [
    'data' => '2020-12-31',
    'intensidade' => '1',
]);

$id = $I->grabTextFrom('//tbody/tr[1]/th');
$I->click('a[href="/l/chuva/cadastrar"]');

$I->submitForm('#chuva-cadastrar', [
    'data' => '2020-12-31',
    'intensidade' => '2',
]);

$I->canSee('Duplicate entry');

$I->click('a[href="/l/chuva/visualizar"]');
$I->click("a[href='/l/chuva/excluir/$id']");

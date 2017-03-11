<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Editar um registro');

$I->amOnPage('/');
$I->fillField('Nome', 'admin');
$I->fillField('Senha', '123');
$I->click('Login');

$I->click('a[href="/l/agenda/cadastrar"]');

$I->submitForm('#agenda-cadastrar', [
    'categoria' => 'Teste',
    'atividade' => 'Atividade.',
    'data' => '2016-03-05',
    'hora' => '18:51',
    'periodico' => '0',
]);

$id = $I->grabTextFrom('//tbody/tr[1]/th');

$I->click("a[href='/l/agenda/historiar/$id']");

$I->amOnPage("/l/historico/visualizar?historia=1&pagina=2");
$I->click("a[href='/l/historico/editar/$id']");

$I->submitForm('#historico-editar', [
    'categoria' => 'Teste 2',
    'atividade' => 'Atividade 2.',
    'data' => '2016-03-06',
    'hora' => '18:52',
    'periodico' => '1',
]);

$I->see('Sucesso ao editar a história!');
$I->seeInField('categoria', 'Teste 2');
$I->seeInField('atividade', 'Atividade 2.');
$I->seeInField('data', '2016-03-06');
$I->seeInField('hora', '18:52');
$I->seeOptionIsSelected('periodico', 'Sim');

$I->amOnPage("/l/historico/visualizar?historia=1&pagina=2");
$I->click("a[href='/l/historico/excluir/$id']");

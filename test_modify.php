<?php
/*
xTool is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/xtool/blob/main/LICENSE
*/
declare(strict_types=1);
require_once __DIR__.'/header.php';

$html = new \TRP\healDocument\healDocument();

$onsubmit = "Ufo.post('main','test_modify.script.php','dataform');return false;";
$form = $html->el('form',['id'=>'dataform','onsubmit'=>$onsubmit]);
$form->el('input',['type'=>'hidden','name'=>'pattern','value'=>$_GET['pattern']]);

if(empty($_GET['test'])) {
	Ufo::output('header','New test');
	$subject = '';
	$passable = true;
}
else {
	$form->el('input',['type'=>'hidden','name'=>'test','value'=>$_GET['test']]);
	Ufo::output('header','Modify test');
	
	$test_id = $mysqli->real_escape_string($_GET['test']);
	$sql = "SELECT `subject`,`passable` FROM `test` WHERE `id` = '$test_id'";
	$query = $mysqli->query($sql);
	if(!list($subject,$passable) = $query->fetch_array()) {
		exit;
	}
}

$table = $form->el('table');
$tbody = $table->el('tbody');

$tr = $tbody->el('tr');
$tr->el('td')->el('label',['for'=>'subject'])->te('Subject');
$tr->el('td')->el('textarea',['name'=>'subject','rows'=>3])->te($subject);

$tr = $tbody->el('tr');
$tr->el('td')->el('label',['for'=>'passable'])->te('Passable');
$select = $tr->el('td')->el('select',['name'=>'passable']);
$select->el('option',['value'=>1,'xtool-success'])->te('Yes');
$option = $select->el('option',['value'=>0,'xtool-ignore'])->te('No');
if(!$passable) $option->at(['selected']);

if(!empty($_GET['test'])) {
	$tr = $tbody->el('tr');
	$tr->el('td')->el('label',['for'=>'delete'])->te('Delete');
	$select = $tr->el('td')->el('select',['name'=>'delete']);
	$select->el('option',['xtool-ignore'])->te('');
	$select->el('option',['value'=>'confirm','xtool-danger'])->te('Confirm delete');
}

$tr = $tbody->el('tr');
$tr->el('td',['colspan'=>2])->el('button',['type'=>'submit'])->te('Save');

Ufo::output('main',$html);

<?php
/*
xTool is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/xtool/blob/main/LICENSE
*/
declare(strict_types=1);
require_once __DIR__.'/header.php';

Ufo::output('header','New pattern');

$html = new \TRP\healDocument\healDocument();

$onsubmit = "Ufo.post('main','pattern_new.script.php','dataform');return false;";
$form = $html->el('form',['id'=>'dataform','onsubmit'=>$onsubmit]);

$table = $form->el('table');
$tbody = $table->el('tbody');

$tr = $tbody->el('tr');
$tr->el('td')->el('label',['for'=>'title'])->te('Title');
$tr->el('td')->el('input',['name'=>'title','maxlength'=>30,'required']);

$tr = $tbody->el('tr');
$tr->el('td',['colspan'=>2])->el('button',['type'=>'submit'])->te('Save');


Ufo::output('main',$html);

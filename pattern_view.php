<?php
/*
xTool is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/xtool/blob/main/LICENSE
*/
declare(strict_types=1);
require_once __DIR__.'/header.php';

if(empty($_GET['pattern'])) {
	Ufo::get('main','pattern_list.php');
	exit;
}

$pattern_id = $mysqli->real_escape_string($_GET['pattern']);
$sql = "SELECT `title`,`pattern`,`replace` FROM `pattern` WHERE `id` = '$pattern_id'";
$query = $mysqli->query($sql);
if(!list($title,$pattern,$replace) = $query->fetch_array()) {
	Ufo::output('header','Unknown');
	Ufo::output('main','');
	exit;
}

Ufo::output('header','Pattern: '.$title);

$html = new \TRP\healDocument\healDocument();

$onsubmit = "Ufo.post('main','pattern_update.script.php','dataform');return false;";
$form = $html->el('form',['id'=>'dataform','onsubmit'=>$onsubmit]);
$form->el('input',['type'=>'hidden','name'=>'pattern_id','value'=>$_GET['pattern']]);

$table = $form->el('table');
$tbody = $table->el('tbody');

$tr = $tbody->el('tr');
$tr->el('td')->el('label',['for'=>'title'])->te('Title');
$tr->el('td')->el('input',['name'=>'title','maxlength'=>30,'required','value'=>$title]);

$tr = $tbody->el('tr');
$tr->el('td')->el('label',['for'=>'pattern'])->te('Pattern');
$tr->el('td')->el('input',['name'=>'pattern','required','value'=>$pattern,'monospace']);

$tr = $tbody->el('tr');
$tr->el('td')->el('label',['for'=>'replace'])->te('Replace');
$tr->el('td')->el('input',['name'=>'replace','value'=>$replace,'monospace']);

$tr = $tbody->el('tr');
$tr->el('td',['colspan'=>2])->el('button',['type'=>'submit'])->te('Update');

$html->el('h2')->te('Tests');
$table = $html->el('table');
$tr = $table->el('thead')->el('tr');
$tr->el('th')->te('Input');
$tr->el('th')->te('Passable');
$tr->el('th')->te('Match');
$tr->el('th')->te('Output');
$tr->el('th');

$sql = "SELECT `id`,`subject`,`passable` FROM `test` WHERE `pattern_id` = '$pattern_id' ORDER BY `subject`";
$query_test = $mysqli->query($sql);

$tbody = $table->el('tbody');
while($rs_test = $query_test->fetch_object()) {
	$tr = $tbody->el('tr');
	$tr->el('td',['monospace'])->te($rs_test->subject);
	$td = $tr->el('td');
	if($rs_test->passable) {
		$td->el('span',['xtool-success'])->te('Yes');
	}
	else {
		$td->el('span',['xtool-ignore'])->te('No');
	}
	
	$td = $tr->el('td');
	$match = @preg_match('/'.$pattern.'/u', $rs_test->subject);
	if(preg_last_error()!==PREG_NO_ERROR) {
		$td->at(['colspan'=>2]);
		$td->el('span',['xtool-danger'])->te(error_get_last()['message']);
	}
	else {
		if($match) {
				if($rs_test->passable) {
					$td->el('span',['xtool-success'])->te('OK');
				}
				else {
					$td->el('span',['xtool-danger'])->te('False positive');
				}
			}
			elseif($rs_test->passable) {
				$td->el('span',['xtool-danger'])->te('No match');
			}
			else {
				$td->el('span',['xtool-ignore'])->te('Ignored');
			}
			$tr->el('td',['monospace'])->te(preg_replace('/'.$pattern.'/', $replace, $rs_test->subject));
	}
	$onclick = "Ufo.get('main','test_modify.php?pattern=".$_GET['pattern']."&test=".$rs_test->id."')";
	$tr->el('td')->el('button',['onclick'=>$onclick])->te('Edit');
}
$onclick = "Ufo.get('main','test_modify.php?pattern=".$_GET['pattern']."')";
$tr = $tbody->el('tr')->el('td',['colspan'=>'5'])->el('button',['onclick'=>$onclick])->te('Add test');

$html->el('h2')->te('Input pattern');
$form = $html->el('form',['onsubmit'=>"alert('Ready');return false;"]);

$table = $form->el('table');
$tbody = $table->el('tbody');

$tr = $tbody->el('tr');
$tr->el('td')->el('label',['for'=>'textfield'])->te('Label');
$tr->el('td')->el('input',['name'=>'textfield','required','pattern'=>$pattern,'title'=>$title]);

$tr = $tbody->el('tr');
$tr->el('td',['colspan'=>2])->el('button',['type'=>'submit'])->te('Test');


$html->el('h2')->te('Code sample');
$code = $html->el('code');
$code->te('$match = preg_match("/'.$pattern.'/u", $input);');
$code->el('br');
$code->te('$string = preg_replace("/'.$pattern.'/u","'.$replace.'", $input);');

Ufo::output('main',$html);

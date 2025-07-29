<?php
/*
xTool is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/xtool/blob/main/LICENSE
*/
declare(strict_types=1);
require_once __DIR__.'/header.php';

Ufo::output('header','Pattern list');

$html = new \TRP\healDocument\healDocument();

$table = $html->el('table');
$tr = $table->el('thead')->el('tr');
$tr->el('th')->te('Title');
$tr->el('th')->te('Pattern');
$tr->el('th')->te('Replace');

$sql = "SELECT `id`,`title`,`pattern`,`replace` FROM `pattern` ORDER BY `title`";
$query = $mysqli->query($sql);

$tbody = $table->el('tbody');
while($rs = $query->fetch_object()) {
	$onclick = "history.pushState({}, '', '?pattern=".$rs->id."');Ufo.get('main','pattern_view.php?pattern=".$rs->id."')";
	$tr = $tbody->el('tr',['onclick'=>$onclick]);
	$tr->el('td')->te($rs->title);
	$tr->el('td')->te($rs->pattern);
	$tr->el('td')->te($rs->replace);
}

$onclick = "Ufo.get('main','pattern_new.php')";
$tr = $tbody->el('tr')->el('td',['colspan'=>'3'])->el('button',['onclick'=>$onclick])->te('Add pattern');

Ufo::output('main',$html);

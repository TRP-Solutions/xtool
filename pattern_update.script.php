<?php
/*
xTool is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/xtool/blob/main/LICENSE
*/
declare(strict_types=1);
require_once __DIR__.'/header.php';

if(empty($_POST['pattern_id']) || empty($_POST['title'])) {
	Ufo::get('main','pattern_list.php');
	exit;
}

$pattern_id = $mysqli->real_escape_string($_POST['pattern_id']);
$title = $mysqli->real_escape_string($_POST['title']);
$pattern = $mysqli->real_escape_string($_POST['pattern']);
$replace = $mysqli->real_escape_string($_POST['replace']);

$sql = "UPDATE `pattern` SET `title`='$title',`pattern`='$pattern',`replace`='$replace'
	WHERE `id`='$pattern_id'";
$mysqli->query($sql);

Ufo::get('main','pattern_view.php?pattern='.$_POST['pattern_id']);

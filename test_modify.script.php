<?php
/*
xTool is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/xtool/blob/main/LICENSE
*/
declare(strict_types=1);
require_once __DIR__.'/header.php';

if(empty($_POST['pattern'])) {
	Ufo::get('main','pattern_list.php');
	exit;
}

$pattern_id = $mysqli->real_escape_string($_POST['pattern']);
$subject = $mysqli->real_escape_string($_POST['subject']);
$passable = empty($_POST['passable']) ? '0' : '1';
$desired = $mysqli->real_escape_string($_POST['desired']);

if(!empty($_POST['delete']) && $_POST['delete']==='confirm' && !empty($_POST['test'])) {
	$test_id = $mysqli->real_escape_string($_POST['test']);
	$sql = "DELETE FROM `test` WHERE `id`='$test_id'";
	$mysqli->query($sql);
}
elseif(!empty($_POST['test'])) {
	$test_id = $mysqli->real_escape_string($_POST['test']);
	$sql = "UPDATE `test` SET `subject`='$subject',`passable`='$passable',`desired`='$desired'
		WHERE `id`='$test_id'";
	$mysqli->query($sql);
}
else {
	$sql = "INSERT INTO `test` (`pattern_id`,`subject`,`passable`,`desired`)
		VALUES ('$pattern_id','$subject','$passable','$desired')";
	$mysqli->query($sql);
}

Ufo::get('main','pattern_view.php?pattern='.$_POST['pattern']);

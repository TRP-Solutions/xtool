<?php
/*
xTool is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/xtool/blob/main/LICENSE
*/
declare(strict_types=1);
require_once __DIR__.'/header.php';

if(!empty($_POST['title'])) {
	$title = $mysqli->real_escape_string($_POST['title']);
	$pattern = $mysqli->real_escape_string('(\d)');
	$replace = $mysqli->real_escape_string('$1');
	
	$sql = "INSERT INTO `pattern` (`title`,`pattern`,`replace`)
		VALUES ('$title','$pattern','$replace')";
	$mysqli->query($sql);
}

Ufo::get('main','pattern_list.php');

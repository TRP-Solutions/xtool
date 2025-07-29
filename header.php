<?php
/*
xTool is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/xtool/blob/main/LICENSE
*/
declare(strict_types=1);

require_once __DIR__.'/config.php';
require_once __DIR__.'/lib/heal-document/HealDocument.php';
require_once __DIR__.'/lib/ufo-ajax/ufo.php';

define('TITLE','xTool');

$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_BASE);
$mysqli->set_charset('utf8mb4');

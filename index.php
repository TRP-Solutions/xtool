<?php
/*
xTool is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/xtool/blob/main/LICENSE
*/
declare(strict_types=1);
require_once __DIR__.'/header.php';

$doc = new \TRP\healDocument\healDocument('html');
$html = $doc->el('html',['lang'=>'en']);
$head = $html->el('head');

$head->el('meta',['charset'=>'utf-8']);
$head->el('meta',['name'=>'viewport','content'=>'width=device-width, initial-scale=1.0']);
$head->el('title')->te(TITLE);
$head->el('link',['rel'=>'stylesheet','href'=>'style.css?'.time()]);
$head->el('script',['src'=>'lib/ufo-ajax/ufo.js']);

if(empty($_GET['pattern'])) {
	$onload = "Ufo.get('main','pattern_list.php');";
}
else {
	$onload = "Ufo.get('main','pattern_view.php?pattern=".$_GET['pattern']."');";
}
$body = $html->el('body',['onload'=>$onload]);
$nav = $body->el('h1',['id'=>'header'])->te('Loading ...');
$body->el('main',['id'=>'main']);

echo $doc;

<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/prepend.php');
$before = $timestamp = strtotime("-3 month");

//お知らせ
$news = $base->getValidateNews();
$base->t->assign('news',$news);

$base->t->assign('gnavi','index');
$base->t->assign('h1','ホーム');
$base->t->display('index.tpl');
?>

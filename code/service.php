<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/prepend.php');
$before = $timestamp = strtotime("-3 month");

//お知らせ
$news = $base->getValidateNews();
$base->t->assign('news',$news);

$base->t->assign('gnavi','service');

$base->t->assign(
    'position',
    array
    (
        '/'=>'iLUNAホーム',
        '/service'=>'提供サービス'
    )
);
$base->t->assign('h1','提供サービス');
$base->t->display('service.tpl');
?>

<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/prepend.php');
$before = $timestamp = strtotime("-3 month");

//お知らせ
$news = $base->getValidateNews();
$base->t->assign('news',$news);

$base->t->assign('gnavi','recruit');

$base->t->assign(
    'position',
    array
    (
        '/'=>'iLUNAホーム',
        '/recruit'=>'採用情報'
    )
);
$base->t->assign('h1','採用情報');
$base->t->display('recruit.tpl');
?>

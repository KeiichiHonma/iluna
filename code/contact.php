<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/prepend.php');
$before = $timestamp = strtotime("-3 month");

//お知らせ
$news = $base->getValidateNews();
$base->t->assign('news',$news);

$base->t->assign('gnavi','contact');

$base->t->assign(
    'position',
    array
    (
        '/'=>'iLUNAホーム',
        '/contact'=>'お問い合わせ'
    )
);
$base->t->assign('h1','お問い合わせ');
$base->t->display('contact.tpl');
?>

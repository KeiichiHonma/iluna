<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/prepend.php');
//お知らせ
$news = $base->getValidateNews();
$base->t->assign('news',$news);
$base->t->assign('h1','日遊酷棒お問い合わせ完了');

$base->t->assign(
    'position',
    array
    (
        '/'=>'iLUNAホーム',
        '/kujapan/contact'=>'日遊酷棒お問い合わせ完了'
    )
);

$base->t->display('kujapan/done.tpl');
?>

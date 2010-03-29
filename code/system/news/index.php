<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/system/prepend.php');

//お知らせ
$base->makeLimitTo();
$base->setFound();
$news = $base->getValidateNews($base->sp_limit['from'],$base->sp_limit['to']);
$base->assignSp($base->rows,'/system/news/index');
$base->t->assign('news',$news);

$base->t->assign('snavi','news');
$base->t->assign('h1','システム管理');
$base->t->display('system/news/index.tpl');
?>

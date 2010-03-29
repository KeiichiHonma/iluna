<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/system/prepend.php');

$nid = $base->getPathVal('nid');
$news = $base->getOneNews($nid);
$base->t->assign('news',$news);

$base->t->assign('snavi','news');
$base->t->assign('h1','システム管理');
$base->t->display('system/news/view.tpl');
?>

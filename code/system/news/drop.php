<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/system/prepend.php');

if ( strcasecmp($_SERVER['REQUEST_METHOD'],'POST') == 0 && is_numeric($_POST['nid'])){
    require_once('system/news/logic.php');
    $systemNewsLogic =& systemNewsLogic::static_getInstance();
    
    $systemNewsLogic->dropNews($_POST['nid']);
    $base->commit();
    $base->redirectPage('/system/news/');
}else{
    $nid = $base->getPathVal('nid');
    $news = $base->getOneNews($nid);
    $base->t->assign('news',$news);
    $base->t->assign('nid',$nid);
}

$base->t->assign('snavi','news');
$base->t->assign('h1','システム管理');
$base->t->display('system/news/drop.tpl');
?>

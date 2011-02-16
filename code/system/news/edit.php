<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/system/prepend.php');

if ( strcasecmp($_SERVER['REQUEST_METHOD'],'POST') == 0 && is_numeric($_POST['nid'])){
    require_once('system/news/logic.php');
    $systemNewsLogic = new systemNewsLogic();
    
    $_POST['date'] = mktime(0, 0, 0, $_POST['date_Month'],$_POST['date_Day'],$_POST['date_Year']);
    if($systemNewsLogic->checkParam()){

        $systemNewsLogic->editNews($_POST['nid']);
        $base->commit();
        $base->redirectPage('/system/news/');
    }else{

    }
}else{
    $nid = $base->getPathVal('nid');
    $news = $base->getOneNews($nid);
    //set
    $_POST['date'] = $news[0]['col_date'];
    $_POST['title'] = $news[0]['col_title'];
    $_POST['news'] = $news[0]['col_news'];
    $_POST['url'] = $news[0]['col_url'];
    $_POST['link'] = $news[0]['col_link'];
    $_POST['target'] = $news[0]['col_target'];
    $_POST['press'] = $news[0]['col_press'];
    $_POST['press_title'] = $news[0]['col_press_title'];
    $base->t->assign('nid',$nid);
}

$base->t->assign('snavi','news');
$base->t->assign('h1','システム管理');
$base->t->display('system/news/edit.tpl');
?>

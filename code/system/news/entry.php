<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/system/prepend.php');

if ( strcasecmp($_SERVER['REQUEST_METHOD'],'POST') == 0){
    require_once('system/news/logic.php');
    $systemNewsLogic = new systemNewsLogic();
    
    $_POST['date'] = mktime(0, 0, 0, $_POST['date_Month'],$_POST['date_Day'],$_POST['date_Year']);
    if($systemNewsLogic->checkParam()){

        $systemNewsLogic->entryNews();
        $base->commit();
        $base->redirectPage('/system/news/');
    }else{

    }

}

$base->t->assign('snavi','news');
$base->t->assign('h1','システム管理');
$base->t->display('system/news/entry.tpl');
?>

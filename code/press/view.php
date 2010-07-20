<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/prepend.php');

$nid = $base->getPathVal('nid');

if(!$nid){
    $base->redirectPage('/');
    die();
}

//プレスリリース
$press = $base->getOneNews($nid);
if($press){
    $year = date("Y",$press[0]['col_date']);
    //$base->t->assign('year',$year);
    $month_day = date("md",$press[0]['col_date']);
    if(is_file($_SERVER['DOCUMENT_ROOT'].'/smarty/templates/include/press/'.$year.'/'.$month_day.'.inc')){
        $base->t->assign('date_timestamp',$press[0]['col_date']);
        $base->t->assign('date_ymd',date("Ymd",$press[0]['col_date']));
        $base->t->assign('date_y',date("Y",$press[0]['col_date']));
        $base->t->assign('date_md',date("md",$press[0]['col_date']));
        $base->t->assign('press',$press);
    }
}

$base->t->assign('gnavi','press');
$base->t->assign(
    'position',
    array
    (
        '/'=>'iLUNAホーム',
        $year == date("Y",time()) ? '/press/' : '/press/index/year/'.$year=>'プレスリリース',
        '/press/view/nid/'.$nid=>$press[0]['col_press_title']
    )
);
$base->t->assign('h1',$press[0]['col_press_title']);
$base->t->display('press/view.tpl');
?>

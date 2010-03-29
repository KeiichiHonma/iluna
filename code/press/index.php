<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/prepend.php');

$year = $base->getPathVal('year');

if($year !== FALSE && is_numeric($year) && $year > 2007){

}else{
    $year = date("Y",time());
}
$base->t->assign('year',$year);
//お知らせ
$press = $base->getPress($year);

$base->t->assign('press',$press);
$base->t->assign('gnavi','press');

$base->t->assign(
    'position',
    array
    (
        '/'=>'iLUNAホーム',
        '/press/'=>'プレスリリース'
    )
);
$base->t->assign('h1','プレスリリース');
$base->t->display('press/index.tpl');
?>

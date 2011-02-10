<?php
//set_include_path($_SERVER['DOCUMENT_ROOT'].'/include/');
//set_include_path('include/');
//die();
define('SETTING_INI',        'setting.ini' );
header("Content-type: text/html; charset=utf-8");
$ini = parse_ini_file(get_include_path().'/'.SETTING_INI, true);
//--[ require ]--------------------------------------------------------------
require_once('base.php');
$base = new base();

//--[ DB接続 ]------------------------------------------------------------------
$base->connect();
$base->getTemplate();
$base->getPathInfo();
if($ini['common']['isDebug'] == 1){
    $base->t->assign('debug',TRUE);
}else{
    $base->t->assign('debug',FALSE);
}
$pm = FALSE;//postフラグ
if(strcasecmp($_SERVER['REQUEST_METHOD'],'POST') === 0){
    $pm = TRUE;
}

?>

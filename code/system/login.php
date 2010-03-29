<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/prepend.php');

//ログイン
if ( strcasecmp($_SERVER['REQUEST_METHOD'],'POST') == 0 && $_SERVER['HTTP_REFERER'] == ILUNAURL.'/system/login'){
    if($_POST['code'] == "" || !$_POST['code']){
        require_once('error_code.php');
        $base->throwError(E_AUTH_USER_EMPTY);
    }
    if($_POST['password'] == "" || !$_POST['password']){
        require_once('error_code.php');
        $base->throwError(E_AUTH_PASS_EMPTY);
    }

    $user_value = $base->getUserAll(0,1,'col_code = \''.$_POST['code'].'\'');
    if(!$user_value){
        require_once('error_code.php');
        $base->throwError(E_AUTH_USER_EXIST);
    }

    if(!$base->static_validatePassword( $_POST['password'], $user_value[0]['col_salt'], $user_value[0]['col_password'] )){
         require_once('error_code.php');
         $base->throwError(E_AUTH_PASS_NG);
    }
    
    setcookie("account",$_POST['code'],0,$base->cookie_path);
    setcookie("password",$user_value['0']['col_password'],0,$base->cookie_path);
    $base->redirectPage('/system/');
}

$base->t->assign('h1','ログイン');
$base->t->display('system/login.tpl');
?>

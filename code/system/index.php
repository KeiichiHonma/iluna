<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/system/prepend.php');

$base->t->assign('snavi','index');
$base->t->assign('h1','システム管理');
$base->t->display('system/index.tpl');
?>

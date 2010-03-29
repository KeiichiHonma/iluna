<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/prepend.php');
if(!$base->isLogin()) $base->redirectPage('/system/login');
?>
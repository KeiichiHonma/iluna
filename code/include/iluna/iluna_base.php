<?php
//==========================================================
//  基本クラス
//                                               2007/9/某日
//==========================================================
require_once('smarty_class.php');
class IlunaBase extends smarty_class
{

    function &static_getInstance()
    {
        static $_instance = null;
        if ( is_null( $_instance ) )
        {
            $_instance = new IlunaBase();
        }
        return $_instance;
    }

	function redirectPage($page = '/'){
		header( "HTTP/1.1 301 Moved Permanently" );
		header("Location: ".$page);
		die();
	}

}
?>
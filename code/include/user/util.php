<?php
//==========================================================
//  utilクラス
//                                               2007/9/某日
//==========================================================
require_once('base.php');
class userUtil extends base
{

    function &static_getInstance()
    {
        static $_instance = null;
        if ( is_null( $_instance ) )
        {
            $_instance = new userUtil();
        }
        return $_instance;
    }

	function getUserCount($condition = ''){
		global $db;
		$db->initializeQuery();
		$db->addSelectColumn(array('_id'));
		if($condition !='') $db->addCondition($condition);
		$query = $db->select(T_USER);
		$db->execute($query);
		return $db->intResultRows;
	}
}
?>

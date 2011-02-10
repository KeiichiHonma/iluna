<?php
//==========================================================
//  utilクラス
//                                               2007/9/某日
//==========================================================
require_once('base.php');
class userUtil extends base
{
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

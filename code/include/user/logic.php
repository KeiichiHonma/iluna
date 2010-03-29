<?php
require_once('database.php');
class userLogic extends database
{
    function &static_getInstance()
    {
        static $_instance = null;
        if ( is_null( $_instance ) )
        {
            $_instance = new userLogic();
        }
        return $_instance;
    }

	//SELECT系関数//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getUser($from,$to,$condition = ''){
		$this->addSelectColumn(
		array(
			'_id',
			'code',
			'name'
			));
		if($condition !='') $this->addCondition($condition);
		$this->limit($from,$to);
		$query = $this->select(T_USER);
		$this->execute($query);
		return $this->intResultRows == 0 ? FALSE : $this->arySQLData;
	}

	function getUserAll($from,$to,$condition = ''){
		$this->addSelectColumn(
		array(
			'_id',
			'code',
			'name',
			'password',
			'salt'
			));
		if($condition !='') $this->addCondition($condition);
		$this->limit($from,$to);
		$query = $this->select(T_USER);
		$this->execute($query);
		return $this->intResultRows == 0 ? FALSE : $this->arySQLData;
	}

}
?>
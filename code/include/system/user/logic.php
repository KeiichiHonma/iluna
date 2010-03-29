<?php
require_once('database.php');
class systemUserLogic extends database
{
	var $user_map = array
	(
			'code'=>0,
			'name'=>1,
			'password'=>2
	);
	
    function &static_getInstance()
    {
        static $_instance = null;
        if ( is_null( $_instance ) )
        {
            $_instance = new systemUserLogic();
        }
        return $_instance;
    }

	function getId($code){
		$this->addSelectColumn(array('_id'));
		$this->addCondition('col_code = \''.$code.'\'');
		$query = $this->select(T_USER);
		$this->execute($query);
		return $this->intResultRows == 0 ? FALSE : $this->arySQLData['0']['_id'];
	}

	function getCode($id){
		$this->addSelectColumn(array('code'));
		$this->addCondition('_id = \''.$id.'\'');
		$query = $this->select(T_USER);
		$this->execute($query);
		return $this->intResultRows == 0 ? FALSE : $this->arySQLData['0']['col_code'];
	}
	
	function getCodeList(){
		$this->addSelectColumn(array('code'));
		$query = $this->select(T_USER);
		$this->execute($query);
		return $this->intResultRows == 0 ? FALSE : $this->arySQLData;
	}


	//CSV譖ｸ蜃ｺ縺礼畑
	function getUserCSV(){
		$this->addSelectColumn(array_flip($this->user_map));
		$query = $this->select(T_USER);
		$this->execute($query);
		return $this->intResultRows == 0 ? FALSE : $this->arySQLData;
	}

	//霑ｽ蜉邉ｻ髢｢謨ｰ//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function addUser($param,$csv = FALSE){
		$ary_hash = array();
		global $base;
		$password = $csv === TRUE ? $param[$this->user_map['password']] : $param['password'];
		$ary_hash = $base->static_hashPassword($password);
		$this->addValue(
			array(
				'_id'=>'',
				'ctime'=>time(),
				'mtime'=>time(),
				'code'=>$csv === TRUE ? $param[$this->user_map['code']] : $param['code'],
				'name'=>$csv === TRUE ? $param[$this->user_map['name']] : $param['name'],
				'password'=>$ary_hash['hash'],
				'salt'=>$ary_hash['salt']
			)
		);
		$query = $this->insert(T_USER);
		$this->execute($query);
		return mysql_insert_id();
	}

	//譖ｴ譁ｰ邉ｻ髢｢謨ｰ//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function modUser($uid,$param,$csv = FALSE){
		$bl = TRUE;
		$ary_hash = array();
		global $base;
		$password = $csv === TRUE ? $param[$this->user_map['password']] : $param['password'];
		if(strcasecmp($password,'***************') === 0) $bl = FALSE;//繝代せ繝ｯ繝ｼ繝峨ｒ螟画峩縺励↑縺・
		if($bl){
			$ary_hash = $base->static_hashPassword($password);
			$this->addValue(
				array(
					'mtime'=>time(),
					'code'=>$csv === TRUE ? $param[$this->user_map['code']] : $param['code'],
					'name'=>$csv === TRUE ? $param[$this->user_map['name']] : $param['name'],
					'password'=>$ary_hash['hash'],
					'salt'=>$ary_hash['salt']
				)
			);
		}else{
			$this->addValue(
				array(
					'mtime'=>time(),
					'code'=>$csv === TRUE ? $param[$this->user_map['code']] : $param['code'],
					'name'=>$csv === TRUE ? $param[$this->user_map['name']] : $param['name']
				)
			);
		}
		$this->addCondition('_id = \''.$uid.'\'');
		$query = $this->update(T_USER);
		$this->execute($query);
	}
	
	//蜑企勁縺ｯ縺ｾ縺壹￥縺ｭ繝ｼ縺具ｼ溽ｦ∵ｭ｢縺励◆譁ｹ縺後・繝ｻ繝ｻ
	function delUser($uid){
		$this->addCondition('_id = \''.$uid.'\'');
		$query = $this->delete(T_USER);
		$this->execute($query);
	}

}
?>
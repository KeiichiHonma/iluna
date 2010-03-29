<?php
require_once('base.php');
class systemUtil extends base
{
    function &static_getInstance()
    {
        static $_instance = null;
        if ( is_null( $_instance ) )
        {
            $_instance = new systemUtil();
        }
        return $_instance;
    }

	function csvWriter($ary_data,$infinity = FALSE){//無限にある場合は1行目のカラムを書出さない
		$temp_filename = tempnam( "", 'fl_' );
		$fp = fopen( $temp_filename, "w" );
		
		/* ヘッダの作成例と出力 */
		$contents="";
		fputs($fp, $contents);
		
		foreach($ary_data as $key => $val){
			$contents="";//初期化
			$ary_count = count($val);
			
			//カラム書き出しデバッグ用
			if($infinity === FALSE){
				$i=0;
				foreach($val as $key2 => $val2){
					$i++;
					if($key == "0"){
						if($ary_count == $i){
							$contents .= "\"".$key2."\"\n";
						}else{
							$contents .= "\"".$key2."\",";
						}
					}else{
						break;
					}
				}
				prev($ary_data);
			}

			$i=0;
			foreach($val as $key2 => $val2){
				$i++;
				if($ary_count == $i){
					$contents .= "\"".$val2."\"\n";
				}else{
					$contents .= "\"".$val2."\",";
				}
			}
			/* ファイルに出力 */
			//fputs($fp,mb_convert_encoding($contents,$this->SJIS,$this->UTF8));
			fputs($fp,mb_convert_encoding($contents,$this->SJIS,ENC));
		}
		fclose( $fp );
		return $temp_filename;
	}
	
	//codeチェック
	function checkCode($newcode,$table,$id = ''){
		$status = TRUE;
		if($newcode == ''){
			require_once('error_code.php');
			$this->throwError(E_CODE_EMPTY);
		}
		global $db;
		$db->initializeQuery();
		
		if($id != ''){
			$db->addSelectColumn(array('code'));
			$db->addCondition('_id = \''.$id.'\'');
			$query = $db->select($table);
			$db->execute($query);
			//現在のコードと新しいコードが異なっていたら
			$newcode == $db->arySQLData[0]['col_code'] ? $status = FALSE : $db->initializeQuery();
			//if($newcode == $db->arySQLData[0]['col_code']) $status = FALSE;
		}
		if($status === TRUE){
			$db->addSelectColumn(array('code'));
			$query = $db->select($table);
			$db->execute($query);
		    foreach($db->arySQLData as $key => $val){
				if(in_array($newcode,$val)){
					require_once('error_code.php');
					$this->throwError(E_CODE_DUPLICATION);
				}
			}
		}
	}
	
	var $isEmpty = FALSE;
	
	//CSVの場合はcodeが存在したら更新扱いとなる．その為codeが存在しているかどうかのチェックだけ実行する
	function checkCodeCSV($code,$ary_code){
		$bool = TRUE;
	    foreach($ary_code as $key => $val){
			if(in_array($code,$val)){
			    $bool = FALSE;//コードが存在
			}
		}
		return $bool;
	}

}
?>

<?php
//==========================================================
//  DBクラス
//                                               2007/9/某日
//==========================================================
   
define('DATABASE_TABLE_PREFIX', 'tab_iluna_');
define('DATABASE_COLUMN_PREFIX', 'col_');

define('DATABASE_OID_NAME', '_id');

// MySQL JOIN types
define('DATABASE_INNER_JOIN','INNER JOIN');
define('DATABASE_LEFT_JOIN','LEFT JOIN');
define('DATABASE_RIGHT_JOIN','RIGHT JOIN');
define('DATABASE_CROSS_JOIN','CROSS JOIN');

define('DATABASE_NO_LOCK',           0 );
define('DATABASE_SHARED_LOCK',       1 );
define('DATABASE_EXCLUSIVE_LOCK',    2 );
define('DATABASE_DEFAULT_LOCK',      3 );

define('T_USER',                 'tab_iluna_user');
define('T_NEWS',                 'tab_iluna_news');

define('A_USER',    'U');
define('A_NEWS',    'N');

//require_once('smarty_class.php');
class database
{
    function &static_getInstance()
    {
        static $_instance = null;
        if ( is_null( $_instance ) )
        {
            $_instance = new database();
        }
        return $_instance;
    }

    //DB
    var $strDBName        = "iluna";
    var $strHostName    = "localhost";
    var $strPort        = "3306";
    var $strUser;
    var $strPass;
    var $strUser        = "db_sqlip";
    var $strPass        = "kyeoisihcihoi";
    var $arySQLData;
    var $strErrMsg        = "";
    var $intResultRows  = 0;
    var $intResultCols  = 0;
    var $api_db_error = FALSE;
    
    //------------------------------------------------------
    // コンストラクタ(db_define)：再定義用
    //    [引数]
    //        HostName        : ホスト名
    //        DBName            : データベース名
    //        Port            : ポート番号
    //        UserID            : 接続ユーザー名
    //        Password        : 接続パスワード
    //------------------------------------------------------
    function initializeDB( $strHostName, $strDBName, $strPort, $strUser, $strPass ){
        if( $strHostName ) $this->strHostName = $strHostName;
        if( $strDBName   ) $this->strDBName   = $strDBName;
        if( $strPort     ) $this->strPort     = $strPort;
        if( $strUser     ) $this->strUser     = $strUser;
        if( $strPass     ) $this->strPass     = $strPass;
    }

    //------------------------------------------------------
    // データベース接続メソッド(db_connect)
    //  [構文]
    //        boolean $db->setParam();
    //    [引数]
    //        ありません
    //    [戻り値]
    //        接続成功         : true
    //        接続失敗         : false
    //    [その他]
    //        $db->strErrMsg    : エラーメッセージ
    //------------------------------------------------------
    function connect(){
        $blnStatus = true;
        //接続結果セット
        $this->intConn = mysql_connect($this->strHostName,$this->strUser,$this->strPass);
        if( isset($this->intConn)){
            if(TRUE != mysql_select_db( $this->strDBName, $this->intConn )){
                //$this->strErrMsg = "データベース選択に失敗しました。[MSSQL_DB:$this->dbname]";
                //$blnStatus = false;
                //$this->throw_error($this->strErrMsg , true);
                $this->err['num'] = "function connect()";
                $this->err['lev'] = 9;
                $this->err['str'] = "データベース選択に失敗しました。[MSSQL_DB:$this->dbname]";
                $blnStatus = false;
            }
        }else{
            $strErr = mysql_error();
            //$this->strErrMsg = "データベースへの接続に失敗しました。[$strErr]";
            //$blnStatus = false;
            //$this->throw_error($this->strErrMsg , true);
            $this->err['num'] = "function db_connect()";
            $this->err['lev'] = 9;
            $this->err['str'] = "データベースへの接続に失敗しました。[$strErr]";
            $blnStatus = false;
        }
        //return $blnStatus;
        $blnStatus == FALSE ? $this->throwDBError($this->err) : mysql_query("BEGIN");
    }

    //------------------------------------------------------
    // クエリー実行メソッド(execute)
    //  [構文]
    //        boolean $db->doQuery( string SQLQuery);
    //    [引数]
    //        SQLQuery        : SQLクエリ文字列
    //    [戻り値]
    //        成功 : true
    //        失敗 : false
    //    [その他]
    //        $db->arySQLData    : SQL結果データ(2次元配列)
    //        $db->strErrMsg    : エラーメッセージ
    //------------------------------------------------------
    function commit(){
        $blnStatus = true;
        $commit_flag = mysql_query("COMMIT");
        //コミット自体がFALSEだった場合。
        if($commit_flag == FALSE){
            $mysql_error = mysql_error();
            $mysql_errno = mysql_errno();
            require_once('error_code_db.php');
            $ary_db_error[$mysql_errno];
            $this->err['fun'] = __CLASS__.'->'.__FUNCTION__;
            $this->err['num'] = $mysql_errno;
            $this->err['lev'] = 9;
            $this->err['str'][] = '【MESSAGE】'."\n".$ary_db_error[$mysql_errno][0]."\n";
            $this->err['str'][] = '【POINT】'."\n".$mysql_error."\n";
            $this->err['str'][] = '【QUERY】'."\n".$strQuery."\n";
            $this->err['str'][] = '【FILE】'."\n".$_SERVER['SCRIPT_FILENAME']."\n";
            $this->err['str'][] = '【PARAM】'."\n".$_SERVER['REQUEST_URI']."\n";
            $this->err['str'][] = '【REFERER】'."\n".$_SERVER['HTTP_REFERER']."\n";
            //ロールバック処理
            mysql_query("ROLLBACK");
            $blnStatus = false;
        }
        if($blnStatus == FALSE) $this->throwDBError($this->err);
        //return $blnStatus;
    }
    
    //var $isChangeKey = FALSE;
    var $isChangeKey = array(FALSE,DATABASE_OID_NAME);
    //var $changeKeyValue = DATABASE_OID_NAME;
    
    function changeKey($column = DATABASE_OID_NAME){
        $this->isChangeKey = array(TRUE,$column);
    }

    function setFound(){
        $this->found = TRUE;
    }

    //function execute( $strQuery,$column = DATABASE_OID_NAME){
    function execute( $strQuery){
        $blnStatus = true;
        mysql_query("SET NAMES UTF8");
        mysql_query("BEGIN");
        $intResult = 0;
        $this->arySQLData = array();
        
        $intResult = mysql_query( $strQuery );
        //print mb_convert_encoding($strQuery,ENC,'UTF-8');
        //die();
        //$intResult = mysql_query( mb_convert_encoding($strQuery,ENC,'UTF-8') );

        if( $intResult !=FALSE ){
            //まずそう・・・・insert系と分けないt
            @$intRows = mysql_num_rows( $intResult );
            @$intCols = mysql_num_fields( $intResult );
            if( $intRows != 0 || $intCols != 0 ){
                // 結果件数を格納
                $this->intResultRows = $intRows;
                $this->intResultCols = $intCols;

                //データ格納
                for( $j=0; $j<$intRows; $j++){
                    if($this->isChangeKey[0]) $key = mysql_result( $intResult, $j, $this->isChangeKey[1] );///keyに入れるカラム値を取得
                    //print $this->isChangeKey[1].'<br>';
                    //var_dump($this->isChangeKey[1]).'<br>';
                    for( $i=0; $i<$intCols; $i++){
                        $strName  = mysql_field_name( $intResult, $i );
                        $strValue = mysql_result( $intResult, $j, $i );
                        if($this->isChangeKey[0]){
                            $this->arySQLData[$key][$strName] = $strValue;//id or 任意カラムをキーに
                        }else{
                            $this->arySQLData[$j][$strName] = $strValue;
                        }
                        
                    }
                }
                //設定戻し
                if($this->isChangeKey[0]) $this->isChangeKey = array(FALSE,DATABASE_OID_NAME);
                if($this->found){
                    $this->rows = mysql_result(mysql_query( 'SELECT FOUND_ROWS()' ),0,0);
                    $this->found = FALSE;
                }
                //メモリ開放
                mysql_free_result( $intResult );
            }
        }else{
            $mysql_error = mysql_error();
            $mysql_errno = mysql_errno();
            require_once('error_code_db.php');
            $ary_db_error[$mysql_errno];
            $this->err['fun'] = __CLASS__.'->'.__FUNCTION__;
            $this->err['num'] = $mysql_errno;
            $this->err['lev'] = 9;
            $this->err['str'][] = '【MESSAGE】'."\n".$ary_db_error[$mysql_errno][0]."\n";
            $this->err['str'][] = '【POINT】'."\n".$mysql_error."\n";
            $this->err['str'][] = '【QUERY】'."\n".$strQuery."\n";
            $this->err['str'][] = '【FILE】'."\n".$_SERVER['SCRIPT_FILENAME']."\n";
            $this->err['str'][] = '【PARAM】'."\n".$_SERVER['REQUEST_URI']."\n";
            //ロールバック処理
            mysql_query("ROLLBACK");
            $blnStatus = FALSE;
        }
        $this->initializeQuery();
        if($blnStatus == FALSE) $this->throwDBError($this->err);
        

    }

    //------------------------------------------------------
    // エラー終了用メソッド(ERRHTML)
    //  [構文]
    //        boolean $Util->ERRHTML();
    //    [引数]
    //        $HTML        ：エラー内容配列
    //    [戻り値]
    //        なし
    //------------------------------------------------------
    function throwDBError($data=""){
        global $ini;
        //引数が空の場合はデフォルトで設定
        if(is_array($data)==false || $data==""){
            $data['flg'] = false;
            $data['num'] = 999;
            $data['lev'] = 999;
            $data['str'] = "原因不明エラーです。";
        }
        
        //発生したエラーをメールで通知
        if($ini['common']['isMail'] == 1 && isset($ini['common']['mail'])) $this->sendMail($ini['common']['mail']);

        if($ini['common']['isDebug'] == 1){//on
            $param = serialize($data);
var_dump($data);
die();
            $this->redirectPage('/system/error.html?error='.urlencode($param));
            //var_dump($this->err);
            exit;
        }else{//user向け
            //$data['str'] = "現在サーバーが混んでいます。\n時間を置いて再度実行して下さい。";
            //header( "HTTP/1.1 301 Moved Permanently" );
            $param = serialize($data);
var_dump($data);
die();
            $this->redirectPage('/system/error.html?error='.urlencode($param));
            //header("Location: ".URL.'/error.html');
            exit;
        }

    }
    
    function sendMail($mail){
        mb_language("Japanese"); // 日本語モードにする
        mb_internal_encoding("UTF-8"); // この設定がないと文字化けorz
        $to = $mail;//固定
        $from = $mail;//from
        $reply = $mail;//返信先
        
        $title = 'YAKINIKU:DBエラー'.$this->err['num'];
        $body = '';
        if(is_array($this->err['str'])){
            foreach($this->err['str'] as $key => $val){
                $body .= $val;
            }
        }
        $header =
          'From: '.$from."\r\n".
          'Reply-To: '.$reply."\r\n".
          'X-Mailer: PHP/' . phpversion();
        $bl = mb_send_mail($to,$title,$body,$header);
        
        if($bl){
        }else{
        }
    }

    // Search
    var $_select_columns = array();
    
    /**
     * @access private
     */
    var $_join_tables = array();    // for JOIN table
    /**
     * @access private
     */
    var $_conditions = array(); // condition clauses for AND
    /**
     * @access private
     */
    var $_orderby = array();    // for sorting
    /**
     * @access private
     */
    var $_offset = 0;           // for LIMIT
    /**
     * @access private
     */
    var $_limit = -1;           // for LIMIT
    /**
     * @access private
     */
    var $_calcAll = FALSE;      // use SQL_CALC_FOUND_ROWS
    /**
     * @access private
     */
    var $_foundrows = FALSE;        // result of SQL_CALC_FOUND_ROWS
    /**
     * @access private
     */
    var $_lock = DATABASE_DEFAULT_LOCK;
    /**
     * @access private
     */
    var $_select = TRUE;
    /**
     * @access private
     */
    var $_oid_only = FALSE;
    /**
     * @access private
     */
    var $_group_functions = NULL;
    /**
     * @access private
     */
    var $_group_by_columns = array();
    /**
     * @access private
     */
    var $_having = '';
    /**
     * @access private
     */
    var $_alias = NULL;

    function initializeQuery(){
        $this->_select_columns = array();
        $this->_join_tables = array();
        $this->_conditions = array();
        $this->_orderby = array();
        $this->_group_by_columns = array();
        $this->_offset = 0;
        $this->_limit = -1;
        $this->_lock = DATABASE_DEFAULT_LOCK;
        $this->_alias = NULL;
        $this->_values = array();
    }

    function setLock( $lock = DATABASE_DEFAULT_LOCK )
    {
        $this->_lock = $lock;
    }
    

    function addSelectColumn($columns,$alias = NULL){
        $this->_select_columns[$alias] = $columns;
    }

    /**
     * Adds the table specified by <var>tableinfo</var>,
     * and joins it on the condition specified by <var>$conditions</var>,
     * using the join type specified by <var>$type</var>
     * @param object TableInfo $tableinfo
     *  The table which are joined.
     * @param string $conditions
     *  Condition on which the table are joined.If NULL no condition.
     *  Default value is NULL.
     * @param string $type
     *  A join type which are used.
     *  Default value is 'LEFT JOIN'.
     * @param string $alias
     *  The table's alias name. If NULL alias isn't used.
     *  Default value is NULL.
     */
    function addJoin( $table_info, $conditions = NULL,$alias = NULL,$type = DATABASE_INNER_JOIN )
    {
        $this->_join_tables[] = array(
                                      'table' => $table_info,
                                      'on' => $conditions,
                                      'type' => $type,
                                      'alias' => $alias
                                      );
    }
    
    /**
     * @param string $condition
     *  An SQL expression that may appear in WHERE clause.
     */
    function addCondition( $condition )
    {
        $this->_conditions[] = $condition;
    }
    
    /**
     * Specifies the ORDER BY column.
     *
     * @param string $col_name
     *  The column's internal name such as 'tab_user.col_name' that
     *  which will be embedded in the SQL directly.
     * @param bool $reverse
     *  If not <var>FALSE</var>, the result will be returned in reverse order.
     */
    function addOrderColumn( $col_name, $reverse = FALSE )
    {
        $this->_orderby[] = array( $col_name, $reverse );
    }

    function addGroupByColumn( $col_name)
    {
        $this->_group_by_columns[] = $col_name;
    }

/*    function addGroupByColumn( $col_name, $reverse = FALSE )
    {
        $this->_group_by_columns[] = array( $col_name, $reverse );
    }*/
    
    /**
     * Limits the number of rows to return.
     *
     * @param int $offset
     *  The offset of the first row to return.  The offset of the
     *  initial row is 0 (not 1).
     * @param int $limit
     *  The number of rows to be retrieved.  Specify '-1' to retrieve
     *  all rows after <var>offset</var>.
     */
    function limit( $offset = 0, $limit = 21 )
    {
        $this->_offset = $offset;
        $this->_limit = $limit;
    }
    var $found = FALSE;
    var $rows = 0;
    
    function select($table,$alias = NULL){
        $query = "SELECT ";
        if($this->found) $query .= 'SQL_CALC_FOUND_ROWS ';
        $toPutComma = FALSE;
        foreach( $this->_select_columns as $table_alias => $columns )
        {
            foreach( $columns as $special => $column )
            {
                if ( $toPutComma ) {
                    $query .= ', ';
                } else {
                    $toPutComma = TRUE;
                }
                $count_alias = '';
                $isSpecial = FALSE;
                $isSpecials = FALSE;
                //if(strcmp($special,'COUNT') == 0 || strcmp($special,'AVG') == 0 ){
                if(!is_numeric($special)){
                    $isSpecial = TRUE;
                    if(is_array($column)){
                        //special指定が複数あった場合
                        //例
                        //$this->addSelectColumn(
                        //    array(
                        //        'AVG'=>array(array('income','col_income_avg'),array('age','col_age_avg')),
                        //        'COUNT'=>array('_id','col_company_count')
                        //        )
                        //);
                        if(is_array($column[0]) && is_array($column[1])){//2つ以上arrayだったら複数指定とみなす
                            $isSpecials = TRUE;//複数フラグ
                        }else{
                            $count_alias = $column[1];//alias指定してきた
                            $column = $column[0];
                        }

                    }
                }
                
                //special指定が複数あった場合
                if($isSpecials){
                    $query_tmp = '';
                    $toPutComma2 = FALSE;
                    foreach($column as $array){
                        if ( $toPutComma2 ) {
                            $query_tmp .= ', ';
                        } else {
                            $toPutComma2 = TRUE;
                        }
                        
                        $count_alias = $array[1];//alias指定してきた
                        $column = $array[0];
                        
                        $column = ereg("^_id", $column) == TRUE ? $column : DATABASE_COLUMN_PREFIX.$column;
        
                        if($table_alias != '') $column = $table_alias.'.'.$column;
                        if($isSpecial){
                            $column = $count_alias != '' ? $special.'('.$column.')'.' AS '.$count_alias : $special.'('.$column.')';
                        }
                        $query_tmp .= $column;
                    }
                    $query .= $query_tmp;
                }else{
                    $column = ereg("^_id", $column) == TRUE ? $column : DATABASE_COLUMN_PREFIX.$column;
    
                    if($table_alias != '') $column = $table_alias.'.'.$column;
                    if($isSpecial){
                        $column = $count_alias != '' ? $special.'('.$column.')'.' AS '.$count_alias : $special.'('.$column.')';
                    }
                    $query .= $column;
                }

            }
        }

        //$alias = $this->_alias;
        $table =$table . (is_null($alias) ? '' : " AS $alias");
        
        $query .= " FROM ";
        $from = $table;
        $keys = array_keys($this->_join_tables);
        $begin = '';
        $end = '';
        foreach( $keys as $key )
        {
            $from = $begin. $from .$end;
            $begin = '(';
            $end = ')';
            
            $info =& $this->_join_tables[$key];
            //$table_info =& $info['table'];
            $table_name = $info['table'];
            //$table_name = $db->escape( $table_info->getTableName() );
            $conditions = $info['on'];
            $type = $info['type'];
            $join_alias = $info['alias'];
            
            $from .= " $type " . $table_name .
                     (is_null($join_alias) ? '' : " AS $join_alias") .
                     (is_null($conditions) ? '' : " ON $conditions");
        }
        $query .= $from;

        if ( count( $this->_conditions ) > 0 )
        {
            $query .= ' WHERE ';
            $toPutAnd = FALSE;
            foreach( $this->_conditions as $condition )
            {
                if($condition != ''){//怪しい挙動なので一応チェック
                    if ( $toPutAnd ) {
                        $query .= 'AND ';
                    } else {
                        $toPutAnd = TRUE;
                    }
                    $query .= "(${condition})";
                }
            }
        }

        //group by
        if ( count( $this->_group_by_columns ) > 0 )
        {
            $query .= ' GROUP BY ';
            $toPutComma = FALSE;
            foreach($this->_group_by_columns as $column) {
                if ( $toPutComma ) {
                    $query .= ', ';
                } else {
                    $toPutComma = TRUE;
                }
                $query .= $column;
            }
        }

        if ( count( $this->_orderby ) > 0 )
        {
            $query .= ' ORDER BY ';
            $toPutComma = FALSE;
            foreach( $this->_orderby as $ob )
            {
                if ( $toPutComma ) {
                    $query .= ', ';
                } else {
                    $toPutComma = TRUE;
                }
                
                //if ( is_null($ob[0]) )
                //{
                    //$ob[0] = '_id';
                //}
                
                $query .= $ob[0];
                //$query .= ereg("^_id", $ob[0]) == TRUE ? $ob[0] : DATABASE_COLUMN_PREFIX.$ob[0];
                if ( $ob[1] )//デフォルトはFALSE
                {
                    $query .= ' DESC';//大きい順
                }
            }
        }else{
            $query .= is_null($alias) ? ' ORDER BY _id' : ' ORDER BY '.$alias.'._id';//指定がなくて，aliasがあればつけてorder
        }

        if ( $this->_limit != -1 )
        {
            $query .= ' LIMIT '.$this->_offset.','.$this->_limit;
        }
        return $query;

    }

    var $_values = array();

    function addValue($values){
        $this->_values = $values;
    }

    // Insert
    
    function insert($table){
        $query = 'INSERT INTO ';
        $query .= $table.' ';
        $toPutComma = FALSE;
        $left = '';
        $right = '';
        foreach( $this->_values as $key => $val )
        {
            if(!is_numeric($val)) $val = mysql_escape_string($val);
            if ( $toPutComma ) {
                $left .= ', ';
                $right .= ', ';
            } else {
                $toPutComma = TRUE;
            }
            $left .= ereg("^_id", $key) == TRUE ? $key : DATABASE_COLUMN_PREFIX.$key;
            $right .= '\''.$val.'\'';
        }
        $query .= '(';
        $query .= $left;
        $query .= ')';
        $query .= ' VALUES ';
        $query .= '(';
        $query .= $right;
        $query .= ')';
        return $query;
    }
    
    //Update
    function update($table){
        $query = 'UPDATE ';
        $query .= $table;
        $query .= ' SET ';
        $toPutComma = FALSE;
        foreach( $this->_values as $key => $val )
        {
            if(!is_numeric($val)) $val = mysql_escape_string($val);
            if ( $toPutComma ) {
                $query .= ', ';
            } else {
                $toPutComma = TRUE;
            }
            //$query .= ' '.ereg("^_id", $key) == TRUE ? $key : DATABASE_COLUMN_PREFIX.$key.' = \''.$val.'\'';
            $query .= ereg("^_id", $key) == TRUE ? $key : DATABASE_COLUMN_PREFIX.$key.' = \''.$val.'\'';
        }
        if ( count( $this->_conditions ) > 0 )
        {
            $query .= ' WHERE ';
            $toPutAnd = FALSE;
            foreach( $this->_conditions as $condition )
            {
                if ( $toPutAnd ) {
                    $query .= 'AND ';
                } else {
                    $toPutAnd = TRUE;
                }
                $query .= "(${condition})";
            }
        }
        return $query;
    }
    
    //Delete
    function delete($table){
        $query = 'DELETE ';
        $query .= 'FROM ';
        $query .= $table.' ';
        if ( count( $this->_conditions ) > 0 )
        {
            $query .= ' WHERE ';
            $toPutAnd = FALSE;
            foreach( $this->_conditions as $condition )
            {
                if ( $toPutAnd ) {
                    $query .= 'AND ';
                } else {
                    $toPutAnd = TRUE;
                }
                $query .= "(${condition})";
            }
        }
        return $query;
    }

}
?>

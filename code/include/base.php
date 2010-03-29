<?php
//==========================================================
//  基本クラス
//                                               2007/9/某日
//==========================================================
require_once('database.php');
define('ILUNAURL',            'http://'.$_SERVER['SERVER_NAME']);
define('ILUNAURLSSL',         'http://'.$_SERVER['SERVER_NAME']);//sslページは存在しない
class base extends database 
{

    function &static_getInstance()
    {
        static $_instance = null;
        if ( is_null( $_instance ) )
        {
            $_instance = new base();
        }
        return $_instance;
    }

    //smarty
    var $t;

    //common
    var $SJIS            = "SJIS";
    var $EUC            = "EUC-JP";
    var $UTF8            = "UTF-8";
    
    //var $session_name   = "JOBSESSID";
    var $session_name_system   = "ILUNASSID";
    
    var $cookie_time    = 86400;
    var $cookie_path    = "/";

    //--戻り値
    var $ret;
    //--エラー
    var $err = array();
    
    //パスインフォ
    var $ary_path_info = array();

    function getTemplate(){
        require_once('smarty/Smarty.class.php');
        //smarty
        $this->t = new Smarty;
        // Smarty の設定
        $this->t->caching = false;//デバッグ：false,通常：true
/*        $compile_checkが有効の時、キャッシュファイルに入り組んだすべてのテンプレートファイルと設定ファイルは
        修正されたかどうかをチェックされます。もしキャッシュが生成されてからいくつかのファイルが修正されていた場合、
        キャッシュは即座に再生成されます。これは最適なパフォーマンスのためには僅かなオーバーヘッドになるので、
        $compile_checkはfalseにして下さい。*/
        $this->t->compile_check = true;//デバッグ：true,通常：false
        $this->t->template_dir = $_SERVER['DOCUMENT_ROOT'].'/smarty/templates/';
        $this->t->compile_dir  = $_SERVER['DOCUMENT_ROOT'].'/smarty/templates_c/';
        $this->t->config_dir   = $_SERVER['DOCUMENT_ROOT'].'/smarty/configs/';
        $this->t->cache_dir    = $_SERVER['DOCUMENT_ROOT'].'/smarty/cache/';
    }

    //エラー
    function throwError($error_code,$string = ''){
        //$function = $_SERVER['PHP_SELF'];
        $function = __FILE__.__LINE__.__FUNCTION__.__CLASS__;
        //$this->getSmarty();
        //parent::getSmarty();
        if($error_code){
            $data['fun'] = $function;
            $data['num'] = $error_code;
            $data['str'] = constant($error_code).$string;
        }else{
            $data['fun'] = "000000";
            $data['num'] = "000000";
            $data['str'] = "不明なエラーが発生しました。\n時間を置いて再度実行いただきますようお願いいたします。\n\n現象が回避されない場合、\n現象をご報告いただきますようお願いいたします。\n\n\nご連絡先\n\ninfo@iluna.co.jp";
        }
        $this->t->assign('errorlist', $data);
        //$param = serialize($this->err);
        $this->t->display('error.tpl');
        die();
        //$this->redirectPage('/system/error.html?error='.urlencode($param));
        //exit;
    }

    //------------------------------------------------------
    // ログインチェックチェック
    //------------------------------------------------------
    function isLogin() {
        //if(!$this->isSession()) return FALSE;
        if(isset($_COOKIE['account']) && isset($_COOKIE['password'])){
            return $this->checkPassword($_COOKIE['account'],$_COOKIE['password']);
        }else{
            return FALSE;
        }
        return TRUE;
    }
    
    function static_validatePassword( $password, $salt, $hash )
    {
        return (strcasecmp(sha1($salt.$password), $hash) === 0);
    }

    //------------------------------------------------------
    // ハッシュ生成
    //------------------------------------------------------
    function static_genSalt()
    {
        static $_init = FALSE;
        if( ! $_init )
        {
            mt_srand( time() ^ getmypid() );
            $_init = TRUE;
        }

        $b = array();
        for( $i = 0; $i < 4; $i++ )
        {
            // ASCII 32-126 are printable
            $b[] = mt_rand(32, 126);
        }

        return pack('C4', $b[0], $b[1], $b[2], $b[3]);
    }
    
    function static_hashPassword( $password )
    {
        $salt = $this->static_genSalt();
        $hash = sha1( $salt . $password );
        return array( 'salt'=>$salt, 'hash'=>$hash );
    }

    //SELECT系関数//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getUser($from = null,$to = null,$condition = ''){
        $this->addSelectColumn(
        array(
            '_id',
            'code',
            'name'
            ));
        if($condition !='') $this->addCondition($condition);
        if(!is_null($from) && !is_null($to)) $this->limit($from,$to);
        $query = $this->select(T_USER);
        $this->execute($query);
        return $this->intResultRows == 0 ? FALSE : $this->arySQLData;
    }

    function getUserAll($from = null,$to = null,$condition = ''){
        $this->addSelectColumn(
        array(
            '_id',
            'code',
            'name',
            'password',
            'salt'
            ));
        if($condition !='') $this->addCondition($condition);
        if(!is_null($from) && !is_null($to)) $this->limit($from,$to);
        $query = $this->select(T_USER);

        $this->execute($query);
        return $this->intResultRows == 0 ? FALSE : $this->arySQLData;
    }
    
    function checkPassword($account,$password){
        $this->addSelectColumn(array('_id'));
        $this->addCondition('col_code = \''.$account.'\' AND col_password = \''.$password.'\'');
        $query = $this->select(T_USER);
        $this->execute($query);
        return $this->intResultRows == 1 ? TRUE : FALSE;
    }

    //------------------------------------------------------
    // エラー初期化(err_reset)
    //    [引数]
    //        なし
    //------------------------------------------------------
    function err_reset(){
        $this->err['flg'] = false;
        $this->err['num'] = 0;
        $this->err['lev'] = 0;
        $this->err['arr'] = array();
        $this->err['str'] = "";
    }

    var $path_info = '';
    var $path_sp = '';
    var $isSp = FALSE;//検索系
    
    function getPathInfo(){
        $this->path_info = @$_SERVER['PATH_INFO'];
        //パスインフォ。ない場合もあるので@
        @$ary_path_info_tmp = explode('/', $this->path_info);//ない場合もarray(1) { [0]=> string(0) "" } 
        //@$ary_path_info_tmp = array_unique(explode('/', $_SERVER['PATH_INFO']));//ない場合もarray(1) { [0]=> string(0) "" } 
        if(count($ary_path_info_tmp) > 1){
            unset($ary_path_info_tmp[0]);//0の要素は必ず空なので
            $count = count($ary_path_info_tmp);
            foreach($ary_path_info_tmp as $key => $val){
                //最後の要素は意味をなさないのでkeyに入れない
                if($count != $key) $this->ary_path_info[$val] = $ary_path_info_tmp[$key +1];
                if($val == 'sp' && is_numeric($ary_path_info_tmp[$key +1])) $this->isSp = TRUE;//spフラグ
            }
        }
    }
    
    function getPathVal($key){
        if(@array_key_exists($key,$this->ary_path_info)){
            return $this->ary_path_info[$key];
        }else{
            return FALSE;
        }
    }

    var $isSp = FALSE;//検索系
    var $sp_value = 10;
    var $index_section_number = 5;

    var $sp_manager = array();
    var $sp_limit = array();//limit使用
    var $bl_next = FALSE;
    var $block_int = 0;

    function changeSpValue($value = 20){
        $this->sp_value = $value;
    }

    function changeIndexSectionNumber($value = 10){
        $this->index_section_number = $value;
    }

    function makeLimitTo(){
        $this->sp_manager = array();
        $this->block_int = 0;
        if($this->isSp){
            //def値の倍数に変換
            //不正な数字を入力されるのを防ぐ
            $this->block_int = floor($this->getPathVal('sp') / $this->sp_value) * $this->sp_value;//小数点切り捨て
        }
        $this->sp_limit['from'] = $this->block_int;
        $this->sp_limit['to'] = $this->sp_value;
    }

    function assignSp($count,$page_arg){
        
        if(!$count) return FALSE;
        global $con;
        if($count < $this->block_int) $this->block_int = 0;
        if($count <= $this->sp_value){
            $this->t->assign('sp_manager', FALSE);
            return FALSE;
        }
        if($count > 0){
            $index_section_base = $this->index_section_number * $this->sp_value;
            
            //ページリスト生成
            $page_count = ceil($count / $this->sp_value);

            $index = 0;
            $sp = 0;
            for($i=0;$i<$page_count;$i++){
                $index = $index + 1;
                if($this->block_int == $sp){
                    /*
                    0～0.9 セクション1
                    1～1.9 セクション2
                    2～2.9 セクション3
                    小数点1位まで求め、+1して割り切れる場合に対応する。
                    割り切れる場合は次のセクションになるため。
                    また、配列のindexは0スタートのため-1している
                    */
                    $validate_section_number = round($this->block_int / $index_section_base,1);//どのセクションを表示するか
                    $validate_section_index = floor($validate_section_number + 1) - 1;//chunkのindex用に

                    $this->sp_manager['list'][$index] = $this->getSpArray($page_arg,$sp,TRUE);//current
                    $current = $index;
                    $this->sp_manager['current'] = $this->getSpArray($page_arg,$this->sp_manager['list'][$current]['sp']);
                    $sp_string1 = $sp == 0 ? 1 :$sp + 1;
                    $sp_string2_number = $sp + $this->sp_value;
                    $sp_string2 = $count >= $sp_string2_number ? $sp_string2_number : $count;
                    $this->sp_manager['current']['display'] = $sp_string1.'～'.$sp_string2;//件目
                }else{
                    $this->sp_manager['list'][$index] = $this->getSpArray($page_arg,$sp);
                }
                $sp = $sp + $this->sp_value;
            }
            if(array_key_exists($current+1,$this->sp_manager['list'])){//次があるかどうか
                $this->sp_manager['next'] = $this->getSpArray($page_arg,$this->sp_manager['list'][$current+1]['sp']);
            }
            if(array_key_exists($current-1,$this->sp_manager['list'])){//前があるかどうか
                $this->sp_manager['before'] = $this->getSpArray($page_arg,$this->sp_manager['list'][$current-1]['sp']);
            }
            
            $sections = array_chunk($this->sp_manager['list'],$this->index_section_number,TRUE);
            $validate_section = $sections[$validate_section_index];//有効なセクション
            $this->sp_manager['list'] = $validate_section;//再セット
            $this->t->assign('sp_manager', $this->sp_manager);
        }
    }
    
    function getSpArray($page_arg,$sp,$isCurrent = FALSE){
        global $con;
        $url = $sp == 0 ? $page_arg : $page_arg.'/sp/'.$sp;
        return array('sp'=>$sp,'isCurrent'=>$isCurrent,'url'=>$url);
    }

    function prepare_download( $filename, $mimetype, $allowInline = TRUE )
    {
        // Disposition determination
        $disposition = 'attachment';
        if ( $allowInline )
        {
            // "text"s are always acceptable
            if ( strncmp('text/', $mimetype, 5) == 0 ) {
                if ( ereg("\\.csv$", $filename) ) {
                    $disposition = 'attachment';
                } else {
                    $disposition = 'inline';
                }
            } else {
    
                // standard images
                $acceptables = array( 'image/jpeg',
                                      'image/pjpeg',
                                      'image/png',
                                      'image/gif' );
                // browser provided acceptable MIME types.
                if ( array_key_exists('HTTP_ACCEPT', $_SERVER) )
                {
                    $acceptables = array();
                    $a = explode(',', $_SERVER['HTTP_ACCEPT']);
                    foreach( $a as $type )
                    {
                        $acceptables[] = trim( $type );
                    }
                }
    
                if ( in_array( $mimetype, $acceptables ) )
                {
                    $disposition = 'inline';
                }
            }
        }
    
        //mb_http_output( 'pass' );
        //ini_set('default_charset', '');
        //while ( ob_get_level() > 0 )
        //{
            //ob_end_clean();
        //}
    
        // issue HTTP headers
        header("Content-Disposition: ${disposition} ;filename=".$filename);
        //header("Content-Disposition: ${disposition}");
        header('Content-Type: ' . $mimetype);
    }
    function redirectPage($page = '/'){
        header( "HTTP/1.1 301 Moved Permanently" );
        header("Location: ".$page);
        die();
    }

    function getNews($from = null,$to = null,$condition = null){
        $this->addSelectColumn(
        array(
            '_id',
            'ctime',
            'mtime',
            'date',
            'title',
            'news',
            'url',
            'link',
            'target',
            'press',
            'press_title'
            ));
        if(!is_null($condition)) $this->addCondition($condition);
        $this->addOrderColumn('col_date',TRUE);
        if(!is_null($from) && !is_null($to)) $this->limit($from,$to);
        $query = $this->select(T_NEWS);
        $this->execute($query);
        return $this->intResultRows == 0 ? FALSE : $this->arySQLData;
    }

    function getValidateNews($from = null,$to = null){
        $before = $timestamp = strtotime("-12 month");
        $condition = 'col_date >' .$before;
        return $this->getNews($from,$to,$condition);
    }

    function getPress($year = null,$from = null,$to = null){
        $date = mktime(0, 0, 0, 1,1,$year);
        $date2 = mktime(23, 59, 59, 12,31,$year);
        $condition = 'col_date >' .$date.' AND col_press = 0 AND col_date < '.$date2;
        return $this->getNews($from,$to,$condition);
    }

    function getOneNews($nid){
        $condition = '_id = '.$nid;
        return $this->getNews(0,1,$condition);
    }
}

?>

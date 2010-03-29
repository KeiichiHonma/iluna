<?php
class positionManager
{
    static public $position = array();
    static protected $page;
    
    static protected function makeSitePosition($isSystem = FALSE){
        global $con;
        $paths = explode('/',$con->pagepath);
        //debug
        //$paths = array('category','index');
        //$paths = array('category','view');
        //$paths = array('question','view');
        
        $array = self::$page;
        $before_array = $array;
        $i = 1;
        $url = '';
        $count = count($paths);
        foreach ($paths as $path){
            if($path != ''){
                $array = $array[$path];

                if($path != 'index'){
                    //$url .= $array['ssl'] ? CAURLSSL : CAURL;
                    //並列の場所にindexが存在するか確認する
                    if(array_key_exists('index',$before_array)){
                        $url .= $i == 1 ? '/' : $before_path.'/';
                        $http = $before_array['index']['ssl'] ? CAURLSSL : CAURL;
                        self::$position[] = array('url'=>$http.$url,'name'=>$before_array['index']['name']);//1つ前のindex
                    }else{
                        $url .= $before_path.'/';
                    }
                    
                    //階層の途中かどうか確認
                    if(array_key_exists('name',$array)){
                        //最終階層だった
                        $url .= $path;
                        $http = $array['ssl'] ? CAURLSSL : CAURL;
                        //定義関数が必要なページか確認
                        if(!is_null($array['func'])){
                            $arg = call_user_func(array('positionManager',$array['func']));
                            self::$position[] = array('url'=>$http.$url.$arg,'name'=>$array['name']);
                        }else{
                            self::$position[] = array('url'=>$http.$url,'name'=>$array['name']);
                        }
                    }else{
                        //階層の途中.パスの保存
                        $before_path = $path;
                    }
                //indexが指定された
                }else{
                    $url .= $i == 1 ? '/' : $before_path.'/';//トップのindex処理
                    $http = $array['ssl'] ? CAURLSSL : CAURL;
                    self::$position[] = array('url'=>$http.$url,'name'=>$array['name']);
                }
                if($count == $i){
                    if(!is_null($array['gnavi'])) self::setGlobalNavi($array['gnavi']);//グローバルナビ
                    if(!is_null($array['snavi'])) self::setSubNavi($array['snavi']);//サブナビ
                    if($isSystem){
                        self::setH1($array['name']);//systemはnameを
                    }else{
                        if(!is_null($array['h1'])) self::setH1($array['h1']);
                    }
                    
                }
                $i++;
                $before_array = $array;
            }
        }
/*var_dump(self::$position);
die();*/
    }

    static public function setSitePosition(){
        global $con;
        $con->t->assign('position',self::$position);
    }

    static protected function makePositionPair($url,$name){
        return array('url'=>$url,'name'=>$name);
    }

    static function getCurrentValue($key){
        global $con;
        $pages = explode('/',$con->pagepath);
        $count = count($pages);
        if($count == 1){
            return array_key_exists($key,self::$page) ? self::$page[$key] : FALSE;
        }else{
            $array = self::$page;
            $i = 1;
            foreach ($pages as $page){
                if($count == $i){//最後
                    return $array[$page][$key];
                }
                $array = $array[$page];
                $i++;
            }
        }
        return FALSE;
    }

    static function setGlobalNavi($navi){
        global $con;
        $con->t->assign('gnavi',$navi);
    }

    static function setSubNavi($navi){
        global $con;
        $con->t->assign('snavi',$navi);
    }

    static function setH1($h1){
        global $con;
        $con->t->assign('h1',$h1);
    }

    static function positionTrim($string){
        return mb_strimwidth($string,0,30,'…','UTF-8');
    }


    //argコールバック関数///////////////////
    //system
/*    static private function getReplyArg(){
        global $con;
        $rid = $con->base->getPath('rid');
        return '/rid/'.$rid;
    }*/
}

class commonPosition extends positionManager
{
    static protected $page = array
    (
    'index'=>array('name'=>'教えてCA(キャビンアテンダント)！トップ','func'=>null,'ssl'=>FALSE,'gnavi'=>'index','snavi'=>null,'h1'=>null),
    'login'=>array('name'=>'教えてCA！ログイン','func'=>null,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null,'h1'=>'教えてCA!ログインページ'),
    'logout'=>array('name'=>'教えてCA！ログアウト','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>null),
    'search'=>array('name'=>'教えてCA！検索','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>null),
    'about'=>array('name'=>'教えてCA(キャビンアテンダント)！とは','func'=>null,'ssl'=>FALSE,'gnavi'=>'about','snavi'=>null,'h1'=>'教えてCA！とは'),
    'privacy'=>array('name'=>'プライバシーポリシー','func'=>null,'ssl'=>FALSE,'gnavi'=>'about','snavi'=>null,'h1'=>'プライバシーポリシー'),
    'rules'=>array('name'=>'登録規約','func'=>null,'ssl'=>FALSE,'gnavi'=>'about','snavi'=>null,'h1'=>'登録規約'),
    'guide'=>array('name'=>'ご利用の皆様へのお願い','func'=>null,'ssl'=>FALSE,'gnavi'=>'about','snavi'=>null,'h1'=>'ご利用の皆様へのお願い'),
    'corp'=>array('name'=>'運営','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>'運営'),
    'media'=>array('name'=>'広告・協業に関して','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>'広告・協業に関して'),
    'mobile_access'=>array('name'=>'ケータイから教えてCA!を使う','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>'ケータイから教えてCA!を使う'),
    'site_map'=>array('name'=>'サイトマップ','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>'サイトマップ'),
    'notfound'=>array('name'=>'あなたのアクセスしようとしたページは見つかりませんでした。','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>'あなたのアクセスしようとしたページは見つかりませんでした。'),
    'goiken'=>array
        (
        'input'=>array('name'=>'ご意見','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>null),
        'regist'=>array('name'=>'ご意見ありがとうございました','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>'ご意見ありがとうございました。'),
        ),
    'mobile_access'=>array
        (
        'index'=>array('name'=>'教えてCA！モバイルのご案内','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>'教えてCA！モバイルのご案内'),
        'input'=>array('name'=>'URL送信','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>null),
        'regist'=>array('name'=>'URL送信完了','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>'URL送信完了'),
        ),
    'recruit'=>array
        (
        'index'=>array('name'=>'キャビンアテンダントの採用情報','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>'index','h1'=>'採用中のキャビンアテンダント情報'),
        'ana'=>array('name'=>'ANA(全日空)グループ','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>'ana','h1'=>'ANA(全日空)グループのキャビンアテンダント採用情報'),
        'jal'=>array('name'=>'JAL(日航)グループ','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>'jal','h1'=>'JAL(日航)グループのキャビンアテンダント採用情報'),
        'independence'=>array('name'=>'独立系エアライン','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>'independence','h1'=>'独立系航空会社のキャビンアテンダント採用情報'),
        'asia'=>array('name'=>'アジア系外資エアライン','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>'asia','h1'=>'アジア系外資航空会社のキャビンアテンダント採用情報'),
        'oceania'=>array('name'=>'オセアニア系外資エアライン','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>'oceania','h1'=>'オセアニア系外資航空会社のキャビンアテンダント採用情報'),
        'europe'=>array('name'=>'ヨーロッパ系外資エアライン','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>'europe','h1'=>'ヨーロッパ系外資航空会社のキャビンアテンダント採用情報'),
        'mideast'=>array('name'=>'中東系外資エアライン','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>'mideast','h1'=>'中東系外資航空会社のキャビンアテンダント採用情報'),
        'na'=>array('name'=>'北米系外資エアライン','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>'na','h1'=>'北米系外資航空会社のキャビンアテンダント採用情報'),
        'sa'=>array('name'=>'南米系外資エアライン','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>'sa','h1'=>'南米系外資航空会社のキャビンアテンダント採用情報')
        ),
    'message'=>array
        (
        'view'=>array('name'=>'教えてCA！からのお知らせ','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>null)
        ),
    'ca'=>array
        (
        'index'=>array('name'=>'頼れる先輩キャビンアテンダント','func'=>null,'ssl'=>FALSE,'gnavi'=>'ca','snavi'=>null,'h1'=>'先輩キャビンアテンダントのご紹介'),
        'answer'=>array('name'=>'頼れる先輩CAの回答','func'=>null,'ssl'=>FALSE,'gnavi'=>'ca','snavi'=>null,'h1'=>null),
        'blog'=>array('name'=>'頼れる先輩CAの体験記','func'=>null,'ssl'=>FALSE,'gnavi'=>'ca','snavi'=>null,'h1'=>null)
        ),
    'entry'=>array
        (
        'input'=>array('name'=>'メンバー登録','func'=>null,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null,'h1'=>'メンバー登録'),
        'regist'=>array('name'=>'メンバー登録','func'=>null,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null,'h1'=>'メンバー登録'),
        'finish'=>array('name'=>'メンバー登録','func'=>null,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null,'h1'=>'メンバー登録')
        ),
    'reminder'=>array
        (
        'do'=>array
            (
            'input'=>array('name'=>'パスワード再発行手続き','func'=>null,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null,'h1'=>'パスワード再発行手続き'),
            'regist'=>array('name'=>'パスワード再発行手続き','func'=>null,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null,'h1'=>'パスワード再発行手続き')
            ),
        'reset'=>array
            (
            'input'=>array('name'=>'パスワード再発行手続き','func'=>null,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null,'h1'=>'パスワード再発行手続き'),
            'finish'=>array('name'=>'パスワード再発行手続き','func'=>null,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null,'h1'=>'パスワード再発行手続き')
            )
        ),
    'leave'=>array
        (
        'input'=>array('name'=>'退会手続き','func'=>null,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null,'h1'=>'退会手続き'),
        'regist'=>array('name'=>'退会手続き完了','func'=>null,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null,'h1'=>'退会手続き')
        ),
    'category'=>array
        (
        'index'=>array('name'=>'カテゴリ','func'=>null,'ssl'=>FALSE,'gnavi'=>'question','snavi'=>null,'h1'=>'キャビンアテンダントになるための質問カテゴリ一覧'),
        'view'=>array('name'=>'個別カテゴリ','func'=>null,'ssl'=>FALSE,'gnavi'=>'question','snavi'=>null,'h1'=>null)
        ),
    'list'=>array
        (
        'new'=>array('name'=>'先輩CAへの質問一覧(最新の質問)','func'=>null,'ssl'=>FALSE,'gnavi'=>'question','snavi'=>'new','h1'=>'キャビンアテンダントになるための質問＆回答（Q＆A）一覧'),
        'answer'=>array('name'=>'先輩CAへの質問一覧(最新の回答)','func'=>null,'ssl'=>FALSE,'gnavi'=>'question','snavi'=>'answer','h1'=>'キャビンアテンダントになるための最新の回答（Q＆A）一覧'),
        'finish'=>array('name'=>'先輩CAへの質問一覧(解決済み)','func'=>null,'ssl'=>FALSE,'gnavi'=>'question','snavi'=>'finish','h1'=>'キャビンアテンダントになるための解決済み質問＆回答（Q&A）一覧'),
        'useful'=>array('name'=>'先輩CAへの質問一覧(役に立つ)','func'=>null,'ssl'=>FALSE,'gnavi'=>'question','snavi'=>'useful','h1'=>'先輩キャビンアテンダントが選ぶ役に立つ質問＆回答（Q&A一覧')
        ),
    'question'=>array
        (
        'view'=>array('name'=>'質問','func'=>null,'ssl'=>FALSE,'gnavi'=>'question','snavi'=>null,'h1'=>null),
        'input'=>array('name'=>'質問する','func'=>null,'ssl'=>FALSE,'gnavi'=>'question','snavi'=>null,'h1'=>'メンバーの質問ページ'),
        'regist'=>array('name'=>'質問受付完了','func'=>null,'ssl'=>FALSE,'gnavi'=>'question','snavi'=>null,'h1'=>'メンバーの質問ページ'),
        'good'=>array('name'=>'GOODQA','func'=>null,'ssl'=>FALSE,'gnavi'=>'question','snavi'=>null,'h1'=>null)
        ),
    'reply'=>array
        (
        'input'=>array('name'=>'補足する','func'=>null,'ssl'=>FALSE,'gnavi'=>'question','snavi'=>null,'h1'=>'メンバーの補足ページ'),
        'regist'=>array('name'=>'補足受付完了','func'=>null,'ssl'=>FALSE,'gnavi'=>'question','snavi'=>null,'h1'=>'メンバーの補足ページ')
        ),
    'thank'=>array
        (
        'input'=>array('name'=>'お礼をする','func'=>null,'ssl'=>FALSE,'gnavi'=>'question','snavi'=>null,'h1'=>'メンバーからのお礼ページ'),
        'regist'=>array('name'=>'お礼受付完了','func'=>null,'ssl'=>FALSE,'gnavi'=>'question','snavi'=>null,'h1'=>'メンバーからのお礼ページ')
        ),
    'bulletin'=>array
        (
        'list'=>array('name'=>'みんなの掲示板','func'=>null,'ssl'=>FALSE,'gnavi'=>'bulletin','snavi'=>null,'h1'=>null),
        'view'=>array('name'=>'みんなの掲示板','func'=>null,'ssl'=>FALSE,'gnavi'=>'bulletin','snavi'=>null,'h1'=>null),
        'can_user'=>array
            (
            'confirm'=>array('name'=>'先輩CAを呼ぶ','func'=>null,'ssl'=>FALSE,'gnavi'=>'bulletin','snavi'=>null,'h1'=>null),
            ),
        'input'=>array('name'=>'掲示板を作成する','func'=>null,'ssl'=>FALSE,'gnavi'=>'bulletin','snavi'=>null,'h1'=>'掲示板作成ページ'),
        'regist'=>array('name'=>'掲示板作成完了','func'=>null,'ssl'=>FALSE,'gnavi'=>'bulletin','snavi'=>null,'h1'=>'掲示板ページ')
        ),
    'comment'=>array
        (
        'input'=>array('name'=>'コメントする','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>'コメントページ'),
        'regist'=>array('name'=>'コメント完了','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>'コメントページ'),
        ),
    'member'=>array
        (
        'view'=>array('name'=>'メンバー情報','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>null)
        ),
    'mypage'=>array
        (
        'index'=>array('name'=>'マイページ','func'=>null,'ssl'=>FALSE,'gnavi'=>'mypage','snavi'=>'index','h1'=>'マイページ'),
        'message'=>array
            (
            'view'=>array('name'=>'お知らせ閲覧','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>'index','h1'=>null)
            ),
        'member'=>array
            (
            'index'=>array('name'=>'メンバー情報','func'=>null,'ssl'=>FALSE,'gnavi'=>'mypage','snavi'=>'member','h1'=>'メンバー情報'),
            'edit'=>array
                (
                'mail'=>array
                    (
                    'input'=>array('name'=>'メールアドレス変更','func'=>null,'ssl'=>TRUE,'gnavi'=>'mypage','snavi'=>'member','h1'=>'メンバーのメールアドレス変更ページ'),
                    'regist'=>array('name'=>'メールアドレス変更完了','func'=>null,'ssl'=>TRUE,'gnavi'=>'mypage','snavi'=>'member','h1'=>'メンバーのメールアドレス変更ページ')
                    ),
                'password'=>array
                    (
                    'input'=>array('name'=>'パスワード変更','func'=>null,'ssl'=>TRUE,'gnavi'=>'mypage','snavi'=>'member','h1'=>'メンバーのパスワード変更ページ'),
                    'regist'=>array('name'=>'パスワード変更完了','func'=>null,'ssl'=>TRUE,'gnavi'=>'mypage','snavi'=>'member','h1'=>'メンバーのパスワード変更ページ')
                    ),
                'profile'=>array
                    (
                    'input'=>array('name'=>'プロフィール変更','func'=>null,'ssl'=>TRUE,'gnavi'=>'mypage','snavi'=>'member','h1'=>'メンバーのプロフィール変更ページ'),
                    'regist'=>array('name'=>'プロフィール変更完了','func'=>null,'ssl'=>TRUE,'gnavi'=>'mypage','snavi'=>'member','h1'=>'メンバーのプロフィール変更ページ')
                    ),
                'customer'=>array
                    (
                    'input'=>array('name'=>'お客様情報変更','func'=>null,'ssl'=>TRUE,'gnavi'=>'mypage','snavi'=>'member','h1'=>'メンバーのお客様情報変更ページ'),
                    'regist'=>array('name'=>'お客様情報変更完了','func'=>null,'ssl'=>TRUE,'gnavi'=>'mypage','snavi'=>'member','h1'=>'メンバーのお客様情報変更ページ')
                    )
                ),
            ),
        'history'=>array('name'=>'メンバーの質問履歴','func'=>null,'ssl'=>FALSE,'gnavi'=>'mypage','snavi'=>'history','h1'=>'メンバーの質問履歴'),
        'bulletin'=>array('name'=>'メンバーの参加掲示板','func'=>null,'ssl'=>FALSE,'gnavi'=>'mypage','snavi'=>'bulletin','h1'=>'メンバーの参加掲示板')
        ),
    'present'=>array
        (
        'view'=>array('name'=>'商品','func'=>null,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null,'h1'=>'プレゼント'),
        'result'=>array('name'=>'当選発表','func'=>null,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null,'h1'=>'プレゼント当選発表'),
        'apply'=>array
            (
            'input'=>array('name'=>'応募フォーム','func'=>null,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null,'h1'=>'応募フォーム'),
            'regist'=>array('name'=>'応募受付完了','func'=>null,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null,'h1'=>'応募フォーム')
            )
        ),
    'success'=>array
        (
        'index'=>array('name'=>'キャビンアテンダント合格体験記','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>'合格体験記'),
        'category'=>array('name'=>'キャビンアテンダント合格体験記カテゴリ','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>'合格体験記カテゴリ'),
        'view'=>array('name'=>'キャビンアテンダント合格体験記詳細','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>null)
        ),
    'special'=>array('name'=>'教えてCA！ニュース','func'=>null,'ssl'=>FALSE,'gnavi'=>'about','snavi'=>null,'h1'=>'教えてCA！ニュース'),
    'api'=>array
        (
        'get_bulletin'=>array('name'=>'掲示板API','func'=>null,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>null)
        ),
    'school'=>array
        (
        'list'=>array('name'=>'スクールガイド','func'=>null,'ssl'=>FALSE,'gnavi'=>'school','snavi'=>null,'h1'=>null),
        'apply'=>array
            (
            'input'=>array('name'=>'資料請求フォーム','func'=>null,'ssl'=>TRUE,'gnavi'=>'school','snavi'=>null,'h1'=>'資料請求フォーム'),
            'regist'=>array('name'=>'資料請求受付完了','func'=>null,'ssl'=>TRUE,'gnavi'=>'school','snavi'=>null,'h1'=>'資料請求フォーム')
            ),
        'view'=>array
            (
            'index'=>array('name'=>'詳細','func'=>null,'ssl'=>FALSE,'gnavi'=>'school','snavi'=>'index','h1'=>null),
            'gallery'=>array('name'=>'フォトギャラリー','func'=>null,'ssl'=>FALSE,'gnavi'=>'school','snavi'=>'gallery','h1'=>null),
            'success'=>array('name'=>'合格者の声','func'=>null,'ssl'=>FALSE,'gnavi'=>'school','snavi'=>'success','h1'=>null),
            'seminar'=>array
                (
                'index'=>array('name'=>'セミナー・イベント','func'=>null,'ssl'=>FALSE,'gnavi'=>'school','snavi'=>'seminar','h1'=>null),
                'view'=>array('name'=>'セミナー・イベント','func'=>null,'ssl'=>FALSE,'gnavi'=>'school','snavi'=>'seminar','h1'=>null),
                'apply'=>array
                    (
                    'input'=>array('name'=>'セミナー・イベント申込フォーム','func'=>null,'ssl'=>TRUE,'gnavi'=>'school','snavi'=>null,'h1'=>'申込フォーム'),
                    'regist'=>array('name'=>'セミナー・イベント申込受付完了','func'=>null,'ssl'=>TRUE,'gnavi'=>'school','snavi'=>null,'h1'=>'申込フォーム')
                    )
                ),
            'access'=>array('name'=>'アクセス','func'=>null,'ssl'=>FALSE,'gnavi'=>'school','snavi'=>'access','h1'=>null)
            ),
        'seminar'=>array
            (
            'list'=>array('name'=>'セミナー・イベント','func'=>null,'ssl'=>TRUE,'gnavi'=>'seminar','snavi'=>null,'h1'=>'セミナー・イベント')
            ),
        )
    );

    static public function makeSitePosition(){
        parent::$page = self::$page;
        parent::makeSitePosition();
    }

    static private $index = 1;

    static public function makeNumberPosition($url,$title,$trim = TRUE){
        parent::$position[self::$index] = parent::makePositionPair($url,$trim ? self::positionTrim($title) : $title);
        self::$index++;
    }

    static public function makeFirstPosition($url,$title,$trim = TRUE){
        parent::$position[1] = parent::makePositionPair($url,$trim ? self::positionTrim($title) : $title);
    }

    static public function makeSecondPosition($url,$title,$trim = TRUE){
        parent::$position[2] = parent::makePositionPair($url,$trim ? self::positionTrim($title) : $title);
    }

    static public function makeThirdPosition($url,$title,$trim = TRUE){
        parent::$position[3] = parent::makePositionPair($url,$trim ? self::positionTrim($title) : $title);
    }

    static public function makeFourPosition($url,$title,$trim = TRUE){
        parent::$position[4] = parent::makePositionPair($url,$trim ? self::positionTrim($title) : $title);
    }

    static public function makeFivePosition($url,$title,$trim = TRUE){
        parent::$position[5] = parent::makePositionPair($url,$trim ? self::positionTrim($title) : $title);
    }

    static public function makeSixPosition($url,$title,$trim = TRUE){
        parent::$position[6] = parent::makePositionPair($url,$trim ? self::positionTrim($title) : $title);
    }

    static public function makeQuestionPosition($cid = null,$category = null,$qid = null,$title = null){
        self::makeFirstPosition('/list/new','先輩CAへの質問一覧');
        self::makeSecondPosition('/category/','カテゴリ');
        if(!is_null($cid) && !is_null($category)) self::makeThirdPosition('/category/view/cid/'.$cid,$category,FALSE);
        if(!is_null($qid) && !is_null($title)) self::makeFourPosition('/question/view/qid/'.$qid,$title);
    }

/*    static public function makeBulletinPosition($bid,$title){
        self::makeFirstPosition('/bulletin/list','みんなの掲示板');
        self::makeSecondPosition('/bulletin/view/bid/'.$bid,$title);
    }*/

    static public function makeBulletinPosition($tid,$theme,$stid,$subtheme,$bid,$title){
        self::makeFirstPosition('/bulletin/list','みんなの掲示板');
        if(!is_null($tid) && !is_null($theme)){
            self::makeSecondPosition('/bulletin/list/tid/'.$tid,$theme);
            if(!is_null($stid) && !is_null($subtheme)){
                self::makeThirdPosition('/bulletin/list/tid/'.$tid.'/stid/'.$stid,$subtheme);
                if(!is_null($bid) && !is_null($title)){
                    self::makeFourPosition('/bulletin/view/bid/'.$bid,$title);
                }
            }else{
                if(!is_null($bid) && !is_null($title)){
                    self::makeThirdPosition('/bulletin/view/bid/'.$bid,$title);
                }
            }
        }
    }
    static public $area_path = '';
    static public function makeScoolPosition($app,$aid,$area,$said,$subarea,$scid,$school_name,$target = null,$scsid = null,$seminar_name = null){
        self::$index = 1;//どこから変更するか
        self::makeNumberPosition(CAURL.'/school/list','エアラインスクールガイド');
        if($app == 'seminar'){
            $app_path = 'school/seminar';
            self::makeNumberPosition(CAURL.'/school/seminar/list','セミナー・イベント');
        }elseif($app == 'school'){
            $app_path = 'school';
        }
        if($aid && $area){
            self::$area_path .= '/aid/'.$aid;
            self::makeNumberPosition(CAURL.'/'.$app_path.'/list'.self::$area_path,$area);
            if($said && $subarea){
                self::$area_path .= '/said/'.$said;
                self::makeNumberPosition(CAURL.'/'.$app_path.'/list'.self::$area_path,$subarea);
                self::setSchoolDetail($scid,$school_name,$target,$scsid,$seminar_name);
            }else{
                self::setSchoolDetail($scid,$school_name,$target,$scsid,$seminar_name);
            }
        }else{
            self::setSchoolDetail($scid,$school_name,$target,$scsid,$seminar_name);
        }
        global $con;
        if(strlen(self::$area_path) > 0) $con->t->assign('area_path',self::$area_path);
    }
    
    static public function setSchoolDetail($scid,$school_name,$target = null,$scsid = null,$seminar_name = null){
        if($scid && $school_name){
            self::makeNumberPosition(CAURL.'/school/view/index/scid/'.$scid.self::$area_path,$school_name);
            if($target){
                switch ($target){
                case 'gallery':
                    self::makeNumberPosition(CAURL.'/school/view/gallery/scid/'.$scid.self::$area_path,'フォトギャラリー');
                break;
                case 'success':
                    self::makeNumberPosition(CAURL.'/school/view/success/scid/'.$scid.self::$area_path,'合格者の声');
                break;
                case 'seminar':
                    self::makeNumberPosition(CAURL.'/school/view/seminar/index/scid/'.$scid.self::$area_path,'セミナー・イベント');
                    if($scsid && $seminar_name){
                        self::makeNumberPosition(CAURLSSL.'/school/view/seminar/view/scid/'.$scid.'/scsid/'.$scsid,$seminar_name);
                    }
                break;
                case 'access':
                    self::makeNumberPosition(CAURL.'/school/view/access/scid/'.$scid.self::$area_path,'アクセス');
                break;
                case 'apply':
                    self::makeNumberPosition(CAURLSSL.'/school/apply/scid/'.$scid.self::$area_path,'資料請求');
                break;
                }
            }
        }
    }

    static public function makeMessagePosition($msid,$title,$isMypage = FALSE){
        if($isMypage){
            self::makeSecondPosition('/mypage/message/view/msid/'.$msid,$title);
        }else{
            self::makeFirstPosition('/message/view/msid/'.$msid,$title);
        }
        
    }

    //reply thank 入力画面にて
    static public function makeReplyPosition($cid,$category,$qid,$title){
        parent::$position[4] = parent::$position[1];//補足するを最後に
        self::makeQuestionPosition($cid,$category,$qid,$title);
        ksort(parent::$position);
    }

    //comment 入力画面にて
    static public function makeCommentPosition($tid,$theme,$stid,$subtheme,$bid,$title){
        parent::$position[3] = parent::$position[1];//補足するを最後に
        self::makeBulletinPosition($tid,$theme,$stid,$subtheme,$bid,$title);
        ksort(parent::$position);
    }

}

class systemPosition extends positionManager
{
    static protected $page = array
    (
    'index'=>array('name'=>'教えてCA！トップ','func'=>null,'ssl'=>FALSE,'gnavi'=>'index','snavi'=>null),
    'system'=>array
        (
        'index'=>array('name'=>'管理画面トップ','func'=>null,'access'=>TYPE_U_NOT_ADMIN_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'index'),
        'login'=>array('name'=>'管理画面ログイン','func'=>null,'access'=>TYPE_U_CA,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null),
        'logout'=>array('name'=>'管理画面ログアウト','func'=>null,'access'=>TYPE_U_CA,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null),
        'user'=>array
            (
            'index'=>array('name'=>'ユーザー管理','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user'),
            'ca'=>array
                (
                'index'=>array('name'=>'CA詳細','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user'),
                'entry'=>array
                    (
                    'input'=>array('name'=>'CA追加','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user'),
                    'regist'=>array('name'=>'CA追加完了','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user')
                    ),
                'edit'=>array
                    (
                    'mail'=>array
                        (
                        'input'=>array('name'=>'CAメールアドレス変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user'),
                        'regist'=>array('name'=>'CAメールアドレス変更完了','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user')
                        ),
                    'password'=>array
                        (
                        'input'=>array('name'=>'CAパスワード変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user'),
                        'regist'=>array('name'=>'CAパスワード変更完了','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user')
                        ),
                    'profile'=>array
                        (
                        'input'=>array('name'=>'CAプロフィール変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user'),
                        'regist'=>array('name'=>'CAプロフィール変更完了','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user')
                        ),
                    'contacts'=>array
                        (
                        'input'=>array('name'=>'CA連絡用メールアドレス変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user'),
                        'regist'=>array('name'=>'CA連絡用メールアドレス変更完了','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user')
                        )
                    )
                ),
            'school'=>array
                (
                'index'=>array('name'=>'スクール詳細','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school'),
                'change'=>array('name'=>'スクールにログイン','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user'),
                'entry'=>array
                    (
                    'input'=>array('name'=>'スクール追加','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user'),
                    'regist'=>array('name'=>'スクール追加完了','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user')
                    ),
                'edit'=>array
                    (
                    'mail'=>array
                        (
                        'input'=>array('name'=>'スクールメールアドレス変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user'),
                        'regist'=>array('name'=>'スクールメールアドレス変更完了','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user')
                        ),
                    'password'=>array
                        (
                        'input'=>array('name'=>'スクールパスワード変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user'),
                        'regist'=>array('name'=>'スクールパスワード変更完了','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user')
                        ),
                    'display'=>array
                        (
                        'input'=>array('name'=>'スクールログイン表示名変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user'),
                        'regist'=>array('name'=>'スクールログイン表示名変更完了','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user')
                        ),
                    'contacts'=>array
                        (
                        'input'=>array('name'=>'CA連絡用メールアドレス変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user'),
                        'regist'=>array('name'=>'CA連絡用メールアドレス変更完了','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'user')
                        )
                    )
                )
            ),
        'school'=>array
            (
            'index'=>array('name'=>'スクールトップ','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school'),
            'logout'=>array('name'=>'管理画面ログアウト','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null),
            'validate'=>array('name'=>'スクールテータス変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school'),
            'reminder'=>array
                (
                'input'=>array('name'=>'スクールパスワード再設定','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_reminder'),
                'regist'=>array('name'=>'スクールパスワード再設定','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_reminder')
                ),
            'base'=>array
                (
                'index'=>array('name'=>'スクール基本情報','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_base'),
                'logo'=>array
                    (
                    'input'=>array('name'=>'ロゴ画像変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_base')
                    ),
                'face'=>array
                    (
                    'input'=>array('name'=>'トップ画像変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_base')
                    ),
                'qr'=>array
                    (
                    'input'=>array('name'=>'QR画像変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_base')
                    ),
                'mail'=>array
                    (
                    'input'=>array('name'=>'メールアドレス変更','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_base')//学校許可
                    ),
                'mails'=>array
                    (
                    'input'=>array('name'=>'メールアドレス変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_base')
                    ),
                'password'=>array
                    (
                    'input'=>array('name'=>'パスワード変更','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_base')//学校許可
                    ),
                'display'=>array
                    (
                    'input'=>array('name'=>'ログイン表示名変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_base')
                    ),
                'profile'=>array
                    (
                    'input'=>array('name'=>'プロフィール変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_base')
                    ),
                'genre'=>array
                    (
                    'input'=>array('name'=>'ジャンル変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_base')
                    ),
                'contacts'=>array
                    (
                    'input'=>array('name'=>'連絡用メールアドレス変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_base')
                    )
                ),
            'school_base'=>array
                (
                'index'=>array('name'=>'スクール基本情報','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_base'),//学校用基本画面
                ),
            'hub'=>array
                (
                'index'=>array('name'=>'拠点','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_hub'),
                'view'=>array('name'=>'拠点詳細','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_hub'),
                'entry'=>array
                    (
                    'input'=>array('name'=>'拠点追加','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_hub')
                    ),
                'edit'=>array
                    (
                    'input'=>array('name'=>'拠点変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_hub')
                    ),
                'drop'=>array
                    (
                    'input'=>array('name'=>'拠点削除','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_hub')
                    ),
                'mails'=>array
                    (
                    'input'=>array('name'=>'メールアドレス変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_hub')
                    )
                ),
            'feature'=>array
                (
                'index'=>array('name'=>'特色','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_feature'),
                'entry'=>array
                    (
                    'input'=>array('name'=>'特色追加','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_feature')
                    ),
                'edit'=>array
                    (
                    'input'=>array('name'=>'特色変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_feature')
                    ),
                'drop'=>array
                    (
                    'input'=>array('name'=>'特色削除','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_feature')
                    )
                ),
            'gallery'=>array
                (
                'index'=>array('name'=>'ギャラリー','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_gallery'),
                'entry'=>array
                    (
                    'input'=>array('name'=>'ギャラリー追加','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_gallery')
                    ),
                'edit'=>array
                    (
                    'input'=>array('name'=>'ギャラリー変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_gallery')
                    ),
                'drop'=>array
                    (
                    'input'=>array('name'=>'ギャラリー削除','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_gallery')
                    )
                ),
            'success'=>array
                (
                'index'=>array('name'=>'合格者の声','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_success'),
                'entry'=>array
                    (
                    'input'=>array('name'=>'合格者の声追加','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_success')
                    ),
                'edit'=>array
                    (
                    'input'=>array('name'=>'合格者の声変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_success')
                    ),
                'drop'=>array
                    (
                    'input'=>array('name'=>'合格者の声削除','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_success')
                    )
                ),
            'seminar'=>array
                (
                'index'=>array('name'=>'セミナー・イベント','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_seminar'),
                'view'=>array('name'=>'セミナー・イベント詳細','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_seminar'),
                'validate'=>array('name'=>'セミナー・イベントステータス変更','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_seminar'),
                'entry'=>array
                    (
                    'input'=>array('name'=>'セミナー・イベント追加','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_seminar')
                    ),
                'edit'=>array
                    (
                    'input'=>array('name'=>'セミナー・イベント変更','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_seminar')
                    ),
                'drop'=>array
                    (
                    'input'=>array('name'=>'セミナー・イベント削除','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_seminar')
                    ),
                'date'=>array
                    (
                    'index'=>array('name'=>'開催日時','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_seminar'),
                    'validate'=>array('name'=>'セミナー・イベント日時ステータス変更','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_seminar'),
                    'entry'=>array
                        (
                        'input'=>array('name'=>'セミナー・イベント追加','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_seminar')
                        ),
                    'edit'=>array
                        (
                        'input'=>array('name'=>'セミナー・イベント変更','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_seminar')
                        ),
                    'drop'=>array
                        (
                        'input'=>array('name'=>'セミナー・イベント削除','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_seminar')
                        )
                    ),
                'apply'=>array
                    (
                    'index'=>array('name'=>'申込','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_seminar'),
                    'view'=>array('name'=>'申込詳細','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_seminar'),
                    'export'=>array('name'=>'申込書き出し','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_seminar')
                    )
                ),
            'apply'=>array
                (
                'index'=>array('name'=>'申込','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_apply'),
                'view'=>array('name'=>'申込詳細','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_apply'),
                'export'=>array('name'=>'申込書き出し','func'=>null,'access'=>TYPE_U_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'school_apply')
                )
            ),
        'judgment'=>array
            (
            'index'=>array('name'=>'質問振り分け','func'=>null,'access'=>TYPE_U_MANAGER,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'judgment'),
            'question'=>array
                (
                'input'=>array('name'=>'質問振り分け実行','func'=>null,'access'=>TYPE_U_MANAGER,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'judgment'),
                'regist'=>array('name'=>'質問振り分け完了','func'=>null,'access'=>TYPE_U_MANAGER,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'judgment')
                ),
            'reply'=>array
                (
                'input'=>array('name'=>'補足振り分け実行','func'=>null,'access'=>TYPE_U_MANAGER,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'judgment'),
                'regist'=>array('name'=>'補足振り分け完了','func'=>null,'access'=>TYPE_U_MANAGER,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'judgment')
                ),
            ),
        'list'=>array
            (
            'question'=>array('name'=>'質問一覧','func'=>null,'access'=>TYPE_U_CA,'ssl'=>TRUE,'gnavi'=>'list','snavi'=>'list'),
            'reply'=>array('name'=>'補足一覧','func'=>null,'access'=>TYPE_U_CA,'ssl'=>TRUE,'gnavi'=>'list','snavi'=>'list'),
            'answer'=>array('name'=>'回答一覧','func'=>null,'access'=>TYPE_U_CA,'ssl'=>TRUE,'gnavi'=>'list','snavi'=>'list'),
            'search'=>array('name'=>'検索','func'=>null,'access'=>TYPE_U_CA,'ssl'=>TRUE,'gnavi'=>'list','snavi'=>'list')
            ),
        'question'=>array
            (
            'view'=>array('name'=>'質問詳細','func'=>null,'access'=>TYPE_U_CA,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'list'),
            'drop'=>array
                (
                'input'=>array('name'=>'質問削除','func'=>null,'access'=>TYPE_U_MANAGER,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'list'),
                )
            ),
        'reply'=>array
            (
            'drop'=>array
                (
                'input'=>array('name'=>'補足削除','func'=>null,'access'=>TYPE_U_MANAGER,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'list'),
                )
            ),
        'thank'=>array
            (
            'drop'=>array
                (
                'input'=>array('name'=>'お礼削除','func'=>null,'access'=>TYPE_U_MANAGER,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'list'),
                )
            ),
        'answer'=>array
            (
            'input'=>array('name'=>'回答追加','func'=>null,'access'=>TYPE_U_NOT_ADMIN_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'list'),
            'regist'=>array('name'=>'回答追加完了','func'=>null,'access'=>TYPE_U_NOT_ADMIN_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'list')
            ),
        'useful'=>array
            (
            'input'=>array('name'=>'役に立つ質問実行','func'=>null,'access'=>TYPE_U_NOT_ADMIN_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'list'),
            'regist'=>array('name'=>'役に立つ質問完了','func'=>null,'access'=>TYPE_U_NOT_ADMIN_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'list')
            ),
        'bulletin'=>array
            (
            'list'=>array('name'=>'掲示板','func'=>null,'access'=>TYPE_U_CA,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'bulletin'),
            'input'=>array('name'=>'今週の模擬面接追加','func'=>null,'access'=>TYPE_U_NOT_ADMIN_SCHOOL,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'bulletin'),
            'drop'=>array
                (
                'input'=>array('name'=>'掲示板削除','func'=>null,'access'=>TYPE_U_MANAGER,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'bulletin')
                )
            ),
        'comment'=>array
            (
            'drop'=>array
                (
                'input'=>array('name'=>'コメント削除','func'=>null,'access'=>TYPE_U_MANAGER,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'bulletin')
                )
            ),
        'message'=>array
            (
            'index'=>array('name'=>'お知らせ管理','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'message'),
            'view'=>array('name'=>'お知らせ閲覧','func'=>null,'access'=>TYPE_U_CA,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>null),
            'detail'=>array('name'=>'お知らせ閲覧(管理)','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'message'),
            'entry'=>array
                (
                'input'=>array('name'=>'お知らせ追加','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'message'),
                ),
            'edit'=>array
                (
                'input'=>array('name'=>'お知らせ変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'message'),
                ),
            'drop'=>array
                (
                'input'=>array('name'=>'お知らせ削除','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'message'),
                )
            ),
        'blog'=>array
            (
            'index'=>array('name'=>'日記管理','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'blog'),
            'detail'=>array('name'=>'日記閲覧(管理)','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'blog'),
            'entry'=>array
                (
                'input'=>array('name'=>'日記追加','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'blog'),
                ),
            'edit'=>array
                (
                'input'=>array('name'=>'日記変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'blog'),
                ),
            'drop'=>array
                (
                'input'=>array('name'=>'日記削除','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'blog'),
                )
            ),
        'success'=>array
            (
            'index'=>array('name'=>'合格体験記管理','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'success'),
            'detail'=>array('name'=>'合格体験記閲覧(管理)','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'success'),
            'entry'=>array
                (
                'input'=>array('name'=>'合格体験記追加','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'success'),
                ),
            'edit'=>array
                (
                'input'=>array('name'=>'合格体験記変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'success'),
                ),
            'drop'=>array
                (
                'input'=>array('name'=>'合格体験記削除','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'success'),
                )
            ),
        'report'=>array
            (
            'index'=>array('name'=>'配信管理','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'report'),
            'detail'=>array('name'=>'配信閲覧','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'report'),
            'entry'=>array
                (
                'input'=>array('name'=>'配信追加','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'report'),
                ),
            'edit'=>array
                (
                'input'=>array('name'=>'配信変更','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'report'),
                ),
            'drop'=>array
                (
                'input'=>array('name'=>'配信削除','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'report'),
                )
            ),
        'member'=>array
            (
            'view'=>array('name'=>'メンバー情報','func'=>null,'access'=>TYPE_U_CA,'ssl'=>FALSE,'gnavi'=>null,'snavi'=>null,'h1'=>null)
            ),
        'analyze'=>array('name'=>'分析','func'=>null,'access'=>TYPE_U_ADMIN,'ssl'=>TRUE,'gnavi'=>null,'snavi'=>'analyze'),
        )
    );

    static public function makeSitePosition(){
        parent::$page = self::$page;
        parent::makeSitePosition(TRUE);
    }

    static public function makeQAPosition($qid,$title,$isChange = TRUE){
        if($isChange) parent::$position[4] = parent::$position[2];//基本は2番目に現在のページがある
        parent::$position[2] = parent::makePositionPair('/system/list/question/sort/new','Q&A');
        parent::$position[3] = parent::makePositionPair('/system/question/view/qid/'.$qid,self::positionTrim($title));
        ksort(parent::$position);
    }

    static public function makeBulletinPosition($bid,$title,$page){
        //systemだが、URLはシステムじゃない
        parent::$position[1] = parent::makePositionPair(CAURL.'/bulletin/list',self::positionTrim('みんなの掲示板'));
        parent::$position[2] = parent::makePositionPair(CAURL.'/bulletin/view/bid/'.$bid,self::positionTrim($title));
        if($page == 'bulletin'){
            parent::$position[3] = parent::makePositionPair('/bulletin/drop/input/bid/'.$bid,self::positionTrim('掲示板の削除'));
        }elseif($page == 'comment'){
            parent::$position[3] = parent::makePositionPair('/comment/drop/input/bid/'.$bid,self::positionTrim('コメントの削除'));
        }
    }

    static public function makeMessagePosition($msid,$title,$view = TRUE){
        //ユーザー向けのお知らせはお知らせ管理を抜いて作る
        if($view){
            unset(parent::$position[3]);
            parent::$position[2] = parent::makePositionPair('/system/message/view/msid/'.$msid,self::positionTrim($title));
        }else{
            parent::$position[3] = parent::makePositionPair('/system/message/detail/msid/'.$msid,self::positionTrim($title));
        }
        
    }

    static public function makeThirdPosition($url,$title){
        parent::$position[3] = parent::makePositionPair($url,self::positionTrim($title));
    }
    
    static public function makeFourthPosition($url,$title){
        parent::$position[4] = parent::$position[3];
        parent::$position[3] = parent::makePositionPair($url,self::positionTrim($title));
        ksort(parent::$position);
    }
    
    static public function makeMessageChildPosition($msid,$title){
        parent::$position[4] = parent::$position[3];
        //question detail
        parent::$position[3] = parent::makePositionPair('/system/message/detail/msid/'.$msid,self::positionTrim($title));
        ksort(parent::$position);
    }

    /*
    学校用のサイトポジション生成関数
    管理者と学校では画面が異なるため
    ※Admin
    教えてCA！トップ > 管理画面トップ > 学校一覧 > 学校詳細
    ※学校
    教えてCA！トップ > 学校名-管理画面トップ（実際は学校詳細） > 各操作(学校メールアドレス変更等)
    */
    
    static public function makeSchoolPosition($school_name,$positions = null){
        global $user_auth;
        $count = count(parent::$position);
        for ($i=2;$i<$count;$i++){
            if($i == 2){
                if(strcasecmp($user_auth->user_type,TYPE_U_ADMIN_SCHOOL) == 0){
                    parent::$position[$i]['name'] = self::positionTrim($school_name.'-管理画面トップ');
                    parent::$position[$i-1] = parent::$position[$i];
                }else{
                    unset(parent::$position[$i]);
                    unset(parent::$position[$i-1]);
                }
                
            }else{
                parent::$position[$i-1] = parent::$position[$i];
            }
        }
        unset(parent::$position[$count-1]);
        ksort(parent::$position);
        if(!is_null($positions)){
            $i = $count-2;
            foreach ($positions as $key => $array){
                parent::$position[$i] = parent::makePositionPair($array['url'],self::positionTrim($array['name']));
                $i++;
            }
        }
    }

    //アクセス権////////////////////////////////////////
    static function getAccess(){
        parent::$page = self::$page;
        return self::getCurrentValue('access');
    }

    static function getName(){
        parent::$page = self::$page;
        return self::getCurrentValue('name');
    }
}
?>

<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/prepend.php');
//お知らせ
$news = $base->getValidateNews();
$base->t->assign('news',$news);
$base->t->assign('h1','日遊酷棒お問い合わせ');

$base->t->assign(
    'position',
    array
    (
        '/'=>'iLUNAホーム',
        '/kujapan/contact'=>'日遊酷棒お問い合わせ'
    )
);

if ( $pm ){
    $error = array();
    
    if(strlen($_POST['company']) == 0){
        $error['company'] = '貴社名は必須です。';
    }

    if(strlen($_POST['url']) == 0){
        $error['url'] = '貴社サイトURLは必須です。';
    }else{
        if(!checkURL($_POST['url'])){
            $error['url'] = 'URLが不正です。';
        }
    }

    if(strlen($_POST['unit']) == 0){
        $error['unit'] = 'ご担当者部署名は必須です。';
    }

    if(strlen($_POST['name']) == 0){
        $error['name'] = 'ご担当者様名は必須です。';
    }

    if(strlen($_POST['kana']) == 0){
        $error['kana'] = 'フリガナは必須です。';
    }

    if(strlen($_POST['mail']) == 0){
        $error['mail'] = 'Eメールアドレスは必須です。';
    }else{
        if(!checkMail($_POST['mail'])){
            $error['mail'] = 'Eメールアドレスが不正です。';
        }
    }

    if(strlen($_POST['telephone1']) == 0 || strlen($_POST['telephone2']) == 0 || strlen($_POST['telephone3']) == 0){
        $error['telephone'] = '電話番号は必須です。';
    }elseif(strlen($_POST['telephone1']) < 2 || strlen($_POST['telephone2']) < 2 || strlen($_POST['telephone3']) < 4){
        $error['telephone'] = '電話番号が不正です。';
    }else{
        $tel1 = mb_convert_kana($_POST['telephone1'], "n");
        $tel2 = mb_convert_kana($_POST['telephone2'], "n");
        $tel3 = mb_convert_kana($_POST['telephone3'], "n");
        $tel = array($tel1,$tel2,$tel3);
        if(!is_numeric($tel1)  || !is_numeric($tel2) || !is_numeric($tel3)){
            $error['telephone'] = '電話番号が不正です。';
        }else{
            if(checkMobile($tel1)){
                $error['telephone'] = '携帯電話番号を指定することはできません。';
            }else{
                if(!checkTelephone($tel1,$tel2,$tel3)){
                    $error['telephone'] = '電話番号が不正です。';
                }
            }
        }
    }

    if(strlen($_POST['address']) == 0){
        $error['address'] = '住所は必須です。';
    }

    if(strlen($_POST['detail']) == 0){
        $error['detail'] = 'お問い合わせ詳細は必須です。';
    }

    if(count($error) > 0){//エラーが存在
        $base->t->assign('error', $error);
    }else{
        if(sendMail()){
            $base->redirectPage('/kujapan/done');
        }else{
            $base->redirectPage('/kujapan/contact/');
        }
    }
    
}else{
    if($ini['common']['isDebug'] == 1){
        $_POST['company'] = '株式会社イルナ';
        $_POST['url'] = 'http://www.iluna.co.jp/';
        $_POST['unit'] = '開発部';
        $_POST['class'] = '部長';
        $_POST['name'] = '本間圭一';
        $_POST['kana'] = 'ホンマケイイチ';
        $_POST['mail'] = 'honma@zeus.corp.iluna.co.jp';
        $_POST['telephone1'] = '03';
        $_POST['telephone2'] = '6687';
        $_POST['telephone3'] = '0737';
        $_POST['address'] = '東京都渋谷区代々木4-31-4 キャッスル新宿802号';
        $_POST['detail'] = "株式会社イルナ( iLUNA, Inc. ) は2008年7月設立のベンチャー企業です。\n社名の由来は以下の2つの単語の掛け合わせで生まれました。";
    }
}

//--[ メイン処理 ]------------------------------------------------------------------
// display it
$base->t->display('kujapan/contact.tpl');

function sendMail(){
    global $tel;
    global $ini;
    
    if($ini['common']['isDebug'] == 0){
        //本番
        $mail = 'info@iluna.co.jp';
    }else{
        //debug
        $mail = 'honma@zeus.corp.iluna.co.jp';
    }
    
    


    
    mb_language("Japanese"); // 日本語モードにする
    mb_internal_encoding("UTF-8"); // この設定がないと文字化けorz
    $to = $mail;//固定
    $from = $mail;//from
    $reply = $_POST['mail'];//返信先
    
    $title = '【日游酷棒】お問い合わせ';
    $body = '';
    if(is_array($_POST)){
        $body .= '貴社名：'.$_POST['company']."\n";
        $body .= '貴社サイトURL：'.$_POST['url']."\n";
        $body .= 'ご担当部署名：'.$_POST['unit']."\n";
        $body .= '役職：'.$_POST['class']."\n";
        $body .= 'ご担当者名：'.$_POST['name']."\n";
        $body .= 'Eメールアドレス：'.$_POST['mail']."\n";
        $body .= '電話番号：'.$tel[0].$tel[1].$tel[2]."\n";
        $body .= 'お問い合わせ詳細：'."\n";
        $body .= $_POST['detail']."\n";
        $body = str_replace("\r\n","\r", $body);
        // \rを\nに変換
        $body = str_replace("\r","\n", $body);
    }
    $header =
      'From: '.$from."\n".
      'Reply-To: '.$reply."\n".
      'X-Mailer: PHP/' . phpversion();
    $bl = mb_send_mail($to,$title,$body,$header);
    
    if($bl){
        return TRUE;
    }else{
        return FALSE;
    }
}

function checkMail($mailaddress)
{
//preg_match('^[a-zA-Z0-9_\.,-]+@([a-zA-Z0-9_\.,-]+\.[a-zA-Z0-9]+$)',$mailaddress)
//preg_match('/^[-+\\w]+(\\.[-+\\w]+)*@[-a-z0-9]+(\\.[-a-z0-9]+)*\\.[a-z]{2,6}$/i', $value)

    if (preg_match('/^[-+\\w]+(\\.[-+\\w]+)*@[-a-z0-9]+(\\.[-a-z0-9]+)*\\.[a-z]{2,6}$/i',$mailaddress)) {
        return TRUE;
    }else{
        return FALSE;
    }
}

function checkURL($url)
{
    if (preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/',$url)) {
        return TRUE;
    }else{
        return FALSE;
    }
}

function checkTelString($string){
    $string = str_replace('-','',$string);
    $string = mb_convert_kana( $string, "n");
}

function checkTelephone($tel1,$tel2,$tel3){
    if (preg_match("/^\d{2,4}$/", $tel1) && preg_match("/^\d{2,4}$/", $tel2) && preg_match("/^\d{4}$/", $tel3)) {
        return TRUE;
    }else{
        return FALSE;
    }

}

function checkMobile($tel1){
    //if (preg_match("/^(090|080)$/", $tel1) && preg_match("/^\d{4}$/", $tel2) && preg_match("/^\d{4}$/", $tel3)) {
    if (preg_match("/^(090|080)$/", $tel1)) {
        return TRUE;
    }else{
        return FALSE;
    }
}

?>

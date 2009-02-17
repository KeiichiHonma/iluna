<?php
set_include_path(get_include_path() . '/iluna');

header("Content-type: text/html; charset=utf-8");
//--[ require ]--------------------------------------------------------------
//--[ インスタンス生成 ]--------------------------------------------------------------
require_once('define.php');
require_once('iluna_base.php');
$base =& IlunaBase::static_getInstance();
if ($_SERVER['SERVER_PORT'] == 443) $base->redirectPage(ILUNAURL.$valid_str.'/');

$base->getSmarty();//smarty
$ini = parse_ini_file(SETTING_INI, true);
//mktime(0, 0, 0, 8,8,2008);
//news
$news_top = array();
$news_bottom = array();
$news_m = array
(
    array
    (
        'display'=>0,
        'date'=>'2009年2月17日',
        'url'=>'http://www.talemado.com/',
        'text'=>'「タレントの窓口」をリリースしました<br /><br /><a href="'.ILUNAURL.'/press/2009/0217.html">プレスリリースはこちら</a>'
    ),
    array
    (
        'display'=>0,
        'date'=>'2008年12月18日',
        'url'=>'http://www.tenmono.com/',
        'text'=>'「転職のモノサシ」が12月13日発売の夕刊フジ1面に掲載されました'
    ),
    array
    (
        'display'=>0,
        'date'=>'2008年12月15日',
        'url'=>'',
        'text'=>'翔泳社発行の「モバイルを極める 広告・集客・サイト運営の大原則」に弊社代表矢作のコラムが掲載されました'
    ),
    array
    (
        'display'=>0,
        'date'=>'2008年12月9日',
        'url'=>'http://www.tenmono.com/rank/',
        'text'=>'年収・給料を計るサイト「転職のモノサシ」年収が気になる企業ランキング2008を発表<br /><br /><a href="'.ILUNAURL.'/press/2008/1209.html">プレスリリースはこちら</a>'
    ),
    array
    (
        'display'=>0,
        'date'=>'2008年11月25日',
        'url'=>'http://www.serviced-apartments-tokyo.com/',
        'text'=>'東京サービスアパートメントサイトをリリースしました<br /><br /><a href="'.ILUNAURL.'/press/2008/pdf/20081125.pdf">プレスリリースはこちら</a>'
    )
);

$i = 0;
foreach($news_m as $key => $val){
    if($val['display'] == 0){
        if($i == 0){
            $news_top[] = $val;
        }else{
            $news_bottom[] = $val;
        }
        $i++;
    }
}
/*var_dump($news_bottom);
die();*/
$base->smarty->assign('news_top',$news_top);
$base->smarty->assign('news_bottom',$news_bottom);
?>
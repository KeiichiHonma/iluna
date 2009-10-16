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
        'date'=>'2009年10月16日',
        'url'=>'',
        'text'=>'<a href="http://markezine.jp/article/detail/8558">弊社矢作のMarkezine連載第4回目が掲載されました。</a>'
    ),
    array
    (
        'display'=>0,
        'date'=>'2009年9月14日',
        'url'=>'',
        'text'=>'「<a href="http://www.serviced-apartments-tokyo.com/">東京サービスアパートメント</a>」をリニューアルしました<br /><br /><a href="'.ILUNAURL.'/press/2009/0914.html">プレスリリースはこちら</a>'
    ),
    array
    (
        'display'=>0,
        'date'=>'2009年9月7日',
        'url'=>'',
        'text'=>'<a href="http://markezine.jp/article/detail/8237">弊社矢作のMarkezine連載第3回目が掲載されました。</a>'
    ),
    array
    (
        'display'=>0,
        'date'=>'2009年8月14日',
        'url'=>'',
        'text'=>'「教えてCA!」に<a href="http://www.oshiete-ca.com/bulletin/list">模擬面接・掲示板機能</a>が追加されました。<br /><br /><a href="'.ILUNAURL.'/press/2009/0814.html">プレスリリースはこちら</a>'
    ),
    array
    (
        'display'=>0,
        'date'=>'2009年8月7日',
        'url'=>'',
        'text'=>'<a href="http://markezine.jp/article/detail/7973">弊社矢作のMarkezine連載第2回目が掲載されました。</a>'
    ),
    array
    (
        'display'=>0,
        'date'=>'2009年7月17日',
        'url'=>'',
        'text'=>'「転職のモノサシモバイル」が日経産業新聞の4面に掲載されました。'
    ),
    array
    (
        'display'=>0,
        'date'=>'2009年7月16日',
        'url'=>'',
        'text'=>'「転職のモノサシモバイル」がが<a href="http://www.j-cast.com/kaisha/2009/07/16045472.html">J-CAST</a>に取上げられました。'
    ),
    array
    (
        'display'=>0,
        'date'=>'2009年7月16日',
        'url'=>'',
        'text'=>'「<a href="http://www.tenmono.com/">転職のモノサシモバイル</a>」をリリースしました<br /><br /><a href="'.ILUNAURL.'/press/2009/0716.html">プレスリリースはこちら</a>'
    ),
    array
    (
        'display'=>0,
        'date'=>'2009年6月30日',
        'url'=>'',
        'text'=>'「<a href="http://www.oshiete-ca.com/">教えてCA!</a>」が<a href="http://markezine.jp/article/detail/7681">MarkeZine</a>に<br />取上げられました。'
    ),
    array
    (
        'display'=>0,
        'date'=>'2009年6月30日',
        'url'=>'',
        'text'=>'「教えてCA!」をリリースしました <br /><br /><a href="'.ILUNAURL.'/press/2009/0630.html">プレスリリースはこちら</a>'
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
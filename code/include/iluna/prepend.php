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
		'date'=>'2008年8月13日',
		'url'=>'',
		'text'=>'<a href="http://www.tenmono.com/">転職のモノサシ</a>が8月13日発売の日経産業新聞13面に掲載されました。'
	),
	array
	(
		'display'=>0,
		'date'=>'2008年8月11日',
		'url'=>'http://www.tenmono.com/blog_parts/',
		'text'=>'年収・給料・給与を上場企業から計る「転職のモノサシ」のブログパーツをリリースしました'
	),
	array
	(
		'display'=>0,
		'date'=>'2008年8月11日',
		'url'=>'http://www.tenmono.com/',
		'text'=>'年収・給料・給与を上場企業から計る「転職のモノサシ」をオープンしました<br /><br /><a href="http://www.iluna.co.jp/press/20080811.pdf">プレスリリースはこちら</a>'
	),
	array
	(
		'display'=>0,
		'date'=>'2008年8月8日',
		'url'=>'',
		'text'=>'大人のブラックテイストマガジンLUSSWに代表 矢作が紹介されました'
	),
	array
	(
		'display'=>0,
		'date'=>'2008年8月7日',
		'url'=>'http://www.iluna.co.jp/',
		'text'=>'株式会社イルナコーポレートサイトをオープンしました'
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="イルナ,iluna" name="keywords"/>
<meta content="「多様な選択肢の中から選ぶ幸せ」という価値を提供。株式会社イルナは月（LUNA）のように、ユーザの足元を照らす（illuminate）ことで、ユーザの様々な活動の手助けをします。" name="description"/>
<link type="text/css" rel="stylesheet" href="/css/common.css">
<link type="text/css" rel="stylesheet" href="/css/press.css">
<script type="text/javascript" defer="defer" src="/js/alphafilter.js"></script>
<title>{$press.0.col_title} | iLUNA</title>
</head>
<body>
<div id="wrapper">
    {include file="include/header.inc"}
    <div id="page">
        <div id="side_l">
        <h2 class="title">プレスリリース</h2>
        <ul>
        <li class="index_line">{if $year == 2010}2010年{else}<a href="{$smarty.const.ILUNAURL}/press/">2010年</a>{/if}</li>
        <li class="index_line">{if $year == 2009}2009年{else}<a href="{$smarty.const.ILUNAURL}/press/index/year/2009">2009年</a>{/if}</li>
        <li class="index_line">{if $year == 2008}2008年{else}<a href="{$smarty.const.ILUNAURL}/press/index/year/2008">2008年</a>{/if}</li>
        </ul>
        </div>
        
        <div id="contents">
            <img src="/img/press_picture.jpg" width="545" height="131" alt="" /><img src="/img/bg4.png" width="545" height="13" class="alphafilter" alt="" />
            <div id="bottom_right">
                {if $press}
                {include file="include/press/`$date_y`/`$date_md`.inc"}
                {else}
                プレスリリースがありません。
                {/if}
            </div>
        </div>
    </div>
</div>
{*フッター*}
{include file="include/footer.inc"}
</body>
</html>

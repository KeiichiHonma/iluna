<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="イルナ,iluna" name="keywords"/>
<meta content="「多様な選択肢の中から選ぶ幸せ」という価値を提供。株式会社イルナは月（LUNA）のように、ユーザの足元を照らす（illuminate）ことで、ユーザの様々な活動の手助けをします。" name="description"/>
<link type="text/css" rel="stylesheet" href="/css/common.css">
<link type="text/css" rel="stylesheet" href="/css/press.css">
<script type="text/javascript" defer="defer" src="/js/alphafilter.js"></script>
<title>{$year}年 - プレスリリース | iLUNA</title>
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
                <h2 class="title">{$year}年&nbsp;プレスリリース一覧</h2>
                <ul>
                {if $press}
                    {foreach from=$press key="key" item="value" name="press"}
                    <li class="index">{$value.col_date|date_format2}</li>
                    
                    
                    
                    <li{if !$smarty.foreach.press.last} class="data"{/if}>
                    {$value.col_date|make_news_judge_new}<a href="{$smarty.const.ILUNAURL}/press/view/nid/{$value._id}">{$value.col_title}</a>
                    <br />{$value.col_news|nl2br}</li>
                    {/foreach}
                {else}
                    プレスリリースはありません。
                {/if}

                </ul>
            </div>
        </div>
    </div>
</div>
{*フッター*}
{include file="include/footer.inc"}
</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="システム管理" name="keywords"/>
<meta content="システム管理" name="description"/>
<link type="text/css" rel="stylesheet" href="/css/common.css">
<link type="text/css" rel="stylesheet" href="/css/system.css">
<script type="text/javascript" defer="defer" src="/js/alphafilter.js"></script>
<title>システム管理</title>
</head>
<body>
<div id="wrapper">
    {include file="include/header.inc"}
    <div id="page">
        <div id="system">
        {include file="include/system/navi.inc"}
        <h2 class="title">お知らせ一覧</h2>
        {include file="include/sp.inc"}
        <a href="{$smarty.const.ILUNAURL}/system/news/entry">追加</a>
        {if $news}
                <dl class="system_list">
                    <dd class="index_line">
                        <dl>
                            <dd class="date_name">日時</dd>
                            <dd class="title_name">お知らせタイトル</dd>
                        </dl>
                    </dd>
        {foreach from=$news key="key" item="value" name="news"}
                    <dd class="line">
                        <dl>
                            <dd class="date">{$value.col_date|date_format2}</dd>
                            <dd class="seminar"><a href="{$smarty.const.ILUNAURL}/system/news/view/nid/{$value._id}">{$value.col_title}</a></dd>
                        </dl>
                    </dd>
        {/foreach}
                </dl>
        {else}
        お知らせがありません。
        {/if}
        </div>
    </div>
</div>
{*フッター*}
{include file="include/footer.inc"}
</body>
</html>

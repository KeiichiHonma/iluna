<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="イルナ,iluna" name="keywords"/>
<meta content="「多様な選択肢の中から選ぶ幸せ」という価値を提供。株式会社イルナは月（LUNA）のように、ユーザの足元を照らす（illuminate）ことで、ユーザの様々な活動の手助けをします。" name="description"/>
<link type="text/css" rel="stylesheet" href="/css/common.css">
<link type="text/css" rel="stylesheet" href="/css/index.css">
<script type="text/javascript" defer="defer" src="/js/alphafilter.js"></script>
<title>ホーム | iLUNA</title>
</head>
<body>
<div id="wrapper">
    {include file="include/header.inc"}
    <div id="page">
<h2>エラーが発生しました。</h2>
<div>
{foreach from=$errorlist key="key" item="value" name="errorlist"}
{if $key == "str" && is_array($value)}
{foreach from=$value key="key2" item="value2" name="errorlist2"}
{$value2|nl2br}<br />
{/foreach}
{else}
{$value|nl2br}<br />
{/if}
{/foreach}
</div>
    </div>
</div>
{*フッター*}
{include file="include/footer.inc"}
</body>
</html>

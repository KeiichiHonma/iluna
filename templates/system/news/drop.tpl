<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="システム管理" name="keywords"/>
<meta content="システム管理" name="description"/>
<link type="text/css" rel="stylesheet" href="/css/common.css">
<link type="text/css" rel="stylesheet" href="/css/system.css">
<link type="text/css" rel="stylesheet" href="/css/form.css">
<link id="calendar_style" href="/css/simple.css" media="screen" rel="Stylesheet" type="text/css" />
<script type="text/javascript" defer="defer" src="/js/alphafilter.js"></script>
<script src="/js/prototype.js" type="text/javascript"></script>
<script src="/js/effects.js" type="text/javascript"></script>
<script src="/js/protocalendar.js" type="text/javascript"></script>
<script src="/js/lang_ja.js" type="text/javascript"></script>
<title>システム管理</title>
</head>
<body>
<div id="wrapper">
    {include file="include/header.inc"}
    <div id="page">
    <div id="system">
    {include file="include/system/navi.inc"}
    <h2 class="title">お知らせ削除</h2>
    <form id="caForm" name="caForm" action= "{$smarty.const.ILUNAURL}/system/news/drop/nid/{$nid}" method="post">
    <table id="suggest">
    <tr>
    <td width="150" valign="top">表示日付</td>
    <td>{$news.0.col_date|date_format2}</td>
    </tr>
    <tr>
    <td width="150" valign="top">タイトル</td>
    <td>{$news.0.col_title}</td>
    </tr>
    <tr>
    <td width="150" valign="top">内容</td>
    <td>{$news.0.col_news|nl2br}</td>
    </tr>
    <tr>
    <td width="150" valign="top">リンク?</td>
    <td>{if $news.0.col_link == 0 }リンクする{else}リンクしない{/if}</td>
    </tr>
    <tr>
    <td width="150" valign="top">URL</td>
    <td>{$news.0.col_url}</td>
    </tr>
    <tr>
    <td width="150" valign="top">ターゲット属性</td>
    <td>{if $news.0.col_target == 0 }別窓にする{else}別窓にしない{/if}</td>
    </tr>
    <tr>
    <td width="150" valign="top">プレスリリース?</td>
    <td>{if $news.0.col_press == 0 }プレスリリース{else}プレスリリースではない{/if}</td>
    </tr>
    <tr>
    <td width="150" valign="top">プレスリリースタイトル</td>
    <td>{$news.0.col_press_title}</td>
    </tr>
    </table>

    <div id="form_btn">
    <input type="submit" value=" 削除 " />
    </div>
    <input type="hidden" name="nid" value="{$nid}" />
    </form>
    </div>
    </div>
</div>
{*フッター*}
{include file="include/footer.inc"}
</body>
</html>

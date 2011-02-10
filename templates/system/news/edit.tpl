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
    <h2 class="title">お知らせ変更</h2>
    <form id="caForm" name="caForm" action= "{$smarty.const.ILUNAURL}/system/news/edit/nid{$nid}" method="post">

    {*日付*}
    <table id="suggest">
    <tr>
    <td width="150" valign="top">{"表示日付"|error_bold:$error.date}<span class="attention">＊</span></td>
    <td>
    {$error.date|error_message}
{if $smarty.post.date}
    {html_select_date field_order="YMD" year_format="%04d年" month_format="%-m月" day_format="%d日" end_year="+1" field_separator=" " year_extra='id="y"' month_extra='id="m"' day_extra='id="d"' prefix="date_" time=$smarty.post.date}<img src="/img/system/icon_calendar.gif" id="select_date_calendar_icon"/>
{else}
    {html_select_date field_order="YMD" year_format="%04d年" month_format="%-m月" day_format="%d日" end_year="+1" field_separator=" " year_extra='id="y"' month_extra='id="m"' day_extra='id="d"' prefix="date_"}<img src="/img/system/icon_calendar.gif" id="select_date_calendar_icon"/>
{/if}
    </td>
    </tr>
    </table>

{literal}
    <script type="text/javascript">
      SelectCalendar.createOnLoaded({yearSelect: 'y',
             monthSelect: 'm',
             daySelect: 'd'
            },
            {startYear: 2010,
             endYear: 2011,
             lang: 'ja',
             triggers: ['select_date_calendar_icon']
            });
    </script>
{/literal}


    <table id="suggest">
        <tr>
        <td width="150" valign="top">{"タイトル"|error_bold:$error.title}<span class="attention">＊</span></td>
        <td valign="top">{$error.title|error_message}<input type="text" name="title" value="{$smarty.post.title}" class="form_text_common" /></td>
        </tr>

        <tr>
        <td width="150" valign="top">内容</td>
        <td valign="top"><textarea name="news" class="form_textarea_common" />{$smarty.post.news}</textarea></td>
        </tr>

        <tr>
        <td width="150" valign="top">リンク？<span class="attention">＊</span></td>
        <td valign="top"><input type="radio" id="link_0" name="link" value="0" class=""{if strcasecmp($smarty.post.link,0) == 0} checked{/if} /><label for="link_0">リンクする</label>&nbsp;<input type="radio" id="link_1" name="link" value="1" class=""{if strcasecmp($smarty.post.link,1) == 0} checked{/if} /><label for="link_1">リンクしない</label>&nbsp;</td>
        </tr>

        <tr>
        <td width="150" valign="top">URL</td>
        <td valign="top"><input type="text" name="url" value="{$smarty.post.url}" class="form_text_common" /></td>
        </tr>

        <tr>
        <td width="150" valign="top">ターゲット属性<span class="attention">＊</span></td>
        <td valign="top"><input type="radio" id="target_0" name="target" value="0" class=""{if strcasecmp($smarty.post.target,0) == 0} checked{/if} /><label for="target_0">別窓にする</label>&nbsp;<input type="radio" id="target_1" name="target" value="1" class=""{if strcasecmp($smarty.post.target,1) == 0} checked{/if} /><label for="target_1">別窓にしない</label>&nbsp;</td>
        </tr>

        <tr>
        <td width="150" valign="top">プレスリリース？<span class="attention">＊</span></td>
        <td valign="top"><input type="radio" id="press_0" name="press" value="0" class=""{if strcasecmp($smarty.post.press,0) == 0} checked{/if} /><label for="press_0">プレスリリース</label>&nbsp;<input type="radio" id="press_1" name="press" value="1" class=""{if strcasecmp($smarty.post.press,1) == 0} checked{/if} /><label for="press_1">プレスリリースではない</label>&nbsp;</td>
        </tr>

        <tr>
        <td width="150" valign="top">プレスリリースタイトル</td>
        <td valign="top"><input type="text" name="press_title" value="{$smarty.post.press_title}" class="form_text_common" /></td>
        </tr>

    </table>

    <div id="form_btn">
    <input type="submit" value=" 登録 " />
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

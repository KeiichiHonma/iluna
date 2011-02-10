<html>
<head>
<title>エラー画面</title>
</head>
<body>

<div>エラーが発生しました。</div>
<table border='1'>
<tr>
<td width="150">
デバッグメッセージ
</td>
<td>
{foreach from=$errorlist.debug key="key" item="debug" name="debug"}
{if $debug.function != "throwDBError" && $debug.function != "execute" && $debug.function != "getResult"}
class::{$debug.class}<br />
function::{$debug.function}<br />
file::{$debug.file}<br />
line::{$debug.line}<br />
<br />-------------------------------------------------------------------------------------<br /><br />
{/if}
{/foreach}
</td>
</tr>

<tr>
<td>
メッセージ
</td>
<td>
{foreach from=$errorlist.msg key="key" item="msg" name="msg"}
{$msg}<br />
{/foreach}
</td>
</tr>

{if $errorlist.query}
<tr>
<td>
クエリ
</td>
<td>
{$errorlist.query}
</td>
</tr>
{/if}

</table>
</body>
</html>
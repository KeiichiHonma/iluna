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
        <form name="login" action= "{$smarty.const.ILUNAURL}/system/login" method="POST">
        <div id="one_parts">
         <div id="action">
          <div class="center_block">
           <div class="center_list">
            <div class="company">株式会社iLUNA</div>
            <div class="br">&nbsp;</div>
            <table class="login">
             <tr>
              <td>ログイン名</td>
              <td>
               <input type="text" size="40" name="code" value="">
              </td>
             </tr>
             <tr>
              <td>パスワード</td>
              <td>
              <input type="password" size="40" name="password" value="">
              </td>
             </tr>
             <tr>
              <td>&nbsp;</td>
              <td><input type="submit" value="ログイン"></td>
             </tr>
            </table>

           </div>
          </div>
         </div><!--action_end--->
        </div>
        </form>
    </div>
</div>
{*フッター*}
{include file="include/footer.inc"}
</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="イルナ,iluna" name="keywords"/>
<meta content="「多様な選択肢の中から選ぶ幸せ」という価値を提供。株式会社イルナは月（LUNA）のように、ユーザの足元を照らす（illuminate）ことで、ユーザの様々な活動の手助けをします。" name="description"/>
<link type="text/css" rel="stylesheet" href="/css/common.css">
<link type="text/css" rel="stylesheet" href="/css/kujapan.css">
<script type="text/javascript" defer="defer" src="/js/alphafilter.js"></script>
<title>日遊酷棒お問い合わせ | iLUNA</title>
</head>
<body>
<div id="wrapper">
    {include file="include/header.inc"}
    <div id="page">
        <div id="side_l">
        {include file="include/news.inc"}
        </div>
        
        <div id="contents">
            <img src="/img/kujapan/kujapan_top.gif" width="545" height="131" alt="" />
            <div id="bottom_right">
                <h2 class="title">お問い合わせ</h2>


    <div id="contact_top">
        以下の項目を入力して[お問い合わせ]ボタンをクリックしてください。<br />
        <span class="hissu">＊</span>の項目は必須となります。
        <div class="contact">
            <form name="contact" action= "/kujapan/contact" method="post">
            <table cellpadding="5" cellspacing="1" class="contact">
                <tr>
                    <td class="form_ttl">
                        <table cellspacing="0" cellpadding="5">
                        <tr>
                        <td>
                        {if isset($error.company)}
                        <b>貴社名</b>
                        {else}
                        貴社名
                        {/if}
                        <span class="hissu">＊</span></td>
                        </tr>
                        </table>
                    </td>
                    <td class="form_data">
                        {if isset($error.company)}
                        <p><b><span class="hissu">{$error.company}</span></b></p>
                        {/if}
                        <input name="company" type="text" class="common_text" value="{if $smarty.post.company}{$smarty.post.company|escape}{/if}" /><br/>
                        <p class="example">例）株式会社○○</p>
                    </td>
                </tr>
                <tr>
                    <td class="form_ttl">
                        <table cellspacing="0" cellpadding="5">
                        <tr>
                        <td>
                        {if isset($error.url)}
                        <b>貴社サイトURL</b>
                        {else}
                        貴社サイトURL
                        {/if}
                        <span class="hissu">＊</span></td>
                        </tr>
                        </table>
                    </td>
                    <td class="form_data">
                        {if isset($error.url)}
                        <p><b><span class="hissu">{$error.url}</span></b></p>
                        {/if}
                        <input name="url" type="text" class="common_text" value="{if $smarty.post.url}{$smarty.post.url|escape}{/if}" /><br/>
                        <p class="example">例）http://www.iluna.co.jp/</p>
                    </td>
                </tr>
                <tr>
                    <td class="form_ttl">
                        <table cellspacing="0" cellpadding="5">
                        <tr>
                        <td>
                        {if isset($error.unit)}
                        <b>ご担当部署名</b>
                        {else}
                        ご担当部署名
                        {/if}
                        <span class="hissu">＊</span></td>
                        </tr>
                        </table>
                    </td>
                    <td class="form_data">
                    {if isset($error.unit)}
                    <p><b><span class="hissu">{$error.unit}</span></b></p>
                    {/if}
                    <input name="unit" type="text" class="common_text" value="{if $smarty.post.unit}{$smarty.post.unit|escape}{/if}" />
                    <p class="example">例）営業部</p>
                    </td>
                </tr>
                <tr>
                    <td class="form_ttl">
                        <table cellspacing="0" cellpadding="5">
                        <tr>
                        <td>役職</td>
                        </tr>
                        </table>
                    </td>
                    <td class="form_data">
                    <input name="class" type="text" class="common_text" value="{if $smarty.post.class}{$smarty.post.class|escape}{/if}" />
                    <p class="example">例）部長</p>
                    </td>
                </tr>
                <tr>
                    <td class="form_ttl">
                        <table cellspacing="0" cellpadding="5">
                        <tr>
                        <td>
                        {if isset($error.name)}
                        <b>ご担当者様名</b>
                        {else}
                        ご担当者様名
                        {/if}
                        <span class="hissu">＊</span></td>
                        </tr>
                        </table>
                    </td>
                    <td class="form_data">
                        {if isset($error.name)}
                        <p><b><span class="hissu">{$error.name}</span></b></p>
                        {/if}
                        <input name="name" type="text" class="common_text" value="{if $smarty.post.name}{$smarty.post.name|escape}{/if}" /><br/>
                        <p class="example">例）山田 太郎</p>
                    </td>
                </tr>
                <tr>
                    <td class="form_ttl">
                        <table cellspacing="0" cellpadding="5">
                        <tr>
                        <td>
                        {if isset($error.name)}
                        <b>フリガナ</b>
                        {else}
                        フリガナ
                        {/if}
                        <span class="hissu">＊</span></td>
                        </tr>
                        </table>
                    </td>
                    <td class="form_data">
                        {if isset($error.kana)}
                        <p><b><span class="hissu">{$error.kana}</span></b></p>
                        {/if}
                        <input name="kana" type="text" class="common_text" value="{if $smarty.post.kana}{$smarty.post.kana|escape}{/if}" /><br/>
                        <p class="example">例）ヤマダ タロウ</p>
                    </td>
                </tr>
                <tr>
                    <td class="form_ttl">
                        <table cellspacing="0" cellpadding="5">
                        <tr>
                        <td>
                        {if isset($error.mail)}
                        <b>Eメールアドレス</b>
                        {else}
                        Eメールアドレス
                        {/if}
                        <span class="hissu">＊</span></td>
                        </tr>
                        </table>
                    </td>
                    <td class="form_data">
                        {if isset($error.mail)}
                        <p><b><span class="hissu">{$error.mail}</span></b></p>
                        {/if}
                        <input name="mail" type="text" class="common_text" value="{if $smarty.post.mail}{$smarty.post.mail|escape}{/if}" /><br/>
                        <p class="example">例）****@iluna.co.jp</p>
                    </td>
                </tr>
                <tr>
                    <td class="form_ttl">
                        <table cellspacing="0" cellpadding="5">
                        <tr>
                    <td>
                        {if isset($error.telephone)}
                        <b>電話番号</b>
                        {else}
                        電話番号
                        {/if}
                        <span class="hissu">＊</span></td>
                        </tr>
                        </table>
                    </td>
                        <td class="form_data">
                        {if isset($error.telephone)}
                        <p><b><span class="hissu">{$error.telephone}</span></b></p>
                        {/if}
                        <input name="telephone1" type="text" size="5" maxlength="4" value="{if $smarty.post.telephone1}{$smarty.post.telephone1|escape}{/if}" />&nbsp;-&nbsp;<input name="telephone2" type="text" size="5" maxlength="4" value="{if $smarty.post.telephone2}{$smarty.post.telephone2|escape}{/if}" />&nbsp;-&nbsp;<input name="telephone3" type="text" size="5" maxlength="4" value="{if $smarty.post.telephone3}{$smarty.post.telephone3|escape}{/if}" />
                        <p class="example">例）03-1234-5678</p>
                    </td>
                </tr>
                <tr>
                    <td class="form_ttl">
                        <table cellspacing="0" cellpadding="5">
                        <tr>
                        <td>
                        {if isset($error.address)}
                        <b>住所</b>
                        {else}
                        住所
                        {/if}
                        <span class="hissu">＊</span></td>
                        </tr>
                        </table>
                    </td>
                    <td class="form_data">
                        {if isset($error.address)}
                        <p><b><span class="hissu">{$error.address}</span></b></p>
                        {/if}
                        <input name="address" type="text" class="common_text" value="{if $smarty.post.address}{$smarty.post.address|escape}{/if}" /><br/>
                        <p class="example">例）東京都渋谷区代々木4-31-4 キャッスル新宿802号</p>
                    </td>
                </tr>
                <tr>
                    <td class="form_ttl">
                        <table cellspacing="0" cellpadding="5">
                        <tr>
                        <td>
                        {if isset($error.detail)}
                        <b>お問い合わせ詳細</b>
                        {else}
                        お問い合わせ詳細
                        {/if}
                        <span class="hissu">＊</span></td>
                        </tr>
                        </table>
                    </td>
                    <td class="form_data">
                        {if isset($error.detail)}
                        <p><b><span class="hissu">{$error.detail}</span></b></p>
                        {/if}
                        <textarea name="detail" class="detail">{if $smarty.post.detail}{$smarty.post.detail|escape}{/if}</textarea>
                    </td>
                </tr>
            </table>
            <div class="form_submit">
            <input type="image" src="/img/kujapan/b_contact.gif" alt="お問い合わせ">
            </div>
            </form>
        </div>
    </div>


            </div>
        </div>
    </div>
</div>
{*フッター*}
{include file="include/footer.inc"}
</body>
</html>

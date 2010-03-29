    <div id="header">
    <h1>{$h1}</h1>
    <p class="logo alphafilter"><a href="{$smarty.const.ILUNAURL}">イルナロゴ</a></p>
    </div>
    {*ナビ*}
    <div id="gnavi">
    <ul>
    <li><a href="{$smarty.const.ILUNAURL}/"><img src="/img/gnavi/n_home{if $gnavi == "index"}_on{/if}.gif" alt="イルナHOME" width="63" height="30" class="{if $gnavi == "index"}{else}btn{/if}" /></a></li>
    <li><a href="{$smarty.const.ILUNAURL}/press/"><img src="/img/gnavi/n_release{if $gnavi == "press"}_on{/if}.gif" alt="プレスリリース" width="119" height="30" border="0" class="{if $gnavi == "press"}{else}btn{/if}" /></a></li>
    <li><a href="{$smarty.const.ILUNAURL}/service"><img src="/img/gnavi/n_service{if $gnavi == "service"}_on{/if}.gif" alt="提供サービス" width="107" height="30" border="0" class="{if $gnavi == "service"}{else}btn{/if}" /></a></li>
    <li><a href="{$smarty.const.ILUNAURL}/corp"><img src="/img/gnavi/n_corp{if $gnavi == "corp"}_on{/if}.gif" alt="会社情報" width="83" height="30" border="0" class="{if $gnavi == "corp"}{else}btn{/if}" /></a></li>
    <li><a href="{$smarty.const.ILUNAURL}/recruit"><img src="/img/gnavi/n_recruit{if $gnavi == "recruit"}_on{/if}.gif" alt="採用情報" width="83" height="30" border="0" class="{if $gnavi == "recruit"}{else}btn{/if}" /></a></li>
    <li><a href="{$smarty.const.ILUNAURL}/contact"><img src="/img/gnavi/n_contact{if $gnavi == "contact"}_on{/if}.gif" alt="お問い合わせ" width="107" height="30" border="0" class="{if $gnavi == "contact"}{else}btn{/if}" /></a></li>
    </ul>
    </div>
    {if $position}
    <div id="position">
    {foreach from=$position key="key" item="value" name="position"}
    {if !$smarty.foreach.position.last}
    <a href="{$key}">{$value|make_strim:40}</a><img src="/img/position_arrow.gif" width="11" height="11" alt="" />
    {else}
    {$value|make_strim:40}
    {/if}
    {/foreach}
    </div>
    {/if}
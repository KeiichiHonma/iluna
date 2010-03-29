{if $sp_manager}
<div id="sp">
    <p class="numbering_txt">{if $search_count}{$search_count}件中&nbsp;{/if}{$sp_manager.current.display}件目を表示しています。 </p>
{if isset($sp_manager.before)}
    <p class="page_txt"><a href="{$sp_manager.before.url}">＜前へ</a></p>
{else}
    <p class="page_txt"><span class="unlink">＜前へ</span></p>
{/if}
    <div class="numbering">
{foreach from=$sp_manager.list key="number" item="array" name="sp_list"}
{if $array.isCurrent}
    <p class="here">{$number}</p>
{else}
    <a href="{$array.url}">{$number}</a>
{/if}
{/foreach}
    </div>
{if isset($sp_manager.next)}
    <p class="page_txt"><a href="{$sp_manager.next.url}">次へ＞</a></p>
{else}
    <p class="page_txt"><span class="unlink">次へ＞</span></p>
{/if}
</div>
{/if}

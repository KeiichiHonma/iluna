<h2 class="title">お知らせ</h2>
<ul class="news">
{foreach from=$news key="key" item="value" name="news"}
<li class="index">{$value.col_date|date_format2}</li>
<li{if !$smarty.foreach.news.last} class="data"{/if}>
{if $value.col_press == 0}
    {$value.col_date|make_news_judge_new}<a href="{$smarty.const.ILUNAURL}/press/view/nid/{$value._id}">{$value.col_title}</a>
{elseif $value.col_link == 0 && isset($value.col_url)}
    {$value.col_date|make_news_judge_new}<a href="{$value.col_url}" {if $value.col_target == 0}target="_blank"{/if}>{$value.col_title}</a>
{else}
    {$value.col_date|make_news_judge_new}{$value.col_title}{if strlen($value.col_news) > 0}<br />{$value.col_news|nl2br}{/if}
{/if}

</li>
{/foreach}
</ul>
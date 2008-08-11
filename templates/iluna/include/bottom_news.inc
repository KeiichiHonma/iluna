{foreach from=$news_bottom key="key" item="array" name="news_bottom"}
<div id="index_red"><strong>{$array.date}</strong></div>
<div id="index_contents72">{if $array.url != ''}<a href="{$array.url}">{$array.text}</a>{else}{$array.text}{/if}</div>
<div id="line"><img alt="" src="img/1_line2.gif"></div>
{/foreach}
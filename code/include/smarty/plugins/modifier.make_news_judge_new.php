<?php
function smarty_modifier_make_news_judge_new($date)
{
    $html = '';
    $now = time();
    $before_week = $now - 604800;
    if($date > $before_week) $html = '<img src="/img/icon_new.gif" width="24" height="11">&nbsp;';
    return $html;
}
?>

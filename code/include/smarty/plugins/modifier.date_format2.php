<?php
function smarty_modifier_date_format2($string, $format = "Y年n月j日", $default_date = '')
{
    if ($string != '') {
        $date = date($format,$string);
    } else {
        return;
    }
    return $date;
}
?>
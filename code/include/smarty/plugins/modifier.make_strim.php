<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/*ex) 
'メールアドレス'=>array('name'=>'mail','type'=>'text','func'=>null,'class'=>'form_text_common','must'=>TRUE,'front'=>'','back'=>'')*/

function smarty_modifier_make_strim($string,$strimbyte = 30, $marker = '…')
{
    $TMP_ENC = 'SJIS';
    $encoding = 'UTF-8';
    $e_str  = mb_convert_encoding( $string,'SJIS','UTF-8');

    $e_marker  = mb_convert_encoding( $marker,'SJIS','UTF-8');
    if( strlen( $e_str ) > $strimbyte ){
        $mksize = strlen( $e_marker );
        $result = mb_strcut( $e_str, 0, $strimbyte-$mksize, $TMP_ENC );
        $string = mb_convert_encoding( $result . $e_marker, $encoding, $TMP_ENC );
    }
    return $string;
}
?>

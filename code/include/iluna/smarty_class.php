<?php
class smarty_class{
    //smarty
	var $smarty;

    function getSmarty(){
	    require_once('smarty/Smarty.class.php');
	    //smarty
		$this->smarty = new Smarty;
		// Smarty の設定
		$this->smarty->caching = false;//デバッグ：false,通常：true
/*		$compile_checkが有効の時、キャッシュファイルに入り組んだすべてのテンプレートファイルと設定ファイルは
		修正されたかどうかをチェックされます。もしキャッシュが生成されてからいくつかのファイルが修正されていた場合、
		キャッシュは即座に再生成されます。これは最適なパフォーマンスのためには僅かなオーバーヘッドになるので、
		$compile_checkはfalseにして下さい。*/
		$this->smarty->compile_check = true;//デバッグ：true,通常：false
		$this->smarty->template_dir = '/usr/local/apache2/smarty/templates/iluna/';
		$this->smarty->compile_dir  = '/usr/local/apache2/smarty/templates_c/iluna/';
		$this->smarty->config_dir   = '/usr/local/apache2/smarty/configs/';
		$this->smarty->cache_dir    = '/usr/local/apache2/smarty/cache/';
	}

}
?>

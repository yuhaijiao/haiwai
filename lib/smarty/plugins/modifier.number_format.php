<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Include the {@link shared.make_timestamp.php} plugin
 */
function smarty_modifier_number_format($string)
{
    // find periods with a word before but not after.
	return number_format($string,2);
	/* $CurrencyC=$_SESSION["CurrencyCodeT"] ? $_SESSION["CurrencyCodeT"] : $_COOKIE['CurrencyCode'];
	if($CurrencyC=='JPY'){
		return str_replace(',','，',number_format($string));
	}
	else{
		$Lang = $_SESSION["langcookie"] ? $_SESSION["langcookie"] : $_COOKIE['lang_cookie'];
		switch($Lang){
			case 'de-ge':
				return number_format($string,2,",",".");
			break;
			case 'fr-fr':
				return number_format($string,2,",",".");
			break;
			case 'es-sp':
				return number_format($string,2,",",".");
			break;
			case 'it-it':
				return number_format($string,2,",",".");
			break;
			default:
				return number_format($string,2);
		}
	} */
    //return number_format($string,0,".","");
}
/* vim: set expandtab: */

?>

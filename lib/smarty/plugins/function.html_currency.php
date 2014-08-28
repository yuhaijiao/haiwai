<?php
use Helper\ResponseUtil as rew;
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {html_header_seo} plugin
 *
 * Type:     function
 * Name:     html_header_seo
 * Purpose:  主页的subscribe
 *
 * @version 1.0.0
 * @author jianjun wu <wujianjun@milanoo.com>
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_html_currency($params, &$smarty)
{
	//{-html_feature_list num=5-}subscribe_to_the_weekly_shameless
	$html_result ='';
	if(SELLER_LANG == 'ja-jp'){
		return '';
	}
	$currency_all = \config\Currency::$currencyTranslations;
	$current_code = $smarty->_tpl_vars['CurrencyCode'];
	$html_result .= '<li class="pull icon_'.$current_code.'" id="currency">';
	$html_result .= '<a href="'.ROOT_URLD.'app/currency.php?currency='.$key.'" rel="nofollow">'.\LangPack::$items['Currency'].':'.Currency.'</a>';
	$html_result .= '<dl class="currency pop_menu" style="width:145px;left:-14px;">';
	$html_result .= '<dt>'.\LangPack::$items['Currency'].':<b>'.Currency.'</b></dt>';
	foreach ($currency_all as $key=>$v){
			$html_result .= '<dd currency="'.$key.'"><a class="'.$v['css'].'_c" href="'.ROOT_URLD.'app/currency.php?currency='.$key.'" rel="nofollow">'.$v['name'][SELLER_LANG].'</a></dd>';
	}
	$html_result .= '</dl>';
	$html_result .= '</li>';
    return $html_result;
}


?>
<?php
use Helper\ResponseUtil as rew;
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {html_nav} plugin
 *
 * Type:     function
 * Name:     html_nav
 * Purpose:  ��ҳ����
 *
 * @version 1.0.0
 * @author jianjun wu <wujianjun@milanoo.com>
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_html_index_intro($params, &$smarty)
{
	$html_result = '';
	$about_url ='';
	$buyer_url = '';
	$facebook_url = '';
	switch (SELLER_LANG){
		case 'en-uk':
			$about_url = ROOT_URL.'help/index-id-41.html';
			$buyer_url = 'https://www.mcafeesecure.com/RatingVerify?ref=www.milanoo.com';
			$facebook_url = 'http://www.facebook.com/milanoo.us';
		break;
		case 'ja-jp':
			$about_url = ROOT_URL.'jp/help/index-id-85.html';
			$buyer_url = 'https://www.mcafeesecure.com/RatingVerify?ref=www.milanoo.com&lang=JP';
			$facebook_url = 'http://www.facebook.com/milanoo.us';
		break;
		case 'fr-fr':
			$about_url = ROOT_URL.'fr/help/About-Milanoo--module-index-id-57.html';
			$buyer_url = 'https://www.mcafeesecure.com/RatingVerify?ref=www.milanoo.com&lang=FR';
			$facebook_url = 'http://www.facebook.com/milanoo.fr';
		break;
		case 'de-ge':
			$about_url = ROOT_URL.'de/help/About-Milanoo--module-index-id-41.html';
			$buyer_url = 'https://www.mcafeesecure.com/RatingVerify?ref=www.milanoo.com&lang=DE';
			$facebook_url = 'http://www.facebook.com/pages/Milanoo-Deutsch/152370671497488';
		break;
		case 'es-sp':
			$about_url = ROOT_URL.'es/help/About-Milanoo--module-index-id-41.html';
			$buyer_url = 'https://www.mcafeesecure.com/RatingVerify?ref=www.milanoo.com&lang=ES';
			$facebook_url = 'http://www.facebook.com/pages/Milanoo-Espa%C3%B1a/133836160036911?sk=app_106878476015645';
		break;
		case 'it-it':
			$about_url = ROOT_URL.'it/help/About-Milanoo--module-index-id-41.html';
			$buyer_url = 'https://www.mcafeesecure.com/RatingVerify?ref=www.milanoo.com&lang=IT';
			$facebook_url = 'http://www.facebook.com/mipiace.milanooitalia';
		break;
		case 'ru-ru':
			$about_url = ROOT_URL.'ru/help/About-Milanoo--module-index-id-41.html';
			$buyer_url = 'https://www.mcafeesecure.com/RatingVerify?ref=www.milanoo.com&lang=EN';
			$facebook_url = 'http://www.facebook.com/milanoo.us';
		break;
	}
	$html_result .= '<div class="intro">';
	$html_result .= '<dl class="one">';
	$html_result .= '<dt><a rel="nofollow" href="'.$about_url.'" target="_black">'.\LangPack::$items['about_milanoo'].'</a></dt>';
	$html_result .= '<dd><a rel="nofollow" href="'.$about_url.'" target="_black">'.\LangPack::$items['about_milanoo_desc'].'</a></dd>';
	$html_result .= '</dl>';
	$html_result .= '<dl class="two">';
	$html_result .= '<dt><a rel="nofollow" href="'.$buyer_url.'" target="_black">'.\LangPack::$items['buyer_pro'].'</a></dt>';
	$html_result .= '<dd><a rel="nofollow" href="'.$buyer_url.'" target="_black">'.\LangPack::$items['buyer_pro_desc'].'</a></dd>';
	$html_result .= '</dl>';
	$html_result .= '<dl class="three">';
	$html_result .= '<dt><a rel="nofollow" href="'.$facebook_url.'" target="_black">'.\LangPack::$items['facebook_freebies'].'</a></dt>';
	$html_result .= '<dd><a rel="nofollow" href="'.$facebook_url.'" target="_black">'.\LangPack::$items['facebook_freebies_desc'].'</a></dd>';
	$html_result .= '</dl>';
	$html_result .= '</div>';
    return $html_result;
}

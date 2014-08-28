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
function smarty_function_join_us_on($params, &$smarty)
{
	$html_result = '';
	$fackbook_url = 'http://www.facebook.com/milanoo.us';
	$twitter_url = 'http://twitter.com/#!/milanoo_en';
	$youtube_url = 'http://www.youtube.com/user/Milanoocom';
	$milanoo_blog = 'http://blog.milanoo.com/';
	$html_result .= '<dl class="share_box">';
    $html_result .= '<dt>'.\LangPack::$items['join_us_on'].'</dt>';
    switch (SELLER_LANG){
    	case 'fr-fr':
    		$fackbook_url = 'http://www.facebook.com/milanoo.fr';
    		$twitter_url = 'https://twitter.com/#!/MilanooFrance';
    	break;
    	case 'de-ge':
    		$fackbook_url = 'http://www.facebook.com/pages/Milanoo-Deutsch/152370671497488';
    	break;
    	case 'es-sp':
    		$fackbook_url = 'http://www.facebook.com/pages/Milanoo-Espa%C3%B1a/133836160036911?sk=app_106878476015645';
    	break;
    	case 'it-it':
    		$fackbook_url = 'http://www.facebook.com/mipiace.milanooitalia';
    	break;
    }
    $html_result .= '<dd><a class="s_facebook" href="'.$fackbook_url.'" rel="nofollow" target="_black"></a><a href="'.$fackbook_url.'" target="_black">Facebook</a></dd>';
    $html_result .= '<dd><a class="s_twitter" href="'.$twitter_url.'" rel="nofollow" target="_black"></a><a href="'.$twitter_url.'" target="_black">Twitter</a></dd>';
    $html_result .= '<dd><a class="s_youtube" href="'.$youtube_url.'" rel="nofollow" target="_black"></a><a href="'.$youtube_url.'" target="_black">Youtube</a></dd>';
    $html_result .= '<dd><a class="s_milan" href="'.$milanoo_blog.'" target="_black"></a><a href="'.$milanoo_blog.'" target="_black">Milanoo Blog</a></dd>'; 
    $html_result .= '</dl>';
    return $html_result;
}

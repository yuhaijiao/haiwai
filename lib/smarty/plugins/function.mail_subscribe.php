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
function smarty_function_mail_subscribe($params, &$smarty)
{
	$html_result .= '<div class="mail_subscribe" style="background:url(\''.IMAGE_GLOBAL_URL.'newletter-'.SELLER_LANG.'.png?r='.REVISION.'\') no-repeat;">';
	$mail_url = "?module=mail&action=subscribe";
	$mail_sepcial_url = "?module=promotions&action=specials&id=";
	switch (SELLER_LANG){
		case 'en-uk':
			$html_result .= '<a href="'.rew::rewrite(array('url'=>$mail_sepcial_url.'570','isxs'=>'no')).'" id="mail_link">'.\LangPack::$items['Details'].'</a>';
		break;
		case 'fr-fr':
			$html_result .= '<a href="'.rew::rewrite(array('url'=>$mail_sepcial_url.'1447','isxs'=>'no')).'" id="mail_link">'.\LangPack::$items['Details'].'</a>';
		break;
		case 'de-ge':
			$html_result .= '<a href="'.rew::rewrite(array('url'=>$mail_sepcial_url.'1459','isxs'=>'no')).'" id="mail_link">'.\LangPack::$items['Details'].'</a>';
		break;
		case 'es-sp':
			$html_result .= '<a href="'.rew::rewrite(array('url'=>$mail_sepcial_url.'1455','isxs'=>'no')).'" id="mail_link">'.\LangPack::$items['Details'].'</a>';
		break;
		case 'it-it':
			$html_result .= '<a href="'.rew::rewrite(array('url'=>$mail_sepcial_url.'1463','isxs'=>'no')).'" id="mail_link">'.\LangPack::$items['Details'].'</a>';
		break;
		case 'ru-ru':
			$html_result .= '<a href="'.rew::rewrite(array('url'=>$mail_sepcial_url.'1469','isxs'=>'no')).'" id="mail_link">'.\LangPack::$items['Details'].'</a>';
		break;
		case 'ja-jp':
			$html_result .= '<a href="'.rew::rewrite(array('url'=>$mail_sepcial_url.'1451','isxs'=>'no')).'" id="mail_link">'.\LangPack::$items['Details'].'</a>';
		break;
	}
	$html_result .= '<form onsubmit="return submailCheck(this);" action="'.rew::rewrite(array('url'=>$mail_url,'isxs'=>'no')).'" method="POST">';
	$html_result .= '<input name="firstname" type="text" class="subinput required" defvalue="'.\LangPack::$items['member_FirstName'].'">';
	$html_result .= '<input name="email" type="text" class="subinput required email" defvalue="'.\LangPack::$items['email_Subscription_email'].'">';
	$html_result .= '<input class="sub_but" name="" type="submit" value="'.\LangPack::$items['theme_Submit'].'">';
	$html_result .= '</form>';
	$html_result .= '</div>';
	$html_result .= "<script>jq('.subinput').defvalue( 'subinput_view' )</script>";
    return $html_result;
}


?>
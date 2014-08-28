<?php
/**
 * Smarty {html_bottom_about} plugin
 * Type:     function
 * Name:     html_bottom_about
 * Purpose:  底部home，关于，支付支持，备号等
 *
 * @version 1.0.0
 * @author Jerry Yang <yang.tao.php@milanoo.com>
 * @param array
 * @param Smarty
 * @return string
 */

function smarty_function_html_bottom_about($params, &$smarty)
{
	$html_result='';
	switch(SELLER_LANG){
		case 'en-uk':
			$copNoticeYear = date('Y');
			$html_result.=<<<xxx
				<div class="about">
				<a target="_blank" rel="nofollow" href="http://www.milanoo.com/" s_itt_ocupdate="true">Home</a> | 
				<a target="_blank" rel="nofollow" href="http://www.milanoo.com/help/About-Milanoo--module-index-id-41.html#sid=41">About us</a> | 
				<a target="_blank" href="http://affiliate.milanoo.com" s_itt_ocupdate="true">Affiliate Program</a> | 
				<a target="_blank" href="http://blog.milanoo.com/">Milanoo Blog</a> | 
				<a target="_blank" href="http://www.milanoo.com/seeall.html">Sitemap</a> | 
				<a target="_blank" rel="nofollow" href="http://www.milanoo.com/help/Submit-a-question-module-index.html">Contact us</a> |
				<a target="_blank" rel="nofollow" href="http://www.milanoo.com/experience/Read-their-experience-module-index.html">Testimonials</a> | 
				<a target="_blank" rel="nofollow" href="http://www.milanoo.com/help/Privacy-Policy--module-index-id-72.html">Privacy Policy</a> | 
				<a target="_blank" rel="nofollow" href="http://www.milanoo.com/help/Professional-AttentionProfessional-Care-module-index-id-89.html">Attention&amp;Care</a>
				</div>
				<div class="link">
				<a rel="nofollow" href="http://www.milanoo.com/help/Payment-Methods-module-index-id-19.html" target="_blank" class="l1">credit card payment</a>
				<a rel="nofollow" href="http://www.westernunion.com/" target="_blank" class="l2">western union</a>
				<a rel="nofollow" target="_blank" href="http://www.DHL.com" class="l3">DHL free shipping</a>
				<a rel="nofollow" target="_blank" href="http://www.tnt.com" class="l4">TNT free shipping</a>
				<a rel="nofollow" target="_blank" href="http://www.ems.com.cn" class="l5">EMS free shipping</a>
				<a rel="nofollow" target="_blank" href="http://www.ups.com" class="l6">UPS free shipping</a>
				<a onclick="javascript:window.open('https://www.paypal.com/verified/pal=paypal@milanoo.com','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');" rel="nofollow" href="javascript:void(0)" class="l7">paypal</a>
				<a href="https://www.mcafeesecure.com/RatingVerify?ref=www.milanoo.com" target="_blank" rel="nofollow" class="l8">mcafee secure</a>
				<a rel="nofollow" target="_blank" href="https://sealinfo.verisign.com/splash?form_file=fdf/splash.fdf&amp;dn=www.milanoo.com&amp;lang=en" class="l9">Verisign Secured</a>
				</div>
				<p class="copy">
					discount  apparel	and other cheap clothing online from 	<a title="wholesale apparel store" href="http://www.milanoo.com/">wholesale apparel store</a> 
					- Shop Wholesale	apparel	and Clothing from	<a title="Apparel Wholesaler" href="http://www.milanoo.com/"> Apparel Wholesaler</a><br />Copyright Notice &copy; 2008-$copNoticeYear Milanoo.com All rights reserved MilanooGlobal UK Limited<i class="icp"></i>
				</p>
xxx;
			break;
		case 'fr-fr':
			$copNoticeYear = date('Y');
			$html_result.=<<<xxx
				<div class="about">
				<a s_itt_ocupdate="true" rel="nofollow" href="http://www.milanoo.com/fr/" target="_blank">Accueil</a> |
				<a href="http://www.milanoo.com/fr/help/About-Milanoo--module-index-id-57.html#sid=41" rel="nofollow" target="_blank">A propos de nous</a> |   
				<a href="http://www.milanoo.com/fr/seeall.html" target="_blank">Plan du site</a>   | 
				<a href="http://www.milanoo.com/fr/help/Submit-a-question-module-index.html" rel="nofollow" target="_blank">Contactez-nous</a> | 
				<a href="http://www.milanoo.com/fr/help/Privacy-Policy--module-index-id-87.html" rel="nofollow" target="_blank">Confidentialité</a> | 
				<a rel="nofollow" href="http://www.milanoo.com/fr/help/Professional-AttentionProfessional-Care-module-index-id-18.html" target="_blank">Attention & Soins</a>
				</div>
				<div class="link">
				<a rel="nofollow" target="_blank" class="l1" href="http://www.milanoo.com/fr/help/Payment-Methods-module-index-id-19.html" >credit card payment</a>
				<a class="l2" target="_blank" href="http://www.westernunion.com/" rel="nofollow">western union</a>
				<a class="l3" href="http://www.DHL.com"  target="_blank" rel="nofollow">DHL free shipping</a>
				<a class="l4" href="http://www.tnt.com"  target="_blank" rel="nofollow">TNT free shipping</a>
				<a class="l5" href="http://www.ems.com.cn"  target="_blank" rel="nofollow">EMS free shipping</a>
				<a rel="nofollow" target="_blank" href="http://www.ups.com" class="l6">UPS free shipping</a>
				<a class="l7" href="javascript:void(0)" title="paypal" rel="nofollow" onclick="javascript:window.open('https://www.paypal.com/verified/pal=paypal@milanoo.com','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');">paypal</a>
				<a class="l8" rel="nofollow" target="_blank" href="https://www.mcafeesecure.com/RatingVerify?ref=www.milanoo.com&lang=FR">mcafee secure</a>
				<a class="l9" href="https://sealinfo.verisign.com/splash?form_file=fdf/splash.fdf&amp;dn=www.milanoo.com&amp;lang=fr"  
				target="_blank" rel="nofollow">Verisign Secured</a>
				</div>
				<p class="copy">
				Copyright Notice @ 2008-$copNoticeYear Milanoo.com Tous droits réservés  MilanooGlobal UK Limited
				</p>
xxx;
			break;
		case 'ja-jp':
			$copNoticeYear = date('Y');
			$html_result.=<<<xxx
				<div class="about">
				 <a href="http://www.milanoo.com/jp/" rel="nofollow"  s_itt_ocupdate="true">ホーム</a> | 
				 <a title="ご利用規約" href="http://www.milanoo.com/jp/help/index-id-85.html#sid=41">ご利用規約</a> | 
				 <a href="http://www.milanoo.com/jp/help/index-id-1.html" title="お問い合わせ" s_itt_ocupdate="true">お問い合わせ</a> | 
				 <a href="http://www.milanoo.com/jp/help/index-id-93.html" title="特定商取引法表示">特定商取引法表示</a> |   
				 <a href="http://www.milanoo.com/jp/help/index-id-52.html" title="プライバシーポリシー">プライバシーポリシー </a> | 
				 <a href="http://www.milanoo.com/jp/seeall.html" title="サイトマップ">サイトマップ</a> | 
				 <a href="http://www.milanoo.com/jp/links.html" title="リンク集">リンク集</a> | <a href="http://www.milanoo.com/jp/producttags">キーワード</a>
				</div>
				<div class="link">
				<a class="l1" title="credit card payment" target="_blank" href="http://www.milanoo.com/help/Payment-Methods-module-index-id-19.html" rel="nofollow">credit card payment</a>
				<a class="l2" title="western union" target="_blank" href="http://www.westernunion.com/" rel="nofollow">western union</a>
				<a class="l3" href="http://www.DHL.com" title="DHL free shipping" target="_blank" rel="nofollow">DHL free shipping</a>
				<a class="l4" href="http://www.tnt.com" title="TNT free shipping" target="_blank" rel="nofollow">TNT free shipping</a>
				<a class="l5" href="http://www.ems.com.cn" title="EMS free shipping" target="_blank" rel="nofollow">EMS free shipping</a>
				<a class="l6" href="http://www.ups.com" title="UPS free shipping" target="_blank" rel="nofollow">UPS free shipping</a>
				<a class="l7" href="javascript:void(0)" title="paypal" rel="nofollow" onclick="javascript:window.open('https://www.paypal.com/verified/pal=paypal@milanoo.com','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');">paypal</a>
				<a class="l8" rel="nofollow" target="_blank" href="https://www.mcafeesecure.com/RatingVerify?ref=www.milanoo.com&lang=JP">mcafee secure</a>
				<a class="l9" href="https://sealinfo.verisign.com/splash?form_file=fdf/splash.fdf&dn=www.milanoo.com&lang=ja" title="Verisign Secured" target="_blank" rel="nofollow">Verisign Secured</a>
				</div>
				<p class="copy">
				 Copyright Notice @ 2008-$copNoticeYear Milanoo.com All rights reserved MilanooGlobal UK Limited
				</p>
xxx;
			break;
		case 'es-sp':
			$html_result.='
				<div class="about">
				<a s_itt_ocupdate="true" href="http://www.milanoo.com/es/" target="_blank" rel="nofollow" >'.\LangPack::$items['footer_home'].'</a> | 
				<a href="http://www.milanoo.com/es/help/About-Milanoo--module-index-id-41.html#sid=41" rel="nofollow" target="_blank">'.\LangPack::$items['footer_aboutUs'].'</a> |   
				<a href="http://www.milanoo.com/es/seeall.html" target="_blank">'.\LangPack::$items['footer_siteMap'].'</a>   | 
				<a href="http://www.milanoo.com/fr/help/Submit-a-question-module-index.html" rel="nofollow" target="_blank">'.\LangPack::$items['footer_contactUs'].'</a> | 
				<a href="http://www.milanoo.com/es/help/Privacy-Policy--module-index-id-72.html" rel="nofollow" target="_blank">'.\LangPack::$items['footer_privacyPolicy'].'</a> | 
				<a rel="nofollow" href="http://www.milanoo.com/es/help/Professional-AttentionProfessional-Care-module-index-id-89.html" target="_blank">'.\LangPack::$items['footer_attenCare'].'</a> | 
				<a href="http://www.facebook.com/pages/Milanoo-en-Espanol/183398985022816" target="_blank">Facebook</a>
				</div>';
			$html_result.=<<<xxx
				<div class="link">
				<a class="l1" title="credit card payment" target="_blank" href="http://www.milanoo.com/es/help/Payment-Methods-module-index-id-19.html" rel="nofollow">credit card payment</a>
				<a class="l2" title="western union" target="_blank" href="http://www.westernunion.com/" rel="nofollow">western union</a>
				<a class="l3" href="http://www.DHL.com" title="DHL free shipping" target="_blank" rel="nofollow">DHL free shipping</a>
				<a class="l4" href="http://www.tnt.com" title="TNT free shipping" target="_blank" rel="nofollow">TNT free shipping</a>
				<a class="l5" href="http://www.ems.com.cn" title="EMS free shipping" target="_blank" rel="nofollow">EMS free shipping</a>
				<a class="l6" href="http://www.ups.com" title="UPS free shipping" target="_blank" rel="nofollow">UPS free shipping</a>
				<a class="l7" href="javascript:void(0)" title="paypal" rel="nofollow" onclick="javascript:window.open('https://www.paypal.com/verified/pal=paypal@milanoo.com','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');">paypal</a>
			   <a class="l8" rel="nofollow" target="_blank" href="https://www.mcafeesecure.com/RatingVerify?ref=www.milanoo.com&lang=ES">mcafee secure</a>
			   <a class="l9" href="https://sealinfo.verisign.com/splash?form_file=fdf/splash.fdf&dn=www.milanoo.com&lang=es" title="Verisign Secured" target="_blank" rel="nofollow">Verisign Secured</a>
				</div>
xxx;
			$html_result.='<p class="copy">'.printf(\LangPack::$items['footer_copyNoti'],date('Y')).\LangPack::$items['g_milahkco'].'</p>';
			break;
		case 'de-ge':
			$html_result.='
				<div class="about">
				<a s_itt_ocupdate="true" href="http://www.milanoo.com/de/" target="_blank" rel="nofollow" >'.\LangPack::$items['footer_home'].'</a> | 
				<a href="http://www.milanoo.com/de/help/About-Milanoo--module-index-id-41.html#sid=41" rel="nofollow" target="_blank">'.\LangPack::$items['footer_aboutUs'].'</a> |   
				<a href="http://www.milanoo.com/de/seeall.html" target="_blank">'.\LangPack::$items['footer_home'].'</a>   | 
				<a href="http://www.milanoo.com/de/help/index.html" rel="nofollow" target="_blank">'.\LangPack::$items['footer_contactUs'].'</a> | 
				<a href="http://www.milanoo.com/de/help/Privacy-Policy--module-index-id-72.html" rel="nofollow" target="_blank">'.\LangPack::$items['footer_privacyPolicy'].'</a> | 
				<a rel="nofollow" href="http://www.milanoo.com/de/help/Professional-AttentionProfessional-Care-module-index-id-89.html" target="_blank">'.\LangPack::$items['footer_attenCare'].'</a>
				</div>';
			$html_result.=<<<xxx
				<div class="link">
				<a class="l1" title="credit card payment" target="_blank" href="http://www.milanoo.com/de/help/Payment-Methods-module-index-id-19.html" rel="nofollow">credit card payment</a>
				<a class="l2" title="western union" target="_blank" href="http://www.westernunion.com/" rel="nofollow">western union</a>
				<a class="l3" href="http://www.DHL.com" title="DHL free shipping" target="_blank" rel="nofollow">DHL free shipping</a>
				<a class="l4" href="http://www.tnt.com" title="TNT free shipping" target="_blank" rel="nofollow">TNT free shipping</a>
				<a class="l5" href="http://www.ems.com.cn" title="EMS free shipping" target="_blank" rel="nofollow">EMS free shipping</a>
				<a class="l6" href="http://www.ups.com" title="UPS free shipping" target="_blank" rel="nofollow">UPS free shipping</a>
				<a class="l7" href="javascript:void(0)" title="paypal" rel="nofollow" onclick="javascript:window.open('https://www.paypal.com/verified/pal=paypal@milanoo.com','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');">paypal</a>
				<a class="l8" rel="nofollow" target="_blank" href="https://www.mcafeesecure.com/RatingVerify?ref=www.milanoo.com&lang=DE">mcafee secure</a>
				<a class="l9" href="https://sealinfo.verisign.com/splash?form_file=fdf/splash.fdf&dn=www.milanoo.com&lang=de" title="Verisign Secured" target="_blank" rel="nofollow">Verisign Secured</a>
				</div>
xxx;
			$html_result.='<p class="copy">'.printf(\LangPack::$items['footer_copyNoti'],date('Y')).\LangPack::$items['g_milahkco'].'</p>';
			break;
		case 'it-it':
		$html_result.='
				<div class="about">
				<a s_itt_ocupdate="true" href="http://www.milanoo.com/it/" target="_blank" rel="nofollow" >'.\LangPack::$items['footer_home'].'</a> | 
				<a href="http://www.milanoo.com/it/help/About-Milanoo--module-index-id-41.html#sid=41" rel="nofollow" target="_blank">'.\LangPack::$items['footer_aboutUs'].'</a> |   
				<a href="http://www.milanoo.com/it/seeall.html" target="_blank">'.\LangPack::$items['footer_siteMap'].'</a>   | 
				<a href="http://www.milanoo.com/de/help/index.html" rel="nofollow" target="_blank">'.\LangPack::$items['footer_contactUs'].'</a> | 
				<a href="http://www.milanoo.com/it/help/Privacy-Policy--module-index-id-72.html" rel="nofollow" target="_blank">'.\LangPack::$items['footer_privacyPolicy'].'</a> | 
				<a rel="nofollow" href="http://www.milanoo.com/it/help/Professional-AttentionProfessional-Care-module-index-id-89.html" target="_blank">'.\LangPack::$items['footer_attenCare'].'</a>
				</div>';
			$html_result.=<<<xxx
				<div class="link">
				<a class="l1" title="credit card payment" target="_blank" href="http://www.milanoo.com/it/help/Payment-Methods-module-index-id-19.html" rel="nofollow">credit card payment</a>
				<a class="l2" title="western union" target="_blank" href="http://www.westernunion.com/" rel="nofollow">western union</a>
				<a class="l3" href="http://www.DHL.com" title="DHL free shipping" target="_blank" rel="nofollow">DHL free shipping</a>
				<a class="l4" href="http://www.tnt.com" title="TNT free shipping" target="_blank" rel="nofollow">TNT free shipping</a>
				<a class="l5" href="http://www.ems.com.cn" title="EMS free shipping" target="_blank" rel="nofollow">EMS free shipping</a>
				<a class="l6" href="http://www.ups.com" title="UPS free shipping" target="_blank" rel="nofollow">UPS free shipping</a>
				<a class="l7" href="javascript:void(0)" title="paypal" rel="nofollow" onclick="javascript:window.open('https://www.paypal.com/verified/pal=paypal@milanoo.com','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');">paypal</a>
				<a class="l8" rel="nofollow" target="_blank" href="https://www.mcafeesecure.com/RatingVerify?ref=www.milanoo.com&lang=IT">mcafee secure</a>
				<a class="l9" href="https://sealinfo.verisign.com/splash?form_file=fdf/splash.fdf&dn=www.milanoo.com&lang=it" title="Verisign Secured" target="_blank" rel="nofollow">Verisign Secured</a>
				</div>
xxx;
			$html_result.='<p class="copy">'.printf(\LangPack::$items['footer_copyNoti'],date('Y')).\LangPack::$items['g_milahkco'].'</p>';
			break;
		case 'ru-ru':
		$html_result.='<div class="about">
				<a s_itt_ocupdate="true" href="http://www.milanoo.com/ru/" target="_blank" rel="nofollow" >'.\LangPack::$items['footer_home'].'</a> | 
				<a href="http://www.milanoo.com/ru/help/About-Milanoo--module-index-id-41.html#sid=41" rel="nofollow" target="_blank">'.\LangPack::$items['footer_aboutUs'].'</a> |   
				<a href="http://www.milanoo.com/ru/seeall.html" target="_blank">'.\LangPack::$items['footer_siteMap'].'</a>   | 
				<a href="http://www.milanoo.com/ru/help/index.html" rel="nofollow" target="_blank">'.\LangPack::$items['footer_contactUs'].'</a> | 
				<a href="http://www.milanoo.com/ru/help/Privacy-Policy--module-index-id-72.html" rel="nofollow" target="_blank">'.\LangPack::$items['footer_privacyPolicy'].'</a> | 
				<a rel="nofollow" href="http://www.milanoo.com/ru/help/Professional-AttentionProfessional-Care-module-index-id-89.html" target="_blank">'.\LangPack::$items['footer_attenCare'].'</a>
				</div>';
			$html_result.=<<<xxx
				<div class="link">
				<a class="l1" title="credit card payment" target="_blank" href="http://www.milanoo.com/ru/help/Payment-Methods-module-index-id-19.html" rel="nofollow">credit card payment</a>
				<a class="l2" title="western union" target="_blank" href="http://www.westernunion.com/" rel="nofollow">western union</a>
				<a class="l3" href="http://www.DHL.com" title="DHL free shipping" target="_blank" rel="nofollow">DHL free shipping</a>
				<a class="l4" href="http://www.tnt.com" title="TNT free shipping" target="_blank" rel="nofollow">TNT free shipping</a>
				<a class="l5" href="http://www.ems.com.cn" title="EMS free shipping" target="_blank" rel="nofollow">EMS free shipping</a>
				<a class="l6" href="http://www.ups.com" title="UPS free shipping" target="_blank" rel="nofollow">UPS free shipping</a>
				<a class="l7" href="javascript:void(0)" title="paypal" rel="nofollow" onclick="javascript:window.open('https://www.paypal.com/verified/pal=paypal@milanoo.com','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');">paypal</a>
				<a class="l8" rel="nofollow" target="_blank" href="https://www.mcafeesecure.com/RatingVerify?ref=www.milanoo.com">mcafee secure</a>
				<a class="l9" href="https://sealinfo.verisign.com/splash?form_file=fdf/splash.fdf&dn=www.milanoo.com&lang=en" title="Verisign Secured" target="_blank" rel="nofollow">Verisign Secured</a>
				</div>
xxx;
			$html_result.='<p class="copy">'.printf(\LangPack::$items['footer_copyNoti'],date('Y')).\LangPack::$items['g_milahkco'].'</p>';
			break;
		default:break;
	}
	return $html_result;
}
?>

	
	
	
	
	
	
	
	
	
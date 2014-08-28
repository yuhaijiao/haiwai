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
 * Purpose:  网页头部的seo信息
 *
 * @version 1.0.0
 * @author jianjun wu <wujianjun@milanoo.com>
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_html_feature_list($params, &$smarty)
{
	$html_result = '';
    $feature = new \Model\Promotion();
	$feature_list = $feature->getListFeature($params['num']);
	$html_result .= "<dl class=\"pro_list\">";
	
	if(count($feature_list['featureResults']) > 0){
		$i = count($feature_list['featureResults']);
		foreach ($feature_list['featureResults'] as $v){
			
			$activationTime = date('mdY',$v['activationTime']);
			switch (SELLER_LANG){
				case 'en-uk':
					$pre_lang='en';
					$code = 'EN_ZT'.$i.'_'.$activationTime;
				break;
				case 'ja-jp':
					$pre_lang='jp';
					$code = 'JP_ZT'.$i.'_'.$activationTime;
				break;
				case 'fr-fr':
					$pre_lang='fr';
					$code = 'FR_ZT'.$i.'_'.$activationTime;
				break;
				case 'de-ge':
					$pre_lang='de';
					$code = 'DE_ZT'.$i.'_'.$activationTime;
				break;
				case 'it-it':
					$pre_lang='it';
					$code = 'IT_ZT'.$i.'_'.$activationTime;
				break;
				case 'ru-ru':
					$pre_lang='ru';
					$code = 'RU_ZT'.$i.'_'.$activationTime;
				break;
				case 'es-sp':
					$pre_lang='es';
					$code = 'ES_ZT'.$i.'_'.$activationTime;
				break;
			}
			$label=$pre_lang.'_ft_'.$v['featureId'].'_'.$activationTime;
			$url = "?module=promotions&action=specials&id=".$v['featureId'];
			$html_result .= "<dd><a href='".rew::rewrite(array('url'=>$url,'isxs'=>'no')).'?intcmp='.$code."' title='".stripslashes($v['featureTitle'])."' onClick='javascript:". "_gaq.push(	[\"_trackEvent\",\"advertise_$pre_lang\",\"$code\",\"$label\"]);'><img src='".CDN_IMAGE_URL.'upload/feature/'.$v['logoImgUrl']."' /><h3>".stripslashes($v['featureTitle'])."</h3><p>".stripslashes($v['featureDesc'])."</p></a>";
			$i--;
		}
	}
	$html_result .= "</dl>";
    return $html_result;
}


?>
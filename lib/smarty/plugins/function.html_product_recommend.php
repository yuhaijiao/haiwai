<?php
/**
 * Smarty {html_product_recommend} plugin
 *
 * Type:     function
 * Name:     html_product_recommend
 * Purpose:  产品终端页商品推荐显示
 *
 * @version 1.0.0
 * @author Cheng Jun <cgjp123@163.com>
 * @param array
 * @param Smarty
 * @return string
 */
use Helper\ResponseUtil as Rewrite;
require_once 'modifier.number_format.php';
function smarty_function_html_product_recommend($params, &$smarty) {
	$productId = $params['productId'];
	$returnNum = $params['num'];
	if(!$productId) return false;
	//调用接口，获取数据
	$searchRecommendArray = array('productId'=>$productId,'returnNum'=>$returnNum);
	$mGetRecommend = new \Model\ItemOtherProducts();
	$recommend = $mGetRecommend->getReconmmend($searchRecommendArray);
	//print_r($recommend);
	//处理数据
	$html_result = '';
	if(!empty($recommend) && $recommend['code']==0){
		if(!empty($recommend['recommendProducts'])){
			$recommend['recommendProducts'] = Helper\String::strDosTrip($recommend['recommendProducts']);
			$html_result .= '<div class="fr re_goods"><h2 class="bg_title">'.\LangPack::$items['Recommendations'].'</h2>';
			$html_result .= '<ul class="lazyload">';
			foreach($recommend['recommendProducts'] as $val){
				$html_result .= '<li>';
				if(!empty($val) && is_array($val)){
					if(!empty($val ['promotionPrice'])){
						$price = $val ['promotionPrice'];
					}else{
						$price = $val ['productPrice'];
					}
					$html_result .= '<a href="'.Rewrite::rewrite(array('url'=>'?module=thing&action=item&id='.$val['productId'],'seo'=>$val['productName'],'isxs' => 'no')).'"><img src="' . CDN_UPLOAD_URL . 'image/default/mlianoo_blank.gif" alt="'.$val['productName'].'" original="'.CDN_UPLOAD_URL.'upen/m/'.$val['firstPictureUrl'].'" /></a>';
					$html_result .= '<h3><a href="'.Rewrite::rewrite(array('url'=>'?module=thing&action=item&id='.$val['productId'],'seo'=>$val['productName'],'isxs' => 'no')).'">'.$val['productName'].'</a></h3>'.Currency.smarty_modifier_number_format(\Lib\common\Language::priceByCurrency ( $price ));
				}
				$html_result .= '</li>';
			}
			$html_result .= '</ul>';
			$html_result .= '</div>';
		}
	}
	return $html_result;
}
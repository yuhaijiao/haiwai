<?php
/**
 * Smarty {html_product_historyview} plugin
 *
 * Type:     function
 * Name:     html_product_historyview
 * Purpose:  产品终端页商品浏览记录显示
 *
 * @version 1.0.0
 * @author Cheng Jun <cgjp123@163.com>
 * @param array
 * @param Smarty
 * @return string
 */
use Helper\ResponseUtil as Rewrite;
require_once 'modifier.number_format.php';
function smarty_function_html_product_historyview($params, &$smarty) {
	$productId = $params['productId'];
	$historyIds = $params['historyids'];
	$returnNum = $params['num'];
	$returnType = $params['returnType'];
	if(!$historyIds) return false;
	if(!$productId) return false;
	if(!$returnNum) $returnNum = 7;
	if(!$returnType) $returnType = 'history';
	//调用接口，获取数据
	$searchHistoryRecommendArray = array('productId'=>$productId,'recentHistoryPid'=>$historyIds,'returnRelatedNum'=>$returnNum);
	$mGetRecommend = new \Model\ItemOtherProducts();
	$historyRecommend = $mGetRecommend->getHistoryRecommend($searchHistoryRecommendArray);
	//处理数据
	$html_result = '';
	if($historyRecommend['code']==0){
		$html_result .= '<ul class="lazyload">';
		//历史记录商品信息
		if($returnType == 'history'){
			if(!empty($historyRecommend['recentHistoryProducts'])){
				$historyRecommend['recentHistoryProducts'] = Helper\String::strDosTrip($historyRecommend['recentHistoryProducts']);
				foreach($historyRecommend['recentHistoryProducts'] as $val){
					$html_result .= '<li>';
					if(!empty($val ['promotionPrice'])){
						$price = $val ['promotionPrice'];
					}else{
						$price = $val ['productPrice'];
					}
					$html_result .= '<a title="'.$val['productName'].'" href="'.Rewrite::rewrite(array('url'=>'?module=thing&action=item&id='.$val['productId'],'seo'=>$val['productName'],'isxs' => 'no')).'"><img alt="'.$val['productName'].'" src="' . CDN_UPLOAD_URL . 'image/default/mlianoo_blank.gif" original="'.CDN_UPLOAD_URL.'upen/50x70/c'.$val['firstPictureUrl'].'"></a>';
					$html_result .= ' <a title="'.$val['productName'].'" href="'.Rewrite::rewrite(array('url'=>'?module=thing&action=item&id='.$val['productId'],'seo'=>$val['productName'],'isxs' => 'no')).'">'.$val['productName'].'</a>';
					$html_result .= '</li>';
				}
			}
		}
		//历史记录相关商品
		if($returnType == 'historyRelate'){
			if(!empty($historyRecommend['historyRelatedProducts'])){
				$historyRecommend['historyRelatedProducts'] = Helper\String::strDosTrip($historyRecommend['historyRelatedProducts']);
				foreach($historyRecommend['historyRelatedProducts'] as $val){
					$html_result .= '<li>';
					if(!empty($val ['promotionPrice'])){
						$price = $val ['promotionPrice'];
					}else{
						$price = $val ['productPrice'];
					}
					$html_result .= '<a class="ep_rollelem_picBox" title="'.$val['productName'].'" href="'.Rewrite::rewrite(array('url'=>'?module=thing&action=item&id='.$val['productId'],'seo'=>$val['productName'],'isxs' => 'no')).'"><img alt="'.$val['productName'].'" src="' . CDN_UPLOAD_URL . 'image/default/mlianoo_blank.gif" original="'.CDN_UPLOAD_URL.'upen/100x135/c'.$val['firstPictureUrl'].'"></a>';
					$html_result .= ' <h3><a title="'.$val['productName'].'" href="'.Rewrite::rewrite(array('url'=>'?module=thing&action=item&id='.$val['productId'],'seo'=>$val['productName'],'isxs' => 'no')).'">'.$val['productName'].'</a></h3>'.Currency.smarty_modifier_number_format(\Lib\common\Language::priceByCurrency ( $price ));
					$html_result .= '</li>';
				}
			}
		}
		$html_result .= '</ul>';
	}
	return $html_result;
}
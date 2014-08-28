<?php
use helper\ResponseUtil as Rewrite;
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {html_topselling} plugin
 *
 * Type:     function
 * Name:     html_topselling
 * Purpose:  列表页topselling
 *
 * @version 1.0.0
 * @author  Jerry Yang<yang.tao.php@gmail.com>
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_html_topselling($params, &$smarty)
{
	$params_all = Helper\RequestUtil::getParams();		
	$cid = $params_all->class;		
	if(!isset($smarty->_tpl_vars['result'])){		
		$mProductList = new \Model\Product ();
		$search_arr = array(
			'pcs.categoryId' => $cid,
			'pcs.returnTopSellingNum' => 10,
		);
		$result = $mProductList->getProductList($search_arr);
	}else{
		$result = $smarty->_tpl_vars['result'];
	}

	$html_result  	 = '';
	if($result['code']==0) {
		if(!empty($result['topSellingResults'])){
			$html_result  .= '<div id="topsell"><h4 class="tops">'.\LangPack::$items['left_top_selling'].'</h4><ol>';
			if(SELLER_LANG=='en-uk' || SELLER_LANG=='fr-fr'){
				foreach($result['topSellingResults'] as $value){
				$pName = stripcslashes($value['productName']);
				$html_result  .="<li><a href='".Rewrite::rewrite(array('url'=>'?module=thing&action=item&id='.$value['productId'],'seo'=>$pName,'isxs'=>'no'))."' title='".$pName."'><img src='".CDN_UPLAN_URL.'upen/m/'.$value['pictureUrl']."' alt='".$pName."' /></a>".Currency.' '.\Lib\common\Language::priceByCurrency($value['productsPrice'])."</li>";
				}
			}else{
				foreach($result['topSellingResults'] as $value){
				$pName = stripcslashes($value['productName']);
				$html_result  .="<li><a href='".Rewrite::rewrite(array('url'=>'?module=thing&action=item&id='.$value['productId'],'seo'=>$pName,'isxs'=>'no'))."' title='".$pName."'><img src='".CDN_UPLAN_URL.'upen/m/'.$value['pictureUrl']."' alt='".$pName."' /></a>".Currency.' '.\Lib\common\Language::priceByCurrency($value['productsPrice'])."</li>";
				}
			}
			$html_result  .='<br class="cl"/></ol></div>';			
		}
	}else{
		die($result['msg']);
	}
	//die(strlen($html_result));
    return $html_result;
}
?>
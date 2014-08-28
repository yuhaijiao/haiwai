<?php
/**
 * Smarty {html_product_related} plugin
 *
 * Type:     function
 * Name:     html_product_related
 * Purpose:  产品终端页关联商品显示
 *
 * @version 1.0.0
 * @author Cheng Jun <cgjp123@163.com>
 * @param array
 * @param Smarty
 * @return string
 */

function smarty_function_html_product_related($params, &$smarty) {
	$productId = $params['productId'];
	if(!$productId) return false;
	//调用接口，获取数据
	
	
	//处理数据
	
	
	return $html_result;
}
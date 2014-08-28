<?php
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
function smarty_function_html_css($params, &$smarty)
{
    $html_result = '';
 	$params_all = Helper\RequestUtil::getParams();
 	$module = $params_all->module;
 	$action = $params_all->action;
	switch ($module){
		case 'index':
			$html_result .= '<link rel="stylesheet" type="text/css" href="'.CDN_CSS_URL.'homepage.css?r='.REVISION.'"/>';
		break;
		case 'promotions':
			
		case 'thing':
			if($action == 'item'){
				$html_result .= '<link rel="stylesheet" type="text/css" href="'.CDN_CSS_URL.'product.css?r='.REVISION.'"/>';
				break;
			}
			$html_result .= '<link rel="stylesheet" type="text/css" href="'.CDN_CSS_URL.'list.css?r='.REVISION.'"/>';
		break;	
		case 'producttags':
			$html_result .= '<link rel="stylesheet" type="text/css" href="'.CDN_CSS_URL.'list.css?r='.REVISION.'"/>';
			$html_result .= '<link rel="stylesheet" type="text/css" href="'.CDN_CSS_URL.'tag.css?r='.REVISION.'"/>';
		break;
	}
	return $html_result;
}
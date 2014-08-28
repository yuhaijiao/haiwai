<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {-notice-} plugin
 *
 * Type:     function
 * Name:     notice
 * Purpose:  网站提示信息统一方法
 *
 * @version 1.0.0
 * @author 成俊 <chengjun@milanoo.com>
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_notice($params, &$smarty)
{
	$html = '';
	$staticUrl = ADMIN_URL.'static/';
	if(!empty($params['msg'])){
		switch ($params['type']){
			case 'attention' :
				$class = 'attention';
			break;
			case 'information' :
				$class = 'information';
			break;
			case 'success' :
				$class = 'success';
			break;
			case 'error' :
				$class = 'error';
			break;
		}
	}
	$html .= <<<NOTICE
			<div class="notification {$class} png_bg">
			<a href="#" class="close"><img src="{$staticUrl}image/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					{$params['msg']}
				</div>
			</div>
NOTICE;
	return $html;
}
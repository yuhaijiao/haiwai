<?php
/**
 * 高亮显示代码插件
 * @param unknown $params
 * @param unknown $smarty
 */
function smarty_function_code($params, &$smarty)
{
	$html = '';
	if(!empty($params['code'])){
		if(strpos($params['code'],'<?php')!==false){
			$html .= highlight_string($params['code'],true);
		}else{
			$resetCode = '<?php';
			$resetCode .= $params['code'];
			$resetCode .= '?>';
			$html .= highlight_string($resetCode,true);
		}
	}
	return $html;
}
<?php
namespace Module\Ajax;
/**
* AJAX获取redmine信息 
* @author chengjun <chengjun@milanoo.com>
*/
class GetRedmine extends \lib\Application{
	public function run(){
		$param = \Lib\Helper\RequestUnit::getParams();
		$id = isset($param->params['id']) ? $param->params['id'] : '';
		if(!empty($id)){
			$redmineM = new \Lib\Helper\GetRedmineInfo();
			$redmineInfo = $redmineM->getInfo($id);
			if(!empty($redmineInfo)){
				echo $redmineInfo['title'];
			}
		}
		exit;
	}
}
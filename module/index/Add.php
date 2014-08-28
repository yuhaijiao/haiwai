<?php
namespace Module\Index;
/**
* 添加文件
* @author oliver <cgjp123@163.com>
*/
class Add extends \lib\Application{

	public function run(){
		$memberId = \Lib\Helper\CheckLogin::getMemberId();
		$tpl = \Lib\Template::getSmarty();
		$param = \Lib\Helper\RequestUnit::getParams();
		$fileM = new \Model\IndexModel();

		$id = isset($param->params['id']) ? $param->params['id'] : '';
		$formSubmit = isset($param->formSubmit) ? $param->formSubmit : '';
		if($formSubmit){
			$hashform = isset($param->hashform) ? $param->hashform : '';
			if($hashform && $hashform==$_SESSION['hashform']){
				$data = array();
				$data['redmineId'] = isset($param->redmineId) ? intval($param->redmineId) : '';
				$data['redmineTitle'] = isset($param->redmineTitle) ? $param->redmineTitle : '';
				$data['desc'] = isset($param->desc) ? $param->desc : '';
				//$data['imgfile'] = isset($param->imgfile) ? $param->imgfile : '';
				//$data['psdfile'] = isset($param->psdfile) ? $param->psdfile : '';
				$data['psdTips'] = isset($param->psdTips) ? $param->psdTips : '';
				//$data['themefile'] = isset($param->themefile) ? $param->themefile : '';
				$data['themeTips'] = isset($param->themeTips) ? $param->themeTips : '';
				//$data['otherfile'] = isset($param->otherfile) ? $param->otherfile : '';
				$data['fileTips'] = isset($param->fileTips) ? $param->fileTips : '';
				if(!empty($_FILE)){
					if(!empty($_FILE['imgfile'])){
						
					}
				}
				if($id) $data['id'] = $id;


				$fileM->addFile($data);
			}else{
				$this->alert_forward('请不要重复提交','',1);
			}
			
		}
		//add
		$hashform = hash('sha256', time().rand(0, 1000));
		$_SESSION['hashform'] = $hashform;
		$tpl->assign('hashform',$hashform);
		$tpl->display('add.htm');
	}
	
}
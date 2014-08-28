<?php
namespace Module\help;
/**
* 米兰网会议管理制度
* @author 
*/
class rule extends \Lib\Application{

	public function run(){
		$memberId = \Lib\Helper\CheckLogin::getMemberId();
		$tpl = \Lib\Template::getSmarty();
		$meets = new \Model\meetingModel();
		$meetingConfig = $meets->getMeetingConfig();
		$tpl->assign('meetingRule',$meetingConfig['rule']);

		$tpl->display('helpRule.htm');
	}
	
}
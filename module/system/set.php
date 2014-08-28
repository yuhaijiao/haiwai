<?php
namespace Module\System;
/**
* 修改系统配置
* @author zhf
*/
class set extends \lib\Application{

	public function run(){
		$memberId = \Lib\Helper\CheckLogin::getMemberId();
		$tpl = \Lib\Template::getSmarty();
		$param = \Lib\Helper\RequestUnit::getParams();
		$memberIsadmin=isset($tpl->_tpl_vars['memberIsadmin'])?$tpl->_tpl_vars['memberIsadmin']:'';
		$meets = new \Model\meetingModel();

		if ($_POST) {
			if (!$memberIsadmin) {
				$this->alert_forward('sorry,你现在还不可以修改这个内容哈','',1);exit;
			}
			$data = array();
			preg_match('#\b([0-1]?[0-9]|[2][0-3]):[0-5][0-9]:[0-5][0-9]\b#',$param->startbooktime,$start);
			preg_match('#\b([0-1]?[0-9]|[2][0-3]):[0-5][0-9]:[0-5][0-9]\b#',$param->endbooktime,$end);
			if ( !$start || !$end || $start[1]>$end[1] ) {
				$this->alert_forward('sorry,你给的时间不是有效的时间','',1);exit;
			}
			$data['startbooktime'] = $start[0];
			$data['endbooktime'] = $end[0];
			$data['debooktime'] = intval($param->debooktime);
			$data['interval'] = intval($param->interval);
			$data['ruletitle'] = strval($param->ruletitle);
			$data['aheadtime'] = intval($param->aheadtime);
			// $data['activation'] = strval($param->activation);
			$data['rule'] = $param->rule;
			if ($data['debooktime']>0 && $data['aheadtime']>0 && $data['interval']>0) {
				$meets->updateMeetingConfig($data);
				$this->alert_forward('提交成功',ROOT_URL,1);exit;
			}else{
				$this->alert_forward('sorry,请输入有效的"预订提前的时间","退订提前的时间","同一会议室两场会议间隔时间"','',1);exit;
			}
		}

		$sysConfig = $meets->getMeetingConfig();
		$tpl->assign('sysConfig',$sysConfig);
		
		$tpl->display('systemSet.htm');
	}
	
}
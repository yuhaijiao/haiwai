<?php
namespace Module\Meeting;
class edit extends \Lib\Application {
	public function run(){
		$memberId = \Lib\Helper\CheckLogin::getMemberId();
		$tpl = \Lib\Template::getSmarty();
		$param = \Lib\Helper\RequestUnit::getParams();
		$meets = new \Model\meetingModel();
		$isBeingUsed=$unableEdit=$isEdit=$bookid='0';
		$isDebook=$bookUser='';
		$tomorrowYMD=date("Y-m-d",time()+3600*24 );
		if ( isset($param->bookid) && strval($param->bookid)>0 ) {
			 $bookid=$param->bookid;
			 $isEdit='1';
			//指定预订id的预订信息
			$bookInfo = $meets->getBookInfoById($bookid);
			$bookInfo['meetingstarttimeYMD']=date("Y-m-d",$bookInfo['meetingstarttime']);
			$bookInfo['meetingstarttimeH']=date("H",$bookInfo['meetingstarttime']);
			$bookInfo['meetingstarttimeI']=date("i",$bookInfo['meetingstarttime']);
			$bookInfo['meetingendtimeYMD']=date("Y-m-d",$bookInfo['meetingendtime']);
			$bookInfo['meetingendtimeH']=date("H",$bookInfo['meetingendtime']);
			$bookInfo['meetingendtimeI']=date("i",$bookInfo['meetingendtime']);
			$bookInfo['meetingaddress']=explode(",", $bookInfo['meetingaddress']);
			$bookInfo['invitee']=explode(",", $bookInfo['invitee']);
			$tpl->assign('bookInfo',$bookInfo);
			$unableEdit = $bookInfo['meetingstarttime']<strtotime($tomorrowYMD)?'1':'0';
			$bookUser = $bookInfo['bookuser']?$bookInfo['bookuser']:'';
			$isDebook = $bookInfo['meetingdebook'];
			$tpl->assign('unableEdit',$unableEdit);
			$tpl->assign('isEdit',$isEdit);
		}
		//可邀请人处理
		$allSysUser = $meets->getSysUsers();
		$systemUser = array();
		foreach ($allSysUser as $key => $value) {
			if ($value['pinyin']!='') {
				$systemUser['chinese'][]=$value;
			}else{
				$systemUser['engOther'][]=$value;
			}
		}
		$categoryLetters=array();
		foreach ($systemUser as $key => $value) {
			foreach ($value as $k => $v) {
				$firstLetter="";
				$firstLetter= $key=='chinese'?strtoupper(substr(trim($v['pinyin']),0,1)):strtoupper(substr(trim($v['username']),0,1));
				if(ord($firstLetter)>=48 && ord($firstLetter)<=57 ){
					$categoryLetters[$key]['_'][]=$v;
				}else{
					$categoryLetters[$key][$firstLetter][]=$v;
				}
			}
		}
		foreach ($categoryLetters as $key => $value) {
			foreach ($value as $ke => $valu) {
				ksort($categoryLetters[$key]);
			}
		}
		// echo'<pre>';print_r($categoryLetters);die;
		$tpl->assign('allSysUser',$categoryLetters);

		$memberIsadmin=isset($tpl->_tpl_vars['memberIsadmin'])?$tpl->_tpl_vars['memberIsadmin']:'';
		$memberName=$tpl->_tpl_vars['memberName'];
		
		//获取会议室信息
		$meet = new \Model\Meeting();
		$meetingAddressInfo = $meet->getMeetingInformation();
		$tpl->assign('meetingAddressInfo',$meetingAddressInfo);

		$meetingConfig = $meets->getMeetingConfig();
		$tpl->assign('meetingConfig',$meetingConfig);

		if ($_POST) {
			if ($isDebook) {
				$this->alert_forward('sorry,已取消的会议预订不可以修改了','',1);exit;
			}
			if ($unableEdit) {
				$this->alert_forward('sorry,明天以前的会议预订不可以修改了','',1);exit;
			}
			$data = array();
			if ($bookid) {
				$data['bookid'] = $bookid;
			}
			$getStartTimeHI = $param->StartTime_H.":".$param->StartTime_I.":00";
			$getEndTimeHI = $param->endTime_H.":".$param->endTime_I.":00";
			preg_match('#\b([0-1]?[0-9]|[2][0-3]):[0-5][0-9]:[0-5][0-9]\b#',$getStartTimeHI,$start);
			preg_match('#\b([0-1]?[0-9]|[2][0-3]):[0-5][0-9]:[0-5][0-9]\b#',$getEndTimeHI,$end);
			if ( !$start || !$end || $start[1]>$end[1] ) {
				$this->alert_forward('sorry,你给的时间不是有效的时间','',1);exit;
			}
			$meetAdd = $param->meetingaddress;
			$startTime = $param->StartTime;
			$endTime = $param->endTime;
			$meetingStartTime = strtotime($startTime." ".$getStartTimeHI);
			$meetingEndTime = strtotime($endTime." ".$getEndTimeHI);

			if ( $meetingStartTime < strtotime(date("Y-m-d",time()+$meetingConfig['aheadtime']*3600*24)) && $meetingEndTime<strtotime(date("Y-m-d",time()+$meetingConfig['aheadtime']*3600*24)) ) {
				$this->alert_forward("sorry,你修改的会议开始、结束日期没有提前$meetingConfig[aheadtime]天",'',1);exit;
			}			
			if ( strtotime($getStartTimeHI) > strtotime($getEndTimeHI) || strtotime($getStartTimeHI) < strtotime($meetingConfig['startbooktime']) || strtotime($getEndTimeHI) > strtotime($meetingConfig['endbooktime']) ) {
				$this->alert_forward('sorry,你给的会议开始、结束时间不在有效范围内','',1);exit;
			}
			if ( $startTime != $endTime ) {
				$this->alert_forward('sorry,你给的会议开始、结束日期不在同一天','',1);exit;
			}
			
			$queryStartTime = strtotime( date("Y-m-d",strtotime($startTime)) );
			$queryEndTime = strtotime( date("Y-m-d",strtotime($startTime)+3600*24) );
			$dayBookInfo = $meets->getDayBookInfo($queryStartTime,$queryEndTime);
			$interval = $meetingConfig['interval'];
			$intervals = $interval*60;
			 // var_dump($dayBookInfo);die;
			if ($dayBookInfo) {foreach ($dayBookInfo as $key => $value) {
				//只与不是当前预订信息 和 没有取消的其它预订作比较
				if ($value['bookid']!= $bookid && !$value['meetingdebook']) {
					if ( $meetAdd=='EbayAmazon' && ( $value['meetingaddress']=='Ebay'|| $value['meetingaddress']=='Amazon') ) {
						if ( $meetingStartTime > $value['meetingstarttime'] && $meetingStartTime < $value['meetingendtime'] || $meetingEndTime > $value['meetingstarttime'] && $meetingEndTime < $value['meetingendtime'] || $meetingStartTime < $value['meetingstarttime'] && $meetingEndTime > $value['meetingendtime'] ) {
							$this->alert_forward("sorry,会议室{$meetAdd}在你选择的会议时间段内,已经被其它同学通过选择Ebay或者Amazon占用了",'',1);exit;	
						}
						if ( $meetingStartTime > $value['meetingstarttime']-$intervals && $meetingStartTime < $value['meetingendtime']+$intervals || $meetingEndTime > $value['meetingstarttime']-$intervals && $meetingEndTime < $value['meetingendtime']+$intervals ) {
							
							$this->alert_forward("sorry,你设置的会议在相应会议室{$meetAdd}中，与另一场会议间隔不足{$interval}分钟",'',1);exit;		
						}
					}elseif ( ($meetAdd=='Ebay' || $meetAdd=='Amazon') && $value['meetingaddress']=='EbayAmazon' ) {
						if ( $meetingStartTime > $value['meetingstarttime'] && $meetingStartTime < $value['meetingendtime'] || $meetingEndTime > $value['meetingstarttime'] && $meetingEndTime < $value['meetingendtime'] || $meetingStartTime < $value['meetingstarttime'] && $meetingEndTime > $value['meetingendtime']) {
							$this->alert_forward("sorry,会议室{$meetAdd}在你选择的会议时间段内,已经被其它同学通过选择EbayAmazon占用了",'',1);exit;	
						}
						if ( $meetingStartTime > $value['meetingstarttime']-$intervals && $meetingStartTime < $value['meetingendtime']+$intervals || $meetingEndTime > $value['meetingstarttime']-$intervals && $meetingEndTime < $value['meetingendtime']+$intervals ) {
							
							$this->alert_forward("sorry,你设置的会议在相应会议室{$meetAdd}中，与另一场会议间隔不足{$interval}分钟",'',1);exit;		
						}
					}elseif($meetAdd==$value['meetingaddress']){
						if ( $meetingStartTime > $value['meetingstarttime'] && $meetingStartTime < $value['meetingendtime'] || $meetingEndTime > $value['meetingstarttime'] && $meetingEndTime < $value['meetingendtime'] || $meetingStartTime < $value['meetingstarttime'] && $meetingEndTime > $value['meetingendtime']) {
							$this->alert_forward("sorry,会议室{$meetAdd}在你选择的会议时间段内已经被占用了",'',1);exit;		
						}
						if ( $meetingStartTime > $value['meetingstarttime']-$intervals && $meetingStartTime < $value['meetingendtime']+$intervals || $meetingEndTime > $value['meetingstarttime']-$intervals && $meetingEndTime < $value['meetingendtime']+$intervals ) {
							
							$this->alert_forward("sorry,你设置的会议在相应会议室{$meetAdd}中，与另一场会议间隔不足{$interval}分钟",'',1);exit;		
						}
					}
				}
			}}

			$data['bookuser'] = (isset($bookUser)&&$bookUser!="")?$bookUser:$memberName;
			$data['meetingname'] = $param->meetingname;
			$data['meetingintro'] = $param->meetingintro;
			$data['meetingaddress'] = $meetAdd;
			$data['booktime'] = time();
			$data['meetingstarttime'] = $meetingStartTime;
			$data['meetingendtime'] = $meetingEndTime;
			$invit = $mail = array();
			$invitee = isset($param->invitee)?$param->invitee:'';
			for ($i=0; $i <count($invitee) ; $i++) { 
				$getSysUserById = $meets->getSysUserById($invitee[$i]);
				$invit[] = $getSysUserById['username'];
				$mail[] = $getSysUserById['email'];
			}
			$data['invitee'] = isset($param->invitee)?implode(",", $param->invitee):'';
			$data['extralist'] = $param->extralist;			

			//准备邮件
			$mailArray=array();
			$mailArray['theme'] = 'invite.htm';
			// $mailArray['mail'] = '446149468@qq.com';
			$mailArray['mail'] = isset($mail)?implode(";", $mail):'';
			$mailArray['data'] = $data;
			$mailArray['emailtitle'] = 'Milanoo '.$data['meetingname'].' 会议邀请';
			$sendeMail = new \Lib\Helper\SendMail();
			//执行修改或增加 并且发送邮件
			if (($bookid && ($bookUser==$memberName || $memberIsadmin) ) || (!$bookid && $memberName)) {
				$rs = $meets->modifyBookinfo($data);//数据提交
				$sendStatus = $sendeMail->sendmail($mailArray);//发送邮件
				// $sendStatus = 1;
				if($rs && $sendStatus){
					$this->alert_forward('提交成功,邮件发送成功！',ROOT_URL,1);exit;
				}
			}else{
				$this->alert_forward("sorry,你不是管理员，也不是会议申请者，无权修改当前会议预订信息",'',1);exit;
			}
		}
		$tpl->assign('tomorrowYMD',$tomorrowYMD);
		$tpl->display('meetingEdit.htm');
	}
}

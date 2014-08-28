<?php
namespace Module\Member;

/**
 * 
 * 个人中心
 * @author zhf
 *
 */
class Index extends \lib\Application{
	public function run(){
		$memberId = \Lib\Helper\CheckLogin::getMemberId();
		$tpl = \Lib\Template::getSmarty();
		$param = \Lib\Helper\RequestUnit::getParams();
		$meets = new \Model\meetingModel();
		$meetLeave = new \Model\Information();
		
		$day=strtotime( date("Y-m-d",time()) );
		$preDay=strtotime( date("Y-m-d",time()-3600*24 ) );
		$nextDay=strtotime( date("Y-m-d",time()+3600*24 ) );
		$memberIsadmin=isset($tpl->_tpl_vars['memberIsadmin'])?$tpl->_tpl_vars['memberIsadmin']:'';
		$memberName=$tpl->_tpl_vars['memberName'];
		
		if ($_POST) {
			$bookId=intval(isset($param->bookid)?$param->bookid:"");
			$leaveReason=strval(isset($param->leaveReason)?$param->leaveReason:"");
			$bookInfo = $meets->getBookInfoById($bookId);
			$forward = ROOT_URL.str_replace('/','',$_SERVER['REQUEST_URI']);
			if ( $bookId!=''&& $leaveReason=="") {// 用户退订
				if ($bookInfo['meetingstarttime']>$nextDay) {
					if ($bookInfo['bookuser']==$memberName && $bookInfo['isagree'] !=1 ) {
						$meets->applyDebook($bookId);
						$msg = array(
								'error_status'=>0,
								'forward'=>$forward
							);
						echo json_encode($msg);
						exit();
					}else{
						$msg = array(
							'error_status'=>1,
							'msg'=>'sorry,不能退订通过审核的会议预订',
							'forward'=>$forward
						);
					echo json_encode($msg);
					exit();
					}
				}else{
					$msg = array(
							'error_status'=>2,
							'msg'=>'sorry,不能退订明天以前会议预订',
							'forward'=>$forward
						);
					echo json_encode($msg);
					exit();
				}
			}elseif( $bookId!=''&& $leaveReason!=""){
				$data=array();
				$data['bookId']=$bookId;
				$data['leaveReason']=$leaveReason;
				$data['userId']=$_SESSION[SESSION_PREFIX.'memberId'];
				$invite = isset($bookInfo['invitee'])?explode(",",$bookInfo['invitee']):'';
				for ($i=0; $i <count($invite) ; $i++) {
					if ($invite[$i] == $data['userId'] && $bookInfo['meetingstarttime']>$nextDay) {
						if (!$meetLeave->isSetLeaveInfo($data)) {
							$meetLeave->leaveMeeting($data);
							$msg = array(
								'error_status'=>0,
								'forward'=>$forward
							);
							echo json_encode($msg);
							exit();
						}else{
							$msg = array(
								'error_status'=>1,
								'msg'=>'sorry,已经请过假了啦',
								'forward'=>$forward
							);
							echo json_encode($msg);
							exit();
						}
					}
				}
				$msg = array(
					'error_status'=>2,
					'msg'=>'sorry,不能给别人请假or不能对明天以前的会议请假的哈',
					'forward'=>$forward
				);
				echo json_encode($msg);
				exit();
			}
		}
		//列表按日期切换
		$getDate = isset($param->date)&&$param->date?$param->date:'';
		if ($getDate!=''&& preg_match('#((((1[6-9]|[2-9]\d)\d{2})-(0?[13578]|1[02])-(0?[1-9]|[12]\d|3[01]))|(((1[6-9]|[2-9]\d)\d{2})-(0?[13456789]|1[012])-(0?[1-9]|[12]\d|30))|(((1[6-9]|[2-9]\d)\d{2})-0?2-(0?[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))-0?2-29-))#', $getDate)) {
			$day = strtotime($getDate);
			$preDay = strtotime($getDate)-3600*24;
			$nextDay = strtotime($getDate)+3600*24 ;
		}	
		$dayBookInfo = $meets->getDayBookInfo($day,$nextDay);
		if ($dayBookInfo) {
			foreach ($dayBookInfo as $key => $value) {
				$dayBookInfo[$key]['meetingstarttime']=date("H:i",$value['meetingstarttime']);
				$dayBookInfo[$key]['meetingendtime']=date("H:i",$value['meetingendtime']);
				$dayBookInfo[$key]['extralist']=$value['extralist']?$value['extralist']:'没有';
				$dayBookInfo[$key]['isagreeCN']=$value['isagree']?$value['isagree']==1?'通过':'未通过':'等待审核';
				$dayBookInfo[$key]['inviteenum']=count(explode(",",$value['invitee']));

				$invit = array();
				$invite = isset($value['invitee'])?explode(",",$value['invitee']):'';
				for ($i=0; $i <count($invite) ; $i++) { 
					$invits = $meets->getSysUserById($invite[$i]);
					$invit[] = $invits['username'];
				}
				$dayBookInfo[$key]['inviteeCN']=implode(',', $invit);
				$dayBookInfo[$key]['meetingintro']=preg_replace('#</?(\w+) ?([^<>])*>#', '', $dayBookInfo[$key]['meetingintro']);
				$ids[]= $value['bookid'];
			}
		}
		$myBooks=$inviteed=array();
		//我预订的会议
		foreach ($dayBookInfo as $key => $value) {
			if ( $value['bookuser']==$memberName ) {
				$myBooks[] = $value;
			}
		}
		//我被邀请的会议
		foreach ($dayBookInfo as $key => $value) {
			$invite = isset($value['invitee'])?explode(",",$value['invitee']):'';
				for ($i=0; $i <count($invite) ; $i++) {
					if ($invite[$i] == $_SESSION[SESSION_PREFIX.'memberId'] ) {
						$inviteed[]=$value;
					}
				}
		}

		$data=array();		
		$data['userId']=$_SESSION[SESSION_PREFIX.'memberId'];
		foreach ($inviteed as $key => $value) {
				$data['bookId']=$value['bookid'];
				if ($meetLeave->isSetLeaveInfo($data)) {
					$inviteed[$key]['isLeave']=1;//已请假
				}else{
					$inviteed[$key]['isLeave']=0;//可以请假
				}
		}
		if (isset($ids) && $ids!='') {
			$ids=implode(',', $ids);
			$tpl->assign('ids',$ids.',0');
		}

		$meetingConfig = $meets->getMeetingConfig();
		$tpl->assign('ruleTitle',isset($meetingConfig['ruletitle'])?$meetingConfig['ruletitle']:"米兰网会议管理制度");

		$requestUrl = "index.php?module=member&action=index";
		$day=date("Y-m-d",$day);
		$preDay=$requestUrl.'&date='.date("Y-m-d",$preDay);
		$nextDay=$requestUrl.'&date='.date("Y-m-d",$nextDay);
		$tpl->assign('memberIsadmin',$memberIsadmin);
		$tpl->assign('memberName',$memberName);
		$tpl->assign('day',$day);
		$tpl->assign('preDay',$preDay);
		$tpl->assign('nextDay',$nextDay);
		$tpl->assign('myBooks',$myBooks);
		$tpl->assign('inviteed',$inviteed);
		$tpl->assign('RequestUrl',str_replace('/','',$_SERVER['REQUEST_URI']));
		
		$tpl->display('memberIndex.htm');
	}
}
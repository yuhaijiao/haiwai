<?php
namespace Module\Index;

/**
 * 
 * 首页
 * @author zhf
 *
 */
class Index extends \lib\Application{
	public function run(){
		$memberId = \Lib\Helper\CheckLogin::getMemberId();
		$tpl = \Lib\Template::getSmarty();
		$param = \Lib\Helper\RequestUnit::getParams();
		$meets = new \Model\meetingModel();
		
		$day=strtotime( date("Y-m-d",time()) );
		$preDay=strtotime( date("Y-m-d",time()-3600*24 ) );
		$nextDay=strtotime( date("Y-m-d",time()+3600*24 ) );
		$memberIsadmin=isset($tpl->_tpl_vars['memberIsadmin'])?$tpl->_tpl_vars['memberIsadmin']:'';
		$memberName=$tpl->_tpl_vars['memberName'];
		
		if ($_POST) {
			$isAgree=intval(isset($param->isagree)&&$param->isagree?$param->isagree:'');
			$bookId=intval($param->bookid);
			$bookInfo = $meets->getBookInfoById($bookId);
			$forward = ROOT_URL.str_replace('/','',$_SERVER['REQUEST_URI']);
			if ($isAgree!='' && $bookId!='' && $bookInfo!='') {//行政管理员审核
				if($bookInfo['meetingdebook']){
					$msg = array(
							'error_status'=>11,
							'msg'=>'sorry,不能审核已经退订会议预订',
							'forward'=>$forward
						);
					echo json_encode($msg);
					exit();
				}elseif ($bookInfo['meetingstarttime']>$nextDay) {				
					if ($memberIsadmin) {
						$meets->isAgreeTheApply($isAgree,$bookId);					
						$msg = array(
								'error_status'=>10,
								'forward'=>$forward
							);
						echo json_encode($msg);
						exit();
					}
				}else{
					$msg = array(
							'error_status'=>12,
							'msg'=>'sorry,不能审核明天以前的会议预订',
							'forward'=>$forward
						);
					echo json_encode($msg);
					exit();
				}
			}elseif ($isAgree=='' && $bookId!='') {// 用户退订
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
				$dayBookInfo[$key]['invitee']=implode(',', $invit);
				$dayBookInfo[$key]['meetingintro']=preg_replace('#</?(\w+) ?([^<>])*>#', '', $dayBookInfo[$key]['meetingintro']);
				$ids[]= $value['bookid'];
			}
		}
		if (isset($ids) && $ids!='') {
			$ids=implode(',', $ids);
			$tpl->assign('ids',$ids.',0');
		}

		$meetingConfig = $meets->getMeetingConfig();
		$tpl->assign('ruleTitle',isset($meetingConfig['ruletitle'])?$meetingConfig['ruletitle']:"米兰网会议管理制度");

		$day=date("Y-m-d",$day);
		$preDay='?date='.date("Y-m-d",$preDay);
		$nextDay='?date='.date("Y-m-d",$nextDay);
		$tpl->assign('memberIsadmin',$memberIsadmin);
		$tpl->assign('memberName',$memberName);
		$tpl->assign('day',$day);
		$tpl->assign('preDay',$preDay);
		$tpl->assign('nextDay',$nextDay);
		$tpl->assign('dayBookInfo',$dayBookInfo);
		$tpl->assign('RequestUrl',str_replace('/','',$_SERVER['REQUEST_URI']));
		
		$tpl->display('index.htm');
	}
}
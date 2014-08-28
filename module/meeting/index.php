<?php
namespace Module\Meeting;
class index extends \Lib\Application {
	public function run(){
		$memberId = \Lib\Helper\CheckLogin::getMemberId();
		$tpl = \Lib\Template::getSmarty();
		$param = \Lib\Helper\RequestUnit::getParams();
		$meet = new \Model\Meeting();
		//获取页面提交的数据
		if (isset($_POST['meet']) && $_POST['meet'] ) {
			$newmeet = $_POST['meet'];
			$newmeet = explode('/',$newmeet);
			$newMeetInformation = array();
			//重组数据
			foreach ($newmeet as $key=>$value){
				$newmeet[$key] = explode('=',$value);
			}
			foreach ($newmeet as $k=>$v){
				$key = $v['0'];
				$value = $v['1'];
				$newMeetInformation[$key] = $value;
			}
			$newMeetInformation['addressaddtime'] = time();//获取当前时间
			$newMeeting = $meet->addMeet($newMeetInformation);
			echo $newMeeting;die;
		}
		//删除
		if(isset($_GET['id']) && $_GET['id']){
			$meetid = $_GET['id'];
			$row = $meet->deleteMeeting($meetid);
		} 
		//修改信息
		if(isset($_GET['mId']) && $_GET['mId']){
			$times = time();
			$editM = array(
					'id' => $_GET['mId'],
					'meetingaddress' => $_GET['mName'],
					'addressaddtime' => $times,
					'isenabled' => $_GET['mUse'], 
					'galleryful' => $_GET['nNumber'], 
					'haveppt' => $_GET['mPpt'], 
					'haveblackbord' => $_GET['mBlack'],
			);
			$newMeeting = $meet->addMeet($editM);
// 			var_dump($editM);die;
		}
		//获取会议室信息
		$meeting = $meet->getMeetingInformation();
// 		print_r($meeting);die;
		$countNum = count($meeting);
		$tpl->assign('countNum',$countNum);
		$tpl->assign('meetingInformation',$meeting);
		
 		
		$tpl->display('meeting.htm');
	}
}

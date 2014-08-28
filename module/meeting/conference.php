<?php
namespace Module\Meeting;
class conference extends \Lib\Application {
	public function run(){
		$memberId = \Lib\Helper\CheckLogin::getMemberId();
		$tpl = \Lib\Template::getSmarty();
		$param = \Lib\Helper\RequestUnit::getParams();
		$meet = new \Model\Information();
		
		$bookid = $_GET['id'];
		//初始化人员数据
		if(isset($bookid) && $bookid != ''){
			$tpl->assign('bookid',$bookid);
			//获取会议邀请人员信息并存入数据库
			$Personinfor = $meet->getMeetingPersonInformation($bookid);
			$Personinfor_1 = $Personinfor['invitee'];
			$Personinfor_2 = explode(',',$Personinfor_1);
			$Personinfors = array();
			foreach ($Personinfor_2 as $key=>$value){
				$Personinfors['userid'] = $value;
				$Personinfors['bookid'] = $bookid;
				$meet_id = array(
						'bookid' => $bookid,
						'userid' => $value
				);
				$meetId = $meet->getPersonInformationId($meet_id);
				if($meetId == null){
					$meet->updateInformation($Personinfors);
				}
			}
		}
		//获取会议信息
		$information = $meet->getMeetingInformation($bookid);
		//获取参会人员信息
		$aa = array(
				'bookid' => $bookid
		);
		$personInformation = $meet->getPersonInformation($aa);
// 		echo "<pre>";print_r($personInformation);die;
		if(isset($information) && !empty($information)){
			$startTime = $information['meetingstarttime'];
			$tpl->assign('start',$startTime*1000);
			$meetstarttime = $information['meetingstarttime'];
			$meetTime = date("Y/m/d","$startTime");
			$startTime = date("H:i","$startTime");
			$endTime = $information['meetingendtime'];
			$endTime = date('H:i',"$endTime");
		}
		//处理参会人员信息
		$ontimeNumber = 0;//实际到会人数
		$lateNumber = 0;//迟到
		$absent = 0;//缺席
		$leave = 0;//请假
		if(isset($personInformation) && !empty($personInformation)){
			foreach ($personInformation as $key => $value){
				$username = $meet->getusername($value['userid']);
				$personInformation[$key]['username'] = $username['username'];
				if($value['isagreeattend'] == 1){
					if($value['isattend'] == 1 && $value['islate'] == 0){
						$personInformation[$key]['state'] = '准时';
						$personInformation[$key]['color'] = '';
						$personInformation[$key]['statename'] = 'zhunshi';
					}
					if($value['isattend'] == 1 && $value['islate'] == 1){
						$personInformation[$key]['state'] = '迟到';$lateNumber++;
						$personInformation[$key]['color'] = 'green';
					}
					if($value['isattend'] == 0){
						$personInformation[$key]['state'] = '缺席';$absent++;
						$personInformation[$key]['color'] = 'red';
					}
				}elseif($value['isagreeattend'] == 0){
					$personInformation[$key]['state'] = '请假';$leave++;
					$personInformation[$key]['color'] = 'violet';
				}
			}
// 			echo "<pre/>";print_r($personInformation);die;
			$personRight = array();
			$personLeft = array();
			$f = ceil(count($personInformation)/2);
			$i = 0;
			foreach ($personInformation as $key=>$value){
				if($key < $f){
					$personRight[$key] = $value;
				}else{
					$i = $i;
					$personLeft[$i] = $value;
					$i++;
				}
			}
			$personNum = count($personInformation);//应到人数
			$ontimeNumber = $personNum - ($leave + $absent);
			//获取会议记录
			if(isset($_POST['meetRecord_1']) && $_POST['meetRecord_1'] != null){
				$record = $_POST['meetRecord_1'];
				$recordM = array(
						'bookid' => $bookid,
						'meetingsummary' => $record
				);
				$meet->updateRecordInformation($recordM);
			}
			//获取签到信息
			if(isset($_POST['meet']) && $_POST['meet'] != null){
				$signInformationCard = $_POST['meet'];
				$signInformationCard_1 = explode('//',$signInformationCard);
				$signInformation = $signInformationCard_1[0];//签到
				$signInformationCardAll = $signInformationCard_1[1];//工牌
				$signInformationAttendAll = $signInformationCard_1[2];
				if($signInformationCardAll != null){//工牌
					$signInformationCardAll = explode('/',$signInformationCardAll);
					foreach ($signInformationCardAll as $key => $value){
						$signInformationCardAll[$key] = explode('_',$value);
					}
					array_shift($signInformationCardAll);
				}
				if($signInformationAttendAll != null){//缺席
					$signInformationAttendAll = explode('/',$signInformationAttendAll);
					foreach ($signInformationAttendAll as $key => $value){
						$signInformationAttendAll[$key] = explode('_',$value);
					}
					array_shift($signInformationAttendAll);
				}
				
				if($signInformation != null){
					$signInformation = explode('/',$signInformation);
					foreach ($signInformation as $key => $value){
						$signInformation[$key] = explode('_',$value);
					}
				}
			}
			if(isset($signInformation) && count($signInformation) > 0){
				array_shift($signInformation);
			}
			//整理工牌参数
			foreach ($personInformation as $key=>$value){
				if($value['isagreeattend'] != 0 && isset($signInformationCardAll) && count($signInformationCardAll) > 0){
					foreach ($signInformationCardAll as $k=>$v){
						if($signInformationCardAll[$k][0] == $value['userid'] && $signInformationCardAll[$k][1] == 1){
							$signInformationCard_2[] = array(//佩戴
									'diaryid' => $value['diaryid'],
									'wearcard' => 1,
							);
							break;
						}elseif($signInformationCardAll[$k][0] == $value['userid'] && $signInformationCardAll[$k][1] == 0){
							$signInformationCard_2[] = array(//未佩戴
									'diaryid' => $value['diaryid'],
									'wearcard' => 0,
							);
							break;
						}
					}
				}
			}
			//整理缺席参数
			foreach ($personInformation as $key=>$value){
				if($value['isagreeattend'] != 0 && isset($signInformationAttendAll) && count($signInformationAttendAll) > 0){
					foreach ($signInformationAttendAll as $k=>$v){
						if($signInformationAttendAll[$k][0] == $value['userid'] && $signInformationAttendAll[$k][1] == 1){
							$signInformationAttend[] = array(//缺席
									'diaryid' => $value['diaryid'],
									'isattend' => 0,
							);
							break;
						}elseif($signInformationAttendAll[$k][0] == $value['userid'] && $signInformationAttendAll[$k][1] == 0){
							$signInformationAttend[] = array(//到场
									'diaryid' => $value['diaryid'],
									'isattend' => 1,
							);
							break;
						}
					}
				}
			}
			//整理签到参数
			$signInformations = array();
			foreach ($personInformation as $key=>$value){
				if($value['isagreeattend'] != 0 && isset($signInformation) && count($signInformation) > 0){
					foreach ($signInformation as $k=>$v){
							if($signInformation[$k][0] == $value['userid'] && $signInformation[$k][1] == 1){
								$signInformations[] = array(//准时
										'diaryid' => $value['diaryid'],
										'isattend' => 1,
										'islate' => 0
									);
								break;
							}elseif($signInformation[$k][0] == $value['userid'] && $signInformation[$k][1] == 0){
								$signInformations[] = array(//迟到
										'diaryid' => $value['diaryid'],
										'isattend' => 1,
										'islate' => 1
								);
								break;
							}
						}	
				}
			}
		}
		//修改数据
		if(isset($signInformations) && !empty($signInformations)){
			foreach ($signInformations as $key=>$value){
				$result = $meet->updateInformation($value);
			}
		}
		if(isset($signInformationCard_2) && !empty($signInformationCard_2)){
			foreach ($signInformationCard_2 as $key=>$value){
				$result = $meet->updateCardInformation($value);
			}
		}
		if(isset($signInformationAttend) && !empty($signInformationAttend)){
			foreach ($signInformationAttend as $key=>$value){
				$result = $meet->updateAttendInformation($value);
			}
		}
// 		echo "<pre/>";print_r($signInformations);die;
		$tpl->assign('meetstarttime',$meetstarttime);
		$tpl->assign('ontimeNumber',$ontimeNumber);
		$tpl->assign('lateNumber',$lateNumber);
		$tpl->assign('absent',$absent);
		$tpl->assign('leave',$leave);
		$tpl->assign('nowtime',time());
		$tpl->assign('startTime',$startTime);
		$tpl->assign('endTime',$endTime);
		$tpl->assign('meetTime',$meetTime);
		$tpl->assign('personNum',$personNum);
		$tpl->assign('information',$information);
		$tpl->assign('personRight',$personRight);
		$tpl->assign('personLeft',$personLeft);
		$tpl->display('conference.htm');
	}
}
<?php
namespace Model;

 class Information extends \Model\Base {
 	
 	protected $db;
 	
 	protected $dbPro;
 	
 	public function __construct(){
 		$this->db = $this->getDB();
 		// $this->dbPro = $this->getDBPro();
 	}
 	//查询会议预订信息
 	public function getMeetingInformation($bookid){
 		if(!empty($bookid)){
	 		$sql = "SELECT * FROM `". DBPREFIX ."meeting_book` WHERE `bookid`= ?";
	 		$this->db->prepare($sql);
 			$this->db->execute(array($bookid));
	 		$result = $this->db->getRow();
	 		if(!empty($result)){
	 			return $result;
	 		}
 		}
 	}
 	//查询会议邀请人员信息
 	public function getMeetingPersonInformation($bookid){
 		if(!empty($bookid)){
 			$sql = "SELECT `invitee` FROM `". DBPREFIX ."meeting_book` WHERE `bookid`= ?";
 			$this->db->prepare($sql);
 			$this->db->execute(array($bookid));
 			$result = $this->db->getRow();
 			if(!empty($result)){
 				return $result;
 			}
 		}
 	}
 	//查询参会人员信息
 	public function getPersonInformation($book){
 		if(!empty($book)){
 			extract($book);
 			$sql = "SELECT * FROM `". DBPREFIX ."meeting_persion_diary` WHERE `bookid`= ?";
 			$this->db->prepare($sql);
 			$this->db->execute(array($bookid));
 			$result = $this->db->getAll();
 			if(!empty($result)){
 				return $result;
 			}
 		}
 	}
 	//查询会议预定id
 	public function getPersonInformationId($book){
 		if(!empty($book)){
 			extract($book);
 			$sql = "SELECT `bookid` FROM `". DBPREFIX ."meeting_persion_diary` WHERE `bookid`= ? AND `userid`= ?";
 			$this->db->prepare($sql);
 			$this->db->execute(array($bookid,$userid));
 			$result = $this->db->getRow();
 			if(!empty($result)){
 				return $result;
 			}
 		}
 	}
 	public function getusername($userid){
 		if(!empty($userid)){
 			$sql = "SELECT `username` FROM `". DBPREFIX ."user` WHERE `userid`= ?";
 			$this->db->prepare($sql);
 			$this->db->execute(array($userid));
 			$result = $this->db->getRow();
 			if(!empty($result)){
 				return $result;
 			}
 		}
 	}
 	//删除
 	public function deleteMeeting($id){
 		if($id){
	 		$sql = "DELETE FROM `". DBPREFIX ."meeting_address` WHERE `meetingaddressid`= $id";
	 		$rows = $this->db->exec($sql);
	 		return $rows;
 		}
 	}
 	//修改会议记录
 	public function updateRecordInformation($data){
 		if(!empty($data)){
 			extract($data);
 			if(isset($bookid)){
 				//update
 				$sql = "UPDATE `". DBPREFIX ."meeting_book` set
 				`meetingsummary`=?
 				WHERE `bookid` = {$bookid}";
 				$this->db->prepare($sql);
 				$this->db->execute(array($meetingsummary));
 			}
 			return true;
 			}
 			return false;
 	}
 	//修改工牌佩戴情况
 	public function updateCardInformation($data){
 		if(!empty($data)){
 			extract($data);
 			if(isset($diaryid)){
 				//update
 				$sql = "UPDATE `". DBPREFIX ."meeting_persion_diary` set
 				`wearcard`=?
 				WHERE `diaryid` = {$diaryid}";
 				$this->db->prepare($sql);
 				$this->db->execute(array($wearcard));
 			}
 				return true;
 		}
 		return false;
 	}
 	//修改缺勤情况
 	public function updateAttendInformation($data){
 		if(!empty($data)){
 			extract($data);
 			if(isset($diaryid)){
 				//update
 				$sql = "UPDATE `". DBPREFIX ."meeting_persion_diary` set
 				`isattend`=?
 				WHERE `diaryid` = {$diaryid}";
 				$this->db->prepare($sql);
 				$this->db->execute(array($isattend));
 			}
 				return true;
 		}
 		return false;
 	}
 	//修改
 	public function updateInformation($data){
 		if(!empty($data)){
 			extract($data);
 			if(isset($diaryid)){
 				//update
 				$sql = "UPDATE `". DBPREFIX ."meeting_persion_diary` set
 				`isattend`=?,
 				`islate`=?
 				WHERE `diaryid` = {$diaryid}";
 				$this->db->prepare($sql);
 				$this->db->execute(array($isattend,$islate));
 			}else{
 			//insert
 			$sql ="INSERT INTO `". DBPREFIX ."meeting_persion_diary` (
 					`userid`,
 					`bookid`
 					) VALUES (?,?)";
				$this->db->prepare($sql);
				$this->db->execute(array($userid,$bookid));
 					//$lastId = $this->db->getLastInsertId();
 				}
 					return true;
 			}
 				return false;
 	}

 	//被邀请人请假
 	/*$userId $bookId 指用户ID和会议预定ID
 	*leaveReason请假原因
 	*/
 	public function leaveMeeting($data){
		extract($data);
		if(isset($bookId)){
			$sql = "INSERT INTO `". DBPREFIX ."meeting_persion_diary` (`userid`,`bookid`,`isagreeattend`,`leavemessage`) VALUES (?,?,?,?)";
			$this->db->prepare($sql);
			$this->db->execute(array($userId,$bookId,0,$leaveReason));
			return true;
		}
		return false;
 	}

 	//
 	public function isSetLeaveInfo($data){
 		extract($data);
 		if(!empty($userId)){
 			$sql = "SELECT * FROM `". DBPREFIX ."meeting_persion_diary` WHERE `userid`= ? AND `bookid` = ?";
 			$this->db->prepare($sql);
 			$this->db->execute(array($userId,$bookId));
 			$result = $this->db->getRow();
 			if(!empty($result)){
 				return $result;
 			}else{
 				return false;
 			}
 		}
 	}
 				
 }
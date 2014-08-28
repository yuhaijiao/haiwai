<?php
namespace Model;
/**
 * 首页模块
 * FileName:IndexModel.php
 * @Author:
 * @Since:2012-2-21
 */
 class MeetingModel extends \Model\Base {
 	
 	protected $db;
 	
 	protected $dbPro;
 	
 	public function __construct(){
 		$this->db = $this->getDB();
 		$this->dbPro = $this->getDBPro();
 	}
 	
 	/**
 	 * 获取某一天预订信息
 	 * @return unknown
 	 */
 	public function getDayBookInfo($day,$nextDay){
 		if($day!="" && $nextDay!="" ){
 			$sql = "SELECT `bookid`,`bookuser`,`meetingname`,`meetingintro`,`meetingaddress`,`meetingstarttime`,`meetingendtime`,`invitee`,`isagree`,`extralist`,`meetingdebook` FROM `". DBPREFIX ."meeting_book` WHERE `meetingstarttime`> ? AND `meetingendtime` < ? order by `meetingaddress`";
 			$this->db->prepare($sql);
 			$this->db->execute(array($day,$nextDay));
 			$result = $this->db->getAll();
 			if(!empty($result)){
 				return $result;
 			}
 		}
 		return false;
 	}

  	/**
 	 * 根据预订id查询指定预订信息
 	 * @return unknown
 	 */
 	public function getBookInfoById($bookid){
 		if($bookid!=""){
 			$sql = "SELECT `bookuser`,`meetingname`,`meetingintro`,`meetingaddress`,`meetingstarttime`,`meetingendtime`,`invitee`,`meetingdebook`,`isagree` FROM `". DBPREFIX ."meeting_book` WHERE `bookid`=?";
 			$this->db->prepare($sql);
 			$this->db->execute(array($bookid));
 			$result = $this->db->getRow();
 			if(!empty($result)){
 				return $result;
 			}
 		}
 		return false;
 	}

 	/**
 	 * 查询所有用户dbPro
 	 * @return unknown
 	 */
 	public function getAllUser(){
		$sql = "SELECT `username`,`uid`,`email` FROM `". DBPREFIX ."admin_user` WHERE `activation` = 1 order by `username` ";
		$this->dbPro->prepare($sql);
		$this->dbPro->execute(array());
		$result = $this->dbPro->getAll();
		if(!empty($result)){
			return $result;
		}
 		return false;
 	}

 	/**
 	 * 查询指定用户db
 	 * @return unknown
 	 */
 	public function getSysUser($username,$userid){
		$sql = "SELECT * FROM `". DBPREFIX ."user` WHERE `username` = ? AND `userid` = ? ";
		$this->db->prepare($sql);
		$this->db->execute(array($username,$userid));
		$result = $this->db->getAll();
		if(!empty($result)){
			return $result;
		}
 		return false;
 	}
 	 	/**
 	 * 查询指定用户db
 	 * @return unknown
 	 */
 	public function getSysUserById($userid){
		$sql = "SELECT * FROM `". DBPREFIX ."user` WHERE `userid` = ? ";
		$this->db->prepare($sql);
		$this->db->execute(array($userid));
		$result = $this->db->getRow();
		if(!empty($result)){
			return $result;
		}
 		return false;
 	}
 	/**
 	 * 查询所有用户db
 	 * @return unknown
 	 */
 	public function getSysUsers(){
		$sql = "SELECT `userid`,`username`,`pinyin`,`email` FROM `". DBPREFIX ."user` WHERE `activation` = 1 order by `username`,`pinyin` ";
		$this->db->prepare($sql);
		$this->db->execute(array());
		$result = $this->db->getAll();
		if(!empty($result)){
			return $result;
		}
 		return false;
 	}
 	/**
 	 * 同步用户
 	 * @return unknown
 	 */
 	public function syncUser($values){
 		extract($values);
		$sql ="INSERT INTO `". DBPREFIX ."user` (
 					`userid`, 
 					`username`, 
 					`pinyin`, 
 					`email`
 					) VALUES (?,?,?,?)";
		$this->db->prepare($sql);
		$this->db->execute(array($uid,$username,$pinyin,$email));
 		return true;
 	}

 	/**
 	 * 系统配置参数
 	 * @return unknown
 	 */
 	public function getMeetingConfig(){
		$sql = "SELECT `startbooktime`,`endbooktime`,`debooktime`,`interval`,`rule`,`ruletitle`,`aheadtime` FROM `". DBPREFIX ."meeting_config` WHERE `activation` = 1 ";
		$this->db->prepare($sql);
		$this->db->execute(array());
		$result = $this->db->getRow();
		if(!empty($result)){
			return $result;
		}
 		return false;
 	}
 	 	/**
 	 * 系统配置参数修改
 	 * @return unknown
 	 */
 	public function updateMeetingConfig($data){
 		extract($data);
		$sql = "UPDATE `". DBPREFIX ."meeting_config` set `startbooktime`=?,`endbooktime`=?,`debooktime`=?,`interval`=?,`rule`=?,`ruletitle`=?,`aheadtime`=? WHERE `activation` = 1 ";
		$this->db->prepare($sql);
		$result=$this->db->execute(array($startbooktime,$endbooktime,$debooktime,$interval,$rule,$ruletitle,$aheadtime));
		if(!empty($result)){
			return $result;
		}
 		return false;
 	}
 	/**
 	 * 行政审核
 	 * @return unknown
 	 */
 	public function isAgreeTheApply($isAgree,$bookId){
 		if ($isAgree!='' && $bookId!='') { 		
			$sql = "UPDATE `". DBPREFIX ."meeting_book` set `isagree`=? WHERE `bookid`=? ";
			$this->db->prepare($sql);
			$this->db->execute(array($isAgree,$bookId));		
			return 1;
 		}
 	}
 	/**
 	 * 申请者退订
 	 * @return unknown
 	 */
 	public function applyDebook($bookId){
 		if ($bookId!='') {
			$sql = "UPDATE `". DBPREFIX ."meeting_book` set `meetingdebook`= 1,`debooktime`=?  WHERE `bookid`=? ";
			$this->db->prepare($sql);
			$this->db->execute(array(time(),$bookId));
	 		return 1;
 		}
 	}




 	/**
 	* 增加或修改记录
 	*/
 	public function modifyBookinfo($data){
 		if(!empty($data)){
 			extract($data);
 			if(isset($bookid)){
 				//update
 				$sql = "UPDATE `". DBPREFIX ."meeting_book` set 
 				`meetingname`=?, 
 				`meetingintro`=?, 
 				`meetingaddress`=?, 
 				`booktime`=?, 
 				`meetingstarttime`=?, 
 				`meetingendtime`=?, 
 				`invitee`=?,
 				`extralist`=?
 				WHERE `bookid` = {$bookid}";
 				$this->db->prepare($sql);
 				$this->db->execute(array($meetingname,$meetingintro,$meetingaddress,$booktime,$meetingstarttime,$meetingendtime,$invitee,$extralist));
 			}else{
 				//insert
 				$sql ="INSERT INTO `". DBPREFIX ."meeting_book` (
 					`bookuser`, 
 					`meetingname`, 
 					`meetingintro`, 
 					`meetingaddress`, 
 					`booktime`, 
 					`meetingstarttime`,  
 					`meetingendtime`, 
 					`invitee`,
 					`extralist`
 					) VALUES (?,?,?,?,?,?,?,?,?)";
				$this->db->prepare($sql);
				$this->db->execute(array($bookuser,$meetingname,$meetingintro,$meetingaddress,$booktime,$meetingstarttime,$meetingendtime,$invitee,$extralist));
 			}
 			return true;
 		} 	
 		return false;	
 	}
 }
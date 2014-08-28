<?php
namespace Model;

 class Meeting extends \Model\Base {
 	
 	protected $db;
 	
 	protected $dbPro;
 	
 	public function __construct(){
 		$this->db = $this->getDB();
 		// $this->dbPro = $this->getDBPro();
 	}
 	//查询
 	public function getMeetingInformation(){
	 		$sql = "SELECT * FROM `". DBPREFIX ."meeting_address`";
	 		$this->db->query($sql);
	 		$result = $this->db->getAll();
	 		if(!empty($result)){
	 			return $result;
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
 	//修改
 	public function addMeet($data){
 		if(!empty($data)){
 			extract($data);
 			if(isset($id)){
 				//update
 				$sql = "UPDATE `". DBPREFIX ."meeting_address` set
 				`meetingaddress`=?,
 				`addressaddtime`=?,
 				`isenabled`=?,
 				`galleryful`=?,
 				`haveppt`=?,
 				`haveblackbord`=?
 				WHERE `meetingaddressid` = {$id}";
 				$this->db->prepare($sql);
 				$this->db->execute(array($meetingaddress,$addressaddtime,$isenabled,$galleryful,$haveppt,$haveblackbord));
 			}else{
 			//insert
 			$sql ="INSERT INTO `". DBPREFIX ."meeting_address` (
 					`meetingaddress`,
 					`addressaddtime`,
 					`isenabled`,
 					`galleryful`,
 					`haveppt`,
 					`haveblackbord`
 					) VALUES (?,?,?,?,?,?)";
				$this->db->prepare($sql);
				$this->db->execute(array($meetingaddress,$addressaddtime,$isenabled,$galleryful,$haveppt,$haveblackbord));
 					//$lastId = $this->db->getLastInsertId();
 				}
 					return true;
 			}
 				return false;
 	}
 				
 }
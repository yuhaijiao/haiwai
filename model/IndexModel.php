<?php
namespace Model;
/**
 * 首页模块
 * FileName:IndexModel.php
 * @Author:oliver <cgjp123@163.com>
 * @Since:2012-2-21
 */
 class IndexModel extends \Model\Base {
 	
 	protected $db;
 	
 	protected $dbPro;
 	
 	public function __construct(){
 		$this->db = $this->getDB();
 		// $this->dbPro = $this->getDBPro();
 	}
 	
 	/**
 	 * 验证用户登录
 	 * @return unknown
 	 */
 	public function getMember($memberName){
 		if(!empty($memberName)){
 			$sql = "SELECT `username`,`isadmin` FROM `". DBPREFIX ."user` WHERE `username`=? limit 1";
 			$this->db->prepare($sql);
 			$this->db->execute(array($memberName));
 			$result = $this->db->getRow();
 			if(!empty($result)){
 				return $result;
 			}
 		}
 		return false;
 	}
 	 /*	public function getMember($memberName,$memberPass){
 		if(!empty($memberName) && !empty($memberPass)){
 			$sql = "SELECT `username`,`isadmin` FROM `". DBPREFIX ."user` WHERE `username`=? AND `userpass`=? limit 1";
 			$this->dbPro->prepare($sql);
 			$this->dbPro->execute(array($memberName,$memberPass));
 			$result = $this->dbPro->getRow();
 			if(!empty($result)){
 				return $result;
 			}
 		}
 		return false;
 	}*/

 	/**
 	* 获取文件列表带分页
 	*/
 	public function getFile($page=1,$pageSize=20){
 		$start = ($page-1)*$pageSize+1;
 		$sql = "select `id`,`redmineId`,`redmineTitle`,`desc`,`imgfile`,`psdfile`,`psdTips`,`themefile`,`themeTips`,`otherfile`,`fileTips`,`creatTime`,`modifyTime` FROM `fileInfo` LIMIT {$start},{$pageSize} ORDER BY `id` DESC";
 		$this->db->query($sql);
 		$result = $this->db->getAll();
 		if(!empty($result)){
 			return $result;
 		}
 	}

 	/**
 	* 获取单条文件
 	*/
 	public function getFileFromId($id){
 		if(!empty($id)){
	 		$sql = "SELECT `id`,`redmineId`,`redmineTitle`,`desc`,`imgfile`,`psdfile`,`psdTips`,`themefile`,`themeTips`,`otherfile`,`fileTips`,`creatTime`,`modifyTime` FROM `fileInfo` WHERE `id`={$id}";
	 		$this->db->query($sql);
	 		$result = $this->db->getRow();
	 		if(!empty($result)){
	 			return $result;
	 		}
 		}
 	}

 	/**
 	* 增加或修改记录
 	*/
 	public function addFile($data){
 		if(!empty($data)){
 			extract($data);
 			if(isset($id)){
 				//update
 				$sql = "UPDATE `fileInfo` set 
 				`redmineId`=?, 
 				`redmineTitle`=?, 
 				`desc`=?, 
 				`imgfile`=?, 
 				`psdfile`=?, 
 				`psdTips`=?, 
 				`themefile`=?, 
 				`themeTips`=?, 
 				`otherfile`=?, 
 				`fileTips`=?, 
 				`modifyTime`=? 
 				WHERE `id` = {$id}";
 				$this->db->prepare($sql);
 				$this->db->execute(array($redmineId,$redmineTitle,$desc,$imgfile,$psdfile,$psdTips,$themefile,$themeTips,$otherfile,$fileTips,time()));
 			}else{
 				//insert
 				$sql ="INSERT INTO `fileInfo` (
 					`redmineId`, 
 					`redmineTitle`, 
 					`desc`, 
 					`imgfile`, 
 					`psdfile`, 
 					`psdTips`, 
 					`themefile`, 
 					`themeTips`, 
 					`otherfile`, 
 					`fileTips`, 
 					`creatTime` 
 					) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
				$this->db->prepare($sql);
				$this->db->execute(array($redmineId,$redmineTitle,$desc,$imgfile,$psdfile,$psdTips,$themefile,$themeTips,$otherfile,$fileTips,time()));
 				//$lastId = $this->db->getLastInsertId();
 			}
 			return true;
 		} 	
 		return false;	
 	}
 }
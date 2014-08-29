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
 	public function getTeam(){
 			$sql = "SELECT * FROM team";
 			$this->db->prepare($sql);
 			$this->db->execute();
 			$result = $this->db->getAll();
 			if(!empty($result)){
 				return $result;
 			}
 	}
 }
<?php
namespace Model;
/**
 * Enter description here ...
 * FileName:Base.php
 * @Author:oliver <cgjp123@163.com>
 * @since:2012-2-13
 */
 class Base {
 	
 	public function getDB(){
 		$dbModle = new \Lib\Db();
 		$db = $dbModle->loadDB('local');
 		return $db;
 	}
 	
 	public function getDBBi(){
 		$dbModle = new \Lib\Db();
 		$db = $dbModle->loadDB('bi');
 		return $db;
 	}
 	
 	public function getDBPro(){
 		$dbModle = new \Lib\Db();
 		$db = $dbModle->loadDB('pro');
 		return $db;
 	}
 }
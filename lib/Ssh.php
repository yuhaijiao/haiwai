<?php
namespace Lib;
/**
 * SSH类单例入口，只允许一个实例存在
 * @author oliver
 *
 */
class Ssh {
	
	private static $_instance = null;
	
	private function __construct(){
		
	}
	
	private function __clone() {
		
	}
	
	/**
	 * 获取实例
	 * @return Ambigous <boolean, \Lib\Helper\Ssh>
	 */
	public static function getInstance(){
		if(self::$_instance===null){
			self::$_instance = self::initInstance();
		}
		return self::$_instance;
	}
	
	/**
	 * 初始化实例
	 * @return boolean|\Lib\Helper\Ssh
	 */
	private static function initInstance(){
		$inst = new \Lib\Helper\Ssh();
		if($inst===false){
			return false;
		}
		return $inst;
	}
}
<?php
namespace Lib;
/**
 * 系统加载前各项处理
 * @author chengjun
 *
 */
class BootStrap {	

	public static function run(){
		$tag = ini_get('session.save_handler');
		if(empty($tag)){
			$tag = 'files';
		} 
		//$tag = 'memcache';
		self::startSession($tag);
		
	}
	
	/**
	 * 启动SESSION
	 */
	private static function startSession($tag='files'){
		if(!session_id()){
			switch ($tag){
				case 'files':
				$sessionHandler = new \Lib\Session\SessionInFile();
				$_SESSION['sessionInWhere'] = 'files';
				break;
				case 'memcache':
				$sessionHandler = new \Lib\Session\SessionInMem();
				$_SESSION['sessionInWhere'] = 'memcache';
				break;
			}
		}
	}
}
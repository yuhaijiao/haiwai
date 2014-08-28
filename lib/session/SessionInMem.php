<?php
namespace Lib\Session;

/**
 * SESSION保存进内存
 * @author oliver
 *
 */
class SessionInMem {
	/**
	 * memcache
	 * @var unknown
	 */
	private $memHandle;
	
	public function __construct(){
		ini_set('session.save_handler', 'memcache');
		session_save_path(\Config\Memcache::HOST.':'.\Config\Memcache::PORT);
		$this->memHandle = new \Lib\Cache\Memcache();
		session_name(SESSION_NAME);
		session_start();
			//$this->sessionRecord();
	}
}
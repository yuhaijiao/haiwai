<?php
namespace Lib\Helper;

class AutoLogin {
	private $memHandle;
	
	private $currentHost;
	
	private $validKey;
	
	public function __construct(){
		$this->memHandle = new \Lib\Cache\Memcache();
		if(empty($_SESSION[SESSION_PREFIX.'validKey'])){
			$this->saveInfoForValid();
		}else {
			$this->validKey = $_SESSION[SESSION_PREFIX.'validKey'];
		}
	}
	
	/**
	 * 生成唯一识别码
	 */
	private function saveInfoForValid(){
		$ip = \Lib\Helper\RequestUnit::getClientIp();
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		//当前用户通用唯一识别码
		//区分了客户端浏览器和IP
		$this->validKey = md5(MD5_PREFIX.$ip.$user_agent);
		$_SESSION[SESSION_PREFIX.'validKey'] = $this->validKey;
		return true;
	}
	
	/**
	 * 自动登录
	 */
	public function autoLogin(){
		$validKey = $this->validKey;
		$session_id = session_id();
		$validKeyCache = array();
		$validKeyCache = $this->memHandle->get('validKeyCache');
		if(empty($_SESSION[SESSION_PREFIX.'login'])){
			if(!empty($validKeyCache[$validKey]['sessionInfo'])){
				/**
				 使用$_SESSION时会自动把数据写入对应memcache，所以不用再调用memecahe写入数据
				 */
				$_SESSION[SESSION_PREFIX.'login'] = $validKeyCache[$validKey]['sessionInfo'][SESSION_PREFIX.'login'];
				$_SESSION[SESSION_PREFIX.'username'] = $validKeyCache[$validKey]['sessionInfo'][SESSION_PREFIX.'username'];
				$_SESSION[SESSION_PREFIX.'memberId'] = $validKeyCache[$validKey]['sessionInfo'][SESSION_PREFIX.'memberId'];
			}
		}
		return true;
	}
}
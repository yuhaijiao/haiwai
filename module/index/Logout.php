<?php
namespace Module\Index;
/**
 * 登出
 * @author oliver
 *
 */
class Logout extends \Lib\Application {	
	public function run(){
		$memberId = \Lib\Helper\CheckLogin::sso();
		if(!$memberId){
			header('LOCATION:'.ROOT_URL);
			exit;
		}
		$this->autoLogout();
		exit;
	}
	
	/**
	 * 自动登出
	 * 只有主动发起的登出才会强制登出所有SESSION
	 * 其他情况就必须等唯一识别码键失效
	 * @param unknown $validKey
	 */
	public function autoLogout(){
		if(isset($_SESSION['sessionInWhere'])){
			$tag = $_SESSION['sessionInWhere'];
		}else{
			$tag = 'files';
		}
		switch ($tag){
			case 'files':
			break;
			case 'memcache':
				$memHandle = new \Lib\Cache\Memcache();
				$validKey = $_SESSION[SESSION_PREFIX.'validKey'];
				$validKeyCache = array();
				$validKeyCache = $memHandle->get('validKeyCache');
				if(!empty($validKeyCache[$validKey])){
					//获取SID
					if(!empty($validKeyCache[$validKey]['domain'])){
						foreach($validKeyCache[$validKey]['domain'] as $host=>$sid){
							$sessInfo = $memHandle->get($sid);
							if($sessInfo!==false){
								$memHandle->delete($sid,0);
							}
						}
						//删除唯一识别码键
						$memHandle->delete('validKeyCache',0);
					}
				
				}
			break;
		}
		unset($_SESSION[SESSION_PREFIX.'login']);
		unset($_SESSION[SESSION_PREFIX.'userName']);
		unset($_SESSION[SESSION_PREFIX.'memberId']);
		header('LOCATION:'.ROOT_URL);
		exit;
		return true;
	}
}
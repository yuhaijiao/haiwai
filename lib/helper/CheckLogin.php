<?php
namespace Lib\Helper;
/**
 * 登录检查
 */
class CheckLogin {
	public static function getMemberId(){
		$memberId = isset($_SESSION[SESSION_PREFIX.'memberId'] ) ? $_SESSION[SESSION_PREFIX.'memberId']  : '';
		if(!$memberId){
			//header('location:'.ROOT_URL.'index/login-forward-'.base64_encode(\Lib\Helper\RequestUnit::getUrl(false)).'.html');
			header('location:'.ROOT_URL.'index.php?module=index&action=login');
			exit;
		}
		return $memberId;
	}
	
	public static function check(){
		$memberId = isset($_SESSION[SESSION_PREFIX.'memberId']) ? $_SESSION[SESSION_PREFIX.'memberId'] : '';
		if(!$memberId){
			return false;
		}
		return $memberId;
	}
	public static function getMemberName(){
		$memberName = isset($_SESSION[SESSION_PREFIX.'userName']) ? $_SESSION[SESSION_PREFIX.'userName'] : '';
		if(!$memberName){
			return false;
		}
		return $memberName;
	}
	public static function memberIsadmin(){
		$memberIsadmin = isset($_SESSION[SESSION_PREFIX.'admin']) ? $_SESSION[SESSION_PREFIX.'admin'] : '';
		if(!$memberIsadmin){
			return false;
		}
		return $memberIsadmin;
	}
	public static function sso(){
		include_once ROOT_PATH . 'lib/cas/CAS.php';
		include_once ROOT_PATH . 'config/cas.php';
		$client = '';
		$cas_host = CAS_HOST;
		$cas_port = intval(CAS_PORT);

		$cas_context = CAS_CONTEXT;
		$phpCAS = new \phpCAS();
		//$phpCAS->setDebug();
		$phpCAS->client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
		$phpCAS->setNoCasServerValidation();
		$phpCAS->handleLogoutRequests();
		$phpCAS->forceAuthentication();
		
		$param = \Lib\Helper\RequestUnit::getParams();
		$action = $param->action;
		if (isset($action)&&$action=='logout') {
			//$resUrl = array('url'=>ROOT_URL.'index.php?module=index&action=login');
			$phpCAS->logout();
			
		}
		
		$client=$phpCAS->getAttributes();
		
		return $client;
	
	}
}
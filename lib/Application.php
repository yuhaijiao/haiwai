<?php
namespace Lib;
use Lib\helper\RequestUnit;
/**
 * 基类，所有应用均继承此类
 */
class Application {
	
	/**
	 * 保存url参数
	 */
	protected static $requestParams;
	
	public function __construct(){
		if($_SERVER['REMOTE_ADDR']){
			$whiteList = \Config\WhiteListConfig::$whiteList;
			if(in_array($_SERVER['REMOTE_ADDR'], $whiteList)){
				if(DEBUG){
					ini_set('display_errors' ,1);
					error_reporting( E_ALL | E_STRICT);
				}else{
					ini_set('display_errors' ,0);
					error_reporting(0);
				}
			}else{
				ini_set('display_errors' ,0);
				error_reporting(0);
			}
		}
	}
	
	/**
	 * 
	 * 启动应用
	 */
	public function run(){
		self::$requestParams = RequestUnit::getParams();
		$moduleAction = 'Module\\'.self::$requestParams->module.'\\'.ucfirst(self::$requestParams->action);
		if(!class_exists($moduleAction, true)){
			$msg = 'module/action not found !'.$moduleAction."\n".'Parsed request parameters:'."\n".var_export(self::$requestParams,true);
			error_log($msg);
            header ('HTTP/1.1 404 Not found');
            require ROOT_PATH.'errors/404.php';
			die();
		}
		
		\Lib\BootStrap::run();
		
		 $module = new $moduleAction();
		 $module->run();
	}
	
	/**
	 *
	 * Enter description here ...
	 * @param unknown_type $msg
	 * @param unknown_type $url
	 * @param unknown_type $exit
	 * @param unknown_type $is_lang
	 * @param unknown_type $is_extra
	 * @param unknown_type $script
	 */
	public function alert_forward($msg, $url, $exit = 0, $is_lang = 0, $is_extra = '', $script = '') {
		$tpl = \Lib\Template::getSmarty();
		$tpl->assign ( 'msg', $msg );
		$tpl->assign ( 'url', $url );
		$tpl->assign ( 'is_lang', $is_lang );
		$tpl->assign ( 'is_extra', $is_extra );
		$tpl->assign ( 'script', $script );
		$tpl->display ( 'alert_forward.htm' );
		if ($exit == 1)
			exit ();
		return;
	}
	
	/**
	 * 注销SESSION
	 */
	protected function unsetSession(){
		unset($_SESSION[SESSION_PREFIX.'memberId']);
		unset($_SESSION[SESSION_PREFIX.'memberName']);
		unset($_SESSION[SESSION_PREFIX.'memberRealName']);
		unset($_SESSION[SESSION_PREFIX.'memberSex']);
		unset($_SESSION[SESSION_PREFIX.'memberEmail']);
		session_destroy();
		return;
	}
	
	public static function getMicroTime($decimal=6)
    {
        return number_format(microtime(true),(int)$decimal,'.','');
    } 
}
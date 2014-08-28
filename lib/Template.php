<?php
namespace Lib;
use Lib\smarty\Smarty;
/**
 * FileName:Template.php
 * Enter description here ...
 * Author:@{user}
 * Date:@{2012-2-9 ����03:24:17
 */

class Template {
	protected static $smarty ;
	
	public static function getSmarty(){
		if(self::$smarty instanceof \Lib\smarty\Smarty){
			return self::$smarty;
		}
		$user_theme = 'default';
		if(!defined('THEME')) define('THEME',ROOT_PATH.'theme/');
		if (!defined('THEME_ROOT_PATH')) define('THEME_ROOT_PATH', THEME . 'default/');//模板目录
		if (!defined('THEME_COMPILE_ROOT_PATH')) define('THEME_COMPILE_ROOT_PATH', DATA_CACHE_ROOT_PATH.'/cache/'.$user_theme);//模板的缓存目录
		if (!defined('THEME_LEFT_DELIMITER')) define('THEME_LEFT_DELIMITER', '{-');
		if (!defined('THEME_RIGHT_DELIMITER')) define('THEME_RIGHT_DELIMITER', '-}');//模板语法标签

		if(!is_dir(THEME_COMPILE_ROOT_PATH)) mkdir(THEME_COMPILE_ROOT_PATH,0777,true); //判断模板缓存目录是否存在
		$tpl	= new \Lib\smarty\Smarty();
		$tpl->template_dir		= THEME_ROOT_PATH;
		$tpl->compile_dir		= THEME_COMPILE_ROOT_PATH;
		$tpl->left_delimiter	= THEME_LEFT_DELIMITER;
		$tpl->right_delimiter	= THEME_RIGHT_DELIMITER;
		
		$tpl->assign('root_url', ROOT_URL);
		$tpl->assign('css_path', CSS_PATH);
		$tpl->assign('js_path', JS_PATH);
		$tpl->assign('img_path', IMG_PATH);
		$tpl->assign('themeRoot', THEME);
		
		
		if($_SERVER['REMOTE_ADDR']){
			$whiteList = \Config\WhiteListConfig::$whiteList;
			if(in_array($_SERVER['REMOTE_ADDR'], $whiteList)){
				$tpl->assign('showCustom',1);
			}else{
				$tpl->assign('showCustom',0);
			}
		}
		
		$memberName = \Lib\Helper\CheckLogin::getMemberName();
		if($memberName){
			$tpl->assign('memberName',$memberName);
		}
		$memberIsadmin = \Lib\Helper\CheckLogin::memberIsadmin();
		if($memberIsadmin){
			$tpl->assign('memberIsadmin',$memberIsadmin);
		}
		//检查登录
		$memberId = \Lib\Helper\CheckLogin::check();
		if($memberId){
			$tpl->assign('isLogin',1);
			$tpl->assign('memberId',$memberId);
		}else{
			$tpl->assign('isLogin',0);
		}
		//用户数据在周二同步
		if (date('l',time())=='Tuesday') {
			$fp = fopen(ROOT_PATH."data/syncUser.log",'r');
			while(!feof($fp)){
	            $line = trim(fgets($fp));
	            if ( $line == date('Y-m-d l',time() )) {
	            	$hasSync=1;
	            }
	        }
			fclose($fp);
			if (!isset($hasSync)) {
				$meets = new \Model\meetingModel();
				$allSysUser = $meets->getAllUser();
				$allActivationUser=array('engOther'=>array(),'chinese'=>array());
				foreach ($allSysUser as $key => $value) {
					for ($i=0; $i <strlen($value['username']) ; $i++) { 
						if (ord($value['username'][$i])<160) {
							continue;
						}else{$chinese=1;}
					}
					if ( isset($chinese) && $chinese==1 ) {
						$allActivationUser['chinese'][]=$value;
					}else{$allActivationUser['engOther'][]=$value;}
				}
				// echo'<pre>';print_r($allActivationUser);die;
				// echo"<pre>";var_dump(\Lib\Helper\stringHelper::GetPinyin('瑶',0)); die;
				foreach ($allActivationUser['engOther'] as $key => $value) {
					$allActivationUser['engOther'][$key]['pinyin']='';
				}foreach ($allActivationUser['chinese'] as $key => $value) {
					$allActivationUser['chinese'][$key]['pinyin']=\Lib\Helper\stringHelper::GetPinyin($value['username']);
				}
				$fp = fopen(ROOT_PATH."data/syncUser.log",'a');
				fwrite($fp, date('Y-m-d l',time() )."\r\n");
				fwrite($fp, date('Y-m-d H:i:s l',time() )."\r\n");
				foreach ($allActivationUser as $key => $value) {
					foreach ($value as $k => $v) {
						$isHad=$meets->getSysUser($v['username'],$v['uid']);
						if (!$isHad) {
							$meets->syncUser($v);
							fwrite($fp, $v['uid'].' '.$v['username'].' '.$v['pinyin'].' '.$v['email']."\r\n");
						}
					}
				}
				fwrite($fp, "\r\n\r\n");
				fclose($fp);
			}
		}


		$tpl->assign('module',\Lib\helper\RequestUnit::getParams('module'));
		$tpl->assign('action',\Lib\helper\RequestUnit::getParams('action'));
		return self::$smarty = $tpl; 
	}
	
	//后台smarty
	public static function getAdminSmarty(){
		if(self::$smarty instanceof \Lib\smarty\Smarty){
			return self::$smarty;
		}
		$user_theme = 'admindefault';
		if(!defined('ADMINTHEME')) define('ADMINTHEME',ADMIN_PATH.'theme/');
		if (!defined('THEME_ROOT_PATH')) define('THEME_ROOT_PATH', ADMINTHEME . 'default/');//模板目录
		if (!defined('THEME_COMPILE_ROOT_PATH')) define('THEME_COMPILE_ROOT_PATH', DATA_CACHE_ROOT_PATH.'/cache/'.$user_theme);//模板的缓存目录
		if (!defined('THEME_LEFT_DELIMITER')) define('THEME_LEFT_DELIMITER', '{-');
		if (!defined('THEME_RIGHT_DELIMITER')) define('THEME_RIGHT_DELIMITER', '-}');//模板语法标签
		
		if(!is_dir(THEME_COMPILE_ROOT_PATH)) mkdir(THEME_COMPILE_ROOT_PATH,0777,true); //判断模板缓存目录是否存在
		
		$tpl	= new \Lib\smarty\Smarty();
		$tpl->template_dir		= THEME_ROOT_PATH;
		$tpl->compile_dir		= THEME_COMPILE_ROOT_PATH;
		$tpl->left_delimiter	= THEME_LEFT_DELIMITER;
		$tpl->right_delimiter	= THEME_RIGHT_DELIMITER;
		
		$tpl->assign('root_url', ROOT_URL);
		$tpl->assign('admin_url', ADMIN_URL);
		$tpl->assign('themeRoot', ADMINTHEME);
		$tpl->assign('staticUrl', ADMIN_URL.'static/');
		
		return self::$smarty = $tpl; 
	}
}
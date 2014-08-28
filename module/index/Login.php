<?php
namespace Module\Index;
/**
 * 登录
 * @author oliver
 *
 */
class Login extends \Lib\Application {	
	public function run(){
		/*$memberId = \Lib\Helper\CheckLogin::check();
		if($memberId){
			header('LOCATION:'.ROOT_URL);
			exit;
		}*/
		$client = \Lib\Helper\CheckLogin::sso();
		if(!empty($client) && is_array($client)){
			$userName = $client['username'];
			$userId = $client['uid'];
			$_SESSION[SESSION_PREFIX.'userName'] = $userName;
			$_SESSION[SESSION_PREFIX.'memberId'] = $userId;
			$_SESSION[SESSION_PREFIX.'login'] = true;
			$mIndex = new \Model\IndexModel();
			$memberInfo = $mIndex->getMember($userName);
			if(!empty($memberInfo) && $memberInfo['username']==$userName){
				$_SESSION[SESSION_PREFIX.'admin'] = $memberInfo['isadmin'];					
			}
			/*else{
				unset($_SESSION['phpCAS']);
				unset($client);
				$this->alert_forward('无权限',ROOT_URL.'logout.html',1);exit;
			}*/
			header('LOCATION:'.ROOT_URL);
					exit;
		}








		//$param = \Lib\Helper\RequestUnit::getParams();
		//$status = isset($param->status) ? $param->status : '';
		//$autoLogin = new \Lib\Helper\AutoLogin();
		//if($status == 'success'){
		//	$autoLogin->autoLogin();
		//}
		
		//if(empty($_SESSION[SESSION_PREFIX.'login'])){
			//自动登录没有获取到信息,直接跳转到sso系统去登录
		//	header('LOCATION:'.SSO_URL . 'index/index-forward-'.base64_encode(\Lib\Helper\RequestUnit::getUrl(false)).'.html');
		//	exit;
		//}else{
		//	$forward = $param->params['forward'];
		//	$forwardUrl =  !empty($forward) ? urldecode( base64_decode($forward)) : ROOT_URL;
		//	header('LOCATION:'.$forwardUrl);
		//	exit;
		//}
		
		/*$tpl = \Lib\Template::getSmarty();
		$param = \Lib\Helper\RequestUnit::getParams();
		$verifycode = isset($param->verifycode) ? $param->verifycode : '' ;
		$act = isset($param->act) ? $param->act : '';
		$forward = $param->params['forward'];
		if(!empty($param->formsubmmit) && $param->formsubmmit==1){
			$verifycode = strtolower($verifycode);
			$forwardUrl =  !empty($forward) ? urldecode( base64_decode($forward)) : ROOT_URL;
			$redriectUrl = !empty($forward) ? ROOT_URL . 'index/login-forward-' . $forward .'.html' : '';
				if (!empty($_SESSION['captcha'][$act]) && $verifycode == $_SESSION['captcha'][$act] ){
					$userName = $param->username;
					$password = $param->password;
					$password = md5($password.MD5_pass);
					$mIndex = new \Model\IndexModel();
					$memberInfo = $mIndex->getMember($userName,$password);
					if(!empty($memberInfo) && $memberInfo['username']==$userName){
							$_SESSION[SESSION_PREFIX.'username'] = $userName;
							$_SESSION[SESSION_PREFIX.'memberId'] = $memberInfo['uid'];
							$_SESSION[SESSION_PREFIX.'login'] = true;
							header('LOCATION:'.$forwardUrl);
							exit;
					}
					
					$this->alert_forward('用户名或密码错误',$redriectUrl,1);
				}else{
					$this->alert_forward('验证码错误',$redriectUrl,1);
				}
		} 
		$tpl->display('login.htm');*/
		
	}
}
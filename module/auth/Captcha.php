<?php
namespace Module\Auth;
/**
 * 验证码生成和设置类
 */
class Captcha extends \Lib\Application{
	public function run(){
		if(isset(self::$requestParams->act))
		{
			$act = self::$requestParams->act;
		}
		else
		{
			$act = 'reg';
		}
		header("Content-type: image/png");
		//$captchaStr = \Lib\Image::getCaptcha();		
		$captchaStr = \Lib\Image::getMathCaptcha();
		$_SESSION['captcha'][$act] = $captchaStr;						 
	}
}
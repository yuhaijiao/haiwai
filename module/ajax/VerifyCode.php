<?php
namespace Module\Ajax;
use \Lib\Helper\RequestUnit as R;
/**
 * 验证码检测
 * @author Jerry Yang<yang.tao.php@gmail.com>
 * @sinc 2011-12-8
 */
class VerifyCode extends \Lib\Application{
    public function run(){
		// -------------发表评论评价：是否有帮助--------------
		 $act=trim(R::getParams('act'));
		 $VCode=trim(R::getParams('code'));
		 if (!isset($_SESSION['captcha'][$act]) || $VCode != $_SESSION['captcha'][$act] ){
		 	die('0');
		 }else{
		 	die('1');
		 }
    }
}
<?php
namespace Lib\Helper;
/**
*发送邮件
*@author chengjun<chengjun@milanoo.com>
*
*/
class SendMail {
	public function sendmail($mailArray){
		$emailTemplateRoot = THEME_ROOT_PATH.'mail/';
		$emailHost = 'milanoo1@163.com';
		$emailTitle = 'imayx';
		if(isset($mailArray['theme'])){
			include $emailTemplateRoot . $mailArray['theme'];
		}
		if(isset($mailArray['mail'])){
			$emailTo = $mailArray['mail'];
		}
		$data = array('from'=>$emailHost,'to'=>$emailTo,'subject'=>isset($mailArray['emailtitle'])?$mailArray['emailtitle']:$emailTitle,'content'=>$emailLR);
		$mail = new \Lib\Mail();
		//链接服务器
		$status = $mail->connect();
		if($status){
			//链接成功
			$sendStatus = $mail->sendMail($data['from'], $data['to'], $data['subject'], $data['content'],1);
			if($sendStatus){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
		
	}
	
}
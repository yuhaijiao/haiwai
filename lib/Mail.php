<?php
namespace Lib;
/**
 * 邮件发送核心处理
 * @author oliver <chengjun@milanoo.com>
 *
 */

class Mail {
	
	/**
	 * 邮件服务器地址
	 * @var unknown
	 */
	public $SMTP_SERVER = 'smtp.163.com';

  /**
   *  SMTP服务端口
   *  @var int
   */
  public $SMTP_PORT = 25;

  /**
   *  SMTP 支持的换行符
   *  @var string
   */
  public $CRLF = "\r\n";
  
  /**
   *  设置错误输出等级，0不输出
   *  @var int
   */
  public $do_debug=0;      
  
  /**
   * 设置错误输出方式
   * @var string
   */
  public $Debugoutput     = "echo";
  
  /**
   * 是否进行帐号验证
   * @var boolean
   */
  public $smtpAuth = true;
  
  /**
   * 邮件编码
   * @var string
   */
  public $charSet = 'UTF-8';
  
  /**
   * 服务器验证帐号
   * @var string
   */
  public $mailUser = MAIL_AUTH_USERNAME;
  
  /**
   * 服务器验证密码
   * @var string
   */
  public $mailPsd = MAIL_AUTH_PSD;
  
  /**
   * @var resource The socket to the server
   */
  private $smtp_conn;
  
  /**
   * 超时时间
   * @var unknown
   */
  private $Timeout = 35;
  
  /**
   * 链接持久时间
   * @var unknown
   */
  private $Timelimit = 30;
  
  /**
   * @var string Error message, if any, for the last call
   */
  private $error;
  
  /**
   * hello返回信息
   * @var unknown
   */
  private $help_rply;
  
  /**
   * 输出错误
   * @param unknown $str
   */
  private function edebug($str) {
  	if ($this->Debugoutput == "error_log") {
  		error_log($str);
  	} else {
  		echo $str;
  	}
  }
  
  /**
   * 初始化
   */
  public function __construct(){
  	$this->smtp_conn = 0;
  	$this->error = null;
  	$this->help_rply = null;
  }
  
  /**
   * 连接邮件服务器
   * @param unknown $host
   * @param number $port
   * @param number $tval
   * @return boolean
   */
  public function connect($host='', $port = 0, $tval = 30){
  	$this->error = null;
  	if($this->connected()) {
  		// 已经链接了服务器，返回错误
  		$this->error = array("error" => "Already connected to a server");
  		return false;
  	}
  	if(empty($host)){
  		$host = $this->SMTP_SERVER;
  	}
  	if($port === 0){
  		$port = $this->SMTP_PORT;
  	}
  	// 链接服务器
  	$this->smtp_conn = @fsockopen($host,    // 服务器地址
  			$port,    // 服务器端口
  			$errno,   // 错误号
  			$errstr,  // 错误信息
  			$tval);   // 超时时间
  	// 验证链接是否正确
  	if(empty($this->smtp_conn)) {
  		$this->error = array("error" => "Failed to connect to server",
  				"errno" => $errno,
  				"errstr" => $errstr);
  		if($this->do_debug >= 1) {
  			$this->edebug("SMTP -> ERROR: " . $this->error["error"] . ": $errstr ($errno)" . $this->CRLF . '<br />');
  		}
  		return false;
  	}
  	// SMTP 服务器保持持久链接，设置不超时
  	// Windows 不支持
  	if(substr(PHP_OS, 0, 3) != "WIN") {
  		$max = ini_get('max_execution_time');
  		if ($max != 0 && $tval > $max) {
  			@set_time_limit($tval);
  		}
  		stream_set_timeout($this->smtp_conn, $tval, 0);
  	}
  	
	/*
	 * 等待服务器返回信息
	 */
  	$announce = $this->get_lines();
  	
  	if($this->do_debug >= 2) {
  		$this->edebug("SMTP -> FROM SERVER:" . $announce . $this->CRLF . '<br />');
  	}
  	
  	/*
  	 * 开始验证
  	 */
  	if($this->smtp_conn && $this->smtpAuth){
  		$this->Auth();
  	}
  	
  	return true;
  }
  
  /**
   *发送过程
   */
  public function sendMail($from,$to,$subject,$msg_data,$htmlType=0,$charSet='utf-8', $contenType='text/plain'){
  	$this->error = null;//清空报错信息
  	//****开始发送邮箱验证*****
  	if(!$this->Connected()){
  		$this->error = array(
  				'error' => '未连接SMTP服务器'
  				);
  		return false;
  	}
  	
  	fputs($this->smtp_conn,"MAIL FROM:<" . $from . ">" . $this->CRLF);
  	
  	$rply = $this->get_lines();
  	$code = substr($rply,0,3);
  	if($this->do_debug >= 2) {
      $this->edebug("SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />');
    }
    if($code != 250) {
    	$this->error =
    	array("error" => "MAIL not accepted from server",
    			"smtp_code" => $code,
    			"smtp_msg" => substr($rply,4));
    	if($this->do_debug >= 1) {
    		$this->edebug("SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />');
    	}
    	return false;
    }
    //****结束发送邮箱验证*****
    
    //****开始接收邮箱验证*****
    if(!$this->connected()) {
    	$this->error = array(
    			"error" => "未连接SMTP服务器");
    	return false;
    }
    
    $toMailArray = explode(';',$to);
    $haveCheck = array();
    $sendFalse = array();
    if(!empty($toMailArray)){
    	foreach ($toMailArray as $toMail){
    		fputs($this->smtp_conn,"RCPT TO:<" . $toMail . ">" . $this->CRLF);
    		
    		$rply = $this->get_lines();
    		$code = substr($rply,0,3);
    		if($this->do_debug >= 2) {
    			$this->edebug("SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />');
    		}
    		if($code != 250 && $code != 251) {
    			$this->error =
    			array("error" => "RCPT not accepted from server",
    					"smtp_code" => $code,
    					"smtp_msg" => substr($rply,4));
    			if($this->do_debug >= 1) {
    				$this->edebug("SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />');
    			}
    			$sendFalse = $toMail;
    			continue;
    		}else{
    			$haveCheck[] = $toMail;
    		}
    	}
    }
    if(empty($haveCheck)){
    	$this->error = array(
    			"error" => "所有接收邮箱验证失败");
    	if(!empty($sendFalse)){
    		return $sendFalse;
    	}else{
    		return false;
    	}
    }
    //****结束接收邮箱验证*****
    
    //****开始发送数据*****
    if(!$this->connected()) {
    	$this->error = array(
    			"error" => "未连接SMTP服务器");
    	return false;
    }
    
    fputs($this->smtp_conn,"DATA" . $this->CRLF);
    
    $rply = $this->get_lines();
    $code = substr($rply,0,3);
    
    if($this->do_debug >= 2) {
    	$this->edebug("SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />');
    }
    
    if($code != 354) {
    	$this->error =
    	array("error" => "DATA command not accepted from server",
    			"smtp_code" => $code,
    			"smtp_msg" => substr($rply,4));
    	if($this->do_debug >= 1) {
    		$this->edebug("SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />');
    	}
    	return false;
    }
    //开始推送数据了
    //先格式化数据
    
    if($htmlType == 1){
    	$contenType = 'text/html';
    }
    
    $header = "Date: ".Date("r"). $this->CRLF;
    $header .= "From: ".$from . $this->CRLF;
    $header .= "To: ".$to. $this->CRLF;
    
    $header .= "Subject:".$subject.$this->CRLF;
    $header .= "Mime-Version: 1.0" . $this->CRLF;
    $header .= "Content-Type: ".$contenType."; charset=".$charSet.";".$this->CRLF;
    $header .= "Content-Transfer-Encoding: base64".$this->CRLF;
    
    $header .= $this->CRLF.base64_encode($msg_data).$this->CRLF;
    fputs($this->smtp_conn,$header);
    //****结束发送数据*****
    
    //信息发送完毕,必须以点结尾
    fputs($this->smtp_conn, $this->CRLF . "." . $this->CRLF);
    
    $rply = $this->get_lines();
    $code = substr($rply,0,3);
    
    if($this->do_debug >= 2) {
    	$this->edebug("SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />');
    }
    
    if($code != 250) {
    	$this->error =
    	array("error" => "DATA not accepted from server",
    			"smtp_code" => $code,
    			"smtp_msg" => substr($rply,4));
    	if($this->do_debug >= 1) {
    		$this->edebug("SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />');
    	}
    	return false;
    }
    
    //****关闭链接*****
    if(!$this->connected()) {
    	$this->error = array(
    			"error" => "未连接SMTP服务器");
    	return false;
    }
    
    fputs($this->smtp_conn,"quit" . $this->CRLF);
    
    $byemsg = $this->get_lines();
    
    if($this->do_debug >= 2) {
    	$this->edebug("SMTP -> FROM SERVER:" . $byemsg . $this->CRLF . '<br />');
    }
    
    $rval = true;
    $e = null;
    
    $code = substr($byemsg,0,3);
    if($code != 221) {
    	$e = array("error" => "SMTP server rejected quit command",
    			"smtp_code" => $code,
    			"smtp_rply" => substr($byemsg,4));
    	$rval = false;
    	if($this->do_debug >= 1) {
    		$this->edebug("SMTP -> ERROR: " . $e["error"] . ": " . $byemsg . $this->CRLF . '<br />');
    	}
    }
    
    $this->Close();
    
    return $rval;
    
  }
  
  /**
   * 验证服务器帐号
   */
  private function Auth($authtype='LOGIN'){
  	if($this->connected()) {
  		if(!empty($this->smtp_conn)){
  			if(empty($authtype)){
  				$authtype = 'LOGIN';
  			}
  			//发送招呼
  			if(!$this->sendHello('HELO')){
  				if(!$this->sendHello('EHLO')){
  					return false;
  				}
  			}
  			switch ($authtype){
  				case 'LOGIN':
  					//发送验证请求
  					fputs($this->smtp_conn,"AUTH LOGIN" . $this->CRLF);
  					$rply = $this->get_lines();
  					$code = substr($rply,0,3);
  					if($code != 334){
  						$this->error =
  						array("error" => "AUTH not accepted from server",
  								"smtp_code" => $code,
  								"smtp_msg" => substr($rply,4));
  						if($this->do_debug >= 1) {
  							$this->edebug("SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />');
  						}
  						return false;
  					}
  					//发送用户名
  					fputs($this->smtp_conn, base64_encode($this->mailUser) . $this->CRLF);
  					$rply = $this->get_lines();
  					$code = substr($rply,0,3);
  					if($code != 334){
  						$this->error =
  						array("error" => "username not accepted from server",
  								"smtp_code" => $code,
  								"smtp_msg" => substr($rply,4));
  						if($this->do_debug >= 1) {
  							$this->edebug("SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />');
  						}
  						return false;
  					}
  					//发送密码
  					fputs($this->smtp_conn, base64_encode($this->mailPsd) . $this->CRLF);
  					$rply = $this->get_lines();
  					$code = substr($rply,0,3);
  					if($code != 235) {
  						$this->error =
  						array("error" => "Password not accepted from server",
  								"smtp_code" => $code,
  								"smtp_msg" => substr($rply,4));
  						if($this->do_debug >= 1) {
  							$this->edebug("SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />');
  						}
  						return false;
  					}
  					break;
  			}
  			return true;
  		}
  	}
  }
  
  private function sendHello($helo){
  	if(!$this->Connected()){
  		$this->error = array(
  				"error" => "without being connected");
  		return false;
  	}
  	//发送招呼
  	fputs($this->smtp_conn, $helo." localhost\r\n");
  	$rply = $this->get_lines();
  	$code = substr($rply,0,3);
  	if($code != 250){
  		$this->error =
  		array("error" => "{$helo} not accepted from server",
  				"smtp_code" => $code,
  				"smtp_msg" => substr($rply,4));
  		if($this->do_debug >= 1) {
  			$this->edebug("SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />');
  		}
  		return false;
  	}
  	$this->helo_rply = $rply;
  	return true;
  }
  
  /**
   * 检查链接
   * @access public
   * @return bool
   */
  private function Connected() {
  	if(!empty($this->smtp_conn)) {
  		$sock_status = socket_get_status($this->smtp_conn);
  		if($sock_status["eof"]) {
  			// 没有链接
  			if($this->do_debug >= 1) {
  				$this->edebug("SMTP -> NOTICE:" . $this->CRLF . "EOF caught while checking if connected");
  			}
  			$this->Close();
  			return false;
  		}
  		return true; 
  	}
  	return false;
  }
  
  public function Close() {
  	$this->error = null; // 清空
  	$this->helo_rply = null;
  	if(!empty($this->smtp_conn)) {
  		// 关闭链接
  		fclose($this->smtp_conn);
  		$this->smtp_conn = 0;
  	}
  }
  
  /**
   * 服务器返回信息
   * 持续等待服务器返回信息，以保证在服务器完整的返回响应后再进行下一步操作
   * @return string|Ambigous <string, unknown>
   */
  private function get_lines(){
  	$data = "";
  	$endtime = 0;
  	if(!is_resource($this->smtp_conn)){
  		return $data;
  	}
  	stream_set_timeout($this->smtp_conn, $this->Timeout);
  	if ($this->Timelimit > 0) {
  		$endtime = time() + $this->Timelimit;
  	}
  	while(is_resource($this->smtp_conn) && !feof($this->smtp_conn)) {
  		$str = @fgets($this->smtp_conn,515);
  		if($this->do_debug >= 4) {
  			$this->edebug("SMTP -> get_lines(): \$str is \"$str\"" . $this->CRLF . '<br />');
  		}
  		$data .= $str;
  		if($this->do_debug >= 4) {
  			$this->edebug("SMTP -> get_lines(): \$data is \"$data\"" . $this->CRLF . '<br />');
  		}
  		// if 4th character is a space, we are done reading, break the loop
  		if(substr($str,3,1) == " ") { break; }
  		// Timed-out? Log and break
  		$info = stream_get_meta_data($this->smtp_conn);
  		if ($info['timed_out']) {
  			if($this->do_debug >= 4) {
  				$this->edebug("SMTP -> get_lines(): timed-out (" . $this->Timeout . " seconds) <br />");
  			}
  			break;
  		}
  		// Now check if reads took too long
  		if ($endtime) {
  			if (time() > $endtime) {
  				if($this->do_debug >= 4) {
  					$this->edebug("SMTP -> get_lines(): timelimit reached (" . $this->Timelimit . " seconds) <br />");
  				}
  				break;
  			}
  		}
  	}
  	return $data;
  }
  
}
<?php
namespace App;
/**
 * ssh链接类
 * @author oliver
 *
 */
class Ssh {
	/**
	 * ssh地址
	 * @var unknown
	 */
	private $ssh_host = '192.168.11.75';
	
	/**
	 * ssh端口
	 * @var unknown
	 */
	private $ssh_port = 22;
	
	/**
	 *
	 * @var 链接SESSION
	 */
	private $ssh_server_fp = '';
	
	/**
	 * ssh登录名
	 * @var unknown
	 */
	private $ssh_auth_user = 'root';
	
	/**
	 * ssh公钥地址
	 * @var unknown
	 */
	private $ssh_auth_pub = '';
	
	/**
	 * ssh私钥地址
	 * @var unknown
	 */
	private $ssh_auth_priv = '';
	
	/**
	 * ssh登录密码
	 * @var unknown
	 */
	private $ssh_auth_pass = 'milanoo-admin';
	
	/**
	 * shell类型
	 * @var unknown
	 */
	private $shellType = 'vt102';
	
	/**
	 * 验证类型
	 * @var unknown
	 */
	private $veryType = 'password';
	
	/**
	 * shell链接
	 * @var unknown
	 */
	private $shell = '';
	
	/**
	 * ssh链接池
	 * @var unknown
	 */
	private $ssh_Connect;
	
	/**
	 * 返回最后一次操作错误记录
	 * @var unknown
	 */
	private $error_log = '';
	
	public function errorMsg(){
		return $this->error_log;
	}
	
	/**
	 * 检查是否已经链接
	 * 没有链接的话重新链接
	 * @return boolean
	 */
	public function isConnected(){
		if(!$this->ssh_Connect){
			$this->disconnect();
			$this->connectSsh();
			return true;
		}else{
			return true;
		}
	}
	
	/**
	 * 检查是否已经打开shell
	 * 没有打开则立即打开一个shell
	 * @return boolean
	 */
	public function isOpenShell(){
		if(!$this->shell){
			$this->openShell();
		}else{
			return true;
		}
	}
	
	public function __construct(){
		$this->connectSsh();
	}
	
	/**
	 * 打开SSH链接
	 * @param unknown $host
	 * @param string $port
	 * @param string $methods
	 * @param unknown $callbacks
	 * @return boolean
	 */
	private function connectSsh($methods='',$callbacks=array()){
		if(!empty($this->ssh_host)){
			$this->ssh_Connect = ssh2_connect($this->ssh_host,$this->ssh_port);
			if(!$this->ssh_Connect){
				$this->error_log = '打开服务器失败';
				return false;
			}else{
				switch ($this->veryType){
					case 'password':
						$this->authPassword();
						break;
				}
				return true ;
			}
		}
	}
	
	/**
	 * 验证登录
	 * @param unknown $user
	 * @param unknown $pass
	 * @return boolean
	 */
	public function authPassword(){
		$user = $this->ssh_auth_user;
		$pass = $this->ssh_auth_pass;
		if(ssh2_auth_password($this->ssh_Connect, $user, $pass)){
			return true;
		}else{
			$this->error_log = '用户名或密码验证失败';
			return false;
		}
	}
	
	/**
	 * 用公钥登录
	 * @param string $pubkey
	 * @param string $prikey
	 * @param string $user
	 * @param string $pass
	 * @return boolean
	 */
	public function authPubkey(){
		$pubkey = $this->ssh_auth_pub;
		$prikey = $this->ssh_auth_priv;
		$user = $this->ssh_auth_user;
		$pass = $this->ssh_auth_pass; 
		if(ssh2_auth_pubkey_file($this->ssh_Connect,$user,$pubkey,$prikey,$pass)){
			return true;
		}else{
			$this->error_log = '公钥验证失败';
		}
	}
	
	/**
	 * 获取链接SESSION
	 */
	public function getFingerprint(){
		$fingerprint = ssh2_fingerprint($this->ssh_Connect, SSH2_FINGERPRINT_MD5 | SSH2_FINGERPRINT_HEX);
		$saveFolder = dirname(__FILE__) .'/knowhost/';
		$saveFile = $this->ssh_host.md5($this->ssh_host.$this->ssh_port.$this->ssh_auth_user.$this->ssh_auth_pass);
		//读取并验证
		if(file_exists($saveFolder.$saveFile)){
			$tempFp = file_get_contents($saveFolder.$saveFile);
			if(!strcmp($tempFp, $fingerprint)){
				$this->error_log = 'session验证失败';
			}
		}else{
		//存储
			file_put_contents($saveFolder.$saveFile, $fingerprint);
		}
		return true;
	}
	
	/**
	 * 打开shell
	 * @param string $shellType
	 * @return boolean
	 */
	public function openShell(){
		$shellType = $this->shellType;
		$this->shell = ssh2_shell($this->ssh_Connect,$this->shellType,null,80,24,SSH2_TERM_UNIT_CHARS);
		if(!$this->shell){
			$this->error_log = 'shell打开失败';
			return false;
		}else{
			sleep ( 1 );
			//stream_set_blocking( $this->shell, true );
			return $this->shell;
		}
	}
	
	/**
	 * 在shell执行命令
	 * @param string $command
	 */
	public function writeShell($command=''){
		fwrite($this->shell, $command."\r\n");
		sleep ( 1 );
	}
	
	/**
	 * 获取结果
	 * @return string
	 */
	public function getShellBuf(){
		$buf = '';
		while($data = fgets($this->shell,4096)){
			$buf .= $data;
		} 
		return $buf;
	}
	
	/**
	 * 执行command
	 * 自动捕获参数
	 * @return string
	 */
	public function cmdExec(){
		$argc = func_num_args();
		$argv = func_get_args();
		$cmd = '';
		for($i=0;$i<$argc;$i++){
			if($i != ($argc-1)){
				$cmd .= $argv[$i].' && ';
			}else{
				$cmd .= $argv[$i];
			}
		}
		if(!$this->ssh_Connect){
			return false;
		}
		if($stream = ssh2_exec($this->ssh_Connect, $cmd)){
			$errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
			stream_set_blocking($errorStream, true);
			stream_set_blocking( $stream, true );
			$content = stream_get_contents($stream);
			$error = stream_get_contents($errorStream);
			if(!empty($error)){
				$this->error_log = $error;
			}
			return $content;
		}
	}
	
	/**
	 * 断开链接
	 */
	public function disconnect(){
		if($this->shell){
			$this->writeShell('exit');
			fclose($this->shell);
		}else{
			$this->cmdExec('exit');
		}
		$this->ssh_Connect = NULL;
		return;
	}
	
}
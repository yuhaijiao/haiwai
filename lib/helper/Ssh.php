<?php
namespace Lib\Helper;
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
	private static $ssh_host = \Config\SshConfig::SSHDOMAIN;
	
	/**
	 * ssh端口
	 * @var unknown
	 */
	private static $ssh_port = \Config\SshConfig::SSHPORT;
	
	/**
	 *
	 * @var 链接SESSION
	 */
	private static $ssh_server_fp = '';
	
	/**
	 * ssh登录名
	 * @var unknown
	 */
	private static $ssh_auth_user = \Config\SshConfig::USERNAME;
	
	/**
	 * ssh公钥地址
	 * @var unknown
	 */
	private static $ssh_auth_pub = \Config\SshConfig::PUBKEY;
	
	/**
	 * ssh私钥地址
	 * @var unknown
	 */
	private static $ssh_auth_priv = \Config\SshConfig::PRIVATEKEY;
	
	/**
	 * ssh登录密码
	 * @var unknown
	 */
	private static $ssh_auth_pass = \Config\SshConfig::PASSWORD;
	
	/**
	 * shell类型
	 * @var unknown
	 */
	private static $shellType = \Config\SshConfig::SHELLTYPE;
	
	/**
	 * 验证类型
	 * @var unknown
	 */
	private static $veryType = \Config\SshConfig::VERYTYPE;
	
	/**
	 * shell链接
	 * @var unknown
	 */
	private static $shell = '';
	
	/**
	 * ssh链接池
	 * @var unknown
	 */
	private static $ssh_Connect;
	
	/**
	 * 返回最后一次操作错误记录
	 * @var unknown
	 */
	private static $error_log = '';
	
	public static function errorMsg(){
		return self::error_log;
	}
	
	/**
	 * 检查是否已经链接
	 * 没有链接的话重新链接
	 * @return boolean
	 */
	public static function isConnected(){
		if(!self::$ssh_Connect){
			self::disconnect();
			self::connectSsh();
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
	public static function isOpenShell(){
		if(!self::$shell){
			self::openShell();
		}else{
			return true;
		}
	}
	
	/**
	 * 打开SSH链接
	 * @param unknown $host
	 * @param string $port
	 * @param string $methods
	 * @param unknown $callbacks
	 * @return boolean
	 */
	private static function connectSsh($methods='',$callbacks=array()){
		if(!empty(self::$ssh_host)){
			self::$ssh_Connect = ssh2_connect(self::$ssh_host,self::$ssh_port);
			if(!self::$ssh_Connect){
				self::$error_log = '打开服务器失败';
				return false;
			}else{
				switch (self::$veryType){
					case 'password':
						self::authPassword();
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
	public static function authPassword(){
		$user = self::$ssh_auth_user;
		$pass = self::$ssh_auth_pass;
		if(ssh2_auth_password(self::$ssh_Connect, $user, $pass)){
			return true;
		}else{
			self::$error_log = '用户名或密码验证失败';
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
	public static function authPubkey(){
		$pubkey = self::$ssh_auth_pub;
		$prikey = self::$ssh_auth_priv;
		$user = self::$ssh_auth_user;
		$pass = self::$ssh_auth_pass; 
		if(ssh2_auth_pubkey_file(self::$ssh_Connect,$user,$pubkey,$prikey,$pass)){
			return true;
		}else{
			self::$error_log = '公钥验证失败';
		}
	}
	
	/**
	 * 获取链接SESSION
	 */
	public static function getFingerprint(){
		$fingerprint = ssh2_fingerprint(self::$ssh_Connect, SSH2_FINGERPRINT_MD5 | SSH2_FINGERPRINT_HEX);
		$saveFolder = ROOT_PATH .'data/knowhost/';
		$saveFile = self::$ssh_host.md5(self::$ssh_host.self::$ssh_port.self::$ssh_auth_user.self::$ssh_auth_pass);
		//读取并验证
		if(file_exists($saveFolder.$saveFile)){
			$tempFp = file_get_contents($saveFolder.$saveFile);
			if(!strcmp($tempFp, $fingerprint)){
				self::$error_log = 'session验证失败';
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
	public static function openShell(){
		$shellType = self::$shellType;
		self::$shell = ssh2_shell(self::$ssh_Connect);
		if(!self::$shell){
			self::$error_log = 'shell打开失败';
			return false;
		}else{
			sleep ( 1 );
			//stream_set_blocking( self::$shell, true );
			return self::$shell;
		}
	}
	
	/**
	 * 在shell执行命令
	 * @param string $command
	 */
	public static function writeShell($command=''){
		fwrite(self::$shell, $command.PHP_EOL);
		sleep ( 1 );
	}
	
	/**
	 * 获取结果
	 * @return string
	 */
	public static function getShellBuf(){
		$buf = '';
		while($data = fgets(self::$shell,4096)){
			$buf .= $data;
		} 
		return $buf;
	}
	
	/**
	 * 执行command
	 * 自动捕获参数
	 * @return string
	 */
	public static function cmdExec(){
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
		if($stream = ssh2_exec(self::$ssh_Connect, $cmd)){
			$errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
			stream_set_blocking($errorStream, true);
			stream_set_blocking( $stream, true );
			$content = stream_get_contents($stream);
			$error = stream_get_contents($errorStream);
			if(!empty($error)){
				self::$error_log = $error;
			}
			return $content;
		}
	}
	
	/**
	 * 断开链接
	 */
	public static function disconnect(){
		if(self::$shell){
			self::writeShell('exit');
			fclose(self::$shell);
		}else{
			self::cmdExec('exit');
		}
		self::$ssh_Connect = NULL;
	}
	
}
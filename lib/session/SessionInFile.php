<?php
namespace Lib\Session;

/**
 * SESSION保存进文件
 * @author oliver
 *
 */
class SessionInFile {
	/**
	 * session存储路径
	 * @var unknown
	 */
	private $savePath;
	public function __construct(){
		ini_set('session.save_handler', 'files');
		session_save_path(DATA_CACHE_ROOT_PATH.'session/');
		session_set_save_handler(
			array($this,'openSession'), 
			array($this,'close'), 
			array($this,'read'), 
			array($this,'write'), 
			array($this,'destroy'), 
			array($this,'gc')
		);
		session_name(SESSION_NAME);
		session_start();
	}
	
	/**
	 * 重新初始化一个已存在的session，或者创建一个新的session
	 * @param string $save_path
	 * @param string $name
	 */
	public function openSession($save_path,$name){
		$this->savePath = $save_path;
		if(!is_dir($this->savePath)){
			mkdir($this->savePath,0777);
		}
		return true;
	}
	
	/**
	 * 读取session值
	 * @param unknown $session_id
	 */
	public function read($session_id){
		return (string)@file_get_contents("$this->savePath/sess_{$session_id}");
	}
	
	/**
	 * 往session中写入内容
	 * @param unknown $session_id
	 * @param unknown $session_data
	 */
	public function write($session_id,$session_data){
		return file_put_contents("$this->savePath/sess_{$session_id}", $session_data) === false ? false : true;
	}
	
	/**
	 * 清理过期的session
	 * @param unknown $maxlifetime
	 */
	public function gc($maxlifetime ){
		foreach (glob("$this->savePath/sess_*") as $file) {
			if (filemtime($file) + $maxlifetime < time() && file_exists($file)) {
				unlink($file);
			}
		}
		
		return true;
	}
	
	/**
	 * 销毁一个session
	 * @param unknown $session_id
	 */
	public function destroy($session_id ){
		$file = "$this->savePath/sess_{$session_id}";
		if (file_exists($file)) {
			unlink($file);
		}
		
		return true;
	}
	
	/**
	 * 关闭当前session
	 */
	public function close(){
		return true;
	}
}
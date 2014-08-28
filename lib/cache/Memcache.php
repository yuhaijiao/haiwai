<?php
namespace Lib\Cache;
/**
 * 基于pecl提供的Memcache类扩展.
 * FileName:Memcache.php
 * @Author:chengjun <cgjp123@163.com>
 * @Since:2012-2-22
 */
 class Memcache extends \Memcache {
 	/**
     * Memcache 服务器地址
     * @var string
     */
    private $host='127.0.0.1';
    /**
     * Memcache 服务器端口
     * @var int
     */
    private $port=11211;
    /**
     * memcache连接超时时间     
     * @var int
     */
    private $connectTimeout=1;    
    
    /**
     * 是有使用持久连接
     * @var Boolean
     */
    private $persistent = false;
 	
 	public function __construct(){
 		static $servers = array();
    	static $ports = array();
 		if(defined('\Config\Memcache::HOST')){
 			$this->host = \Config\Memcache::HOST;
 		}
 		if(defined('\Config\Memcache::PORT')){
 			$this->port = \Config\Memcache::PORT;
 		}
 		if(defined('\Config\Memcache::CONNECTION_TIMEOUT')){
 			$this->connectTimeout = \Config\Memcache::CONNECTION_TIMEOUT;
 		}
 		if(defined('\Config\Memcache::PERSISTENT')){
 			$this->persistent = \Config\Memcache::PERSISTENT;
 		}
 		if(empty($servers)){
 			$servers = explode(',', $this->host);
 			$ports = explode(',', $this->port);
 			$port = empty($port) ? '11211' : current($ports);
 		}
 		
 		foreach($servers as $k=>$v){
 			if(isset($ports[$k])){
 				$port = $ports[$k];
 			}
 			$this->addServer($v, $port, $this->persistent,1,$this->connectTimeout,15,true,array($this,'logFailure'));
 		}
 	}
 	
 	public function logFailure($host,$tcpPort,$udpPort,$errMsg,$errNo){
 		error_log('Memcache出错:'."\t".$host.':'.$tcpPort."\t".$errNo.'-'.$errMsg);
 	}
 	public function __destruct()
 	{
 		$this->close();
 	}
 }
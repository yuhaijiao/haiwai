<?php
/**
 * 基于pecl提供的Redis类扩展
 * FileName:Redis.php
 * @Author:chengjun <cgjp123@163.com>
 * @Since:2012-2-22
 */
 class Redis extends \Redis {
 	
 	/**
	* Redis 服务器地址
	* @var string
	*/
	private $host='127.0.0.1';
	/**
	 * Redis 服务器端口
	 * @var int
	 */
	private $port=6379;
	/**
	 * Redis服务器连接超时时间
	 * @var int
	 */
	private $connectionTimeout=1;
	/**
	 * 
	 * 存储键名
	 * @var string
	 */
	private $key = '';
	
	public function __construct()
	{
		if(defined('\config\Redis::HOST'))
		{
			$this->host = \config\Redis::HOST;
		}
	
		if(defined('\config\Redis::PORT'))
		{
			$this->port = \config\Redis::PORT;
		}
	
		if(defined('\config\Redis::CONNECTION_TIMEOUT'))
		{
			$this->connectionTimeout = \config\Redis::CONNECTION_TIMEOUT;
		}		 
		$this->connect($this->host,$this->port,$this->connectionTimeout);
	}
	
	/**
	 * 设定键名
	 * @see Redis::setKey($key)
	 */
	public function setKey($key=''){
		if($key!==''){
			$this->key = $key;
			return true;
		}
		return false;
	}
	
	/**
	 * 获取当前键名
	 * @see Redis::getKey()
	 */
	public function getKey(){
		if(!$this->key){
			return $this->key;
		}
		return false;
	}
	
 	public function write($val){
		$this->rPush($this->key,$val);
		return true;
	}
	
	public function edit($index=0,$val){
		return $this->lSet($this->key,$index,$val);
	}
	
	public function readAll(){
		return $this->lRange($this->key,0,-1);
	}
	
	public function readLeft(){
		return $this->lRange($this->key,0,0);
	}
	
	public function readRight(){
		return $this->lRange($this->key,-1,-1);
	}
	
	public function readIndex($index=0){
		return $this->lIndex($this->key,$index);
	}
	
	public function deleteLeft(){
		return $this->lPop($this->key);
	}
	
	public function deleteRight(){
		return $this->rPop($this->key);
	}
	
	public function size(){
		return $this->lLen($this->key);
	}
	
	public function deleteAll(){
		return $this->del($this->key);
	}
 }
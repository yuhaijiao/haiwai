<?php
namespace Lib;
/**
 * 数据库管理
 * @author oliver <cgjp123@163.com>
 */
class Db{
	
	//是否使用永久连接
    protected $pconnect  = false;
    //数据库服务器地址
	protected $dbHost = array();
	//端口地址
	protected $port = array();
	//链接数据库用户名
	protected $dbUserName = array();
	//链接数据库密码
	protected $dbPassword = array();
	//数据表名
	protected $dbTableName = array();
	//当前链接ID
	protected $_linkID = array();
	//当前查询ID
	protected $queryID = null;
	//最后插入ID
	protected $lastInsID = null;
	//查询结果
	protected $queryResult = array();
	//结果集条数
	protected $numRows = 0;
	//错误
	protected $error = '';
	//连接成功标记
	protected $connected = false;
	// 事务指令数
    protected $transTimes = 0;
    
    protected $tag = '';
	
	/**
	 * 
	 * 加载数据库驱动
	 */
	public function loadDB($tag='local'){
		$sqlType = ucwords(strtolower(SQL_TYPE));
		$sqlType = '\Lib\Drive\\'.$sqlType;
		$this->tag = $tag;
		if(class_exists($sqlType)){
			$dataModel = new $sqlType($this->tag );
		}else{
			return false;
		}
		return $dataModel;
	}
	
	/**
	 * 
	 * 初始化数据连接
	 */
	protected function initConnect(){
		for($i=0,$n=count(\Config\Db::$mysqlConnection);$i<$n;$i++){
			$server = \Config\Db::$mysqlConnection[$i];  
			if($this->tag == $server['tag']){
				if(!$this->connected && $this->connected != $server['tag']) $this->_linkID[$server['tag']] = $this->connect();
				break;
			}
		}
	}
}
?>

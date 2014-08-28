<?php
namespace Lib\Drive;

/**
 * 把PDO封装起来，好用
 * @author oliver
 *
 */
class Pdomysql extends \Lib\Db {
	
	/**
	 * 全局配置
	 * @var unknown
	 */
	private $configParam = array();
	
	/**
	 * 存储查询状态
	 * @var unknown
	 */
	private $statement = null;
	
	public function __construct($tag){
		if(!empty($tag)){
			$this->tag = $tag;
			for($i=0,$n=count(\Config\Db::$mysqlConnection);$i<$n;$i++){
				$server = \Config\Db::$mysqlConnection[$i];
				if($this->tag == $server['tag']){
					$this->dbHost[$this->tag] = $server['host'];
					$this->dbUserName[$this->tag] = $server['username'];
					$this->dbPassword[$this->tag] = $server['password'];
					$this->dbTableName[$this->tag] = $server['tablename'];
					$this->port[$this->tag] = $server['port'];
					break;
				}
			}
			$this->configParam = array(
					\PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8',
					//设置强制字段小写
					\PDO::ATTR_CASE => \PDO::CASE_LOWER,
			);
			if($this->pconnect){
				//设置长链接
				$this->configParam[\PDO::ATTR_DEFAULT_FETCH_MODE] = true;
			}
		}
	}
	
	
	/**
	 * 链接数据库
	 * @return Ambigous <boolean, \PDO>
	 */
	public function connect(){
		$dsn = "mysql:dbname={$this->dbTableName[$this->tag]};host={$this->dbHost[$this->tag]}";
		try {
			$this->link = new \PDO($dsn,$this->dbUserName[$this->tag], $this->dbPassword[$this->tag],$this->configParam);
			$this->connected    =   $this->tag;
		}catch (\PDOException $e){
			$this->link = false;
			$this->error($e->getMessage());
		}
		return $this->link;
	}
	
	/**
	 * 执行查询 返回数据集
	 * @param $query sql语句
	 * @see lib.Db::query()
	 * @return mixed
	 */
	public function query($sql){
		if($sql){
			$this->initConnect();
			if(!empty($this->statement)){
				$this->freeResult();
			}
			$this->statement = $this->link->query($sql);
			return $this->statement;
		}
		return false;
	}
	
	/**
	 * 执行SQL语句
	 * @param unknown $sql
	 * @return number|boolean
	 */
	public function exec($sql){
		if($sql){
			$this->initConnect();
			$rowCount = $this->link->exec($sql);
			return $rowCount;
		}
		return false;
	}
	
	/**
	 * 执行查询，返回单条数据
	 * @see lib.Db::getRow()
	 * @return multitype:|string
	 */
	public function getRow(){
		$result = array();
		$result = $this->statement->fetch(\PDO::FETCH_ASSOC);
		return $result;
	}
	
	/**
	 * 执行查询，返回多条数据
	 * @see lib.Db::getAll()
	 * @return array
	 */
	public function getAll(){
		$result = array();
		$result = $this->statement->fetchAll(\PDO::FETCH_ASSOC);
		return $result;
	}
	
	/**
	 * 执行查询，以对象形式返回数据
	 * @param unknown $sql
	 * @param string $objName
	 */
	public function getDataObj($sql,$objName=''){
		$this->query($sql);
		if($objName){
			return $this->statement->fetchObject($objName);
		}else{
			return $this->statement->fetchObject();
		}
	}
	
	/**
	 * 获取受影响的记录行数
	 */
	public function getRowCount(){
		return $this->statement->rowCount();
	}
	
	/**
	 * 获取最后插入行的ID
	 */
	public function getLastInsertId(){
		return $this->statement->lastInsertId();
	}
	
	/**
	 开启事务
	 */
	public function startTrans(){
		$this->initConnect();
		if ( !$this->_linkID[$this->tag] ) return false;
		if ($this->transTimes == 0) {
			$this->link->beginTransaction();
		}
		$this->transTimes++;
		return ;
	}
	
	/**
	 * 检查是否正处在一个事务内
	 * @return boolean
	 */
	public function inTrans(){
		return $this->link->inTransaction();
	}
	
	/**
	 提交事务
	 */
	public function commit(){
		if ($this->transTimes > 0) {
			$this->link->commit();
			$this->transTimes = 0;
		}
		return true;
	}
	
	/**
	 事务回滚
	 */
	public function rollBack(){
		if ($this->transTimes > 0) {
			$this->link->rollBack();
			$this->transTimes = 0;
		}
		return true;
	}
	
	/**
	 * 生成一条预处理语句
	 * @param unknown $sql
	 */
	public function prepare($sql){
		if($sql){
			$this->initConnect();
			if(!empty($this->statement)){
				$this->freeResult();
			}
			$this->statement = $this->link->prepare($sql);
			return $this->statement;
		}
		return false;
	}
	
	/**
	 * 执行一条预处理语句
	 * @param array $param 传递需要替换预处理SQL中占位符的变量
	 */
	public function execute ($param=array()){
		if(is_array($param) && !empty($param)){
			//将数组中的值对应绑定到SQL参数标记中
			try{
				return $this->statement->execute($param);
			}catch(\PDOException $e){
				return $this->error();
			}
		}else{
			try{
				return $this->statement->execute();
			}catch(\PDOException $e){
				return $this->error();
			}
		}
	}
	
	/**
	 * 绑定参数到一个指定的变量名
	 * 在prepare后使用,可重复使用以便重复绑定变量
	 * 在execute时取值
	 * 问号占位符的索引以1开始
	 * 建议直接在执行execute时传递变量数组，比这个方便
	 * @param unknown $parameter
	 * @param unknown $variable
	 * @param unknown $data_type
	 * @param number $length
	 */
	public function bindParam($parameter,$variable,$data_type=PDO::PARAM_STR,$length=6){
		return $this->statement->bindParam($parameter,$variable,$data_type,$length);
	}
	
	/**
	 *
	 * 释放内存
	 */
	public function freeResult() {
		$this->statement = null;
		return true;
	}
	
	/**
	 *
	 * 释放到数据库服务的连接，以便发出其他 SQL 语句，但使语句处于一个可以被再次执行的状态
	 * 实例参考：http://www.php.net/manual/zh/pdostatement.closecursor.php
	 * 一般情况一个prepare对应一个execute，如果有多个prepare预处理，则执行一个之后需要closeCursor才能execute下一个预处理语句
	 */
	public function close() {
		return $this->statement->closeCursor();
	}
	
	/**
	 * SQL语句执行错误的函数
	 */
	public function error($msg='') {
		if($msg){
			if(DEBUG){
				exit($msg) ;
			}
		}
		return $this->statement->errorInfo();
	}
	
	/**
	 *
	 * 析构方法
	 */
	public function __destruct(){
		$this->freeResult();
	}
}
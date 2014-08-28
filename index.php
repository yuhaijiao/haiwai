<?php 
/**
* 脚本开始执行的时间
* 测2322323方法
* @var float
*/
define('SCRIPT_TIME_START',microtime(true));
define('ROOT_PATH',realpath(__DIR__).DIRECTORY_SEPARATOR);

//调用项目配置文件
require ROOT_PATH.'/config/config.static.php';
require_once ROOT_PATH.'config/config.inc.php';

//调入类库自动加载过程
require ROOT_PATH.'lib/Autoloader.php';

$app = new Lib\Application();
$app->run();

if(DEBUG){
	
}
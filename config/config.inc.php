<?php
date_default_timezone_set('PRC');
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());//函数取得 PHP 环境配置的magic_quotes_gpc 变量值

define('WEB_NAME','会议室管理');

if (!defined('ROOT_PATH'))//物理根目录
{
	define('ROOT_PATH', dirname(__DIR__).DIRECTORY_SEPARATOR);
}

if(!defined('LIB_PATH')) define('LIB_PATH', ROOT_PATH.'lib/');
if(!defined('MODEL_PATH')) define('MODEL_PATH', ROOT_PATH.'model/');
if(!defined('UPLOAD_PATH')) define('UPLOAD_PATH', ROOT_PATH.'upload/');

if(isset($_SERVER["HTTPS"]))  $http="https"; else  $http="http";
if (!defined('HTTP')) define('HTTP', $http);
if (!defined('ROOT_URL'))
{
	define('ROOT_URL',"http://".$_SERVER["HTTP_HOST"]."/");

}

if(!defined('PHPSF')) define('PHPSF','.php');
if(!defined('SESSION_NAME')) define('SESSION_NAME','OLIVER');
if(!defined('SESSION_PREFIX')) define('SESSION_PREFIX','OLIVER_');

//数据缓存根目录
if (!defined('DATA_CACHE_ROOT_PATH')) define('DATA_CACHE_ROOT_PATH', ROOT_PATH . 'data'.DIRECTORY_SEPARATOR);

if(!defined('CSS_PATH')) define('CSS_PATH',ROOT_URL . 'static' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR);
if(!defined('JS_PATH')) define('JS_PATH',ROOT_URL . 'static' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR);
if(!defined('IMG_PATH')) define('IMG_PATH',ROOT_URL . 'static' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR);
if(!defined('FONTSURL')) define('FONTSURL',ROOT_PATH.'static' . DIRECTORY_SEPARATOR . 'fonts' . DIRECTORY_SEPARATOR);

if(!defined('UPLOAD_URL')) define('UPLOAD_URL', ROOT_URL.'upload/');

//数据连接类型
if(!defined('SQL_TYPE')) define('SQL_TYPE','pdomysql');
if(!defined('DBPREFIX')) define('DBPREFIX','milanoo_');
if(!defined('MD5_PREFIX')) define('MD5_PREFIX',md5('oliver_'));
if (!defined('MD5_pass')) define('MD5_pass', 'milanoo_');//加密连接字符串,系统开始使用后不能修改
if(!defined('SSO_URL')) define('SSO_URL','http://sso.ued.com/');

if(!defined('DEBUG')) define('DEBUG',true);

if(!defined('MAIL_AUTH_USERNAME')) define('MAIL_AUTH_USERNAME','milanoo1@163.com');
if(!defined('MAIL_AUTH_PSD')) define('MAIL_AUTH_PSD','1milanoo');

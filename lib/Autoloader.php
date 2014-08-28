<?php
namespace Lib;

/**
 * 自动加载及注册类库
 */
class AutoLoader {
	public static function loadByNameSpace($name){
		$nameArray = explode('\\', $name);
		$className = array_pop($nameArray);
		$dirPath = ROOT_PATH . strtolower(implode(DIRECTORY_SEPARATOR, $nameArray));
		$filePath = $dirPath . DIRECTORY_SEPARATOR . $className . '.php';
		if(file_exists($filePath)){
			include_once $filePath;
			return true;
		}else{
			return false;
		}
	}
}

/**
 * 注册AutoLoader类，当系统调用未定义类时，则会自动调用注册进spl_autoload_register()函数中的方法。
 * 本程序中则会调用loadByNameSpace方法按命名空间自动加载类文件
 */
spl_autoload_register(array('Lib\AutoLoader','loadByNameSpace'));
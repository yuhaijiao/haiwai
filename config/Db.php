<?php
namespace Config;
/**
 * 数据库基础参数
 * @author oliver
 *
 */
class Db {
	static $mysqlConnection = array(
				array (
						'host' => 'localhost',
						'port' => '3306',
						'username' => 'root',
						'password' => '123456',
						'tablename' => 'football',//数据库名
						'dbprefix' => '',
						'tag' => 'local'
						),
				array (
						'host' => '192.168.3.70',
						'port' => '3306',
						'username' => 'dev',
						'password' => 'devpass',
						'tablename' => 'milanoo',
						'dbprefix' => 'milanoo_',
						'tag' => 'pro'
				),
			
		);
}
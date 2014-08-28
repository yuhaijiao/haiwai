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
						'host' => '192.168.11.90',
						'port' => '3306',
						'username' => 'ued',
						'password' => 'ued',
						'tablename' => 'milanooOffice',//数据库名
						'dbprefix' => 'milanoo_',
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
<?php
namespace Config;
/**
 * 配置memcache
 * FileName:Memcache.php
 * @Author:chengjun <cgjp123@163.com>
 * @Since:2012-2-22
 */
 class Memcache {
 	/**
     * Memcache 服务器地址,多台服务器以逗号分开
     * @var string
     */
 	const HOST = '127.0.0.1';
 	/**
     * Memcache 服务器端口，多个端口以逗号分开
     * @var int
     */
 	const PORT = '11211';
 	/**
 	 * 
 	 * 链接超时时间
 	 * @var int
 	 */
 	const CONNECTION_TIMEOUT = 1;
 	/**
 	 * 
 	 * 是否持久链接
 	 * @var boolean
 	 */
 	const PERSISTENT = true;
 }
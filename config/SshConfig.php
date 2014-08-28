<?php
namespace Config;
/**
 * SSH服务器配置
 * @author oliver
 *
 */
class SshConfig {
	/**
	 * 服务器地址
	 */
	const SSHDOMAIN = '192.168.11.75';
	
	/**
	 * 服务器端口
	 */
	const SSHPORT = '22';
	
	/**
	 * 服务器登录名
	 * @var unknown
	 */
	const USERNAME = 'root';
	
	/**
	 * 服务器登录密码
	 * @var unknown
	 */
	const PASSWORD = 'milanoo-admin';
	
	/**
	 * 公钥地址
	 * @var unknown
	 */
	const PUBKEY = '';
	
	/**
	 * 私钥地址
	 * @var unknown
	 */
	const PRIVATEKEY = '';
	
	/**
	 * shell类型
	 * @var unknown
	 */
	const SHELLTYPE = 'xterm';
	
	/**
	 * 验证方式
	 * @var unknown
	 */
	const VERYTYPE = 'password';
	
	/**
	 * 服务器字符集类型
	 */
	const SSHFONTTYPE = 'UTF-8';
}
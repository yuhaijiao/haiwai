<?php
namespace Config;

class DeployUser {
	
	static $user = array(
		1 => array(
				'id' => 1,
				'userName' => 'admin',
				'userPassword' => '123456',
				'userNickName' => 'admin',
				'userQuanxian' => 'admin',
				),	
		2 => array(
				'id' => 2,
				'userName' => 'chengjun',
				'userPassword' => '123456',
				'userNickName' => 'oliver',
				'userQuanxian' => 'user',
				),
		);
	
	static $quanxian = array(
			'admin' => array(''),
			'user' => array('login','cd','ls','git',''),
			);
}
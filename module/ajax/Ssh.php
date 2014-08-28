<?php
namespace Module\Ajax;
/**
 * AJAX调用服务器命令
 * @author oliver
 *
 */
class Ssh extends \Lib\Application {
	public function run(){
		$param = \Lib\Helper\RequestUnit::getParams();
		$cmd = $param->cmd;
		//$cmd = 1;
		if(!empty($cmd)){
			$ssh = new \Module\Ajax\sshobj();
			$result = $ssh->sshCmd($cmd);
			/* \Lib\Helper\Ssh::isConnected();
			\Lib\Helper\Ssh::isOpenShell();
			\Lib\Helper\Ssh::writeShell($cmd);
			$result = \Lib\Helper\Ssh::getShellBuf(); */
			if($cmd == 'exit'){
				$ssh->exitShell();
				//\Lib\Helper\Ssh::disconnect();
				break;
			}
			if(connection_aborted ()){
				$ssh->exitShell();
				//\Lib\Helper\Ssh::disconnect();
				break;
			}
			echo $result;
		}
	}
}

class sshobj{

	public function __construct(){
		\Lib\Helper\Ssh::isConnected();
		\Lib\Helper\Ssh::isOpenShell();
	}

	public function sshCmd($cmd){
		if($cmd){
			//\App\Ssh::isConnected();
			//\App\Ssh::isOpenShell();
			\Lib\Helper\Ssh::writeShell($cmd);
			return \Lib\Helper\Ssh::getShellBuf();
		}
		return false;
	}

	public function exitShell(){
		\Lib\Helper\Ssh::disconnect();
		return true;
	}

	public function __destruct(){
		\Lib\Helper\Ssh::disconnect();
	}
}
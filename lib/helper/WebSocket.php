<?php
namespace App;
set_time_limit(0);
ob_implicit_flush();

$socket = new \Lib\Helper\WebSocket('127.0.0.1',8000);
$socket->run();

class WebSocket {
	
	public $host = '';
	
	public $port = '';
	
	public $master = '';
	
	public $socket = null;
	
	public $hand = null;
	
	public function __construct($host,$port){
		$this->web_socket($host, $port);
		$this->socket = $this->master;
	}
	
	public function run(){
		while(1){
			if($this->master){
				$client = socket_accept($this->master);
				if($client<0){
					$this->e('socket_accept() failed');
					continue;
				}
				$this->socket = $client;
				$this->hand = false;
			}else{
				$len = @socket_recv($this->master, $buffer, 2048, 0);
				if($len==0){
					//中断
					$this->close($this->master);
				}else{
					if(!$this->hand){
						$this->connect($buffer);
					}else{
						$this->send($buffer);
					}
				}
			}
		}
	}
	
	public function close($sock){
		socket_close($sock);
		unset($this->socket);
		$this->e('socket:close');
	}
	
	public function web_socket($host,$port){
		$this->master = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
		socket_set_option($master, SOL_SOCKET, SO_REUSEADDR, 1);
		socket_bind($master, $host, $port);
		socket_listen($master,20);
		$this->e('Server Started:'.date('Y-m-d H:i:s'));
		$this->e('listening on:'.$host.' port:'.$port);
	}
	
	public function connect($buffer){
		$buf = substr($buffer, strpos($buffer, 'Sec-WebSocket-Key:')+18);
		$key = trim(substr($buf,0,strpos($buf, "\r\n")));
		$new_key = base64_encode(sha1($key."258EAFA5-E914-47DA-95CA-C5AB0DC85B11",true));
		$new_message = "HTTP/1.1 101 Switching Protocols\r\n";
		$new_message .= "Upgrade: websocket\r\n";
		$new_message .= "Sec-WebSocket-Version: 13\r\n";
		$new_message .= "Connection: Upgrade\r\n";
		$new_message .= "Sec-WebSocket-Accept: " . $new_key . "\r\n\r\n";
		socket_write($this->socket,$new_message,strlen($new_message));
		$this->hand=true;
		return true;
	}
	
	public function uncode($str){
		$mask = array();
		$data = '';
		$msg = unpack('H*',$str);
		$head = substr($msg[1],0,2);
		if (hexdec($head{1}) === 8) {
			$data = false;
		}else if (hexdec($head{1}) === 1){
			$mask[] = hexdec(substr($msg[1],4,2));
			$mask[] = hexdec(substr($msg[1],6,2));
			$mask[] = hexdec(substr($msg[1],8,2));
			$mask[] = hexdec(substr($msg[1],10,2));
			$s = 12;
			$e = strlen($msg[1])-2;
			$n = 0;
			for ($i=$s; $i<= $e; $i+= 2) {
				$data .= chr($mask[$n%4]^hexdec(substr($msg[1],$i,2)));
				$n++;
			}
		}
		return $data;
	}
	
	public function code($msg){
		$msg = preg_replace(array('/\r$/','/\n$/','/\r\n$/',), '', $msg);
		$frame = array();
		$frame[0] = '81';
		$len = strlen($msg);
		$frame[1] = $len<16?'0'.dechex($len):dechex($len);
		$frame[2] = $this->ord_hex($msg);
		$data = implode('',$frame);
		return pack("H*", $data);
	}
	
	public function ord_hex($data){
		$msg = '';
		$l = strlen($data);
		for ($i= 0; $i<$l; $i++) {
			$msg .= dechex(ord($data{$i}));
		}
		return $msg;
		
	}
	
	function send($msg){
		/*$this->send1($k,$this->code($msg),'all');*/
		parse_str($msg,$cmd);
		$this->e($msg);
		$ar=array();
		if($g['type']=='login'){
			\Lib\Helper\Ssh::isConnected();
			\Lib\Helper\Ssh::isOpenShell();
		}else if($g['type']=='cmd'){
			\Lib\Helper\Ssh::writeShell($cmd['cmd']);
			if(connection_aborted ()){
				\Lib\Helper\Ssh::writeShell('exit');
			}
			$result = \Lib\Helper\Ssh::getShellBuf();
		}
		socket_write($this->master,$result,strlen($result));
	}
	
	
	function e($str){
		$path=dirname(__FILE__).'/socektlog.txt';
		$str=$str."\n";
		error_log($str,3,$path);
		echo iconv('utf-8','gbk//IGNORE',$str);
	}
	
}
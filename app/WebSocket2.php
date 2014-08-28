<?php 
/**
 * 
 * @author chengjun <cgjp123@163.com>
 * @date 2014.1.4
 * 参考：
 * http://blog.csdn.net/binyao02123202/article/details/17577051
 * http://www.zendstudio.net/tag/websocket/
 * http://code.google.com/p/phpwebsocket/source/browse/#svn/trunk/%20phpwebsocket
 * http://tools.ietf.org/html/rfc6455
 * http://www.w3.org/TR/websockets/
 */
error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush(true);

include dirname(__FILE__).'/Ssh.php';
include dirname(__FILE__).'/../config/DeployUser.php';
$socket = new WebSocket();
$socket->run();

class WebSocket {
        
        public $host = '192.168.6.23';
        
        public $port = '12345';
        
        public $socket = null;
        
        public $users = null;
        
        public $master = null;
        
        public $debug = true;
        
        public $Version = 'chengjun 1.0';
        
        public function __construct(){
                $this->master = $this->socketConnect();
                $this->socket[] = $this->master;
                $this->users = array();
        }
        
        /**
         * 监听客户端请求
         */
        public function run(){
                while (true){
                        $changed = $this->socket;
                        $write = null;
                        $except = null;
                        socket_select($changed, $write, $except, 0);
                        foreach($changed as $socket){
                                if($socket == $this->master){
                                        $client = socket_accept($socket);
                                        if($client < 0){
                                                $this->out('socket_accept() faild');
                                                continue;
                                        }else{
                                                $this->connect($client);
                                        }
                                }else{
                                        $bytes = socket_recv($socket, $data, 2048, 0);
                                        if($bytes){
                                                $user = $this->getUserBySocket($socket);
                                                if(!$user->handle){
                                                        $this->handShake($user,$data);
                                                }else{
                                                	
                                                        $this->process($user,$data);
                                                }
                                        }else{
                                        	$this->close($socket);
                                        }
                                }
                        }
                        //释放cpu
                        sleep(1);
                }
        }
        
        /**
         * 处理客户端发送的数据
         * @param unknown_type $user
         * @param unknown_type $data
         */
        private function process($user,$data){
                $msg = $this->deCode($data);
                if(!$msg){
                	$this->close($user->socket);
                	return;
                }
                if(substr($msg, 0,5) == 'login'){
                	$userInfo = explode(':',$msg);
                	if(!empty($userInfo)){
                		$user->userId = $userInfo[1];
                	}
                	$msg = 'login';
                }
                if(!empty($user->userId)){
                	$quanxian = $user->getquanxian($user->userId);
                	if(!empty($quanxian)){
                		if($quanxian != 'admin'){
	                		$quanxianTeam = \Config\DeployUser::$quanxian;
	                		if(!empty($quanxianTeam[$quanxian])){
	                			$msgCmdArray = explode(' ',$msg);
	                			if(!empty($msgCmdArray)){
	                				$msgCmd = $msgCmdArray[0];
	                				$panduan = array_search($msgCmd, $quanxianTeam[$quanxian]);
	                				if($panduan === false){
	                					$msg = 'wrong';
	                				}
	                			}else{
	                				$msg = 'wrong';
	                			}
	                			
	                		}
                		}
                	}
                }
                $msg = nl2br(htmlspecialchars( trim($msg) ,ENT_NOQUOTES));
                $this->send($user,$msg);
        }
        
        /**
         * 发送数据到客户端
         * @param unknown_type $socket
         * @param unknown_type $data
         */
        private function send($user,$data){
        		$result = array();
        		$result['time'] = date('Y-m-d H:i:s');
        		$result['type'] = 'msg';
        		if(!$data) return false;
                if($data=='login'){
                        $result['result'] = $user->ssh->sshCmd('ls -a /data');
                }elseif($data=='wrong'){
                	$result['result'] = '<br />没有权限执行该命令<br />';
                }else{
					if($data == 'top'){
						$data = 'top -b -n 1';//强制TOP只交互一次
					}
                	$result['result'] = $user->ssh->sshCmd($data);
                } 
                $msg = json_encode($result);
               	$msg = $this->enCode($msg);

                $success = socket_write($user->socket, $msg,strlen($msg));
                if($success){
                	$this->out('send success');
                }
        }
        
        /* private function encodingCheck($str){
        	$enclist = array('UTF-8', 'ASCII', 'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4', 'ISO-8859-5', 'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8', 'ISO-8859-9', 'ISO-8859-10', 'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'ISO-8859-16', 'Windows-1251', 'Windows-1252', 'Windows-1254', );
        	$encoding = mb_detect_encoding($str,$enclist,true);
        	return $encoding;
        } */
        
        /**
         * 获取当前socket链接的用户对象
         * @param unknown_type $socket
         */
        private function getUserBySocket($socket){
                $found = null;
                foreach($this->users as $user){
                        if($user->socket == $socket){
                                $found = $user;
                                break;
                        }
                }
                return $found;
        }
        
        /**
         * 创建当前客户端用户链接
         * @param unknown_type $socket
         */
        private function connect($socket){
                $users = new users();
                $users->userId = uniqid();
                $users->socket = $socket;
                $users->handle = false;
                $ssh = new ssh();
                $users->ssh = &$ssh;
                
                array_push($this->users, $users);
                array_push($this->socket, $socket);
                $this->out($socket.'connected');
        }
        
        /**
         * 关闭客户端链接
         * @param unknown $socket
         */
        private function close($socket){
        	$user = $this->getUserBySocket($socket);
        	$kso = array_search($socket, $this->socket);
        	$kus = array_search($user, $this->users);
            socket_close($socket);
            unset($this->users[$kus]->ssh);
            //$user->ssh->exitShell();
            unset($this->users[$kus]);
            
            unset($this->socket[$kso]);
            $this->out($socket.'closed');
        }
        
        /**
         * 建立socket链接
         * 这里只是建立socket套接字，并未进行真实链接
         */
        private function socketConnect(){
                //创建套接字
                $master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
                socket_set_option($master, SOL_SOCKET, SO_REUSEADDR, 1);
                socket_bind($master, $this->host,$this->port);
                //最多监听20条请求
                socket_listen($master,20);
                echo "Server Starter : " . date('Y-m-d H:i:s')."\r\n";
                echo "Listening on : " . $this->host .":".$this->port."\r\n";
                return $master;
        }
        
        /**
         * 与客户端握手
         */
        private function handShake($user,$data){
                $key = $this->getClientHeader($data);
                $mask = '258EAFA5-E914-47DA-95CA-C5AB0DC85B11';
                //加密key
                $newKey = base64_encode( sha1($key.$mask,true) );//true表示获得20长度的散列
                $responseHeader = "HTTP/1.1 101 Switching Protocols\r\n";
                $responseHeader .= "Upgrade: websocket\r\n";
                $responseHeader .= "Connection: Upgrade\r\n";
                $responseHeader .= "Sec-WebSocket-Version: 13\r\n";
                $responseHeader .= "Sec-WebSocket-Accept: {$newKey}\r\n";
                $responseHeader .= "X-Powered-By: {$this->Version}\r\n";
                $responseHeader .= "\r\n";
                socket_write($user->socket, $responseHeader,strlen($responseHeader));
                $user->handle = true;
                $this->out('handShake success');
        }
        
        /**
         * 获取客户端请求头信息
         */
        private function getClientHeader($data){
                preg_match('/Sec-WebSocket-Key: (.*)\r\n/',$data,$match);
                $key = $match[1];
                return $key;
        }
        
		/**
         * 编码
         */
        private function enCode($msg){
                $msg = preg_replace(array('/\r$/','/\n$/','/\r\n$/'), '', $msg);
                $frame = array();
                $frame[0] = '81';//FIN位必须是1，opcode必须是1（表示文本），所以必须以0x81开头
                $len = strlen($msg);
                if($len<126){//数据长度小于127（0x7F）,因为mask位必须0，所以第3数据位最大为7，第四数据位最大为F
                        if($len<16){
                                $frame[1] = '0'.dechex($len);
                        }else{
                                $frame[1] = dechex($len);
                        }
                }elseif($len<hexdec('FFFF')){//数据长度大于127（0x7F）,小于FFFF，则属于16位负载长度，长度数据位指定为0x7E(126)，然后2字节（4个数据位）的长度最大是FFFF
                        $frame[1] = dechex(126);
                        $hexNumber = dechex($len);
                        //填充数位到指定长度
                        //方法1
                        //$frame[1] .= sprintf('%04s',$hexNumber);
                        //方法2
                        $frame[1] .= str_pad($hexNumber, 4,'0',STR_PAD_LEFT );
                }else{//数据长度大于FFFF，则属于64位负载长度，长度数据位指定为0x7F(127)
                        $frame[1] = dechex(127);
                        $frame[1] .= str_pad($hexNumber, 16,'0',STR_PAD_LEFT );
                }
                //$frame[1] = $len<16?'0'.dechex($len):dechex($len);
                $frame[2] = $this->ord_hex($msg);
                $data = implode('',$frame);
                return pack('H*',$data);
        }
        
        /**
         * 解码
         */
        private function deCode($str){
                $mask = array();
                $data = '';
                $msg = unpack('H*', $str);
                $head = substr($msg[1],0,2);
                if(hexdec($head{1})===8){
                        $data = false;
                }else if(hexdec($head{1})===1){//文本数据
                        $payLoadLen = hexdec(substr($msg[1],2,2))-128;
                        if($payLoadLen<126){//当数据长度小于126
                                $mask[] = hexdec(substr($msg[1],4,2));
                                $mask[] = hexdec(substr($msg[1],6,2));
                                $mask[] = hexdec(substr($msg[1],8,2));
                                $mask[] = hexdec(substr($msg[1],10,2));
                                $s = 12;
                                $e = strlen($msg[1])-2;
                                $n = 0;
                        }elseif($payLoadLen==126){//当数据长度等于126，后面2个字节（4个数位）表示数据长度，之后8位是掩码
                                $mask[] = hexdec(substr($msg[1],8,2));
                                $mask[] = hexdec(substr($msg[1],10,2));
                                $mask[] = hexdec(substr($msg[1],12,2));
                                $mask[] = hexdec(substr($msg[1],14,2));
                                $s = 16;
                                $e = strlen($msg[1])-2;
                                $n = 0;
                        }elseif($payLoadLen==127){//当数据长度等于126，后面8个字节（16个数位）表示数据长度，之后8位是掩码
                                $mask[] = hexdec(substr($msg[1],24,2));
                                $mask[] = hexdec(substr($msg[1],26,2));
                                $mask[] = hexdec(substr($msg[1],28,2));
                                $mask[] = hexdec(substr($msg[1],30,2));
                                $s = 32;
                                $e = strlen($msg[1])-2;
                                $n = 0;
                        }
                        
                        for($i=$s;$i<=$e;$i+=2){
                                $data .= chr($mask[$n%4]^hexdec(substr($msg[1],$i,2)));
                                $n++;
                        }                        
                }elseif(hexdec($head{1})===2){
                	//二进制数据
                }
                return $data;
        }
        
        private function ord_hex($data){
                $msg = '';
                $l = strlen($data);
                for($i=0;$i<$l;$i++){
                        $msg .= dechex(ord($data{$i}));
                }
                return $msg;
        }
        
        /**
         * 输出测试信息
         * @param unknown_type $msg
         */
        private function out($msg){
                if($this->debug){
                        echo "wpInfo>>";
                        print_r($msg);
                        echo "\r\n";
                }
        }
}

class users {
        public $userId;
        public $socket;
        public $handle;
        public $ssh;
        
        public function getquanxian($uid){
        	$systemUser = \Config\DeployUser::$user;
        	if(!empty($systemUser[$uid])){
        		$userInfo = $systemUser[$uid];
        		$quanxian = $userInfo['userQuanxian'];
        		return $quanxian;
        	}
        	return false;
        }
}

class ssh{
	
		private $sshHand = null;
	
		public function __construct(){
			$this->sshHand = new \App\Ssh();
			$this->sshHand->openShell();
		}
		
		public function sshCmd($cmd){
			if($cmd){
				//$this->sshHand->isConnected();
				//$this->sshHand->isOpenShell();
				$this->sshHand->writeShell($cmd);
				return $this->getSshResult();
			}
			return false;
		}
		
		public function getSshResult(){
			return $this->sshHand->getShellBuf();
		}
		
		public function exitShell(){
			$this->sshHand->disconnect();
			return true;
		}
		
		public function __destruct(){
			$this->sshHand->disconnect();
		}
}
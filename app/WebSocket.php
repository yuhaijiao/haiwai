<?php
/**
 * 
 * @author chengjun <cgjp123@163.com>
 * @date 2014.1.4
 * 参考
 * http://blog.csdn.net/binyao02123202/article/details/17577051
 * http://www.zendstudio.net/tag/websocket/
 * http://code.google.com/p/phpwebsocket/source/browse/#svn/trunk/%20phpwebsocket
 * http://tools.ietf.org/html/rfc6455
 * http://www.w3.org/TR/websockets/
 */
error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush(true);
date_default_timezone_set('Asia/Shanghai');

define('ROOT_PATH',realpath(__DIR__).'/../'.DIRECTORY_SEPARATOR);

if (!defined('DATA_CACHE_ROOT_PATH')) define('DATA_CACHE_ROOT_PATH', ROOT_PATH . 'data'.DIRECTORY_SEPARATOR);
require_once dirname(__FILE__).'/../config/DeployUser.php';

$socket = new WebSocket();
$socket->run();

class WebSocket {

    public $host = '192.168.6.23';
    public $port = '8003';
    public $socket = null;
    public $users = null;
    public $master = null;
    public $debug = true;
    public $Version = 'chengjun 1.0';

    public function __construct() {
        $this->master = $this->socketConnect();
        $this->socket[] = $this->master;
        $this->users = array();
    }

    /**
     * 监听客户端请求
     */
    public function run() {
        while (true) {
            $changed = $this->socket;
            $write = null;
            $except = null;
            socket_select($changed, $write, $except, 0);
            foreach ($changed as $socket) {
                if ($socket == $this->master) {
                    $client = socket_accept($socket);
                    if ($client < 0) {
                        $this->out('socket_accept() faild');
                        continue;
                    } else {
                        $this->connect($client);
                    }
                } else {
                    $bytes = socket_recv($socket, $data, 50000, 0);
                    if ($bytes) {
                        $user = $this->getUserBySocket($socket);
                        if (!$user->handle) {
                            $this->handShake($user, $data);
                        } else {
                            $this->process($user, $data);
                            //返回所有用户
                            $this->getAllUser($user);
                        }
                    } else {
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
    private function process($user, $data) {
        $msg = $this->deCode($data);
        if (!$msg) {
            $this->close($user->socket);
            return;
        }
        $type = 'all';
        if (substr($msg, 0, 5) == 'login') {
            $userId = explode(':', $msg);
            if (!empty($userId) && !$user->userLogin) {
                //检查重复登录,重复登录关闭之前的链接
                foreach($this->users as $LoginUser){
                	if($LoginUser->userId == $userId[1]){
                		$this->userReLogin($LoginUser);
                		break;
                	}
                }
                $user->userId = $userId[1];
                $type = 'login';
            }
            $this->send($user, $msg, $type);
        }elseif(substr($msg, 0, 6) == 'logout'){
            //踢人,只有管理员才能踢
            $userId = explode(':', $msg);
            if (!empty($userId) && $user->userLogin && $user->userInfo['userQuanxian'] == 'admin') {
                $this->userGoOut($user, $userId[1]);
            }
        }elseif(substr($msg, 0, 3) == 'pop'){
            //发送弹窗
            $msgArray = explode(':', $msg);
            if(!empty($msgArray) && $user->userLogin && $user->userInfo['userQuanxian'] == 'admin'){
                $this->send($user, $msgArray[1],'pop');
            }
        }else{
            //$msg = nl2br(htmlspecialchars( strip_tags(trim($msg))  ,ENT_NOQUOTES));
            //为了兼容火狐和谷歌的不同换行标记
        	$msg = str_replace('<br />', "\n", $msg);
        	$msg = str_replace('<br>', "\n", $msg);
        	$msg = str_replace('<div>', "\n", $msg);
        	$msg = str_replace('</div>', "", $msg);
        	$msg = nl2br(strip_tags(trim($msg)) );
            $this->send($user, $msg);
        }
        return;
    }
    
    private function getAllUser($myself){
        if(!empty($this->users)){
            $userInfo = array();
            foreach($this->users as $k => $user){
                if($user->userLogin){
                    $userInfo[$k] = $user->userInfo;
                }
            }
            if(!empty($userInfo)){
                $this->send($user, $userInfo,'user');
            }
        }
        return;
    }
    
    /**
     * 踢人
     * @param type $userId
     * @return type
     */
    private function userGoOut($adminUser,$userId){
        foreach($this->users as $user){
            if($user->userId == $userId){
                $user->userLogin = false;
                $str = $user->userInfo['userNickName'].' 已经被管理员踢出去了';
                $this->send($adminUser, $str, 'logout');
                $this->close($user->socket);
                break;
            }
        }
        return;
    }


    /**
     * 用户登录
     * @param type $user
     * @return boolean
     */
    private function userLogin($user){
        $user->userInfo = $user->getUserInfo($user->userId);
        $user->userLogin = true;
        $user->userStatus = true;
        $str = '欢迎 '.$user->userInfo['userNickName'] .' 驾到';
        return $str;
    }
    
    private function userReLogin($loginuser){
    	$this->send($loginuser, 'logout', 'relogin');
    	sleep(1);
    	$this->close($loginuser->socket);
    	return ;
    }
    
    /**
     * 用户登出
     * @param type $user
     * @return type
     */
    private function userLogout($user){
          $str = $user->userInfo['userNickName'].' 已退出';
          $this->send($user, $str, 'logout');
          return;
    }

    /**
     * 发�?数据到客户端
     * @param unknown_type $socket
     * @param unknown_type $data
     */
    private function send($user, $data, $type='all') {
        $result = array();
        $result['time'] = date('Y-m-d H:i:s');
        $result['type'] = '';
        $result['uid'] = $user->userInfo['id'];
        $result['username'] = $user->userInfo['userNickName'];
        $result['userface'] = $user->userInfo['userFace'];
        if (!$data){
            return false;
        }
        if ($type=='login' && !$user->userLogin) {
            $result['type'] = $type;
            $result['result'] = $this->userLogin($user);
        }elseif($type == 'logout' && $user->userLogin){
             $result['type'] = $type;
             $result['result'] = $data;
        }elseif($type == 'user' && $user->userLogin){
            $result['type'] = $type;
            $result['result'] = $data;
        }elseif($type == 'pop' && $user->userLogin){
            $result['type'] = $type;
            $result['result'] = $data;
        }elseif($type == 'relogin' && $user->userLogin){
        	$result['type'] = $type;
        	$result['result'] = $data;
        }elseif($type == 'all'){
            $result['type'] = $type;
            $result['result'] = $data;
        }
        $msg = json_encode($result);
        $msg = $this->enCode($msg);
        switch ($result['type']){
            case 'all':
            case 'login':
            case 'logout':
            case 'user':
            case 'pop':
                //群发
                foreach ($this->users as $u) {
                        $success = socket_write($u->socket, $msg, strlen($msg));
                }
            break;
            case 'relogin':
            default :
                $success = socket_write($user->socket, $msg, strlen($msg));
            break;
        }
        return;
    }

    /* private function encodingCheck($str){
      $enclist = array('UTF-8', 'ASCII', 'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4', 'ISO-8859-5', 'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8', 'ISO-8859-9', 'ISO-8859-10', 'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'ISO-8859-16', 'Windows-1251', 'Windows-1252', 'Windows-1254', );
      $encoding = mb_detect_encoding($str,$enclist,true);
      return $encoding;
      } */

    /**
     * 获取当前socket链接的用户对�?
     * @param unknown_type $socket
     */
    private function getUserBySocket($socket) {
        $found = null;
        foreach ($this->users as $user) {
            if ($user->socket == $socket) {
                $found = $user;
                break;
            }
        }
        return $found;
    }

    /**
     * 创建当前客户端用户链�?
     * @param unknown_type $socket
     */
    private function connect($socket) {
        $users = new users();
        $users->userId = uniqid();
        $users->socket = $socket;
        $users->handle = false;
        $users->userLogin = false;

        array_push($this->users, $users);
        array_push($this->socket, $socket);
        $this->out($socket . 'connected');
    }

    /**
     * 关闭客户端链�?
     * @param unknown $socket
     */
    private function close($socket) {
        $user = $this->getUserBySocket($socket);
        $kso = array_search($socket, $this->socket);
        $kus = array_search($user, $this->users);
        $this->userLogout($user);
        $this->getAllUser($user);
        sleep(1);
        socket_close($socket);
        unset($this->users[$kus]);

        unset($this->socket[$kso]);
        $this->out($socket . 'closed');
    }
    
    /**
     * 静默关闭
     * @param unknown $socket
     */
    private function closeQuite($socket){
    	$user = $this->getUserBySocket($socket);
    	$kso = array_search($socket, $this->socket);
    	$kus = array_search($user, $this->users);
    	socket_close($socket);
    	unset($this->users[$kus]);
    	unset($this->socket[$kso]);
    }

    /**
     * 建立socket链接
     * 这里只是建立socket套接字，并未进行真实链接
     */
    private function socketConnect() {
        //创建套接�?
        $master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($master, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_bind($master, $this->host, $this->port);
        //�?��监听20条请�?
        socket_listen($master, 20);
        echo "Server Starter : " . date('Y-m-d H:i:s',time()) . "\r\n";
        echo "Listening on : " . $this->host . ":" . $this->port . "\r\n";
        return $master;
    }

    /**
     * 与客户端握手
     */
    private function handShake($user, $data) {
        $key = $this->getClientHeader($data);
        $mask = '258EAFA5-E914-47DA-95CA-C5AB0DC85B11';
        //加密key
        $newKey = base64_encode(sha1($key . $mask, true)); //true表示获得20长度的散�?
        $responseHeader = "HTTP/1.1 101 Switching Protocols\r\n";
        $responseHeader .= "Upgrade: websocket\r\n";
        $responseHeader .= "Connection: Upgrade\r\n";
        $responseHeader .= "Sec-WebSocket-Version: 13\r\n";
        $responseHeader .= "Sec-WebSocket-Accept: {$newKey}\r\n";
        $responseHeader .= "X-Powered-By: {$this->Version}\r\n";
        $responseHeader .= "\r\n";
        socket_write($user->socket, $responseHeader, strlen($responseHeader));
        $user->handle = true;
        $this->out('handShake success');
    }

    /**
     * 获取客户端请求头信息
     */
    private function getClientHeader($data) {
        preg_match('/Sec-WebSocket-Key: (.*)\r\n/', $data, $match);
        $key = $match[1];
        return $key;
    }

    /**
     * 编码
     */
    private function enCode($msg) {
        $msg = preg_replace(array('/\r$/', '/\n$/', '/\r\n$/'), '', $msg);
        $frame = array();
        $frame[0] = '81'; //FIN位必须是1，opcode必须�?（表示文本），所以必须以0x81�?��
        $len = strlen($msg);
        if ($len < 126) {//数据长度小于127�?x7F�?因为mask位必�?，所以第3数据位最大为7，第四数据位�?��为F
            if ($len < 16) {
                $frame[1] = '0' . dechex($len);
            } else {
                $frame[1] = dechex($len);
            }
        } elseif ($len < hexdec('FFFF')) {//数据长度大于127�?x7F�?小于FFFF，则属于16位负载长度，长度数据位指定为0x7E(126)，然�?字节�?个数据位）的长度�?��是FFFF
            $frame[1] = dechex(126);
            $hexNumber = dechex($len);
            //填充数位到指定长�?
            //方法1
            //$frame[1] .= sprintf('%04s',$hexNumber);
            //方法2
            $frame[1] .= str_pad($hexNumber, 4, '0', STR_PAD_LEFT);
        } else {//数据长度大于FFFF，则属于64位负载长度，长度数据位指定为0x7F(127)
            $frame[1] = dechex(127);
            $frame[1] .= str_pad($hexNumber, 16, '0', STR_PAD_LEFT);
        }
        //$frame[1] = $len<16?'0'.dechex($len):dechex($len);
        $frame[2] = $this->ord_hex($msg);
        $data = implode('', $frame);
        return pack('H*', $data);
    }

    /**
     * 解码
     */
    private function deCode($str) {
        $mask = array();
        $data = '';
        $msg = unpack('H*', $str);
        $head = substr($msg[1], 0, 2);
        if (hexdec($head{1}) === 8) {
            $data = false;
        } else if (hexdec($head{1}) === 1) {//文本数据
            $payLoadLen = hexdec(substr($msg[1], 2, 2)) - 128;
            if ($payLoadLen < 126) {//当数据长度小�?26
                $mask[] = hexdec(substr($msg[1], 4, 2));
                $mask[] = hexdec(substr($msg[1], 6, 2));
                $mask[] = hexdec(substr($msg[1], 8, 2));
                $mask[] = hexdec(substr($msg[1], 10, 2));
                $s = 12;
                $e = strlen($msg[1]) - 2;
                $n = 0;
            } elseif ($payLoadLen == 126) {//当数据长度等�?26，后2个字节（4个数位）表示数据长度，之�?位是掩码
                $mask[] = hexdec(substr($msg[1], 8, 2));
                $mask[] = hexdec(substr($msg[1], 10, 2));
                $mask[] = hexdec(substr($msg[1], 12, 2));
                $mask[] = hexdec(substr($msg[1], 14, 2));
                $s = 16;
                $e = strlen($msg[1]) - 2;
                $n = 0;
            } elseif ($payLoadLen == 127) {//当数据长度等�?26，后8个字节（16个数位）表示数据长度，之�?位是掩码
                $mask[] = hexdec(substr($msg[1], 24, 2));
                $mask[] = hexdec(substr($msg[1], 26, 2));
                $mask[] = hexdec(substr($msg[1], 28, 2));
                $mask[] = hexdec(substr($msg[1], 30, 2));
                $s = 32;
                $e = strlen($msg[1]) - 2;
                $n = 0;
            }

            for ($i = $s; $i <= $e; $i+=2) {
                $data .= chr($mask[$n % 4] ^ hexdec(substr($msg[1], $i, 2)));
                $n++;
            }
        } elseif (hexdec($head{1}) === 2) {
            //二进制数�?
        }
        return $data;
    }

    private function ord_hex($data) {
        $msg = '';
        $l = strlen($data);
        for ($i = 0; $i < $l; $i++) {
            $msg .= dechex(ord($data{$i}));
        }
        return $msg;
    }

    /**
     * 输出测试信息
     * @param unknown_type $msg
     */
    private function out($msg) {
        if ($this->debug) {
             echo "wpInfo>>";
            if(is_array($msg)){
                print_r($msg);
            }else{
                echo iconv('UTF-8', 'gbk//IGNORE', $msg);
            }
           echo "\r\n";
        }
    }

}

class users {

    public $userId;
    public $socket;
    public $handle;
    public $userLogin;
    public $userInfo = null;
    public $userOpt = null;
    public $userStatus = null;
    
    /**
     * 返回用户信息
     * @param type $uid
     * @return boolean
     */
    public function getUserInfo($uid) {
        $systemUser = \Config\DeployUser::getUserNoPass();
        if (!empty($systemUser[$uid])) {
            $userInfo = $systemUser[$uid];
            return $userInfo;
        }
        return false;
    }

}

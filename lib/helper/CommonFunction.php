<?php 
namespace Lib\Helper;
/**
 * 通用方法集合
 * FileName:function.fun.php
 * @Author:oliver <cgjp123@163.com>
 * @Since:2012-3-20
 */
class CommonFunction {
	//来访工具判断
	public static function getrobot()	{
		if(!defined('IS_ROBOT')) {
			$kw_spiders = 'Bot|bot|Crawl|Spider|slurp|sohu-search|lycos|robozilla|google|Search|Yahoo|Technology|msn|spider|search';
			$kw_browsers = 'MSIE|Netscape|Opera|Konqueror|Mozilla';
			if(preg_match("/($kw_browsers)/", $_SERVER['HTTP_USER_AGENT'])) {
				define('IS_ROBOT', FALSE);
			} elseif(preg_match("/($kw_spiders)/", $_SERVER['HTTP_USER_AGENT'])) {
				define('IS_ROBOT', TRUE);
			} else {
				define('IS_ROBOT', FALSE);
			}
		}
		return IS_ROBOT;
	}
	
	//获取客户端IP
	public static function get_client_ip() {
		return $_SERVER['REMOTE_ADDR'];
	}
	
	//获取随机字符
	public static function genRandomString($len){
		$chars = array(
		"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
		"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
		"w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
		"H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
		"S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
		"3", "4", "5", "6", "7", "8", "9"
		);
		$charsLen=count($chars) - 1;
		shuffle($chars);
		$output = "";
	    for ($i=0; $i<$len; $i++){
			$output .= $chars[mt_rand(0, $charsLen)];
		}
		return $output;
	}
	
	//获取随机数
	public static function random($length, $numeric = 0) {
		mt_srand((double)microtime() * 1000000);
		if($numeric) {
			$hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
		} else {
			$hash = '';
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
			$max = strlen($chars) - 1;
			for($i = 0; $i < $length; $i++) {
				$hash .= $chars[mt_rand(0, $max)];
			}
		}
		return $hash;
	}
	
	/**
	 * 生成随机数
	 */
	public static function rand_num($len=3){
		//生成随机数范围
		for($i=1;$i<=$len;$i++){
			$s = rand(0,9);
			$result[] = $s;
		}
		return implode('', $result);
	}
	
	
	public static function daddslashes($string, $force = 0) {
		!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
		if(!MAGIC_QUOTES_GPC || $force) {
			if(is_array($string)) {
				foreach($string as $key => $val) {
					$string[$key] = daddslashes($val, $force);
				}
			} else {
				$string = trim(addslashes($string));
			}
		}
		else
		{
			if(is_array($string)) {
				foreach($string as $key => $val) {
					$string[$key] = daddslashes($val, $force);
				}
			} else {
				$string = trim($string);
			}
		}
		return $string;
	}
	
	//自定义BASE64编码
	public static function Base64Encode($string=''){
		$Base64CodeTable = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9','+','/','=');
		if(!empty($string)){
			$length = strlen($string);
			$byte = '';
			for($i=0;$i<$length;$i++){
				$ascII = ord($string[$i]);
				$bin = (string)decbin($ascII);
				
				if(strlen($bin)<8){
					$temp = '';
					for($j=0;$j<(8-strlen($bin));$j++){
						$temp .= '0';
					}
					$bin = $temp.$bin;
				}
				$byte .= $bin;
			}
			$newByte = str_split($byte,6);
			$newstr = array();
			if(!empty($newByte)){
				foreach($newByte as $k=>$v){
					if(strlen($v)<6){
						$temp = 6-strlen($v);
						$v = bindec($v);
						$v = $v << $temp;
						$v = decbin($v);
					}
					$temp = bindec($v);
					$newstr[$k] = $Base64CodeTable[$temp];
				}
			}
			if(!empty($newstr)){
				$base64Code = implode('', $newstr);
				if(strlen($base64Code)%4!=0){
					for($i=0;strlen($base64Code)%4!=0;$i++){
						$base64Code{strlen($base64Code)} = '=';
					}
				}
			}
			echo $base64Code;exit;
		}
	}
	
	
	public static function timeHash($timeDelay=30,$hashWord='oliverTimeHash'){
		//一天总秒数
		$totalSenonds = 24*3600;
		//根据令牌值变化的间隔时间将一天划分为多个区间，必须能够整除
		$totalSize = $totalSenonds/$timeDelay;
		//当前时间是在当天的多少秒
		$nowTime = date('H')*3600+date('i')*60+date('s');
		//计算当前时间所在区块，采用舍去法
		$nowSize = floor($nowTime/$timeDelay);
		
		$hashString = $nowSize.$hashWord.'_cj'.date('Ymd',time());
		
		$hash = hash('md5', $hashString);
		$_SESSION['timeHash'] = $hash;
		return $hash;		
	}

	/**
	* upload img
	*/
	public static function upload($file_up,$file_prefix=''){
		$suffix=array('.jpg','.gif','.png','.JPG','.GIF','.PNG','.psd','.PSD','.ZIP','.zip','.rar','.RAR');
		$size='10485760';

		$filetype=$file_up['type'];
		$filesize=$file_up['size'];
		$name=$file_up['name'];

		$extend =explode("." , $name);  
	    	$va=count($extend)-1;  
	    	$fileSx = strtolower('.'.$extend[$va]);
	    	if(in_array($fileSx, $suffix))  {
	    		if ($filesize <= $size){
	    			$fileDir = 'bill/'.date('Y');
	    			if(!is_dir(UPLOAD_PATH.$fileDir)){
	    				@mkdir(UPLOAD_PATH.$fileDir,0777);
	    			}
	    			$newFileName = $file_prefix.date('m').date('d').date('H').date('i').date('s').'_'.rand(0,10).$fileSx;
	    			$upFile = UPLOAD_PATH.$fileDir.'/'.$newFileName;
	    			$returnFile = $fileDir.'/'.$newFileName;
	    			move_uploaded_file($file_up['tmp_name'],$upFile);
				chmod ($upFile,0777);
				return $returnFile;
	    		}
	    	}
	    	return false;
	    
	}
	
	/**
	 * 调取JAVA接口获取数据
	 * @param unknown $javaUrl
	 * @param unknown $method
	 * @param unknown $paramPost
	 * @return unknown|mixed
	 */
	public static function getWebserverData($javaUrl,$method,$paramPost=array()){
		$javaUrl = rtrim ( $javaUrl, '?\/' );
		$ch = curl_init ();
		if ($method == 'POST') {
			curl_setopt ( $ch, CURLOPT_POST, true );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $paramPost );
		}
		
		curl_setopt_array ( $ch, 
			array (
				CURLOPT_URL => $javaUrl,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CONNECTTIMEOUT => 50
				)
		);
		$response = curl_exec ( $ch );
		
		if (curl_errno ( $ch )) {
			$info = @curl_getinfo ( $ch );
			$errorResponse = $info;
		
			curl_close ( $ch );
			return $errorResponse;
		}
		
		curl_close ( $ch );
		$str = gzuncompress ( $response );
		
		//$responseArr = json_decode ( $str, true );
		$responseArr = $str;
		
		return $responseArr;
	}
	
	/**
	 * 调取JAVA索引获取数据
	 * @param unknown $javaUrl
	 * @param unknown $method
	 * @param unknown $paramPost
	 * @return unknown|mixed
	 */
	public static function getWebserverSlorData($javaUrl,$method,$paramPost=array()){
		$javaUrl = rtrim ( $javaUrl, '?\/' );
		$ch = curl_init ();
		if ($method == 'POST') {
			curl_setopt ( $ch, CURLOPT_POST, true );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $paramPost );
		}
	
		curl_setopt_array ( $ch,
		array (
		CURLOPT_URL => $javaUrl,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CONNECTTIMEOUT => 50
		)
		);
		$response = curl_exec ( $ch );
	
		if (curl_errno ( $ch )) {
			$info = @curl_getinfo ( $ch );
			$errorResponse = $info;
	
			curl_close ( $ch );
			return $errorResponse;
		}
	
		curl_close ( $ch );
	
		return $response;
	}
	
	/**
	 * curl抓取数据
	 * @param unknown $javaUrl
	 * @param unknown $method
	 * @param unknown $paramPost
	 * @return unknown|mixed
	 */
	public static function getCurlData($javaUrl,$method,$paramPost=array()){
		$javaUrl = rtrim ( $javaUrl, '?\/' );
		$ch = curl_init ();
		if ($method == 'POST') {
			curl_setopt ( $ch, CURLOPT_POST, true );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $paramPost );
			curl_setopt($cs, CURLOPT_USERAGENT, 'Opera');
			curl_setopt($cs, CURLOPT_REFERER, 'http://www.baidu.com');
		}
	
		curl_setopt_array ( $ch,
		array (
		CURLOPT_URL => $javaUrl,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CONNECTTIMEOUT => 50,
		CURLOPT_USERAGENT => 'Opera',
		CURLOPT_REFERER => 'http://www.baidu.com'
		)
		);
		$response = curl_exec ( $ch );
		
		if(empty($response)){
			$info = @curl_getinfo ( $ch );
			if(isset($info['http_code']) && ($info['http_code']=='301' || $info['http_code']=='302')){
				$redirectUrl = $info['redirect_url'];
				if(!empty($redirectUrl)){
					curl_setopt_array ( $ch,
					array (
					CURLOPT_URL => $redirectUrl,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_CONNECTTIMEOUT => 50,
					CURLOPT_USERAGENT => 'Opera',
					CURLOPT_REFERER => $info['url'],
					)
					);
					$response = curl_exec ( $ch );
				}
			}
		}
	
		if (curl_errno ( $ch )) {
			$info = @curl_getinfo ( $ch );
			$errorResponse = $info;
	
			curl_close ( $ch );
			return $errorResponse;
		}
	
		curl_close ( $ch );
	
		//$responseArr = json_decode ( $str, true );
		//$response;
		
		
	
		return $response;
	}
	
	/**
	 * 获取百度新闻
	 * @param unknown $rssUrl
	 * @return multitype:
	 */
	public static function baiduRssNews($rssUrl){
		//获取内容
		$rssResult = \Lib\Helper\CommonFunction::getCurlData($rssUrl,'get');
		$rssResult = iconv('gbk', 'utf-8', $rssResult);
		//替换xml编码头
		$rssResult = str_replace('encoding="gb2312"', 'encoding="utf-8"', $rssResult);

		$news = array();		
		$result = self::xml2array($rssResult);
		if(!empty($result)){
			foreach($result as $k=>$v){
				if($k=='rss' && !empty($v['channel'])){
					$news = $v['channel'];				
				}
			}
		}
		return $news;
	}
	
	/**
	 * 获取网易新闻
	 * @param unknown $rssUrl
	 * @return multitype:
	 */
	public static function netEasyRssNews($rssUrl){
		//获取内容
		$rssResult = \Lib\Helper\CommonFunction::getCurlData($rssUrl,'get');
	
		$news = array();
		$result = self::xml2array($rssResult);
		if(!empty($result)){
			foreach($result as $k=>$v){
				if($k=='rss' && !empty($v['channel'])){
					$news = $v['channel'];
				}
			}
		}
		return $news;
	}
	
	/**
	 * 获取普通订阅新闻
	 * @param unknown $rssUrl
	 * @return multitype:
	 */
	public static function normalNews($rssUrl){
		//获取内容
		$rssResult = \Lib\Helper\CommonFunction::getCurlData($rssUrl,'get');
	
		$news = array();
		$result = self::xml2array($rssResult);
		if(!empty($result)){
			foreach($result as $k=>$v){
				if($k=='rss' && !empty($v['channel'])){
					$news = $v['channel'];
				}
			}
		}
		return $news;
	}
	
	
	/**
	 * 解析XML
	 * @param unknown $contents
	 * @param number $get_attributes
	 * @param string $priority
	 * @return void|multitype:
	 */
	public static function xml2array($contents, $get_attributes = 1, $priority = 'tag') {
		if(!$contents)
			return array();
	
		if(!function_exists('xml_parser_create')) {
			//print "'xml_parser_create()' function not found!";
			return array();
		}
	
		//Get the XML parser of PHP - PHP must have this module for the parser to work
		$parser = xml_parser_create('');
		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($parser, trim($contents), $xml_values);
		xml_parser_free($parser);
	
		if(!$xml_values)
			return; //Hmm...
	
	
		//Initializations
		$xml_array = array();
		$parents = array();
		$opened_tags = array();
		$arr = array();
	
		$current = &$xml_array; //Refference
	
	
		//Go through the tags.
		$repeated_tag_index = array(); //Multiple tags with same name will be turned into an array
		foreach($xml_values as $data) {
			unset($attributes, $value); //Remove existing values, or there will be trouble
				
	
			//This command will extract these variables into the foreach scope
			// tag(string), type(string), level(int), attributes(array).
			extract($data); //We could use the array by itself, but this cooler.
				
	
			$result = array();
			$attributes_data = array();
				
			if(isset($value)) {
				if($priority == 'tag')
					$result = $value;
				else
					$result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
			}
				
			//Set the attributes too.
			if(isset($attributes) and $get_attributes) {
				foreach($attributes as $attr => $val) {
					if($priority == 'tag')
						$attributes_data[$attr] = $val;
					else
						$result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
				}
			}
				
			//See tag status and do the needed.
			if($type == "open") { //The starting of the tag '<tag>'
				$parent[$level - 1] = &$current;
				if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
					$current[$tag] = $result;
					if($attributes_data)
						$current[$tag . '_attr'] = $attributes_data;
					$repeated_tag_index[$tag . '_' . $level] = 1;
						
					$current = &$current[$tag];
	
				} else { //There was another element with the same tag name
						
	
					if(isset($current[$tag][0])) { //If there is a 0th element it is already an array
						$current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
						$repeated_tag_index[$tag . '_' . $level]++;
					} else { //This section will make the value an array if multiple tags with the same name appear together
						$current[$tag] = array($current[$tag], $result); //This will combine the existing item and the new item together to make an array
						$repeated_tag_index[$tag . '_' . $level] = 2;
	
						if(isset($current[$tag . '_attr'])) { //The attribute of the last(0th) tag must be moved as well
							$current[$tag]['0_attr'] = $current[$tag . '_attr'];
							unset($current[$tag . '_attr']);
						}
							
					}
					$last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
					$current = &$current[$tag][$last_item_index];
				}
					
			} elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
				//See if the key is already taken.
				if(!isset($current[$tag])) { //New Key
					$current[$tag] = $result;
					$repeated_tag_index[$tag . '_' . $level] = 1;
					if($priority == 'tag' and $attributes_data)
						$current[$tag . '_attr'] = $attributes_data;
	
				} else { //If taken, put all things inside a list(array)
					if(isset($current[$tag][0]) and is_array($current[$tag])) { //If it is already an array...
	
	
						// ...push the new element into that array.
						$current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
	
						if($priority == 'tag' and $get_attributes and $attributes_data) {
							$current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
						}
						$repeated_tag_index[$tag . '_' . $level]++;
							
					} else { //If it is not an array...
						$current[$tag] = array($current[$tag], $result); //...Make it an array using using the existing value and the new value
						$repeated_tag_index[$tag . '_' . $level] = 1;
						if($priority == 'tag' and $get_attributes) {
							if(isset($current[$tag . '_attr'])) { //The attribute of the last(0th) tag must be moved as well
	
	
								$current[$tag]['0_attr'] = $current[$tag . '_attr'];
								unset($current[$tag . '_attr']);
							}
								
							if($attributes_data) {
								$current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
							}
						}
						$repeated_tag_index[$tag . '_' . $level]++; //0 and 1 index is already taken
					}
				}
					
			} elseif($type == 'close') { //End of tag '</tag>'
				$current = &$parent[$level - 1];
			}
		}
	
		return ($xml_array);
	}
}
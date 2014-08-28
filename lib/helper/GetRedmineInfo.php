<?php
namespace Lib\Helper;

class GetRedmineInfo {
	
	protected $redmineUrl = 'http://192.168.0.2:8000/issues/';
	
	protected $loginUrl = 'http://192.168.0.2:8000/login';

	protected $cookie_file = '';
	
	public function __construct(){

	}
	
	public function getInfo($id){
		$repose = $this->curl();
		$info = array();
		if($repose){
			$redmineInfo = $this->getRedmine($id);
			if($redmineInfo){
				$info = $this->parseRemine($redmineInfo);
				if(!empty($info)){
					$info ['id'] = $id;
				}
			}
		}
		//$fielPath = DATA_CACHE_ROOT_PATH.'cache/view-source wrs.ued.com.html';
		//$redmineInfo = file_get_contents($fielPath);
		
		return $info;
	}

	/**
	*解析需求信息
	*/
	private function parseRemine($redmineInfo){			
		if(!empty($redmineInfo)){
			$parseInfo = array();
			//获取title
			if(preg_match('#<title>([^<]*?)<\/title>#i',$redmineInfo,$matches)){
				$title = $matches[1];
				$tempArray = explode('-', $title);
				if(!empty($tempArray)){
					$parseInfo['title'] = trim($tempArray[1]);
				}
			}
			//获取描述

			return $parseInfo;
		}
	}

	/**
	*获取需求信息
	*/
	private function getRedmine($id){
		if(!empty($id)){
			$ch = curl_init();
			$options = array(
					CURLOPT_URL => $this->redmineUrl.$id,
					CURLOPT_AUTOREFERER => true,
					CURLOPT_CONNECTTIMEOUT => 20,
					CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_COOKIEFILE => $this->cookie_file,//先把上次的链接SESSION传递过去
			);
			curl_setopt_array($ch, $options);
			$response = curl_exec ( $ch );
			curl_close ( $ch );
			unlink($this->cookie_file);
			if(!empty($response)){
				return $response;
			}
		}
		return false;
	}
	
	//获取登录信息
	private function curl(){
		$ch = curl_init();
		if($ch){
			//获取表单formhash
			$cookie_file = tempnam ( '/tmp', 'cookie_curl_' );
			$options = array(
					CURLOPT_URL => $this->loginUrl,
					CURLOPT_AUTOREFERER => true,
					CURLOPT_CONNECTTIMEOUT => 20,
					CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_COOKIEJAR => $cookie_file,//把这次的链接SESSION保存下来
					);
			curl_setopt_array($ch, $options);
			$response = curl_exec ( $ch );
			$info = curl_getinfo ( $ch );
			curl_close ( $ch );
			
			preg_match('/<input\s*name="authenticity_token"\s*type="hidden"\s*value="(.*?)"\s*\/>/i',$response, $matches);
			if(!empty($matches)){
				$formHash = $matches[1];
			}

			//登录
			$ch = curl_init();
			$loginInfo = array();
			$loginInfo['username'] = 'oliver';
			$loginInfo['password'] = 'cj19860204';
			$loginInfo['authenticity_token'] = $formHash;
			$loginInfo['login'] = '登录 &#187;';
			
			curl_setopt_array ( $ch,
				array (
					CURLOPT_URL => $this->loginUrl,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_CONNECTTIMEOUT => 50,
					CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36',
					CURLOPT_REFERER => $info['url'],
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $loginInfo,
					CURLOPT_COOKIEFILE => $cookie_file,//先把上次的链接SESSION传递过去
					CURLOPT_COOKIEJAR => $cookie_file,//把本次登录的结果保存在COOKIE
				)
			);
			$response = curl_exec ( $ch );
			//获取信息
			$info = curl_getinfo ( $ch );
			curl_close ( $ch );
			
			if(!empty($info)){
				if($info['http_code']=='302' || $info['http_code']=='200'){
					$this->cookie_file = $cookie_file;
				}
			}

			
			//print_r($response);
			//print_r($info);
			return true;
		}
		return false;
	}
}
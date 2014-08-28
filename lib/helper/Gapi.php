<?php
namespace Lib\Helper;
/**
 * GA处理
 * @Author:chengjun <cgjp123@163.com>
 * @Since:2013-8-6
 */
 class Gapi {
 	
	const retryMaxTimes = 10;
	
	public $auth_token	= null; //登录验证toekn
	public $Retry_Count	= 0;//重试记录
	
	
 	public function __construct(){
		if(!empty($_SESSION['auth_token'])){
			$this->auth_token = $_SESSION['auth_token'];
		}
		if($this->auth_token==null)
		{
		  $this->authenticateUser();
		}
		$this->auth_token;
 	}
	
	protected function authenticateUser(){
		$variables = array(
			'Email'	=> \Config\Ga::ga_emial,
			'Passwd' =>	\Config\Ga::ga_pass,
			'service' => 'analytics'
		);
		$response =	$this->curlRequest(\Config\Ga::client_login_url,NULL,$variables);
		parse_str(str_replace(array("\n","\r\n"),'&',$response['body']),$auth_token);
		if(substr($response['code'],0,1) !=	'2'	|| !is_array($auth_token) || empty($auth_token['Auth']))
		{
			$this->Retry_Count++;
			$this->logcode("登陆失败,重试".$this->Retry_Count);
			if($this->Retry_Count<self::retryMaxTimes) $this->authenticateUser(); else $this->Retry_Count=0;
		}
		else
		{
			$this->Retry_Count=0;
			$this->auth_token =	$auth_token['Auth'];
			$_SESSION['auth_token'] =$auth_token['Auth'];
		}
	}
	
	protected function AuthHeader(){
		return array('Authorization: GoogleLogin auth=' . $this->auth_token);
	}
	
	public function requestReportData($report_id,$start_date,$end_date,$dimensions, $metrics, $sort_metric, $filter=null,$start_index=1, $max_results=10000){
		$variables ="ids=".urlencode("ga:".$report_id)."&start-date=".urlencode($start_date)."&end-date=".urlencode($end_date)."&metrics=".urlencode($metrics)."&dimensions=".urlencode($dimensions)."&max-results=".urlencode($max_results)."&sort=".urlencode($sort_metric)."&start-index=".urlencode($start_index);
		if($filter) $variables.="&filters=".urlencode($filter);
		$response =	$this->curlRequest(\Config\Ga::report_data_url,$variables,NULL,$this->AuthHeader());
		$Mapbody=json_decode($response['body'],true);
		if(substr($response['code'],0,1) == '2' && $Mapbody[totalResults]>0)
			{
				$this->logcode("\t".$report_id."_".$start_index."_".$Mapbody[totalResults]."_".$this->Retry_Count,FILELOGFILE);
				$this->Retry_Count=0;
				return array($Mapbody[totalResults],$Mapbody[rows]);
			}
		else
		  {
				$this->Retry_Count++;
				if($this->Retry_Count<self::retryMaxTimes) {
					if($response['code']=="401" || $response['code']==0)
					{
						$this->logcode("登陆失效,重试".$this->Retry_Count." ".$response['code']." ".$Mapbody["error"]["message"]);
						$this->Retry_Count=0;
						$this->authenticateUser();
					 }
					elseif(substr($response['code'],0,1)== '4') { $this->logcode("数据查询失败,重试".$this->Retry_Count." ".$variables." ".$response['code']." ".$Mapbody["error"]["message"]);}
					elseif($Mapbody[rows]==0 ||!$Mapbody[rows]) {$this->logcode("查询成功但未取得数据,重试".$this->Retry_Count." ".$variables);}
					else { $this->logcode("连接失败,重试".$this->Retry_Count." ".$variables);}
					return $this->requestReportData($report_id,$start_date, $end_date, $dimensions, $metrics, $sort_metric, $filter,  $start_index, $max_results);
					} 
					else $this->Retry_Count=0;
		  }
	}
	
	/**
	*错误记录
	*/
	public function logcode($str=NULL,$file=NULL){
		if($file==NULL) $file=ERRORLOGFILE;
		if($str) $str = "\r\n".date("m-d H:i:s")." ".$str; else $str=".";
		$file_pointer = fopen($file,"a");
		fwrite($file_pointer,$str);
		fclose($file_pointer);
	}
	
	/**
	 * 获取账户信息
	 * @param number $start_index
	 * @param number $max_results
	 * @throws Exception
	 * @return mixed
	 */
	public function requestAccountData($start_index=1, $max_results=20){
		$response = $this->curlRequest(\Config\Ga::account_data_url, array('start-index'=>$start_index,'max-results'=>$max_results), null, $this->AuthHeader());
	
		if(substr($response['code'],0,1) == '2')
		{
			return json_decode($response['body'],true);
		}
		else
		{
			throw new Exception('GAPI: Failed to request account data. Error: "' . strip_tags($response['body']) . '"');
		}
	}
	
	/**
	*登录
	*/
	private	function curlRequest($url, $get_variables=null,$post_variables=NULL,$headers=null){
		$ch	= curl_init();
		
		if($get_variables)
		{
		  $get_variables = '?'.$get_variables;
		}
		curl_setopt($ch, CURLOPT_URL, $url . $get_variables);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //CURL	doesn't	like google's cert
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
		if(is_array($post_variables))
		{
		  curl_setopt($ch, CURLOPT_POST, true);
		  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_variables);
		}
		if(is_array($headers))
		{
		  curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		}
		curl_setopt($ch, CURLOPT_PROXY,'127.0.0.1:8087');//开启代理
		//curl_setopt($ch, CURLOPT_PROXY,'192.168.11.69:8087');//公司服务器的代理
		$response =	curl_exec($ch);
		$code =	curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);
		return array('body'=>$response,'code'=>$code);
	}
 }
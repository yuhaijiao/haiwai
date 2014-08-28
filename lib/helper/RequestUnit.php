<?php
namespace Lib\helper;

/**
 * 
 * 处理url
 */
class RequestUnit {
	
	/**
	 * 
	 * 保存url参数
	 */
	protected static $requestParams;
	
	public static function getParams($name = null) {
		if (! isset ( self::$requestParams )) {
			self::iniParams ();
		}
		 if(is_string($name))
        {
            if(isset(self::$requestParams->$name))
            {
                return self::$requestParams->$name;
            }
            else
            {
                return null;
            }
        }
        else
        {
            return self::$requestParams;
        }
	}
	
	public static function iniParams() {
		$module = self::requestParams('module');
		$action = self::requestParams('action');
		if(empty($module) && empty($action)){
			$params = self::getRewriteParams();
		}else{
			$params = $_GET;
		}
		
		if(empty($module) && isset($params['module'])) $module = $params['module'];
		if(empty($action) && isset($params['action'])) $action = $params['action'];
		if(empty($module))
        {
            $module = 'index';   
            $params['module'] = 'index';
        }
        if(empty($action))
        {
           $action = 'index';  
           $params['action'] = 'index';
        }
        $params = array_merge($params,$_POST);   

        //if(isset($params['params']))
        //{
         //   $params = array_merge($params,self::parseAparams($params['params']));
        //}
       // $params = array_merge($params, self::parseSearchFields());
        return self::$requestParams = (Object) $params; 
	}
	
	public static function requestParams($name=null){
		if(!is_string($name)) return null;
		$value = isset($_GET[$name]) ? $_GET[$name] : (isset($_POST[$name]) ? $_POST[$name] : null);
		return $value;
	}
	
	public static function getRewriteParams(){
		$urlParams = array();
		$queryStringUrl = self::getRawQueryString();
		if(!empty($queryStringUrl)){
			parse_str($queryStringUrl,$urlParams);
			array_merge($_GET,$urlParams);
		}
		$path = self::getUrl();
		if(strpos($path,'.html')==0){
			if(substr($path,-1)!=='/'){
				$path .= '/';
			}
		}
		$path  = explode('.html',$path);
		$path = $path[0];
		$path = explode('://', $path);
		$path = $path[1];
		$path = explode($_SERVER["HTTP_HOST"]."/",$path);
		$path = $path[1];
		if($path == 'index.php') $path = '';
		if(!empty($path)){
			$path = explode('/', $path);
			if(sizeof($path)==1)
    		{
    			$urlParams['module']	= 'index';
    			$path	= str_replace('.html', '', $path[0]);
    		}
    		else
    		{
    			$urlParams['module']	=  $path[0];
    			$path	= str_replace('.html', '', $path[1]);
    		}
    		$path			= explode('module-', $path);
    		if(isset($path[1])) $path=$path[1];else $path=$path[0];
    		$path			= explode('-', $path);
    		$params = array();
    		if (!empty($path[0]) and (sizeof($path)%2!=0))
    		{
    			$urlParams['action']	= (!empty($path[0])) ? str_replace('.html', '', $path[0]) : 'index';
    			if(preg_match("/(\?|=)/i", $urlParams['action']))
    			{
    				$Promotion=explode('=',str_replace('?', '', $urlParams['action']));
    				$urlParams[$Promotion[0]]=$Promotion[1];
    				$urlParams['action']='index';
    
    			}
    			for($i=1; $i<sizeof($path); $i=$i+2)
    			{
    				$params[$path[$i]]	= (isset($path[$i+1])) ? str_replace('.html', '', $path[$i+1]) : str_replace(".html", '', '');
    			}
    		}
    		else
    		{
    			$urlParams['action']	= 'index';
    			for($i=0; $i<sizeof($path); $i=$i+2)
    			{
    				$params[$path[$i]]	= (isset($path[$i+1])) ? str_replace('.html', '', $path[$i+1]) : str_replace(".html", '', '');
    			}
    		}
    		foreach ($params as $k=>$v)
    		{
    		    if(empty($v))
    		    {
    		        unset($params[$k]);
    		    }
    		}
    		$urlParams['params']	= $params;
		}else{
			$urlParams['module'] = 'index';
			$urlParams['action'] = 'index';
			$urlParams['params'] = array();
		}
		return $urlParams;
	}
	
	/**
	 * 
	 * 获取客户端请求的完整的URL地址
	 * @param boolean $withQueryString  是否包括query string,默认为true
	 * @return string $url
	 */
	public static function getUrl($withQueryString=true){
		$url = strtolower(strstr($_SERVER['SERVER_PROTOCOL'], '/', true)).'://'.$_SERVER['HTTP_HOST'];
		if (isset ($_SERVER["REQUEST_URI"])){
    		$url .= $_SERVER["REQUEST_URI"];
    	}else{
    		$url .= $_SERVER['PHP_SELF'];
    		if(!empty($_SERVER["QUERY_STRING"])){
    			$url .= '?' . $_SERVER['QUERY_STRING'];
    		}
    	}
    	if(!$withQueryString){
    		if(($queryStrPos = strpos($url, '?')) !== false){
    			$url = substr($url, 0, $queryStrPos);
    		}
    	}
    	return urldecode($url);
	}
	
	/**
	 * 
     * 获取最原始的URL中的query string (在未被服务器重写之前的query string部分, 从REQUEST_URI中分析)
     * @return string $queryString
     */
    public static function getRawQueryString()
    {
    	static $queryString;
    	if(!isset($queryString))
    	{
    		$queryString = strstr($_SERVER['REQUEST_URI'], '?');
    		if($queryString !== false)
    		{
    			//去掉"?"
    			$queryString = substr($queryString, 1);
    		}
    		
    	}
    	return $queryString;
    }
    
    public static function getClientIp() {
    	$ip = false;
    	if(!empty($_SERVER["HTTP_CLIENT_IP"])) {
    		$ip = $_SERVER["HTTP_CLIENT_IP"];
    	}
    	if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    		$ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
    		if($ip) {
    			array_unshift($ips, $ip);
    			$ip = FALSE;
    		}
    		for($i = 0; $i < count($ips); $i++) {
    			if(!preg_match("#^(10|172\.16|192\.168)\.#si", $ips[$i])) {
    				$ip = $ips[$i];
    				break;
    			}
    		}
    	}
    
    	if(!$ip)
    	{
    		$ip = !empty($_SERVER['HTTP_X_REAL_IP'])?$_SERVER['HTTP_X_REAL_IP']:'';
    	}
    
    	if(!$ip)
    	{
    		$ip = $_SERVER['REMOTE_ADDR'];
    	}
    	return $ip;
    }
}
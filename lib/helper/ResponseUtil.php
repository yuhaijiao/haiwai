<?php
namespace Helper;
/**
 * 服务端响应时的应用辅助库
 * @author Su Chao<suchaoabc@163.com>
 *
 */
class ResponseUtil{
    /**
     * seo相关的url重写
     * @param array $rawParams 重写时模版传入的参数.参数的详细说明见{@link smarty_function_rewrite()}
     */
    public static function rewrite($rawParams)
    {
        $url = '';
        $isxs='yes';
        $html='.html';
        $seo='';
		$isseo='yes';
        $IS_REWRITE_URL='';
        $rewriteDirName='';
        $force_seo=0;
        $forceNoDomainPrepend = 0;
        $domain = null;
        $seoTargetLanguage = SELLER_LANG;
        $protocol = null;
        $style = '';
		
		extract($rawParams);
		
		//SEO需要类目前面加的前缀
		$seoPre=\config\domainConfig::$seoPre;
		$seoK=isset($seoPre[WEBSITEID][$seoTargetLanguage])?$seoPre[WEBSITEID][$seoTargetLanguage]:'';
		
        switch(WEBSITEID){
        	/* case '2':
        		if($isxs=='yes'){
        			\Wedding\Helper\ResponseUtil::rewrite($rawParams);
        			return;
        		}else{
        			return \Wedding\Helper\ResponseUtil::rewrite($rawParams);
        		}
        		break; */
        	case '3':
        		if($isxs=='yes'){
	        		\Lolitashow\Helper\ResponseUtil::rewrite($rawParams);
	        		return;
        		}else{
        			return \Lolitashow\Helper\ResponseUtil::rewrite($rawParams);
        		}
        		break;
        	case '4':
        		if($isxs=='yes'){
        			\Cosplay\Helper\ResponseUtil::rewrite($rawParams);
        			return;
        		}else{
        			return \Cosplay\Helper\ResponseUtil::rewrite($rawParams);
        		}
        		break;
        	case '5':
        		if($isxs=='yes'){
        			\Costumeslive\Helper\ResponseUtil::rewrite($rawParams);
        			return;
        		}else{
        			return \Costumeslive\Helper\ResponseUtil::rewrite($rawParams);
        		}
        		break;
			case '6':
        		if($isxs=='yes'){
        			\milanoode\Helper\ResponseUtil::rewrite($rawParams);
        			return;
        		}else{
        			return \milanoode\Helper\ResponseUtil::rewrite($rawParams);
        		}
        		break;
			case '7':
        		if($isxs=='yes'){
        			\milanoofr\Helper\ResponseUtil::rewrite($rawParams);
        			return;
        		}else{
        			return \milanoofr\Helper\ResponseUtil::rewrite($rawParams);
        		}
        		break;
        	default:
        		break;
        }
		
		if(WEBSITEID==1&&defined('APP_TYPE') && APP_TYPE == 'wap'){
			if($isxs=='yes'){
				\Wap\Helper\ResponseUtil::rewrite($rawParams);
				return;
        	}else{
				return \Wap\Helper\ResponseUtil::rewrite($rawParams);
        	}		
		}
		
        $seo = html_entity_decode($seo,ENT_QUOTES,'UTF-8');
        $seo = self::replaceSpecialCharacters($seo,$seoTargetLanguage);
    	//if ($seoTargetLanguage!='en-uk' && $seoTargetLanguage!='fr-fr'&& $seoTargetLanguage!='pt-pt' && !$force_seo){$seo='';}
		
		if(($seoTargetLanguage == 'ja-jp' || $seoTargetLanguage == 'ru-ru') && empty($seoEn)){
			$seo = '';
		}elseif(($seoTargetLanguage == 'ja-jp' || $seoTargetLanguage == 'ru-ru') && !empty($seoEn)){
    		//日文和俄文的URL seo使用英文名称，其他语言使用自己的
    		$seo = $seoEn;
    	}
       if($isseo=='no' && ($seoTargetLanguage == 'it-it' || $seoTargetLanguage == 'es-sp' || $seoTargetLanguage == 'de-ge') && !$force_seo){$seo='';}
    	if ($IS_REWRITE_URL=="") $IS_REWRITE_URL=IS_REWRITE_URL;
    	$rewriteBaseDirName = '';
		$speicalDomainLang = \Config\domainConfig::$speicalDomainLang;
		$speicalDomainLang = $speicalDomainLang[WEBSITEID];
		if(is_null($domain)){
			if(defined('APP_TYPE') && APP_TYPE == 'wap'){
				$domain = \Helper\Domain::getWapDomain(WEBSITEID,$seoTargetLanguage);
			}else{
				$domain = \Helper\Domain::getDomain(WEBSITEID,$seoTargetLanguage);
			}
		}
    	if(in_array($seoTargetLanguage,$speicalDomainLang) && is_null($domain))
    	{
    		$rewriteBaseDirName = LangDirName.'/';
    	}

    	if(!empty($rewriteDirName))
    	{
    		$rewriteBaseDirName .= trim($rewriteDirName,' /').'/';
		}
    
    	if($IS_REWRITE_URL!=0)
    	{
    		$module=$action='index';
    		$params='';
    		$url_array=explode("?",$url);

    	    $Garray = self::parseStr($url_array[1]);
    		if(isset($Garray['module']))
    		{
    		    $module = $Garray['module'];  
    		    unset($Garray['module']);
    		}
    	    
    		if(isset($Garray['action']))
    		{
    		    $action = $Garray['action'];    		
    		    unset($Garray['action']);    		    
    		}
    		
    		if(isset($Garray['style']))
    		{
    			$style = $Garray['style'];//用于判断面包屑的spotlight是否要用重写规则
    			unset($Garray['style']);
    		}
           
    		$params = array();
    		foreach ($Garray as $k=>$v)
    		{//@todo 不支持二维以上的数组
    		    if(is_string($v))
    		    {
    		        $params[] = $k.'-'.urlencode($v);
    		    }
    		    else if(is_array($v))
    		    {
    		        foreach ($v as $v_i)
    		        {
    		            $params[] = $k. '-'.urlencode($v_i);    		           
    		        }
    		    }
    		}
    		$params = implode('-', $params);

    		$url=$url_array[0];

			if($IS_REWRITE_URL==1)
			{
				$url.='?/';
			}
			elseif($IS_REWRITE_URL==2 && $rewriteDirName!="en")
			{
				$url .= $rewriteBaseDirName;
			}
			$patterns = array("#['’\"\(\)\&\?\=\%\$\:\[\]\{\}\!\,]#u","#\s*[\-\*\/\.\<\>\:\+×]\s*|\s+#u",'#-{2,}#u','#\s+#u','#%#u');
			if(WEBSITEID == 1 && (!defined('APP_TYPE') || APP_TYPE != 'wap')){
				$replace = array("-","-",'-','-','-');
			}else{
				$replace = array("","-",'-','','%25');
			}
    		if($seo)
    		{
    			$seo=trim($seo);
    			$seo=preg_replace( $patterns,$replace,$seo);
					$seo.="-";	
    		}
			
			//SEO凡是带类目的页面加前缀
			if($isseo=='yes' && !empty($seoK)){
				if(!empty($Garray['class']) ||!empty($Garray['c'])){
					$seo=$seoK.$seo;
				}
			}
			
    		if( $rewriteDirName !="dhtml")
    		{
    			switch ($module)
    			{
    				case '':
    					$url.=$seo;
    					if($action!="index" && $action!="") $url.=$action;
    					if($params!="")
    					{
    						if($action!="index" && $action!="") $url.="-";
    						$url.=$params;
    					}
    					if(($action!="index" && $action!="") || $params!="") $url.=$html;
    					break;
    				case 'index':
    					$url.=$seo;
    					if($action!="index" && $action!="") $url.=$action.$html;
    					break;
    				case 'Brand':
    					$url .="Brand/";
    					if($action="item"&&$Garray['bid']){
    						if($Garray['bname']){
    							$url.=$Garray['bname']."-";
    						}
    						$url.="b{$Garray['bid']}/";
    						if($Garray['class']) {
    							$url.=$seo."c".$Garray['class']."/";
    						} elseif(isset($Garray['class'])){
    								
    							$url.="All-c0/";
    						}
    						if($Garray['page']) {
    							$url.=$Garray['page'].".html";
    						}
    					}
    					break;
    				case 'Boutiques':
    					$url .="Boutiques/";
    					if($action="item"&&$Garray['bid']){
    						if($Garray['bname']){
    							$url.=preg_replace('# +#','-',$Garray['bname'])."-";
    						}
    						$url.="b{$Garray['bid']}";
    						if($Garray['class']) {
    							$url.='/'.$seo."c".$Garray['class']."/";
    						} elseif(isset($Garray['class'])){
    								
    							$url.="/All-c0/";
    						}
    						if($Garray['page']) {
    							$url.=$Garray['page'].".html";
    						}
    					}
    					break;
    				case 'thing':
    					switch ($action)
    					{
    						case 'glist':
    							if (!empty($Garray['textname']) && !empty($Garray['sortlist'])&&(!defined('APP_TYPE') || APP_TYPE != 'wap')){ 							
    								$tagPre = \Config\domainConfig::$tagPres;
									$tagPre = $tagPre[WEBSITEID][$seoTargetLanguage];
									$Garray['textname']=urldecode($Garray['textname']);
									$Garray['textname']=urldecode($Garray['textname']);
									$Garray['textname']=preg_replace( $patterns,$replace,$Garray['textname']);
    								if(!empty($tagPre))$url.=$tagPre."/";
									$url.=strtolower($Garray['textname']);
    							}elseif(!empty($Garray['textname']) && !empty($Garray['sortlist'])){
									$Garray['textname']=urldecode($Garray['textname']);
									$Garray['textname']=preg_replace( $patterns,$replace,$Garray['textname']);
    								$url.="producttags/".$Garray['sortlist']."-".$Garray['textname'];
								}elseif(empty($Garray['class'])){
									$url.="search";
								}else{
									$seo=preg_replace('/\-/',' ',$seo);
									$seo=ucwords($seo);
									$seo=explode(' ',$seo);
									$seo=implode('-',$seo);
									$url.=$seo;
    								$url.="c".$Garray['class'];
    							}
    							$url2="";
    							if(is_array($Garray))
    							{    		
    								ksort($Garray);
    								foreach($Garray as $kid=>$key )
    								{
    									if($kid!="class" && $kid!="page" && $kid!="textname" && $kid!="sortlist")
    									{ 							
    										if($url2) $url2.="-";
    										if(is_array($key))
    										{
    											sort($key);
    										   $url3 = array();
    										   foreach ($key as $key_i) 
    										   {
    										       $url3[] = $kid.'-'. String::escQuotes($key_i);
    										   }   
    										   $url2 .= implode('-', $url3);
    										}
    										else 
    										{
    											if($kid=='keyword'){
    												$url2.=$kid."-". urlencode($key);
    											}else{
    										    	$url2.=$kid."-". String::escQuotes($key);
    											}
    										}
    									}
    								}
    							}
    							if($url2) $url.="/".$url2;
    							if(!empty($Garray['page']))
    							{
    								//add by chengjun 2012-04-16  如果页数=1，则url中不再显示页码
    								if($Garray['page']==1){
    									if(!$url2) $url.='';else $url.=$html;
    								}else{
    									if(!$url2) $url.="/"; else $url.="-";
    									if($Garray['page']!=0) $url.=$Garray['page'].$html;
    								}
    							}elseif($url2){
									$url.=$html;
								}elseif(!empty($Garray['textname']) && !empty($Garray['sortlist'])&&(!defined('APP_TYPE') || APP_TYPE != 'wap')){
									$url.=$html;	
								};
    							break;
    						case 'tag':
	    							if(!empty($Garray['class'])){
	    								$url.=$seo;
	    								$url.="c".$Garray['class'];
	    								$outParamArray = array('class','page','textname','sortlist');
	    							}elseif (!empty($Garray['textname']) && !empty($Garray['sortlist'])&&(!defined('APP_TYPE') || APP_TYPE != 'wap')){
    									$tagPre = \Config\domainConfig::$tagPres;
										$tagPre = $tagPre[WEBSITEID][$seoTargetLanguage];
										$Garray['textname']=urldecode($Garray['textname']);
										$Garray['textname']=urldecode($Garray['textname']);
										$Garray['textname']=preg_replace( $patterns,$replace,$Garray['textname']);
    									if(!empty($tagPre))$url.=$tagPre."/";
										$url.=strtolower($Garray['textname']);
    									$outParamArray = array('class','page','textname','sortlist','ClassId','keyword');
    								}elseif (!empty($Garray['textname']) && !empty($Garray['sortlist'])){
										$Garray['textname']=urldecode($Garray['textname']);
    									$Garray['textname']=preg_replace( $patterns,$replace,$Garray['textname']);
    									$url.="producttags/".$Garray['sortlist']."-".$Garray['textname'];
    									$outParamArray = array('class','page','textname','sortlist','ClassId','keyword');
    								}
    								
    								$url2="";
    								
    								if(is_array($Garray))
    								{
    									ksort($Garray);
    									foreach($Garray as $kid=>$key )
    									{
    										if(!in_array($kid, $outParamArray))
    										{
    											if($url2) $url2.="-";
    											if(is_array($key))
    											{
    												sort($key);
    												$url3 = array();
    												foreach ($key as $key_i)
    												{
    													$url3[] = $kid.'-'. String::escQuotes($key_i);
    												}
    												$url2 .= implode('-', $url3);
    											}
    											else
    											{
    												$url2.=$kid."-". String::escQuotes($key);
    											}
    										}
    									}
    								}
    								if($url2) $url.="/".$url2;
    								if(!empty($Garray['page']))
    								{
    									//add by chengjun 2012-04-16  如果页数=1，则url中不再显示页码
    									if($Garray['page']==1&&!empty($Garray['textname']) && !empty($Garray['sortlist'])&&(!defined('APP_TYPE') || APP_TYPE != 'wap')){
    										if(!$url2) $url.='';
											$url.=$html;
    									}elseif($Garray['page']==1){
											if(!$url2) $url.='';else $url.=$html;
										}else{
    										if(!$url2) $url.="/"; else $url.="-";
    										if($Garray['page']!=0) $url.=$Garray['page'].$html;
    									}
    								}elseif($url2){
										$url.=$html;
									}elseif(!empty($Garray['textname']) && !empty($Garray['sortlist'])&&(!defined('APP_TYPE') || APP_TYPE != 'wap')){
										$url.=$html;
									};
    								break;
    						case 'item':
								if((!defined('APP_TYPE') || APP_TYPE != 'wap')){
									$seo = strtolower($seo);
									$productPre = \Config\domainConfig::$productPres;
									$productPre = $productPre[WEBSITEID][$seoTargetLanguage];
									if(!empty($productPre))$url.=$productPre.'/';
								}
    							$url.=$seo;
    							$url.="p".$Garray['id'];
    							if(!empty($Garray['page'])&&$Garray['page']!=1) $url.="-page-".$Garray['page'];
    							$url.=$html;
    							break;
							case 'writeReview':
								$url .= 'writeReview';
    							$url .= '/' . $seo;
    							$url.="w".$Garray['id'];
    							$url.=$html;
    							break;
    						case '':
    							$url.="seeall".$html;
    							break;
							case 'review':
    						case 'comments':
    							$reviewPre = \Config\domainConfig::$reviewPres;
								$reviewPre = $reviewPre[WEBSITEID][$seoTargetLanguage];
								if(!empty($reviewPre)) $url.=$reviewPre;
    							if(!empty($seo)){
									$seo=strtolower($seo);
									$url.='/'.$seo;
								}else{
									$url.='/';
								}
    							$url.="rp".$Garray['id'];
    							if(!empty($Garray['act'])) $url.="-act-".$Garray['act'];
								if(!empty($Garray['sort'])) $url.="-sort-".$Garray['sort'];
								if(!empty($Garray['typeid'])) $url.="-typeid-".$Garray['typeid'];
    							if(!empty($Garray['page'])&&$Garray['page']!=1) $url.="/".$Garray['page'];
    							$url.=$html;
    						break;
    						default:
    							$url.=$module.'/'.$action."-".$params.$html;
    					}
    					break;
    				case 'promotions':
    					switch($action){
							case 'Spotlight':
								if($style=='breadcrumb'){
									$url .= 'promotions/spotlight';
								}else{			
									$url .= 'hot/';
									if(!empty($seo)){
										$url .= $seo;
									}
									if(!empty($Garray['c'])){
										$url .= 'c'.$Garray['c'];
									}else{
										$url .= $html;
										break;
									}
								}
								$url2 = '';
								//print_r($Garray);exit;
								foreach($Garray as $k=>$v){
									if($k!='page' && $k!='c'){
										if($url2) $url2.="-";
    										if(is_array($v))
    										{
    										   $url3 = array();
    										   foreach ($v as $key_i) 
    										   {
    										       $url3[] = $k.'-'. String::escQuotes($key_i);
    										   }   
    										   $url2 .= implode('-', $url3);
    										}
    										else 
    										{
    										    $url2.=$k."-". String::escQuotes($v);
    										}
									}
								}
								if($url2){
									$url .= '/'.$url2;
								}
								if(!empty($Garray['page']))
    							{
    								if($Garray['page']==1){
    									if(!$url2) $url.='';
    								}else{
    									if(!$url2) $url.="/"; else $url.="-";
    									if($Garray['page']!=0) $url.=$Garray['page'];
    								}
    							}
    							$url.=$html;
								
								
							break;
							case 'Newarrivals':
								$url .= 'new/';
								if(!empty($seo)){
									$url .= $seo;
								}	
								if(!empty($Garray['c'])){
									$url .='c'.$Garray['c'];
								}
								$url2 = '';
								//print_r($Garray);exit;
								foreach($Garray as $k=>$v){
									if($k!='page' && $k!='c'){
										if($url2) $url2.="-";
    										if(is_array($v))
    										{
    										   $url3 = array();
    										   foreach ($v as $key_i) 
    										   {
    										       $url3[] = $k.'-'. String::escQuotes($key_i);
    										   }   
    										   $url2 .= implode('-', $url3);
    										}
    										else 
    										{
    										    $url2.=$k."-". String::escQuotes($v);
    										}
									}
								}
								if($url2){
									$url .= '/'.$url2;
								}
								if(!empty($Garray['page']))
    							{
    								if($Garray['page']==1){
    									if(!$url2) $url.='';
    								}else{
    									if(!$url2) $url.="/"; else $url.="-";
    									if($Garray['page']!=0) $url.=$Garray['page'];
    								}
    							}
    							$url.=$html;
							break;
							default:
								if($seo) $seo.="module-";
		    					$url.=$module.'/'.$seo.$action;
		    					if(($seo!="" || $action!="")&&$params!="") $url.='-';
		    					if($params!="") $url.=$params.$html;
		    					elseif($action!="") $url.=$html; 
							break;
						}
						break;
    				case 'producttags':
						if((!defined('APP_TYPE') || APP_TYPE != 'wap')){
							$tagPre = \Config\domainConfig::$tagPres;
							$tagPre = $tagPre[WEBSITEID][$seoTargetLanguage];
							if(!empty($Garray['index'])){
								if(!empty($tagPre))$url.=$tagPre."/";
								$url.="index-".$Garray['index'].$html;
							}else{
								if(!empty($tagPre))$url.=$tagPre.'/';
								$url.=strtolower($Garray['sort'])."/";
								if(!empty($Garray['page'])&&$Garray['page']!=1)
								{
									$url.=$Garray['page'].$html;
								}
							}
						}else{
							if(!empty($Garray['index'])){
								$url.=$module."/index-".$Garray['index'].$html;
							}else{
								$url.=$module.'/'.$Garray['sort']."/";
								if(!empty($Garray['page'])&&$Garray['page']!=1)
								{
									$url.=$Garray['page'].$html;
								}
							}
						}
    					break;
    				case 'gs':
    					if(!empty($Garray['urlname'])){
    						$url .= 'gs/'.$Garray['urlname'];
    						$url2="";
    						if(is_array($Garray))
    						{    
    							ksort($Garray);
    							foreach($Garray as $kid=>$key )
    							{
    								if($kid!="urlname" && $kid!="page")
    								{ 	
    									if($key!=''){						
    										if($url2) $url2.="-";
    										if(is_array($key))
    										{
    											sort($key);
    										   $url3 = array();
    										   foreach ($key as $key_i) 
    										   {
    										       $url3[] = $kid.'-'. String::escQuotes($key_i);
    										   }   
    										   $url2 .= implode('-', $url3);
    										}
    										else 
    										{
    										    $url2.=$kid."-". String::escQuotes($key);
    										}
    									}
   									}
   								}
    						}
    						
    						if($url2) $url.="/".$url2;
    						if(!empty($Garray['page'])){
    							if($Garray['page']==1){
    								if(!$url2) $url.='';else $url.=$html;
    							}else{
    								if(!$url2) $url.="/"; else $url.="-";
    								if($Garray['page']!=0) $url.=$Garray['page'].$html;
    							}
    						}elseif($url2) $url.=$html;
    					}else{
    						$url .= '';
    					}
    					break;
    				case 'review':
    					$reviewPre = \Config\domainConfig::$reviewPres;
						$reviewPre = $reviewPre[WEBSITEID][$seoTargetLanguage];
						if(!empty($reviewPre)) $url.=$reviewPre;
    					if($action=='glist'){
    						if(!empty($seo)){
								$seo=strtolower($seo);
    							$url .= '/'.$seo;
    						}else{
    							$url .= '/';
    						}
    						$url .=  'rc'.$Garray['id'];
    						$url2 = '';
    						foreach($Garray as $kid=>$key){
    							if($kid!='id' && $kid!='page'){
    							if($url2) $url2.="-";
    								if(is_array($key))
    								{
    								   $url3 = array();
    								   foreach ($key as $key_i) 
    								   {
    								       $url3[] = $kid.'-'. String::escQuotes($key_i);
    								   }   
    								   $url2 .= implode('-', $url3);
    								}
    								else 
    								{
   									    $url2.=$kid."-". String::escQuotes($key);
 									}
    							}
    						}
    						if($url2) $url.="/".$url2;
    						if(!empty($Garray['page'])){
    							if(!$url2) $url.="/"; else $url.="-";
    							if($Garray['page']!=0&&$Garray['page']!=1) $url.=$Garray['page'].$html;
    						}elseif($url2) $url.=$html;
    					}
    					break;
    				case 'reals':
    					$url .= 'event/wedding/real-wedding';
    					if(!empty($seo)){
    						$seo = urlencode($seo);
    					}
    					if($action=='details'){
    						if(!empty($seo)){
    							$url .= '/'.$seo;
    						}else{
    							$url .= '/';
    						}
    						$url .=  'r'.$Garray['id'];
    					}elseif ($action=='add'){
    						$url .= '/add';
    					}
    					
    					$url2 = '';
    					if(!empty($Garray)){
    						foreach($Garray as $kid=>$key){
    							if($kid!='page' && $kid!='id'){
    								if($url2) $url2.="-";
    								if(is_array($key))
    								{
    									$url3 = array();
    									foreach ($key as $key_i)
    									{
    										$key_i = urlencode($key_i);
    										$url3[] = $kid.'-'. String::escQuotes($key_i);
    									}
    									$url2 .= implode('-', $url3);
    								}
    								else
    								{
    									$key = urlencode($key);
    									$url2.=$kid."-". String::escQuotes($key);
    								}
    							}
    						}
    					}
    					if($url2) $url.="/".$url2;
    					if(!empty($Garray['page'])){
    						if(!$url2) $url.="/"; else $url.="-";
    						if($Garray['page']!=0) $url.="lists-".$Garray['page'].$html;
    					}elseif($url2 || $action=='details' || $action=='add') $url.=$html;
						elseif($action=='lists') $url.="/lists-1".$html;
    					break;
					case 'story':
    					$url .= 'testimonials';
    					if(!empty($seo)){
    						$seo = urlencode($seo);
    					}
    					if($action=='show'){
    						//if(!empty($seo)){
    						//	$url .= '/'.$seo;
    						//}else{
    							$url .= '/';
    						//}
    						$url .=  'm'.$Garray['id'];
    					}elseif ($action=='add'){
    						$url .= '/add';
    					}
    					
    					$url2 = '';
    					if(!empty($Garray)){
    						foreach($Garray as $kid=>$key){
    							if($kid!='page' && $kid!='id'){
    								if($url2) $url2.="-";
    								if(is_array($key))
    								{
    									$url3 = array();
    									foreach ($key as $key_i)
    									{
    										$key_i = urlencode($key_i);
    										$url3[] = $kid.'-'. String::escQuotes($key_i);
    									}
    									$url2 .= implode('-', $url3);
    								}
    								else
    								{
    									$key = urlencode($key);
    									$url2.=$kid."-". String::escQuotes($key);
    								}
    							}
    						}
    					}
    					if($url2) $url.="/".$url2;
    					if(!empty($Garray['page'])){
    						if(!$url2) $url.="/"; else $url.="-";
    						if($Garray['page']!=0) $url.=$Garray['page'].$html;
    					}elseif($url2 || $action=='show' || $action=='add') $url.=$html;
    					break;
    				case 'sale':
    					if($Garray['promotiontype']=='clearance'){
    						$url.='clearance/';
    					}else{
    						$url.='sale/';
    					}
    					if(!empty($Garray['class'])){
    						$url.=$seo;
    						$url.="c".$Garray['class'];
    						$url2 = '';
    						foreach($Garray as $kid=>$key ){
    							if($kid!="class" && $kid!="page" && $kid!="promotiontype"){ 							
    								if($url2) $url2.="-";
    								if(is_array($key)){
    									$url3 = array();
    									foreach ($key as $key_i){
    										 $url3[] = $kid.'-'. String::escQuotes($key_i);
    									}   
    										 $url2 .= implode('-', $url3);
    								}else {
    										$url2.=$kid."-". String::escQuotes($key);
    								}
    							}
    						}
    						
    						if($url2) $url.="/".$url2;
    						if(!empty($Garray['page']))
    						{
    							if($Garray['page']==1){
    								if(!$url2) $url.='';else $url.=$html;
    							}else{
    								if(!$url2) $url.="/"; else $url.="-";
    								if($Garray['page']!=0) $url.=$Garray['page'].$html;
    							}
    						}
    						elseif($url2) $url.=$html;
    					}else{
    						$url .= 'index.html';
    					}
    					break;
						
					case 'flashsale':
						$url.='flashsale/';
						if(!empty($Garray)){
							if(!empty($Garray['eventId'])){
								$url.=$seo;
								$url.=$Garray['flashUrl'];
								$url.="_f".$Garray['eventId'];
								$url2 = '';
								foreach($Garray as $kid=>$key ){
									if($kid!="eventId" && $kid!="page" && $kid!="flashUrl"){ 							
										if($url2) $url2.="-";
										if(is_array($key)){
											$url3 = array();
											foreach ($key as $key_i){
												 $url3[] = $kid.'-'. String::escQuotes($key_i);
											}   
												 $url2 .= implode('-', $url3);
										}else {
												$url2.=$kid."-". String::escQuotes($key);
										}
									}
								}
    						
    						if($url2) $url.="/".$url2;
    						if(!empty($Garray['page']))
    						{
    							if($Garray['page']==1){
    								if(!$url2) $url.='';else $url.=$html;
    							}else{
    								if(!$url2) $url.="/"; else $url.="-";
    								if($Garray['page']!=0) $url.=$Garray['page'].$html;
    							}
    						}
							$url.=$html;
							}else{
								$url.= 'sort-'.$Garray['sort'];
								$url.=$html;
							}
						}
						
						break;
    				case 'modelcenter':
    					$url.='modelcenter';
    					if(!empty($Garray)){
    						if(!empty($Garray['id'])){
    							$url.='/';
    							$url.=$seo;
    							$url.="m".$Garray['id'];
    							$url2 = '';
    							foreach($Garray as $kid=>$key ){
    								if($kid!="id" && $kid!="page"){
    									if($url2) $url2.="-";
    									if(is_array($key)){
    										$url3 = array();
    										foreach ($key as $key_i){
    											$url3[] = $kid.'-'. String::escQuotes($key_i);
    										}
    										$url2 .= implode('-', $url3);
    									}else {
    										$url2.=$kid."-". String::escQuotes($key);
    									}
    								}
    							}
    								
    							if($url2) $url.="/".$url2;
    							if(!empty($Garray['page']))
    							{
    								if($Garray['page']==1){
    									if(!$url2) $url.='';else $url.=$html;
    								}else{
    									if(!$url2) $url.="/"; else $url.="-";
    									if($Garray['page']!=0) $url.=$Garray['page'].$html;
    								}
    							}
    							elseif($url2) $url.=$html;
    						}else{
    							foreach($Garray as $kid=>$key ){
    								if($kid!="id" && $kid!="page"){
    									if($url2) $url2.="-";
    									if(is_array($key)){
    										$url3 = array();
    										foreach ($key as $key_i){
    											$url3[] = $kid.'-'. String::escQuotes($key_i);
    										}
    										$url2 .= implode('-', $url3);
    									}else {
    										$url2.=$kid."-". String::escQuotes($key);
    									}
    								}
    							}
    							if($url2) $url.="/".$url2;
    							if(!empty($Garray['page']))
    							{
    								if($Garray['page']==1){
    									if(!$url2) $url.='/index.html';else $url.=$html;
    								}else{
    									if(!$url2) $url.="/"; else $url.="-";
    									if($Garray['page']!=0) $url.=$Garray['page'].$html;
    								}
    							}
    							elseif($url2) $url.=$html;
    						}    						
    					}else{
    						$url .= '/index.html';
    					}
    					break;
    				case 'member':
    					if($action == 'CouponPromotion'){
    						if($seo) $seo.="module-";
    						$url.=$module.'/'.$seo.$action;
    						if(($seo!="" || $action!="")&& $params!="") $url.='-';
    						if($params!="") $url.=$params.$html;
    						elseif($action!="") $url.=$html;
    						if(isset($Garray['page2'])) $url.= '#Used';
    						if(isset($Garray['page3'])) $url.= '#Expired';
    						if(isset($Garray['pageProm'])) $url.= '#promotion_content';
    					}else{
	    					if($seo) $seo.="module-";
	    					$url.=$module.'/'.$seo.$action;
	    					if(($seo!="" || $action!="")&&$params!="") $url.='-';
	    					if($params!="") $url.=$params.$html;
	    					elseif($action!="") $url.=$html;
    					}
    					break;
    				case 'help':
    				 	if($action=='detail'){
    				 		$url.=$module.'/index-id-'.$Garray['id'];
    				 		if(isset($Garray['childcat'])) $url.= '-childcat-'.$Garray['childcat'];
    				 		if(isset($Garray['keyword'])) $url.= '-keyword-'.$Garray['keyword'];
    				 		$url.=$html;
    				 	}else{
    				 		if($seo) $seo.="module-";
	    					$url.=$module.'/'.$seo.$action;
	    					if(($seo!="" || $action!="")&&$params!="") $url.='-';
	    					if($params!="") $url.=$params.$html;
	    					elseif($action!="") $url.=$html; 
    				 	}
    				 	break;
					case 'guide':
    				 	if($action=='glist'){
    				 		$url.=$module.'/index-cid-'.$Garray['cid'];
							if(!empty($Garray['page']))
							{
								if($Garray['page']!=1){
									if($Garray['page']!=0) $url.='-pageNo-'.$Garray['page'];
								}
							}
							$url.=$html;
    				 	}else if(!empty($Garray['id'])){
							$url.=$module.'/index-id-'.$Garray['id'];
							$url.=$html;
						}else{
    				 		$url.=$module.'/';    				 		
    				 	}
						
    				 	break;
    				default:
    					if($seo) $seo.="module-";
    					$url.=$module.'/'.$seo.$action;
    					if(($seo!="" || $action!="")&&$params!="") $url.='-';
    					if($params!="") $url.=$params.$html;
    					elseif($action!="") $url.=$html; 
    			}
    		}
    		else
    		{
    			if($seo) $seo.="module-";
    			$url.=$module.'/'.$seo.$action;
    			if(($seo!="" || $action!="")&&$params!="") $url.='-';
    			if($params!="") $url.=$params.$html;
    			elseif($action!="") $url.=$html;
    			if(!$action && !$params && $rewriteDirName=="dhtml") $url.='index'.$html;
    		}
    	}

    	if(!empty($domain)) {
			if(defined('APP_TYPE') && APP_TYPE == 'wap'){
				$https_flag = false;
				if(in_array(strtolower($module),array('shop','member')) && !in_array(strtolower($action),array('cart','recently','coupon'))){
					$https_flag = true;
				}
				if(!HTTPS_SWITCH){
					$https_flag = false;
				}
				$wap_domain = \Helper\Domain::getWapDomain(WEBSITEID,$seoTargetLanguage,$https_flag);
				$domain = $wap_domain.'/';
				
			}else{
				if(HTTPS_SWITCH){
				
					if(((!defined('APP_TYPE'))  ||  WEBSITEID==2) 
					&&  ($module=='shop' && (in_array($action,array('Step1','Step2','Payment','Achieve','Paypal'))))
					 ||  ($module=='member' && (in_array($action,array('reg','login')))) 
					){
						
						$domain = \Helper\Domain::getSecurityDomain(WEBSITEID,$seoTargetLanguage);
						
					}
				}
			}
			$url = rtrim($domain, '/') . '/' . rtrim($url, '/');
			
		} else if(!$forceNoDomainPrepend) {
			if($protocol == 'https') {
				//$url = ROOT_URLS . $url;
				$url = ROOT_URLD . $url;
			} else if($protocol == 'http') {
				$url = ROOT_URLD . $url;
			} else {
				$url = ROOT_URL . $url;
			}
		}
    	if($isxs=='yes') echo $url;
    
    	else return $url;        
    }
    
    /**
     * 将GET参数格式的字符串转换成关联数组.与parse_str()方法相比,parseStr()不会对key的特殊字符进行处理,如:将空格转换成下划线
     * @param string $url
     * @return array
     */
    public static function parseStr($url)
    {
        $url = explode('?', $url);
        $url = array_pop($url);
        $com = explode('&', $url);
        $url = array();
        foreach ($com as $v)
        {
            $v = explode('=', $v);
            if(!empty($v[0]))
            {
                $varName = preg_replace('#([^\[\]]+)|(\[[^\]\[]*\])#', '\1\2', $v[0]);                
                if(!isset($v[1])) $v[1] = '';
                $varNameSub = strstr($varName, '[');
                if(false !== $varNameSub)
                {
                    $varName = strstr($varName, '[',true);
                    eval('$url[\''.addslashes($varName).'\']'.$varNameSub.'=$v[1];');                    
                }
                else 
                {
                    $url[$varName] = $v[1]; 
                }
            }
        }        
        return $url;
    }
	
	/**
	 * 将法语特殊字符转换成英文字符
	 *
	 * @param $str string       	
	 * @return string
	 */
	public static function replaceSpecialCharacters($str,$seoTargetLanguage) {
		switch ($seoTargetLanguage) {
			case 'fr-fr' :
				$replace_arr = array ('À' => 'A', 'à' => 'a', 'à' => 'a', 'Â' => 'A', 'â' => 'a', 'È' => 'E', 'è' => 'e', 'É' => 'E', 'é' => 'e', 'Ê' => 'E', 'ê' => 'e', 'Ë' => 'E', 'ë' => 'e', 'Î' => 'I', 'î' => 'i', 'Ï' => 'I', 'ï' => 'i', 'ç' => 'c', 'ô' => 'o', 'Œ' => 'OE', 'œ' => 'oe', 'Ù' => 'U', 'ù' => 'u', 'Û' => 'U', 'û' => 'u', 'Ü' => 'U', 'ü' => 'u', 'µ' => 'u' );
				$str = strtr ( $str, $replace_arr );
				break;
			case 'pt-pt' :
				$replace_arr = array ('Á' => 'A', 'á' => 'a', 'Ã' => 'A', 'ã' => 'a', 'À' => 'A', 'à' => 'a','Â' => 'A','â' => 'a', 'Ç' => 'C', 'ç' => 'c','Ê' => 'E','ê' => 'e','É' => 'E', 'é' => 'e', 'Í' => 'I', 'í' => 'i', 'Ó' => 'O', 'ó' => 'o', 'Õ' => 'O', 'õ' => 'o', 'Ô' => 'O', 'ô' => 'o','Ú' => 'U','ú' => 'u','€'=>'');
				$str = strtr ( $str, $replace_arr );
				break;
			case 'de-ge' :
				$replace_arr = array('Ä' => 'Ae', 'ä' => 'ae', 'Ö' => 'Oe', 'ö' => 'oe', 'Ü' => 'Ue', 'ü' => 'ue', 'ß' =>'ss' );
				$str = strtr ( $str, $replace_arr );
				break;
			case 'es-sp' :
				$replace_arr = array('Á' => 'A', 'á' => 'a', 'Ó' => 'O', 'ó' => 'o', 'É' => 'E', 'é' => 'e', 'Í' =>'I', 'í' => 'i', 'Ú' => 'U', 'ú' => 'u', 'Ñ' => 'N', 'ñ' => 'n' );
				$str = strtr ( $str, $replace_arr );
				break;
			case 'it-it' :
				$replace_arr = array('À' => 'A', 'à' => 'a', 'É' => 'E', 'é' => 'e', 'È' => 'E', 'è' => 'e', 'Ì' => 'I', 'ì' => 'i', 'Í' =>'I', 'í' => 'i','Ó' => 'O', 'ó' => 'o', 'Ò' => 'O', 'ò' => 'o', 'Ù' => 'U', 'ù' =>'u', 'Ú' => 'U', 'ú' => 'u' );
				$str = strtr ( $str, $replace_arr );
				break;
		}
		return $str;
	}
    
    /**
     * 返回已经发送或者准备发送的header信息
     * @param string $name header名称
     * @return string header的内容.如果header不存在则返回null
     */
    public static function getHeader($name)
    {
    	$headers = headers_list();
    	foreach ($headers as &$header)
    	{
    		if(stripos($header, $name . ':') === 0)
    		{
    			return str_ireplace($name . ':', '', $header);
    		}
    	}
    	return null;
    }
	
	public static function formatArrSpe($arr)  {
		foreach($arr as $key => $item) {
			if(is_array($item))  {
				$item = self::formatArrSpe($item);
			} else {
				$item = html_entity_decode($item, ENT_COMPAT, 'UTF-8');
			}
			$arr[$key] = $item;
		}
		return $arr;
	}
}
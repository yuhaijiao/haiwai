<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {html_statistics_code} plugin
 *
 * Type:     function
 * Name:     html_statistics_code
 * Purpose:  统计代码
 *
 * @version 1.0.0
 * @author yang tao<yang.tao.php@gmail.com>
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_html_statistics_code($params, &$smarty)
{
    $tplar=$smarty->_tpl_vars;
	$params_all  =Helper\RequestUtil::getParams();
	// echo '<hr><pre>';
	// print_r($params_all);
	// die;
	$module 		=$params_all->module;
	$type 			=$params_all->type;
	$action  		=$params_all->action;
	$ClassId		=$params_all->ClassId;
	$class			=$params_all->class;
	$pid				=$params_all->id;
	$page			=$params_all->page;
	$cid=!empty($class)?$class:$ClassId;
	if(empty($page))$page=1;
	$html_result .='';
	if(defined('STATICS_OPEN') && STATICS_OPEN==1){
		if($module=='thing' && $action=='item'){
			$productCategory=$smarty->_tpl_vars['productsDetails']['productCategory'];
			$parentCategories=\Helper\String::cat_ga_custom_var($productCategory,1);
			// echo '<hr><pre>';
			// print_r($productCategory);
			// die;
			krsort($parentCategories);
			//remarketing plain
			$Remarket_code=\Helper\String::get_remarket_code($parentCategories);
			//remarketing 30
			$Remarket_code_30=\Helper\String::get_remarket_code($parentCategories,30);
			//remarketing 120
			$Remarket_code_120=\Helper\String::get_remarket_code($parentCategories,120);
		}
		 /*  if($module=='thing' && $action=='glist'){
			unset($smarty->_tpl_vars['lang']);
			unset($smarty->_tpl_vars['ExchangeRateAll']);
			unset($smarty->_tpl_vars['CurrencyAll']);
			unset($smarty->_tpl_vars['productlist']);
			unset($smarty->_tpl_vars['topSelling']);
			unset($smarty->_tpl_vars['productCategory']);
			unset($smarty->_tpl_vars['searchinfo']);
			unset($smarty->_tpl_vars['result']);
			unset($smarty->_tpl_vars['PropertyResults']);
			unset($smarty->_tpl_vars['i']);
			unset($smarty->_tpl_vars['lang']);
			unset($smarty->_tpl_vars['lang']);
			unset($smarty->_tpl_vars['lang']);
			echo '<hr><pre>';
			print_r($smarty->_tpl_vars);
			die;
		}   */
		//statistics code begin
		$html_result .='
<!--statistics code-->
<div style="display:none">';
		switch(SELLER_LANG){
			case 'en-uk':
				//-------------------------------------------------->>>CNZZ<<<--------------------------------------------------en
			// if($tplar['HTTP']=='http'){
				// $html_result .='
// <script src="http://s93.cnzz.com/stat.php?id=968786&web_id=968786" language="JavaScript" charset="gb2312"></script>';
			// }
			//-------------------------------------------------->>>GA old<<<-------------------------------------------------en
			$html_result .='
<!--GA old-->';
			$html_result .='
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-8431060-1"]);
_gaq.push(["_trackPageview"]);
';
			if($tplar['google']=='google'){
				$html_result .="
_gaq.push(['_addTrans',
'".$tplar['OrdersId']."',		// order ID - required
'Milanoo_en',  // affiliation or store name
'".$tplar['OrdersAmount_Currency']."',		// total - required
'0.00',           // tax
'".$tplar['OrdersLogisticsCosts_Currency']."',		// shipping
'".$tplar['Orders']['OrdersConsigneeCtiy']."',		// city
'".$tplar['Orders']['OrdersConsigneeUrbanAreas']."',		// state or province
'".$tplar['Countries']['name']."',		// country
]);
";
				foreach($tplar['Cart_ga'] as $cart){
					$html_result .="
_gaq.push(['_addItem',
'".$tplar['OrdersId']."',		// order ID - required
'".$cart['ProductsId']."',				//SKU/code - required
'".$cart['ProductsName']."',				//product name
'".$cart['CategoryId']."',				//category or variation
'".$cart['ProductsPrice']."',				//unit price - required
'".$cart['ProductsNum']."',				//quantity - required
]);
";
				}
				$html_result .='_gaq.push(["_trackTrans"]); ';
			}
			$html_result .='
(function() {
var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
ga.src = ("https:" == document.location.protocol ? " https://ssl" : " http://www") + ".google-analytics.com/ga.js";
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
	';
			$html_result .='
<!--GA old end-->';
			//-------------------------------------------------->>>GA new<<<--------------------------------------------------en
			$ga_custom_var='';
			if($module=='thing' && $action=='glist' && $cid!=''){
				//$ga_custom_var=\Helper\String::get_ga_custom_var('glist',$cid,$page);
				// echo '123<hr><pre>';
				// print_r($smarty->_tpl_vars['categoryBreadcrumbNavigation']);
				// die;
				$ga_custom_var=\Helper\String::get_ga_custom_var('glist',$smarty->_tpl_vars['categoryBreadcrumbNavigation'],$page);
			}else if ($module=='thing' && $action=='item'){
				$ga_custom_var=\Helper\String::get_ga_custom_var('item',$productCategory,0,$pid);
			}else{
				$ga_custom_var=\Helper\String::get_ga_pageview();
			}
			$html_result .='
<!--GA new-->';
			$html_result .='
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-26300554-1"]);
';
			if(isset($tplar['select']['textfield']) && $tplar['select']['textfield']!='Enter search keywords or item code here'){
				$html_result .='_gaq.push(["_trackPageview", "/en/search/?q='.$tplar['select']['textfield'];
				if($cid){
					$html_result .='&c='.$cid.'"]);';
				}else{$html_result .='"]);';}
			}else{
				$html_result .='_gaq.push(["_trackPageview","'.$ga_custom_var.'"]);';
			}
			if($tplar['google']=='google'){
				$html_result .="
_gaq.push(['_addTrans',
'".$tplar['OrdersId']."',		// order ID - required
'Milanoo_en',  // affiliation or store name
'".$tplar['OrdersAmount_Currency']."',		// total - required
'0.00',           // tax
'".$tplar['OrdersLogisticsCosts_Currency']."',		// shipping
'".$tplar['Orders']['OrdersConsigneeCtiy']."',		// city
'".$tplar['Orders']['OrdersConsigneeUrbanAreas']."',		// state or province
'".$tplar['Countries']['name']."',		// country
]);
";
				foreach($tplar['Cart_ga'] as $cart){
					$html_result .="
_gaq.push(['_addItem',
'".$tplar['OrdersId']."',		// order ID - required
'".$cart['ProductsId']."',				//SKU/code - required
'".$cart['ProductsName']."',				//product name
'".$cart['CategoryId']."',				//category or variation
'".$cart['ProductsPrice']."',				//unit price - required
'".$cart['ProductsNum']."',				//quantity - required
]);
";
				}
				$html_result .='_gaq.push(["_trackTrans"]); ';
			}
			$html_result .='
(function() {
var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
ga.src = ("https:" == document.location.protocol ? " https://ssl" : " http://www") + ".google-analytics.com/ga.js";
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
';
			$html_result .='<!--GA new end-->';
		
			//-------------------------------------------->>>omniture<<<--------------------------------------------------en
			if(defined('OMNITURE_STATISTICS_OPEN') && OMNITURE_STATISTICS_OPEN==1){
			$html_result .='
<!--omniture-->
<script language="JavaScript" type="text/javascript" src="'.$tplar['cdn_javascript_url'].'s_encode.js"></script> 
<script language="JavaScript" type="text/javascript">';
			$html_result .="
s.pageName='".$tplar['pageName']."';
s.channel='".$tplar['channel']."';
s.prop1='".$tplar['prop1']."';
s.prop2='".$tplar['prop2']."';
s.prop3='".$tplar['prop3']."';
s.prop4='".$tplar['prop4']."';
";
			if(isset($tplar['reg60'])){			$html_result .='s.events="event5";';		}
			if($module=='thing' && $action=='item'){
			$html_result .="
s.events='prodView,event3';
s.products=';".$pid."';
";
			}
			else if($tplar['Omn_cart']!=''){
				$html_result .="
s.products=';".$tplar['Omn_cart']."';
s.events='scAdd';
";
			}
			else if($tplar['Omn_order']!=''){
				$html_result .="
s.products=';".$tplar['Omn_order']."';
s.eVar10='".$tplar['Omn_DiscountCode']."';
s.events='scCheckout';
";
			}
			if($tplar['be_omniture']=='be_omniture'){
				$html_result .="
s.purchaseID='".$tplar['OrdersId']."';
s.events='purchase,event7';
s.products='".$tplar['Omn_Products']."';
s.zip='".$tplar['Orders']['OrdersConsigneePostalcode']."';
s.state='".$tplar['Orders']['OrdersConsigneeCtiy']."';
s.eVar9='".$tplar['Countries']['name']."';
s.eVar5='".$tplar['Orders']['OrdersPayClass']."';
s.eVar6='".$tplar['Orders']['OrdersLogistics']."';			
";
			}
			if(isset($tplar['eVar3'])){
				$html_result .="s.eVar3='".$tplar['eVar3']."';";
				if($tplar['eVar3']=='search'){
					$html_result .="
	s.eVar1='".$tplar['select']['textfield']."';"; 
					if($tplar['page_t']==1){		
							if($tplar['num']==0){		
								$html_result .="s.events='event1,event2';";
							}else{
								$html_result .="s.events='event1';";
							}
					}		
				}
			}
			if(isset($tplar['eVar4'])){			
				$html_result .='
s.eVar4="'.$tplar['eVar4'].'";';		}
			if($tplar['Omn_login']=='login'){
				$html_result .="
s.events='event4';
s.eVar8='".$tplar['Omn_login_member']."';
";
			}else if($tplar['Omn_login']=='reg'){
				$html_result .="
s.events='event5';
s.eVar8='".$tplar['Omn_login_member']."';
";		
			}
			if($tplar['pageName']=='404page'){			$html_result .='s.pageType="errorPage";';		}
			if($tplar['pageName']=='del_mail'){			$html_result .='s.events="event9";';		}
			
			$html_result .="
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code)//--></script> 
<script language='JavaScript' type='text/javascript'><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
// --></script>
<noscript>
<img src='".$tplar['HTTP']."://milanoo.122.2o7.net/b/ss/milanoo-dev/1/H.22--NS/0'
height='1' width='1' border='0' alt='' />
</noscript>		
";
			$html_result .='<!--omniture end-->'; 
			}
			//-------------------------------------------------->>>Google Conversion Page<<<--------------------------------------------------en
			if($tplar['Omn_login']=='reg'){
				$html_result .='<!-- Google Conversion Page -->';
				$html_result .=<<<UNIQUE_CONV_1
 <script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1041876871;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "beqqCOWo4wEQh4_n8AM";
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/1041876871/?label=beqqCOWo4wEQh4_n8AM&amp;guid=ON&amp;script=0"/> </div>
</noscript>
<!-- Google Code for sign up Conversion Page (new account)-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1023548723;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "hpTvCLXV8QEQs7qI6AM";
var google_conversion_value = 0;
if (1) {
google_conversion_value = 1;
}
/* ]]> */
</script> 
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/1023548723/?value=1&amp;label=hpTvCLXV8QEQs7qI6AM&amp;guid=ON&amp;script=0"/> </div>
</noscript> 
<!--PPC 账户分拆-->
<!--1-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 964404181;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "PK7YCPOh3gIQ1cfuywM";
var google_conversion_value = 0;
if (1) {
google_conversion_value = 1;
}
/* ]]> */
</script>
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/964404181/?value=1&amp;label=PK7YCPOh3gIQ1cfuywM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<!--2-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 963956927;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "137_CPHS-AIQv6HTywM";
var google_conversion_value = 0;
if (1) {
google_conversion_value = 1;
}
/* ]]> */
</script>
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/963956927/?value=1&amp;label=137_CPHS-AIQv6HTywM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<!--3-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 964676925;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "ntvYCKu03QIQvZr_ywM";
var google_conversion_value = 0;
if (1) {
google_conversion_value = 1;
}
/* ]]> */
</script>
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/964676925/?value=1&amp;label=ntvYCKu03QIQvZr_ywM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<!--4-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 962760780;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "SpgfCMTt2QIQzKCKywM";
var google_conversion_value = 0;
if (1) {
google_conversion_value = 1;
}
/* ]]> */
</script>
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/962760780/?value=1&amp;label=SpgfCMTt2QIQzKCKywM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<!--5-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 975061990;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "SOzmCLqJzwIQ5of50AM";
var google_conversion_value = 0;
if (1) {
google_conversion_value = 1;
}
/* ]]> */
</script>
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/975061990/?value=1&amp;label=SOzmCLqJzwIQ5of50AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<!--6-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 966175387;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "39paCK289AIQm9XazAM";
var google_conversion_value = 0;
if (1) {
google_conversion_value = 1;
}
/* ]]> */
</script>
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/966175387/?value=1&amp;label=39paCK289AIQm9XazAM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<!--7-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 963071336;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "P_VfCJij8gIQ6JqdywM";
var google_conversion_value = 0;
if (1) {
google_conversion_value = 1;
}
/* ]]> */
</script>
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/963071336/?value=1&amp;label=P_VfCJij8gIQ6JqdywM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<!--8-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 964544815;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "zlH3CPm47AIQr5L3ywM";
var google_conversion_value = 0;
if (1) {
google_conversion_value = 1;
}
/* ]]> */
</script>
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/964544815/?value=1&amp;label=zlH3CPm47AIQr5L3ywM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<!--PPC 账户分拆 End--> 
UNIQUE_CONV_1;
				$html_result .='<!-- Google Conversion Page End-->';
			}
		//-------------------------------------------------->>>再营销<<<--------------------------------------------------en
			if($module=='thing' && $action=='item'){
				$productCategory=$smarty->_tpl_vars['productsDetails']['productCategory'];
				$parentCategories=\Helper\String::cat_ga_custom_var($productCategory,1);
				krsort($parentCategories);
				//remarketing plain
				$Remarket_code=\Helper\String::get_remarket_code($parentCategories);
				//remarketing 30
				$Remarket_code_30=\Helper\String::get_remarket_code($parentCategories,30);
				//remarketing 120
				$Remarket_code_120=\Helper\String::get_remarket_code($parentCategories,120);
				$html_result .='<!-- 再营销 --> ';
				if(!empty($Remarket_code)){
					$html_result .="
<!-- 再营销 plain--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 1023548723;
var google_conversion_language = 'en';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/1023548723/?label=".$Remarket_code."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 plain End--> ";
				}
				if(!empty($Remarket_code_30)){
					$html_result .="
<!-- 再营销 30--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 1023548723;
var google_conversion_language = 'en';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code_30."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/1023548723/?label=".$Remarket_code_30."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 30 End--> ";
				}
				if(!empty($Remarket_code_120)){
					$html_result .="
<!-- 再营销 120--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 1023548723;
var google_conversion_language = 'en';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code_120."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/1023548723/?label=".$Remarket_code_120."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 120 End--> ";
				}
				$html_result .='<!-- 再营销 End--> ';
			}
			
			if($module=='index' && $action=='index' ){
			
				$html_result.=<<<UNIQUE_REMARKET_CODE_1
<!--首页-->
<!-- Google Code for homepage visitor Remarketing List -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1023548723;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "lMgRCIW6pAIQs7qI6AM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1023548723/?label=lMgRCIW6pAIQs7qI6AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<!--30-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1023548723;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "COMcCI2DpwIQs7qI6AM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1023548723/?label=COMcCI2DpwIQs7qI6AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
UNIQUE_REMARKET_CODE_1;
			}
			//-------------------------------------------------->>>PPL<<<--------------------------------------------------en
			if(isset($tplar['subscribe_email_id']) && !$tplar['subscribe_email_id']){
				$html_result .='<!-- PPL--> ';
				$html_result .="
<div style='display:none'>
<img src='".$tplar['HTTP']."://track.linksynergy.com/ep?mid=36308&ord=".$tplar['subscribe_email_id']."&skulist=registration&qlist=1&amtlist=0&cur=USD&mail=".$tplar['subscribe_email']."&namelist=registration'>
</div>";
				$html_result .="
<!-- <webgains tracking code> -->
<script language='javascript' type='text/javascript'>
var wgOrderReference = '".$tplar['subscribe_email_id']."';			
";
				$html_result .=<<<UNIQUE_PPL_1
var wgOrderValue = "0";
var wgEventID = "8188";

var wgComment = "";
var wgLang = "en_US";
var wgsLang = "javascript-client";
var wgVersion = "1.2";
var wgProgramID = "4292";
var wgSubDomain = "track";
var wgCheckSum = "";
var wgItems = "";
var wgVoucherCode = "";
var wgCustomerID = "";

if(location.protocol.toLowerCase() == "https:") wgProtocol="https";
else wgProtocol = "http";

wgUri = wgProtocol + "://" + wgSubDomain + ".webgains.com/transaction.html" + "?wgver=" + wgVersion + "&wgprotocol=" + wgProtocol + "&wgsubdomain=" + wgSubDomain + "&wgslang=" + wgsLang + "&wglang=" + wgLang + "&wgprogramid=" + wgProgramID + "&wgeventid=" + wgEventID + "&wgvalue=" + wgOrderValue + "&wgchecksum=" + wgCheckSum + "&wgorderreference="  + wgOrderReference + "&wgcomment=" + escape(wgComment) + "&wglocation=" + escape(document.referrer) + "&wgitems=" + escape(wgItems) + "&wgcustomerid=" + escape(wgCustomerID) + "&wgvouchercode=" + escape(wgVoucherCode);
document.write('<sc'+'ript language="JavaScript"  type="text/javascript" src="'+wgUri+'"></sc'+'ript>');

</script>
UNIQUE_PPL_1;
				$html_result .="<noscript>
<img src='".$tplar['HTTP']."://track.webgains.com/transaction.html?wgver=1.2&wgprogramid=4292&wgrs=1&wgvalue=0&wgeventid=8188&wgorderreference=".$tplar['subscribe_email_id']."&wgitems=&wgcustomerid=&wgvouchercode=' alt='' />
</noscript>
<!-- </webgains tracking code> -->";
				$html_result .='<!-- PPL End--> ';
			}
	
				break;
			case 'ja-jp':
			//-------------------------------------------------->>>CNZZ<<<--------------------------------------------------jp
			// if($tplar['HTTP']=='http'){
				// $html_result .='
// <script src="http://s93.cnzz.com/stat.php?id=1129921&web_id=1129921" language="JavaScript" charset="gb2312"></script>';
			// }
			//-------------------------------------------------->>>GA old<<<-------------------------------------------------jp
			$html_result .='
<!--GA old-->';
			$html_result .='
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-11443273-1"]);
_gaq.push(["_trackPageview"]);
';
			if($tplar['google']=='google'){
				$html_result .="
_gaq.push(['_addTrans',
'".$tplar['OrdersId']."',		// order ID - required
'Milanoo_en',  // affiliation or store name
'".$tplar['OrdersAmount_Currency']."',		// total - required
'0.00',           // tax
'".$tplar['OrdersLogisticsCosts_Currency']."',		// shipping
'".$tplar['Orders']['OrdersConsigneeCtiy']."',		// city
'".$tplar['Orders']['OrdersConsigneeUrbanAreas']."',		// state or province
'".$tplar['Countries']['name']."',		// country
]);
";
				foreach($tplar['Cart_ga'] as $cart){
					$html_result .="
_gaq.push(['_addItem',
'".$tplar['OrdersId']."',		// order ID - required
'".$cart['ProductsId']."',				//SKU/code - required
'".$cart['ProductsName']."',				//product name
'".$cart['CategoryId']."',				//category or variation
'".$cart['ProductsPrice']."',				//unit price - required
'".$cart['ProductsNum']."',				//quantity - required
]);
";
				}
				$html_result .='_gaq.push(["_trackTrans"]); ';
			}
			$html_result .='
(function() {
var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
ga.src = ("https:" == document.location.protocol ? " https://ssl" : " http://www") + ".google-analytics.com/ga.js";
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
	';
			$html_result .='
<!--GA old end-->';
			//-------------------------------------------------->>>GA new<<<--------------------------------------------------jp
			$ga_custom_var='';
			if($module=='thing' && $action=='glist' && $cid!=''){
				$ga_custom_var=\Helper\String::get_ga_custom_var($action,$cid,$page);
			}else if ($module=='thing' && $action=='item'){
				$ga_custom_var=\Helper\String::get_ga_custom_var('item',$productCategory,0,$pid);
			}else{
				$ga_custom_var=\Helper\String::get_ga_pageview();
			}
		
			$html_result .='
<!--GA new-->';
			$html_result .='
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-26300554-1"]);
';
			if(isset($tplar['select']['textfield']) && $tplar['select']['textfield']!='Enter search keywords or item code here'){
				$html_result .='_gaq.push(["_trackPageview", "/jp/search/?q='.$tplar['select']['textfield'];
				if($tplar['select']['classid']){
					$html_result .='&c='.$tplar['select']['classid'].'"]);';
				}else{$html_result .='"]);';}
			}else{
				$html_result .='_gaq.push(["_trackPageview","'.$ga_custom_var.'"]);';
			}
			if($tplar['google']=='google'){
				$html_result .="
_gaq.push(['_addTrans',
'".$tplar['OrdersId']."',		// order ID - required
'Milanoo_en',  // affiliation or store name
'".$tplar['OrdersAmount_Currency']."',		// total - required
'0.00',           // tax
'".$tplar['OrdersLogisticsCosts_Currency']."',		// shipping
'".$tplar['Orders']['OrdersConsigneeCtiy']."',		// city
'".$tplar['Orders']['OrdersConsigneeUrbanAreas']."',		// state or province
'".$tplar['Countries']['name']."',		// country
]);
";
				foreach($tplar['Cart_ga'] as $cart){
					$html_result .="
_gaq.push(['_addItem',
'".$tplar['OrdersId']."',		// order ID - required
'".$cart['ProductsId']."',				//SKU/code - required
'".$cart['ProductsName']."',				//product name
'".$cart['CategoryId']."',				//category or variation
'".$cart['ProductsPrice']."',				//unit price - required
'".$cart['ProductsNum']."',				//quantity - required
]);
";
				}
				$html_result .='_gaq.push(["_trackTrans"]); ';
			}
			$html_result .='
(function() {
var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
ga.src = ("https:" == document.location.protocol ? " https://ssl" : " http://www") + ".google-analytics.com/ga.js";
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
';
			$html_result .='<!--GA new end-->';
		if(defined('OMNITURE_STATISTICS_OPEN') && OMNITURE_STATISTICS_OPEN==1){
			//-------------------------------------------->>>omniture<<<--------------------------------------------------jp
			$html_result .='
<!--omniture-->
<script language="JavaScript" type="text/javascript" src="'.$tplar['cdn_javascript_url'].'s_jpcode.js"></script> 
<script language="JavaScript" type="text/javascript">';
			$html_result .="
s.pageName='".$tplar['pageName']."';
s.channel='".$tplar['channel']."';
s.prop1='".$tplar['prop1']."';
s.prop2='".$tplar['prop2']."';
s.prop3='".$tplar['prop3']."';
s.prop4='".$tplar['prop4']."';
";
			if(isset($tplar['reg60'])){			$html_result .='s.events="event5";';		}
			if($module=='thing' && $action=='item'){
			$html_result .="
s.events='prodView,event3';
s.products=';".$pid."';
";
			}
			else if($tplar['Omn_cart']!=''){
				$html_result .="
s.products=';".$tplar['Omn_cart']."';
s.events='scAdd';
";
			}
			else if($tplar['Omn_order']!=''){
				$html_result .="
s.products=';".$tplar['Omn_order']."';
s.eVar10='".$tplar['Omn_DiscountCode']."';
s.events='scCheckout';
";
			}
			if($tplar['be_omniture']=='be_omniture'){
				$html_result .="
s.purchaseID='".$tplar['OrdersId']."';
s.events='purchase,event7';
s.products='".$tplar['Omn_Products']."';
s.zip='".$tplar['Orders']['OrdersConsigneePostalcode']."';
s.state='".$tplar['Orders']['OrdersConsigneeCtiy']."';
s.eVar9='".$tplar['Countries']['name']."';
s.eVar5='".$tplar['Orders']['OrdersPayClass']."';
s.eVar6='".$tplar['Orders']['OrdersLogistics']."';			
";
			}
			if(isset($tplar['eVar3'])){
				$html_result .="s.eVar3='".$tplar['eVar3']."';";
				if($tplar['eVar3']=='search'){
					$html_result .="
	s.eVar1='".$tplar['select']['textfield']."';"; 
					if($tplar['page_t']==1){		
							if($tplar['num']==0){		
								$html_result .="s.events='event1,event2';";
							}else{
								$html_result .="s.events='event1';";
							}
					}		
				}
			}
			if(isset($tplar['eVar4'])){			
				$html_result .='
s.eVar4="'.$tplar['eVar4'].'";';		}
			if($tplar['Omn_login']=='login'){
				$html_result .="
s.events='event4';
s.eVar8='".$tplar['Omn_login_member']."';
";
			}else if($tplar['Omn_login']=='reg'){
				$html_result .="
s.events='event5';
s.eVar8='".$tplar['Omn_login_member']."';
";		
			}
			if($tplar['pageName']=='404page'){			$html_result .='s.pageType="errorPage";';		}
			if($tplar['pageName']=='del_mail'){			$html_result .='s.events="event9";';		}
			$html_result .="
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code)//--></script> 
<script language='JavaScript' type='text/javascript'><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
//--></script>
<noscript>
<img src='".$tplar['HTTP']."://milanoo.122.2o7.net/b/ss/milanoo-dev/1/H.22--NS/0'
height='1' width='1' border='0' alt='' />
</noscript>		
";
			$html_result .='<!--omniture end-->';
			}
			//-------------------------------------------------->>>Google Conversion Page<<<--------------------------------------------------jp
			if($tplar['Omn_login']=='reg'){
				$html_result .='<!-- Google Conversion Page -->';
				$html_result .=<<<UNIQUE_CONV_1
 <script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 994899662;
var google_conversion_language = "jp";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "WjnRCMK19wEQzu2z2gM";
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/994899662/?label=WjnRCMK19wEQzu2z2gM&amp;guid=ON&amp;script=0"/> </div>
</noscript>
<!-- Google Code for &#30331;&#37682; Remarketing List -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 994899662;
var google_conversion_language = "jp";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "XJN_CLK39wEQzu2z2gM";
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/994899662/?value=1&amp;label=XJN_CLK39wEQzu2z2gM&amp;guid=ON&amp;script=0"/> </div>
</noscript> 
UNIQUE_CONV_1;
				$html_result .='<!-- Google Conversion Page End-->';
			}
		//-------------------------------------------------->>>再营销<<<--------------------------------------------------jp
			if($module=='thing' && $action=='item'){
				$html_result .='<!-- 再营销 --> ';
				if(!empty($Remarket_code)){
					$html_result .="
<!-- 再营销 plain--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 994899662;
var google_conversion_language = 'jp';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/994899662/?label=".$Remarket_code."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 plain End--> ";
				}
				if(!empty($Remarket_code_30)){
					$html_result .="
<!-- 再营销 30--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 994899662;
var google_conversion_language = 'jp';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code_30."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/994899662/?label=".$Remarket_code_30."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 30 End--> ";
				}
				if(!empty($Remarket_code_120)){
					$html_result .="
<!-- 再营销 120--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 994899662;
var google_conversion_language = 'en';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code_120."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/994899662/?label=".$Remarket_code_120."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 120 End--> ";
				}
				$html_result .='<!-- 再营销 End--> ';
			}
			if($tplar['Omn_login']=='reg'){
				$html_result.="
<!-- Google Code for &#30331;&#37682; Conversion Page -->
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 994899662;
var google_conversion_language = 'jp';
var google_conversion_format = '2';
var google_conversion_color = 'ffffff';
var google_conversion_label = 'WjnRCMK19wEQzu2z2gM';
var google_conversion_value = 0;
/* ]]> */
</script>
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'>
<img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/994899662/?label=WjnRCMK19wEQzu2z2gM&amp;guid=ON&amp;script=0'/>
</div>
</noscript>
<!-- Google Code for &#30331;&#37682; Remarketing List -->
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 994899662;
var google_conversion_language = 'jp';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = 'XJN_CLK39wEQzu2z2gM';
var google_conversion_value = 0;
/* ]]> */
</script>
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'>
<img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/994899662/?label=XJN_CLK39wEQzu2z2gM&amp;guid=ON&amp;script=0'/>
</div>
</noscript>";
			}
			if($tplar['Omn_cart']!=''){
				$html_result.="
<!-- Google Code for &#27880;&#25991; Conversion Page -->
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 994899662;
var google_conversion_language = 'jp';
var google_conversion_format = '2';
var google_conversion_color = 'ffffff';
var google_conversion_label = '9ZvSCLq29wEQzu2z2gM';
var google_conversion_value = 0;
/* ]]> */
</script>
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'>
<img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/994899662/?label=9ZvSCLq29wEQzu2z2gM&amp;guid=ON&amp;script=0'/>
</div>
</noscript>
<!-- Google Code for &#12459;&#12540;&#12488; Remarketing List -->
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 994899662;
var google_conversion_language = 'jp';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '-sdxCKK59wEQzu2z2gM';
var google_conversion_value = 0;
/* ]]> */
</script>
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'>
<img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/994899662/?label=-sdxCKK59wEQzu2z2gM&amp;guid=ON&amp;script=0'/>
</div>
</noscript>";
			}
			if($module=='index' && $action=='index' ){
				$html_result.=<<<UNIQUE_REMARKET_CODE_1
<!--首页-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 994899662;
var google_conversion_language = "jp";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "9N90CJK79wEQzu2z2gM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/994899662/?label=9N90CJK79wEQzu2z2gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!--30-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 994899662;
var google_conversion_language = "jp";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "gOE-COLQ7QIQzu2z2gM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/994899662/?label=gOE-COLQ7QIQzu2z2gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
UNIQUE_REMARKET_CODE_1;
			}
				break;
			case 'fr-fr':
			//-------------------------------------------------->>>CNZZ<<<--------------------------------------------------fr
			// if($tplar['HTTP']=='http'){
				// $html_result .='
// <script src="http://s13.cnzz.com/stat.php?id=2480181&web_id=2480181&show=pic1" language="JavaScript" charset="gb2312"></script>';
			// }
			//-------------------------------------------------->>>GA old<<<-------------------------------------------------fr
			$html_result .='
<!--GA old-->';
			$html_result .='
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-18943674-1"]);
_gaq.push(["_trackPageview"]);
';
			if($tplar['google']=='google'){
				$html_result .="
_gaq.push(['_addTrans',
'".$tplar['OrdersId']."',		// order ID - required
'Milanoo_en',  // affiliation or store name
'".$tplar['OrdersAmount_Currency']."',		// total - required
'0.00',           // tax
'".$tplar['OrdersLogisticsCosts_Currency']."',		// shipping
'".$tplar['Orders']['OrdersConsigneeCtiy']."',		// city
'".$tplar['Orders']['OrdersConsigneeUrbanAreas']."',		// state or province
'".$tplar['Countries']['name']."',		// country
]);
";
				foreach($tplar['Cart_ga'] as $cart){
					$html_result .="
_gaq.push(['_addItem',
'".$tplar['OrdersId']."',		// order ID - required
'".$cart['ProductsId']."',				//SKU/code - required
'".$cart['ProductsName']."',				//product name
'".$cart['CategoryId']."',				//category or variation
'".$cart['ProductsPrice']."',				//unit price - required
'".$cart['ProductsNum']."',				//quantity - required
]);
";
				}
				$html_result .='_gaq.push(["_trackTrans"]); ';
			}
			$html_result .='
(function() {
var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
ga.src = ("https:" == document.location.protocol ? " https://ssl" : " http://www") + ".google-analytics.com/ga.js";
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
})();
</script>';
			$html_result .='
<!--GA old end-->';
			//-------------------------------------------------->>>GA new<<<--------------------------------------------------fr
			$ga_custom_var='';
			if($module=='thing' && $action=='glist' && $cid!=''){
				$ga_custom_var=\Helper\String::get_ga_custom_var($action,$cid,$page);
			}else if ($module=='thing' && $action=='item'){
				$ga_custom_var=\Helper\String::get_ga_custom_var('item',$productCategory,0,$pid);
			}else{
				$ga_custom_var=\Helper\String::get_ga_pageview();
			}
		
			$html_result .='
<!--GA new-->';
			$html_result .='
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-26300554-1"]);
';
			if(isset($tplar['select']['textfield']) && $tplar['select']['textfield']!='Enter search keywords or item code here'){
				$html_result .='_gaq.push(["_trackPageview", "/fr/search/?q='.$tplar['select']['textfield'];
				if($tplar['select']['classid']){
					$html_result .='&c='.$tplar['select']['classid'].'"]);';
				}else{$html_result .='"]);';}
			}else{
				$html_result .='_gaq.push(["_trackPageview","'.$ga_custom_var.'"]);';
			}
			if($tplar['google']=='google'){
				$html_result .="
_gaq.push(['_addTrans',
'".$tplar['OrdersId']."',		// order ID - required
'Milanoo_en',  // affiliation or store name
'".$tplar['OrdersAmount_Currency']."',		// total - required
'0.00',           // tax
'".$tplar['OrdersLogisticsCosts_Currency']."',		// shipping
'".$tplar['Orders']['OrdersConsigneeCtiy']."',		// city
'".$tplar['Orders']['OrdersConsigneeUrbanAreas']."',		// state or province
'".$tplar['Countries']['name']."',		// country
]);
";
				foreach($tplar['Cart_ga'] as $cart){
					$html_result .="
_gaq.push(['_addItem',
'".$tplar['OrdersId']."',		// order ID - required
'".$cart['ProductsId']."',				//SKU/code - required
'".$cart['ProductsName']."',				//product name
'".$cart['CategoryId']."',				//category or variation
'".$cart['ProductsPrice']."',				//unit price - required
'".$cart['ProductsNum']."',				//quantity - required
]);
";
				}
				$html_result .='_gaq.push(["_trackTrans"]); ';
			}
			$html_result .='
(function() {
var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
ga.src = ("https:" == document.location.protocol ? " https://ssl" : " http://www") + ".google-analytics.com/ga.js";
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
';
			$html_result .='<!--GA new end-->';
		
			//-------------------------------------------->>>omniture<<<--------------------------------------------------fr
			if(defined('OMNITURE_STATISTICS_OPEN') && OMNITURE_STATISTICS_OPEN==1){
			$html_result .='
<!--omniture-->
<script language="JavaScript" type="text/javascript" src="'.$tplar['cdn_javascript_url'].'s_frcode.js"></script> 
<script language="JavaScript" type="text/javascript">';
			$html_result .="
s.pageName='".$tplar['pageName']."';
s.channel='".$tplar['channel']."';
s.prop1='".$tplar['prop1']."';
s.prop2='".$tplar['prop2']."';
s.prop3='".$tplar['prop3']."';
s.prop4='".$tplar['prop4']."';
";
			if(isset($tplar['reg60'])){			$html_result .='s.events="event5";';		}
			if($module=='thing' && $action=='item'){
			$html_result .="
s.events='prodView,event3';
s.products=';".$pid."';
";
			}
			else if($tplar['Omn_cart']!=''){
				$html_result .="
s.products=';".$tplar['Omn_cart']."';
s.events='scAdd';
";
			}
			else if($tplar['Omn_order']!=''){
				$html_result .="
s.products=';".$tplar['Omn_order']."';
s.eVar10='".$tplar['Omn_DiscountCode']."';
s.events='scCheckout';
";
			}
			if($tplar['be_omniture']=='be_omniture'){
				$html_result .="
s.purchaseID='".$tplar['OrdersId']."';
s.events='purchase,event7';
s.products='".$tplar['Omn_Products']."';
s.zip='".$tplar['Orders']['OrdersConsigneePostalcode']."';
s.state='".$tplar['Orders']['OrdersConsigneeCtiy']."';
s.eVar9='".$tplar['Countries']['name']."';
s.eVar5='".$tplar['Orders']['OrdersPayClass']."';
s.eVar6='".$tplar['Orders']['OrdersLogistics']."';			
";
			}
			if(isset($tplar['eVar3'])){
				$html_result .="s.eVar3='".$tplar['eVar3']."';";
				if($tplar['eVar3']=='search'){
					$html_result .="
	s.eVar1='".$tplar['select']['textfield']."';"; 
					if($tplar['page_t']==1){		
							if($tplar['num']==0){		
								$html_result .="s.events='event1,event2';";
							}else{
								$html_result .="s.events='event1';";
							}
					}		
				}
			}
			if(isset($tplar['eVar4'])){			
				$html_result .='
s.eVar4="'.$tplar['eVar4'].'";';		}
			if($tplar['Omn_login']=='login'){
				$html_result .="
s.events='event4';
s.eVar8='".$tplar['Omn_login_member']."';
";
			}else if($tplar['Omn_login']=='reg'){
				$html_result .="
s.events='event5';
s.eVar8='".$tplar['Omn_login_member']."';
";		
			}
			if($tplar['pageName']=='404page'){			$html_result .='s.pageType="errorPage";';		}
			if($tplar['pageName']=='del_mail'){			$html_result .='s.events="event9";';		}
			$html_result .="
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code)//--></script> 
<script language='JavaScript' type='text/javascript'><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
//--></script>
<noscript>
<img src='".$tplar['HTTP']."://milanoo.122.2o7.net/b/ss/milanoo-dev/1/H.22--NS/0'
height='1' width='1' border='0' alt='' />
</noscript>		
";
			$html_result .='<!--omniture end-->';
			}
			//-------------------------------------------------->>>Google Conversion Page<<<--------------------------------------------------fr
			if($tplar['Omn_login']=='reg'){
				$html_result .='<!-- Google Conversion Page -->';
				$html_result .=<<<UNIQUE_CONV_1
 <script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 996040848;
var google_conversion_language = "fr";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "7tK4CMiJ9wEQkMH52gM";
var google_conversion_value = 0;
if (1) {
  google_conversion_value = 1;
}
/* ]]> */
</script> 
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/996040848/?label=7tK4CMiJ9wEQkMH52gM&amp;guid=ON&amp;script=0"/> </div>
</noscript>
<!-- Google Code for sign up Conversion Page (new account)-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 977520546;
var google_conversion_language = "fr";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "FStyCMaHpAIQoo-P0gM";
var google_conversion_value = 0;
if (1) {
google_conversion_value = 1;
}
/* ]]> */
</script> 
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/977520546/?value=1&amp;label=FStyCMaHpAIQoo-P0gM&amp;guid=ON&amp;script=0"/> </div>
</noscript> 
UNIQUE_CONV_1;
				$html_result .='<!-- Google Conversion Page End-->';
			}
		//-------------------------------------------------->>>再营销<<<--------------------------------------------------fr
			if($module=='thing' && $action=='item'){
				$html_result .='<!-- 再营销 --> ';
				if(!empty($Remarket_code)){
					$html_result .="
<!-- 再营销 plain--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 977520546;
var google_conversion_language = 'fr';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/977520546/?label=".$Remarket_code."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 plain End--> ";
				}
				if(!empty($Remarket_code_30)){
					$html_result .="
<!-- 再营销 30--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 977520546;
var google_conversion_language = 'fr';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code_30."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/977520546/?label=".$Remarket_code_30."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 30 End--> ";
				}
				if(!empty($Remarket_code_120)){
					$html_result .="
<!-- 再营销 120--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 977520546;
var google_conversion_language = 'en';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code_120."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/977520546/?label=".$Remarket_code_120."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 120 End--> ";
				}
				$html_result .='<!-- 再营销 End--> ';
			}
				break;
			case 'de-ge':
			//-------------------------------------------------->>>CNZZ<<<--------------------------------------------------de
			// if($tplar['HTTP']=='http'){
				// $html_result .='
// <script src="http://s15.cnzz.com/stat.php?id=2659039&web_id=2659039&show=pic1" language="JavaScript" charset="gb2312"></script>';
			// }
			//-------------------------------------------->>>omniture<<<--------------------------------------------------de
			if(defined('OMNITURE_STATISTICS_OPEN') && OMNITURE_STATISTICS_OPEN==1){
			$html_result .='
<!--omniture-->
<script language="JavaScript" type="text/javascript" src="'.$tplar['cdn_javascript_url'].'s_decode.js"></script> 
<script language="JavaScript" type="text/javascript">';
			$html_result .="
s.pageName='".$tplar['pageName']."';
s.channel='".$tplar['channel']."';
s.prop1='".$tplar['prop1']."';
s.prop2='".$tplar['prop2']."';
s.prop3='".$tplar['prop3']."';
s.prop4='".$tplar['prop4']."';
";
			if(isset($tplar['reg60'])){			$html_result .='s.events="event5";';		}
			if($module=='thing' && $action=='item'){
			$html_result .="
s.events='prodView,event3';
s.products=';".$pid."';
";
			}
			else if($tplar['Omn_cart']!=''){
				$html_result .="
s.products=';".$tplar['Omn_cart']."';
s.events='scAdd';
";
			}
			else if($tplar['Omn_order']!=''){
				$html_result .="
s.products=';".$tplar['Omn_order']."';
s.eVar10='".$tplar['Omn_DiscountCode']."';
s.events='scCheckout';
";
			}
			if($tplar['be_omniture']=='be_omniture'){
				$html_result .="
s.purchaseID='".$tplar['OrdersId']."';
s.events='purchase,event7';
s.products='".$tplar['Omn_Products']."';
s.zip='".$tplar['Orders']['OrdersConsigneePostalcode']."';
s.state='".$tplar['Orders']['OrdersConsigneeCtiy']."';
s.eVar9='".$tplar['Countries']['name']."';
s.eVar5='".$tplar['Orders']['OrdersPayClass']."';
s.eVar6='".$tplar['Orders']['OrdersLogistics']."';			
";
			}
			if(isset($tplar['eVar3'])){
				$html_result .="s.eVar3='".$tplar['eVar3']."';";
				if($tplar['eVar3']=='search'){
					$html_result .="
	s.eVar1='".$tplar['select']['textfield']."';"; 
					if($tplar['page_t']==1){		
							if($tplar['num']==0){		
								$html_result .="s.events='event1,event2';";
							}else{
								$html_result .="s.events='event1';";
							}
					}		
				}
			}
			if(isset($tplar['eVar4'])){			
				$html_result .='
s.eVar4="'.$tplar['eVar4'].'";';		}
			if($tplar['Omn_login']=='login'){
				$html_result .="
s.events='event4';
s.eVar8='".$tplar['Omn_login_member']."';
";
			}else if($tplar['Omn_login']=='reg'){
				$html_result .="
s.events='event5';
s.eVar8='".$tplar['Omn_login_member']."';
";		
			}
			if($tplar['pageName']=='404page'){			$html_result .='s.pageType="errorPage";';		}
			if($tplar['pageName']=='del_mail'){			$html_result .='s.events="event9";';		}
			$html_result .="
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code)//--></script> 
<script language='JavaScript' type='text/javascript'><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
//--></script>
<noscript>
<img src='".$tplar['HTTP']."://milanoo.122.2o7.net/b/ss/milanoo-dev/1/H.22--NS/0'
height='1' width='1' border='0' alt='' />
</noscript>		
";
			$html_result .='<!--omniture end-->';
			}
			//-------------------------------------------------->>>GA old<<<-------------------------------------------------de
			$html_result .='
<!--GA old-->';
			$html_result .='
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-20214541-1"]);
_gaq.push(["_trackPageview"]);
';
			if($tplar['google']=='google'){
				$html_result .="
_gaq.push(['_addTrans',
'".$tplar['OrdersId']."',		// order ID - required
'Milanoo_en',  // affiliation or store name
'".$tplar['OrdersAmount_Currency']."',		// total - required
'0.00',           // tax
'".$tplar['OrdersLogisticsCosts_Currency']."',		// shipping
'".$tplar['Orders']['OrdersConsigneeCtiy']."',		// city
'".$tplar['Orders']['OrdersConsigneeUrbanAreas']."',		// state or province
'".$tplar['Countries']['name']."',		// country
]);
";
				foreach($tplar['Cart_ga'] as $cart){
					$html_result .="
_gaq.push(['_addItem',
'".$tplar['OrdersId']."',		// order ID - required
'".$cart['ProductsId']."',				//SKU/code - required
'".$cart['ProductsName']."',				//product name
'".$cart['CategoryId']."',				//category or variation
'".$cart['ProductsPrice']."',				//unit price - required
'".$cart['ProductsNum']."',				//quantity - required
]);
";
				}
				$html_result .='_gaq.push(["_trackTrans"]); ';
			}
			$html_result .='
(function() {
var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
ga.src = ("https:" == document.location.protocol ? " https://ssl" : " http://www") + ".google-analytics.com/ga.js";
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
	';
			$html_result .='
<!--GA old end-->';
			//-------------------------------------------------->>>GA new<<<--------------------------------------------------de
			$ga_custom_var='';
			if($module=='thing' && $action=='glist' && $cid!=''){
				$ga_custom_var=\Helper\String::get_ga_custom_var($action,$cid,$page);
			}else if ($module=='thing' && $action=='item'){
				$ga_custom_var=\Helper\String::get_ga_custom_var('item',$productCategory,0,$pid);
			}else{
				$ga_custom_var=\Helper\String::get_ga_pageview();
			}
		
			$html_result .='
<!--GA new-->';
			$html_result .='
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-26300554-1"]);
';
			if(isset($tplar['select']['textfield']) && $tplar['select']['textfield']!='Enter search keywords or item code here'){
				$html_result .='_gaq.push(["_trackPageview", "/de/search/?q='.$tplar['select']['textfield'];
				if($tplar['select']['classid']){
					$html_result .='&c='.$tplar['select']['classid'].'"]);';
				}else{$html_result .='"]);';}
			}else{
				$html_result .='_gaq.push(["_trackPageview","'.$ga_custom_var.'"]);';
			}
			if($tplar['google']=='google'){
				$html_result .="
_gaq.push(['_addTrans',
'".$tplar['OrdersId']."',		// order ID - required
'Milanoo_en',  // affiliation or store name
'".$tplar['OrdersAmount_Currency']."',		// total - required
'0.00',           // tax
'".$tplar['OrdersLogisticsCosts_Currency']."',		// shipping
'".$tplar['Orders']['OrdersConsigneeCtiy']."',		// city
'".$tplar['Orders']['OrdersConsigneeUrbanAreas']."',		// state or province
'".$tplar['Countries']['name']."',		// country
]);
";
				foreach($tplar['Cart_ga'] as $cart){
					$html_result .="
_gaq.push(['_addItem',
'".$tplar['OrdersId']."',		// order ID - required
'".$cart['ProductsId']."',				//SKU/code - required
'".$cart['ProductsName']."',				//product name
'".$cart['CategoryId']."',				//category or variation
'".$cart['ProductsPrice']."',				//unit price - required
'".$cart['ProductsNum']."',				//quantity - required
]);
";
				}
				$html_result .='_gaq.push(["_trackTrans"]); ';
			}
			$html_result .='
(function() {
var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
ga.src = ("https:" == document.location.protocol ? " https://ssl" : " http://www") + ".google-analytics.com/ga.js";
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
';
			$html_result .='<!--GA new end-->';
			//-------------------------------------------------->>>Google Conversion Page<<<--------------------------------------------------de
			if($tplar['Omn_login']=='reg'){
				$html_result .='<!-- Google Conversion Page -->';
				$html_result .=<<<UNIQUE_CONV_1
 <script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1008675766;
var google_conversion_language = "de";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "TrkPCIKC-QEQttf84AM";
var google_conversion_value = 0;
if (1) {
  google_conversion_value = 1;
}
/* ]]> */
</script> 
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/1008675766/?label=TrkPCIKC-QEQttf84AM&amp;guid=ON&amp;script=0"/> </div>
</noscript>
<!-- Google Code for sign up Conversion Page (new account)-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 976531739;
var google_conversion_language = "de";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "9tQnCN3pvQIQm-LS0QM";
var google_conversion_value = 0;
if (1) {
google_conversion_value = 1;
}
/* ]]> */
</script> 
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/976531739/?value=1&amp;label=9tQnCN3pvQIQm-LS0QM&amp;guid=ON&amp;script=0"/> </div>
</noscript> 
UNIQUE_CONV_1;
				$html_result .='<!-- Google Conversion Page End-->';
			}
		//-------------------------------------------------->>>再营销<<<--------------------------------------------------de
			if($module=='thing' && $action=='item'){
				$html_result .='<!-- 再营销 --> ';
				if(!empty($Remarket_code)){
					$html_result .="
<!-- 再营销 plain--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 976531739;
var google_conversion_language = 'de';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/976531739/?label=".$Remarket_code."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 plain End--> ";
				}
				if(!empty($Remarket_code_30)){
					$html_result .="
<!-- 再营销 30--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 976531739;
var google_conversion_language = 'de';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code_30."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/976531739/?label=".$Remarket_code_30."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 30 End--> ";
				}
				if(!empty($Remarket_code_120)){
					$html_result .="
<!-- 再营销 120--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 976531739;
var google_conversion_language = 'de';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code_120."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/976531739/?label=".$Remarket_code_120."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 120 End--> ";
				}
				$html_result .='<!-- 再营销 End--> ';
			}
				break;
			case 'es-sp':
				//-------------------------------------------------->>>CNZZ<<<--------------------------------------------------es
			// if($tplar['HTTP']=='http'){
				// $html_result .='
// <script src="http://s13.cnzz.com/stat.php?id=2611677&web_id=2611677&show=pic1" language="JavaScript" charset="gb2312"></script>';
			// }
			//-------------------------------------------->>>omniture<<<--------------------------------------------------de
			if(defined('OMNITURE_STATISTICS_OPEN') && OMNITURE_STATISTICS_OPEN==1){
			$html_result .='
<!--omniture-->
<script language="JavaScript" type="text/javascript" src="'.$tplar['cdn_javascript_url'].'s_escode.js"></script> 
<script language="JavaScript" type="text/javascript">';
			$html_result .="
s.pageName='".$tplar['pageName']."';
s.channel='".$tplar['channel']."';
s.prop1='".$tplar['prop1']."';
s.prop2='".$tplar['prop2']."';
s.prop3='".$tplar['prop3']."';
s.prop4='".$tplar['prop4']."';
";
			if(isset($tplar['reg60'])){			$html_result .='s.events="event5";';		}
			if($module=='thing' && $action=='item'){
			$html_result .="
s.events='prodView,event3';
s.products=';".$pid."';
";
			}
			else if($tplar['Omn_cart']!=''){
				$html_result .="
s.products=';".$tplar['Omn_cart']."';
s.events='scAdd';
";
			}
			else if($tplar['Omn_order']!=''){
				$html_result .="
s.products=';".$tplar['Omn_order']."';
s.eVar10='".$tplar['Omn_DiscountCode']."';
s.events='scCheckout';
";
			}
			if($tplar['be_omniture']=='be_omniture'){
				$html_result .="
s.purchaseID='".$tplar['OrdersId']."';
s.events='purchase,event7';
s.products='".$tplar['Omn_Products']."';
s.zip='".$tplar['Orders']['OrdersConsigneePostalcode']."';
s.state='".$tplar['Orders']['OrdersConsigneeCtiy']."';
s.eVar9='".$tplar['Countries']['name']."';
s.eVar5='".$tplar['Orders']['OrdersPayClass']."';
s.eVar6='".$tplar['Orders']['OrdersLogistics']."';			
";
			}
			if(isset($tplar['eVar3'])){
				$html_result .="s.eVar3='".$tplar['eVar3']."';";
				if($tplar['eVar3']=='search'){
					$html_result .="
	s.eVar1='".$tplar['select']['textfield']."';"; 
					if($tplar['page_t']==1){		
							if($tplar['num']==0){		
								$html_result .="s.events='event1,event2';";
							}else{
								$html_result .="s.events='event1';";
							}
					}		
				}
			}
			if(isset($tplar['eVar4'])){			
				$html_result .='
s.eVar4="'.$tplar['eVar4'].'";';		}
			if($tplar['Omn_login']=='login'){
				$html_result .="
s.events='event4';
s.eVar8='".$tplar['Omn_login_member']."';
";
			}else if($tplar['Omn_login']=='reg'){
				$html_result .="
s.events='event5';
s.eVar8='".$tplar['Omn_login_member']."';
";		
			}
			if($tplar['pageName']=='404page'){			$html_result .='s.pageType="errorPage";';		}
			if($tplar['pageName']=='del_mail'){			$html_result .='s.events="event9";';		}
			$html_result .="
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code)//--></script> 
<script language='JavaScript' type='text/javascript'><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
//--></script>
<noscript>
<img src='".$tplar['HTTP']."://milanoo.122.2o7.net/b/ss/milanoo-dev/1/H.22--NS/0'
height='1' width='1' border='0' alt='' />
</noscript>		
";
			$html_result .='<!--omniture end-->';
			}
			//-------------------------------------------------->>>GA old<<<-------------------------------------------------es
			$html_result .='
<!--GA old-->';
			$html_result .='
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-19946518-1"]);
_gaq.push(["_trackPageview"]);
';
			if($tplar['google']=='google'){
				$html_result .="
_gaq.push(['_addTrans',
'".$tplar['OrdersId']."',		// order ID - required
'Milanoo_en',  // affiliation or store name
'".$tplar['OrdersAmount_Currency']."',		// total - required
'0.00',           // tax
'".$tplar['OrdersLogisticsCosts_Currency']."',		// shipping
'".$tplar['Orders']['OrdersConsigneeCtiy']."',		// city
'".$tplar['Orders']['OrdersConsigneeUrbanAreas']."',		// state or province
'".$tplar['Countries']['name']."',		// country
]);
";
				foreach($tplar['Cart_ga'] as $cart){
					$html_result .="
_gaq.push(['_addItem',
'".$tplar['OrdersId']."',		// order ID - required
'".$cart['ProductsId']."',				//SKU/code - required
'".$cart['ProductsName']."',				//product name
'".$cart['CategoryId']."',				//category or variation
'".$cart['ProductsPrice']."',				//unit price - required
'".$cart['ProductsNum']."',				//quantity - required
]);
";
				}
				$html_result .='_gaq.push(["_trackTrans"]); ';
			}
			$html_result .='
(function() {
var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
ga.src = ("https:" == document.location.protocol ? " https://ssl" : " http://www") + ".google-analytics.com/ga.js";
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
	';
			$html_result .='
<!--GA old end-->';
			//-------------------------------------------------->>>GA new<<<--------------------------------------------------es
			$ga_custom_var='';
			if($module=='thing' && $action=='glist' && $cid!=''){
				$ga_custom_var=\Helper\String::get_ga_custom_var($action,$cid,$page);
			}else if ($module=='thing' && $action=='item'){
				$ga_custom_var=\Helper\String::get_ga_custom_var('item',$productCategory,0,$pid);
			}else{
				$ga_custom_var=\Helper\String::get_ga_pageview();
			}
		
			$html_result .='
<!--GA new-->';
			$html_result .='
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-26300554-1"]);
';
			if(isset($tplar['select']['textfield']) && $tplar['select']['textfield']!='Enter search keywords or item code here'){
				$html_result .='_gaq.push(["_trackPageview", "/es/search/?q='.$tplar['select']['textfield'];
				if($tplar['select']['classid']){
					$html_result .='&c='.$tplar['select']['classid'].'"]);';
				}else{$html_result .='"]);';}
			}else{
				$html_result .='_gaq.push(["_trackPageview","'.$ga_custom_var.'"]);';
			}
			if($tplar['google']=='google'){
				$html_result .="
_gaq.push(['_addTrans',
'".$tplar['OrdersId']."',		// order ID - required
'Milanoo_en',  // affiliation or store name
'".$tplar['OrdersAmount_Currency']."',		// total - required
'0.00',           // tax
'".$tplar['OrdersLogisticsCosts_Currency']."',		// shipping
'".$tplar['Orders']['OrdersConsigneeCtiy']."',		// city
'".$tplar['Orders']['OrdersConsigneeUrbanAreas']."',		// state or province
'".$tplar['Countries']['name']."',		// country
]);
";
				foreach($tplar['Cart_ga'] as $cart){
					$html_result .="
_gaq.push(['_addItem',
'".$tplar['OrdersId']."',		// order ID - required
'".$cart['ProductsId']."',				//SKU/code - required
'".$cart['ProductsName']."',				//product name
'".$cart['CategoryId']."',				//category or variation
'".$cart['ProductsPrice']."',				//unit price - required
'".$cart['ProductsNum']."',				//quantity - required
]);
";
				}
				$html_result .='_gaq.push(["_trackTrans"]); ';
			}
			$html_result .='
(function() {
var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
ga.src = ("https:" == document.location.protocol ? " https://ssl" : " http://www") + ".google-analytics.com/ga.js";
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
';
			$html_result .='<!--GA new end-->';
			//-------------------------------------------------->>>Google Conversion Page<<<--------------------------------------------------es
			if($tplar['Omn_login']=='reg'){
				$html_result .='<!-- Google Conversion Page -->';
				$html_result .=<<<UNIQUE_CONV_1
 <script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1024823597;
var google_conversion_language = "es";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "MBVrCKXV_gEQraLW6AM";
var google_conversion_value = 0;
if (1) {
  google_conversion_value = 1;
}
/* ]]> */
</script> 
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/1024823597/?label=MBVrCKXV_gEQraLW6AM&amp;guid=ON&amp;script=0"/> </div>
</noscript>
<!-- Google Code for sign up Conversion Page (new account)-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 976654016;
var google_conversion_language = "es";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "sUo2CNjtxgIQwJ3a0QM";
var google_conversion_value = 0;
if (1) {
google_conversion_value = 1;
}
/* ]]> */
</script> 
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/976654016/?value=1&amp;label=sUo2CNjtxgIQwJ3a0QM&amp;guid=ON&amp;script=0"/> </div>
</noscript> 
UNIQUE_CONV_1;
				$html_result .='<!-- Google Conversion Page End-->';
			}
		//-------------------------------------------------->>>再营销<<<--------------------------------------------------es
			if($module=='thing' && $action=='item'){
				$html_result .='<!-- 再营销 --> ';
				if(!empty($Remarket_code)){
					$html_result .="
<!-- 再营销 plain--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 976654016;
var google_conversion_language = 'es';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/976654016/?label=".$Remarket_code."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 plain End--> ";
				}
				if(!empty($Remarket_code_30)){
					$html_result .="
<!-- 再营销 30--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 976654016;
var google_conversion_language = 'es';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code_30."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/976654016/?label=".$Remarket_code_30."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 30 End--> ";
				}
				if(!empty($Remarket_code_120)){
					$html_result .="
<!-- 再营销 120--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 976654016;
var google_conversion_language = 'es';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code_120."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/976654016/?label=".$Remarket_code_120."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 120 End--> ";
				}
				$html_result .='<!-- 再营销 End--> ';
			}
			if($module=='index' && $action=='index'){
				$html_result .=<<<UNIQUE_REMARKET_CODE_3
<!--首页-->
<!-- Google Code for &#39318;&#39029; Remarketing List -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 976654016;
var google_conversion_language = "es";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "OSo-CKiggwMQwJ3a0QM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/976654016/?label=OSo-CKiggwMQwJ3a0QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>				
UNIQUE_REMARKET_CODE_3;
			}
				break;
			case 'it-it':
				//-------------------------------------------------->>>CNZZ<<<--------------------------------------------------it
			// if($tplar['HTTP']=='http'){
				// $html_result .='
// <script src="http://s15.cnzz.com/stat.php?id=2659067&web_id=2659067&show=pic1" language="JavaScript" charset="gb2312"></script>';
			// }
			//-------------------------------------------->>>omniture<<<--------------------------------------------------it
			if(defined('OMNITURE_STATISTICS_OPEN') && OMNITURE_STATISTICS_OPEN==1){
			$html_result .='
<!--omniture-->
<script language="JavaScript" type="text/javascript" src="'.$tplar['cdn_javascript_url'].'s_itcode.js"></script> 
<script language="JavaScript" type="text/javascript">';
			$html_result .="
s.pageName='".$tplar['pageName']."';
s.channel='".$tplar['channel']."';
s.prop1='".$tplar['prop1']."';
s.prop2='".$tplar['prop2']."';
s.prop3='".$tplar['prop3']."';
s.prop4='".$tplar['prop4']."';
";
			if(isset($tplar['reg60'])){			$html_result .='s.events="event5";';		}
			if($module=='thing' && $action=='item'){
			$html_result .="
s.events='prodView,event3';
s.products=';".$pid."';
";
			}
			else if($tplar['Omn_cart']!=''){
				$html_result .="
s.products=';".$tplar['Omn_cart']."';
s.events='scAdd';
";
			}
			else if($tplar['Omn_order']!=''){
				$html_result .="
s.products=';".$tplar['Omn_order']."';
s.eVar10='".$tplar['Omn_DiscountCode']."';
s.events='scCheckout';
";
			}
			if($tplar['be_omniture']=='be_omniture'){
				$html_result .="
s.purchaseID='".$tplar['OrdersId']."';
s.events='purchase,event7';
s.products='".$tplar['Omn_Products']."';
s.zip='".$tplar['Orders']['OrdersConsigneePostalcode']."';
s.state='".$tplar['Orders']['OrdersConsigneeCtiy']."';
s.eVar9='".$tplar['Countries']['name']."';
s.eVar5='".$tplar['Orders']['OrdersPayClass']."';
s.eVar6='".$tplar['Orders']['OrdersLogistics']."';			
";
			}
			if(isset($tplar['eVar3'])){
				$html_result .="s.eVar3='".$tplar['eVar3']."';";
				if($tplar['eVar3']=='search'){
					$html_result .="
	s.eVar1='".$tplar['select']['textfield']."';"; 
					if($tplar['page_t']==1){		
							if($tplar['num']==0){		
								$html_result .="s.events='event1,event2';";
							}else{
								$html_result .="s.events='event1';";
							}
					}		
				}
			}
			if(isset($tplar['eVar4'])){			
				$html_result .='
s.eVar4="'.$tplar['eVar4'].'";';		}
			if($tplar['Omn_login']=='login'){
				$html_result .="
s.events='event4';
s.eVar8='".$tplar['Omn_login_member']."';
";
			}else if($tplar['Omn_login']=='reg'){
				$html_result .="
s.events='event5';
s.eVar8='".$tplar['Omn_login_member']."';
";		
			}
			if($tplar['pageName']=='404page'){			$html_result .='s.pageType="errorPage";';		}
			if($tplar['pageName']=='del_mail'){			$html_result .='s.events="event9";';		}
			$html_result .="
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code)//--></script> 
<script language='JavaScript' type='text/javascript'><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
//--></script>
<noscript>
<img src='".$tplar['HTTP']."://milanoo.122.2o7.net/b/ss/milanoo-dev/1/H.22--NS/0'
height='1' width='1' border='0' alt='' />
</noscript>		
";
			$html_result .='<!--omniture end-->';
			}
			//-------------------------------------------------->>>GA old<<<-------------------------------------------------it
			$html_result .='
<!--GA old-->';
			$html_result .='
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-20215100-1"]);
_gaq.push(["_trackPageview"]);
';
			if($tplar['google']=='google'){
				$html_result .="
_gaq.push(['_addTrans',
'".$tplar['OrdersId']."',		// order ID - required
'Milanoo_en',  // affiliation or store name
'".$tplar['OrdersAmount_Currency']."',		// total - required
'0.00',           // tax
'".$tplar['OrdersLogisticsCosts_Currency']."',		// shipping
'".$tplar['Orders']['OrdersConsigneeCtiy']."',		// city
'".$tplar['Orders']['OrdersConsigneeUrbanAreas']."',		// state or province
'".$tplar['Countries']['name']."',		// country
]);
";
				foreach($tplar['Cart_ga'] as $cart){
					$html_result .="
_gaq.push(['_addItem',
'".$tplar['OrdersId']."',		// order ID - required
'".$cart['ProductsId']."',				//SKU/code - required
'".$cart['ProductsName']."',				//product name
'".$cart['CategoryId']."',				//category or variation
'".$cart['ProductsPrice']."',				//unit price - required
'".$cart['ProductsNum']."',				//quantity - required
]);
";
				}
				$html_result .='_gaq.push(["_trackTrans"]); ';
			}
			$html_result .='
(function() {
var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
ga.src = ("https:" == document.location.protocol ? " https://ssl" : " http://www") + ".google-analytics.com/ga.js";
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
	';
			$html_result .='
<!--GA old end-->';
			//-------------------------------------------------->>>GA new<<<--------------------------------------------------it
			$ga_custom_var='';
			if($module=='thing' && $action=='glist' && $cid!=''){
				$ga_custom_var=\Helper\String::get_ga_custom_var($action,$cid,$page);
			}else if ($module=='thing' && $action=='item'){
				$ga_custom_var=\Helper\String::get_ga_custom_var('item',$productCategory,0,$pid);
			}else{
				$ga_custom_var=\Helper\String::get_ga_pageview();
			}
		
			$html_result .='
<!--GA new-->';
			$html_result .='
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-26300554-1"]);
';
			if(isset($tplar['select']['textfield']) && $tplar['select']['textfield']!='Enter search keywords or item code here'){
				$html_result .='_gaq.push(["_trackPageview", "/it/search/?q='.$tplar['select']['textfield'];
				if($tplar['select']['classid']){
					$html_result .='&c='.$tplar['select']['classid'].'"]);';
				}else{$html_result .='"]);';}
			}else{
				$html_result .='_gaq.push(["_trackPageview","'.$ga_custom_var.'"]);';
			}
			if($tplar['google']=='google'){
				$html_result .="
_gaq.push(['_addTrans',
'".$tplar['OrdersId']."',		// order ID - required
'Milanoo_en',  // affiliation or store name
'".$tplar['OrdersAmount_Currency']."',		// total - required
'0.00',           // tax
'".$tplar['OrdersLogisticsCosts_Currency']."',		// shipping
'".$tplar['Orders']['OrdersConsigneeCtiy']."',		// city
'".$tplar['Orders']['OrdersConsigneeUrbanAreas']."',		// state or province
'".$tplar['Countries']['name']."',		// country
]);
";
				foreach($tplar['Cart_ga'] as $cart){
					$html_result .="
_gaq.push(['_addItem',
'".$tplar['OrdersId']."',		// order ID - required
'".$cart['ProductsId']."',				//SKU/code - required
'".$cart['ProductsName']."',				//product name
'".$cart['CategoryId']."',				//category or variation
'".$cart['ProductsPrice']."',				//unit price - required
'".$cart['ProductsNum']."',				//quantity - required
]);
";
				}
				$html_result .='_gaq.push(["_trackTrans"]); ';
			}
			$html_result .='
(function() {
var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
ga.src = ("https:" == document.location.protocol ? " https://ssl" : " http://www") + ".google-analytics.com/ga.js";
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
';
			$html_result .='<!--GA new end-->';
			//-------------------------------------------------->>>Google Conversion Page<<<--------------------------------------------------it
			if($tplar['Omn_login']=='reg'){
				$html_result .='<!-- Google Conversion Page -->';
				$html_result .=<<<UNIQUE_CONV_1
 <script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 990165411;
var google_conversion_language = "it";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "VRenCIXIkAIQo_OS2AM";
var google_conversion_value = 0;
if (1) {
  google_conversion_value = 1;
}
/* ]]> */
</script> 
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/990165411/?label=VRenCIXIkAIQo_OS2AM&amp;guid=ON&amp;script=0"/> </div>
</noscript>
<!-- Google Code for sign up Conversion Page (new account)-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 972306416;
var google_conversion_language = "it";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "y4bFCOjs0wIQ8O_QzwM";
var google_conversion_value = 0;
if (1) {
google_conversion_value = 1;
}
/* ]]> */
</script> 
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/972306416/?value=1&amp;label=y4bFCOjs0wIQ8O_QzwM&amp;guid=ON&amp;script=0"/> </div>
</noscript>

<!-- Google Code for Sign Up Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 972306416;
var google_conversion_language = "it";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "_d_5CPDr0wIQ8O_QzwM";
var google_conversion_value = 0;
if (1) {
  google_conversion_value = 1;
}
/* ]]> */
</script>
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/972306416/?value=1&amp;label=_d_5CPDr0wIQ8O_QzwM&amp;guid=ON&amp;script=0"/>
</div>
</noscript> 

<!-- Google Code for Sign Up Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 972306416;
var google_conversion_language = "it";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "_d_5CPDr0wIQ8O_QzwM";
var google_conversion_value = 0;
if (1) {
  google_conversion_value = 1;
}
/* ]]> */
</script>
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/972306416/?value=1&amp;label=_d_5CPDr0wIQ8O_QzwM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
UNIQUE_CONV_1;
				$html_result .='<!-- Google Conversion Page End-->';
			}
		//-------------------------------------------------->>>再营销<<<--------------------------------------------------it
			if($module=='thing' && $action=='item'){
				$html_result .='<!-- 再营销 --> ';
				if(!empty($Remarket_code)){
					$html_result .="
<!-- 再营销 plain--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 972306416;
var google_conversion_language = 'it';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/972306416/?label=".$Remarket_code."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 plain End--> ";
				}
				if(!empty($Remarket_code_30)){
					$html_result .="
<!-- 再营销 30--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 972306416;
var google_conversion_language = 'it';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code_30."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/972306416/?label=".$Remarket_code_30."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 30 End--> ";
				}
				if(!empty($Remarket_code_120)){
					$html_result .="
<!-- 再营销 120--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 972306416;
var google_conversion_language = 'it';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code_120."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/972306416/?label=".$Remarket_code_120."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 120 End--> ";
				}
				$html_result .='<!-- 再营销 End--> ';
			}
			if($module=='index' && $action=='index'){
				$html_result .=<<<UNIQUE_INDEX_CODE_3
<!--首页-->
<!-- Google Code for ujh Remarketing List -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 972306416;
var google_conversion_language = "it";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "WDHDCNjeggMQ8O_QzwM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/972306416/?label=WDHDCNjeggMQ8O_QzwM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>			
UNIQUE_INDEX_CODE_3;
			}
				break;
			case 'ru-ru':
				//-------------------------------------------------->>>CNZZ<<<--------------------------------------------------ru
			// if($tplar['HTTP']=='http'){
				// $html_result .='
// <script src="s95.cnzz.com/stat.php?id=2820849&web_id=2820849&show=pic1" language="JavaScript" charset="gb2312"></script>';
			// }
			//-------------------------------------------->>>omniture<<<--------------------------------------------------ru
			if(defined('OMNITURE_STATISTICS_OPEN') && OMNITURE_STATISTICS_OPEN==1){
			$html_result .='
<!--omniture-->
<script language="JavaScript" type="text/javascript" src="'.$tplar['cdn_javascript_url'].'s_rucode.js"></script> 
<script language="JavaScript" type="text/javascript">';
			$html_result .="
s.pageName='".$tplar['pageName']."';
s.channel='".$tplar['channel']."';
s.prop1='".$tplar['prop1']."';
s.prop2='".$tplar['prop2']."';
s.prop3='".$tplar['prop3']."';
s.prop4='".$tplar['prop4']."';
";
			if(isset($tplar['reg60'])){			$html_result .='s.events="event5";';		}
			if($module=='thing' && $action=='item'){
			$html_result .="
s.events='prodView,event3';
s.products=';".$pid."';
";
			}
			else if($tplar['Omn_cart']!=''){
				$html_result .="
s.products=';".$tplar['Omn_cart']."';
s.events='scAdd';
";
			}
			else if($tplar['Omn_order']!=''){
				$html_result .="
s.products=';".$tplar['Omn_order']."';
s.eVar10='".$tplar['Omn_DiscountCode']."';
s.events='scCheckout';
";
			}
			if($tplar['be_omniture']=='be_omniture'){
				$html_result .="
s.purchaseID='".$tplar['OrdersId']."';
s.events='purchase,event7';
s.products='".$tplar['Omn_Products']."';
s.zip='".$tplar['Orders']['OrdersConsigneePostalcode']."';
s.state='".$tplar['Orders']['OrdersConsigneeCtiy']."';
s.eVar9='".$tplar['Countries']['name']."';
s.eVar5='".$tplar['Orders']['OrdersPayClass']."';
s.eVar6='".$tplar['Orders']['OrdersLogistics']."';			
";
			}
			if(isset($tplar['eVar3'])){
				$html_result .="s.eVar3='".$tplar['eVar3']."';";
				if($tplar['eVar3']=='search'){
					$html_result .="
	s.eVar1='".$tplar['select']['textfield']."';"; 
					if($tplar['page_t']==1){		
							if($tplar['num']==0){		
								$html_result .="s.events='event1,event2';";
							}else{
								$html_result .="s.events='event1';";
							}
					}		
				}
			}
			if(isset($tplar['eVar4'])){			
				$html_result .='
s.eVar4="'.$tplar['eVar4'].'";';		}
			if($tplar['Omn_login']=='login'){
				$html_result .="
s.events='event4';
s.eVar8='".$tplar['Omn_login_member']."';
";
			}else if($tplar['Omn_login']=='reg'){
				$html_result .="
s.events='event5';
s.eVar8='".$tplar['Omn_login_member']."';
";		
			}
			if($tplar['pageName']=='404page'){			$html_result .='s.pageType="errorPage";';		}
			if($tplar['pageName']=='del_mail'){			$html_result .='s.events="event9";';		}
			$html_result .="
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code)//--></script> 
<script language='JavaScript' type='text/javascript'><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
//--></script>
<noscript>
<img src='".$tplar['HTTP']."://milanoo.122.2o7.net/b/ss/milanoo-dev/1/H.22--NS/0'
height='1' width='1' border='0' alt='' />
</noscript>		
";
			$html_result .='<!--omniture end-->';
			}
			//-------------------------------------------------->>>GA old<<<-------------------------------------------------ru
			$html_result .='
<!--GA old-->';
			$html_result .='
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-20838489-1"]);
_gaq.push(["_trackPageview"]);
';
			if($tplar['google']=='google'){
				$html_result .="
_gaq.push(['_addTrans',
'".$tplar['OrdersId']."',		// order ID - required
'Milanoo_en',  // affiliation or store name
'".$tplar['OrdersAmount_Currency']."',		// total - required
'0.00',           // tax
'".$tplar['OrdersLogisticsCosts_Currency']."',		// shipping
'".$tplar['Orders']['OrdersConsigneeCtiy']."',		// city
'".$tplar['Orders']['OrdersConsigneeUrbanAreas']."',		// state or province
'".$tplar['Countries']['name']."',		// country
]);
";
				foreach($tplar['Cart_ga'] as $cart){
					$html_result .="
_gaq.push(['_addItem',
'".$tplar['OrdersId']."',		// order ID - required
'".$cart['ProductsId']."',				//SKU/code - required
'".$cart['ProductsName']."',				//product name
'".$cart['CategoryId']."',				//category or variation
'".$cart['ProductsPrice']."',				//unit price - required
'".$cart['ProductsNum']."',				//quantity - required
]);
";
				}
				$html_result .='_gaq.push(["_trackTrans"]); ';
			}
			$html_result .='
(function() {
var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
ga.src = ("https:" == document.location.protocol ? " https://ssl" : " http://www") + ".google-analytics.com/ga.js";
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
	';
			$html_result .='
<!--GA old end-->';
			//-------------------------------------------------->>>GA new<<<--------------------------------------------------ru
			$ga_custom_var='';
			if($module=='thing' && $action=='glist' && $cid!=''){
				$ga_custom_var=\Helper\String::get_ga_custom_var($action,$cid,$page);
			}else if ($module=='thing' && $action=='item'){
				$ga_custom_var=\Helper\String::get_ga_custom_var('item',$productCategory,0,$pid);
			}else{
				$ga_custom_var=\Helper\String::get_ga_pageview();
			}
		
			$html_result .='
<!--GA new-->';
			$html_result .='
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-26300554-1"]);
';
			if(isset($tplar['select']['textfield']) && $tplar['select']['textfield']!='Enter search keywords or item code here'){
				$html_result .='_gaq.push(["_trackPageview", "/ru/search/?q='.$tplar['select']['textfield'];
				if($tplar['select']['classid']){
					$html_result .='&c='.$tplar['select']['classid'].'"]);';
				}else{$html_result .='"]);';}
			}else{
				$html_result .='_gaq.push(["_trackPageview","'.$ga_custom_var.'"]);';
			}
			if($tplar['google']=='google'){
				$html_result .="
_gaq.push(['_addTrans',
'".$tplar['OrdersId']."',		// order ID - required
'Milanoo_en',  // affiliation or store name
'".$tplar['OrdersAmount_Currency']."',		// total - required
'0.00',           // tax
'".$tplar['OrdersLogisticsCosts_Currency']."',		// shipping
'".$tplar['Orders']['OrdersConsigneeCtiy']."',		// city
'".$tplar['Orders']['OrdersConsigneeUrbanAreas']."',		// state or province
'".$tplar['Countries']['name']."',		// country
]);
";
				foreach($tplar['Cart_ga'] as $cart){
					$html_result .="
_gaq.push(['_addItem',
'".$tplar['OrdersId']."',		// order ID - required
'".$cart['ProductsId']."',				//SKU/code - required
'".$cart['ProductsName']."',				//product name
'".$cart['CategoryId']."',				//category or variation
'".$cart['ProductsPrice']."',				//unit price - required
'".$cart['ProductsNum']."',				//quantity - required
]);
";
				}
				$html_result .='_gaq.push(["_trackTrans"]); ';
			}
			$html_result .='
(function() {
var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
ga.src = ("https:" == document.location.protocol ? " https://ssl" : " http://www") + ".google-analytics.com/ga.js";
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
';
			$html_result .='<!--GA new end-->';
			//-------------------------------------------------->>>Google Conversion Page<<<--------------------------------------------------ru
			if($tplar['Omn_login']=='reg'){
				$html_result .='<!-- Google Conversion Page -->';
				$html_result .=<<<UNIQUE_CONV_1
 <script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 990883625;
var google_conversion_language = "ru";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "gFVMCOfurwIQqd6-2AM";
var google_conversion_value = 0;
if (1) {
  google_conversion_value = 1;
}
/* ]]> */
</script> 
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/990883625/?label=gFVMCOfurwIQqd6-2AM&amp;guid=ON&amp;script=0"/> </div>
</noscript>
<!-- Google Code for sign up Conversion Page (new account)-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 965136303;
var google_conversion_language = "ru";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "bc7lCLG5zQIQr5-bzAM";
var google_conversion_value = 0;
if (1) {
google_conversion_value = 1;
}
/* ]]> */
</script> 
<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/965136303/?value=1&amp;label=bc7lCLG5zQIQr5-bzAM&amp;guid=ON&amp;script=0"/> </div>
</noscript>
UNIQUE_CONV_1;
				$html_result .='<!-- Google Conversion Page End-->';
			}
		//-------------------------------------------------->>>再营销<<<--------------------------------------------------ru
			if($module=='thing' && $action=='item'){
				$html_result .='<!-- 再营销 --> ';
				if(!empty($Remarket_code)){
					$html_result .="
<!-- 再营销 plain--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 965136303;
var google_conversion_language = 'ru';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/965136303/?label=".$Remarket_code."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 plain End--> ";
				}
				if(!empty($Remarket_code_30)){
					$html_result .="
<!-- 再营销 30--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 965136303;
var google_conversion_language = 'ru';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code_30."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/965136303/?label=".$Remarket_code_30."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 30 End--> ";
				}
				if(!empty($Remarket_code_120)){
					$html_result .="
<!-- 再营销 120--> 
<div style='display:none'>
<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 965136303;
var google_conversion_language = 'ru';
var google_conversion_format = '3';
var google_conversion_color = '666666';
var google_conversion_label = '".$Remarket_code_120."';
var google_conversion_value = 0;
/* ]]> */
</script> 
<script type='text/javascript' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'><img height='1' width='1' style='border-style:none;' alt='' src='".$tplar['HTTP']."://www.googleadservices.com/pagead/conversion/965136303/?label=".$Remarket_code_120."&amp;guid=ON&amp;script=0'/> </div>
</noscript>
</div>
<!-- 再营销 120 End--> ";
				}
				$html_result .='<!-- 再营销 End--> ';
			}
			if($module=='index' && $action=='index'){
				$html_result .=<<<UNIQUE_INDEX_CODE_3
<!-- 再营销 首页 30-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 965136303;
var google_conversion_language = "ru";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "wTr3CPmX4QIQr5-bzAM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/965136303/?label=wTr3CPmX4QIQr5-bzAM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<!-- 再营销  首页 End-->
<!--120-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 965136303;
var google_conversion_language = "ru";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "isi8CPGM6gIQr5-bzAM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/965136303/?label=isi8CPGM6gIQr5-bzAM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>	
UNIQUE_INDEX_CODE_3;
			}
				break;
			default:break;
		}
		//--------------------------------------------------统计代码结束--------------------------------------------------	
		$html_result .='
</div>
<!--statistics code end-->';//statistics code end
	} 
    return $html_result;
}



?>
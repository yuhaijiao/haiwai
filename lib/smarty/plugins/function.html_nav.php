<?php
use Helper\ResponseUtil as rew;
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {html_nav} plugin
 *
 * Type:     function
 * Name:     html_nav
 * Purpose:  ��ҳ����
 *
 * @version 1.0.0
 * @author jianjun wu <wujianjun@milanoo.com>
 * @param array
 * @param Smarty
 * @return string
 */

class cosplay_plugin{
	public static $cosplay_display_array = array(2186,2188);
}

function smarty_function_html_nav($params, &$smarty)
{
	switch ($params['type']){
		case 'header':	
			$topNav = getNav($params,$smarty);
			$html_result = header_nav($topNav);
		break;
		case 'footer':
			$topNav = getNav($params,$smarty);
			$html_result = footer_nav($topNav,$params['step']);
		break;
		case 'search':
			$topNav = getNav($params,$smarty);
			$html_result = search_nav($topNav);
		break;
		case 'category_list_left':
			$html_result = category_list_left($smarty);
		break;
		case 'category_list_right':
			$html_result = category_list_right($smarty);
		break;
		case 'index_category':
			$mNav = new \Model\Navigator(); 
    		$topNav = $mNav->getNav($params['class'],$params['childNum']);
			$html_result = index_category($topNav);
		break;
	}
	//$html_result = count($topNav);
    return $html_result;
}

function getNav($params,$smarty){
	if(!isset($smarty->_tpl_vars['topNav'])){
		$mNav = new \Model\Navigator(); 
		$topNav = $mNav->getNav($params['class'],$params['childNum']);
	}else{
		$topNav = $smarty->_tpl_vars['topNav'];
	}
	return $topNav;
}

/**
 * 尾部分类
 *
 * @param unknown_type $topNav
 * @param unknown_type $step
 * @return unknown
 */
function footer_nav($topNav,$step){
	$html_result = '';
	if($topNav['returnCode']==0) {
		$html_result .= "<div class='list'>";
		if(count($topNav['resultList']) > 0){
			foreach ($topNav['resultList'] as $cat){
				$html_result .= "<ul>";
				$cateName = getCateName($cat);
				$seoCateName = stripcslashes($cat['categoryName']);
				$url = "?module=thing&action=glist&class=".$cat['categoryId'];
				$html_result .= "<li><h6><a href='".rew::rewrite(array('url'=>$url,'isxs'=>'no','seo'=>$seoCateName))."'>{$cateName}</a></h6></li>";
				if(is_array($cat['childrenList'])){
					$i = 0;
					foreach ($cat['childrenList'] as $secCat){
						if($i == $step){
							break;
						}
						$cateName = getCateName($secCat);
						$seoCateName = stripcslashes($secCat['categoryName']);
						$url = "?module=thing&action=glist&class=".$secCat['categoryId'];
						$html_result .= "<li><a href='".rew::rewrite(array('url'=>$url,'isxs'=>'no','seo'=>$seoCateName,'seo'=>$cateName))."'>{$cateName}</a></li>";
						$i++;
					}
				}
				$html_result .= "</ul>";
			}
		}
		$html_result .= "</div>";
	}
	return $html_result;
}

/**
 * 顶部分类
 *
 * @param unknown_type $topNav
 * @return unknown
 */
function header_nav($topNav){
	
	$display_num = 12; //分类显示个数
	$html_result = '';
	$params_all = Helper\RequestUtil::getParams();
	
	$module = $params_all->module;
	$action = $params_all->action;
	if($module == 'index' && $action == 'index'){
		return '';
	}
	$url = "?module=thing&action=glist&class=";
	
	if($topNav) {
		$html_result = '<dl class="allcategories botbor" id="mainmenu">';
		$all_categories_url = "?module=index&action=seeall";
		//$html_result .= '<dt><a href="'.rew::rewrite(array('url'=>$all_categories_url,'isxs'=>'no')).'">'.\LangPack::$items['head_Category'].'</a></dt>';
		  $html_result .= '<dt>'.\LangPack::$items['head_Category'].'</dt>';
		     
			foreach($topNav['resultList'] as $key=>$cat) {
				$cateName = getCateName($cat);		
				$seoCateName = stripcslashes($cat['categoryName']);
				$dd_class = "";
				if($key == 0){
					$dd_class = " class='top_none'";
				}
				$html_result .= '<dd'.$dd_class.'><a href="'.rew::rewrite(array('url'=>$url.$cat['categoryId'],'isxs'=>'no','seo'=>$seoCateName)).'">'.$cateName."</a>";
				if(is_array($cat['childrenList'])){
					$html_result .= "<!-- [n2h]<ul>";
					$sec_num = 0;
					foreach($cat['childrenList'] as $secCat) {
						$cateName = getCateName($secCat);
						$seoCateName = stripcslashes($secCat['categoryName']);
						if($sec_num == $display_num){						
							break;			
						}
						$html_result .= "<li><a href='".rew::rewrite(array('url'=>$url.$secCat['categoryId'],'isxs'=>'no','seo'=>$seoCateName))."'>{$cateName}</a>";
						$sec_num++;
							if(is_array($secCat['childrenList'])) {
								$html_result .= "<ol>";
								$i = 0;
								foreach($secCat['childrenList'] as $thridCat) {
									if($i == $display_num){
										break;
									}
									$cateName = getCateName($thridCat);
									$seoCateName = stripcslashes($thridCat['categoryName']);
									$html_result .= "<li><a href='".rew::rewrite(array('url'=>$url.$thridCat['categoryId'],'isxs'=>'no','seo'=>$seoCateName))."'>{$cateName}</a></li>";
									$i++;
								}
								if($i == $display_num){
									$cateName = getCateName($secCat);
									$seoCateName = stripcslashes($secCat['categoryName']);
									$html_result .= '<li><a class="mo" href="'.rew::rewrite(array('url'=>$url.$secCat['categoryId'],'isxs'=>'no','seo'=>$seoCateName)).'">'.\LangPack::$items['theme_More'].'></a></li>';
								}
								$html_result .= "</ol>";
							}
						$html_result .= "</li>";
					}
					if($sec_num == $display_num){
						$cateName =getCateName($cat);
						$seoCateName = stripcslashes($cat['categoryName']);
						$html_result .= '<li><a class="mo" href="'.rew::rewrite(array('url'=>$url.$cat['categoryId'],'isxs'=>'no','seo'=>$seoCateName)).'">'.\LangPack::$items['theme_More'].'></a></li>';
					}
					$html_result .= "</ul>[/n2h] -->";
				}
				$html_result .= '</dd>';
			}
			$sale_url = "?module=sale&action=index";
			$html_result .= '<dd class="navnosub"><a style="font-weight:bold;" href="'.rew::rewrite(array('url'=>$sale_url,'isxs'=>'no')).'">'.\LangPack::$items['thing_Sale'].'</a>';
		$html_result .= '</dl>';
	}
	return $html_result;
}


/**
 * 主页分类列表
 *
 * @param unknown_type $topNav
 * @return unknown
 */
function index_category($topNav){
	$display_num = 12; //分类显示个数
	$html_result = '';
	$params_all = Helper\RequestUtil::getParams();
	$module = $params_all->module;
	$action = $params_all->action;
	$url = "?module=thing&action=glist&class=";
	if($topNav) {
		$html_result = '<dl class="allcategories botbor" id="mainmenu">';
		//head_Category
		$all_categories_url = "?module=index&action=seeall";
		//$html_result .= '<dt><a href="'.rew::rewrite(array('url'=>$all_categories_url,'isxs'=>'no')).'">'.\LangPack::$items['head_Category'].'</a></dt>';
		$html_result .= '<dt>'.\LangPack::$items['head_Category'].'</dt>';
			foreach($topNav['resultList'] as $key=>$cat) {
				$cateName = getCateName($cat);			
				$seoCateName = stripcslashes($cat['categoryName']);
				$dd_class = "";
				if($key == 0){
					$dd_class = " class='top_none'";
				}
				$html_result .= '<dd'.$dd_class.'><a href="'.rew::rewrite(array('url'=>$url.$cat['categoryId'],'isxs'=>'no','seo'=>$seoCateName)).'">'.$cateName."</a>";
				if(is_array($cat['childrenList'])){
					$html_result .= "<!-- [n2h]<ul>";
					$sec_num = 0;
					foreach($cat['childrenList'] as $secCat) {
						$seoCateName = stripcslashes($secCat['categoryName']);
						$cateName =getCateName($secCat);						
						if($sec_num == $display_num){
							break;
						}
						$html_result .= "<li><a href='".rew::rewrite(array('url'=>$url.$secCat['categoryId'],'isxs'=>'no','seo'=>$seoCateName))."'>{$cateName}</a>";
						$sec_num++;
							if(is_array($secCat['childrenList'])) {
								$html_result .= "<ol>";
								$i = 0;
								foreach($secCat['childrenList'] as $thridCat) {
									if($i == $display_num){
										break;
									}
									$cateName = getCateName($thridCat);
									$seoCateName = stripcslashes($thridCat['categoryName']);
									$html_result .= "<li><a href='".rew::rewrite(array('url'=>$url.$thridCat['categoryId'],'isxs'=>'no','seo'=>$seoCateName))."'>{$cateName}</a></li>";
									$i++;
								}
								if($i == $display_num){
									$cateName = getCateName($secCat);
									$seoCateName = stripcslashes($secCat['categoryName']);
									$html_result .= '<li><a class="mo" href="'.rew::rewrite(array('url'=>$url.$secCat['categoryId'],'isxs'=>'no','seo'=>$seoCateName)).'">'.\LangPack::$items['theme_More'].'></a></li>';
								}
								$html_result .= "</ol>";
							}
						$html_result .= "</li>";
					}
					if($sec_num == $display_num){
						$cateName = getCateName($cat);
						$seoCateName = stripcslashes($cat['categoryName']);
						$html_result .= '<li><a class="mo" href="'.rew::rewrite(array('url'=>$url.$cat['categoryId'],'isxs'=>'no','seo'=>$seoCateName)).'">'.\LangPack::$items['theme_More'].'></a></li>';
					}
					$html_result .= "</ul>[/n2h] -->";
				}
				$html_result .= '</dd>';
			}
			$sale_url = "?module=sale";
			$html_result .= '<dd class="navnosub"><a style="font-weight:bold;" href="'.rew::rewrite(array('url'=>$sale_url,'isxs'=>'no')).'">'.\LangPack::$items['thing_Sale'].'</a>';
		$html_result .= '</dl>';
	}
	return $html_result;
}

/**
 * 搜索分类显示
 *
 * @param unknown_type $topNav
 */
function search_nav($topNav){
	$html_result = '';
	if($topNav) {
		$html_result .= '<li class="pop_cate">';
		$html_result .= '<span categoriesid="">'.\LangPack::$items['head_Category'].'</span>';
		foreach($topNav['resultList'] as $cat) {
			//$cateName = stripslashes($cat['categoryName']);
			$cateName = getCateName($cat);
			$html_result .= '<span categoriesid="'.$cat['categoryId'].'">'.$cateName.'</span>';
		}
		$html_result .= '</li>';
	}
	return $html_result;
}
/**
 * 分类列表页面的左边导航
 *
 * @return unknown
 */
function category_list_left($smarty){
	$params_all = Helper\RequestUtil::getParams();			
	$cid = $params_all->class;		
	if(!isset($smarty->_tpl_vars['result'])){		
		$mProductList = new \Model\Product ();
		$search_arr = array(
			'pcs.categoryId' => $cid,
		);
		$result = $mProductList->getProductList($search_arr);
	}else{
		$result = $smarty->_tpl_vars['result'];
	}
	$html_result = '';
	if($result) {
		$html_result .= '<dl class="catalog" style="border-bottom: none;">';
        $html_result .= '<dt>'.stripslashes($result['productCategory']['categoryName']).'</dt>';
        if(in_array($cid,cosplay_plugin::$cosplay_display_array)){
        	$names = \LangPack::$items['left2_Categories_Search'];
			$html_result .= '<dl><input class="cosplay_search" name="" onfocus="javascript:if(this.value==\'  '.$names.'\')this.value=\'\';cg();" onblur="if(this.value==\'\')this.value=\'\';" onkeyup="cg();" value="  '.$names.'" id="cg" ></dl>';
		}
		$html_result .= '</dl>';//catelist
		$html_result .= '<ul id="Caracoter_lb" class="categories" style="border-top: none;">';
        $url = "?module=thing&action=glist&class=";
        if(is_array($result['productCategory']['childrenList'])){
	        foreach ($result['productCategory']['childrenList'] as $cat){
	        	$cateName = getCateName($cat);		
	        	$seoCateName = stripcslashes($cat['categoryName']);
	        	if(is_array($cat['childrenList']) && count($cat['childrenList'])>0){
					$html_result .= '<li><span class="plus"></span><a class="nextCategory_title" title="'.$cateName.'" href="'.rew::rewrite(array('url'=>$url.$cat['categoryId'],'isxs'=>'no','seo'=>$seoCateName)).'">'.$cateName.'</a>';
				}else{
					$html_result .= '<li><a title="'.$cateName.'" href="'.rew::rewrite(array('url'=>$url.$cat['categoryId'],'isxs'=>'no','seo'=>$seoCateName)).'">'.$cateName.'</a>';
				}
				if(is_array($cat['childrenList']) && count($cat['childrenList'])>0){
					$html_result .= '<ul style="display:none">';
						foreach ($cat['childrenList'] as $childcat){
							$cateName = getCateName($childcat);		
	        				$seoCateName = stripcslashes($childcat['categoryName']);	
							$html_result .= '<li><a title="'.$cateName.'" href="'.rew::rewrite(array('url'=>$url.$childcat['categoryId'],'isxs'=>'no','seo'=>$seoCateName)).'">'.$cateName.'</a></li>';
						}
					$html_result .= '</ul>';
				}
				$html_result .= '</li>';
				//$html_result .= '<dd><a title="'.$cateName.'" href="'.rew::rewrite(array('url'=>$url.$cat['categoryId'],'isxs'=>'no','seo'=>$seoCateName)).'">'.$cateName.'</a></dd>';
	        }
        }
        $html_result .= '</ul>';
        $html_result .= "<script>jQuery('#Caracoter_lb').catelist();</script>";
        return $html_result;
	}
}

/**
 * 获取分类名称，优先选择分类别名
 *
 * @param unknown_type $data
 * @return unknown
 */
function getCateName($data){
	if(isset($data['categoryAliasName']) && !empty($data['categoryAliasName'])){
		return stripcslashes($data['categoryAliasName']);
	}else{
		return stripcslashes($data['categoryName']);
	}
}
/**
 * 分类列表页面右边分类列表
 *
 * @return unknown
 */
function category_list_right($smarty){
	global $cosplay_display_array;
	$params_all = Helper\RequestUtil::getParams();		
	$cid = $params_all->class;		
	if(!isset($smarty->_tpl_vars['result'])){		
		$mProductList = new \Model\Product ();
		$search_arr = array(
			'pcs.categoryId' => $cid,
		);
		$result = $mProductList->getProductList($search_arr);
	}else{
		$result = $smarty->_tpl_vars['result'];
	}

	$html_result = '';
	if($result) {
		if(in_array($cid,cosplay_plugin::$cosplay_display_array)){
			//$html_result .= '<h1>'.stripslashes($result['productCategory']['categoryName']).'</h1>';
			$html_result .= '<div class="descript_box">';
			$html_result .= '<h1>'.stripslashes($result['productCategory']['categoryName']).'</h1>';	
			$html_result .= '<div>'.strip_tags(htmlspecialchars_decode(stripcslashes($result['productCategory']['categoryIntroduce']))).'</div>';	
			$html_result .= '</div>';
			$html_result .= '<div class="cosplay_search_words" id="cosplay_search_words"><a href="javascript:void(0);">A</a>|<a href="javascript:void(0);" id="aeaoofnhgocdbnbeljkmbjdmhbcokfdb-mousedown">B</a>|<a href="javascript:void(0);">C</a>|<a href="javascript:void(0);">D</a>|<a href="javascript:void(0);">E</a>|<a href="javascript:void(0);">F</a>|<a href="javascript:void(0);">G</a>|<a href="javascript:void(0);">H</a>|<a href="javascript:void(0);">I</a>|<a href="javascript:void(0);">J</a>|<a href="javascript:void(0);">K</a>|<a href="javascript:void(0);">L</a>|<a href="javascript:void(0);">M</a>|<a href="javascript:void(0);">N</a>|<a href="javascript:void(0);">O</a>|<a href="javascript:void(0);">P</a>|<a href="javascript:void(0);">Q</a>|<a href="javascript:void(0);">R</a>|<a href="javascript:void(0);">S</a>|<a href="javascript:void(0);">T</a>|<a href="javascript:void(0);">U</a>|<a href="javascript:void(0);">V</a>|<a href="javascript:void(0);">W</a>|<a href="javascript:void(0);">X</a>|<a href="javascript:void(0);">Y</a>|<a href="javascript:void(0);">Z</a></div>';
		}else{
			$html_result .= '<div class="descript_box">';
			$html_result .= '<h1>'.stripslashes($result['productCategory']['categoryName']).'</h1>';	
			$html_result .= '<div>'.strip_tags(htmlspecialchars_decode(stripcslashes($result['productCategory']['categoryIntroduce']))).'</div>';
			$html_result .= '</div>';
		}
		$html_result .= '<p><div id="slideAlbum_107'.$cid.'"></div></p>';
		$html_result .= '<ul class="ca_list">';
		$url = "?module=thing&action=glist&class=";
		foreach ($result['productCategory']['childrenList'] as $cat){
        	$cateName = stripcslashes($cat['categoryName']);
			$html_result .= '<li><a class="pic" title="'.$cateName.'" href="'.rew::rewrite(array('url'=>$url.$cat['categoryId'],'isxs'=>'no','seo'=>$cateName)).'"><img src="'.CDN_UPLOAD_URL.'upload/CategoriesLogo/'.$cat['categoryLogUrl'].'" alt="'.$cateName.'" /></a><h3><a title="'.$cateName.'" href="'.rew::rewrite(array('url'=>$url.$cat['categoryId'],'isxs'=>'no','seo'=>$cateName)).'">'.$cateName.'</a></h3></li>';
        }
		$html_result .= '<br class="cl"/>';
		$html_result .= '</ul>';
        return $html_result;
	}
}
/* vim: set expandtab: */

?>
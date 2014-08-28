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
function smarty_function_breadcrumb($params, &$smarty)
{
	$params_all = Helper\RequestUtil::getParams();
	
	$tag = $smarty->_tpl_vars['tag'];
	$keywords = $smarty->_tpl_vars['textname'];
	$module = $params_all->module;
    $breadcrumb = new \Model\Product(); 
    $search = $smarty->_tpl_vars['search'];

    if($search == 1){
		if($params_all->class != 0){
			$class = $params_all->class;
		}else{
			$class = $params_all->ClassId;
		}
    }else{
    	if($params_all->module == "thing" && $params_all->action == "item"){
    		$productsDetails = $smarty->_tpl_vars['productsDetails'];
    		$class =  $productsDetails['productCategory']['categoryId'];
    		$keywords = stripslashes($productsDetails['productName']);
    	}else{
    		$class = $params_all->class;
    	}
    }
	$search_array = array(
    	'pcs.categoryId'=>intval($class),
    );

	if(!isset($smarty->_tpl_vars['result'])){
    	$result = $breadcrumb->getProductList($search_array);
	}else{
		$result = $smarty->_tpl_vars['result'];
	}
	
    $html_result .= '<div class="crumb">';
    $html_result .= '<a rel="nofollow" href="'.ROOT_URLD.'">'.\LangPack::$items['head_Home'].'</a>&gt;';
    $all_categories_url = "?module=index&action=seeall";
    $cate_url = "?module=thing&action=glist&class=";
    if($search == 1){  //搜索页面的面包屑
    	$bread = '';
    	if($class == 0){ //没有选择分类
    		if(!empty($tag)){ //是tag页面过来
    			$tag_list = \LangPack::$items['tag_list'];
    			if(empty($keywords)){ //关键词为空
	    			$bread .= '<a href="'.ROOT_URLD.'producttags/'.$tag.'">'.$tag_list.' '.$tag.'</a>';
    			}else{
    				$bread .= '<a href="'.ROOT_URLD.'producttags/'.$tag.'">'.$tag_list.' '.$tag.'</a>&gt;<b>'.$keywords.'</b>';
    			}
    		}else{
    			if($params_all->class != 0){ //点击左边导航分类搜索
    				$bread .= '<a href="'.rew::rewrite(array('url'=>$all_categories_url,'isxs'=>'no')).'">'.\LangPack::$items['head_Category'].'</a>&gt';
		    		$cateName = stripcslashes($result['categoryBreadcrumbNavigation']['categoryName']);
		    		$bread .= '<a href="'.rew::rewrite(array('url'=>$cate_url.$result['categoryBreadcrumbNavigation']['categoryId'],'isxs'=>'no','seo'=>$cateName)).'">'.$cateName.'</a>&gt';
    			}
    			if(!empty($keywords)){ //不是tag页面，且关键词不为空
    				$bread .= '<a href="'.rew::rewrite(array('url'=>$all_categories_url,'isxs'=>'no')).'">'.\LangPack::$items['brand_item_all_product'].'</a>&gt';
    				$bread .= '<b>'.$keywords.'</b>';
    			}else{		
    				$bread .= '<b>'.\LangPack::$items['thing_glist_all'].'</b>';
    			}
    		}
	    }else { 
	    	$bread .= '<a href="'.rew::rewrite(array('url'=>$all_categories_url,'isxs'=>'no')).'">'.\LangPack::$items['head_Category'].'</a>&gt';
	    	if($params_all->class != 0){//点击左边导航分类搜索
	    		$bread .= getCategories($result['categoryBreadcrumbNavigation'],$class,false);
			}else{
	    		$cateName = stripcslashes($result['categoryBreadcrumbNavigation']['categoryName']);
	    		$bread .= '<a href="'.rew::rewrite(array('url'=>$cate_url.$result['categoryBreadcrumbNavigation']['categoryId'],'isxs'=>'no','seo'=>$cateName)).'">'.$cateName.'</a>&gt';
			}
	    	if(empty($keywords)){ //关键词为空
	    		$bread .= '<b>'.\LangPack::$items['thing_glist_all'].'</b>';
	    	}else{
	    		$bread .= '<b>'.$keywords.'</b>';
	    	}
	    }    
    }else{//非搜索页面的面包屑
		if($params_all->module == "thing" && $params_all->action == "item"){
	    	$bread = getCategories($result['categoryBreadcrumbNavigation'],$class,false);
	    	$bread .= '<b>'.$keywords.'</b>';
		}else{
			$bread = getCategories($result['categoryBreadcrumbNavigation'],$class);
		}
    }
    $html_result .= $bread;
    $html_result .= '</div>';
    return $html_result;
}
/* vim: set expandtab: */

/**
 * 递归获取分类信息的每一级
 *
 * @param unknown_type $cate
 * @param unknown_type $class
 * @param boolean $flag 是否是从分类进入，true：是 false:否
 * @return unknown
 */
function getCategories($cate,$class,$flag=true){
	$url = "?module=thing&action=glist&class=".$cate['categoryId'];
	$cateName = stripslashes($cate['categoryName']);
	$bread = '';
	if($cate['categoryId'] == $class){
		if($flag){
			$bread .= '<b><a style="color:#999999;" title="'.$cateName.'" href="'.rew::rewrite(array('url'=>$url,'isxs'=>'no','seo'=>$cateName)).'">'.$cateName.'</a></b>';
		}else{
			$bread .= '<a title="'.$cateName.'" href="'.rew::rewrite(array('url'=>$url,'isxs'=>'no','seo'=>$cateName)).'">'.$cateName.'</a>&gt;';
		}
	}else{
		$bread .= '<a title="'.$cateName.'" href="'.rew::rewrite(array('url'=>$url,'isxs'=>'no','seo'=>$cateName)).'">'.$cateName.'</a>&gt;';
	}
	if(is_array($cate['nextCategory'])){
		$bread .= getCategories($cate['nextCategory'],$class,$flag);
	} 
	return $bread;
}
?>
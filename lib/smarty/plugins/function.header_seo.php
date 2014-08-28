<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {html_header_seo} plugin
 *
 * Type:     function
 * Name:     html_header_seo
 * Purpose:  网页头部的seo信息
 *
 * @version 1.0.0
 * @author jianjun wu <wujianjun@milanoo.com>
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_header_seo($params, &$smarty)
{
	
    $html_result = '';
    $params_all = Helper\RequestUtil::getParams();
    $module = $params_all->module;
    $action = $params_all->action;
    $class = $params_all->class;
    $keywords = $params_all->keyword;
	$metaName = "";
	$meta_description = "";
	$meta_keywords = "";
	$metaName = \LangPack::$items['index_metaname'];
	$meta_description = \LangPack::$items['index_metadesc'];
	$meta_keywords = \LangPack::$items['index_metakey'];
	if($module == 'index' && $action == 'index'){ //首页seo信息
		$html_result .= '<meta name="google-site-verification" content="4KNLPsyOCRhCOpC2OA2zggxdElDkrc0NddOT1f4ImwA" />';
		$html_result .= '<title>'.$metaName.' - Milanoo.com</title>';
		$html_result .= '<meta name="description" content="'.$meta_description.'" />';
		$html_result .= '<meta name="keywords" content="'.$meta_keywords.'" />';
		$html_result .= '<meta name="yandex-verification" content="654e015860147018" />';
	}elseif($module == 'producttags'){ //tag的列表页面的seo信息
		$tag_str = isset($smarty->_tpl_vars['meta_tags']) ? $smarty->_tpl_vars['meta_tags'] : '';
		$tag_metaName = \LangPack::$items['tag_metaName'];
		$tag_metaName = sprintf($tag_metaName,$tag_str);
		$tag_meta_description = \LangPack::$items['tag_meta_description'];
		$tag_meta_description = sprintf($tag_meta_description,$tag_str);
		$tag_meta_keywords = \LangPack::$items['tag_meta_keywords'];
		$tag_meta_keywords = sprintf($tag_meta_keywords,$tag_str);
		$html_result .= '<title>'.$tag_metaName.'</title>';
		$html_result .= '<meta name="description" content="'.$tag_meta_description.'" />';
		$html_result .= '<meta name="keywords" content="'.$tag_meta_keywords.'" />';
	}elseif ($module == 'thing' && $action == 'item'){
		$products_details =  isset($smarty->_tpl_vars['productsDetails']) ? $smarty->_tpl_vars['productsDetails'] : '';
		$html_result .= '<title>'.stripslashes($products_details['productName']).' -  Milanoo.com </title>';
		$html_result .= '<meta name="description" content="'.stripslashes($products_details['introduce']).'" />';
		$html_result .= '<meta name="keywords" content="'.stripslashes($products_details['productName']).'" />';
	}else{
		$search = $smarty->_tpl_vars['search'];
		if($search == 1){	//search == 1为搜索页面
			$title = '';
			$mNav = new \Model\Navigator(); 
			$topNav = $mNav->getNav(0,'-1');
			if(count($topNav['resultList']) > 0){
				foreach ($topNav['resultList'] as $v)
				{
					$title .= " ".stripcslashes($v['categoryName']);
				}
			}
			if(!empty($keywords)){
				$title = $keywords . " -".$title;
			}
			$tag = $smarty->_tpl_vars['tag'];
			if(empty($tag)){ //非tags页面过来的搜索
				$html_result .= '<title>'.$title.'- Milanoo.com</title>';
				$html_result .= '<meta name="description" content="" />';
				$html_result .= '<meta name="keywords" content="" />';
			}else{ //tags页面过来的搜索				
				$keywords = $smarty->_tpl_vars['textname'];
				switch (SELLER_LANG){
					case 'ja-jp':
						$title = $keywords.' 人気ファッションオンライショッピングサイト ';
						$meta_keywords = $keywords .'　激安　格安　販売　通販　卸売　服装　婦人服　ファッション';
						$meta_description = $keywords . ' milanooは高品質で豊富な種類の商品を、すべて卸売り価格にてご提供しております。';
					break;
					case 'fr-fr':
						$title = $keywords." - Acheter ".$keywords." aux petits prix  - Milanoo.com";
						$meta_description = "Acheter ".$keywords." aux prix de gros raisonables sur Milanoo.com – une des meilleures boutiques de ".$keywords.". L’énorme sélection de produits de haute qualité!";
						$meta_keywords = $keywords;
					break;
					case 'de-ge':
						$title = $keywords." | Großhandel ".$keywords." Online - Milanoo.com";
						$meta_description = $keywords." in billigen Großhandelspreisen von ".$keywords." im Shop Milanoo.com kaufen. Die größste Auswahl an Rabattsprodukten mit Qualitätsgarantie.";
						$meta_keywords = $keywords;
					break;
					case 'it-it':
						$title = $keywords."Vendita a privati e all ingrosso Online - Milanoo.com";
						$meta_description = $keywords." a prezzi convenienti su Milanoo.com. Una vasta selezione di prodotti scontati. Qualità Garantita!";
						$meta_keywords = $keywords;
					break;
					case 'es-sp':
						$title = $keywords." | Venta al por mayor ".$keywords." Online - Milanoo.com";
						$meta_description = "Comprar ".$keywords." a precio bajo como mayorista desde ".$keywords." Tienda Milanoo.com. La selección es de muchos productos en oferta con calidad garantizada!";
						$meta_keywords = $keywords;
					break;
					case 'ru-ru':
						$title = $keywords."| Оптом ".$keywords." Интернет-магазин Milanoo.com";
						$meta_description = "Купить ".$keywords." по низким оптовым ценам от лучших ".$keywords." в Интернет-магазин Milanoo.com. Мы предлагаем Вам большой выбор со скидками продукции с гарантированным качеством!";
						$meta_keywords = $keywords;
					break;
					default:
						$title = $keywords."-Buy ".$keywords." at Cheap Prices-Milanoo.com";
						$meta_description = "Buy " . $keywords . " at cheap wholesale prices from best " . $keywords . " store Milanoo.com. The absolute largest selection of discount products with quality guaranteed! ";
						$meta_keywords = "buy " . $keywords . ", cheap " . $keywords . "";
					break;
				}
				$html_result .= '<title>'.$title.'</title>';
				$html_result .= '<meta name="description" content="'.$meta_description.'" />';
				$html_result .= '<meta name="keywords" content="'.$meta_keywords.'" />';
			}
		}else{			
			$seo_attrs = isset($smarty->_tpl_vars['seo_attrs']) ? $smarty->_tpl_vars['seo_attrs'] : '';
			if(!isset($smarty->_tpl_vars['result'])){		
				$mProductList = new \Model\Product ();
				$search_arr = array(
					'pcs.categoryId' => $class,
				);
				$result = $mProductList->getProductList($search_arr);
			}else{
				$result = $smarty->_tpl_vars['result'];
			}
			$title = stripslashes($result['productCategory']['categoryName']);
			if(empty($seo_attrs)){
				switch (SELLER_LANG){
					case 'en-uk':
						if(isset($result['productCategory']['seoTitle']) && !empty($result['productCategory']['seoTitle'])){
							$title = stripcslashes($result['productCategory']['seoTitle']);
						}
						if(!isset($result['productCategory']['seoMeta']) || empty($result['productCategory']['seoMeta'])){
							$meta_keywords = $title;
						}else{
							$meta_keywords = stripcslashes($result['productCategory']['seoMeta']);
						}
						if(!isset($result['productCategory']['categoryIntroduce']) || empty($result['productCategory']['categoryIntroduce'])){
							$CategoriesIntroduction = $title;
						}else{
							$CategoriesIntroduction = strip_tags(htmlspecialchars_decode(stripcslashes($result['productCategory']['categoryIntroduce'])));
						}
					break;
					case 'ja-jp':
						if(isset($result['productCategory']['seoTitle']) && !empty($result['productCategory']['seoTitle'])){
							$title = stripcslashes($result['productCategory']['seoTitle']);
						}
						if(!isset($result['productCategory']['seoMeta']) || empty($result['productCategory']['seoMeta'])){
							$meta_keywords = $title;
						}else{
							$meta_keywords = stripcslashes($result['productCategory']['seoMeta']);
						}
						if(!isset($result['productCategory']['categoryIntroduce']) || empty($result['productCategory']['categoryIntroduce'])){
							$CategoriesIntroduction = "中国最大級の {$title} 卸売業者・ミラノーは、オンラインにて {$title} 卸売いたします。様々な高品質＆激安価格商品を、是非お選びください。";
						}else{
							$CategoriesIntroduction = strip_tags(htmlspecialchars_decode(stripcslashes($result['productCategory']['categoryIntroduce'])));
						}
					break;
					case 'fr-fr':
						
						if(isset($result['productCategory']['seoTitle']) && !empty($result['productCategory']['seoTitle'])){
							$title = stripcslashes($result['productCategory']['seoTitle']);
						}else{
							$title = "{$title}  | Vente de gros {$title} en ligne";
						}
						if(!isset($result['productCategory']['seoMeta']) || empty($result['productCategory']['seoMeta'])){
							$meta_keywords = $title;
						}else{
							$meta_keywords = stripcslashes($result['productCategory']['seoMeta']);
						}
						if(!isset($result['productCategory']['categoryIntroduce']) || empty($result['productCategory']['categoryIntroduce'])){
							$CategoriesIntroduction = "Découvrez {$title} chez Milanoo, le grossiste de la Chine, vente de gros de  {$title} en ligne. La plus grande sélection absolue de produits discount avec la garantie de qualité!";
						}else{
							$CategoriesIntroduction = strip_tags(htmlspecialchars_decode(stripcslashes($result['productCategory']['categoryIntroduce'])));
						}
					break;
					case 'ru-ru':
						if(isset($result['productCategory']['seoTitle']) && !empty($result['productCategory']['seoTitle'])){
							$title = stripcslashes($result['productCategory']['seoTitle']);
						}else{
							$title = "{$title}  | Vente de gros {$title} en ligne";
						}
						if(!isset($result['productCategory']['seoMeta']) || empty($result['productCategory']['seoMeta'])){
							$meta_keywords = $title;
						}else{
							$meta_keywords = stripcslashes($result['productCategory']['seoMeta']);
						}
						if(!isset($result['productCategory']['categoryIntroduce']) || empty($result['productCategory']['categoryIntroduce'])){
							$CategoriesIntroduction = "Купить {$title} по низким оптовым ценам в Интернет-магазин Milanoo.com. Мы предлагаем Вам большой выбор со скидками продукции с гарантированным качеством!";
						}else{
							$CategoriesIntroduction = strip_tags(htmlspecialchars_decode(stripcslashes($result['productCategory']['categoryIntroduce'])));
						}
					break;
					case 'it-it':
						if(isset($result['productCategory']['seoTitle']) && !empty($result['productCategory']['seoTitle'])){
							$title = stripcslashes($result['productCategory']['seoTitle']);
						}else{
							$title = "{$title} Vendita a privati e all ingrosso Online";
						}
						if(!isset($result['productCategory']['seoMeta']) || empty($result['productCategory']['seoMeta'])){
							$meta_keywords = $title;
						}else{
							$meta_keywords = stripcslashes($result['productCategory']['seoMeta']);
						}
						if(!isset($result['productCategory']['categoryIntroduce']) || empty($result['productCategory']['categoryIntroduce'])){
							$CategoriesIntroduction = "{$title} a prezzi convenienti su Milanoo.com. Una vasta selezione di prodotti scontati. Qualità Garantita!";
						}else{
							$CategoriesIntroduction = strip_tags(htmlspecialchars_decode(stripcslashes($result['productCategory']['categoryIntroduce'])));
						}
					break;
					case 'es-sp':
						if(isset($result['productCategory']['seoTitle']) && !empty($result['productCategory']['seoTitle'])){
							$title = stripcslashes($result['productCategory']['seoTitle']);
						}else{
							$title = "{$title} | Venta al por mayor {$title} Online";
						}
						if(!isset($result['productCategory']['seoMeta']) || empty($result['productCategory']['seoMeta'])){
							$meta_keywords = $title;
						}else{
							$meta_keywords = stripcslashes($result['productCategory']['seoMeta']);
						}
						if(!isset($result['productCategory']['categoryIntroduce']) || empty($result['productCategory']['categoryIntroduce'])){
							$CategoriesIntroduction = "Comprar {$title} a precio bajo como mayorista desde {$title} Tienda Milanoo.com. La selección es de muchos productos en oferta con calidad garantizada!";
						}else{
							$CategoriesIntroduction = strip_tags(htmlspecialchars_decode(stripcslashes($result['productCategory']['categoryIntroduce'])));
						}
					break;
					case 'de-ge':
						if(isset($result['productCategory']['seoTitle']) && !empty($result['productCategory']['seoTitle'])){
							$title = stripcslashes($result['productCategory']['seoTitle']);
						}else{
							$title = "{$title} | Großhandel {$title} Online";
						}
						if(!isset($result['productCategory']['seoMeta']) || empty($result['productCategory']['seoMeta'])){
							$meta_keywords = $title;
						}else{
							$meta_keywords = stripcslashes($result['productCategory']['seoMeta']);
						}
						if(!isset($result['productCategory']['categoryIntroduce']) || empty($result['productCategory']['categoryIntroduce'])){
							$CategoriesIntroduction = "{$title} in billigen Großhandelspreisen von {$title} im Shop Milanoo.com kaufen. Die größste Auswahl an Rabattsprodukten mit Qualitätsgarantie.";
						}else{
							$CategoriesIntroduction = strip_tags(htmlspecialchars_decode(stripcslashes($result['productCategory']['categoryIntroduce'])));
						}
					break;
					
				}
			}
			else{
				$title = ucwords($seo_attrs ." ".stripcslashes($result['productCategory']['categoryName']));
				$meta_keywords = $title;
				switch (SELLER_LANG){
					case 'en-uk':
						$CategoriesIntroduction = "Shop ".$title." online. Browse through huge selection of ".$title." at Milanoo.com.";
					break;
					case 'ja-jp':
						$CategoriesIntroduction = "【".$title."】のオンラインショップ――【".$title."】の豊富なラインナップをMilanoo.comでチェック！";
					break;
					case 'fr-fr':
						$CategoriesIntroduction = "Acheter ".$title." en Ligne. Parcourez l'énorme sélection ".$title."de Milanoo.com.";
					break;
					case 'ru-ru':
						$CategoriesIntroduction = "Магазин ".$title." онлайн. Поищите из огромных ".$title." в Milanoo.com.";
					break;
					case 'it-it':
						$CategoriesIntroduction = "Acquista  ".$title." online. Scegli tra una vasta selezione di".$title."su Milanoo.com";
					break;
					case 'es-sp':
						$CategoriesIntroduction = "Compra ".$title." online. Busca en la gran selección de ".$title." en Milanoo.com.";
					break;
					case 'de-ge':
						$CategoriesIntroduction = "Kaufen ".$title." online. Finden Sie ".$title."mit riesigen Auswählen auf Milanoo.com.";
					break;
					
				}
			}
			//$meta_keywords = isset($result['productCategory']['seoMeta']) ? stripslashes($result['productCategory']['seoMeta']) : '';  
			//$CategoriesIntroduction = isset($result['productCategory']['categoryIntroduce']) ? stripslashes(strip_tags($result['productCategory']['categoryIntroduce'])) : ''; 
			$html_result .= '<title>'.$title.' - Milanoo.com</title>';
			$html_result .= '<meta name="description" content="'.$CategoriesIntroduction.'" />';
			$html_result .= '<meta name="keywords" content="'.$meta_keywords.'" />';
		}
	}		
	return $html_result;
}
?>
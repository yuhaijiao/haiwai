<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {html_promotion} plugin
 *
 * Type:     function
 * Name:     html_promotion
 * Purpose:  首页促销显示
 *
 * @version 1.0.0
 * @author Cheng Jun <cgjp123@163.com>
 * @param array
 * @param Smarty
 * @return string
 */
use Helper\ResponseUtil as Rewrite;
require_once 'modifier.number_format.php';
function smarty_function_html_promotion($params, &$smarty) {
	$type = $params ['type'];
	$pnum = $params ['pnum'];
	$html_result = '';
	if (! $type || ! $pnum) {
		return false;
	}
	switch ($type) {
		case 'Feature' :
			$mFeature = new \model\Promotion ();
			$feature = $mFeature->getListFeature ( $pnum );
			if ($feature ['code'] == 0 && ! empty ( $feature ['featureResults'] )) {
				$html_result = '<ul>';
				foreach ( $feature ['featureResults'] as $val ) {
					$val = dostrip($val);
					$url = Rewrite::rewrite ( array ('url' => '?module=promotions&action=specials&id=' . $val ['featureId'], 'isxs' => 'no', 'seo' => $val ['featureTitle'] ) );
					$html_result .= "<li>";
					$html_result .= "<a href='" . $url . "' title='" . $val ['featureDesc'] . "'><img src='" . CDN_UPLOAD_URL . "image/default/mlianoo_blank.gif' original='" . CDN_UPLOAD_URL . 'upen/m/' . $val ['logoImgUrl'] . "' /></a><span><a href='" . $url . "'>" . $val ['featureTitle'] . "</a></span>";
					$html_result .= "</li>";
				}
				$html_result .= "</ul>";
			}
			break;
		case 'DailyMadness' :
			$mDailymadness = new \model\Promotion ();
			$dailymadness = $mDailymadness->getPromotion ( 'DailyMadness', $pnum );
			if ($dailymadness ['code'] == 0 && ! empty ( $dailymadness ['productResults'] )) {
				$html_result = '';
				$html_result .='<h3 id="dailymadness">';
				if(!empty($dailymadness ['productResults'][0]['endtime']) && ($dailymadness ['productResults'][0]['endtime']>time())){
					$html_result .='<span id="clock"><span id="clock_words">'.\LangPack::$items['indextime01'].'</span> <span id="timeDown"></span></span>';
				}
				$html_result .=\LangPack::$items['index_dailMadn'].'</h3><div class="daily">';
				foreach ( $dailymadness ['productResults'] as $val ) {
					$val = dostrip($val);
					$url = Rewrite::rewrite ( array ('url' => '?module=thing&action=item&id=' . $val ['productId'], 'isxs' => 'no', 'seo' => stripcslashes($val ['productName']) ) );
					$html_result .= "<dl>";
					$html_result .= "<dt><a rel='nofollow' href='" . $url . "'><img src='" . CDN_UPLOAD_URL . "image/default/mlianoo_blank.gif' width='90' height='120' original='" . CDN_UPLOAD_URL . 'upen/90x120/c' . $val ['productImgUrl'] . "' /></a></dt>";
					$html_result .= "<dd>
					<span><a rel='nofollow' href='" . $url . "'>" . stripcslashes($val ['productName']) . "</a></span>";
					if($val ['rate']>0){
						if(SELLER_LANG=='en-uk'){
							$html_result .= "<strong> " . $langpack ['product_save'] . " " . $val ['rate'] . "% off</strong>";
						}else{
							$html_result .= "<strong> -" . $langpack ['product_save'] . " " . $val ['rate'] . "%</strong>";
						}
					}
					$html_result .= "<s>" . Currency . ' ' . smarty_modifier_number_format ( \Lib\common\Language::priceByCurrency ( $val ['productPrice'] ) ) . "</s>
                    <b>" . Currency . ' ' . smarty_modifier_number_format ( \Lib\common\Language::priceByCurrency ( $val ['salePrice'] ) ) . "</b>
                    </dd>";
					$html_result .= "</dl>";
				}
				$html_result .= '<p class="more"><a rel="nofollow" href="'.\LangPack::$items['$root_url'].'promotions/dailymadness.html">'.\LangPack::$items['shop_all_deals'].' &gt;</a></p></div>';
				if(!empty($dailymadness ['productResults'][0]['endtime'])  && ($dailymadness ['productResults'][0]['endtime']>time())){
					$timedown = date ( "Y/m/d H:i:s", $dailymadness ['productResults'][0]['endtime']);
					$html_result .= "<script type='text/javascript'>
									jq(document).ready(function() {
										jq('#timeDown').timeDown({
											runTime : '" . $timedown . "',
											timezone : 8,
											isDays : false
										});
									});
									</script>";
				}
			} else {
				$html_result = '';
			}
			break;
		case 'NewArrival' :
			$mNewarrival = new \model\IndexMiddle ();
			$newarrival = $mNewarrival->getNewArrival ( $pnum );
			if ($newarrival ['code'] == 0 && ! empty ( $newarrival ['productResults'] )) {
				$html_result = '<ul id="1">';
				foreach ( $newarrival ['productResults'] as $val ) {
					$val = dostrip($val);
					$url = Rewrite::rewrite ( array ('url' => '?module=thing&action=item&id=' . $val ['productId'], 'isxs' => 'no', 'seo' => stripcslashes($val ['productName']) ) );
					$html_result .= "<li>";
					$html_result .= "<a rel='nofollow' class='goods_pic' href='" . $url . "'><img src='" . CDN_UPLOAD_URL . "image/default/mlianoo_blank.gif' original='" . CDN_UPLOAD_URL . 'upen/m/' . $val ['pictureUrl'] . "' /></a>
                        <span><a rel='nofollow' href='" . $url . "'>" . stripcslashes($val ['productName']) . "</a></span>
                        <b>" . Currency . ' ' . smarty_modifier_number_format ( \Lib\common\Language::priceByCurrency ( $val ['productPrice'] ) ) . "</b>";
					$html_result .= "</li>";
				}
				$html_result .= "</ul>";
			}
			break;
		case 'BestSellers' :
			$mBestSellers = new \model\IndexMiddle ();
			$bestsellers = $mBestSellers->getSpotlight ( $pnum );
			if ($bestsellers ['code'] == 0 && ! empty ( $bestsellers ['productResults'] )) {
				$html_result = '<ul>';
				foreach ( $bestsellers ['productResults'] as $val ) {
					$val = dostrip($val);
					$url = Rewrite::rewrite ( array ('url' => '?module=thing&action=item&id=' . $val ['productId'], 'isxs' => 'no', 'seo' => specialchars($val ['productName']) ) );
					$html_result .= "<li>";
					$html_result .= "<a rel='nofollow' class='goods_pic' href='" . $url . "'><img src='" . CDN_UPLOAD_URL . 'upen/m/' . $val ['pictureUrl'] . "' original='" . CDN_UPLOAD_URL . "image/default/mlianoo_blank.gif' /></a>
                        <span><a rel='nofollow' href='" . $url . "'>" . specialchars($val ['productName']) . "</a></span>
                        <b>" . Currency . ' ' . smarty_modifier_number_format ( \Lib\common\Language::priceByCurrency ( $val ['productPrice'] ) ) . "</b>";
					$html_result .= "</li>";
				}
				$html_result .= "</ul>";
			}
			break;
		default :
			$mPromotion = new \model\Promotion ();
			$promotion = $mPromotion->getPromotion ( $type, $pnum );
			if ($promotion ['code'] == 0 && ! empty ( $promotion ['productResults'] )) {
				$html_result = '';
				foreach ( $promotion ['productResults'] as $val ) {
					$val = dostrip($val);
					$url = Rewrite::rewrite ( array ('url' => '?module=thing&action=item&id=' . $val ['productId'], 'isxs' => 'no', 'seo' => specialchars($val ['productName']) ) );
					$html_result .= "<dl>";
					$html_result .= "<dt><a class='goods_pic' href='" . $url . "'><img src='" . CDN_UPLOAD_URL . 'upen/m/' . $val ['productImgUrl'] . "' width='90' height='120' original='" . CDN_UPLOAD_URL . "image/default/mlianoo_blank.gif' /></a></dt>";
					$html_result .= "<dd>
					<span><a href='" . $url . "'>" . specialchars($val ['productName']) . "</a></span>
                    <strong> " . $langpack ['product_save'] . " " . $val ['rate'] . "%</strong>
                    <s>" . Currency . ' ' . smarty_modifier_number_format ( \Lib\common\Language::priceByCurrency ( $val ['productPrice'] ) ) . "</s>
                    <b>" . Currency . ' ' . smarty_modifier_number_format ( \Lib\common\Language::priceByCurrency ( $val ['salePrice'] ) ) . "</b>
                    </dd>";
					$html_result .= "</dl>";
				}
			}
			break;
	}
	return $html_result;
}

/**
	 * 去掉反斜杠
	 */
	function dostrip($value) {
		if (is_array ( $value )) {
			$value = array_map ( 'dostrip', $value );
		} else {
			$value = stripslashes ( $value );
			$value = htmlspecialchars_decode ( $value );
		}
		return $value;
	}
	
	function specialchars($value){
		return htmlspecialchars($value,ENT_QUOTES);
	}
/* vim: set expandtab: */
?>

<?php
use Helper\RequestUtil as R;
use Helper\String as HS;
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {html_comment} plugin
 *
 * Type:     function
 * Name:     html_comments
 * @author Jerry Yang<yang.tao.php@gmail.com>
 * @return string
 */
function smarty_function_html_comments($params, &$smarty)
{
	//$comment_obj=new \Model\Comment ();
	$pageNo=R::getParams('page');
	if(empty($pageNo)){$pageNo=1;}
	//$WebsiteId=R::getParams('WebsiteId');
	//if(empty($WebsiteId)){$WebsiteId=1;}
	$class=R::getParams('class');
	$id=R::getParams('id');
	// -------------获取评论-------------
	$pageSize=5;
	//$comments=$comment_obj->getCommentsByPid($id,$WebsiteId,$pageNo,$pageSize);
	$comments=$smarty->_tpl_vars['comments'];
	//分页
	$url_p ="?module=thing&action=item&class=" . $class . "&id=" . $id;
	$pages = \Helper\Page::getpage ( $comments ['listResults'] ['totalCount'], $pageSize, $pageNo, $url_p, 'wedding dress','.html#reviews',1);
	// echo '<pre>';
	// print_r($pages);
	// die;
	if($comments['code']==0 && $comments ['listResults'] ['totalCount']!=0){
		$html_result="
<div class='reviews' id='reviews'>
	<h3>".\LangPack::$items['thing_item_reviews'].":</h3><div id='reviews_wrap'>";
		foreach($comments['listResults']['results'] as $com){//评论
				$score=$com['productScore']*20;
				
				if(preg_match_all("/(\w+)@\w+\.\w+/",$com['memberName'],$match_ar)){
					$memberName=$match_ar[1][0];
				}else{
					$memberName=stripcslashes($com['memberName']);
				}
				if(preg_match_all("/(\w+)@\w+\.\w+/",$com['commentContent'],$match_ar2)){
					$commentContent=$match_ar2[1][0];
				}else{
					$commentContent=stripcslashes($com['commentContent']);
				}
				$html_result.="
<h4>
<span class='fr'>".$com['gmtCreate']."</span>
<span class='star'><b style='width:".$score."%'></b></span> ".\LangPack::$items['thing_item_by']." <b>".$memberName."</b>
</h4>
<p class='review'>".$commentContent."</p>
";
				foreach($com['commentReplyList'] as $reply){//回复
					$html_result.="
<div class='reply'>
<span class='fr'>".$reply['gmtCreate'].'</span>'.\LangPack::$items['thing_item_reply'].':<br />'.\LangPack::$items['thing_item_dear'].'&nbsp;'.$memberName.',<br />'.htmlspecialchars_decode($reply['replyContent']).'</div>';
				}
				$stack=explode(',',$_COOKIE['milanoo_helpful']);
					// echo '<pre>';
					// print_r($stack);
					// die;
				if(in_array($com['commentId'],$stack)){
					$html_result.="
<p class='helpful'><a class='help_yes' href='javascript:void(0)' ><span id='ishelpful".$com['commentId']."'>(".$com['helpFulNum'].")</span></a><a class='help_no' href='javascript:void(0)' ><span id='nohelpful".$com['commentId']."'>(".$com['notHelpFulNum'].")</span></a>
</p>";
				}else{
					$html_result.="
<p class='helpful'><a class='help_yes' href='javascript:void(0)' onclick='helpful(\"1\",\"".$com['commentId']."\");'><span id='ishelpful".$com['commentId']."'>(".$com['helpFulNum'].")</span></a><a class='help_no' href='javascript:void(0)' onclick='helpful(\"0\",\"".$com['commentId']."\");'><span id='nohelpful".$com['commentId']."'>(".$com['notHelpFulNum'].")</span></a></p>";
				}
		}
		$html_result.="<div class='pages'>".$pages."</div></div></div>";
	}else{
		return $comments['msg]'];
	}
    return $html_result;
}
?>
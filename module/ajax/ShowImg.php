<?php
namespace Module\Ajax;

class ShowImg extends \Lib\Application{
	public function run(){
		$params = \Lib\Helper\RequestUnit::getParams();
		if(!empty($params->params['type'])){
			$type = $params->params['type'];
			$uid = 1;
			$dbMibao = new \Model\Mibao();
			if($type=='creat'){
				$mibaoOpert = new \Lib\Helper\CreateMibaoImg();
				$mibaoOpert->creat($uid);
			}elseif($type=='down'){
				$cardInfo = $dbMibao->getCardByUid($uid);
				if(!empty($cardInfo)){
					$imgUrl = ROOT_PATH.'static' . DIRECTORY_SEPARATOR . 'mibao'. DIRECTORY_SEPARATOR .$cardInfo['card_num'].'.jpg';
					header("Content-type: application/octet-stream");
					header('Content-Disposition: attachment; filename="'. basename($imgUrl).'"');
					header("Content-Length: ". filesize($imgUrl));
					readfile($imgUrl);
					exit;
				}
			}
		}		
	}
}
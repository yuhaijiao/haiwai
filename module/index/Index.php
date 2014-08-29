<?php
namespace Module\Index;

/**
 * 
 * 首页
 * @author zhf
 *
 */
class Index extends \lib\Application{
	public function run(){
		$tpl = \Lib\Template::getSmarty();
		$param = \Lib\Helper\RequestUnit::getParams();
		$meets = new \Model\meetingModel();
	
		$tpl->display('index.htm');
	}
}
<?php
namespace Lib\Helper;
class Programme {
	
	public function __construct(){
		
	}
	
	public function timeHash($timeDelay=30,$hashWord='oliverTimeHash'){
		//一天总秒数
		$totalSenonds = 24*3600;
		//根据令牌值变化的间隔时间将一天划分为多个区间，必须能够整除
		$totalSize = $totalSenonds/$timeDelay;
		//当前时间是在当天的多少秒
		$nowTime = date('H')*3600+date('i')*60+date('s');
		//计算当前时间所在区块，采用舍去法
		$nowSize = floor($nowTime/$timeDelay);
		
		$hashString = $nowSize.$hashWord.'_cj'.date('Ymd',time());
		
		$hash = hash('md5', $hashString);
		$_SESSION['timeHash'] = $hash;
		return $hash;		
	}
	
	public function miBao($type=1){
		$mibaoOpert = new \Lib\Helper\CreateMibaoImg();
		$res = $mibaoOpert->creat($type);
	}
}
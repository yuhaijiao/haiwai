<?php
namespace Module\Service;
/**
* WINDOWS模块模拟DOS
* @example exec() 不输出结果，返回最后一行shell结果，所有结果可以保存到一个返回的数组里面
* @example system() 输出并返回最后一行shell结果。
* @example passthru() 只调用命令，把命令的运行结果原样地直接输出到标准输出设备上
* @author chengjun<chengjun@milanoo.com>
*/
class Cmd extends \lib\Application {
	public function run(){
		$tpl = \Lib\Template:: getSmarty();
		
		$cmd = escapeshellcmd('ssh root@192.168.0.161');
		$runStartTime = microtime(true);
		exec ($cmd,$result,$rs);
		echo $rs;
		$runEndTime = microtime(true);
		$runTime = round(($runEndTime - $runStartTime)*1000,2);
		$memoryUse = memory_get_peak_usage()/1024/1024;
		
		if(!empty($result)){
			foreach ($result as &$v){
				$v = htmlentities($v,ENT_COMPAT,'GB2312');
				$v= iconv('GB2312', 'UTF-8', $v);
			}
			unset ($v);
		}
		$tpl->assign('runTime',$runTime);
		$tpl->assign('memoryUse',round($memoryUse,2));
		$tpl->assign('child',1);
		$tpl->assign('title','模拟DOS');
		$tpl->assign('dec','模拟DOS命令行');
		$tpl->assign('result',$result);
		$tpl->display('service_index.htm');
	}
}
<?php
namespace Lib;
/**
 * PHP接口输出类
 * @author oliver
 *
 */
class Iouter {
	
	private $encodeData = null;
	
	public $type = 'json';
	
	public function __construct(){
		
	}
	
	/**
	 * 对数据进行编码
	 * @param unknown $data
	 * @param string $type
	 * @return Ambigous <unknown, string>|boolean
	 */
	private function encodeData($data,$type='json'){
		if(!empty($data) && is_array($data)){
			$data['code'] = 0;
			switch ($type){
				case 'json' : 
					$this->encodeData = json_encode($data);
					break;
				case 'array' :
					$this->encodeData = $data;
					break;
			}
		}else{
			return false;
		}
	}
	
	/**
	 * 输出数据
	 * @param unknown $data
	 * @return Ambigous <unknown, string>
	 */
	public function display($data){
		if(!empty($data)){
			$this->encodeData($data);
			if(!empty($this->encodeData)){
				return $this->encodeData;
			}
		}
	}
}
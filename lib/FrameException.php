<?php
namespace Lib;

/**
 * 定义异常输出类型接口
 * @author oliver
 *
 */
interface ExceptionFrame {
	/**
	 * 异常输出方法，变量必须是已定义的异常类
	 * @param \Lib\FrameException $e
	 */
	public function update(\Lib\FrameException $e);
}

/**
 * 定义异常
 * @author oliver
 *
 */
class FrameException extends \Exception{
	
	public static $_frame = array();
	
	public function __construct($message = null, $code = 0){
		parent::__construct($message,$code);
		//error_log('Error in '.$this->getFile().' Line: '.$this->getLine() . ' Error: '.$this->getMessage());
		$this->notify();
	}
	
	/**
	 * 创建异常输出类型的静态方法
	 * 变量使用强制暗示类型，必须是继承于异常输出接口的实例
	 * @param \Lib\ExceptionFrame $frame
	 */
	public static function attach(\Lib\ExceptionFrame $frame){
		self::$_frame[] = $frame;
	}
	
	public function notify(){
		foreach (self::$_frame as $frame){
			$frame->update($this);
		}
	}
	
}

/**
 * 日志记录异常类型
 * @author oliver
 *
 */
 class logException implements \Lib\ExceptionFrame {
 	/**
 	 * 输出异常
 	 * @see \Lib\ExceptionFrame::update()
 	 */
	public function update(\Lib\FrameException $e){
		error_log('Error in '.$e->getFile().' Line: '.$e->getLine() . ' Error: '.$e->getMessage());
	}
}

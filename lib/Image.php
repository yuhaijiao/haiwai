<?php
namespace Lib;
/**
 * 图像处理类
 * @author Su Chao<suchaoabc@163.com>
 * @since 2011-11-22
 */
class Image{
	/**
	 * 生成验证码
	 * @param int $width 验证码图片宽度.默认130
	 * @param int $height 验证码图片高度.默认40
	 * @param int $fontSize 验证码字体大小.默认20
	 * @param int $length 验证码字符个数.默认4
	 * @return string  验证码中的字符串
	 */
	public static function getCaptcha($width='130', $height='40', $fontSize='20', $length='4')
	{

		$chars = '0123456789abcdefghijklmnopqrstuvwxyz';
		$randStr = substr(str_shuffle($chars), 0, $length);
		
		$image			= imagecreatetruecolor($width, $height);
		
		// 定义背景色
		$bgColor		= imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
		// 定义文字及边框颜色
		$blackColor	= imagecolorallocate($image, 0x00, 0x00, 0x00);
		 
		//生成矩形边框
		imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);		
		
		// 循环生成雪花点
		for ($i = 0; $i < 200; $i++)
		{
			$grayColor = imagecolorallocate($image, 128 + rand(0, 128), 128 + rand(0, 128), 128 + rand(0, 128));
			imagesetpixel($image, rand(1, $width-2), rand(4, $height-2), $grayColor);
		}
		$font	= ROOT_PATH . 'static/fonts/acidic.ttf';
		// 把随机字符串输入图片
		$i=-1;
		while (isset($randStr[++$i]))
		{
			$fontColor	= imagecolorallocate($image, rand(0, 100), rand(0, 100),rand(0, 100));
			if(!function_exists('imagettftext')) 
			{
				imagechar( $image, $fontSize ,  15 + $i*30, rand(5,20), $randStr[$i], $fontColor );
			}
			else
			{
				imagettftext($image, $fontSize, 0, 10 + $i*30, rand(25,35), $fontColor, $font, $randStr[$i]);
			}
		}		
		imagepng($image);
		$image=$bgColor=$blackColor=$grayColor=$fontColor=null;
		return $randStr;
	}
	
	/**
	 * 获取数字计算类型的验证码
	 * @param string $width 验证图片宽
	 * @param string $height 验证图片高
	 * @param string $fontSize 验证图片字体大小
	 * @param int $maxDigital 验证图片中数字最大数位
	 * @param int $maxLevel	几个数参与运算 ，默认为2 表示最多只有2个数参与运算
	 * @author chengjun <chengjun@milanoo.com>
	 */
	public static function getMathCaptcha($width='130', $height='40', $fontSize='28',$maxDigital=1,$maxLevel=2){
		if($maxDigital<1){
			$maxDigital = 2;
		}
		//运算符
		$numberOperators = array('+','x');
		
		//数字池最小
		$numberSourceStart = 1;
		//数字池最大数
		$numberSourceEnd = pow(10, $maxDigital) - 1;
		 
		$numberArray = array();
		for($i=0;$i<$maxLevel;$i++){
			$numberArray[$i] = rand($numberSourceStart,$numberSourceEnd);
		}
		$randKey = array_rand($numberOperators,1);
		$operator = $numberOperators[$randKey];
		$getResult = function($number,$opera){
			$r = 0;
			foreach($number as $k=>$v){
				if($k==0){
					$r = $number[0];
				}else{
					switch ($opera){
						case '+':
							$r += $v;
							break;
						case '-':
							$r -= $v;
							break;
						case 'x':
							$r *= $v;
							break;
					}
				}
			}
			return $r;
		};
		$result = $getResult($numberArray,$operator);
		
		$image			= imagecreatetruecolor($width, $height);
		// 定义背景色
		$bgColor		= imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
			
		//生成矩形边框
		imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);
		
		// 循环生成雪花点
		for ($i = 0; $i < 200; $i++)
		{
		$grayColor = imagecolorallocate($image, 128 + rand(0, 128), 128 + rand(0, 128), 128 + rand(0, 128));
		imagesetpixel($image, rand(1, $width-2), rand(4, $height-2), $grayColor);
		}
		
		//画10条干扰线
		for ($i = 0; $i < 5; $i++){
			$lineColor = imagecolorallocate($image, 128 + rand(0, 128), 128 + rand(0, 128), 128 + rand(0, 128));
			//画直线
			imageline($image,rand(1, $width-2),rand(4, $height-2),rand(1, $width-2),rand(4, $height-2),$lineColor);
			//画弧线
			imagearc($image,rand(0, ($width-2)/2),rand(0, ($height-2)/2),rand(5, $width-2),rand(10, $height-2),0,rand(10, 180),$lineColor);
		}
		
		$font	= ROOT_PATH . 'static/fonts/xiaowanzi.ttf';
		// 把随机数字和符号输入图片
		//重新生成数组把数字和符号放在一起
		$newNumberArray = array();
		for($i=0,$j=0;$i<$maxLevel;$i++,$j+=2){
			$newNumberArray[$j] = $numberArray[$i];
			$newNumberArray[$j+1] = $operator;
		}
		array_pop($newNumberArray);
		array_push($newNumberArray, '=');
		for($i=0;$i<count($newNumberArray);$i++){
			//随机字符颜色
			$fontColor	= imagecolorallocate($image, rand(0, 100), rand(0, 100),rand(0, 100));
			if(!function_exists('imagettftext'))
			{
				imagechar( $image, $fontSize ,  15 + $i*30, rand(5,20), $newNumberArray[$i], $fontColor );
			}
			else
			{
				imagettftext($image, $fontSize, 0, 10 + $i*30, rand(25,35), $fontColor, $font, $newNumberArray[$i]);
			}
			
		}
		imagepng($image);
		$image=$bgColor=$grayColor=$fontColor=null;
		return $result;
	}
}
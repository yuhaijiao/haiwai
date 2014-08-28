<?php
namespace Lib\Helper;
/**
 * 生成图片类
 * @author Administrator
 *
 */
class CreateMibaoImg {
	
	var $data = array();
	var $c_x = \Config\MibaoConfig::MIBAO_X;
	var $c_y = \Config\MibaoConfig::MIBAO_Y;
	var $c_num = \Config\MibaoConfig::MIBAO_NUM;
	
	var $uid = 1;
	
	//生成密保矩阵
	public function creat($uid=1){
		$this->uid = $uid;
		$data = array();
		$rand_str = $this->c_x;//密保横坐标
		$arr = array();
		for ($k = 0; $k < strlen($rand_str); $k++) {
			for ($i = 1; $i <= $this->c_y; $i++) {
				$rand = \Lib\Helper\CommonFunction::rand_num($this->c_num);
				//赋给所有code的容器
				$arr[$rand_str{$k} . $i] = $rand;
			}
		}
		$this->data['card_info'] = serialize($arr);
		$this->card_num();
	}
	
	//生成密保序列号
	private function card_num(){
		$dbMibao = new \Model\Mibao();
		while (true) {
			$this->data['card_num'] = \Lib\Helper\CommonFunction::rand_num(20);
			//判断序列号是否重复存在
			if (!($dbMibao -> isHasCard($this->data['card_num']))) {
				break;
			}
		}
			$data = array();
			$data['creattime'] = time();
			$data['status'] = '1';
			$data['card_info'] = $this->data['card_info'];
			$data['card_num'] = $this->data['card_num'];
			$data['uid'] = $this->uid;
 			$result = $dbMibao->InsertCard($data);
 			if($result){
				$this->show($data['card_num'],1);
 			}
		return;
	}
	
	/**
	 * 显示卡
	 * @param unknown $cardNum
	 * @return boolean
	 */
	public function show($cardNum,$type=1) {
		$dbMibao = new \Model\Mibao();
		$info = $dbMibao->getCardByCardNum($cardNum);
		if(empty($info)){
			return false;
		}
		$codes = unserialize($info['card_info']);
		$cardNum = $info['card_num'];
		//图片初始值

		$bit = 3;
		//密保卡位数

		$height = 332;
		//图片高度

		$width = 626;
		//图片宽度

		$im = imagecreatetruecolor($width, $height);

		$linecolor = imagecolorallocate($im, 229, 229, 229);

		$fontcolor = imagecolorallocate($im, 0, 0, 0);

		$top_rectangle_color = imagecolorallocate($im, 241, 254, 237);

		$top_letter_color = imagecolorallocate($im, 54, 126, 76);

		$left_rectangle_color = imagecolorallocate($im, 243, 247, 255);

		$left_num_color = imagecolorallocate($im, 4, 68, 192);

		$logo_str_color = imagecolorallocate($im, 0, 0, 0);
		
		$color = imagecolorallocate($im, 0, 0, 0);

		imagefill($im, 0, 0, imagecolorallocate($im, 255, 255, 255));
		//图片背景色

		$font = FONTSURL.'FZYTK.TTF';
		//字体

		$font_en = FONTSURL.'FZYTK.TTF';
		//英文字体

		$font2 = FONTSURL.'FZYTK.TTF';
		//密保卡上方黑体

		//$dst = imagecreatefromjpeg("./public/baomi/120.jpg");

		//imagecopymerge($im, $dst, 120, 15, 0, 0, 193, 55, 100);

		imageline($im, 10, 72, $width - 10, 72, $linecolor);

		$ltext = \Config\MibaoConfig::MIBAO_NAME;

		if (!imagettftext($im, 10, 0, 280, 47, $logo_str_color, $font2, $ltext)) {
			exit('error');
		}

		//写入卡号

		$b = '1000' . $cardNum;
		$p = '';

		for ($i = 0; $i < 7; $i++) {

			$p .= substr($b, 3 * $i, 4) . ' ';

		}

		$x = 40;
		$y = 95;
		//序列号位置
		

		imagettftext($im, 10, 0, $x, $y, $color, $font, '序列号');

		imagettftext($im, 11, 0, $x + 50, $y, $color, $font_en, $p);

		//颜色框

		imagefilledrectangle($im, 10, 106, $width - 10, 128, $top_rectangle_color);

		imagefilledrectangle($im, 10, 129, 65, $height - 10, $left_rectangle_color);

		//写入最上排英文字母及竖线
		//写入横坐标
		$_x = $this->c_x;

		for ($i = 1; $i <= 10; $i++) {

			$x = $i * 55 + 35;
			$y = 123;
			$float_size = 11;
			//字母位置参数

			imagettftext($im, $float_size, 0, $x, $y, $top_letter_color, $font_en, $_x{$i - 1});
			//写入最上排英文字母

		}

		for ($i = 0; $i <= 9; $i++) {

			$linex = $i * 55 + 65;
			$liney = 105;
			$liney2 = $height - 10;
			//竖线位置参数

			imageline($im, $linex, $liney, $linex, $liney2, $linecolor);
			//划入竖线

		}

		//写入竖排数字及填入矩阵数据 划横线
		$_y = $this->c_y;

		for ($j = 0; $j < $_y; $j++) {

			$jj = $j + 1;

			$x = 35;
			$y = ($jj * 24) + 123;
			//左排数字及横线位置参数

			imagettftext($im, $float_size, 0, $x, $y, $left_num_color, $font_en, $jj);
			//写入左排数字
	
			for ($i = 1; $i <= 10; $i++) {

				$float_size2 = 11;
				$x = $i * 55 + 27;
				$sy = $y;
				//填入矩阵数据位置参数

				$s = $_x{$i - 1};
				$s .= $j + 1;
				//echo $codes[$s];
				imagettftext($im, $float_size2, 0, $x, $sy, $fontcolor, $font_en, $codes[$s]);
				//写入矩阵数据

			}
		}

		for ($j = 0; $j < 10; $j++) {

			$line_x = 10;
			$line_x2 = $width - 10;
			$y = $j * 24 + 105;
			//横线位置参数 y坐标数据同上

			imageline($im, $line_x, $y, $line_x2, $y, $linecolor);
			//划入横线

		}

		//外框边线

		imageline($im, 10, 10, $width - 10, 10, $linecolor);
		//横线

		//imageline($im,10,$height-10,$width-10,$height-10,$linecolor);

		imageline($im, 10, 10, 10, $height - 10, $linecolor);
		//竖线

		imageline($im, $width - 10, 10, $width - 10, $height - 10, $linecolor);

		//生成图片
		//exit();
		$imgPath = ROOT_PATH.'static' . DIRECTORY_SEPARATOR . 'mibao'. DIRECTORY_SEPARATOR .$cardNum.'.jpg';
		imagejpeg($im, $imgPath, 100);
		imagedestroy($im);
	}
}

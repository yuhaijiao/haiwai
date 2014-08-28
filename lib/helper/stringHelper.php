<?php
namespace Lib\Helper;
/**
 *  获取拼音以gbk编码为准
 *
 * @access    public
 * @param     string  $str  字符串
 * @param     int  $ishead  是否为首字母
 * @param     int  $isclose  解析后是否释放资源
 * @return    string
 */
class stringHelper {
	public static function GetPinyin($str, $ishead=0, $isclose=1)
	{
		$pinyins = Array();
	    $restr = '';
	    $str=iconv('UTF-8', 'GBK//IGNORE', $str);
	    $str = trim($str);
	    $slen = strlen($str);
	    if($slen < 2)
	    {
	        return $str;
	    }
	    if(count($pinyins) == 0)
	    {
	        $fp = fopen(ROOT_PATH.'/data/pinyin.dat', 'r');
	        while(!feof($fp))
	        {
	            $line = trim(fgets($fp));
	            $pinyins[$line[0].$line[1]] = substr($line, 3, strlen($line)-3);
	        }
	        fclose($fp);
	    }	    
	    for($i=0; $i<$slen; $i++)
	    {
	        if(ord($str[$i])>0x80)
	        {
	            $c = $str[$i].$str[$i+1];
	            $i++;
	            if(isset($pinyins[$c]))
	            {
	                if($ishead==0)
	                {
	                    $restr .= $pinyins[$c];
	                }
	                else
	                {
	                    $restr .= $pinyins[$c][0];
	                }
	            }else
	            {
	                $restr .= "_";
	            }
	        }else if( preg_match("/[a-z0-9]/i", $str[$i]) )
	        {
	            $restr .= $str[$i];
	        }
	        else
	        {
	            $restr .= "_";
	        }
	    }
	    if($isclose==0)
	    {
	        unset($pinyins);
	    }
	    return $restr;
	}
}
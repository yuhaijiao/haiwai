<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty stripcslashes modifier plugin
 *
 * Type:     modifier<br>
 * Name:     stripcslashes<br>
 * Purpose:  字符串转义
 * Example:  {$var|stripcslashes} 
 * Date:     2011-11-25
 * @link http://smarty.php.net/manual/en/language.modifier.strip.php
 *          strip (Smarty online manual)
 * @author   jianjun wu<wujianjun@milanoo.com>
 * @version  1.0
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_stripcslashes($text)
{
    return stripcslashes($text);
}

/* vim: set expandtab: */

?>

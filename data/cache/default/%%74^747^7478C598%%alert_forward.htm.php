<?php /* Smarty version 2.6.18, created on 2014-05-15 13:26:31
         compiled from alert_forward.htm */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>milanoo 会议室管理系统-提示信息了呀</title>		
	</head>
	<body>
<style type="text/css">
.footer{text-align:center;}
.tableborder {

	outline: 1px solid #555;

	border: 0px !important;

	> border: 1px solid #bbb !important;

	border: 1px solid #bbb;

	empty-cells: show;

	border-collapse: separate !important;

	> border-collapse: collapse !important;

	border-collapse: collapse;

}

.tableborder td {

	border-bottom: 1px solid #bbb;

	line-height: 1.5em;

	height: 2em;

	padding: 4px;

	background: #bbb;

}

.tableborder td ul, .tableborder td ul li {

	line-height: 22px;

	margin-bottom: 0px;

	margin-top: 0px;

}

.tableborder td img {

	margin-top: 8px;

}

.tableborder td .smalltxt {

	line-height: 20px;

}
/*表格头(表格标签)---->>>*/

.header td {

	background: url('<?php echo $this->_tpl_vars['staticUrl']; ?>
image/bg.gif') repeat-x;

	line-height: 16px;

	height: 31px !important;

	> height: 30px !important;

	height: 30px;

	font-weight: bold;

	color: #FFFFFF;

	border-bottom: 1px solid #bbb;

	padding: 0px 8px;

}

.header a{

	color: #FFFFFF;

}
td.altbg1,.altbg1 td {background: #EBF4D8;}
td.altbg2,.altbg2 td,td.altbg3{background: #eeeeee;}
td.altbg3{ white-space:normal; word-wrap:break-word; line-height:15px;}
</style>
<table width="100%" border="0" cellpadding="2" cellspacing="6"><tr><td><br /><br /><br /><br /><br /><br />
<table width="500" border="0" cellpadding="0" cellspacing="0" align="center" class="tableborder">
	<tr class="header">
		<td>提示信息</td>
	</tr>
	<tr>
		<td class="altbg2">
			<div align="center">
				<?php if ($this->_tpl_vars['is_extra'] == 1): ?>
					<?php echo $this->_tpl_vars['msg']; ?>

				<?php else: ?>
					<br /><br /><br />
					<?php if ($this->_tpl_vars['is_lang'] == 1): ?><?php echo $this->_tpl_vars['action_lang'][$this->_tpl_vars['msg']]; ?>
<?php else: ?><?php echo $this->_tpl_vars['msg']; ?>
<?php endif; ?><br /><br /><br />
					<a href="javascript:forwardRedirect();"><?php if ($this->_tpl_vars['url'] || $this->_tpl_vars['script']): ?>如果您的浏览器没有自动跳转，请点击这里<?php else: ?>[ 点击这里返回上一页 ]<?php endif; ?></a><br /><br />
				<?php endif; ?>
			</div>
			<br /><br />
		</td>
	</tr>
</table><br /><br /><br /></td></tr></table>
<script>
var forwardtime=setTimeout(forwardRedirect,200000);
function forwardRedirect(){
	clearTimeout(forwardtime);
	<?php if ($this->_tpl_vars['script']): ?>
		<?php echo $this->_tpl_vars['script']; ?>

		<?php if ($this->_tpl_vars['url']): ?>self.location.href='<?php echo $this->_tpl_vars['url']; ?>
';<?php endif; ?>
	<?php else: ?>
		<?php if ($this->_tpl_vars['url']): ?>
			self.location.href='<?php echo $this->_tpl_vars['url']; ?>
';
			//redirect('<?php echo $this->_tpl_vars['url']; ?>
');
		<?php else: ?>
			history.go(-1);
		<?php endif; ?>
	<?php endif; ?>
}
</script>
</body>
</html>
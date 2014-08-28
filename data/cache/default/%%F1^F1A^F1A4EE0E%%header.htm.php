<?php /* Smarty version 2.6.18, created on 2014-05-19 11:06:05
         compiled from header.htm */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>milanoo 会议室管理系统</title>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['css_path']; ?>
reset.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['css_path']; ?>
text.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['css_path']; ?>
grid.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['css_path']; ?>
layout.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['css_path']; ?>
nav.css" media="screen" />
		<script type="text/javascript" src="<?php echo $this->_tpl_vars['js_path']; ?>
jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->_tpl_vars['js_path']; ?>
jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->_tpl_vars['js_path']; ?>
action.js"></script>
	</head>
	<body>
    <div class="container_12">
		<div class="grid_12 clearfix">
			<a href="<?php echo @ROOT_URL; ?>
" id="branding"><?php echo @WEB_NAME; ?>
</a> 		
			<div class="infos">
				<span>欢迎，<a href="index.php?module=member&action=index" title="进入人个中心"><?php echo $this->_tpl_vars['memberName']; ?>
</a>同学!&nbsp;&nbsp;&nbsp;</span>
				<a href="index.php?module=meeting&action=edit">会议室预订</a>	
				<?php if ($this->_tpl_vars['memberIsadmin']): ?>
					<a href="index.php?module=meeting&action=index">会议室管理</a>	
					<a href="index.php?module=system&action=set">系统设置</a>	
				<?php endif; ?>
				<a href="index.php?module=index&action=logout">退出登录</a>	
			</div>	
		</div>
<?php /* Smarty version 2.6.18, created on 2014-08-28 17:29:22
         compiled from index.htm */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['css_path']; ?>
common.css"/>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['css_path']; ?>
layout.css" type="text/css">
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['css_path']; ?>
index.css" type="text/css">
 <script type="text/javascript">
	function logoutWeb(){
		 top.location.href=root_url+'index/logout.html';
	}
</script>

<div class="grid_10 home_box" id="content_box">       
	
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
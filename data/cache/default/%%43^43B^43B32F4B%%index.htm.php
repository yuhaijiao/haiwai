<?php /* Smarty version 2.6.18, created on 2014-08-29 11:02:55
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
	
</script>
<table>
	<tr>
		<td>球队名称</td>
		<td>教练</td>
		<td>队长</td>
		<td>积分</td>
	</tr>
<?php $_from = $this->_tpl_vars['result']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
	<tr>
		<td><?php echo $this->_tpl_vars['val']['name']; ?>
</td>
		<td><?php echo $this->_tpl_vars['val']['coach']; ?>
</td>
		<td><?php echo $this->_tpl_vars['val']['leader']; ?>
</td>
		<td><?php echo $this->_tpl_vars['val']['points']; ?>
</td>
	</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
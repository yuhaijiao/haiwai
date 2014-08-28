<?php /* Smarty version 2.6.18, created on 2014-05-19 11:06:30
         compiled from systemSet.htm */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['css_path']; ?>
common.css"/>
 <script src="<?php echo $this->_tpl_vars['js_path']; ?>
jquery-1.9.1.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['js_path']; ?>
jquery.validate.js"></script>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['js_path']; ?>
jquery-ui.css" />
 <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
 <script src="<?php echo $this->_tpl_vars['js_path']; ?>
ckeditor/ckeditor.js"></script>

      <div class="grid_10 home_box" id="content_box">
       
<div class="grid_10 home_box" id="content_box">       
	<div class="box">
		<h2>系统设置</h2>
		<div class="block" >
			<form action="" method="post">
				<table class="edit">
					<tr>
						<th>接受预订需要提前的时间(天):<span class="required">*</span></th><td  colspan="9"><input  name="aheadtime" size="55" type="text" value="<?php echo $this->_tpl_vars['sysConfig']['aheadtime']; ?>
" required="required"/>如:"1"</td>
					</tr>
					<tr>
						<th>接受预订开始时间：<span class="required">*</span></th><td  colspan="9"><input  name="startbooktime" size="55" type="text" value="<?php echo $this->_tpl_vars['sysConfig']['startbooktime']; ?>
" required="required"/><span> 格式: 时:分:秒. 如:"09:00:00"</span></td>
					</tr>
					<tr>
						<th>接受预订结束时间：<span class="required">*</span></th><td  colspan="9"><input  name="endbooktime" size="55" type="text" value="<?php echo $this->_tpl_vars['sysConfig']['endbooktime']; ?>
" required="required"/><span> 格式: 时:分:秒. 如:"18:00:00"</span></td>
					</tr>
					<tr>
						<th>接受退订提前的时间(天):<span class="required">*</span></th><td  colspan="9"><input  name="debooktime" size="55" type="text" value="<?php echo $this->_tpl_vars['sysConfig']['debooktime']; ?>
" required="required"/>如:"1"</td>
					</tr>
					<tr>
						<th>同一会议室两场会议间隔时间(分)：<span class="required">*</span></th><td  colspan="9"><input  name="interval" size="55" type="text" value="<?php echo $this->_tpl_vars['sysConfig']['interval']; ?>
" required="required"/>如:"5"</td>
					</tr>
					<tr>
						<th>会议管理制度标题：<span class="required">*</span></th><td  colspan="9"><input  name="ruletitle" size="55" type="text" value="<?php echo $this->_tpl_vars['sysConfig']['ruletitle']; ?>
" required="required"/></td>
					</tr>
					<!-- <tr>
						<th>激活：</th><td  colspan="9"><input  name="activation" size="55" type="checkbox" <?php if ($this->_tpl_vars['sysConfig']['activation']): ?>checked<?php endif; ?> value='1'/></td>
					</tr> -->
					<tr>
						<th>会议管理制度：<span class="required">*</span></th><td  colspan="9"><textarea class="ckeditor" required="required" minlength="20" name="rule" style="width: 400px;height: 100px;"><?php echo $this->_tpl_vars['sysConfig']['rule']; ?>
</textarea></td>
					</tr>
					
					<tr><th></th>
						<td style="padding:5px 0;">
							<button type="reset">重置</button>
							<button class="submitbtn" type="submit">提交</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php /* Smarty version 2.6.18, created on 2014-05-06 18:16:06
         compiled from login.htm */ ?>
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

      <div class="grid_10 home_box" id="content_box">
       
<div class="box">

  <h2>请先登录</h2>
  <div class="block">
   		<form action='' method="POST" id="login_submit">
   		<input name="formsubmmit" value="1" type="hidden" />
   		<table style="width:40%;" class="common-table" >
   		<tr>
   			<td width="30%">用户名：</td>
   			<td width="70%"><input type="text" value="" name="username" /></td>
   		</tr>
   		<tr>
   			<td>密码：</td>
   			<td><input type="password" value="" name="password" /></td>
   		</tr>
   		<tr>
   			<td>验证码：<span class="tips">请输入计算结果</span></td>
   			<td>
   			<img onclick="javascript:changeimg('login')" id="vfcodelogin" src="<?php echo $this->_tpl_vars['root_url']; ?>
auth/captcha.html?act=login" style="height:35px;vertical-align:middle;" />
   			<input type="text" class="text" name="verifycode" size="5"  /> 
			<input type="hidden" name="act" value="login" />
			</td>
   		</tr>
   		<tr>
   			<td colspan="2">
   			<input type="submit" value="登录" />
   			</td>
   		</tr>
   		</table>
   		</form>
  </div>

</div>
<script type="text/javascript">
(function($) {
	$(function(){	
		// validate signup form on keyup and submit
	    $("#login_submit").validate({
	        event: "keyup",
	        rules: {
	        username: "required",
	        password: "required",
	        verifycode: "required",
	        	username: {
	                required: true,                       
	            },
	            password: {
	                required: true,                       
	            },
	            verifycode: {
	                required: true
	            }
	        },
	        messages: {
	        	username: {
	                required: "请输入用户名"                   
	            },
	            password: {
	                required: "请输入密码"                   
	            },
	            verifycode: {
	                required: "请输入验证码"
	            }
	        },
			submitHandler:function(form){
				form.submit();
			}
	    });
		
	});
})(jQuery);

function changeimg(act)
{
	$('#vfcode'+act).attr('src','<?php echo $this->_tpl_vars['root_url']; ?>
auth/captcha.html?act='+ act + '&' + Math.random());
}
</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
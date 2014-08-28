<?php /* Smarty version 2.6.18, created on 2014-05-19 16:33:52
         compiled from memberIndex.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'memberIndex.htm', 33, false),)), $this); ?>
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
	<div class="box">
		<h2>我预订的会议(<?php echo $this->_tpl_vars['day']; ?>
)</h2>
		<div><a href="<?php echo $this->_tpl_vars['preDay']; ?>
">前一日</a>/<a href="<?php echo $this->_tpl_vars['nextDay']; ?>
">后一日</a></div>
		<div class="block" >
			<table>
				<tr>
					<th>会议室</th>
					<th>时间</th>
					<th>会议名</th>
					<th>简介</th>
					<th>被邀请人</th>
					<th>需要行政协助</th>
					<th>行政审核</th>
				</tr>
				<?php echo ''; ?><?php if ($this->_tpl_vars['myBooks']): ?><?php echo ''; ?><?php $_from = $this->_tpl_vars['myBooks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['chenyao']):
?><?php echo '<tr><td>'; ?><?php echo $this->_tpl_vars['chenyao']['meetingaddress']; ?><?php echo '</td><td>'; ?><?php echo $this->_tpl_vars['chenyao']['meetingstarttime']; ?><?php echo '-'; ?><?php echo $this->_tpl_vars['chenyao']['meetingendtime']; ?><?php echo '</td><td><a href="index.php?module=meeting&action=edit&bookid='; ?><?php echo $this->_tpl_vars['chenyao']['bookid']; ?><?php echo '" title="编辑此预订信息">'; ?><?php echo $this->_tpl_vars['chenyao']['meetingname']; ?><?php echo '</a></td><td title="'; ?><?php echo $this->_tpl_vars['chenyao']['meetingintro']; ?><?php echo '">'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['chenyao']['meetingintro'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 100) : smarty_modifier_truncate($_tmp, 100)); ?><?php echo '</td><td title="'; ?><?php echo $this->_tpl_vars['chenyao']['inviteeCN']; ?><?php echo '">('; ?><?php echo $this->_tpl_vars['chenyao']['inviteenum']; ?><?php echo '人)'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['chenyao']['inviteeCN'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 40) : smarty_modifier_truncate($_tmp, 40)); ?><?php echo '</td><td title="'; ?><?php echo $this->_tpl_vars['chenyao']['extralist']; ?><?php echo '">'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['chenyao']['extralist'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 100) : smarty_modifier_truncate($_tmp, 100)); ?><?php echo '</td><td class="isAgree">'; ?><?php echo $this->_tpl_vars['chenyao']['isagreeCN']; ?><?php echo ''; ?><?php if (! $this->_tpl_vars['chenyao']['meetingdebook'] && $this->_tpl_vars['chenyao']['isagree'] == 0): ?><?php echo '<span id="debook'; ?><?php echo $this->_tpl_vars['chenyao']['bookid']; ?><?php echo '" val=\''; ?><?php echo $this->_tpl_vars['chenyao']['bookid']; ?><?php echo '\'>&nbsp;&nbsp;退订</span>'; ?><?php elseif ($this->_tpl_vars['chenyao']['meetingdebook'] == 1): ?><?php echo '&nbsp;&nbsp;已退订'; ?><?php elseif ($this->_tpl_vars['chenyao']['isagree'] == 1): ?><?php echo '<a href="index.php?module=meeting&action=conference&id='; ?><?php echo $this->_tpl_vars['chenyao']['bookid']; ?><?php echo '">&nbsp;&nbsp;开始会议纪要</a>'; ?><?php endif; ?><?php echo '</td></tr>'; ?><?php endforeach; endif; unset($_from); ?><?php echo ''; ?><?php else: ?><?php echo '<tr><td colspan="7">Sorry啦,你在'; ?><?php echo $this->_tpl_vars['day']; ?><?php echo '日还没有预订会议室呢。您可以<a href="index.php?module=meeting&action=edit">预订会议室</a>，也可以<a href="">浏览会议室使用日历</a></td></tr>'; ?><?php endif; ?><?php echo ''; ?>

			</table>
		</div>
	</div>

	<div class="box">
		<h2>我被邀请的会议(<?php echo $this->_tpl_vars['day']; ?>
)</h2>
		<div><a href="<?php echo $this->_tpl_vars['preDay']; ?>
">前一日</a>/<a href="<?php echo $this->_tpl_vars['nextDay']; ?>
">后一日</a></div>
		<div class="block" >
			<table>
				<tr>
					<th>会议室</th>
					<th>时间</th>
					<th>预订人</th>
					<th>会议名</th>
					<th>简介</th>
					<th>被邀请人</th>
					<th>需要行政协助</th>
					<th>行政审核</th>
				</tr>
				<?php echo ''; ?><?php if ($this->_tpl_vars['inviteed']): ?><?php echo ''; ?><?php $_from = $this->_tpl_vars['inviteed']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['chenyao']):
?><?php echo '<tr><td>'; ?><?php echo $this->_tpl_vars['chenyao']['meetingaddress']; ?><?php echo '</td><td>'; ?><?php echo $this->_tpl_vars['chenyao']['meetingstarttime']; ?><?php echo '-'; ?><?php echo $this->_tpl_vars['chenyao']['meetingendtime']; ?><?php echo '</td><td>'; ?><?php echo $this->_tpl_vars['chenyao']['bookuser']; ?><?php echo '</td><td>'; ?><?php if (( $this->_tpl_vars['memberIsadmin'] || $this->_tpl_vars['memberName'] == $this->_tpl_vars['chenyao']['bookuser'] )): ?><?php echo '<a href="index.php?module=meeting&action=edit&bookid='; ?><?php echo $this->_tpl_vars['chenyao']['bookid']; ?><?php echo '" title="编辑此预订信息">'; ?><?php echo $this->_tpl_vars['chenyao']['meetingname']; ?><?php echo '</a>'; ?><?php else: ?><?php echo ''; ?><?php echo $this->_tpl_vars['chenyao']['meetingname']; ?><?php echo ''; ?><?php endif; ?><?php echo '</td><td title="'; ?><?php echo $this->_tpl_vars['chenyao']['meetingintro']; ?><?php echo '">'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['chenyao']['meetingintro'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 100) : smarty_modifier_truncate($_tmp, 100)); ?><?php echo '</td><td title="'; ?><?php echo $this->_tpl_vars['chenyao']['inviteeCN']; ?><?php echo '">('; ?><?php echo $this->_tpl_vars['chenyao']['inviteenum']; ?><?php echo '人)'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['chenyao']['inviteeCN'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 40) : smarty_modifier_truncate($_tmp, 40)); ?><?php echo '</td><td title="'; ?><?php echo $this->_tpl_vars['chenyao']['extralist']; ?><?php echo '">'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['chenyao']['extralist'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 100) : smarty_modifier_truncate($_tmp, 100)); ?><?php echo '</td><td class="isAgree">'; ?><?php echo $this->_tpl_vars['chenyao']['isagreeCN']; ?><?php echo '&nbsp;&nbsp;&nbsp;'; ?><?php if ($this->_tpl_vars['chenyao']['isLeave'] == 0): ?><?php echo '<span id="leave'; ?><?php echo $this->_tpl_vars['chenyao']['bookid']; ?><?php echo '">请假</span>'; ?><?php else: ?><?php echo '已请假'; ?><?php endif; ?><?php echo '</td></tr>'; ?><?php endforeach; endif; unset($_from); ?><?php echo ''; ?><?php else: ?><?php echo '<tr><td colspan="7">Sorry啦,你还没有收到在'; ?><?php echo $this->_tpl_vars['day']; ?><?php echo '日的会议邀请呢。您可以<a href="index.php?module=meeting&action=edit">预订会议室</a>，也可以<a href="">浏览会议室使用日历</a></td></tr>'; ?><?php endif; ?><?php echo ''; ?>

			</table>
		</div>
	</div>
	<div>
		<a href="index.php?module=help&action=rule"><?php echo $this->_tpl_vars['ruleTitle']; ?>
</a><br/>
	</div>

	<div id="topcover" ></div>
	<script type="text/javascript"src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
	<div class="hidden" id="sc_loginreg" style=" left: 506.5px; top: 187.5px; z-index: 99999;">
		<ul id="sc_lr_tab">
			<li><a href="#sc_reg" class="curtab">请假</a></li>
		</ul>
		<div style="display: block;" class="sc_lr_content hidden" id="sc_reg">
			<div style="display:none" id="error_reg" class="err_tips_all"></div>
			<form onsubmit="return false" id="leave" name="leave" method="POST" >
				<input id="leaveId" type="hidden" value="" name="leaveId">
				<div style="margin-bottom: 15px;">
					<p>原因:
						<input type="text" id="leaveReason" name="leaveReason" class="" required>
					</p>
				</div>
				<p class="fix">
					<input type="button" id="toClose" value="取消" >
					<input type="submit" id="regBtn" value="提交">
				</p>
			</form>
		</div>
	</div>
<style type="text/css">
	.hidden {
	    display: none;
	}
	.show {
	    display: block;
	}
	#sc_loginreg {
	    background: none repeat scroll 0 0 #FFFFFF;
	    border-radius: 2px;
	    box-shadow: 0 0 6px #666666;
	    position: fixed;
	    width: 410px;
	}
	.topcover{
	    background: none repeat scroll 0 0 #666666;
	    display: block;
	    height: 879px;
	    left: 0;
	    opacity: 0.5;
	    position: absolute;
	    top: 0;
	    width: 1423px;
	    z-index: 99998;
	}

</style>


<script type="text/javascript">
(function($) {

	$(function(){
		$('#toClose').click(function(){
			$('#sc_loginreg').attr('class','hidden');
			$('#topcover').attr('class','');
		});
	});
	
	$(function(){
		var a =new Array(<?php echo $this->_tpl_vars['ids']; ?>
);
		$.each(a,function(n,value) {
			$('#leave'+value).click(function(){
				// console.log(value);
				$('#sc_loginreg').attr('class','show');
				$('#topcover').attr('class','topcover');
				$('#leaveId').attr('value',value);
			});
		});
	});

	$("#leave").validate({
			messages: {
				leaveReason: '请输入请假原因！'
			},
			submitHandler: function( form ) {
				var url='<?php echo $this->_tpl_vars['root_url']; ?>
'+'<?php echo $this->_tpl_vars['RequestUrl']; ?>
';
				leaveCard(url);
				return false;
			}
		});
	function leaveCard(url){
		var leaveId = $('#leaveId').val();
		var leaveReason = $('#leaveReason').val();
		$.ajax({
			cache:"false",
			type:'POST',
			url:url,
			data:'bookid='+leaveId+'&leaveReason='+leaveReason,
			dataType:'json',
			success:function(data){
				if(data.error_status == 0){
					window.location.href = data.forward;
					return true;
				}else{
					alert(data.msg);
					return false;
				}
			}
		});
		return false;
	}

	$(function(){
		var a =new Array(<?php echo $this->_tpl_vars['ids']; ?>
);
		$.each(a,function(n,value) {
			$('#debook'+value).click(function(){
				if(confirm('确认退订吗？')){
					var _bookId = $('#debook'+value).attr('val');
					$.ajax({
						cache:"false",
						type:'POST',
						url:'<?php echo $this->_tpl_vars['root_url']; ?>
'+'<?php echo $this->_tpl_vars['RequestUrl']; ?>
',
						data:'bookid='+_bookId,
						dataType:'json',
						success:function(data){
							if(data.error_status == 0){
								window.location.href = data.forward;
								return true;
							}else{
								alert(data.msg);
							}
						}
					});
				}
			});
		});
	});	

})(jQuery);

</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
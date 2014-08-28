<?php /* Smarty version 2.6.18, created on 2014-05-19 11:06:47
         compiled from index.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'index.htm', 35, false),)), $this); ?>
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
		<h2><?php echo $this->_tpl_vars['day']; ?>
日会议室安排</h2>
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
				<?php echo ''; ?><?php if ($this->_tpl_vars['dayBookInfo']): ?><?php echo ''; ?><?php $_from = $this->_tpl_vars['dayBookInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['chenyao']):
?><?php echo '<tr><td>'; ?><?php echo $this->_tpl_vars['chenyao']['meetingaddress']; ?><?php echo '</td><td>'; ?><?php echo $this->_tpl_vars['chenyao']['meetingstarttime']; ?><?php echo '-'; ?><?php echo $this->_tpl_vars['chenyao']['meetingendtime']; ?><?php echo '</td><td>'; ?><?php echo $this->_tpl_vars['chenyao']['bookuser']; ?><?php echo '</td><td>'; ?><?php if (( $this->_tpl_vars['memberIsadmin'] || $this->_tpl_vars['memberName'] == $this->_tpl_vars['chenyao']['bookuser'] )): ?><?php echo '<a href="index.php?module=meeting&action=edit&bookid='; ?><?php echo $this->_tpl_vars['chenyao']['bookid']; ?><?php echo '" title="编辑此预订信息">'; ?><?php echo $this->_tpl_vars['chenyao']['meetingname']; ?><?php echo '</a>'; ?><?php else: ?><?php echo ''; ?><?php echo $this->_tpl_vars['chenyao']['meetingname']; ?><?php echo ''; ?><?php endif; ?><?php echo '</td><td title="'; ?><?php echo $this->_tpl_vars['chenyao']['meetingintro']; ?><?php echo '">'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['chenyao']['meetingintro'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 100) : smarty_modifier_truncate($_tmp, 100)); ?><?php echo '</td><td title="'; ?><?php echo $this->_tpl_vars['chenyao']['invitee']; ?><?php echo '">('; ?><?php echo $this->_tpl_vars['chenyao']['inviteenum']; ?><?php echo '人)'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['chenyao']['invitee'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 40) : smarty_modifier_truncate($_tmp, 40)); ?><?php echo '</td><td title="'; ?><?php echo $this->_tpl_vars['chenyao']['extralist']; ?><?php echo '">'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['chenyao']['extralist'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 100) : smarty_modifier_truncate($_tmp, 100)); ?><?php echo '</td><td class="isAgree">'; ?><?php if ($this->_tpl_vars['memberIsadmin']): ?><?php echo '(目前为'; ?><?php echo $this->_tpl_vars['chenyao']['isagreeCN']; ?><?php echo ')<span id=\'agree'; ?><?php echo $this->_tpl_vars['chenyao']['bookid']; ?><?php echo '\' val=\''; ?><?php echo $this->_tpl_vars['chenyao']['bookid']; ?><?php echo '\' >通过</span>/<span id=\'disagree'; ?><?php echo $this->_tpl_vars['chenyao']['bookid']; ?><?php echo '\' val=\''; ?><?php echo $this->_tpl_vars['chenyao']['bookid']; ?><?php echo '\' >不通过</span>'; ?><?php else: ?><?php echo ''; ?><?php echo $this->_tpl_vars['chenyao']['isagreeCN']; ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['memberName'] == $this->_tpl_vars['chenyao']['bookuser'] && ! $this->_tpl_vars['chenyao']['meetingdebook']): ?><?php echo '<span id="debook'; ?><?php echo $this->_tpl_vars['chenyao']['bookid']; ?><?php echo '" val=\''; ?><?php echo $this->_tpl_vars['chenyao']['bookid']; ?><?php echo '\'>&nbsp;&nbsp;退订</span>'; ?><?php elseif ($this->_tpl_vars['chenyao']['meetingdebook'] == 1): ?><?php echo '&nbsp;&nbsp;已退订'; ?><?php endif; ?><?php echo '</td></tr>'; ?><?php endforeach; endif; unset($_from); ?><?php echo ''; ?><?php else: ?><?php echo '<tr><td colspan="8">Sorry啦,今天还没有同学预订会议室呢。您可以<a href="index.php?module=meeting&action=edit">预订会议室</a>，也可以<a href="">浏览会议室使用日历</a></td></tr>'; ?><?php endif; ?><?php echo ''; ?>

			</table>
		</div>
	</div>
	<div>
		<a href="index.php?module=help&action=rule"><?php echo $this->_tpl_vars['ruleTitle']; ?>
</a><br/>
	</div>

<script type="text/javascript">
(function($) {	
	//$( window ).load(function(){
	$(function(){
		//init();
		$('#cmd').keydown(function( event ) {
			if(event.keyCode === 13){
				send();
				return false;
			}
		});
	});
	
	$(function(){
		//$('#infowindow').hide();
		var a =new Array(<?php echo $this->_tpl_vars['ids']; ?>
);
		$.each(a,function(n,value) {
			$('#agree'+value).click(function(){
				var _isAgree = 1,
					_bookId = $('#agree'+value).attr('val');
				$.ajax({
					cache:"false",
					type:'POST',
					url:'<?php echo $this->_tpl_vars['root_url']; ?>
'+'<?php echo $this->_tpl_vars['RequestUrl']; ?>
',
					data:'isagree='+_isAgree+'&bookid='+_bookId,
					dataType:'json',
					success:function(data){
						//console.log(data.error_status)
						if(data.error_status == 10){
							window.location.href = data.forward;
							return true;						
						}else{
							alert(data.msg);
						}
					}
				});
			});
		});
	});
	$(function(){
		var a =new Array(<?php echo $this->_tpl_vars['ids']; ?>
);
		$.each(a,function(n,value) {
			$('#disagree'+value).click(function(){
				var _isAgree = 2,
					_bookId = $('#disagree'+value).attr('val');
				$.ajax({
					cache:"false",
					type:'POST',
					url:'<?php echo $this->_tpl_vars['root_url']; ?>
'+'<?php echo $this->_tpl_vars['RequestUrl']; ?>
',
					data:'isagree='+_isAgree+'&bookid='+_bookId,
					dataType:'json',
					success:function(data){
						if(data.error_status == 10){
							window.location.href = data.forward;
							return true;						
						}else{
							alert(data.msg);
						}
					}
				});
			});
		});
	});
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
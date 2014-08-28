<?php /* Smarty version 2.6.18, created on 2014-05-19 16:35:00
         compiled from meetingEdit.htm */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['css_path']; ?>
common.css"/>
<script src="<?php echo $this->_tpl_vars['js_path']; ?>
calendar.js"></script>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['css_path']; ?>
layout.css" type="text/css">
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['css_path']; ?>
edit.css" type="text/css">
<script src="<?php echo $this->_tpl_vars['js_path']; ?>
ckeditor/ckeditor.js"></script>
 <script type="text/javascript">
	function logoutWeb(){
		 top.location.href=root_url+'index/logout.html';
	}
</script>

<div class="grid_10 home_box" id="content_box">       
	<div class="box">
		<h2><?php if ($this->_tpl_vars['isEdit']): ?>会议室预订信息修改<?php else: ?>会议室预订<?php endif; ?></h2>
		<div class="block" >
			<form action="" method="post">
				<table class="edit">
					<tr>
						<th>会议名称：<span class="required">*</span></th><td  colspan="9"><input  name="meetingname" size="55" type="text" value="<?php echo $this->_tpl_vars['bookInfo']['meetingname']; ?>
" required="required"/></td>
					</tr>
					<tr>
						<th>会议室：<span class="required">*</span></th>
						<td><select required name="meetingaddress"><option value="">选择会议室：</option><?php $_from = $this->_tpl_vars['meetingAddressInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['chenyao']):
?><?php if ($this->_tpl_vars['chenyao']['isenabled']): ?><option value="<?php echo $this->_tpl_vars['chenyao']['meetingaddress']; ?>
" <?php $_from = $this->_tpl_vars['bookInfo']['meetingaddress']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cy']):
?><?php if ($this->_tpl_vars['chenyao']['meetingaddress'] == $this->_tpl_vars['cy']): ?> selected <?php endif; ?><?php endforeach; endif; unset($_from); ?>> <?php echo $this->_tpl_vars['chenyao']['meetingaddress']; ?>
</option><?php endif; ?><?php endforeach; endif; unset($_from); ?></select> <span id="showDetails" style="margin-left:15px;cursor:pointer" onclick="document.getElementById('meetingAddIntro').style.display='inline';document.getElementById('hiddenDetails').style.display='inline';this.style.display='none'">打开详细?</span><span id="hiddenDetails" style="margin-left:15px;cursor:pointer;display:none" onclick="document.getElementById('meetingAddIntro').style.display='none';document.getElementById('showDetails').style.display='inline';this.style.display='none'">关闭详细</span>
							<table id=meetingAddIntro style="display:none">
								<tr><th>名称</th><th>最大容纳</th><th>投影PPT</th><th>白板</th></tr>
								<?php $_from = $this->_tpl_vars['meetingAddressInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['m']):
?>
								<?php if ($this->_tpl_vars['m']['isenabled']): ?>
								<tr><td><?php echo $this->_tpl_vars['m']['meetingaddress']; ?>
</td><td><?php echo $this->_tpl_vars['m']['galleryful']; ?>
</td><td><?php echo $this->_tpl_vars['m']['haveppt']; ?>
</td><td><?php echo $this->_tpl_vars['m']['haveblackbord']; ?>
</td></tr><?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</table>
						</td>
						
						<!-- <td><?php $_from = $this->_tpl_vars['meetingAddressInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['chenyao']):
?>
							<input  type="checkbox" name="meetingaddress[]" value="<?php echo $this->_tpl_vars['chenyao']['meetingaddress']; ?>
" 
								<?php $_from = $this->_tpl_vars['bookInfo']['meetingaddress']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cy']):
?>
									<?php if ($this->_tpl_vars['chenyao']['meetingaddress'] == $this->_tpl_vars['cy']): ?>checked="checked"<?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>><?php echo $this->_tpl_vars['chenyao']['meetingaddress']; ?>

							<?php endforeach; endif; unset($_from); ?>
						</td> -->
					</tr>
					<tr>
						<th>会议开始时间：<span class="required">*</span></th><td><input required type="text" onclick="showcalendar(event, this)" value="<?php if ($this->_tpl_vars['bookInfo']['meetingstarttimeYMD']): ?><?php echo $this->_tpl_vars['bookInfo']['meetingstarttimeYMD']; ?>
<?php else: ?><?php echo $this->_tpl_vars['tomorrowYMD']; ?>
<?php endif; ?>" size="44" name="StartTime">&nbsp;&nbsp;&nbsp;<input required type="text" style="width:30px;" value="<?php echo $this->_tpl_vars['bookInfo']['meetingstarttimeH']; ?>
" name="StartTime_H">:<input required type="text" style="width:30px;" value="<?php echo $this->_tpl_vars['bookInfo']['meetingstarttimeI']; ?>
" name="StartTime_I">:00<span style="margin-left:10px">会议预订需要提前一天，当天会议时间范围为<?php echo $this->_tpl_vars['meetingConfig']['startbooktime']; ?>
-<?php echo $this->_tpl_vars['meetingConfig']['endbooktime']; ?>
,时间使用24小时制</span></td>
					</tr>
					<tr>
						<th>会议结束时间：<span class="required">*</span></th><td><input required type="text" onclick="showcalendar(event, this)" value="<?php if ($this->_tpl_vars['bookInfo']['meetingendtimeYMD']): ?><?php echo $this->_tpl_vars['bookInfo']['meetingendtimeYMD']; ?>
<?php else: ?><?php echo $this->_tpl_vars['tomorrowYMD']; ?>
<?php endif; ?>" size="44" name="endTime">&nbsp;&nbsp;&nbsp;<input required type="text" style="width:30px;" value="<?php echo $this->_tpl_vars['bookInfo']['meetingendtimeH']; ?>
" name="endTime_H">:<input required type="text" style="width:30px;" value="<?php echo $this->_tpl_vars['bookInfo']['meetingendtimeI']; ?>
" name="endTime_I">:00</td>
					</tr>
					<tr>
						<th>会议简介：<span class="required">*</span></th><td  colspan="9"><textarea class="ckeditor" required="required" minlength="20" name="meetingintro" style="width: 400px;height: 100px;"><?php echo $this->_tpl_vars['bookInfo']['meetingintro']; ?>
</textarea></td>
					</tr>
					<tr>
						<th>需要行政协助：</th><td  colspan="9"><textarea class="" minlength="20" name="extralist" style="width: 99%;height: 100px;"><?php echo $this->_tpl_vars['bookInfo']['extralist']; ?>
</textarea></td>
					</tr>
					<tr>
						<th>邀请参加会议的同学：</th>
						<td><span id="show" style="cursor:pointer">邀请小伙伴，并给他们发送邮件？</span><span id="hidden" style="cursor:pointer;display:inline">关闭列表</span><br/>
							<div id="userList" style="display:inline"><span id="selectAll">全选</span><br/><?php echo ''; ?><?php $_from = $this->_tpl_vars['allSysUser']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['chenyao']):
?><?php echo ''; ?><?php echo $this->_tpl_vars['key']; ?><?php echo ':<br/>'; ?><?php $_from = $this->_tpl_vars['chenyao']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ke'] => $this->_tpl_vars['chenya']):
?><?php echo ''; ?><?php echo $this->_tpl_vars['ke']; ?><?php echo '<br/>'; ?><?php $_from = $this->_tpl_vars['chenya']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['chen']):
?><?php echo ''; ?><?php if ($this->_tpl_vars['chen']['username'] != 'admin'): ?><?php echo '<input id="invi'; ?><?php echo $this->_tpl_vars['chen']['userid']; ?><?php echo '" type="checkbox" name="invitee[]" value="'; ?><?php echo $this->_tpl_vars['chen']['userid']; ?><?php echo '"'; ?><?php $_from = $this->_tpl_vars['bookInfo']['invitee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cy']):
?><?php echo ''; ?><?php if ($this->_tpl_vars['chen']['userid'] == $this->_tpl_vars['cy']): ?><?php echo ' checked '; ?><?php endif; ?><?php echo ''; ?><?php endforeach; endif; unset($_from); ?><?php echo '> <label id="label'; ?><?php echo $this->_tpl_vars['chen']['userid']; ?><?php echo '" class="'; ?><?php $_from = $this->_tpl_vars['bookInfo']['invitee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cy']):
?><?php echo ''; ?><?php if ($this->_tpl_vars['chen']['userid'] == $this->_tpl_vars['cy']): ?><?php echo 'bright'; ?><?php endif; ?><?php echo ''; ?><?php endforeach; endif; unset($_from); ?><?php echo '" for="invi'; ?><?php echo $this->_tpl_vars['chen']['userid']; ?><?php echo '" title="'; ?><?php echo $this->_tpl_vars['chen']['email']; ?><?php echo '">'; ?><?php echo $this->_tpl_vars['chen']['username']; ?><?php echo '</label>'; ?><?php endif; ?><?php echo ''; ?><?php endforeach; endif; unset($_from); ?><?php echo '<br/>'; ?><?php endforeach; endif; unset($_from); ?><?php echo ''; ?><?php endforeach; endif; unset($_from); ?><?php echo ''; ?>
</div>
						</td>
					</tr>
					<tr><th></th>
						<td style="padding:5px 0;">
							<button type="reset">重置</button>
							<button class="submitbtn" type="button" id="checkInvitee">提交</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
<script type="text/javascript">
(function($) {
	$('#show').click(function(){
		if(confirm('勾选邀请参加会议的同学，并在会议预订成功后发送会议预订信息到所选小伙伴的邮箱？')){
			$('#userList').css('display','inline');
			$('#hidden').css('display','inline');
			$('#show').css('display','none');
		}
	});
	$('#hidden').click(function(){		
		$('#userList').css('display','none');
		$('#hidden').css('display','none');
		$('#show').css('display','inline');
	});
	//全选
	$('#selectAll').click(function(){		
		$("input:checkbox").attr("checked",'true');
		$("label").attr("class",'bright');
	});
	//点选
	$(document).ready(function(){
		$("input:checkbox").each(function(){
			var _userId=$(this).attr('value');
			$(this).click(function(){
				// alert($(this).attr('checked'));
				$("#label"+_userId).toggleClass('bright');
			});
		});
	});

	$('#checkInvitee').click(function(){
        if ($("input:checked").length > 0) {
            return true;
        } else {
            alert("至少需要选择一个小伙伴参与会议哦！");
            return false;
        }
	});

})(jQuery);

</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
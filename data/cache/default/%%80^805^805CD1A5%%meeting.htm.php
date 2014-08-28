<?php /* Smarty version 2.6.18, created on 2014-05-16 13:42:10
         compiled from meeting.htm */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['css_path']; ?>
common.css"/>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['css_path']; ?>
layout.css" type="text/css">

<div class="grid_10 home_box" id="content_box">
<form name="meeting" action="" method="post" id="meetForm">
	<div class="box">
		<h2>会议室信息</h2>
			<div class="block" >
				<table>
					<tr>
						<th>会议室名称</th>	
						<th>容量</th>
						<th>是否有投影</th>
						<th>是否有白板</th>
						<th>是否禁用</th>
						<th>删除</th>
						<th>编辑</th>
						<th>&nbsp</th>
					</tr>
					<?php $_from = $this->_tpl_vars['meetingInformation']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
					<tr>
						<td><input type="text" id="meetingName<?php echo $this->_tpl_vars['val']['meetingaddressid']; ?>
" value="<?php echo $this->_tpl_vars['val']['meetingaddress']; ?>
"  disabled = "true"></td>
						<td><input type="text" id="numbers<?php echo $this->_tpl_vars['val']['meetingaddressid']; ?>
" value="<?php echo $this->_tpl_vars['val']['galleryful']; ?>
"  disabled = "true"></td>
						<td>
							<select  disabled = "true" id="ppt_2<?php echo $this->_tpl_vars['val']['meetingaddressid']; ?>
">
								<option value="1" <?php if ($this->_tpl_vars['val']['haveppt'] == 1): ?> selected="selected" <?php endif; ?>>有</option>
								<option value="0" <?php if ($this->_tpl_vars['val']['haveppt'] == 0): ?> selected="selected" <?php endif; ?>>无</option>
							</select>
						</td>
						<td>
							<select  disabled = "true" id="blackbord_1<?php echo $this->_tpl_vars['val']['meetingaddressid']; ?>
">
								<option value="1" <?php if ($this->_tpl_vars['val']['haveblackbord'] == 1): ?> selected="selected" <?php endif; ?>>有</option>
								<option value="0" <?php if ($this->_tpl_vars['val']['haveblackbord'] == 0): ?> selected="selected" <?php endif; ?>>无</option>
							</select>
						</td>
						<td>
							<select  disabled = "true" id="use<?php echo $this->_tpl_vars['val']['meetingaddressid']; ?>
">
								<option value="1" <?php if ($this->_tpl_vars['val']['isenabled'] == 1): ?> selected="selected" <?php endif; ?>>可用</option>
								<option value="0" <?php if ($this->_tpl_vars['val']['isenabled'] == 0): ?> selected="selected" <?php endif; ?>>禁用</option>
							</select>
						</td>
						<td><a style="cursor:pointer;" name="meetId" id="d<?php echo $this->_tpl_vars['val']['meetingaddressid']; ?>
" onclick="delet(<?php echo $this->_tpl_vars['val']['meetingaddressid']; ?>
)">删除</a></td>
						<td><a style="cursor:pointer;" id="e<?php echo $this->_tpl_vars['val']['meetingaddressid']; ?>
" onclick="editM(<?php echo $this->_tpl_vars['val']['meetingaddressid']; ?>
)">编辑</a></td>
						<td><a style="cursor:pointer;display:none;" id="s<?php echo $this->_tpl_vars['val']['meetingaddressid']; ?>
" onclick="edit(<?php echo $this->_tpl_vars['val']['meetingaddressid']; ?>
)">确认修改</a></td>
					</tr>
					<?php endforeach; endif; unset($_from); ?>
				</table>
			</div>
	</div>
	<div class="box">
		<h2>新增会议室</h2>
			<div class="block" >
				<table>
					<tr>
						<th>会议室名称</th>	
						<th>容量</th>
						<th>是否有投影</th>
						<th>是否有白板</th>
						<th>是否禁用</th>
						<th>确认</th>
					</tr>
					<tr>
						<td><input type="text" name="meetName" id="newName"></td>
						<td><input type="text" name="number" id="number_1"></td>
						<td>
							<select name="ppt" id="ppt_1">
								<option value="1">有</option>
								<option value="0">无</option>
							</select>
						</td>
						<td>
							<select name="blackbox" id="blackbox_1">
								<option value="1">有</option>
								<option value="0">无</option>
							</select>
						</td>
						<td>
							<select name="able" id="able_1">
								<option value="1">可用</option>
								<option value="0">禁用</option>
							</select>
						</td>
						<td><input type="button" name="meet" id="sub" value="提交"></td>
					</tr>
				</table>
			</div>
	</div>
</form>
<script type="text/javascript">
	$(function($){
		$('#sub').click(function(){
			$a = confirm('确认添加?');
			if($a == true){
				var meetName = $('#newName').val();
				var number = $('#number_1').val();
				var ppt = $('#ppt_1').val();
				var blackbox = $('#blackbox_1').val();
				var able = $('#able_1').val();
				if(meetName == ''){
					alert('请输入会议室名称！');
					$('#newName').focus();
				}else if(number == ''){
					alert('请输入会议室容量！');
					$('#number_1').focus();
				}else{
				$.ajax({
					   type: "POST",
					   url: "<?php echo @ROOT_URL; ?>
index.php?module=meeting&action=index",
					   data: "meet=meetingaddress="+meetName+"/galleryful="+number+"/haveppt="+ppt+"/haveblackbord="+blackbox+"/isenabled="+able,
					   success: function(data){
					    	if(data == '1'){
					    		window.location.reload();
					    	}
					   }
					});
				}
			}
		});
		
	});
	//删除
	function delet(Id){
		if(Id){
			if(confirm('确认删除？')){
// 				alert(Id);
				var deletMeet = document.getElementById("d"+Id);
				deletMeet.href = "<?php echo @ROOT_URL; ?>
index.php?module=meeting&action=index&id="+Id;
				window.location.reload();
			}
		}
	}
	//修改
	function editM(Id){
		document.getElementById("s"+Id).style.display = 'block';
		document.getElementById("e"+Id).style.display = 'none';
		var mName = document.getElementById('meetingName'+Id);
		var nNumber = document.getElementById('numbers'+Id);
		var mPpt = document.getElementById('ppt_2'+Id);
		var mBlack = document.getElementById('blackbord_1'+Id);
		var mUse = document.getElementById('use'+Id);

		mName.disabled = false;
		nNumber.disabled = false;
		mPpt.disabled = false;
		mBlack.disabled = false;
		mUse.disabled = false;
	}
	function edit(Id){
		var mName = document.getElementById('meetingName'+Id);
		var nNumber = document.getElementById('numbers'+Id);
		var mPpt = document.getElementById('ppt_2'+Id);
		var mBlack = document.getElementById('blackbord_1'+Id);
		var mUse = document.getElementById('use'+Id);
		var editMeet = document.getElementById("s"+Id);
		
		mName = mName.value;
		nNumber = nNumber.value;
		mPpt = mPpt.value;
		mBlack = mBlack.value;
		mUse = mUse.value;
		if(confirm('确认修改？')){
			editMeet.href = "<?php echo @ROOT_URL; ?>
index.php?module=meeting&action=index&mId="+Id+"&mName="+mName+"&nNumber="+nNumber+"&mPpt="+mPpt+"&mBlack="+mBlack+"&mUse="+mUse;
		}
	}
</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
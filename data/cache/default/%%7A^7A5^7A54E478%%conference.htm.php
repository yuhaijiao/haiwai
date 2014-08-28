<?php /* Smarty version 2.6.18, created on 2014-05-26 10:42:37
         compiled from conference.htm */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['css_path']; ?>
common.css"/>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['css_path']; ?>
layout.css" type="text/css">
<script src="<?php echo $this->_tpl_vars['js_path']; ?>
ckeditor/ckeditor.js"></script>
<div class="grid_10 home_box" id="content_box">
	<div class="box">
		<h2>会议签到及会议记录</h2>
			<div class="block" >
				<table>
					<tr>
						<th colspan="12"><?php echo $this->_tpl_vars['information']['meetingname']; ?>
</th>
					</tr>
					<tr>
						<td colspan="4"><b>地点：</b><?php echo $this->_tpl_vars['information']['meetingaddress']; ?>
</td>
						<td colspan="4"><b>时间：</b><?php echo $this->_tpl_vars['meetTime']; ?>
(<?php echo $this->_tpl_vars['startTime']; ?>
—<?php echo $this->_tpl_vars['endTime']; ?>
)</td>
						<td colspan="4"><b>发起者：</b><?php echo $this->_tpl_vars['information']['bookuser']; ?>
</td>
					</tr>
					<tr>
						<th colspan="6" style="width:50%;">人员统计</th>
						<td colspan="6" style="width:50%;"><b>应到：</b><?php echo $this->_tpl_vars['personNum']; ?>
　　　<b>实到：</b><?php echo $this->_tpl_vars['ontimeNumber']; ?>
　　　<b>请假：</b><?php echo $this->_tpl_vars['leave']; ?>
　　　<b>迟到：</b><?php echo $this->_tpl_vars['lateNumber']; ?>
　　　<b>缺席：<?php echo $this->_tpl_vars['absent']; ?>
</b></td>
					</tr>
					<tr>
						<th colspan="6">人员签到(默认迟到，请在会议开始之前在准时选项框内签到!!)</th>
						<td colspan="6">离会议开始还有：<span id="timeDifference_1"></span></td>
					</tr>
					<tr>
						<th>姓名</th>
						<th>状态</th>
						<th>准时</th>
						<th>迟到</th>
						<th>缺席</th>
						<th>工牌</th>
						<th>姓名</th>
						<th>状态</th>
						<th>准时</th>
						<th>迟到</th>
						<th>缺席</th>
						<th>工牌</th>
					</tr>
					<form id="allpersoninfor" name="personinfor" method="POST" action="">
					<?php $_from = $this->_tpl_vars['personRight']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['val']):
?>
						<tr style="">
							<td style="color:<?php echo $this->_tpl_vars['val']['color']; ?>
;"><?php echo $this->_tpl_vars['val']['username']; ?>
</td>
							<td style="color:<?php echo $this->_tpl_vars['val']['color']; ?>
;"><?php echo $this->_tpl_vars['val']['state']; ?>
</td>
							<td>
								<input name="ontimeState" type="checkbox" <?php if ($this->_tpl_vars['val']['isagreeattend'] == 0): ?>disabled = "true"<?php endif; ?> id="ontime_<?php echo $this->_tpl_vars['val']['userid']; ?>
" onclick="signIn('ontime_<?php echo $this->_tpl_vars['val']['userid']; ?>
',<?php echo $this->_tpl_vars['val']['userid']; ?>
,'ontime')"/>
							</td>
							<td>
								<input name="<?php echo $this->_tpl_vars['val']['statename']; ?>
" type="checkbox" <?php if ($this->_tpl_vars['val']['isagreeattend'] == 0): ?>disabled = "true"<?php endif; ?> id="late_<?php echo $this->_tpl_vars['val']['userid']; ?>
" onclick="signIn('late_<?php echo $this->_tpl_vars['val']['userid']; ?>
',<?php echo $this->_tpl_vars['val']['userid']; ?>
,'late')"/>
							</td>
							<td>
								<input name="<?php echo $this->_tpl_vars['val']['statename']; ?>
" type="checkbox" <?php if ($this->_tpl_vars['val']['isattend'] == 0): ?>checked = 'true'<?php endif; ?> <?php if ($this->_tpl_vars['val']['isagreeattend'] == 0): ?>disabled = "true"<?php endif; ?> id="a<?php echo $this->_tpl_vars['val']['userid']; ?>
" onclick = "attend('a<?php echo $this->_tpl_vars['val']['userid']; ?>
')"/>
							</td>
							<td>
								<input name="meetCard" type="checkbox" id="c<?php echo $this->_tpl_vars['val']['userid']; ?>
" <?php if ($this->_tpl_vars['val']['wearcard'] == 1): ?>checked = 'true'<?php endif; ?> <?php if ($this->_tpl_vars['val']['isagreeattend'] == 0): ?>disabled = "true"<?php endif; ?> onclick = "iscard('c<?php echo $this->_tpl_vars['val']['userid']; ?>
')"/>
							</td>
							<td style="color:<?php echo $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['color']; ?>
;"><?php echo $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['username']; ?>
</td>
							<td style="color:<?php echo $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['color']; ?>
;"><?php echo $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['state']; ?>
</td>
							<td>
								<input name="ontimeState" type="checkbox" <?php if ($this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['isagreeattend'] == 0 || $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['isagreeattend'] == null): ?>disabled = "true"<?php endif; ?> id="ontime_<?php echo $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['userid']; ?>
" onclick="signIn('ontime_<?php echo $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['userid']; ?>
',<?php echo $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['userid']; ?>
,'ontime')"/>
							</td>
							<td>
								<input name="<?php echo $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['statename']; ?>
" type="checkbox" <?php if ($this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['isagreeattend'] == 0 || $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['isagreeattend'] == null): ?>disabled = "true"<?php endif; ?> id="late_<?php echo $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['userid']; ?>
" onclick="signIn('late_<?php echo $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['userid']; ?>
',<?php echo $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['userid']; ?>
,'late')"/>
							</td>
							<td>
								<input name="<?php echo $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['statename']; ?>
" type="checkbox" <?php if ($this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['isattend'] == 0): ?>checked = 'true'<?php endif; ?> <?php if ($this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['isagreeattend'] == 0 || $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['isagreeattend'] == null): ?>disabled = "true"<?php endif; ?> id="a<?php echo $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['userid']; ?>
" onclick = "attend('a<?php echo $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['userid']; ?>
')"/>
							</td>
							<td>
								<input name="meetCard" type="checkbox" id="c<?php echo $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['userid']; ?>
" <?php if ($this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['wearcard'] == 1): ?>checked = 'true'<?php endif; ?> <?php if ($this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['isagreeattend'] == 0 || $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['isagreeattend'] == null): ?>disabled = "true"<?php endif; ?> onclick = "iscard('c<?php echo $this->_tpl_vars['personLeft'][$this->_tpl_vars['k']]['userid']; ?>
')"/>
							</td>
						</tr>
					<?php endforeach; endif; unset($_from); ?>
						<input type="hidden" name="signInformation" id="signInformations" value=""/>
						<input type="hidden" name="signCard" id="signCard_1" value=""/>
						<input type="hidden" name="signAttend" id="signAttend_1" value=""/>
						<tr>
							<td colspan="12">
								<input name="allontime_1" type="button" value="全选准时" id="allontime" onclick="allSelected()"/>
								<input name="submitInformation_1" type="button" value="提交签到" id="submitInformation"/>
							</td>
						</tr>
					</form>
						<tr><td colspan="12"></td></tr>
						<tr>
							<th colspan="12">会议记录</th>
						</tr>
						<tr>
							<td colspan="12">
								<form name="ckmeet"  method="post" action="" id="meetCkeditor">
									<textarea class="ckeditor" name="meetRecord_1" id="meetRecord"><?php echo $this->_tpl_vars['information']['meetingsummary']; ?>
</textarea>
									<input id="subMeetRecord" name="subMeetRecordButton" type="button" value="提交会议记录" onclick="sub()"/>
								</form>
							</td>
						</tr>
				</table>
			</div>			
	</div>
	<script type="text/javascript">
		function signIn(classid,id,state){
			if(state == 'ontime'){//1代表准时，0代表迟到
				var lateState = document.getElementById('late_'+id);
				var onTimeState = document.getElementById('ontime_'+id);
				var submitInformations = document.getElementById('signInformations').value;
				var re =new RegExp("/"+id + "_1","g");
				var re_1 =new RegExp("/"+id + "_0","g");
				if(lateState.checked == true){
					if(re_1.test(submitInformations)){
						submitInformations_1 = submitInformations.replace(re_1,"");
						document.getElementById('signInformations').value = submitInformations_1;
					}
				}
				if(re.test(submitInformations) && onTimeState.checked == false){
					submitInformations_1 = submitInformations.replace(re,"");
					document.getElementById('signInformations').value = submitInformations_1;
				}else{
					document.getElementById('signInformations').value += '/'+id+'_1';
				}
				lateState.checked = false;
			}
			if(state == 'late'){
				var lateState = document.getElementById('late_'+id);
				var onTimeState = document.getElementById('ontime_'+id);
				var submitInformations = document.getElementById('signInformations').value;
				var re =new RegExp("/"+id + "_1","g");
				var re_1 =new RegExp("/"+id + "_0","g");
				
				if(onTimeState.checked == true){
					if(re.test(submitInformations)){
						submitInformations_1 = submitInformations.replace(re,"");
						document.getElementById('signInformations').value = submitInformations_1;
					}
				}
				if(re_1.test(submitInformations) && onTimeState.checked == false){
					submitInformations_1 = submitInformations.replace(re_1,"");
					document.getElementById('signInformations').value = submitInformations_1;
				}else{
					document.getElementById('signInformations').value += '/'+id+'_0';
				}
				onTimeState.checked = false;
			}
		}
		//工牌
		function iscard(userid){
			var card = document.getElementById(userid);
			var id = userid.substr(1);
			var cards = document.getElementById('signCard_1');
			var submitCard = cards.value;
			var re =new RegExp("/"+id + "_1","g");
			var re_1 =new RegExp("/"+id + "_0","g");
			var val = "/"+id + "_1";
			var val_1 = "/"+id + "_0";
			if(card.checked == false){
				submitCard_1 = submitCard.replace(re,"");
				cards.value = submitCard_1;
				cards.value += val_1;
			}else if(card.checked == true){
				submitCard_1 = submitCard.replace(re_1,"");
				cards.value = submitCard_1;
				cards.value += val;
			}
		}
		//缺席
		function attend(userid){
			var att = document.getElementById(userid);
			var id = userid.substr(1);
			var attends = document.getElementById('signAttend_1');
			var submitattend = attends.value;
			var re =new RegExp("/"+id + "_1","g");
			var re_1 =new RegExp("/"+id + "_0","g");
			var val = "/"+id + "_1";
			var val_1 = "/"+id + "_0";
			if(att.checked == false){
				submitattend_1 = submitattend.replace(re,"");
				attends.value = submitattend_1;
				attends.value += val_1;
			}else if(att.checked == true){
				submitattend_1 = submitattend.replace(re_1,"");
				attends.value = submitattend_1;
				attends.value += val;
			}else{
				attends.value += val;
			}
		}
		//倒计时
		function times(){
			var date = new Date();
			var nowtime = date.getTime();//当前时间
			var meetTime = <?php echo $this->_tpl_vars['start']; ?>
;
			var timeDifference = (meetTime - nowtime)/1000;
			if(timeDifference > 0){
				if(timeDifference > 86400){
					var day = Math.floor((timeDifference/86400));//天
					var surplusTime = timeDifference - (day*86400);
				}
				if(timeDifference < 86400){
					var day = 0;//天
					var surplusTime = timeDifference;
				}
				if(surplusTime > 3600){
					var hours = Math.floor((surplusTime/3600));//时
					var surplusTime1 = surplusTime - (hours*3600);
				}
				if(surplusTime < 3600){
					var hours = 0;//小时
					var surplusTime1 = surplusTime;
				}
				if(surplusTime1 > 60){
					var minute =  Math.floor((surplusTime1/60));//分
					var second =  Math.floor(surplusTime1 - (minute*60));//秒
				}
				if(surplusTime1 < 60){ 
					var minute = 0;//分
					var second = Math.floor(surplusTime1);//秒
				}
				var timeD = day+"天"+hours+"时"+minute+"分"+second+"秒";
				if(day == 0 && hours == 0 && minute == 4 && second == 59){
					alert('离会议开始还有5分钟，请确认签到信息，并在会议开始前提交准时到会人员信息！过期不候哦！');
				}
				document.getElementById('timeDifference_1').innerHTML = timeD;
				setTimeout("times()",1000);
			}else{//当会议开始后执行
				document.getElementById('timeDifference_1').innerHTML = 0+"天"+0+"时"+0+"分"+0+"秒";
				document.getElementById('allontime').disabled = true;
				var all = document.getElementsByTagName("input");
				for(var i=0;i<all.length;i++){
					var long = all[i];
					if(long.name == 'ontimeState'){
						long.disabled = true;//锁定签到准时框
						long.style.display = 'none';
					}
				}
				if(timeDifference < -43200){//关闭签到功能
					var all = document.getElementsByTagName("input");
					for(var i=0;i<all.length;i++){
						var long = all[i];
						if(long.name != 'subMeetRecordButton'){
							long.disabled = true;
							long.style.display = 'inline';
						}
					}
				}
			}
		}
		window.onload=times;
		//全选
		function allSelected(){
			var keywords = document.getElementById('allontime').value;
			var allinput = document.getElementsByTagName("input");
			if(keywords == '全选准时'){
				document.getElementById('allontime').value = '取消全选';
				for(var i=0;i<allinput.length;i++){
					var long = allinput[i];
					if(long.name == 'ontimeState'){
						var classid = long.id;
						var id = classid.substr(7);
						var state = 'ontime';
						signIn(classid,id,state);
						long.checked = true;//全选准时
					}
				}
			}
			if(keywords == '取消全选'){
				document.getElementById('allontime').value = '全选准时';
				for(var i=0;i<allinput.length;i++){
					var long = allinput[i];
					if(long.name == 'ontimeState'){
						document.getElementById('signInformations').value = '';
						long.checked = false;//取消全选准时
					}
				}
			}
		}
		
	</script>
	<script type="text/javascript">
		//提交签到信息
		$(function($){
			$('#submitInformation').click(function(){
				$a = confirm('确认提交?');
				if($a == true){
					var signInformations_1 = $('#signInformations').val();
					var signCard = $('#signCard_1').val();
					var signAttend = $('#signAttend_1').val();
					$.ajax({
						   type: "POST",
						   url: "<?php echo @ROOT_URL; ?>
index.php?module=meeting&action=conference&id=<?php echo $this->_tpl_vars['bookid']; ?>
",
						   data: "meet=signInformation="+signInformations_1+"//signcards="+signCard+"//signAttends="+signAttend,
						   success: function(data){
						    	if(data = 1){
						    		window.location.reload();
						    	}
						   }
						});
				}
			});
			
		});
		//提交会议记录
		function sub(){
			if(confirm('是否提交？')){
				document.getElementById('meetCkeditor').submit();
			}
		}
	
	</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
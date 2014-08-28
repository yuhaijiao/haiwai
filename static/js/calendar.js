/*
	[Discuz!] (C)2001-2006 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$RCSfile: calendar.js,v $
	$Revision: 1.9.2.3 $
	$Date: 2007/03/08 18:55:30 $
*/

var controlid = null;
var currdate = null;
var startdate = null;
var enddate  = null;
var yy = null;
var mm = null;
var hh = null;
var ii = null;
var currday = null;
var addtime = false;
var today = new Date();
var lastcheckedyear = false;
var lastcheckedmonth = false;

function doane(event) {
	e = event ? event : window.event ;
	if(is_ie) {
		e.returnValue = false;
		e.cancelBubble = true;
	} else {
		e.stopPropagation();
		e.preventDefault();
	}
}
function getposition(obj) {
	var r = new Array();
	r['x'] = obj.offsetLeft;
	r['y'] = obj.offsetTop;
	while(obj = obj.offsetParent) {
		r['x'] += obj.offsetLeft;
		r['y'] += obj.offsetTop;
	}
	return r;
}

function loadcalendar() {
	s = '';
	s += '<div id="calendar" style="display:none; position:absolute; z-index:9;" onclick="doane(event)">';
	s += '<div style="width: 200px;"><table class="tableborder" cellspacing="0" cellpadding="0" width="100%" style="text-align: center" bgcolor="#FFFFFF">';
	s += '<tr align="center" class="header"><td class="header"><a href="###" onclick="refreshcalendar(yy, mm-1)" title="上一月">《</a></td><td colspan="5" style="text-align: center" class="header"><a href="###" onclick="showdiv(\'year\');doane(event)" title="点击选择年份" id="year"></a>&nbsp; - &nbsp;<a id="month" title="点击选择月份" href="###" onclick="showdiv(\'month\');doane(event)"></a></td><td class="header"><A href="###" onclick="refreshcalendar(yy, mm+1)" title="下一月">》</A></td></tr>';
	s += '<tr class="category calendar_header"><td>日</td><td>一</td><td>二</td><td>三</td><td>四</td><td>五</td><td>六</td></tr>';
	for(var i = 0; i < 6; i++) {
		s += '<tr class="altbg2">';
		for(var j = 1; j <= 7; j++)
			s += "<td id=d" + (i * 7 + j) + " height=\"15\">0</td>";
		s += "</tr>";
	}
	s += '<tr id="hourminute"><td colspan="7" align="center"><input type="text" size="1" value="" id="hour" onKeyUp=\'this.value=this.value > 23 ? 23 : zerofill(this.value);controlid.value=controlid.value.replace(/\\d+(\:\\d+)/ig, this.value+"$1")\'> 点 <input type="text" size="1" value="" id="minute" onKeyUp=\'this.value=this.value > 59 ? 59 : zerofill(this.value);controlid.value=controlid.value.replace(/(\\d+\:)\\d+/ig, "$1"+this.value)\'> 分</td></tr>';
	s += '<tr class="altbg2"  height="15"><td colspan="4" align="left"><a href="###" onclick="settime(\''+today.getDate()+'\',\''+(today.getMonth()+1)+'\',\''+today.getFullYear()+'\');return false">今天</a></td><td colspan="3" align="right"><a href="###" onclick="fClearInput();return false">清空</a></td></tr>';
	s += '</table></div></div>';
	s += '<div id="calendar_year" onclick="doane(event)" style="display: none"><div class="col">';
	for(var k = 2020; k > 2010; k--) {
		s += k != 1930 && k % 10 == 0 ? '</div><div class="col">' : '';
		s += '<a href="###" onclick="refreshcalendar(' + k + ', mm);$(\'calendar_year\').style.display=\'none\'"><span' + (today.getFullYear() == k ? ' class="calendar_today"' : '') + ' id="calendar_year_' + k + '">' + k + '</span></a><br />';
	}
	s += '</div></div>';
	s += '<div id="calendar_month" onclick="doane(event)" style="display: none">';
	for(var k = 1; k <= 12; k++) {
		s += '<a href="###" onclick="refreshcalendar(yy, ' + (k - 1) + ');$(\'calendar_month\').style.display=\'none\'"><span' + (today.getMonth()+1 == k ? ' class="calendar_today"' : '') + ' id="calendar_month_' + k + '">' + k + ( k < 10 ? '&nbsp;' : '') + ' 月</span></a><br />';
	}
	s += '</div>';
	if(is_ie && is_ie < 7) {
		s += '<iframe id="calendariframe" frameborder="0" style="display:none;position:absolute;filter:progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)"></iframe>';
		s += '<iframe id="calendariframe_year" frameborder="0" style="display:none;position:absolute;filter:progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)"></iframe>';
		s += '<iframe id="calendariframe_month" frameborder="0" style="display:none;position:absolute;filter:progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)"></iframe>';
	}

	document.write(s);
	document.onclick = function(event) {
		$('calendar').style.display = 'none';
		$('calendar_year').style.display = 'none';
		$('calendar_month').style.display = 'none';
		if(is_ie && is_ie < 7) {
			$('calendariframe').style.display = 'none';
			$('calendariframe_year').style.display = 'none';
			$('calendariframe_month').style.display = 'none';
		}
	}
	$('calendar').onclick = function(event) {
		doane(event);
		$('calendar_year').style.display = 'none';
		$('calendar_month').style.display = 'none';
		if(is_ie && is_ie < 7) {
			$('calendariframe_year').style.display = 'none';
			$('calendariframe_month').style.display = 'none';
		}
	}
}

function parsedate(s) {
	/(\d+)\-(\d+)\-(\d+)\s*(\d*):?(\d*)/.exec(s);
	var m1 = (RegExp.$1 && RegExp.$1 > 1899 && RegExp.$1 < 2101) ? parseFloat(RegExp.$1) : today.getFullYear();
	var m2 = (RegExp.$2 && (RegExp.$2 > 0 && RegExp.$2 < 13)) ? parseFloat(RegExp.$2) : today.getMonth() + 1;
	var m3 = (RegExp.$3 && (RegExp.$3 > 0 && RegExp.$3 < 32)) ? parseFloat(RegExp.$3) : today.getDate();
	var m4 = (RegExp.$4 && (RegExp.$4 > -1 && RegExp.$4 < 24)) ? parseFloat(RegExp.$4) : 0;
	var m5 = (RegExp.$5 && (RegExp.$5 > -1 && RegExp.$5 < 60)) ? parseFloat(RegExp.$5) : 0;
	/(\d+)\-(\d+)\-(\d+)\s*(\d*):?(\d*)/.exec("0000-00-00 00\:00");
	return new Date(m1, m2 - 1, m3, m4, m5);
}

function settime(d,month,year) {
	var mm=month-1;
	var yy=year;
	$('calendar').style.display = 'none';
	$('calendar_month').style.display = 'none';
	if(is_ie && is_ie < 7) {
		$('calendariframe').style.display = 'none';
	}
	controlid.value = yy + "-" + zerofill(mm + 1) + "-" + zerofill(d) + (addtime ? ' ' + zerofill($('hour').value) + ':' + zerofill($('minute').value) : '');
}
function fClearInput()
{
	$('calendar').style.display = 'none';
	$('calendar_month').style.display = 'none';
	if(is_ie && is_ie < 7) {
		$('calendariframe').style.display = 'none';
	}
	controlid.value = "";  	
}

function showcalendar(event, controlid1, addtime1, startdate1, enddate1) {
	controlid = controlid1;
	addtime = addtime1;
	startdate = startdate1 ? parsedate(startdate1) : false;
	enddate = enddate1 ? parsedate(enddate1) : false;
	currday = controlid.value ? parsedate(controlid.value) : today;
	hh = currday.getHours();
	ii = currday.getMinutes();
	var p = getposition(controlid);
	$('calendar').style.display = 'block';
	$('calendar').style.left = p['x']+'px';
	$('calendar').style.top	= (p['y'] + 33)+'px';
	doane(event);
	refreshcalendar(currday.getFullYear(), currday.getMonth());
	if(lastcheckedyear != false) {
		$('calendar_year_' + lastcheckedyear).className = 'calendar_default';
		$('calendar_year_' + today.getFullYear()).className = 'calendar_today';
	}
	if(lastcheckedmonth != false) {
		$('calendar_month_' + lastcheckedmonth).className = 'calendar_default';
		$('calendar_month_' + (today.getMonth() + 1)).className = 'calendar_today';
	}
	$('calendar_year_' + currday.getFullYear()).className = 'calendar_checked';
	$('calendar_month_' + (currday.getMonth() + 1)).className = 'calendar_checked';
	$('hourminute').style.display = addtime ? '' : 'none';
	lastcheckedyear = currday.getFullYear();
	lastcheckedmonth = currday.getMonth() + 1;
	if(is_ie && is_ie < 7) {
		$('calendariframe').style.top = $('calendar').style.top;
		$('calendariframe').style.left = $('calendar').style.left;
		$('calendariframe').style.width = $('calendar').offsetWidth;
		$('calendariframe').style.height = $('calendar').offsetHeight;
		$('calendariframe').style.display = 'block';
	}
}

function refreshcalendar(y, m) {
	var x = new Date(y, m, 1);
	var mv = x.getDay();
	var d = x.getDate();
	var dd = null;
	var Last=new Date(y, m, 0).getDate()-mv;
	var exit=new Date(y, m+1, 0).getDate();	
	yy = x.getFullYear();
	mm = x.getMonth();	
	$("month").innerHTML = mm + 1 > 9  ? (mm + 1) : '0' + (mm + 1);
	$("year").innerHTML = yy;
	for(var i = 1; i <= mv; i++) {
		dd = $("d" + i);	
		month= mm  > 9  ? (mm ) : '0' + (mm);
		year=yy;
		if( month=='00') { month=12; year=yy-1; }		
		dd.innerHTML = '<a href="###" onclick="settime(' + (Last+i) + ',' + month + ',' + year + ');return false">' + (Last+i) + '</a>';
		if(x.getTime() < today.getTime() || (enddate && x.getTime() > enddate.getTime()) || (startdate && x.getTime() < startdate.getTime())) {
			dd.className = 'calendar_expire2';
		} else {
			dd.className = 'calendar_default2';
		}
		if(year == currday.getFullYear() && (month-1) == currday.getMonth() && (Last+i) == currday.getDate()) {
			dd.className = 'calendar_checked';
		}
	}
	while(x.getMonth() == mm) {
		dd = $("d" + (d + mv));
		month=mm+1;
		year= yy;		
		dd.innerHTML = '<a href="###" onclick="settime(' + d + ',' + month + ',' + year + ');return false">' + d + '</a>';
		if(x.getTime() < today.getTime() || (enddate && x.getTime() > enddate.getTime()) || (startdate && x.getTime() < startdate.getTime())) {
			dd.className = 'calendar_expire';
		} else {
			dd.className = 'calendar_default';
		}
		if(x.getFullYear() == today.getFullYear() && x.getMonth() == today.getMonth() && x.getDate() == today.getDate()) {
			dd.className = 'calendar_today';
			dd.firstChild.title = '今天';
		}
		if(x.getFullYear() == currday.getFullYear() && x.getMonth() == currday.getMonth() && x.getDate() == currday.getDate()) {
			dd.className = 'calendar_checked';
		}
		x.setDate(++d);
	}
	while(d + mv <= 42) {
		dd = $("d" + (d + mv));	
		month=mm + 2 > 9  ? (mm + 2) : '0' + (mm + 2);
		year=yy;
		if( month=='13') { month=1; year=yy+1; }
		dd.innerHTML = '<a href="###" onclick="settime(' + (d-exit) + ',' + month + ',' + year + ');return false">' + (d-exit) + '</a>';
		if(x.getTime() < today.getTime() || (enddate && x.getTime() > enddate.getTime()) || (startdate && x.getTime() < startdate.getTime())) {
			dd.className = 'calendar_expire2';
		} else {
			dd.className = 'calendar_default2';
		}
		if(year == currday.getFullYear() && (month-1) == currday.getMonth() && (d-exit) == currday.getDate()) {
			dd.className = 'calendar_checked';
		}
		d++;
	}

	if(addtime) {
		$('hour').value = zerofill(hh);
		$('minute').value = zerofill(ii);
	}
}

function showdiv(id) {
	var p = getposition($(id));
	$('calendar_' + id).style.left = p['x']+'px';
	$('calendar_' + id).style.top = (p['y'] + 16)+'px';
	$('calendar_' + id).style.display = 'block';
	if(is_ie && is_ie < 7) {
		$('calendariframe_' + id).style.top = $('calendar_' + id).style.top;
		$('calendariframe_' + id).style.left = $('calendar_' + id).style.left;
		$('calendariframe_' + id).style.width = $('calendar_' + id).offsetWidth;
		$('calendariframe_' + id ).style.height = $('calendar_' + id).offsetHeight;
		$('calendariframe_' + id).style.display = 'block';
	}
}

function zerofill(s) {
	var s = parseFloat(s.toString().replace(/(^[\s0]+)|(\s+$)/g, ''));
	s = isNaN(s) ? 0 : s;
	return (s < 10 ? '0' : '') + s.toString();
}
loadcalendar();


















var sPop = null;
var postSubmited = false;
var userAgent = navigator.userAgent.toLowerCase();
var is_webtv = userAgent.indexOf('webtv') != -1;
var is_kon = userAgent.indexOf('konqueror') != -1;
var is_mac = userAgent.indexOf('mac') != -1;
var is_saf = userAgent.indexOf('applewebkit') != -1 || navigator.vendor == 'Apple Computer, Inc.';
var is_opera = userAgent.indexOf('opera') != -1 && opera.version();
var is_moz = (navigator.product == 'Gecko' && !is_saf) && userAgent.substr(userAgent.indexOf('firefox') + 8, 3);
var is_ns = userAgent.indexOf('compatible') == -1 && userAgent.indexOf('mozilla') != -1 && !is_opera && !is_webtv && !is_saf;
var is_ie = (userAgent.indexOf('msie') != -1 && !is_opera && !is_saf && !is_webtv) && userAgent.substr(userAgent.indexOf('msie') + 5, 3);

function $(id) {
	return document.getElementById(id);
}
function getcookie(name) {//cookie读取
	var cookie_start = document.cookie.indexOf(name);
	var cookie_end = document.cookie.indexOf(";", cookie_start);
	return cookie_start == -1 ? '' : unescape(document.cookie.substring(cookie_start + name.length + 1, (cookie_end > cookie_start ? cookie_end : document.cookie.length)));
}
function setcookie(cookieName, cookieValue, seconds, path, domain, secure) {//cookie写入
	var expires = new Date();
	expires.setTime(expires.getTime() + seconds);
	document.cookie = escape(cookieName) + '=' + escape(cookieValue)
		+ (expires ? '; expires=' + expires.toGMTString() : '')
		+ (path ? '; path=' + path : '/')
		+ (domain ? '; domain=' + domain : '')
		+ (secure ? '; secure' : '');
}
function collapse_change(menucount) {
	var collapsed = getcookie('menu_cookie');
	if($('menu_' + menucount).style.display == 'none') {
		$('menu_' + menucount).style.display = '';
		$('menuimg_' + menucount).src = Image_url+'menu_reduce.gif';
		collapsed = collapsed.replace( menucount + '|' , '');	
	} else {
		$('menu_' + menucount).style.display = 'none';
		$('menuimg_' + menucount).src = Image_url+'menu_add.gif';
		collapsed +=  menucount + '|';
	}	
	setcookie('menu_cookie', collapsed, 2592000);
}
function collapsed_remarks(menucount) {	
	if($('remarks_' + menucount).style.display == 'none') {
		$('remarks_' + menucount).style.display = '';
		$('remarksimg_' + menucount).src = Image_url+'collapsed_yes.gif';
	} else {
		$('remarks_' + menucount).style.display = 'none';
		$('remarksimg_' + menucount).src = Image_url+'collapsed_no.gif';
	}	
}
function collapsed_o(menucount,o) {	
	if($('remarks_' + menucount).style.display == 'none') {
		$('remarks_' + menucount).style.display = '';
		$('remarksimg_' + menucount).src = Image_url+o+'_yes.gif';
	} else {
		$('remarks_' + menucount).style.display = 'none';
		$('remarksimg_' + menucount).src = Image_url+o+'_no.gif';
	}	
}
function redirect(url) {
	window.location.replace(url);
}

function _attachEvent(obj, evt, func) {
	if(obj.addEventListener) {
		obj.addEventListener(evt, func, false);
	} else if(obj.attachEvent) {
		obj.attachEvent("on" + evt, func);
	}
}
function zoomtextarea(objname, zoom) {
	zoomsize = zoom ? 10 : -10;
	obj = $(objname);
	if(obj.rows + zoomsize > 0 && obj.cols + zoomsize * 3 > 0) {
		obj.rows += zoomsize;
		obj.cols += zoomsize * 3;
	}
}
function collapse_input(menu_id) {
	var			Tree=new   Array;
	Tree	=	menu_exit_id[menu_id].split(",");
	if($('menu_' + menu_id).checked ==true ) 
	{		
		open_input(menu_id);
	}
	else
	{
		close_input(menu_id);
	}
}
function open_input(menu_id)
{
	var			Tree=new   Array;
	Tree	=	menu_exit_id[menu_id].split(",");
	for(dd in Tree)
		{ 			
			if(Tree[dd])
			{
			$('menu_' + Tree[dd]).disabled = '';
			}
		}	
}
function close_input(menu_id)
{
	var			Tree=new   Array;
	Tree	=	menu_exit_id[menu_id].split(",");
	for(dd in Tree)
		{ 			
			if(Tree[dd])
			{
			$('menu_' + Tree[dd]).checked = false;
			$('menu_' + Tree[dd]).disabled = 'disabled';
				if(menu_exit_id[Tree[dd]])
				{
					close_input(Tree[dd]);
				}
			}
		}	
}
function collapse_CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall')
		{
			if(e.type=='checkbox')
			{
				e.checked = form.chkall.checked;
				if(form.chkall.checked==false)
				{
					e.disabled = 'disabled';
					open_input(0);
					form.submit.disabled = '';
				}
				else
				{
					e.disabled = '';
				}
			}			
		}
    }
  }
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall' && e.type=='checkbox')
		{
			e.checked = form.chkall.checked;			
		}
    }
  }
function isUndefined(variable) {
	return typeof variable == 'undefined' ? true : false;
}

//信息弹出显示层开始
function fetchOffset(obj) {
	var left_offset = obj.offsetLeft;
	var top_offset = obj.offsetTop;
	while((obj = obj.offsetParent) != null) {
		left_offset += obj.offsetLeft;
		top_offset += obj.offsetTop;
	}
	return { 'left' : left_offset, 'top' : top_offset };
}

var jsmenu = new Array();
jsmenu['active'] = new Array();
jsmenu['timer'] = new Array();
jsmenu['iframe'] = new Array();
function details_open(ctrlid, click, offset, duration,timeout,layer, showid, maxh ,xz) {//弹出信息层
	var ctrlobj = $(ctrlid);
	if(!ctrlobj) return;
	if(isUndefined(click)) click = false;
	if(isUndefined(offset)) offset = 0;
	if(isUndefined(duration)) duration = 2;
	if(isUndefined(timeout)) timeout = 500;
	if(isUndefined(layer)) layer = 0;
	if(isUndefined(showid)) showid = ctrlid;
	var showobj = $(showid);
	var menuobj = $(showid + '_menu');
	if(!showobj|| !menuobj) return;
	if(isUndefined(maxh)) maxh = 400;
	if(isUndefined(xz)) xz = 0;
	//alert(layer);
	hideMenu(layer);



	for(var id in jsmenu['timer']) {		
		if(jsmenu['timer'][id]) clearTimeout(jsmenu['timer'][id]);
	}

	initCtrl(ctrlobj, click, duration, timeout, layer);
	initMenu(ctrlobj, menuobj, duration, timeout, layer);
	menuobj.style.display = '';
	if(!is_opera) {
		menuobj.style.clip = 'rect(auto, auto, auto, auto)';
	}	
	setMenuPosition(showid, offset, xz);
	if(is_ie && is_ie < 7) {
		if(!jsmenu['iframe'][layer]) {
			var iframe = document.createElement('iframe');
			iframe.style.display = 'none';
			iframe.style.position = 'absolute';
			iframe.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)';
			$('append_parent') ? $('append_parent').appendChild(iframe) : menuobj.parentNode.appendChild(iframe);
			jsmenu['iframe'][layer] = iframe;
		}
		jsmenu['iframe'][layer].style.top = menuobj.style.top;
		jsmenu['iframe'][layer].style.left = menuobj.style.left;
		jsmenu['iframe'][layer].style.width = menuobj.w;
		jsmenu['iframe'][layer].style.height = menuobj.h;
		jsmenu['iframe'][layer].style.display = 'block';
	}
	/*
	if(maxh && menuobj.scrollHeight > maxh) {
		menuobj.style.height = maxh + 'px';
		if(is_ie || is_opera) {
			//menuobj.style.width = menuobj.scrollWidth + 18;
		}
		if(is_opera) {
			menuobj.style.overflow = 'auto';
		} else {
			menuobj.style.overflowY = 'auto';
		}
	}
*/
	if(!duration) {
		setTimeout('hideMenu(' + layer + ')', timeout);
	}
	jsmenu['active'][layer] = menuobj;
}

//使用JQUERY使用 summer.Hu
function details_open_tab(ctrlid,top,left) {//弹出信息层

	var jquery_offset = jq("#"+ctrlid);
	var position = jquery_offset.position();
	
	var ctrlobj = $(ctrlid);

	 click = false;
	 offset = 0;
	 duration = 2;
	 timeout = 500;
	 layer = 0;
	showid = ctrlid;
	var showobj = $(showid);
	var menuobj = $(showid + '_menu');
	if(!showobj|| !menuobj) return;
	maxh = 400;
	xz = 0;
	
	
	
	if(isUndefined(top)) top = 54;
	if(isUndefined(left)) left = 8;
	//alert(layer);
	hideMenu(layer);
	
	for(var id in jsmenu['timer']) {		
		if(jsmenu['timer'][id]) clearTimeout(jsmenu['timer'][id]);
	}


	initCtrl(ctrlobj, click, duration, timeout, layer);
	initMenu(ctrlobj, menuobj, duration, timeout, layer);
	menuobj.style.display = '';
	if(!is_opera) {
		menuobj.style.clip = 'rect(auto, auto, auto, auto)';
	}	
	setMenuPosition(showid, offset, xz);
	

	if(is_ie && is_ie < 7) {
		if(!jsmenu['iframe'][layer]) {
			var iframe = document.createElement('iframe');
			iframe.style.display = 'none';
			iframe.style.position = 'absolute';
			iframe.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)';
			$('append_parent') ? $('append_parent').appendChild(iframe) : menuobj.parentNode.appendChild(iframe);
			jsmenu['iframe'][layer] = iframe;
		}
		jsmenu['iframe'][layer].style.top = menuobj.style.top;
		jsmenu['iframe'][layer].style.left = menuobj.style.left;
		jsmenu['iframe'][layer].style.width = menuobj.w;
		jsmenu['iframe'][layer].style.height = menuobj.h;
		jsmenu['iframe'][layer].style.display = 'block';
	}

	if(menuobj.style.top!='')
	{
		var add_top=14;
		if(!isUndefined(jquery_offset.attr("value")))
		{
			add_top=25;
		}

		menuobj.style.top=(parseInt(position.top)+add_top)+'px';
	}
	if(menuobj.style.left!='')
	{
		menuobj.style.left=(parseInt(position.left))+'px';
	}
	
	if(!duration) {
		setTimeout('hideMenu(' + layer + ')', timeout);
	}
	jsmenu['active'][layer] = menuobj;
}


function initMenu(ctrlid, menuobj, duration, timeout, layer) {//阴影效果,离开关闭
	if(menuobj && !menuobj.initialized) {
		menuobj.initialized = true;
		menuobj.ctrlkey = ctrlid;
		menuobj.style.position = 'absolute';
		if(duration < 3) {
			if(duration > 1) {
				menuobj.onmouseover = function() {
					clearTimeout(jsmenu['timer'][ctrlid]);
				}
			}
			if(duration != 1) {
				menuobj.onmouseout = function() {
					jsmenu['timer'][ctrlid] = setTimeout('hideMenu(' + layer + ',\'yes\')', timeout);
				}
			}
		}
		menuobj.style.zIndex = 50;
		if(is_ie) {
			menuobj.style.filter += "progid:DXImageTransform.Microsoft.shadow(direction=135,color=#CCCCCC,strength=2)";
		}
	}
}
function setMenuPosition(showid, offset ,xz) {//层定位
	var showobj = $(showid);
	var menuobj = $(showid + '_menu');
	if(isUndefined(offset)) offset = 0;	
	if(isUndefined(xz)) xz = 0;
	if(showobj) {
		showobj.pos = fetchOffset(showobj);
		showobj.X = showobj.pos['left'];
		showobj.Y = showobj.pos['top'];
		showobj.w = showobj.offsetWidth;
		showobj.h = showobj.offsetHeight;
		menuobj.w = menuobj.offsetWidth;
		menuobj.h = menuobj.offsetHeight;
		menuobj.style.left = (showobj.X + menuobj.w > document.body.clientWidth) && (showobj.X + showobj.w - menuobj.w >= 0) ? showobj.X + showobj.w - menuobj.w + 'px' : showobj.X + 'px';
		menuobj.style.top = offset == 1 ? showobj.Y + 'px' : (offset == 2 || ((showobj.Y + showobj.h + menuobj.h > document.documentElement.scrollTop + document.documentElement.clientHeight) && (showobj.Y - menuobj.h >= 0)) ? (showobj.Y - menuobj.h + xz) + 'px' : (showobj.Y + showobj.h + xz)+ 'px');
		if(menuobj.style.clip && !is_opera) {
			menuobj.style.clip = 'rect(auto, auto, auto, auto)';
		}
	}
}
function initCtrl(ctrlobj, click, duration, timeout, layer) {//设定定时关闭
	if(ctrlobj && !ctrlobj.initialized) {
		ctrlobj.initialized = true;

		ctrlobj.outfunc = typeof ctrlobj.onmouseout == 'function' ? ctrlobj.onmouseout : null;
		ctrlobj.onmouseout = function() {
			if(this.outfunc) this.outfunc();
			if(duration < 3) jsmenu['timer'][ctrlobj.id] = setTimeout('hideMenu(' + layer + ')', timeout);
		}

		if(click && duration) {
			ctrlobj.clickfunc = typeof ctrlobj.onclick == 'function' ? ctrlobj.onclick : null;
			ctrlobj.onclick = function (e) {
				if(jsmenu['active'][layer] == null || jsmenu['active'][layer].ctrlkey != this.id) {
					if(this.clickfunc) this.clickfunc();
					else details_open(this.id, true);
				} else {
					hideMenu(layer);
				}
			}
		}
		ctrlobj.overfunc = typeof ctrlobj.onmouseover == 'function' ? ctrlobj.onmouseover : null;
		ctrlobj.onmouseover = function(e) {
			if(this.overfunc) this.overfunc();
			if(click) {
				clearTimeout(jsmenu['timer'][this.id]);
			} else {
				for(var id in jsmenu['timer']) {
					if(jsmenu['timer'][id]) clearTimeout(jsmenu['timer'][id]);
				}
			}
		}
	}
}
function hideMenu(layer,isIframe) {//关闭处理
	if(isUndefined(layer)) layer = 0;
	if(isUndefined(isIframe)) isI = 'no'; else isI = isIframe;
	if(jsmenu['active'][layer]) {
		clearTimeout(jsmenu['timer'][jsmenu['active'][layer].ctrlkey]);
		jsmenu['active'][layer].style.display = 'none';			
		if(is_ie && is_ie < 7 && jsmenu['iframe'][layer]) {			
			if(isI=="yes") {	
				jsmenu['iframe'][layer].style.display = 'none';				
			}
		}
		jsmenu['active'][layer] = null;
	}
}
function details_close(ctrlid) {//离开直接关闭
	var ctrlobj = $(ctrlid);
	var menuobj = $(ctrlid + '_menu');
	hideMenu('0','yes');
	menuobj.style.display='none';
}
////信息弹出显示层结束

//获取高度
function getNodePosition(node,type){var nodeTemp=node;var l=0;var t=0;while(nodeTemp!=document.body&&nodeTemp!=null){l+=nodeTemp.offsetLeft;t+=nodeTemp.offsetTop;nodeTemp=nodeTemp.offsetParent}if(type.toLowerCase()=="left")return l;else return t};
//input textarea select 改变颜色
function brightBox (o)
{
	if (o)
	{
		if (document.all)
		{
			o.style.backgroundColor = "#FFFFFF";
			o.style.borderColor = "#00A8FF";
		}
	}
}
function dimBox(o)
{
	if (o)
	{
		if (document.all)
		{
			o.style.backgroundColor = "#F7F7F7";
			o.style.borderColor = "#87A34D";
		}
	}
}
function trim(str) {//字符过滤
	return (str + '').replace(/(\s+)$/g, '').replace(/^\s+/g, '');
}

////////////////////////

function arraypush(a, value) {//设置一个新值到指定数组的最后一位。数组长度自动加一。 
	a[a.length] = value;
	return a.length;
}

function in_array(needle, haystack) {//数组包括判断
	if(typeof needle == 'string') {
		for(var i in haystack) {
			if(haystack[i] == needle) {
					return true;
			}
		}
	}
	return false;
}

/*ajax开始*/	
	// var xml_http_building_link = '<img src="' + Image_url + 'check_loading.gif" width="13" height="13"> 请等待，正在建立连接...';
	// var xml_http_sending = '<img src="' + Image_url + 'check_loading.gif" width="13" height="13"> 请等待，正在发送数据...';
	// var xml_http_loading = '<img src="' + Image_url + 'check_loading.gif" width="13" height="13"> 请等待，正在接受数据...';
	// var xml_http_load_failed = '<img src="' + Image_url + 'check_error.gif" width="13" height="13"> 通信失败，请刷新重新尝试！';
	// var xml_http_data_in_processed = '<img src="' + Image_url + 'check_loading.gif" width="13" height="13"> 通信成功，数据正在处理中...';


function ajaxremarks(objname, data ,css1,css2,opendiv,closediv,closediv2,http){
		var x = new Ajax('XML', objname);
		if(isUndefined(http)) http = '';
		
		jQuery.ajax({
				url: http+'?action=ajax&' + data,
				dataType: "text", 
				success:function(s){
					s = s.replace( '<?xml version="1.0" encoding="UTF-8"?><ajax><![CDATA[', "" )
					s = s.replace( ']]></ajax>', "" );
					if(s){
						var jq = jQuery.noConflict();
						jq('#NewRemarks').before(s);
					}
				}
		});
	}	

function ajaxresponse(objname, data ,css1,css2,opendiv,closediv,closediv2,http) {//ajax取值并判断
        	var x = new Ajax('XML', objname);
			if(isUndefined(http)) http = '';
        	x.get(http+'?action=ajax&' + data, function(s){
        	       	var obj = $(objname);					
        	        if( s.substr(0, 1) != '0') {	
						obj.style.display = '';
						if(s.substr(1).indexOf('<script>')>=0){
							jq(obj).html(s.substr(1));
						}else{
							obj.innerHTML=s.substr(1);
						}
        	            
						if(s.substr(0, 1)>5) 
						{
							obj.className =css2;
						}
						else
						{
							obj.className = css1;
						}
						if(closediv2) 
						{
							var close_div2=$(closediv2);							
							close_div2.style.display='none';
						}
        			}
					else
					{						
						warning(obj, s.substr(1),css1,closediv);
					}
					//if(opendiv) details_open(opendiv);
        	});
 }
 
 
 function ajaxresponse_view(objname, data ,css1,css2,opendiv,closediv,closediv2,http) {//ajax取值并判断
        	var x = new Ajax('XML', objname);
			if(isUndefined(http)) http = '';
        	x.get(http+'?action=ajax_view&' + data, function(s){
        	       	var obj = $(objname);					
        	        if( s.substr(0, 1) != '0') {	
						obj.style.display = '';
        	            obj.innerHTML = s.substr(1);
						if(s.substr(0, 1)>5) 
						{
							obj.className =css2;
						}
						else
						{
							obj.className = css1;
						}
						if(closediv2) 
						{
							var close_div2=$(closediv2);							
							close_div2.style.display='none';
						}
        			}
					else
					{						
						warning(obj, s.substr(1),css1,closediv);
					}
					//if(opendiv) details_open(opendiv);
        	});
 }
 
 function warning(obj, msg ,css1,closediv) {//返回值错误提示
		if( msg.substr(0, 1) == '0') var check_img='check_error.gif';
		else var check_img='check_warn.gif';
		obj.className = css1;
		obj.innerHTML ='<img src="' + Image_url + check_img + '" width="13" height="13"> ' + msg.substr(1);
		obj.style.display = '';
		if(closediv) {
		var close_div=$(closediv);	
		close_div.style.display='none';
		}
	}
/*ajax结束*/
function pageGo(value) 
{ 
	var custompage = document.getElementsByName('custompage');
	for(var i = 0 ;i<custompage.length;i++){
	custompage[i].value=value;
	}
} 

if(typeof(jQuery)!='undefined'){
	//增加选择的名称到结果框中
	function addseletypevalue($el,arr,cbfun){
		cbfun=cbfun || 0;
		var strid=$el.attr('id');
		var $tdiv=jq('#'+strid+'_w_valuediv');
		if($tdiv.length==0){
			var $tdiv=jq('<div id="'+strid+'_w_valuediv" class="typevaluediv">').insertBefore($el);
		}
		for(var i=0;i<arr.length;i++){
			var tcid=arr[i][0];
			jq('<a href="javascript:void(0);" title="单击删除此类别" val="'+arr[i][0]+'">'+arr[i][1]+'</a>')
				.click(function(){
					if(cbfun){cbfun.call($el,tcid);}
					jq(this).remove();
					var strval=(','+$el.val()+',').replace(','+jq(this).attr('val')+',',',');
					
					if(strval.length>1){
						var tempValue = strval.substring(1,strval.length-1);
						
						var tempArr = toArray( tempValue );
						
						$el.val( tempArr.length ? ',' + tempArr.join(',') + ',' : '' );
					}else{
						$el.val('');
					}
				})
				.appendTo($tdiv);
		}
	}
	
	(function($){
		$.fn.showE=function(a,b,c){var e=this;var f=arguments.length;if(f==1){var g=$.extend({},$.fn.showE.defaults,a);e.css({position:'absolute','z-index':999});$('#'+g.btnclose).bind('click',close);if(g.shade){showshade()}setlocation();setevent()}else{setlocation2();$(window).resize(setlocation2)}e.show();return e;function close(){e.hide();$(window).unbind("resize",setlocation);$(window).unbind("scroll",setlocation)};function showshade(){$('html').css('overflow','hidden');$('body').css('overflow','hidden')};function setlocation(){var a=g.position.split(' ');if(a.length<2){a[1]='center'}var b=inttop=0;switch(a[0]){case'center':b=($(window).width()-e.outerWidth())/2;break;default:b=a[0]}switch(a[1]){case'center':inttop=($(window).height()-e.outerHeight())/2+$(window).scrollTop();break;default:inttop=Number(a[1])+$(window).scrollTop()}e.css({left:b,top:inttop})};function setlocation2(){var o=a.offset();var t=0;var l=0;b=b||3;c=c||0;if(b==1){t=-c-e.outerHeight();if(o.top+t<0){t=c+a.outerHeight()}}if(b==2){l=c+a.outerWidth()}if(b==3){t=c+a.outerHeight();var d=o.left+e.outerWidth()-$(window).width();if(d>0){l=-d}}if(b==4){l=-c-e.outerWidth()}e.css({top:o.top+t,left:o.left+l})};function setevent(){$(window).resize(setlocation);$(window).scroll(setlocation)}};$.fn.showE.defaults={position:'center',btnclose:'',shade:0}
		$.fn.w_stronglist = function(q) {
		    if (!q.keysea) {
		        q.keysea = q.key
		    }
		    var r = $(this).data('oldval', ''),
		    keydownval = 0;
		    if (r.data('attrinit') != 1) {
		        var s = $.extend({},
		        $.fn.w_stronglist.defaults, q);
		        if (s.searchaim) {
		            var t = $('#' + s.searchaim)
		        } else {
		            var t = $('<input type="text" autocomplete="off" class="cateinput" />').insertAfter(r).data('oldval', '')
		        }
		        if (s.hide) {
		            var u = $('<input type="button" class="catebutton" />').insertAfter(t.hide())
		        }
		        if (s.treeaim != 0) {
		            var v = $('#' + s.treeaim).css({
		                width: s.treewidth + s.selewidth + (s.selediv == 1 ? 5 : 2),
		                height: s.height + 2
		            });
		            var w = v.children('.catetree').css({
		                width: s.treewidth,
		                height: s.height
		            });
		            if (q.selediv == 1) {
		                var x = v.children('.catesele').css({
		                    width: s.selewidth,
		                    height: s.height
		                })
		            }
		        } else {
		            var v = $('<div class="catetocid" style="z-index: 9999;">').css({
		                width: s.treewidth + s.selewidth + (s.selediv == 1 ? 5 : 2),
		                height: s.height + 2
		            });
		            var w = $('<div class="catetree">').css({
		                width: s.treewidth,
		                height: s.height
		            }).appendTo(v);
		            if (q.selediv == 1) {
		                var x = $('<div class="catesele">').css({
		                    width: s.selewidth,
		                    height: s.height
		                }).appendTo(v)
		            }
		            v.appendTo('body')
		        }
		        $(document).keydown(function(e) {
		            if (e.keyCode == '16') {
		                keydownval = 16
		            }
		        }).keyup(function() {
		            keydownval = 0
		        });
		        if (s.hide) {
		            t.focus(function() {
		                v.showE(t, 3, 1)
		            }).click(function() {
		                v.showE(t, 3, 1)
		            });
		            u.click(function() {
		                u.hide();
		                t.show().focus()
		            });
		            $(document).keydown(function(e) {
		                if (e.keyCode == '27') {
		                    close()
		                }
		            });
		            $(document).mousedown(function(e) {
		                if ($(e.target).index(t) < 0 && $(e.target).parents().index(v) < 0) {
		                    close()
		                }
		            })
		        }
		        r.data('attrinit', 1);
		        w.data('sele', {
		            cid: '',
		            cname: ''
		        });
		        if (r.val() != '') {
		            initselevalue()
		        }
		    }
		    if (q == 'val') {
		        return w.data('val')
		    } else if (q == 'vals') {
		        return x.data('val')
		    } else if (q.sele != undefined) {
		        if (q.sele == "") {
		            return
		        }
		        w.data('sele').cid = q.sele;
		        if (q.key == '') {
		            return
		        }
		        $.ajax({
		            cache: false,
		            timeout: 30000,
		            type: "GET",
		            url: '/milanooht/index.php?action=ajax&responseType=result&menu_action=' + q.key + '&cids=' + q.sele + '&WebsiteId='+q.WebsiteId,
		            success: function(a) {
		                if (a.substr(0, 3) == 'var') {
		                    eval(a);
		                    var b;
		                    var c = [];
		                    var d = [];
		                    for (var i = 0; i < result.length; i++) {
		                        c[i] = result[i][0];
		                        d[i] = result[i][1];
		                        b = $('<dl cid="' + result[i][0] + '">' + result[i][1] + '</dl>');
		                        b.data('cval', {
		                            cid: result[i][0],
		                            cname: result[i][1],
		                            up: result[i][2]
		                        }).appendTo(x)
		                    }
		                    c = c.join(',');
		                    d = d.join(',');
		                    w.data('sele', {
		                        cid: c,
		                        cname: d
		                    })
		                }
		            }
		        })
		    }
		    var q = $.extend({},
		    $.fn.w_stronglist.defaults, q);
		    if (!q.root && !q.auto) {
		        q.auto = 1
		    }
		    autoloadroot();
		    var y = 0;
		    t.keydown(function(e) {
		        clearTimeout(y)
		    }).keyup(function(e) {
		        if (e.which >= 49 || e.which == 32 || e.which == 8) {
		            clearTimeout(y);
		            y = setTimeout(searchvalue, 500)
		        }
		    });
		    w.click(function(e) {
		        var a = e.target.tagName.toLowerCase();
		        if (e.target.className.toLowerCase().indexOf('catetree') >= 0) {
		            return false
		        };
		        if (a == 'span' || a == 'input') {
		            var b = $(e.target).parents('dl').eq(0)
		        } else {
		            var b = $(e.target)
		        }
		        var c = b.attr('cid');
		        if (a == 'dl') {
		            var d = b.next();
		            var f = b.attr('key');
		            if (b.hasClass('Tminus')) {
		                b[0].className = 'Tplus';
		                d.addClass('t_close')
		            } else if (b.hasClass('Tplus')) {
		                b[0].className = 'Tminus';
		                d.removeClass('t_close');
		                d.show();
		                if (b.attr('va') != '1') {
		                    if (f == '' || f == 'undefined') {
		                        f = q.key
		                    }
		                    loadnode(d, c, b, w, f)
		                }
		            }
		        } else {
		            if (a == 'span') {
		                var g = {
		                    el: b,
		                    cid: b.attr('cid'),
		                    cname: $('span', b).text(),
		                    up: b.attr('up'),
		                    lcname: getlangname(b)
		                };
		                w.data('val', g);
		                if (b.attr('nc') == 0 && q.nodeClick) {
		                    q.nodeClick.call(this, r, g, q.charborder);
		                    close()
		                }
		            } else if (a == 'input') {
		                var h = $(e.target);
		                var i = h.attr('checked');
		                var j = b;
		                if (keydownval == 16) {
		                    var k = h.closest('dl');
		                    var l = k.parent().children('dl[cid]');
		                    var m = l.filter('dl.Tsele');
		                    var n = l.index(m);
		                    if (n != -1) {
		                        var o = l.index(k);
		                        if (n > o) {
		                            var p = o;
		                            o = n;
		                            n = p
		                        }
		                        j = l.slice(n, o + 1);
		                        h = j.find('input:checkbox').attr('checked', i)
		                    }
		                }
		                var g = new Array();
		                j.each(function() {
		                    tmpel = $(this);
		                    g.push({
		                        cid: tmpel.attr('cid'),
		                        cname: $('span', tmpel).text(),
		                        up: tmpel.attr('up')
		                    })
		                });
		                if (q.selediv) {
		                    selechangenode(h, g, x, w, i)
		                }
		                changeval(w, x, g, i)
		            }
		            if (w.data('old')) {
		                w.data('old').removeClass('Tsele')
		            }
		            b.addClass('Tsele');
		            w.data('old', b)
		        }
		    }).mousemove(function(e) {
		        var a = e.target.tagName.toLowerCase();
		        if (a == 'span' || a == 'input') {
		            var b = $(e.target).parents('dl').eq(0)
		        } else {
		            var b = $(e.target)
		        }
		        if (b.hasClass('Tminus') || b.hasClass('Tplus') || b.hasClass('Tno')) {
		            b.addClass('Tmov')
		        }
		    }).mouseout(function(e) {
		        var a = e.target.tagName.toLowerCase();
		        if (a == 'span' || a == 'input') {
		            var b = $(e.target).parents('dl').eq(0)
		        } else {
		            var b = $(e.target)
		        }
		        b.removeClass('Tmov')
		    });
		    if (q.selediv == 1) {
		        x.dblclick(function(e) {
		            var a = $(e.target);
		            seledelnode(a.data('ein'), a.data('cval'), x, w)
		        }).mousemove(function(e) {
		            var a = $(e.target);
		            a.addClass('Tmov')
		        }).mouseout(function(e) {
		            var a = $(e.target);
		            a.removeClass('Tmov')
		        })
		    }
		    function close() {
		        if (q.hide) {
		            v.hide();
		            t.hide();
		            q.hide && u.show()
		        }
		    }
		    function autoloadroot() {
		        if (q.root) {
		            w.html('<dl cid="' + q.up + '" class="' + ((q.auto) ? 'Tminus': 'Tplus') + ' root">顶部选项</dl><dl class="Ino root_l"></dl>')
		        }
		        if (q.auto) {
		            if (q.root) {
		                var a = $('.root_l', w);
		                loadnode(a, a.attr('cid'), $('.root', w), w, q.key)
		            } else {
		                loadnode(w, q.up, 0, w, q.key)
		            }
		        }
		    }
		    function initselevalue() {
		        $.ajax({
		            cache: false,
		            timeout: 30000,
		            type: "GET",
		            url: '/milanooht/index.php?action=ajax&responseType=result&menu_action=' + q.key + '&cids=' + r.val() + '&WebsiteId='+q.WebsiteId,
		            success: function(a) {
		                if (a.substr(0, 3) == 'var') {
		                    eval(a);
		                    if (q.valueInitFun) {
		                        q.valueInitFun.call(this, r, result)
		                    }
		                }
		            }
		        })
		    }
		    function selechangenode(b, c, d, e, f) {
		        if (typeof(c) != 'object') {
		            return
		        }
		        var i = 0;
		        b.each(function(i) {
		            var a = $('dl[cid=' + c[i].cid + ']', d);
		            if (f) {
		                if (a.length <= 0) {
		                    var a = $('<dl cid="' + c[i].cid + '"></dl>').appendTo(d);
		                    a.text(c[i].cname).data('cval', c[i]).data('ein', $(this))
		                }
		            } else {
		                if (a.length > 0) {
		                    a.remove()
		                }
		            }
		        })
		    };
		    function seledelnode(a, b, c, d) {
		        if (typeof(b) != 'object') {
		            return
		        }
		        var e = $('dl[cid=' + b.cid + ']', c);
		        changeval(d, c, [{
		            cid: b.cid,
		            cname: b.cname
		        }], false);
		        if (e.length > 0) {
		            e.remove();
		            if (a) {
		                a[0].checked = false
		            } else {
		                a = $('dl[cid=' + b.cid + ']', d).find('input');
		                if (a.length > 0) {
		                    a[0].checked = false
		                }
		            }
		        }
		    };
		    function changeval(a, b, c, d) {
		        var e = a.data('sele').cid;
		        var f = a.data('sele').cname;
		        for (var i = 0; i < c.length; i++) {
		            if (d) {
		                if (e.indexOf(',' + c[i].cid + ',') == -1) {
		                    e += ',' + c[i].cid + ',';
		                    f += ',' + c[i].cname + ','
		                }
		            } else {
		                e = ',' + e + ',';
		                f = ',' + f + ',';
		                e = e.replace(',' + c[i].cid + ',', ',');
		                f = f.replace(',' + c[i].cname + ',', ',')
		            }
		        }
		        a.data('sele', {
		            cid: e,
		            cname: f
		        });
		        var g = e.split(',');
		        var h = Array();
		        for (var i = 0; i < g.length; i++) {
		            if (g[i]) {
		                h.push(g[i])
		            }
		        }
		        var g = f.split(',');
		        var j = Array();
		        for (var i = 0; i < g.length; i++) {
		            if (g[i]) {
		                j.push(g[i])
		            }
		        }
		        if (q.nodeChange) {
		            q.nodeChange.call(this, {
		                cids: h,
		                cnames: j
		            })
		        }
		    };
		    function loadnode(h, j, k, l, m) {
		        var n = l.data('sele').cid;
		        h.html('正在加载栏目……');
		        $.ajax({
		            cache: false,
		            timeout: 30000,
		            type: "GET",
		            url: '/milanooht/index.php?action=ajax&responseType=result&menu_action=' + m + '&cid=' + j + '&WebsiteId='+q.WebsiteId,
		            success: function(a) {
		                if (a.substr(0, 3) == 'var') {
		                    eval(a);
		                    var b = [];
		                    var c = "";
		                    var d = "";
		                    for (var i = 0; i < result.length; i++) {
		                        c = (parseInt(result[i][3]) > 0) ? 'Tplus': 'Tno';
		                        var e = result[i][5] == 'undefined' ? '': result[i][5];
		                        var f = e == 'c' || e == 'cn' ? 1 : 0;
		                        var g = e == 'n' || e == 'cn' ? 1 : 0;
		                        if (q.box && f == 0) {
		                            d = '<input type="checkbox" ' + checknode(result[i][0], n) + ' />'
		                        } else {
		                            d = ''
		                        }
                                if(m == 'w_SuppliersName'){
                                    b[i] = '<dl class="' + c + '" cid="' + result[i][0] + '" up="' + result[i][2] + '" key="' + result[i][4] + '" nc="' + g + '"><span>' + d + result[i][1] + '<font color="red">[' +result[i][2]+ ']</font></span></dl>';
                                }if(m == 'hot_categories_zh-cn'){
                                    if(result[i][3]=='0'){
                                        b[i] = '<dl class="' + c + '" cid="' + result[i][0] + '" up="' + result[i][2] + '" key="' + result[i][4] + '" nc="' + g + '"><span>' + d + result[i][1] + '</span></dl>';
                                    }else{
                                        b[i] = '<dl class="' + c + '" cid="' + result[i][0] + '" up="' + result[i][2] + '" key="' + result[i][4] + '" nc="' + g + '">' + d + result[i][1] + '</dl>';
                                    }
                                     
                                    
                                }else{
                                    b[i] = '<dl class="' + c + '" cid="' + result[i][0] + '" up="' + result[i][2] + '" key="' + result[i][4] + '" nc="' + g + '"><span>' + d + result[i][1] + '</span></dl>';
                                }
		                        if (c == 'Tplus') {
		                            b[i] += '<dl class="Ino t_close"></dl>'
		                        }
		                    }
		                    c = b.join("");
		                    h.html(c);
		                    if (k) {
		                        k.attr('va', '1')
		                    }
		                } else {
		                    loaderror(h, k)
		                }
		            },
		            error: function() {
		                loaderror(h, k)
		            }
		        })
		    }
		    function searchvalue() {
		        //return false;
		        if (t.val() == t.data('oldval')) {
		            return false
		        }
		        t.data('oldval', t.val());
		        if (t.val() == '') {
		            autoloadroot()
		        } else {
		            var d = w.data('sele').cid;
		            $.ajax({
		                cache: false,
		                timeout: 30000,
		                type: "POST",
		                url: '/milanooht/index.php',
		                data: {
		                    action: 'ajax',
		                    responseType: 'result',
		                    menu_action: q.keysea,
		                    seach: t.val(),
							WebsiteId : q.WebsiteId
		                },
		                success: function(a) {
		                    if (a.substr(0, 3) == 'var') {
		                        eval(a);
		                        var b = [];
		                        var c = "";
		                        for (var i = 0; i < result.length; i++) {
		                            if (q.box) {
		                                c = '<input type="checkbox" ' + checknode(result[i][0], d) + ' />'
		                            } else {
		                                c = ''
		                            }
		                            b[i] = '<dl class="Tno" cid="' + result[i][0] + '" up="' + result[i][2] + '" nc="0"><span>' + c + result[i][1] + '</span></dl>'
		                        }
		                        w.html(b.join(""))
		                    } else {
		                        loaderror(w)
		                    }
		                },
		                error: function() {
		                    loaderror(w)
		                }
		            })
		        }
		    }
		    function getlangname(a) {
		        var b = Array(a.children('span').text());
		        if (a.parent('dl.Ino').length > 0) {
		            a.parents('dl.Ino').each(function() {
		                b.unshift($(this).prev().children('span').text())
		            });
		            b = '/ ' + b.join(' / ')
		        } else {
		            b = b.join('')
		        }
		        return b
		    }
		};
		function checknode(a, b) {
		    if ((',' + b + ',').indexOf(',' + a + ',') < 0) {
		        return ''
		    } else {
		        return 'checked="checked"'
		    }
		};
		function loaderror(a, b) {
		    if (b) {
		        a.html('加载栏目失败').fadeOut(800,
		        function() {
		            a.addClass('t_close');
		            b[0].className = 'Tplus'
		        })
		    } else {
		        a.html('加载栏目失败')
		    }
		};
		$.fn.w_stronglist.defaults = {
		    root: 0,
		    auto: 1,
		    box: 0,
		    up: 0,
		    sele: '',
		    nodeClick: 0,
		    nodeChange: 0,
		    selediv: 0,
		    hide: 1,
		    key: '',
		    keysea: '',
		    treewidth: 300,
		    selewidth: 0,
		    height: 200,
		    treeaim: 0,
		    searchaim: 0,
		    charborder: 0,
		    valueInitFun: addseletypevalue
		};
		$.fn.w_getInputs=function(){var c=$.fn.w_getInputs.rule;var d={},exit=true;this.find('input[name]').each(function(){var a={},tmp,el=$(this),atype=el.attr('type'),aname=el.attr('name'),rule=el.attr('rule');switch(atype){case"hidden":case"password":case"text":d[aname]=el.val();break;case"checkbox":d[aname]=(el.attr('checked'))?el.val():0;break;case"radio":if(el.attr('checked')){d[aname]=el.val()}break}if(rule!=undefined){rule=rule.split('|');var b=rule[0];for(var i=1;i<rule.length;i++){tmp=rule[i].split(':');if(tmp.length==1){a[tmp[0]]=1}else{a[tmp[0]]=tmp[1]}}$.each(a,function(n,v){if(c[n]){exit=c[n].apply(el,[b,d[aname],v]);if(exit==false){el.focus()}else{exit=true}return exit}});if(!exit){return false}}});if(!exit){return false}this.find('select[name]').each(function(){var a=$(this);var b=a.attr('name');d[b]=a.val()});this.find('textarea[name]').each(function(){var a=$(this);var b=a.attr('name');d[b]=a.val()});return d};$.fn.w_getInputs.rule={nonull:function(a,b){if($.trim(b)==''){alert(a+' 不能为空！');return false}},minsize:function(a,b,v){if($.trim(b).length<v){alert(a+' 的长度不能少于'+v+'位！');return false}},charnum:function(a,b){if((/^[0-9_]+$/).test(b)||(/^[a-zA-Z_]+$/).test(b)){alert(a+' 必须由字母和数字组合！');return false}}};
		$.fn.w_nullInputState=function(s,c){if(c==undefined){var c=''}return this.each(function(){if(this.value==''){this.value=s;c!=''&&$(this).addClass(c)}$(this).focus(function(){if(this.value==s){this.value='';c!=''&&$(this).removeClass(c)}}).blur(function(){if(this.value==''){this.value=s;c!=''&&$(this).addClass(c)}})})}
		$.fn.isselbox=function(a){a=a||'请选择在需要操作的记录前打钩';var b=false;this.each(function(){if($(this).is(':checked')){b=true;return false}});if(!b)alert(a);return b}
	})(jQuery);
	
	jQuery.cookie=function(a,b,c){if(typeof(b)!='undefined'){c=c||{};if(b===null){b='';c=$.extend({},c);c.expires=-1}var d='';if(c.expires&&(typeof c.expires=='number'||c.expires.toUTCString)){var e;if(typeof c.expires=='number'){e=new Date();e.setTime(e.getTime()+(c.expires*24*60*60*1000))}else{e=c.expires}d='; expires='+e.toUTCString()}var f=c.path?'; path='+(c.path):'';var g=c.domain?'; domain='+(c.domain):'';var h=c.secure?'; secure':'';document.cookie=[a,'=',encodeURIComponent(b),d,f,g,h].join('')}else{var j=null;if(document.cookie&&document.cookie!=''){var k=document.cookie.split(';');for(var i=0;i<k.length;i++){var l=jQuery.trim(k[i]);if(l.substring(0,a.length+1)==(a+'=')){j=decodeURIComponent(l.substring(a.length+1));break}}}return j}};
	
	//扩展功能
	//增加结果到输入框前面
	function addtypevalue($el,data,cb,cbfun){
		cbfun=cbfun || 0;
		var strid=$el.attr('id');
		var $tdiv=jq('#'+strid+'_w_valuediv');
		if($tdiv.length==0){
			var $tdiv=jq('<div id="'+strid+'_w_valuediv" class="typevaluediv">').insertBefore($el);
		}
		var tmp2=cb?',':'';
		$el.val(tmp2+data.cid+tmp2);
		jq('<a href="javascript:void(0);" title="单击删除此类别">'+data.lcname+'</a>')
			.click(function(){
				if(cbfun){cbfun.call($el,data.cid);}
				jq(this).remove();
				$el.val('');
			})
			.appendTo($tdiv.text(''));
	}

	function addtypevalue_and_auto_fill($el,data,cb,cbfun,zz){
		cbfun=cbfun || 0;
		var strid=$el.attr('id');
		var $tdiv=jq('#'+strid+'_w_valuediv');
		if($tdiv.length==0){
			var $tdiv=jq('<div id="'+strid+'_w_valuediv" class="typevaluediv">').insertBefore($el);
		}
		var tmp2=cb?',':'';
		$el.val(tmp2+data.cid+tmp2);
		var sitelang = jq("#language").val();
		var WebsiteId = jq("#WebsiteId").val();
//		alert(jq("#language").val());
		
		var as_url = '/milanooht/index.php?action=ajax&responseType=result&menu_action=get_childrenList&_language_station='+ sitelang +'&_c_1_select_id='+data.cid+''+'&WebsiteId='+WebsiteId;
		console.log(as_url);
		jq('<a href="javascript:void(0);" title="单击删除此类别">'+data.lcname+'</a>').click(function(){
				if(cbfun){cbfun.call($el,data.cid);}
				jq(this).remove();
				$el.val('');
			}).appendTo($tdiv.text(''));

		jq.getJSON(as_url, function(json) {
			jq("#textalias").val(json.bn);
			jq("#textfront").val(json.fn);
			jq("#textseo").val(json.seo);
			jq("#texturl").val(json.urln);
		    });
		
	}	
	
	function toArray( str, sign ) {
		var arr = [], s = sign ? sign : ',';
		
		var tempArr = str.split( s );
		
		for( var i = tempArr.length - 1; i >= 0; i -- ) {
			var t = tempArr[ i ].replace( /^(\s|\u00A0)+|(\s|\u00A0)+$/g, '' );
			if( t !== '' ) {
				arr.push( t );
			}
		}
		
		return arr;
	}	
	
	//增加结果到输入框前面 多选
	function addtypevalues($el,data,cb){
		var strid=$el.attr('id');
		var $tdiv=jq('#'+strid+'_w_valuediv');
		if($tdiv.length==0){
			var $tdiv=jq('<div id="'+strid+'_w_valuediv" class="typevaluediv">').insertBefore($el);
		}
		
		if(cb){
			$el.val()
		}
		var tmp1=cb?'':',',tmp2=cb?',':'';
		if((tmp1+$el.val()+tmp1).indexOf(','+data.cid+',')==-1){
			var strval=$el.val()!=''?$el.val()+tmp1+data.cid+tmp2:tmp2+data.cid+tmp2;
			
			$el.val( ',' + toArray( strval ).join(',') + ',' );
			
			jq('<a href="javascript:void(0);" title="单击删除此类别" val="'+data.cid+'">'+data.lcname+'</a>')
				.click(function(){
					jq(this).remove();
					var strval=(tmp1+$el.val()+tmp1).replace(','+jq(this).attr('val')+',',',');
					if(strval.length>1){
						var tempValue = cb?strval:strval.substring(1,strval.length-1);
						
						var tempArr = toArray( tempValue );
						
						$el.val( tempArr.length ? ',' + tempArr.join(',') + ',' : '' );
					}else{
						$el.val('');
					}
				})
				.appendTo($tdiv);
		}
	}	

	function addtypevalues_and_ajax($el,data,cb){
		var strid=$el.attr('id');
		var $tdiv=jq('#'+strid+'_w_valuediv');
		if($tdiv.length==0){
			var $tdiv=jq('<div id="'+strid+'_w_valuediv" class="typevaluediv">').insertBefore($el);
		}
		
		if(cb){
			$el.val()
		}
		var tmp1=cb?'':',',tmp2=cb?',':'';
		if((tmp1+$el.val()+tmp1).indexOf(','+data.cid+',')==-1){
			var strval=$el.val()!=''?$el.val()+tmp1+data.cid+tmp2:tmp2+data.cid+tmp2;
			
			$el.val( ',' + toArray( strval ).join(',') + ',' );
			
			var lang = jq("#language_station").find("option:selected").val();
			
			/*var as_url = '/milanooht/index.php?action=ajax&responseType=result&menu_action=getProductElevate&_value='+ lang +'&_categoryId='+data.cid+'';
			
			jq.getJSON(as_url, function(json){
				var as_textarea = jq("#as_textarea").val();
				if(json != null) {
					if(as_textarea.length) {
						jq("#as_textarea").val(as_textarea +','+json);
					} else {
						jq("#as_textarea").val(json);
					}					
				}

			});*/
			
			jq('<a href="javascript:void(0);" title="单击删除此类别" val="'+data.cid+'">'+data.lcname+'</a>')
				.click(function(){
				    var catId = jq(this).attr('val');
                   /* var del_url = '/milanooht/index.php?action=ajax&responseType=result&menu_action=getProductElevate&_value='+ lang +'&_categoryId='+catId;
                    
                    jq.getJSON(del_url, function(result){
				        var as_textarea2 = jq("#as_textarea").val();
				        if(result != null) {
	                       		var newdata = as_textarea2.replace(result,'');
                                var dataNew = trimdh(newdata);
                                jq("#as_textarea").val(dataNew);
                                			
				        }

			         });*/
                     
					jq(this).remove();
					var strval=(tmp1+$el.val()+tmp1).replace(','+jq(this).attr('val')+',',',');
					if(strval.length>1){
						var tempValue = cb?strval:strval.substring(1,strval.length-1);
						
						var tempArr = toArray( tempValue );
						
						$el.val( tempArr.length ? ',' + tempArr.join(',') + ',' : '' );
					}else{
						$el.val('');
					}
				})
				.appendTo($tdiv);
		}
	}
    
    //去掉字符串首尾逗号
    function trimdh(text){
        {
            return (text || "").replace(/^\,+|\,+$/g, "");
        } 
    }	
	
	//将层全屏化，并可还原大小
	function fullwindiv(a,str,fun)
	{
		var obj=jq('#'+str);
		var el=jq(a);
		if(el.attr('fullwin')=='1'){
			var tmpd=obj.data('oldoff');
			obj.width(tmpd.width).height(tmpd.height)
				.css({position:'static'})
				.appendTo(tmpd.parent);
			el.text(el.data('oldtext')).attr('fullwin',0);
		}else{
			obj.data('oldoff',{width:obj.width(),height:obj.height(),parent:obj.parent()})
				.width(jq(window).width()).height(jq(window).height())
				.css({position:'absolute',top:jq(window).scrollTop(),left:0,'z-index':999})
				.appendTo('body');
			el.data('oldtext',el.text()).text('退出全屏').attr('fullwin',1);
		}
		fun({width:obj.width(),height:obj.height()});
	}

	//新窗口预览代码效果
	function winpreviewcode(str)
	{
		var win = window.open(" ");
		win.document.write(jq('#'+str).val());
	}

	//复制内容到剪贴板
	function syscopycontent(str)
	{
		var obj=jq('#'+str)[0];
		obj.select();
		obj.createTextRange().execCommand("Copy");
		alert('已经将模板内容复制到剪贴板!');
	}
	
	function stopDefault( e )
	{
		if ( e && e.preventDefault ){
			e.preventDefault();
		}else{

			window.event.returnValue = false;
		}
		return false;
	}

	//ajax执行相应的页面，并回调提供的函数
	//fun可为函数或者为触发者要改变的名称
	function runtoajax(e,a,fun,href)
	{
		var $a=jq(a);
		jq.ajax({
			url: (href?href:$a.attr('href')),
			data:{ajaxtrue:1},
			cache:false,
			dataType:'html',
			success: function(data){
				if(data.substr(0,3)=='var'){
					var dd=data.substr(3);
					if(typeof(fun)=='function'){
						fun.call($a,dd);
					}else{
						$a.text(fun[dd]);
					}
				}else{
					alert('操作失败');
				}
			}
		}); 
		e && stopDefault(e);
	};
}


function add_att(id, text){
	var length = parseInt($(id).value)+ 1;
	$(id).value = length;
	var str = text + '<br /><input type="text" size="20" name="' + id +'[' + length  + ']" />';
	var cdiv = document.createElement('div');
	cdiv.innerHTML = str;
	$('d_'+id).appendChild(cdiv);	
}

function add_custom(dl){
	//在TABLE增加一行TR
	var custom_frame = document.getElementById('custom_table');
	var custom_length = parseInt(document.getElementById('length').value) + 1;
	document.getElementById('length').value = custom_length;
	var str = document.getElementById('template').innerHTML;
	var newTR = custom_frame.insertRow(custom_frame.rows.length);
	newTR.id = custom_length;
	
	//newTR.innerHTML = innerHTMl//无效
	//很郁闷，TD的innerHTML竟然是只读的， 只能先添加TD后改变TD的innerHTML	
	var newTD0=newTR.insertCell(0);
	newTD0.className = 'altbg1';
	newTD0.innerHTML = '<select sytle="width:150px;" onchange="select_custom(this.value, \'custom_' + custom_length +'\');">' + str +  '</select>&nbsp;&nbsp;<img onmouseover="this.style.cursor=\'pointer\'" style="cursor: pointer;" onclick="add_custom()" src="./image/common/zoomin.gif">&nbsp;&nbsp;<img src="./image/common/zoomout.gif" onclick="delete_custom('+ custom_length +')" style="cursor: pointer;" onmouseover="this.style.cursor=\'pointer\'">';
	
	var newTD1=newTR.insertCell(1);
	newTD1.colSpan='3';
	newTD1.className = 'altbg2';
	newTD1.innerHTML = '<div id="custom_' + custom_length + '"></div>';
}

function delete_custom(id){
	var daleter_tr = document.getElementById(id);
	var custom_frame = document.getElementById('custom_table');

	//获取将要删除的行的Index
	var rowIndex = daleter_tr.rowIndex;

	//删除指定Index的行
	custom_frame.deleteRow(rowIndex);
}

//加强checkbox属性框
//blurNone 隐藏时清空内容
function CheckboxExt(els,op){
	ops={blurNone:0};
	op=jq.extend({},ops,op);
	els.bind('click',op,CheckboxExt_elclick);
	els.each(function(){
		var el=jq(this),aim=el.attr('aim');
		if(el.is(':checked')){
			jq('#'+aim).show();
		}else{
			jq('#'+aim).hide();
		}
	});
}
function CheckboxExt_elclick(e){
	var el=jq(this),aim=el.attr('aim'),bn=e.data.blurNone;
	if(el.is(':checked')){
		jq('#'+aim).show();
	}else{
		jq('#'+aim).hide();
		if(bn){jq('#'+aim).val('');}
	}
}

/**
 * 打印调用URL的内容 
 * @param {Object} url
 */
function printUrlContent(url) {
	jq.get(url,function(data){
		  	var headstr = "<html><head><title></title></head><body>";
			var footstr = "</body>";
		  	var newstr = data;
			var oldstr = document.body.innerHTML;
			document.body.innerHTML = headstr+newstr+footstr;
			window.print();
			setTimeout(function(){
				document.body.innerHTML = oldstr;
			}, 1000 );
			return false;
	})
	
}

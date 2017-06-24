var userAgent = navigator.userAgent.toLowerCase();
var is_opera = userAgent.indexOf('opera') != -1 && opera.version();
var is_ie = (userAgent.indexOf('msie') != -1 && !is_opera) && userAgent.substr(userAgent.indexOf('msie') + 5, 3);
function docomment_form(id) {
	var divid = 'docomment_' + id;
	var showid = 'docomment_form_' + id;
	document.getElementById(divid).style.display = '';
	document.getElementById(showid).innerHTML = '<form method="get" onsubmit="reply(' + id + ');return false;" style="padding-left:10px;">'
	 + '<a href="javascript:void(0)" id="do_face_' + id + '" onclick="showFace(this.id, \'do_message_' + id + '\');return false;"><img src="' + in_path + 'static/user/images/facelist.gif" align="absmiddle"></a>&nbsp;'
	 + '<input type="text" id="do_message_' + id + '" size="35" class="t_input" onkeydown="return ctrlEnter(event, \'docommform_btn_' + id + '\', 1);">&nbsp;'
	 + '<input type="submit" class="submit" id="docommform_btn_' + id + '" value="回复">&nbsp;'
	 + '<button type="button" class="button" onclick="docomment_close(' + id + ');">取消</button>'
	 + '</form>';
}
function docomment_close(id) {
	var showid = 'docomment_form_' + id;
	document.getElementById(showid).innerHTML = '';
}
function showFace(showid, target) {
	var div = document.getElementById('uchome_face_bg');
	if (div) {
		div.parentNode.removeChild(div);
	}
	div = document.createElement('div');
	div.id = 'uchome_face_bg';
	div.style.position = 'absolute';
	div.style.left = div.style.top = '0px';
	div.style.width = '100%';
	div.style.height = document.body.scrollHeight + 'px';
	div.style.backgroundColor = '#FFFFFF';
	div.style.zIndex = 10000;
	div.style.display = 'none';
	div.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=0,finishOpacity=100,style=0)';
	div.style.opacity = 0;
	div.onclick = function() {
		document.getElementById(showid + '_menu').style.display = 'none';
		document.getElementById('uchome_face_bg').style.display = 'none';
	}
	document.getElementById('append_parent').appendChild(div);
	if (document.getElementById(showid + '_menu') != null) {
		document.getElementById(showid + '_menu').style.display = '';
	} else {
		var faceDiv = document.createElement("div");
		faceDiv.id = showid + '_menu';
		faceDiv.className = 'facebox';
		faceDiv.style.position = 'absolute';
		var faceul = document.createElement("ul");
		for (i = 1; i < 31; i++) {
			var faceli = document.createElement("li");
			faceli.innerHTML = '<img src="' + in_path + 'static/user/images/face/' + i + '.gif" onclick="insertFace(\'' + showid + '\',' + i + ', \'' + target + '\')" style="cursor:pointer; position:relative;" />';
			faceul.appendChild(faceli);
		}
		faceDiv.appendChild(faceul);
		document.getElementById('append_parent').appendChild(faceDiv)
	}
	setMenuPosition(showid, 0);
	div.style.display = '';
}
function insertFace(showid, id, target) {
	var faceText = '[em:' + id + ']';
	if (document.getElementById(target) != null) {
		insertContent(target, faceText);
	}
	document.getElementById(showid + '_menu').style.display = 'none';
	document.getElementById('uchome_face_bg').style.display = 'none';
}
function textCounter(obj, showid, maxlimit) {
	var len = strLen(obj.value);
	var showobj = document.getElementById(showid);
	if (len > maxlimit) {
		obj.value = getStrbylen(obj.value, maxlimit);
		showobj.innerHTML = '0';
	} else {
		showobj.innerHTML = maxlimit - len;
	}
	if (maxlimit - len > 0) {
		showobj.parentNode.style.color = "";
	} else {
		showobj.parentNode.style.color = "red";
	}
}
function getStrbylen(str, len) {
	var num = 0;
	var strlen = 0;
	var newstr = "";
	var obj_value_arr = str.split("");
	for (var i = 0; i < obj_value_arr.length; i++) {
		if (i < len && num + byteLength(obj_value_arr[i]) <= len) {
			num += byteLength(obj_value_arr[i]);
			strlen = i + 1;
		}
	}
	if (str.length > strlen) {
		newstr = str.substr(0, strlen);
	} else {
		newstr = str;
	}
	return newstr;
}
function byteLength(sStr) {
	aMatch = sStr.match(/[^\x00-\x80]/g);
	return (sStr.length + (!aMatch ? 0: aMatch.length));
}
function insertContent(target, text) {
	var obj = document.getElementById(target);
	selection = document.selection;
	checkFocus(target);
	if (!isUndefined(obj.selectionStart)) {
		var opn = obj.selectionStart + 0;
		obj.value = obj.value.substr(0, obj.selectionStart) + text + obj.value.substr(obj.selectionEnd);
	} else if (selection && selection.createRange) {
		var sel = selection.createRange();
		sel.text = text;
		sel.moveStart('character', -strlen(text));
	} else {
		obj.value += text;
	}
}
function checkFocus(target) {
	var obj = document.getElementById(target);
	if (!obj.hasfocus) {
		obj.focus();
	}
}
function isUndefined(variable) {
	return typeof variable == 'undefined' ? true: false;
}
function strlen(str) {
	return (is_ie && str.indexOf('\n') != -1) ? str.replace(/\r?\n/g, '_').length: str.length;
}
function ctrlEnter(event, btnId, onlyEnter) {
	if (isUndefined(onlyEnter)) onlyEnter = 0;
	if ((event.ctrlKey || onlyEnter) && event.keyCode == 13) {
		document.getElementById(btnId).click();
		return false;
	}
	return true;
}
function setMenuPosition(showid, offset) {
	var showobj = document.getElementById(showid);
	var menuobj = document.getElementById(showid + '_menu');
	if (isUndefined(offset)) offset = 0;
	if (showobj) {
		showobj.pos = fetchOffset(showobj);
		showobj.X = showobj.pos['left'];
		showobj.Y = showobj.pos['top'];
		showobj.w = showobj.offsetWidth;
		showobj.h = showobj.offsetHeight;
		menuobj.w = menuobj.offsetWidth;
		menuobj.h = menuobj.offsetHeight;
		var sTop = document.documentElement && document.documentElement.scrollTop ? document.documentElement.scrollTop: document.body.scrollTop;
		if (offset != -1) {
			menuobj.style.left = (showobj.X + menuobj.w > document.body.clientWidth) && (showobj.X + showobj.w - menuobj.w >= 0) ? showobj.X + showobj.w - menuobj.w + 'px': showobj.X + 'px';
			menuobj.style.top = offset == 1 ? showobj.Y + 'px': (offset == 2 || ((showobj.Y + showobj.h + menuobj.h > sTop + document.documentElement.clientHeight) && (showobj.Y - menuobj.h >= 0)) ? (showobj.Y - menuobj.h) + 'px': showobj.Y + showobj.h + 'px');
		} else if (offset == -1) {
			menuobj.style.left = (document.body.clientWidth - menuobj.w) / 2 + 'px';
			var divtop = sTop + (document.documentElement.clientHeight - menuobj.h) / 2;
			if (divtop > 100) divtop = divtop - 100;
			menuobj.style.top = divtop + 'px';
		}
		if (menuobj.style.clip && !is_opera) {
			menuobj.style.clip = 'rect(auto, auto, auto, auto)';
		}
	}
}
function fetchOffset(obj) {
	var left_offset = obj.offsetLeft;
	var top_offset = obj.offsetTop;
	while ((obj = obj.offsetParent) != null) {
		left_offset += obj.offsetLeft;
		top_offset += obj.offsetTop;
	}
	return {
		'left': left_offset,
		'top': top_offset
	};
}
function get_week() {
	var objDate = new Date();
	var week = objDate.getDay();
	switch (week) {
	case 0:
		week = '周日';
		break;
	case 1:
		week = '周一';
		break;
	case 2:
		week = '周二';
		break;
	case 3:
		week = '周三';
		break;
	case 4:
		week = '周四';
		break;
	case 5:
		week = '周五';
		break;
	case 6:
		week = '周六';
		break;
	}
	return week;
}
function clock_sign() {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/feed/ajax.php?ac=sign', true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('今日已签到，请明天再来！', {icon: 4});
				} else if (XMLHttpReq.responseText == 'return_3') {
					var in_sign = Number($('in_sign').innerHTML) + 1;
					$('in_sign').innerHTML = in_sign;
					$('day_' + new Date().getDate()).innerHTML = '<ul><li class="dayeventsli">出勤[' + in_points + '][' + in_rank + ']</li></ul>';
					$('day_' + new Date().getDate()).style.display = 'block';
					$('a_' + new Date().getDate()).style.background = '#F7EEB8';
					$('a_' + new Date().getDate()).style.border = '1px solid #E0D486';
					layer.msg('签到成功，已连续打卡' + in_sign + '天！', {icon: 1});
				} else {
					layer.msg('内部出现错误，请稍后再试！', {icon: 5});
				}
			} else {
				layer.msg('通讯异常，请检查网络设置！', {icon: 3});
			}
		}
	}
	XMLHttpReq.send(null);
}
function share_flash() {
	var play = $('share_play').value;
	var intro = $('share_intro').value;
	var format = play.match(/\.(swf)/g);
	if (!format) {
		layer.msg('抱歉，Flash地址解析失败！', {icon: 5});
		$('share_play').focus();
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/feed/ajax.php?ac=share&p=' + escape(play) + '&i=' + escape(intro), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					location.href = guide_url;
				} else {
					layer.msg('内部出现错误，请稍后再试！', {icon: 5});
				}
			} else {
				layer.msg('通讯异常，请检查网络设置！', {icon: 3});
			}
		}
	}
	XMLHttpReq.send(null);
}
function invisible(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/feed/ajax.php?ac=invisible&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					var _text = _id > 0 ? '隐身' : '在线';
					layer.msg('恭喜，切换到' + _text + '状态成功！', {icon: 1});
					setTimeout("location.reload();", 3000);
				} else {
					layer.msg('内部出现错误，请稍后再试！', {icon: 5});
				}
			} else {
				layer.msg('通讯异常，请检查网络设置！', {icon: 3});
			}
		}
	}
	XMLHttpReq.send(null);
}
function doing() {
	var message = $('message').value;
	if (message == '') {
		$('message').focus();
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/feed/ajax.php?ac=do&c=' + escape(message), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					location.href = guide_url;
				} else {
					layer.msg('内部出现错误，请稍后再试！', {icon: 5});
				}
			} else {
				layer.msg('通讯异常，请检查网络设置！', {icon: 3});
			}
		}
	}
	XMLHttpReq.send(null);
}
function deldoing(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/feed/ajax.php?ac=f_del&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					asyncbox.tips("请先登录用户中心！", "wait", 3000);
				} else if (XMLHttpReq.responseText == 'return_2') {
					asyncbox.tips("说说不存在或已被删除！", "error", 3000);
				} else if (XMLHttpReq.responseText == 'return_3') {
					asyncbox.tips("您不能删除别人的说说！", "error", 3000);
				} else if (XMLHttpReq.responseText == 'return_4') {
					asyncbox.tips("恭喜，说说删除成功！", "success", 3000);
					setTimeout("location.reload();", 3000);
				} else {
					asyncbox.tips("内部出现错误，请稍后再试！", "error", 3000);
				}
			} else {
				asyncbox.tips("通讯异常，请检查网络设置！", "error", 3000);
			}
		}
	}
	XMLHttpReq.send(null);
}
function reply(_id) {
	var message = document.getElementById('do_message_' + _id).value;
	if (message == '') {
		document.getElementById('do_message_' + _id).focus();
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/feed/ajax.php?ac=re&id=' + _id + '&c=' + escape(message), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					asyncbox.tips("请先登录用户中心！", "wait", 3000);
				} else if (XMLHttpReq.responseText == 'return_2') {
					asyncbox.tips("说说不存在或已被删除！", "error", 3000);
				} else if (XMLHttpReq.responseText == 'return_3') {
					getreply(_id);
					asyncbox.tips("恭喜，添加回复成功！", "success", 3000);
				} else {
					asyncbox.tips("内部出现错误，请稍后再试！", "error", 3000);
				}
			} else {
				asyncbox.tips("通讯异常，请检查网络设置！", "error", 3000);
			}
		}
	}
	XMLHttpReq.send(null);
}
function delreply(_id, _fid) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/feed/ajax.php?ac=r_del&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					asyncbox.tips("请先登录用户中心！", "wait", 3000);
				} else if (XMLHttpReq.responseText == 'return_2') {
					asyncbox.tips("回复不存在或已被删除！", "error", 3000);
				} else if (XMLHttpReq.responseText == 'return_3') {
					asyncbox.tips("只有说说的主人才能删除回复！", "error", 3000);
				} else if (XMLHttpReq.responseText == 'return_4') {
					getreply(_fid);
					asyncbox.tips("恭喜，回复删除成功！", "success", 3000);
				} else {
					asyncbox.tips("内部出现错误，请稍后再试！", "error", 3000);
				}
			} else {
				asyncbox.tips("通讯异常，请检查网络设置！", "error", 3000);
			}
		}
	}
	XMLHttpReq.send(null);
}
function getreply(_id) {
	var theHttpRequest = getHttpObject();
	theHttpRequest.onreadystatechange = function() {
		processAJAX();
	};
	theHttpRequest.open('GET', in_path + 'source/user/feed/ajax.php?ac=get&id=' + _id, true);
	theHttpRequest.send(null);
	function processAJAX() {
		if (theHttpRequest.readyState == 4) {
			if (theHttpRequest.status == 200) {
				document.getElementById('doreply' + _id).innerHTML = theHttpRequest.responseText;
			} else {
				document.getElementById('doreply' + _id).innerHTML = '加载失败...';
			}
		}
	}
}
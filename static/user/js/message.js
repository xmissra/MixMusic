function sendmessage(name, msg) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/message/ajax.php?ac=add&name=' + escape(name) + '&msg=' + escape(msg), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('用户不存在或已被管理员锁定！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能给自己发短消息！', 3, 8);
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，短消息发送成功！', 3, 1);
				} else {
					layer.msg('内部出现错误，请稍后再试！', 3, 8);
				}
			} else {
				layer.msg('通讯异常，请检查网络设置！', 3, 3);
			}
		}
	}
	XMLHttpReq.send(null);
}
function addmessage() {
	var username = $('username').value;
	if (username == '') {
		layer.msg('收件人不能为空！', {icon: 2});
		$('username').focus();
		return;
	}
	var message = $('message').value;
	if (message == '') {
		layer.msg('内容不能为空！', {icon: 2});
		$('message').focus();
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/message/ajax.php?ac=add&name=' + escape(username) + '&msg=' + escape(message), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('收件人不存在或已被管理员锁定！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('收件人不能是自己！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，短消息发送成功！', {icon: 1});
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
function del_message(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/message/ajax.php?ac=del&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('短消息不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能删除别人的短消息！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，短消息删除成功！', {icon: 1});
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
function set_msg(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/message/ajax.php?ac=set&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					var _text = _id > 0 ? '标记所有未读消息' : '清空所有已读消息';
					layer.msg('恭喜，' + _text + '成功！', {icon: 1});
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
function reply_message(_uid) {
	var message = $('message').value;
	if (message == '') {
		layer.msg('回复内容不能为空！', {icon: 2});
		$('message').focus();
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/message/ajax.php?ac=reply&uid=' + _uid + '&msg=' + escape(message), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('恭喜，短消息回复成功！', {icon: 1});
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
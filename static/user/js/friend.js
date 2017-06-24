function addfriend(name) {
	var msg = document.getElementById('message').value;
	var gid = document.getElementById('groupid');
	if (gid.value < 1) {
		gid.focus();
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/friend/ajax.php?ac=insert&name=' + escape(name) + '&msg=' + escape(msg) + '&gid=' + gid.value, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('用户不存在或已被管理员锁定！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('分组不存在或已被删除！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('您不能添加自己为好友！', 3, 8);
				} else if (XMLHttpReq.responseText == 'return_5') {
					layer.msg('您不能选择别人的分组！', 3, 7);
				} else if (XMLHttpReq.responseText == 'return_6') {
					layer.closeAll();
					layer.msg('恭喜，加为好友成功！', 3, 1);
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
function delfriend(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/friend/ajax.php?ac=f_del&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('好友不存在或已被删除！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能删除别人的好友！', 3, 7);
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，好友删除成功！', 3, 1);
					setTimeout("location.reload();", 3000);
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
function changefriend(_id) {
	var gid = document.getElementById('groupid');
	if (gid.value < 1) {
		gid.focus();
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/friend/ajax.php?ac=change&fid=' + _id + '&gid=' + gid.value, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('好友不存在或已被删除！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('分组不存在或已被删除！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('您不能移动别人的好友！', 3, 7);
				} else if (XMLHttpReq.responseText == 'return_5') {
					layer.msg('您不能选择别人的分组！', 3, 7);
				} else if (XMLHttpReq.responseText == 'return_6') {
					layer.closeAll();
					layer.msg('恭喜，好友移动成功！', 3, 1);
					setTimeout("location.reload();", 3000);
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
function addgroup(title) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/friend/ajax.php?ac=add&title=' + escape(title), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('您已经新建过该分组，请更换分组名称！', 3, 8);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('恭喜，新建分组成功！', 3, 1);
					setTimeout("location.reload();", 3000);
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
function delgroup(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/friend/ajax.php?ac=del&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('分组不存在或已被删除！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能删除别人的分组！', 3, 7);
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，分组删除成功！', 3, 1);
					setTimeout("location.href='" + guide_url + "';", 3000);
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
function edigroup(_id, _title) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/friend/ajax.php?ac=edi&id=' + _id + '&title=' + escape(_title), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('分组不存在或已被删除！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能修改别人的分组！', 3, 7);
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('您已经新建过该分组，请更换分组名称！', 3, 8);
				} else if (XMLHttpReq.responseText == 'return_5') {
					layer.msg('恭喜，分组修改成功！', 3, 1);
					setTimeout("location.reload();", 3000);
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
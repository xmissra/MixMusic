function blogshare(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/blog/ajax.php?ac=share&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('日志不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('恭喜，日志推荐成功！', {icon: 1});
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
function addgroup(title) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/blog/ajax.php?ac=add&title=' + escape(title), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('您已经新建过该分类，请更换分类名称！', 3, 8);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('恭喜，新建分类成功！', 3, 1);
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
	XMLHttpReq.open('GET', in_path + 'source/user/blog/ajax.php?ac=del&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('分类不存在或已被删除！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能删除别人的分类！', 3, 7);
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，分类删除成功！', 3, 1);
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
function editgroup(_id, _title) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/blog/ajax.php?ac=edit&id=' + _id + '&title=' + escape(_title), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('分类不存在或已被删除！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能修改别人的分类！', 3, 7);
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('您已经新建过该分类，请更换分类名称！', 3, 8);
				} else if (XMLHttpReq.responseText == 'return_5') {
					layer.msg('恭喜，分类修改成功！', 3, 1);
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
function addblog(obj) {
	uploadEdit(obj);
	var classid = document.getElementById('classid');
	var title = document.getElementById('title');
	var content = document.getElementById('uchome-ttHtmlEditor').value;
	if (classid.value < 1) {
		layer.msg('请先选择分类！', 3, 11);
		classid.focus();
		return;
	}
	if (title.value == '') {
		layer.msg('标题不能为空！', 3, 11);
		title.focus();
		return;
	}
	if (content == '') {
		layer.msg('内容不能为空！', 3, 11);
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/blog/ajax.php?ac=insert&id=' + classid.value + '&t=' + escape(title.value) + '&c=' + escape(content), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('分类不存在或已被删除！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能选择别人的分类！', 3, 7);
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，日志发表成功！', 3, 1);
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
function delblog(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/blog/ajax.php?ac=cancel&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('日志不存在或已被删除！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能删除别人的日志！', 3, 7);
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，日志删除成功！', 3, 1);
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
function editblog(obj, _id) {
	uploadEdit(obj);
	var classid = document.getElementById('classid');
	var title = document.getElementById('title');
	var content = document.getElementById('uchome-ttHtmlEditor').value;
	if (classid.value < 1) {
		layer.msg('请先选择分类！', 3, 11);
		classid.focus();
		return;
	}
	if (title.value == '') {
		layer.msg('标题不能为空！', 3, 11);
		title.focus();
		return;
	}
	if (content == '') {
		layer.msg('内容不能为空！', 3, 11);
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/blog/ajax.php?ac=change&bid=' + _id + '&gid=' + classid.value + '&t=' + escape(title.value) + '&c=' + escape(content), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('日志不存在或已被删除！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('分类不存在或已被删除！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('您不能编辑别人的日志！', 3, 7);
				} else if (XMLHttpReq.responseText == 'return_5') {
					layer.msg('您不能选择别人的分类！', 3, 7);
				} else if (XMLHttpReq.responseText == 'return_6') {
					layer.msg('恭喜，日志编辑成功！', 3, 1);
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
function dig_blog(_id, _field) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/blog/ajax.php?ac=dig&id=' + _id +'&field=' + _field, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('日志不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能给自己的日志表态！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('您刚刚已经表过态了！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_5') {
					layer.msg('恭喜，您已经表态成功！', {icon: 1});
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
function commentblog(_id) {
	var content = $('content').value;
	if (content == '') {
		layer.msg('评论内容不能为空！', {icon: 2});
		$('content').focus();
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/blog/ajax.php?ac=comment&id=' + _id + '&content=' + escape(content), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('日志不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					$('comment_tips').innerHTML = '每次评论间隔时间不能低于30秒！';
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，您已经评论成功！', {icon: 1});
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
function delcomment(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/blog/ajax.php?ac=c_del&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('评论不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('只有日志的主人才能删除评论！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，评论删除成功！', {icon: 1});
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
function groupshare(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/photo/ajax.php?ac=share&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('相册不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('恭喜，相册推荐成功！', {icon: 1});
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
function addgroup() {
	var photo = $('photo').value;
	if (photo == '') {
		layer.msg('相册名称不能为空！', {icon: 2});
		$('photo').focus();
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/photo/ajax.php?ac=add&photo=' + escape(photo), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('您已经新建过该相册，请更换相册名称！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('恭喜，新建相册成功！', {icon: 1});
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
function delgroup(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/photo/ajax.php?ac=del&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('相册不存在或已被删除！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能删除别人的相册！', 3, 7);
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，相册删除成功！', 3, 1);
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
function editgroup(_id, _title) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/photo/ajax.php?ac=edit&id=' + _id + '&title=' + escape(_title), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('相册不存在或已被删除！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能修改别人的相册！', 3, 7);
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('您已经新建过该相册，请更换相册名称！', 3, 8);
				} else if (XMLHttpReq.responseText == 'return_5') {
					layer.msg('恭喜，相册改名成功！', 3, 1);
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
function coverphoto(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/photo/ajax.php?ac=cover&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('照片不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能设置别人的照片！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，照片设为封面成功！', {icon: 1});
					setTimeout("location.href='" + cover_url + "';", 3000);
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
function delphoto(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/photo/ajax.php?ac=cancel&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('照片不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能删除别人的照片！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，照片删除成功！', {icon: 1});
					setTimeout("location.href='" + del_url + "';", 3000);
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
function editphoto(_id) {
	var gid = $('groupid').value;
	if (gid < 1) {
		$('groupid').focus();
		return;
	}
	var title = $('title').value;
	if (title == '') {
		$('title').focus();
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/photo/ajax.php?ac=change&pid=' + _id + '&gid=' + gid + '&title=' + escape(title), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('照片不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('相册不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('您不能编辑别人的照片！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_5') {
					layer.msg('您不能选择别人的相册！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_6') {
					layer.msg('恭喜，照片编辑成功！', {icon: 1});
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
function dig_photo(_id, _field) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/photo/ajax.php?ac=dig&id=' + _id +'&field=' + _field, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('照片不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能给自己的照片表态！', {icon: 5});
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
function commentphoto(_id) {
	var content = $('content').value;
	if (content == '') {
		layer.msg('评论内容不能为空！', {icon: 2});
		$('content').focus();
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/photo/ajax.php?ac=comment&id=' + _id + '&content=' + escape(content), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('照片不存在或已被删除！', {icon: 2});
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
	XMLHttpReq.open('GET', in_path + 'source/user/photo/ajax.php?ac=c_del&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('评论不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('只有照片的主人才能删除评论！', {icon: 5});
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
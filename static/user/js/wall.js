function spaceshare(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/space/ajax.php?ac=share&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('用户不存在或已被管理员锁定！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('恭喜，用户推荐成功！', 3, 1);
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
function spacewall(_id) {
	var wall = document.getElementById('space_wall').value;
	if (wall == '') {
		document.getElementById('space_wall').focus();
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/space/ajax.php?ac=wall&id=' + _id + '&wall=' + escape(wall), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('用户不存在或已被管理员锁定！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_3') {
					document.getElementById('wall_tips').innerHTML = '每次留言间隔时间不能低于45秒！';
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，您已经留言成功！', 3, 10);
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
function delwall(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/space/ajax.php?ac=w_del&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('留言不存在或已被删除！', 3, 11);
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('只有空间的主人才能删除留言！', 3, 8);
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，留言删除成功！', 3, 10);
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
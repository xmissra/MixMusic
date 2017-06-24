function delvideo(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/video/ajax.php?ac=del&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('视频不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能删除别人的视频！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('您不能删除已审视频！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_5') {
					layer.msg('恭喜，视频删除成功！', {icon: 1});
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
function addvideo() {
	var name = $('in_name').value;
	if (name == '') {
		layer.msg('请填写视频名称！', {icon: 2});
		$('in_name').focus();
		return;
	}
	var classid = $('in_classid').value;
	if (classid == 0) {
		layer.msg('请选择所属分类！', {icon: 2});
		$('in_classid').focus();
		return;
	}
	var play = $('in_play').value;
	if (play == '') {
		layer.msg('请填写视频地址！', {icon: 2});
		$('in_play').focus();
		return;
	}
	var singerid = $('in_singerid').value;
	var cover = $('in_cover').value;
	var intro = $('in_intro').value.replace(/[\r\n]/g, '<br />');
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/video/ajax.php?ac=add&name=' + escape(name) + '&classid=' + classid + '&play=' + escape(play) + '&singerid=' + singerid + '&cover=' + escape(cover) + '&intro=' + escape(intro), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('分类不存在，请重选或刷新页面！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('歌手不存在，请重选或刷新页面！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，视频发布成功！', {icon: 1});
					setTimeout("location.href='" + guide_url + "';", 3000);
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
function editvideo(_id) {
	var name = $('in_name').value;
	if (name == '') {
		layer.msg('请填写视频名称！', {icon: 2});
		$('in_name').focus();
		return;
	}
	var classid = $('in_classid').value;
	if (classid == 0) {
		layer.msg('请选择所属分类！', {icon: 2});
		$('in_classid').focus();
		return;
	}
	var play = $('in_play').value;
	if (play == '') {
		layer.msg('请填写视频地址！', {icon: 2});
		$('in_play').focus();
		return;
	}
	var singerid = $('in_singerid').value;
	var cover = $('in_cover').value;
	var intro = $('in_intro').value.replace(/[\r\n]/g, '<br />');
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/video/ajax.php?ac=edit&id=' + _id + '&name=' + escape(name) + '&classid=' + classid + '&play=' + escape(play) + '&singerid=' + singerid + '&cover=' + escape(cover) + '&intro=' + escape(intro), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('视频不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('分类不存在，请重选或刷新页面！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('歌手不存在，请重选或刷新页面！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_5') {
					layer.msg('您不能编辑别人的视频！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_6') {
					layer.msg('您不能编辑已审视频！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_7') {
					layer.msg('恭喜，视频编辑成功！', {icon: 1});
					setTimeout("location.href='" + guide_url + "';", 3000);
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
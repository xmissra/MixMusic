function delsong(_id, _table) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/music/ajax.php?ac=delete&table=' + _table + '&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				var _text = _table == 'listen' ? '试听' : '收藏';
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg(_text + '记录不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能删除别人的' + _text + '记录！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('恭喜，' + _text + '记录删除成功！', {icon: 1});
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
function delmusic(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/music/ajax.php?ac=del&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('音乐不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能删除别人的音乐！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('您不能删除已审音乐！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_5') {
					layer.msg('恭喜，音乐删除成功！', {icon: 1});
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
function addmusic() {
	var name = document.getElementById('in_name').value;
	if (name == '') {
		layer.msg('请填写音乐名称！', {icon: 2});
		document.getElementById('in_name').focus();
		return;
	}
	var classid = document.getElementById('in_classid').value;
	if (classid == 0) {
		layer.msg('请选择所属分类！', {icon: 2});
		document.getElementById('in_classid').focus();
		return;
	}
	var audio = document.getElementById('in_audio').value;
	if (audio == '') {
		layer.msg('请填写音频地址！', {icon: 2});
		document.getElementById('in_audio').focus();
		return;
	}
	var specialid = document.getElementById('in_specialid').value;
	var singerid = document.getElementById('in_singerid').value;
	var tag = document.getElementById('in_tag').value;
	var cover = document.getElementById('in_cover').value;
	var lyric = document.getElementById('in_lyric').value;
	var text = document.getElementById('in_text').value.replace(/[\r\n]/g, '<br />');
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/music/ajax.php?ac=add&name=' + escape(name) + '&classid=' + classid + '&audio=' + escape(audio) + '&specialid=' + specialid + '&singerid=' + singerid + '&tag=' + escape(tag) + '&cover=' + escape(cover) + '&lyric=' + escape(lyric) + '&text=' + escape(text), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('分类不存在，请重选或刷新页面！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('专辑不存在，请重选或刷新页面！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('歌手不存在，请重选或刷新页面！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_5') {
					layer.msg('恭喜，音乐上传成功！', {icon: 1});
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
function editmusic(_id) {
	var name = document.getElementById('in_name').value;
	if (name == '') {
		layer.msg('请填写音乐名称！', {icon: 2});
		document.getElementById('in_name').focus();
		return;
	}
	var classid = document.getElementById('in_classid').value;
	if (classid == 0) {
		layer.msg('请选择所属分类！', {icon: 2});
		document.getElementById('in_classid').focus();
		return;
	}
	var audio = document.getElementById('in_audio').value;
	if (audio == '') {
		layer.msg('请填写音频地址！', {icon: 2});
		document.getElementById('in_audio').focus();
		return;
	}
	var specialid = document.getElementById('in_specialid').value;
	var singerid = document.getElementById('in_singerid').value;
	var tag = document.getElementById('in_tag').value;
	var cover = document.getElementById('in_cover').value;
	var lyric = document.getElementById('in_lyric').value;
	var text = document.getElementById('in_text').value.replace(/[\r\n]/g, '<br />');
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/music/ajax.php?ac=edit&id=' + _id + '&name=' + escape(name) + '&classid=' + classid + '&audio=' + escape(audio) + '&specialid=' + specialid + '&singerid=' + singerid + '&tag=' + escape(tag) + '&cover=' + escape(cover) + '&lyric=' + escape(lyric) + '&text=' + escape(text), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('音乐不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('分类不存在，请重选或刷新页面！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('专辑不存在，请重选或刷新页面！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_5') {
					layer.msg('歌手不存在，请重选或刷新页面！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_6') {
					layer.msg('您不能编辑别人的音乐！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_7') {
					layer.msg('您不能编辑已审音乐！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_8') {
					layer.msg('恭喜，音乐编辑成功！', {icon: 1});
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
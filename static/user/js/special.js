function delspecial(_id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/special/ajax.php?ac=del&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('专辑不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('您不能删除别人的专辑！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('您不能删除已审专辑！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_5') {
					layer.msg('恭喜，专辑删除成功！', {icon: 1});
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
function addspecial() {
	var name = $('in_name').value;
	if (name == '') {
		layer.msg('请填写专辑名称！', {icon: 2});
		$('in_name').focus();
		return;
	}
	var classid = $('in_classid').value;
	if (classid == 0) {
		layer.msg('请选择所属分类！', {icon: 2});
		$('in_classid').focus();
		return;
	}
	var singerid = $('in_singerid').value;
	var firm = $('in_firm').value;
	var lang = $('in_lang').value;
	var cover = $('in_cover').value;
	var intro = $('in_intro').value.replace(/[\r\n]/g, '<br />');
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/special/ajax.php?ac=add&name=' + escape(name) + '&classid=' + classid + '&singerid=' + singerid + '&firm=' + escape(firm) + '&lang=' + escape(lang) + '&cover=' + escape(cover) + '&intro=' + escape(intro), true);
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
					layer.msg('恭喜，专辑制作成功！', {icon: 1});
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
function editspecial(_id) {
	var name = $('in_name').value;
	if (name == '') {
		layer.msg('请填写专辑名称！', {icon: 2});
		$('in_name').focus();
		return;
	}
	var classid = $('in_classid').value;
	if (classid == 0) {
		layer.msg('请选择所属分类！', {icon: 2});
		$('in_classid').focus();
		return;
	}
	var singerid = $('in_singerid').value;
	var firm = $('in_firm').value;
	var lang = $('in_lang').value;
	var cover = $('in_cover').value;
	var intro = $('in_intro').value.replace(/[\r\n]/g, '<br />');
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/special/ajax.php?ac=edit&id=' + _id + '&name=' + escape(name) + '&classid=' + classid + '&singerid=' + singerid + '&firm=' + escape(firm) + '&lang=' + escape(lang) + '&cover=' + escape(cover) + '&intro=' + escape(intro), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('专辑不存在或已被删除！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('分类不存在，请重选或刷新页面！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('歌手不存在，请重选或刷新页面！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_5') {
					layer.msg('您不能编辑别人的专辑！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_6') {
					layer.msg('您不能编辑已审专辑！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_7') {
					layer.msg('恭喜，专辑编辑成功！', {icon: 1});
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
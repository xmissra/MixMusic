function unconnect() {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/profile/ajax.php?ac=unconnect', true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('恭喜，您已经成功解绑QQ！', {icon: 1});
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
function editprofile() {
	var sex = $('sex').value;
	var province = $('province').value;
	if (province == '') {
		layer.msg('请选择地区[省]！', {icon: 2});
		$('province').focus();
		return;
	}
	var city = $('city').value;
	if (city == '') {
		layer.msg('请选择地区[市]！', {icon: 2});
		$('city').focus();
		return;
	}
	var year = $('year').value;
	if (year == '') {
		layer.msg('请选择生日[年]！', {icon: 2});
		$('year').focus();
		return;
	}
	var month = $('month').value;
	if (month == '') {
		layer.msg('请选择生日[月]！', {icon: 2});
		$('month').focus();
		return;
	}
	var day = $('day').value;
	if (day == '') {
		layer.msg('请选择生日[日]！', {icon: 2});
		$('day').focus();
		return;
	}
	var introduce = $('introduce').value;
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/profile/ajax.php?ac=editprofile&sex=' + sex + '&province=' + escape(province) + '&city=' + escape(city) + '&year=' + year + '&month=' + month + '&day=' + day + '&introduce=' + escape(introduce), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('恭喜，基本资料保存成功！', {icon: 1});
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
function editpassword() {
	var _old = $('_old').value;
	if (_old == '') {
		layer.msg('旧密码不能为空！', {icon: 2});
		$('_old').focus();
		return;
	}
	var _new = $('_new').value;
	if (strLen(_new) < 6) {
		layer.msg('新密码最小长度为 6 个字符。', {icon: 2});
		$('_new').focus();
		return;
	}
	var _news = $('_news').value;
	if (_news !== _new) {
		layer.msg('两次输入的密码不一致！', {icon: 2});
		$('_news').focus();
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/profile/ajax.php?ac=editpassword&old=' + escape(_old) + '&new=' + escape(_news), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('旧密码有误，请重试！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('恭喜，登录密码修改成功！', {icon: 1});
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
function editmail(type) {
	if (type == 1) {
		var mail = $('mail').value;
		if (strLen(mail) < 1 || isEmail(mail) == false) {
			layer.msg('邮箱的格式有误！', {icon: 2});
			$('mail').focus();
			return;
		}
		createXMLHttpRequest();
		XMLHttpReq.open('GET', in_path + 'source/user/profile/ajax.php?ac=editmail&type=1&mail=' + escape(mail), true);
		XMLHttpReq.onreadystatechange = function() {
			if (XMLHttpReq.readyState == 4) {
				if (XMLHttpReq.status == 200) {
					if (XMLHttpReq.responseText == 'return_0') {
						layer.msg('邮件服务功能暂未开启，请联系管理员！', {icon: 5});
					} else if (XMLHttpReq.responseText == 'return_1') {
						layer.msg('请先登录用户中心！', {icon: 2});
					} else if (XMLHttpReq.responseText == 'return_2') {
						layer.msg('邮件已经发出，需等待 30 秒后才可重新发送！', {icon: 4});
					} else if (XMLHttpReq.responseText == 'return_4') {
						layer.msg('恭喜，邮件已经发送成功！', {icon: 1});
					} else {
						layer.msg('抱歉，邮件未能发送成功！', {icon: 5});
					}
				} else {
					layer.msg('通讯异常，请检查网络设置！', {icon: 3});
				}
			}
		}
		XMLHttpReq.send(null);
	} else {
		var password = $('password').value;
		if (password == '') {
			layer.msg('登录密码不能为空！', {icon: 2});
			$('password').focus();
			return;
		}
		var mail = $('mail').value;
		if (strLen(mail) < 1 || isEmail(mail) == false) {
			layer.msg('邮箱的格式有误！', {icon: 2});
			$('mail').focus();
			return;
		}
		var _code = $('_code').value;
		if (_code == '') {
			layer.msg('邮件验证码不能为空！', {icon: 2});
			$('_code').focus();
			return;
		}
		createXMLHttpRequest();
		XMLHttpReq.open('GET', in_path + 'source/user/profile/ajax.php?ac=editmail&type=0&pwd=' + escape(password) + '&mail=' + escape(mail) + '&code=' + _code, true);
		XMLHttpReq.onreadystatechange = function() {
			if (XMLHttpReq.readyState == 4) {
				if (XMLHttpReq.status == 200) {
					if (XMLHttpReq.responseText == 'return_1') {
						layer.msg('请先登录用户中心！', {icon: 2});
					} else if (XMLHttpReq.responseText == 'return_2') {
						layer.msg('登录密码有误，请重试！', {icon: 2});
					} else if (XMLHttpReq.responseText == 'return_3') {
						layer.msg('邮箱已经被占用，请更换一个！', {icon: 5});
					} else if (XMLHttpReq.responseText == 'return_4') {
						layer.msg('邮件验证码无效，请重试！', {icon: 2});
					} else if (XMLHttpReq.responseText == 'return_5') {
						layer.msg('恭喜，邮箱验证成功！', {icon: 1});
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
}
function editverify() {
	var password = $('password').value;
	if (password == '') {
		layer.msg('登录密码不能为空！', {icon: 2});
		$('password').focus();
		return;
	}
	var _name = $('_name').value;
	if (_name == '') {
		layer.msg('真实姓名不能为空！', {icon: 2});
		$('_name').focus();
		return;
	}
	var _cardtype = $('_cardtype').value;
	var _cardnum = $('_cardnum').value;
	if (_cardnum == '') {
		layer.msg('证件号码不能为空！', {icon: 2});
		$('_cardnum').focus();
		return;
	}
	var _address = $('_address').value;
	if (_address == '') {
		layer.msg('联系地址不能为空！', {icon: 2});
		$('_address').focus();
		return;
	}
	var _mobile = $('_mobile').value;
	if (_mobile == '') {
		layer.msg('手机号码不能为空！', {icon: 2});
		$('_mobile').focus();
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/profile/ajax.php?ac=editverify&pwd=' + escape(password) + '&name=' + escape(_name) + '&type=' + escape(_cardtype) + '&num=' + _cardnum + '&address=' + escape(_address) + '&mobile=' + _mobile, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('登录密码有误，请重试！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('恭喜，认证资料提交成功！', {icon: 1});
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
function getvip() {
	var password = $('password').value;
	if (password == '') {
		layer.msg('登录密码不能为空！', {icon: 2});
		$('password').focus();
		return;
	}
	var uname = $('uname').value;
	if (uname == '') {
		layer.msg('用户名不能为空！', {icon: 2});
		$('uname').focus();
		return;
	}
	var vipnum = $('vipnum').value;
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/profile/ajax.php?ac=vip&pwd=' + escape(password) + '&name=' + escape(uname) + '&num=' + vipnum, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_2') {
					layer.msg('登录密码有误，请重试！', {icon: 2});
				} else if (XMLHttpReq.responseText == 'return_3') {
					layer.msg('金币不足，请先充值！', {icon: 5});
				} else if (XMLHttpReq.responseText == 'return_4') {
					layer.msg('用户名不存在，请更改！', {icon: 3});
				} else if (XMLHttpReq.responseText == 'return_5') {
					layer.msg('恭喜，绿钻开通成功！', {icon: 6});
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
function getpay() {
	var _rmb = $('_rmb').value;
	if (_rmb == '') {
		layer.msg('充值金额不能为空！', {icon: 2});
		$('_rmb').focus();
		return;
	}
	if (_rmb == 0) {
		layer.msg('充值金额不能为0！', {icon: 2});
		$('_rmb').focus();
		return;
	}
	var _title = new Date().getTime() + Math.floor(Math.random() * 1000000 + 1);
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/profile/ajax.php?ac=pay&rmb=' + _rmb + '&title=' + _title, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					layer.msg('请先登录用户中心！', {icon: 2});
				} else if ($('_type').value == 'alipay' && XMLHttpReq.responseText == 'return_2') {
					var pay = layer.open({
						type: 2,
						maxmin: true,
						title: '充值金币',
						content: [in_path + 'source/pack/alipay/pay.php?in_title=' + _title, 'yes'],
						area: ['700px', '430px'],
						offset: '100px',
						shade: false
					});
					layer.full(pay);
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
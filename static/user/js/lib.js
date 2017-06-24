function createXMLHttpRequest() {
	try {
		XMLHttpReq = new ActiveXObject('Msxml2.XMLHTTP');
	} catch(e) {
		try {
			XMLHttpReq = new ActiveXObject('Microsoft.XMLHTTP');
		} catch(e) {
			XMLHttpReq = new XMLHttpRequest();
		}
	}
}
function getHttpObject() {
	var objType = false;
	try {
		objType = new ActiveXObject('Msxml2.XMLHTTP');
	} catch(e) {
		try {
			objType = new ActiveXObject('Microsoft.XMLHTTP');
		} catch(e) {
			objType = new XMLHttpRequest();
		}
	}
	return objType;
}
function uc_syn(type) {
	var theHttpRequest = getHttpObject();
	theHttpRequest.onreadystatechange = function() {
		processAJAX();
	};
	theHttpRequest.open('GET', in_path + 'source/user/people/syn.php?uc=' + type, true);
	theHttpRequest.send(null);
	function processAJAX() {
		if (theHttpRequest.readyState == 4) {
			if (theHttpRequest.status == 200) {
				var src = theHttpRequest.responseText.match(/src=".*?"/g);
				if (src) {
					for (i = 0; i < src.length; i++) {
						theHttpRequest = getHttpObject();
						theHttpRequest.open('GET', src[i].match(/src="([^"]*)"/)[1], true);
						theHttpRequest.send(null);
					}
				}
			}
		}
	}
}
function processResponse() {
	if (XMLHttpReq.readyState == 4) {
		if (XMLHttpReq.status == 200) {
			var tips = XMLHttpReq.responseText;
			if (tips == 'return_0') {
				asyncbox.tips("邮件服务功能暂未开启，请联系管理员！", "wait", 3000);
			} else if (tips == 'return_1') {
				asyncbox.tips("验证码不正确，请更改！", "error", 3000);
			} else if (tips == 'return_2') {
				asyncbox.tips("登录信息不存在或已失效，请重新获取！", "error", 3000);
			} else if (tips == 'return_3') {
				asyncbox.tips("抱歉，该QQ号码已经被其它帐号绑定过！", "error", 3000);
			} else if (tips == 'return_4') {
				uc_syn('login');
				asyncbox.tips("激活成功并已完成绑定！", "success", 500);
				setTimeout("location.href='" + guide_url + "';", 1000);
			} else if (tips == 'return_5') {
				uc_syn('login');
				asyncbox.tips("恭喜，您已经成功激活帐号！", "success", 500);
				setTimeout("location.href='" + guide_url + "';", 1000);
			} else if (tips == 'return_6') {
				asyncbox.tips("抱歉，您的帐号已经被锁定！", "wait", 3000);
			} else if (tips == 'return_7') {
				uc_syn('login');
				asyncbox.tips("您的帐号已经绑定过其它QQ号码，请先解除绑定！", "error", 500);
				setTimeout("location.href='" + guide_url + "';", 1000);
			} else if (tips == 'return_8') {
				uc_syn('login');
				asyncbox.tips("恭喜，您已经成功完成绑定！", "success", 500);
				setTimeout("location.href='" + guide_url + "';", 1000);
			} else if (tips == 'return_9') {
				uc_syn('login');
				asyncbox.tips("恭喜，您已经成功登录本站！", "success", 500);
				setTimeout("location.href='" + guide_url + "';", 1000);
			} else if (tips == 'return_10') {
				asyncbox.tips("帐号或密码错误，请重试！", "error", 3000);
			} else if (tips == 'return_11') {
				asyncbox.tips("用户名已经被注册，请更换一个！", "error", 3000);
			} else if (tips == 'return_12') {
				asyncbox.tips("邮箱已经被占用，请更换一个！", "error", 3000);
			} else if (tips == 'return_13') {
				asyncbox.tips("UCenter API: 用户名不合法！", "error", 3000);
			} else if (tips == 'return_14') {
				asyncbox.tips("UCenter API: 包含不允许注册的词语！", "error", 3000);
			} else if (tips == 'return_15') {
				asyncbox.tips("UCenter API: 用户名已经存在！", "error", 3000);
			} else if (tips == 'return_16') {
				asyncbox.tips("UCenter API: Email 格式有误！", "error", 3000);
			} else if (tips == 'return_17') {
				asyncbox.tips("UCenter API: Email 不允许注册！", "error", 3000);
			} else if (tips == 'return_18') {
				asyncbox.tips("UCenter API: Email 已经被注册！", "error", 3000);
			} else if (tips == 'return_19') {
				asyncbox.tips("UCenter API: 错误未定义！", "error", 3000);
			} else if (tips == 'return_20') {
				asyncbox.tips("恭喜，您已经成功注册帐号！", "success", 2500);
				setTimeout("location.href='" + guide_url + "';", 3000);
			} else if (tips == 'return_21') {
				asyncbox.tips("用户名不存在，请更换再试！", "error", 3000);
			} else if (tips == 'return_22') {
				asyncbox.tips("验证信息不匹配，请重试！", "error", 3000);
			} else if (tips == 'return_23') {
				lostpasswd(2);
			} else if (tips == 'return_24') {
				asyncbox.tips("重设地址不存在或已失效，请重新验证！", "wait", 3000);
			} else if (tips == 'return_25') {
				asyncbox.tips("恭喜，您已经成功重设密码！", "success", 1500);
				setTimeout("location.href='" + guide_url + "';", 2000);
			} else {
				asyncbox.tips("内部出现错误，请稍后再试！", "error", 3000);
			}
		} else {
			asyncbox.tips("通讯异常，请检查网络设置！", "error", 3000);
		}
	}
}
function login(type) {
	var username = $('username').value;
	if (strLen(username) < 1) {
		if (type < 2) {
		        $('username_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;&nbsp;请输入用户名！';
		}
		$('username').focus();
		return;
	} else {
		if (type < 2) {
		        $('username_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_right.gif" />';
		}
	}
	var password = $('password').value;
	if (strLen(password) < 1) {
		if (type < 2) {
		        $('password_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;&nbsp;请输入密码！';
		}
		$('password').focus();
		return;
	} else {
		if (type < 2) {
		        $('password_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_right.gif" />';
		}
	}
	var seccode = $('seccode').value;
	if (strLen(seccode) < 4) {
		if (type < 2) {
		        $('seccode_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;&nbsp;请输入四位验证码！';
		}
		$('seccode').focus();
		return;
	} else {
		if (type < 2) {
		        $('seccode_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_right.gif" />';
		}
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/people/ajax.php?ac=login&qq=' + type + '&name=' + escape(username) + '&pwd=' + escape(password) + '&code=' + seccode, true);
	XMLHttpReq.onreadystatechange = processResponse;
	XMLHttpReq.send(null);
}
function register() {
	var username = $('username').value;
	if (strLen(username) < 3 || strLen(username) > 15 || !/^([\S])*$/.test(username) || !/^([^<>'"\/\\])*$/.test(username)) {
		$('username_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;&nbsp;由 3 到 15 个字符组成，不能有空格或 < > \' " / \\ 等字符。';
		$('username').focus();
		return;
	} else {
		$('username_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_right.gif" />';
	}
	var password = $('password').value;
	if (strLen(password) < 6) {
		$('password_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;&nbsp;最小长度为 6 个字符。';
		$('password').focus();
		return;
	} else {
		$('password_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_right.gif" />';
	}
	var password1 = $('password1').value;
	if (password1 !== password) {
		$('password1_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;&nbsp;两次输入的密码不一致！';
		$('password1').focus();
		return;
	} else {
		$('password1_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_right.gif" />';
	}
	var mail = $('mail').value;
	if (strLen(mail) < 1 || isEmail(mail) == false) {
		$('mail_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;&nbsp;填写的 Email 格式有误！';
		$('mail').focus();
		return;
	} else {
		$('mail_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_right.gif" />';
	}
	var seccode = $('seccode').value;
	if (strLen(seccode) < 4) {
		$('seccode_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;&nbsp;请输入四位验证码！';
		$('seccode').focus();
		return;
	} else {
		$('seccode_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_right.gif" />';
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/people/ajax.php?ac=register&name=' + escape(username) + '&pwd=' + escape(password1) + '&mail=' + escape(mail) + '&code=' + seccode, true);
	XMLHttpReq.onreadystatechange = processResponse;
	XMLHttpReq.send(null);
}
function lostpasswd(type) {
	if (type == 1) {
		var username = $('username').value;
		if (strLen(username) < 1) {
			$('username_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;&nbsp;请输入用户名！';
			$('username').focus();
			return;
		} else {
			$('username_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_right.gif" />';
		}
		var mail = $('mail').value;
		if (strLen(mail) < 1 || isEmail(mail) == false) {
			$('mail_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;&nbsp;填写的 Email 格式有误！';
			$('mail').focus();
			return;
		} else {
			$('mail_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_right.gif" />';
		}
		var seccode = $('seccode').value;
		if (strLen(seccode) < 4) {
			$('seccode_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;&nbsp;请输入四位验证码！';
			$('seccode').focus();
			return;
		} else {
			$('seccode_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_right.gif" />';
		}
		createXMLHttpRequest();
		XMLHttpReq.open('GET', in_path + 'source/user/people/ajax.php?ac=lostpasswd&type=1&name=' + escape(username) + '&mail=' + escape(mail) + '&code=' + seccode, true);
		XMLHttpReq.onreadystatechange = processResponse;
		XMLHttpReq.send(null);
	} else if (type == 2) {
		$('_tips').innerHTML = '<span><img src="' + in_path + 'static/user/images/loading.gif" />&nbsp;Loading...</span>';
		createXMLHttpRequest();
		XMLHttpReq.open('GET', in_path + 'source/user/people/ajax.php?ac=lostpasswd&type=2', true);
		XMLHttpReq.onreadystatechange = function() {
			if (XMLHttpReq.readyState == 4) {
				if (XMLHttpReq.status == 200) {
					if (XMLHttpReq.responseText == 'return_26') {
						$('_tips').innerHTML = '<span style="color:#3B5998;font-weight:bold;">邮件已经发出，需等待 30 秒后才可重新发送！</span>';
					} else if (XMLHttpReq.responseText == 'return_28') {
						$('_tips').innerHTML = '<span style="color:green;font-weight:bold;">恭喜，邮件已经发送成功！</span>';
					} else {
						$('_tips').innerHTML = '<span style="color:red;font-weight:bold;">抱歉，邮件未能发送成功！</span>';
					}
				} else {
					asyncbox.tips("通讯异常，请检查网络设置！", "error", 3000);
				}
			}
		}
		XMLHttpReq.send(null);
	} else {
		var password = $('password').value;
		if (strLen(password) < 6) {
			$('password_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;&nbsp;最小长度为 6 个字符。';
			$('password').focus();
			return;
		} else {
			$('password_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_right.gif" />';
		}
		var password1 = $('password1').value;
		if (password1 !== password) {
			$('password1_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;&nbsp;两次输入的密码不一致！';
			$('password1').focus();
			return;
		} else {
			$('password1_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_right.gif" />';
		}
		var seccode = $('seccode').value;
		if (strLen(seccode) < 4) {
			$('seccode_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;&nbsp;请输入四位验证码！';
			$('seccode').focus();
			return;
		} else {
			$('seccode_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_right.gif" />';
		}
		var uid = $('uid').value;
		var ucode = $('ucode').value;
		createXMLHttpRequest();
		XMLHttpReq.open('GET', in_path + 'source/user/people/ajax.php?ac=lostpasswd&type=0&pwd=' + escape(password1) + '&uid=' + uid + '&ucode=' + ucode + '&code=' + seccode, true);
		XMLHttpReq.onreadystatechange = processResponse;
		XMLHttpReq.send(null);
	}
}
function strLen(str) {
	var charset = document.charset;
	var len = 0;
	for (var i = 0; i < str.length; i++) {
		len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == 'gbk' ? 3: 2) : 1;
	}
	return len;
}
function isEmail(input) {
	if (input.match(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/)) {
		return true;
	}
	return false;
}
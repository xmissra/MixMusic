(function() {
	lib = {
		s_earch: function(_type, _id) {
			var keyword = document.getElementById(_id).value.replace(/\//g, '');
			keyword = keyword.replace(/\\/g, '');
			keyword = keyword.replace(/\?/g, '');
			var _url = search_url.replace(/table/g, _type);
			_url = _url.replace(/target/g, keyword);
			if (keyword == '') {
				asyncbox.tips("请输入查询的关键字！", "wait", 1000);
				document.getElementById(_id).focus();
				return;
			} else {
				location.href = _url;
			}
		},
		add_play: function(_id, _type) {
			send_box($('#' + _type + '_' + _id).val());
		},
		all_play: function(_ids) {
			if (_ids) {
				_ids = _ids + ']';
				_ids = _ids.replace(/\/\]/g, '');
				_ids = play_url.replace(/player/g, _ids);
				window.open(_ids);
			}
		},
		quanxuan: function(obj) {
			with(document.getElementById(obj)) {
				var ins = getElementsByTagName('input');
				for (var i = 0; i < ins.length; i++) {
					ins[i].checked = !ins[i].checked;
				}
			}
		},
		player: function(objName, objType) {
			var mIdSrt = '';
			$('#' + objName + ' :checkbox').each(function() {
				if ($(this).attr('checked')) {
					mIdSrt += $(this).val() + ',';
				}
			});
			if (mIdSrt) {
				if (objType == 'box') {
					send_box(mIdSrt.substr(0, mIdSrt.length - 1));
				} else {
					var _ids = mIdSrt.substr(0, mIdSrt.length - 1);
					_ids = _ids.replace(/\,/g, '/');
					_ids = play_url.replace(/player/g, _ids);
					window.open(_ids);
				}
			} else {
				var _text = objType == 'box' ? '加入列表' : '播放';
				asyncbox.tips("请选择要" + _text + "的歌曲！", "wait", 1000);
			}
		}
	}
})();
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
function getavatar() {
	var theHttpRequest = getHttpObject();
	theHttpRequest.onreadystatechange = function() {
		processAJAX();
	};
	theHttpRequest.open('GET', temp_url + 'source/ajax_avatar.php', true);
	theHttpRequest.send(null);
	function processAJAX() {
		if (theHttpRequest.readyState == 4) {
			if (theHttpRequest.status == 200) {
				document.getElementById('wall').innerHTML = theHttpRequest.responseText;
			} else {
				document.getElementById('wall').innerHTML = '加载失败...';
			}
		}
	}
}
function getlogin() {
	var theHttpRequest = getHttpObject();
	theHttpRequest.onreadystatechange = function() {
		processAJAX();
	};
	theHttpRequest.open('GET', temp_url + 'source/ajax_login.php', true);
	theHttpRequest.send(null);
	function processAJAX() {
		if (theHttpRequest.readyState == 4) {
			if (theHttpRequest.status == 200) {
				document.getElementById('userinfo').innerHTML = theHttpRequest.responseText;
			} else {
				document.getElementById('userinfo').innerHTML = '加载失败...';
			}
		}
	}
}
function getlisten() {
	var theHttpRequest = getHttpObject();
	theHttpRequest.onreadystatechange = function() {
		processAJAX();
	};
	theHttpRequest.open('GET', temp_url + 'source/ajax_listen.php?ac=ajax', true);
	theHttpRequest.send(null);
	function processAJAX() {
		if (theHttpRequest.readyState == 4) {
			if (theHttpRequest.status == 200) {
				document.getElementById('listen').innerHTML = theHttpRequest.responseText;
			} else {
				document.getElementById('listen').innerHTML = '加载失败...';
			}
		}
	}
}
function his_del(_do, _id) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', temp_url + 'source/ajax_listen.php?ac=hisdel&do=' + _do + '&id=' + _id, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_0') {
					asyncbox.tips("请先登录用户中心！", "wait", 1000);
				} else if (XMLHttpReq.responseText == 'return_1') {
					asyncbox.tips("试听记录不存在或已被删除！", "error", 3000);
				} else if (XMLHttpReq.responseText == 'return_2') {
					asyncbox.tips("您不能删除别人的试听记录！", "error", 3000);
				} else if (XMLHttpReq.responseText == 'return_3') {
					asyncbox.tips("恭喜，试听记录移除成功！", "success", 1000);
				} else if (XMLHttpReq.responseText == 'return_4') {
					asyncbox.tips("恭喜，试听记录清空完成！", "success", 3000);
				} else {
					asyncbox.tips("内部出现错误，请稍后再试！", "error", 3000);
				}
				getlisten();
			} else {
				asyncbox.tips("通讯异常，请检查网络设置！", "error", 3000);
			}
		}
	}
	XMLHttpReq.send(null);
}
function getbox(_id) {
	var theHttpRequest = getHttpObject();
	theHttpRequest.onreadystatechange = function() {
		processAJAX();
	};
	theHttpRequest.open('GET', temp_url + 'source/ajax_box.php?id=' + _id, true);
	theHttpRequest.send(null);
	function processAJAX() {
		if (theHttpRequest.readyState == 4) {
			if (theHttpRequest.status == 200) {
				document.getElementById('jp-playlist-box').innerHTML = theHttpRequest.responseText;
			} else {
				document.getElementById('jp-playlist-box').innerHTML = '加载失败...';
			}
		}
	}
}
function getdohits(_id) {
	var theHttpRequest = getHttpObject();
	theHttpRequest.onreadystatechange = function() {
		processAJAX();
	};
	theHttpRequest.open('GET', temp_url + 'source/ajax_like.php?ac=goodbad&id=' + _id, true);
	theHttpRequest.send(null);
	function processAJAX() {
		if (theHttpRequest.readyState == 4) {
			if (theHttpRequest.status == 200) {
				document.getElementById('like').innerHTML = theHttpRequest.responseText;
			} else {
				document.getElementById('like').innerHTML = '加载失败...';
			}
		}
	}
}
function up_down(_id, _do) {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', temp_url + 'source/ajax_like.php?ac=dohits&id=' + _id + '&do=' + _do, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					asyncbox.tips("音乐不存在或已被删除！", "error", 3000);
				} else if (XMLHttpReq.responseText == 'return_2') {
					asyncbox.tips("您刚刚已经评价过了！", "wait", 1000);
				} else if (XMLHttpReq.responseText == 'return_3') {
					asyncbox.tips("恭喜，您已经评价成功！", "success", 1000);
				} else {
					asyncbox.tips("内部出现错误，请稍后再试！", "error", 3000);
				}
				getdohits(_id);
			} else {
				asyncbox.tips("通讯异常，请检查网络设置！", "error", 3000);
			}
		}
	}
	XMLHttpReq.send(null);
}
function getplay() {
	var theHttpRequest = getHttpObject();
	theHttpRequest.onreadystatechange = function() {
		processAJAX();
	};
	theHttpRequest.open('GET', temp_url + 'source/ajax_play.php', true);
	theHttpRequest.send(null);
	function processAJAX() {
		if (theHttpRequest.readyState == 4) {
			if (theHttpRequest.status == 200) {
				document.getElementById('play').innerHTML = theHttpRequest.responseText;
			} else {
				document.getElementById('play').innerHTML = '加载失败...';
			}
		}
	}
}
function getbitrate(_id) {
	var theHttpRequest = getHttpObject();
	theHttpRequest.onreadystatechange = function() {
		processAJAX();
	};
	theHttpRequest.open('GET', temp_url + 'source/ajax.php?ac=kbps&id=' + _id, true);
	theHttpRequest.send(null);
	function processAJAX() {
		if (theHttpRequest.readyState == 4) {
			if (theHttpRequest.status == 200) {
				document.getElementById('kbps').innerHTML = theHttpRequest.responseText;
			} else {
				document.getElementById('kbps').innerHTML = '加载失败...';
			}
		}
	}
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
function logout() {
	createXMLHttpRequest();
	XMLHttpReq.open('GET', temp_url + 'source/ajax.php?ac=logout', true);
	XMLHttpReq.onreadystatechange = processResponse;
	XMLHttpReq.send(null);
}
function processResponse() {
	if (XMLHttpReq.readyState == 4) {
		if (XMLHttpReq.status == 200) {
			var tips = XMLHttpReq.responseText;
			if (tips == 'return_0') {
				asyncbox.tips("邮件服务功能暂未开启，请联系管理员！", "wait", 3000);
			} else if (tips == 'return_1') {
				asyncbox.tips("验证码不正确，请更改！", "error", 3000);
			} else if (tips == 'return_5') {
				uc_syn('login');
				asyncbox.tips("恭喜，您已经成功激活帐号！", "success", 500);
				setTimeout("location.href='" + in_path + "';", 1000);
			} else if (tips == 'return_6') {
				asyncbox.tips("抱歉，您的帐号已经被锁定！", "wait", 3000);
			} else if (tips == 'return_9') {
				uc_syn('login');
				asyncbox.tips("恭喜，您已经成功登录本站！", "success", 500);
				setTimeout("location.href='" + in_path + "';", 1000);
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
				setTimeout("location.href='" + in_path + "';", 3000);
			} else if (tips == 'return_21') {
				asyncbox.tips("用户名不存在，请更换再试！", "error", 3000);
			} else if (tips == 'return_22') {
				asyncbox.tips("验证信息不匹配，请重试！", "error", 3000);
			} else if (tips == 'return_23') {
				lostpasswd(2);
			} else if (tips == 'logout') {
				uc_syn('logout');
				getlogin();
				asyncbox.tips("您已经安全退出了！", "wait", 1000);
			} else {
				asyncbox.tips("内部出现错误，请稍后再试！", "error", 3000);
			}
		} else {
			asyncbox.tips("通讯异常，请检查网络设置！", "error", 3000);
		}
	}
}
function login(type) {
	var username = document.getElementById('username');
	var password = document.getElementById('password');
	var seccode = document.getElementById('seccode');
	if (strLen(username.value) < 1) {
		username.focus();
		return;
	} else if (strLen(password.value) < 1) {
		password.focus();
		return;
	} else if (strLen(seccode.value) < 4) {
		document.getElementById('_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;请输入四位验证码！';
		seccode.focus();
		return;
	} else {
		document.getElementById('_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_right.gif" />';
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/people/ajax.php?ac=login&qq=' + type + '&name=' + escape(username.value) + '&pwd=' + escape(password.value) + '&code=' + seccode.value, true);
	XMLHttpReq.onreadystatechange = processResponse;
	XMLHttpReq.send(null);
}
function register() {
	var username = document.getElementById('username');
	if (strLen(username.value) < 3 || strLen(username.value) > 15 || !/^([\S])*$/.test(username.value) || !/^([^<>'"\/\\])*$/.test(username.value)) {
		document.getElementById('username_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;由 3 到 15 个字符组成，不能有空格或 < > \' " / \\ 等字符。';
		username.focus();
		return;
	} else {
		document.getElementById('username_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_right.gif" />';
	}
	var password = document.getElementById('password');
	if (strLen(password.value) < 6) {
		document.getElementById('password_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;最小长度为 6 个字符。';
		password.focus();
		return;
	} else {
		document.getElementById('password_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_right.gif" />';
	}
	var password1 = document.getElementById('password1');
	if (password1.value !== password.value) {
		document.getElementById('password1_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;两次输入的密码不一致！';
		password1.focus();
		return;
	} else {
		document.getElementById('password1_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_right.gif" />';
	}
	var mail = document.getElementById('mail');
	if (strLen(mail.value) < 1 || isEmail(mail.value) == false) {
		document.getElementById('mail_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;填写的 Email 格式有误！';
		mail.focus();
		return;
	} else {
		document.getElementById('mail_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_right.gif" />';
	}
	var seccode = document.getElementById('seccode');
	if (strLen(seccode.value) < 4) {
		document.getElementById('seccode_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;请输入四位验证码！';
		seccode.focus();
		return;
	} else {
		document.getElementById('seccode_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_right.gif" />';
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', in_path + 'source/user/people/ajax.php?ac=register&name=' + escape(username.value) + '&pwd=' + escape(password1.value) + '&mail=' + escape(mail.value) + '&code=' + seccode.value, true);
	XMLHttpReq.onreadystatechange = processResponse;
	XMLHttpReq.send(null);
}
function lostpasswd(type) {
	if (type == 1) {
		var username = document.getElementById('username');
		if (strLen(username.value) < 1) {
			document.getElementById('username_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;请输入用户名！';
			username.focus();
			return;
		} else {
			document.getElementById('username_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_right.gif" />';
		}
		var mail = document.getElementById('mail');
		if (strLen(mail.value) < 1 || isEmail(mail.value) == false) {
			document.getElementById('mail_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;填写的 Email 格式有误！';
			mail.focus();
			return;
		} else {
			document.getElementById('mail_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_right.gif" />';
		}
		var seccode = document.getElementById('seccode');
		if (strLen(seccode.value) < 4) {
			document.getElementById('seccode_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;请输入四位验证码！';
			seccode.focus();
			return;
		} else {
			document.getElementById('seccode_tips').innerHTML = '<img src="' + in_path + 'static/user/images/check_right.gif" />';
		}
		createXMLHttpRequest();
		XMLHttpReq.open('GET', in_path + 'source/user/people/ajax.php?ac=lostpasswd&type=1&name=' + escape(username.value) + '&mail=' + escape(mail.value) + '&code=' + seccode.value, true);
		XMLHttpReq.onreadystatechange = processResponse;
		XMLHttpReq.send(null);
	} else if (type == 2) {
		createXMLHttpRequest();
		XMLHttpReq.open('GET', in_path + 'source/user/people/ajax.php?ac=lostpasswd&type=2', true);
		XMLHttpReq.onreadystatechange = function() {
			if (XMLHttpReq.readyState == 4) {
				if (XMLHttpReq.status == 200) {
					if (XMLHttpReq.responseText == 'return_26') {
						document.getElementById('_notice').innerHTML = '<div class="error">邮件已经发出，需等待 30 秒后才可重新发送！</div>';
					} else if (XMLHttpReq.responseText == 'return_28') {
						document.getElementById('_notice').innerHTML = '<div class="success">恭喜，邮件已经发送成功！</div>';
					} else {
						document.getElementById('_notice').innerHTML = '<div class="error">抱歉，邮件未能发送成功！</div>';
					}
				} else {
					asyncbox.tips("通讯异常，请检查网络设置！", "error", 3000);
				}
			}
		}
		XMLHttpReq.send(null);
	}
}
function mod_diange(_id) {
	var name = document.getElementById('name');
	var mail = document.getElementById('mail');
	var message = document.getElementById('message');
	var friend = document.getElementById('friend');
	if (name.value.length < 1) {
		asyncbox.tips("Ta的名字不能为空！", "error", 1000);
		name.focus();
		return;
	} else if (mail.value.length < 1) {
		asyncbox.tips("Ta的邮箱不能为空！", "error", 1000);
		mail.focus();
		return;
	} else if (isEmail(mail.value) == false) {
		asyncbox.tips("Ta的邮箱格式错误！", "error", 1000);
		mail.focus();
		return;
	} else if (message.value.length < 10) {
		asyncbox.tips("对Ta说的话至少10个字！", "error", 1000);
		message.focus();
		return;
	} else if (message.value.length > 100) {
		asyncbox.tips("最多输入100个字！", "error", 1000);
		message.focus();
		return;
	} else if (friend.value.length < 1) {
		asyncbox.tips("你的名字不能为空！", "error", 1000);
		friend.focus();
		return;
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', temp_url + 'source/ajax.php?ac=diange&id=' + _id + '&name=' + escape(name.value) + '&mail=' + escape(mail.value) + '&message=' + escape(message.value) + '&friend=' + escape(friend.value), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_0') {
					asyncbox.tips("邮件服务功能暂未开启，请联系管理员！", "wait", 3000);
				} else if (XMLHttpReq.responseText == 'return_1') {
					asyncbox.tips("音乐不存在或已被删除！", "error", 3000);
				} else if (XMLHttpReq.responseText == 'return_3') {
					asyncbox.tips("点歌成功！稍后对方会收到一份惊喜喔！", "success", 3000);
				} else {
					asyncbox.tips("点歌失败，请重试！", "error", 3000);
				}
			} else {
				asyncbox.tips("通讯异常，请检查网络设置！", "error", 3000);
			}
		}
	}
	XMLHttpReq.send(null);
}
function mod_wrong(_id) {
	var _seccode = document.getElementById('_seccode');
	if (strLen(_seccode.value) < 4) {
		document.getElementById('_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;&nbsp;请输入四位验证码！';
		_seccode.focus();
		return;
	} else {
		document.getElementById('_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_right.gif" />';
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', temp_url + 'source/ajax.php?ac=wrong&id=' + _id + '&seccode=' + _seccode.value, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_1') {
					asyncbox.tips("验证码不正确，请更改！", "error", 3000);
				} else if (XMLHttpReq.responseText == 'return_2') {
					asyncbox.tips("音乐不存在或已被删除！", "error", 3000);
				} else if (XMLHttpReq.responseText == 'return_3') {
					asyncbox.tips("报错成功，感谢您的反馈！", "success", 1000);
				} else {
					asyncbox.tips("内部出现错误，请稍后再试！", "error", 3000);
				}
			} else {
				asyncbox.tips("通讯异常，请检查网络设置！", "error", 3000);
			}
		}
	}
	XMLHttpReq.send(null);
}
function mod_fav(_id) {
	var _seccode = document.getElementById('_seccode');
	if (strLen(_seccode.value) < 4) {
		document.getElementById('_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_error.gif" />&nbsp;&nbsp;请输入四位验证码！';
		_seccode.focus();
		return;
	} else {
		document.getElementById('_tips').innerHTML = '&nbsp;&nbsp;<img src="' + in_path + 'static/user/images/check_right.gif" />';
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', temp_url + 'source/ajax.php?ac=fav&id=' + _id + '&seccode=' + _seccode.value, true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_0') {
					asyncbox.tips("请先登录用户中心！", "wait", 1000);
				} else if (XMLHttpReq.responseText == 'return_1') {
					asyncbox.tips("验证码不正确，请更改！", "error", 3000);
				} else if (XMLHttpReq.responseText == 'return_2') {
					asyncbox.tips("音乐不存在或已被删除！", "error", 3000);
				} else if (XMLHttpReq.responseText == 'return_3') {
					asyncbox.tips("收藏成功，即将跳转到我的歌单！", "success", 2500);
					setTimeout("location.href='" + guide_url + "';", 3000);
				} else {
					asyncbox.tips("内部出现错误，请稍后再试！", "error", 3000);
				}
			} else {
				asyncbox.tips("通讯异常，请检查网络设置！", "error", 3000);
			}
		}
	}
	XMLHttpReq.send(null);
}
function send_comment(_id) {
	var _content = document.getElementById('_content').value;
	if (strLen(_content) < 6) {
		document.getElementById('_tips').innerHTML = '评论内容最少<em>6</em>个字符！';
		return;
	} else if (strLen(_content) > 128) {
		document.getElementById('_tips').innerHTML = '评论内容最多<em>128</em>个字符！';
		return;
	} else {
		document.getElementById('_tips').innerHTML = '请<em>文明</em>发言！';
	}
	createXMLHttpRequest();
	XMLHttpReq.open('GET', temp_url + 'source/ajax.php?ac=comment&id=' + _id + '&content=' + escape(_content), true);
	XMLHttpReq.onreadystatechange = function() {
		if (XMLHttpReq.readyState == 4) {
			if (XMLHttpReq.status == 200) {
				if (XMLHttpReq.responseText == 'return_0') {
					asyncbox.tips("请先登录用户中心！", "wait", 1000);
				} else if (XMLHttpReq.responseText == 'return_1') {
					asyncbox.tips("音乐不存在或已被删除！", "error", 3000);
				} else if (XMLHttpReq.responseText == 'return_2') {
					document.getElementById('_tips').innerHTML = '每次评论间隔时间为<em>30</em>秒！';
				} else if (XMLHttpReq.responseText == 'return_3') {
					window.location.reload();
				} else {
					asyncbox.tips("内部出现错误，请稍后再试！", "error", 3000);
				}
			} else {
				asyncbox.tips("通讯异常，请检查网络设置！", "error", 3000);
			}
		}
	}
	XMLHttpReq.send(null);
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
(function() {
        lib = {
                s_earch:function(kid) {
                        var keyword = document.getElementById(kid).value.replace(/\//g, "");
                        keyword = keyword.replace(/\\/g, "");
                        keyword = keyword.replace(/\?/g, "");
                        var _url = search_url.replace(/target/g, keyword);
                        if (keyword == "" || keyword == "找到好音乐") {
                                lib.t_ips("请输入要查找的关键词！", 0, 3e3);
                                document.getElementById(kid).focus();
                                return;
                        } else {
                                location.href = _url;
                        }
                },
                quanxuan:function(obj) {
                        with (document.getElementById(obj)) {
                                var ins = getElementsByTagName("input");
                                for (var i = 0; i < ins.length; i++) {
                                        ins[i].checked = !ins[i].checked;
                                }
                        }
                },
                t_ips:function(text, type, time) {
                        var top = document.body.scrollTop + document.documentElement.scrollTop + 300;
                        document.getElementById("error_tips").style.top = top + "px";
                        document.getElementById("error_tips").style.display = "";
                        document.getElementById("error_tips_content").style.background = type ? "#0dad51" :"#525c5f";
                        document.getElementById("error_message").innerHTML = text;
                        setTimeout("document.getElementById('error_tips').style.display = 'none';", time);
                },
                s_onblur:function() {
                        setTimeout("document.getElementById('getsearch').style.display = 'none';", 500);
                }
        };
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
                objType = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
                try {
                        objType = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                        objType = new XMLHttpRequest();
                }
        }
        return objType;
}
function get_search(key) {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", temp_url + "source/ajax_search.php?key=" + escape(key), true);
        theHttpRequest.send(null);
        function processAJAX() {
                if (theHttpRequest.readyState == 4) {
                        if (theHttpRequest.status == 200) {
                                document.getElementById("getsearch").innerHTML = theHttpRequest.responseText;
                        } else {
                                document.getElementById("getsearch").innerHTML = "载入异常...";
                        }
                        document.getElementById("getsearch").style.display = "";
                }
        }
}
function get_player(_ids, _fid) {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", temp_url + "source/ajax_player.php?type=get&id=" + _ids + "&fid=" + _fid, true);
        theHttpRequest.send(null);
        function processAJAX() {
                if (theHttpRequest.readyState == 4) {
                        if (theHttpRequest.status == 200) {
                                document.getElementById("jp-playlist-box").innerHTML = theHttpRequest.responseText;
                        } else {
                                document.getElementById("jp-playlist-box").innerHTML = "载入异常...";
                        }
                }
        }
}
function get_login() {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", temp_url + "source/ajax_login.php", true);
        theHttpRequest.send(null);
        function processAJAX() {
                if (theHttpRequest.readyState == 4) {
                        if (theHttpRequest.status == 200) {
                                document.getElementById("getlogin").innerHTML = theHttpRequest.responseText;
                        } else {
                                document.getElementById("getlogin").innerHTML = "载入异常...";
                        }
                }
        }
}
function get_info() {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", temp_url + "source/ajax_info.php", true);
        theHttpRequest.send(null);
        function processAJAX() {
                if (theHttpRequest.readyState == 4) {
                        if (theHttpRequest.status == 200) {
                                document.getElementById("getinfo").innerHTML = theHttpRequest.responseText;
                        } else {
                                document.getElementById("getinfo").innerHTML = "载入异常...";
                        }
                }
        }
}
function get_comment(_id, _pid) {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", temp_url + "source/ajax_comment.php?id=" + _id + "&pid=" + _pid, true);
        theHttpRequest.send(null);
        function processAJAX() {
                if (theHttpRequest.readyState == 4) {
                        if (theHttpRequest.status == 200) {
                                document.getElementById("comment_tab").innerHTML = theHttpRequest.responseText;
                        } else {
                                document.getElementById("comment_tab").innerHTML = "载入异常...";
                        }
                }
        }
}
function get_like(_id) {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", temp_url + "source/ajax_like.php?ac=get&id=" + _id, true);
        theHttpRequest.send(null);
        function processAJAX() {
                if (theHttpRequest.readyState == 4) {
                        if (theHttpRequest.status == 200) {
                                document.getElementById("like").innerHTML = theHttpRequest.responseText;
                        } else {
                                document.getElementById("like").innerHTML = "载入异常...";
                        }
                }
        }
}
function create_like(_id, _do) {
        createXMLHttpRequest();
        XMLHttpReq.open("GET", temp_url + "source/ajax_like.php?ac=create&id=" + _id + "&do=" + _do, true);
        XMLHttpReq.onreadystatechange = function() {
                if (XMLHttpReq.readyState == 4) {
                        if (XMLHttpReq.status == 200) {
                                if (XMLHttpReq.responseText == "return_1") {
                                        lib.t_ips("音乐不存在或已被删除！", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_2") {
                                        lib.t_ips("您刚刚已经评价过了！", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_3") {
                                        lib.t_ips("恭喜，您已经评价成功！", 1, 1e3);
                                } else {
                                        lib.t_ips("内部出现错误，请稍后再试！", 0, 3e3);
                                }
                                get_like(_id);
                        } else {
                                lib.t_ips("通讯异常，请检查网络设置！", 0, 3e3);
                        }
                }
        };
        XMLHttpReq.send(null);
}
function create_fav(_id) {
        createXMLHttpRequest();
        XMLHttpReq.open("GET", temp_url + "source/ajax.php?ac=fav&id=" + _id, true);
        XMLHttpReq.onreadystatechange = function() {
                if (XMLHttpReq.readyState == 4) {
                        if (XMLHttpReq.status == 200) {
                                if (XMLHttpReq.responseText == "return_0") {
                                        lib.t_ips("请先登录用户中心！", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_1") {
                                        lib.t_ips("音乐不存在或已被删除！", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_2") {
                                        lib.t_ips("恭喜，音乐收藏成功！", 1, 1e3);
                                } else {
                                        lib.t_ips("内部出现错误，请稍后再试！", 0, 3e3);
                                }
                        } else {
                                lib.t_ips("通讯异常，请检查网络设置！", 0, 3e3);
                        }
                }
        };
        XMLHttpReq.send(null);
}
function create_down(_id) {
        createXMLHttpRequest();
        XMLHttpReq.open("GET", temp_url + "source/ajax.php?ac=down&id=" + _id, true);
        XMLHttpReq.onreadystatechange = function() {
                if (XMLHttpReq.readyState == 4) {
                        if (XMLHttpReq.status == 200) {
                                if (XMLHttpReq.responseText == "return_0") {
                                        lib.t_ips("请先登录用户中心！", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_1") {
                                        lib.t_ips("权限不够，请开通绿钻！", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_2") {
                                        lib.t_ips("金币不足，请先充值！", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_3") {
                                        lib.t_ips("音乐不存在或已被删除！", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_4") {
                                        location.href = temp_url + "source/audio.php?id=" + _id;
                                } else {
                                        lib.t_ips("内部出现错误，请稍后再试！", 0, 3e3);
                                }
                        } else {
                                lib.t_ips("通讯异常，请检查网络设置！", 0, 3e3);
                        }
                }
        };
        XMLHttpReq.send(null);
}
function uc_syn(type) {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", in_path + "source/user/people/syn.php?uc=" + type, true);
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
        XMLHttpReq.open("GET", temp_url + "source/ajax.php?ac=logout", true);
        XMLHttpReq.onreadystatechange = processResponse;
        XMLHttpReq.send(null);
}
function processResponse() {
        if (XMLHttpReq.readyState == 4) {
                if (XMLHttpReq.status == 200) {
                        var tips = XMLHttpReq.responseText;
                        if (tips == "return_0") {
                                lib.t_ips("邮件服务功能暂未开启，请联系管理员！", 0, 3e3);
                        } else if (tips == "return_1") {
                                lib.t_ips("验证码不正确，请更改！", 0, 3e3);
                        } else if (tips == "return_5") {
                                uc_syn("login");
                                lib.t_ips("恭喜，您已经成功激活帐号！", 1, 1e3);
                                setTimeout("parent.location.href='" + in_path + "';", 1e3);
                        } else if (tips == "return_6") {
                                lib.t_ips("抱歉，您的帐号已经被锁定！", 0, 3e3);
                        } else if (tips == "return_9") {
                                uc_syn("login");
                                lib.t_ips("恭喜，您已经成功登录本站！", 1, 1e3);
                                setTimeout("parent.location.href='" + in_path + "';", 1e3);
                        } else if (tips == "return_10") {
                                lib.t_ips("帐号或密码错误，请重试！", 0, 3e3);
                        } else if (tips == "return_11") {
                                lib.t_ips("用户名已经被注册，请更换一个！", 0, 3e3);
                        } else if (tips == "return_12") {
                                lib.t_ips("邮箱已经被占用，请更换一个！", 0, 3e3);
                        } else if (tips == "return_13") {
                                lib.t_ips("UCenter API: 用户名不合法！", 0, 3e3);
                        } else if (tips == "return_14") {
                                lib.t_ips("UCenter API: 包含不允许注册的词语！", 0, 3e3);
                        } else if (tips == "return_15") {
                                lib.t_ips("UCenter API: 用户名已经存在！", 0, 3e3);
                        } else if (tips == "return_16") {
                                lib.t_ips("UCenter API: Email 格式有误！", 0, 3e3);
                        } else if (tips == "return_17") {
                                lib.t_ips("UCenter API: Email 不允许注册！", 0, 3e3);
                        } else if (tips == "return_18") {
                                lib.t_ips("UCenter API: Email 已经被注册！", 0, 3e3);
                        } else if (tips == "return_19") {
                                lib.t_ips("UCenter API: 错误未定义！", 0, 3e3);
                        } else if (tips == "return_20") {
                                lib.t_ips("恭喜，您已经成功注册帐号！", 1, 1e3);
                                setTimeout("location.href='" + in_path + "';", 1e3);
                        } else if (tips == "return_21") {
                                lib.t_ips("用户名不存在，请更换再试！", 0, 3e3);
                        } else if (tips == "return_22") {
                                lib.t_ips("验证信息不匹配，请重试！", 0, 3e3);
                        } else if (tips == "return_23") {
                                lostpasswd(2);
                        } else if (tips == "logout") {
                                uc_syn("logout");
                                get_login();
                                lib.t_ips("您已经安全退出了！", 1, 1e3);
                        } else {
                                lib.t_ips("内部出现错误，请稍后再试！", 0, 3e3);
                        }
                } else {
                        lib.t_ips("通讯异常，请检查网络设置！", 0, 3e3);
                }
        }
}
function login(type) {
        var username = document.getElementById("username");
        var password = document.getElementById("password");
        var seccode = document.getElementById("seccode");
        if (strLen(username.value) < 1) {
                lib.t_ips("用户名不能为空！", 0, 3e3);
                username.focus();
                return;
        } else if (strLen(password.value) < 1) {
                lib.t_ips("密码不能为空！", 0, 3e3);
                password.focus();
                return;
        } else if (strLen(seccode.value) != 4) {
                lib.t_ips("请输入四位验证码！", 0, 3e3);
                seccode.focus();
                return;
        }
        createXMLHttpRequest();
        XMLHttpReq.open("GET", in_path + "source/user/people/ajax.php?ac=login&qq=" + type + "&name=" + escape(username.value) + "&pwd=" + escape(password.value) + "&code=" + seccode.value, true);
        XMLHttpReq.onreadystatechange = processResponse;
        XMLHttpReq.send(null);
}
function register() {
        var username = document.getElementById("username");
        if (strLen(username.value) < 3 || strLen(username.value) > 15 || !/^([\S])*$/.test(username.value) || !/^([^<>'"\/\\])*$/.test(username.value)) {
                document.getElementById("username_tips").innerHTML = "<i>由 3 到 15 个字符组成，不能有空格或 < > ' \" / \\ 等字符。</i>";
                username.focus();
                return;
        } else {
                document.getElementById("username_tips").innerHTML = "";
        }
        var password = document.getElementById("password");
        if (strLen(password.value) < 6) {
                document.getElementById("password_tips").innerHTML = "<i>最小长度为 6 个字符。</i>";
                password.focus();
                return;
        } else {
                document.getElementById("password_tips").innerHTML = "";
        }
        var password1 = document.getElementById("password1");
        if (password1.value !== password.value) {
                document.getElementById("password1_tips").innerHTML = "<i>两次输入的密码不一致！</i>";
                password1.focus();
                return;
        } else {
                document.getElementById("password1_tips").innerHTML = "";
        }
        var mail = document.getElementById("mail");
        if (strLen(mail.value) < 1 || isEmail(mail.value) == false) {
                document.getElementById("mail_tips").innerHTML = "<i>填写的 Email 格式有误！</i>";
                mail.focus();
                return;
        } else {
                document.getElementById("mail_tips").innerHTML = "";
        }
        var seccode = document.getElementById("seccode");
        if (strLen(seccode.value) != 4) {
                document.getElementById("seccode_tips").innerHTML = "&nbsp;&nbsp;请输入四位验证码！";
                seccode.focus();
                return;
        } else {
                document.getElementById("seccode_tips").innerHTML = "";
        }
        createXMLHttpRequest();
        XMLHttpReq.open("GET", in_path + "source/user/people/ajax.php?ac=register&name=" + escape(username.value) + "&pwd=" + escape(password1.value) + "&mail=" + escape(mail.value) + "&code=" + seccode.value, true);
        XMLHttpReq.onreadystatechange = processResponse;
        XMLHttpReq.send(null);
}
function lostpasswd(type) {
        if (type == 1) {
                var username = document.getElementById("username");
                if (strLen(username.value) < 1) {
                        document.getElementById("username_tips").innerHTML = "<i>请输入用户名！</i>";
                        username.focus();
                        return;
                } else {
                        document.getElementById("username_tips").innerHTML = "";
                }
                var mail = document.getElementById("mail");
                if (strLen(mail.value) < 1 || isEmail(mail.value) == false) {
                        document.getElementById("mail_tips").innerHTML = "<i>填写的 Email 格式有误！</i>";
                        mail.focus();
                        return;
                } else {
                        document.getElementById("mail_tips").innerHTML = "";
                }
                var seccode = document.getElementById("seccode");
                if (strLen(seccode.value) != 4) {
                        document.getElementById("seccode_tips").innerHTML = "&nbsp;&nbsp;请输入四位验证码！";
                        seccode.focus();
                        return;
                } else {
                        document.getElementById("seccode_tips").innerHTML = "";
                }
                createXMLHttpRequest();
                XMLHttpReq.open("GET", in_path + "source/user/people/ajax.php?ac=lostpasswd&type=1&name=" + escape(username.value) + "&mail=" + escape(mail.value) + "&code=" + seccode.value, true);
                XMLHttpReq.onreadystatechange = processResponse;
                XMLHttpReq.send(null);
        } else if (type == 2) {
                createXMLHttpRequest();
                XMLHttpReq.open("GET", in_path + "source/user/people/ajax.php?ac=lostpasswd&type=2", true);
                XMLHttpReq.onreadystatechange = function() {
                        if (XMLHttpReq.readyState == 4) {
                                if (XMLHttpReq.status == 200) {
                                        if (XMLHttpReq.responseText == "return_26") {
                                                lib.t_ips("邮件已经发出，需等待 30 秒后才可重新发送！", 0, 3e3);
                                        } else if (XMLHttpReq.responseText == "return_28") {
                                                lib.t_ips("恭喜，邮件已经发送成功！", 1, 1e3);
                                        } else {
                                                lib.t_ips("抱歉，邮件未能发送成功！", 0, 3e3);
                                        }
                                } else {
                                        lib.t_ips("通讯异常，请检查网络设置！", 0, 3e3);
                                }
                        }
                };
                XMLHttpReq.send(null);
        }
}
function send_comment(_id) {
        var _content = document.getElementById("_content").value;
        if (strLen(_content) < 6) {
                document.getElementById("_tips").innerHTML = "评论内容最少<em>6</em>个字符！";
                return;
        } else if (strLen(_content) > 128) {
                document.getElementById("_tips").innerHTML = "评论内容最多<em>128</em>个字符！";
                return;
        } else {
                document.getElementById("_tips").innerHTML = "请<em>文明</em>发言！";
        }
        createXMLHttpRequest();
        XMLHttpReq.open("GET", temp_url + "source/ajax.php?ac=comment&id=" + _id + "&content=" + escape(_content), true);
        XMLHttpReq.onreadystatechange = function() {
                if (XMLHttpReq.readyState == 4) {
                        if (XMLHttpReq.status == 200) {
                                if (XMLHttpReq.responseText == "return_0") {
                                        lib.t_ips("请先登录用户中心！", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_1") {
                                        lib.t_ips("音乐不存在或已被删除！", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_2") {
                                        document.getElementById("_tips").innerHTML = "每次评论间隔时间为<em>30</em>秒！";
                                } else if (XMLHttpReq.responseText == "return_3") {
                                        get_comment(_id, 1);
                                        lib.t_ips("恭喜，评论发表成功！", 1, 1e3);
                                } else {
                                        lib.t_ips("内部出现错误，请稍后再试！", 0, 3e3);
                                }
                        } else {
                                lib.t_ips("通讯异常，请检查网络设置！", 0, 3e3);
                        }
                }
        };
        XMLHttpReq.send(null);
}
function strLen(str) {
        var charset = document.charset;
        var len = 0;
        for (var i = 0; i < str.length; i++) {
                len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? charset == "gbk" ? 3 :2 :1;
        }
        return len;
}
function isEmail(input) {
        if (input.match(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/)) {
                return true;
        }
        return false;
}
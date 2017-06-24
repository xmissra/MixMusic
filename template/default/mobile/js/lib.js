(function() {
        lib = {
                s_earch:function(_type) {
                        var keyword = document.getElementById("keyword").value.replace(/\//g, "");
                        keyword = keyword.replace(/\\/g, "");
                        keyword = keyword.replace(/\?/g, "");
                        var _url = search_url.replace(/table/g, _type);
                        _url = _url.replace(/target/g, keyword);
                        if (keyword == "" || keyword == "搜索音乐" || keyword == "搜索专辑" || keyword == "搜索歌手" || keyword == "搜索视频") {
                                document.getElementById("keyword").value = "";
                                document.getElementById("keyword").focus();
                                return;
                        } else {
                                location.href = _url;
                        }
                },
                t_ips:function(text, type, time) {
                        document.getElementById("error_tips").style.display = "";
                        document.getElementById("error_tips_content").style.background = type ? "#0dad51" :"#525c5f";
                        document.getElementById("error_message").innerHTML = text;
                        setTimeout("document.getElementById('error_tips').style.display = 'none';", time);
                }
        };
})();
function getpage(now, last, down) {
	if (now == last) {
		document.getElementById("loaded").style.cursor = "";
		document.getElementById("loaded").innerHTML = "已加载全部";
	} else {
		location.href = down;
	}
}
function getplay(play) {
	if (play.match(/\.(swf)/g)) {
		object = "<embed src='" + play + "' quality='high' width='100%' height='334' align='middle' allowscriptaccess='always' allowfullscreen='true' type='application/x-shockwave-flash'></embed>";
	} else {
		object = "<video autoplay='autoplay' controls='controls' width='100%' src='" + play + "'></video>";
	}
	return object;
}
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
function processResponse() {
        if (XMLHttpReq.readyState == 4) {
                if (XMLHttpReq.status == 200) {
                        var tips = XMLHttpReq.responseText;
                        if (tips == "return_5") {
                                lib.t_ips("恭喜，您已经成功激活帐号！", 1, 1e3);
                                setTimeout("history.go(-2);", 1e3);
                        } else if (tips == "return_6") {
                                lib.t_ips("抱歉，您的帐号已经被锁定！", 0, 3e3);
                        } else if (tips == "return_9") {
                                lib.t_ips("恭喜，您已经成功登录本站！", 1, 1e3);
                                setTimeout("history.go(-2);", 1e3);
                        } else if (tips == "return_10") {
                                lib.t_ips("帐号或密码错误，请重试！", 0, 3e3);
                        } else {
                                lib.t_ips("内部出现错误，请稍后再试！", 0, 3e3);
                        }
                } else {
                        lib.t_ips("通讯异常，请检查网络设置！", 0, 3e3);
                }
        }
}
function ginRequest(type) {
        var _name = document.getElementById("login-name").value;
        var _pwd = document.getElementById("login-pwd").value;
        if (_name == "") {
                lib.t_ips("请输入登录帐号！", 0, 1e3);
                return;
        } else if (_pwd == "") {
                lib.t_ips("请输入登录密码！", 0, 1e3);
                return;
        }
        createXMLHttpRequest();
        XMLHttpReq.open("GET", in_path + "source/user/people/ajax.php?ac=login&qq=" + type + "&name=" + escape(_name) + "&pwd=" + escape(_pwd), true);
        XMLHttpReq.onreadystatechange = processResponse;
        XMLHttpReq.send(null);
}
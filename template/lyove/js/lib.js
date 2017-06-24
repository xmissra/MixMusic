(function() {
        lib = {
                egg:function(_id) {
                        var left = parseInt($("span.msg").offset().left), top = parseInt($("span.msg").offset().top), lefts = parseInt($("span.hits").offset().left), tops = parseInt($("span.hits").offset().top);
                        $("span.msg").hide();
                        $("div.play_zhuan").append('<span class="tips">+1</span>');
                        $("span.tips").css({
                                position:"absolute",
                                "z-index":"1",
                                color:"#ff5500",
                                left:left + "px",
                                top:top + "px"
                        }).animate({
                                top:tops,
                                left:lefts
                        }, "slow", function() {
                                $("span.tips").fadeIn("fast").remove();
                                getlove(_id, "good");
                                getlove(_id, "bad");
                        });
                },
                init:function() {
                        this.search({
                                inputid:"#sq",
                                btn:"#hsearch",
                                lid:"#st",
                                selected_a:"#search_option_selected a",
                                list:"#search_option_list"
                        });
                        this.search({
                                inputid:"#footsq",
                                btn:"#fsearch",
                                lid:"#footst",
                                selected_a:"#footsearch_option_selected a",
                                list:"#footsearch_option_list"
                        });
                },
                tab:function(options) {
                        var settings = $.extend({
                                id:"",
                                actcss:"tab_act",
                                nolcss:"tab_nol",
                                idpre:"#tabMenu_Content"
                        }, options || {});
                        var $this = $(settings.id);
                        var $$this = $this.children();
                        return $$this.each(function() {
                                $(this).click(function() {
                                        var idx = $(this).index();
                                        var len = $$this.length;
                                        if ($(this).attr("class") == settings.actcss) return;
                                        $$this.eq(idx).removeClass(settings.nolcss).addClass(settings.actcss).siblings().removeClass(settings.actcss).addClass(settings.nolcss);
                                        for (var i = 0; i < len; i++) {
                                                if (idx == i) {
                                                        $(settings.idpre + i).show();
                                                } else {
                                                        $(settings.idpre + i).hide();
                                                }
                                        }
                                });
                        });
                },
                scroll:function(options) {
                        var settings = $.extend({
                                rightid:"",
                                leftid:"",
                                wndid:"",
                                contid:"",
                                type:"left",
                                ftx:"li",
                                num:3
                        }, options || {});
                        var page = 1;
                        $(settings.rightid).click(function() {
                                var $pictureShow = $(settings.wndid);
                                var downwidth = settings.type == "top" ? $pictureShow.height() :$pictureShow.width();
                                var len = $(settings.contid).find(settings.ftx).length;
                                var page_number = Math.ceil(len / settings.num);
                                if (!$(settings.contid).is(":animated")) {
                                        if (page == page_number) {
                                                if (settings.type == "top") {
                                                        $(settings.contid).animate({
                                                                top:"0px"
                                                        }, "slow");
                                                } else {
                                                        $(settings.contid).animate({
                                                                left:"0px"
                                                        }, "slow");
                                                }
                                                page = 1;
                                        } else {
                                                if (settings.type == "top") {
                                                        $(settings.contid).animate({
                                                                top:"-=" + downwidth
                                                        }, "slow");
                                                } else {
                                                        $(settings.contid).animate({
                                                                left:"-=" + downwidth
                                                        }, "slow");
                                                }
                                                page++;
                                        }
                                }
                        });
                        $(settings.leftid).click(function() {
                                var $pictureShow = $(settings.wndid);
                                var downwidth = settings.type == "top" ? $pictureShow.height() :$pictureShow.width();
                                var len = $(settings.contid).find(settings.ftx).length;
                                var page_number = Math.ceil(len / settings.num);
                                if (!$(settings.contid).is(":animated")) {
                                        if (page == 1) {
                                                if (settings.type == "top") {
                                                        $(settings.contid).animate({
                                                                top:"-=" + downwidth * (page_number - 1)
                                                        }, "slow");
                                                } else {
                                                        $(settings.contid).animate({
                                                                left:"-=" + downwidth * (page_number - 1)
                                                        }, "slow");
                                                }
                                                page = page_number;
                                        } else {
                                                if (settings.type == "top") {
                                                        $(settings.contid).animate({
                                                                top:"+=" + downwidth
                                                        }, "slow");
                                                } else {
                                                        $(settings.contid).animate({
                                                                left:"+=" + downwidth
                                                        }, "slow");
                                                }
                                                page--;
                                        }
                                }
                        });
                },
                select:function(options) {
                        var settings = $.extend({
                                id:"",
                                name:"",
                                value_id:""
                        }, options || {});
                        var $this = $(settings.id);
                        $('input[name="' + settings.name + '"]').each(function() {
                                $(this).click(function() {
                                        var k = i = 0;
                                        var str = _str = "";
                                        $('input[name="' + settings.name + '"]').each(function() {
                                                if ($(this).attr("checked") == "checked") {
                                                        k++;
                                                        _str += $(this).val() + ",";
                                                }
                                                i++;
                                        });
                                        str = _str.substr(0, _str.length - 1);
                                        $this.attr("checked", k == i ? true :false);
                                        $(settings.value_id).val(str);
                                });
                        });
                        return $this.click(function() {
                                var flag = $(this).attr("checked") == "checked" ? true :false;
                                var str = _str = "";
                                $('input[name="' + settings.name + '"]').each(function() {
                                        $(this).attr("checked", flag);
                                        if (flag) _str += $(this).val() + ",";
                                });
                                str = _str.substr(0, _str.length - 1);
                                $(settings.value_id).val(str);
                        });
                },
                search:function(options) {
                        var settings = $.extend({
                                inputid:"",
                                btn:"",
                                lid:"",
                                selected_a:"#search_option_selected a",
                                list:"#search_option_list",
                                css:"selected"
                        }, options || {});
                        $(settings.selected_a).click(function() {
                                $(settings.list).toggle();
                                $(this).blur();
                        });
                        $(settings.list + " li a").click(function() {
                                $(this).blur().parent("li").addClass(settings.css).siblings("li.selected").removeClass(settings.css);
                                $(settings.selected_a).text($(this).text());
                                $(settings.list).hide();
                                $(settings.inputid).focus();
                        });
                        $(settings.inputid).keyup(function(event) {
                                if (event.keyCode == 13) {
                                        $(settings.btn).click();
                                }
                        }).focus(function() {
                                if ($.trim($(this).val()) == "请输入查询关键字！") {
                                        $(this).val("");
                                }
                        }).blur(function() {
                                if ($.trim($(this).val()) == "") {
                                        $(this).val("请输入查询关键字！");
                                }
                        });
                        $(settings.btn).click(function() {
                                var k = $(settings.inputid), v = $(settings.lid).text(), b = {
                                        "音乐":"music",
                                        "专辑":"special",
                                        "歌手":"singer",
                                        "视频":"video"
                                }[v] || "1", d = $.trim(k.val());
                                d = d.replace(/\//g, "");
                                d = d.replace(/\\/g, "");
                                d = d.replace(/\?/g, "");
                                var _url = search_url.replace(/target/g, d);
                                _url = _url.replace(/table/g, b);
                                if (d.length == 0 || d == "请输入查询关键字！") {
                                        k.val("请输入查询关键字！");
                                        k.focus();
                                        return false;
                                }
                                location.href = _url;
                                return true;
                        });
                },
                musicPlayer:function(ids) {
                        ids = ids.replace(/\,/g, "/");
                        ids = play_url.replace(/player/g, ids);
                        window.open(ids);
                },
                playerObj:function(obj) {
                        var mIdSrt = "";
                        $("#" + obj + " :checkbox").each(function() {
                                if ($(this).attr("checked")) {
                                        mIdSrt += $(this).val() + "/";
                                }
                        });
                        if (mIdSrt) {
                                var ids = mIdSrt.substr(0, mIdSrt.length - 1);
                                ids = play_url.replace(/player/g, ids);
                                window.open(ids);
                        } else {
                                asyncbox.tips("试听列表为空！", "wait", 1e3);
                        }
                },
                hover:function(options) {
                        var settings = $.extend({
                                id:".mcln_list li",
                                css:"hover"
                        }, options || {});
                        $(settings.id).hover(function() {
                                $(this).addClass(settings.css);
                        }, function() {
                                $(this).removeClass(settings.css);
                        });
                },
                menu:function(options) {
                        var settings = $.extend({
                                id:"li.mainlevel",
                                nid:".nol_nav"
                        }, options || {});
                        $(settings.id).mousemove(function() {
                                $(this).find("ul").show();
                                $(settings.nid).hide();
                        }).mouseleave(function() {
                                $(this).find("ul").hide();
                                $(settings.nid).show();
                        });
                },
                submit:function(options) {
                        var settings = $.extend({
                                id:"",
                                formid:""
                        }, options || {});
                        $(settings.id).click(function() {
                                $(settings.formid).submit();
                        });
                },
                toggle:function(options) {
                        var settings = $.extend({
                                id:"",
                                lid:"",
                                cid:"",
                                height:"100px",
                                hcss:"itemsHide",
                                scss:"itemsShow"
                        }, options || {});
                        $(settings.id).toggle(function() {
                                $(this).addClass(settings.hcss).removeClass(settings.scss);
                                $(settings.lid).css("height", $(settings.cid).height());
                        }, function() {
                                $(this).addClass(settings.scss).removeClass(settings.hcss);
                                $(settings.lid).css("height", settings.height);
                        });
                }
        };
})();
$(function() {
        lib.init();
        $("a").bind("focus", function() {
                if (this.blur) {
                        this.blur();
                }
        });
});
function processResponse() {
        if (XMLHttpReq.readyState == 4) {
                if (XMLHttpReq.status == 200) {
                        var tips = XMLHttpReq.responseText;
                        if (tips == "return_0") {
                                asyncbox.tips("邮件服务功能暂未开启，请联系管理员！", "wait", 3e3);
                        } else if (tips == "return_5") {
                                $.close("login");
                                uc_syn("login");
                                get_login();
                        } else if (tips == "return_6") {
                                asyncbox.tips("抱歉，您的帐号已经被锁定！", "wait", 3e3);
                        } else if (tips == "return_9") {
                                $.close("login");
                                uc_syn("login");
                                get_login();
                        } else if (tips == "return_10") {
                                asyncbox.tips("帐号或密码错误，请重试！", "error", 3e3);
                        } else if (tips == "return_11") {
                                asyncbox.tips("帐号已经被注册，请更换一个！", "error", 3e3);
                        } else if (tips == "return_12") {
                                asyncbox.tips("邮箱已经被占用，请更换一个！", "error", 3e3);
                        } else if (tips == "return_13") {
                                asyncbox.tips("UCenter API: 用户名不合法！", "error", 3e3);
                        } else if (tips == "return_14") {
                                asyncbox.tips("UCenter API: 包含不允许注册的词语！", "error", 3e3);
                        } else if (tips == "return_15") {
                                asyncbox.tips("UCenter API: 用户名已经存在！", "error", 3e3);
                        } else if (tips == "return_16") {
                                asyncbox.tips("UCenter API: Email 格式有误！", "error", 3e3);
                        } else if (tips == "return_17") {
                                asyncbox.tips("UCenter API: Email 不允许注册！", "error", 3e3);
                        } else if (tips == "return_18") {
                                asyncbox.tips("UCenter API: Email 已经被注册！", "error", 3e3);
                        } else if (tips == "return_19") {
                                asyncbox.tips("UCenter API: 错误未定义！", "error", 3e3);
                        } else if (tips == "return_20") {
                                $.close("register");
                                get_login();
                        } else if (tips == "return_21") {
                                asyncbox.tips("登录帐号不存在，请更换再试！", "error", 3e3);
                        } else if (tips == "return_22") {
                                asyncbox.tips("验证信息不匹配，请重试！", "error", 3e3);
                        } else if (tips == "return_23") {
                                lostRequest(2);
                        } else if (tips == "logout") {
                                uc_syn("logout");
                                get_login();
                        } else {
                                asyncbox.tips("内部出现错误，请稍后再试！", "error", 3e3);
                        }
                } else {
                        asyncbox.tips("通讯异常，请检查网络设置！", "error", 3e3);
                }
        }
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
function QQLogin() {
        $.close("login");
        asyncbox.open({
                id:"popQQLogin",
                title:"QQ登录",
                url:in_path + "source/pack/connect/login.php",
                width:726,
                height:450,
                modal:true,
                btnsbar:$.btn.close
        });
}
function qzone_return(type) {
        $.close("popQQLogin");
        if (type == 1) {
                uc_syn("login");
                get_login();
        } else {
                location.href = connect_url;
        }
}
function pop_login() {
        asyncbox.open({
                id:"login",
                modal:true,
                drag:true,
                width:480,
                height:260,
                title:"用户登录",
                html:'<div class="popLoginForm form-box"><div class="fl"><ul><li class="form-item clearfix"><label class="label">帐号：</label><input type="text" class="input" id="login-name" /></li><li class="form-item clearfix"><label class="label">密码：</label><input type="password" class="input" id="login-pwd" /></li><li class="form-item clearfix remember"><label class="label">&nbsp;</label><a onclick="QQLogin();" style="cursor:pointer;"><span style="vertical-align:middle;"><img src="' + temp_url + 'css/connect.gif" width="16" height="16"/></span>&nbsp;QQ登录</a>&nbsp;&nbsp;&nbsp;<a onclick="pop_lostpasswd();" style="cursor:pointer;">忘记密码？</a></li></ul><div class="popLoginBtn"><a href="javascript:void(0)" onclick="ginRequest(0);" id="popLoginBtn">登录</a></div></div></div>'
        });
}
function pop_lostpasswd() {
        $.close("login");
        asyncbox.open({
                id:"lostpasswd",
                modal:true,
                drag:true,
                width:480,
                height:260,
                title:"找回密码",
                html:'<div class="popLoginForm form-box"><div class="fl"><ul><li class="form-item clearfix"><label class="label">登录帐号：</label><input type="text" class="input" id="lost-name" /></li><li class="form-item clearfix"><label class="label">密保邮箱：</label><input type="text" class="input" id="lost-mail" /></li><li class="form-item clearfix remember"><label class="label">&nbsp;</label><span id="losttips">注意：重设地址将发送到密保邮箱</span></li></ul><div class="popLoginBtn"><a href="javascript:void(0)" onclick="lostRequest(1);" id="popLoginBtn">开始验证</a></div></div></div>'
        });
}
function pop_register() {
        asyncbox.open({
                id:"register",
                modal:true,
                drag:true,
                width:490,
                height:310,
                title:"注册帐号",
                html:'<div class="popLoginForm form-box"><div class="fl"><ul><li class="form-item clearfix"><label class="label">帐号：</label><input type="text" class="input" id="reg-name" /></li><li class="form-item clearfix"><label class="label">密码：</label><input type="text" class="input" id="reg-pwd" /></li><li class="form-item clearfix"><label class="label">邮箱：</label><input type="text" class="input" id="reg-mail" /></li><li class="form-item clearfix remember"><label class="label">&nbsp;</label><span id="regtips">建议使用真实的邮箱进行注册</span></li></ul><div class="popLoginBtn"><a href="javascript:void(0)" onclick="regRequest();" id="popLoginBtn">注册</a></div></div></div>'
        });
}
function ginRequest(type) {
        var _name = document.getElementById("login-name").value;
        var _pwd = document.getElementById("login-pwd").value;
        if (_name == "") {
                document.getElementById("login-name").focus();
                return;
        } else if (_pwd == "") {
                document.getElementById("login-pwd").focus();
                return;
        }
        createXMLHttpRequest();
        XMLHttpReq.open("GET", in_path + "source/user/people/ajax.php?ac=login&qq=" + type + "&name=" + escape(_name) + "&pwd=" + escape(_pwd), true);
        XMLHttpReq.onreadystatechange = processResponse;
        XMLHttpReq.send(null);
}
function lostRequest(type) {
        if (type == 1) {
                var username = document.getElementById("lost-name");
                if (strLen(username.value) < 1) {
                        document.getElementById("losttips").innerHTML = '<font color="#ff5500">请输入登录帐号</font>';
                        username.focus();
                        return;
                }
                var mail = document.getElementById("lost-mail");
                if (strLen(mail.value) < 1 || isEmail(mail.value) == false) {
                        document.getElementById("losttips").innerHTML = '<font color="#ff5500">请输入正确的密保邮箱</font>';
                        mail.focus();
                        return;
                }
                createXMLHttpRequest();
                XMLHttpReq.open("GET", in_path + "source/user/people/ajax.php?ac=lostpasswd&type=1&name=" + escape(username.value) + "&mail=" + escape(mail.value), true);
                XMLHttpReq.onreadystatechange = processResponse;
                XMLHttpReq.send(null);
        } else if (type == 2) {
                createXMLHttpRequest();
                XMLHttpReq.open("GET", in_path + "source/user/people/ajax.php?ac=lostpasswd&type=2", true);
                XMLHttpReq.onreadystatechange = function() {
                        if (XMLHttpReq.readyState == 4) {
                                if (XMLHttpReq.status == 200) {
                                        if (XMLHttpReq.responseText == "return_26") {
                                                asyncbox.tips("邮件已经发出，需等待 30 秒后才可重新发送！", "wait", 3e3);
                                        } else if (XMLHttpReq.responseText == "return_28") {
                                                document.getElementById("losttips").innerHTML = '<font color="#259b24">恭喜，邮件已经发送成功！</font>';
                                        } else {
                                                document.getElementById("losttips").innerHTML = '<font color="#ff5500">抱歉，邮件未能发送成功！</font>';
                                        }
                                } else {
                                        asyncbox.tips("通讯异常，请检查网络设置！", "error", 3e3);
                                }
                        }
                };
                XMLHttpReq.send(null);
        }
}
function regRequest() {
        var _name = document.getElementById("reg-name").value;
        var _pwd = document.getElementById("reg-pwd").value;
        var _mail = document.getElementById("reg-mail").value;
        if (!/^([\S])*$/.test(_name) || !/^([^<>'"\/\\])*$/.test(_name)) {
                document.getElementById("regtips").innerHTML = '<font color="#ff5500">帐号不能包含空格或 < > \' " / \\ 等</font>';
                document.getElementById("reg-name").focus();
                return;
        } else if (strLen(_name) < 3 || strLen(_name) > 15) {
                document.getElementById("regtips").innerHTML = '<font color="#ff5500">帐号介于3到15个字符之间</font>';
                document.getElementById("reg-name").focus();
                return;
        } else if (strLen(_pwd) < 6) {
                document.getElementById("regtips").innerHTML = '<font color="#ff5500">密码不能低于6位</font>';
                document.getElementById("reg-pwd").focus();
                return;
        } else if (strLen(_mail) < 1 || isEmail(_mail) == false) {
                document.getElementById("regtips").innerHTML = '<font color="#ff5500">请输入正确的邮箱</font>';
                document.getElementById("reg-mail").focus();
                return;
        } else if (reg_open < 1) {
                asyncbox.tips("本站暂未开放注册，请联系管理员！", "wait", 3e3);
                return;
        }
        createXMLHttpRequest();
        XMLHttpReq.open("GET", in_path + "source/user/people/ajax.php?ac=register&name=" + escape(_name) + "&pwd=" + escape(_pwd) + "&mail=" + escape(_mail), true);
        XMLHttpReq.onreadystatechange = processResponse;
        XMLHttpReq.send(null);
}
function getplay() {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", temp_url + "source/ajax_play.php", true);
        theHttpRequest.send(null);
        function processAJAX() {
                if (theHttpRequest.readyState == 4) {
                        if (theHttpRequest.status == 200) {
                                document.getElementById("_play").innerHTML = theHttpRequest.responseText;
                        } else {
                                document.getElementById("_play").innerHTML = "载入异常...";
                        }
                }
        }
}
function getmusician(_id, _type) {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", temp_url + "source/ajax_musician.php?ac=" + _type + "&id=" + _id, true);
        theHttpRequest.send(null);
        function processAJAX() {
                if (theHttpRequest.readyState == 4) {
                        if (theHttpRequest.status == 200) {
                                document.getElementById("_" + _type).innerHTML = theHttpRequest.responseText;
                        } else {
                                document.getElementById("_" + _type).innerHTML = "载入异常...";
                        }
                }
        }
}
function getlove(_id, _type) {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", temp_url + "source/ajax_love.php?ac=" + _type + "&id=" + _id, true);
        theHttpRequest.send(null);
        function processAJAX() {
                if (theHttpRequest.readyState == 4) {
                        if (theHttpRequest.status == 200) {
                                document.getElementById("_" + _type).innerHTML = theHttpRequest.responseText;
                        } else {
                                document.getElementById("_" + _type).innerHTML = "载入异常...";
                        }
                }
        }
}
function up_love(_id, _do) {
        createXMLHttpRequest();
        XMLHttpReq.open("GET", temp_url + "source/ajax_love.php?ac=love&id=" + _id + "&do=" + _do, true);
        XMLHttpReq.onreadystatechange = function() {
                if (XMLHttpReq.readyState == 4) {
                        if (XMLHttpReq.status == 200) {
                                if (XMLHttpReq.responseText == "return_1") {
                                        asyncbox.tips("音乐不存在或已被删除！", "error", 3e3);
                                } else if (XMLHttpReq.responseText == "return_2") {
                                        asyncbox.tips("休息会吧！您已经给过评价啦！", "wait", 3e3);
                                } else if (XMLHttpReq.responseText == "return_3") {
                                        getlove(_id, "good");
                                        getlove(_id, "bad");
                                } else if (XMLHttpReq.responseText == "return_4") {
                                        lib.egg(_id);
                                } else {
                                        asyncbox.tips("内部出现错误，请稍后再试！", "error", 3e3);
                                }
                        } else {
                                asyncbox.tips("通讯异常，请检查网络设置！", "error", 3e3);
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
                                        pop_login();
                                } else if (XMLHttpReq.responseText == "return_1") {
                                        asyncbox.tips("权限不够，请开通绿钻！", "wait", 3e3);
                                } else if (XMLHttpReq.responseText == "return_2") {
                                        asyncbox.tips("金币不足，请先充值！", "wait", 3e3);
                                } else if (XMLHttpReq.responseText == "return_3") {
                                        asyncbox.tips("音乐不存在或已被删除！", "error", 3e3);
                                } else if (XMLHttpReq.responseText == "return_4") {
                                        location.href = temp_url + "source/audio.php?id=" + _id;
                                } else {
                                        asyncbox.tips("内部出现错误，请稍后再试！", "error", 3e3);
                                }
                        } else {
                                asyncbox.tips("通讯异常，请检查网络设置！", "error", 3e3);
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
                                        pop_login();
                                } else if (XMLHttpReq.responseText == "return_1") {
                                        asyncbox.tips("音乐不存在或已被删除！", "error", 3e3);
                                } else if (XMLHttpReq.responseText == "return_2") {
                                        asyncbox.tips("恭喜，音乐收藏成功！", "success", 1e3);
                                } else {
                                        asyncbox.tips("内部出现错误，请稍后再试！", "error", 3e3);
                                }
                        } else {
                                asyncbox.tips("通讯异常，请检查网络设置！", "error", 3e3);
                        }
                }
        };
        XMLHttpReq.send(null);
}
function create_error(_id) {
        createXMLHttpRequest();
        XMLHttpReq.open("GET", temp_url + "source/ajax.php?ac=error&id=" + _id, true);
        XMLHttpReq.onreadystatechange = function() {
                if (XMLHttpReq.readyState == 4) {
                        if (XMLHttpReq.status == 200) {
                                if (XMLHttpReq.responseText == "return_0") {
                                        pop_login();
                                } else if (XMLHttpReq.responseText == "return_1") {
                                        asyncbox.tips("音乐不存在或已被删除！", "error", 3e3);
                                } else if (XMLHttpReq.responseText == "return_2") {
                                        asyncbox.tips("恭喜，音乐举报成功！", "success", 1e3);
                                } else {
                                        asyncbox.tips("内部出现错误，请稍后再试！", "error", 3e3);
                                }
                        } else {
                                asyncbox.tips("通讯异常，请检查网络设置！", "error", 3e3);
                        }
                }
        };
        XMLHttpReq.send(null);
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
                                        parent.pop_login();
                                } else if (XMLHttpReq.responseText == "return_1") {
                                        asyncbox.tips("音乐不存在或已被删除！", "error", 3e3);
                                } else if (XMLHttpReq.responseText == "return_2") {
                                        document.getElementById("_tips").innerHTML = "每次评论间隔时间为<em>30</em>秒！";
                                } else if (XMLHttpReq.responseText == "return_3") {
                                        location.reload();
                                } else {
                                        asyncbox.tips("内部出现错误，请稍后再试！", "error", 3e3);
                                }
                        } else {
                                asyncbox.tips("通讯异常，请检查网络设置！", "error", 3e3);
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
var f_getURL = function() {
        return temp_url + "source/auth.php?ac=save";
};
var f_getMAX = function() {
        return 60;
};
var f_getMIN = function() {
        return 3;
};
var f_complete = function(f) {
        if (f == "success") {
                dos.shake(20, 8, "as_js", 28);
        }
};
var listenMsg = {
        Id:0,
        Url:temp_url + "source/auth.php",
        ing:function(_type, _p, _num) {
                ajax({
                        type:"get",
                        url:listenMsg.Url + "?ac=ing&type=" + _type + "&num=" + _num,
                        dataType:"json",
                        success:function(data) {
                                if (_type < 1 && data["num"] > _num) {
                                        if ($(".play_bt").is(":hidden")) {
                                                $(".pause_bt").click();
                                        }
                                        $('<embed style="position:absolute;top:-100000px" width="0" height="0" type="application/x-shockwave-flash" swliveconnect="true" allowscriptaccess="sameDomain" menu="false" flashvars="sFile=' + in_path + "data/tmp/" + data["record"] + '.mp3" src="' + temp_url + 'js/listen.swf" />').insertBefore("body");
                                } else if (_type < 1 && _p > 0 && $(".pause_bt").is(":hidden")) {
                                        $(".play_bt").click();
                                } else if (data["num"] > _num) {
                                        for (var i = 0; i < data.barrager.length; i++) {
                                                $("body").barrager({
                                                        img:data.barrager[i].img,
                                                        info:data.barrager[i].info,
                                                        close:true,
                                                        speed:6,
                                                        top:i * 50,
                                                        color:"#fff",
                                                        old_ie_color:"#000000"
                                                });
                                        }
                                }
                                listenMsg.Id = setTimeout("listenMsg.ing(" + _type + ", " + data["p"] + ", " + data["num"] + ");", data["time"]);
                        }
                });
        },
        num:function(_type) {
                ajax({
                        type:"get",
                        url:listenMsg.Url + "?ac=num&type=" + _type,
                        dataType:"json",
                        success:function(data) {
                                listenMsg.ing(_type, 0, data["num"]);
                        }
                });
        },
        send:function() {
                if ($("#_info").val().length < 1) {
                        $("#_info").focus();
                        return;
                }
                ajax({
                        type:"get",
                        url:listenMsg.Url + "?ac=send&img=" + $("#album_pic img").attr("src") + "&info=" + escape($("#_info").val()),
                        dataType:"json",
                        success:function(data) {
                                if (data["send"] == 1) {
                                        $("#_info").val("");
                                        dos.shake(20, 8, "_info", 28);
                                }
                        }
                });
        },
        pop:function() {
                asyncbox.open({
                        id:"pop",
                        modal:false,
                        drag:true,
                        width:"auto",
                        height:"auto",
                        title:"边听边说",
                        html:'<object id="as_js" type="application/x-shockwave-flash" width="811" height="140"><param name="movie" value="' + in_path + 'static/pack/upload/record.swf" /><param name="wmode" value="transparent" /></object><div class="popLoginForm form-box"><div class="fl"><ul><li class="form-item clearfix"><textarea class="textarea" id="_info" rows="3" cols="50"></textarea></li></ul><div class="popLoginBtn"><a onclick="listenMsg.send();" id="popLoginBtn">发送弹幕</a></div></div></div>'
                });
        }
};
(function() {
        dos = {
                shake:function(_size, _time, _id, _speed) {
                        var len = _size, c = _time, step = 0, shake = $("#" + _id), off = shake.offset();
                        this.step = 0;
                        timer = setInterval(function() {
                                var set = dos.pos();
                                shake.offset({
                                        top:off.top + set.y * len,
                                        left:off.left + set.x * len
                                });
                                if (step++ >= c) {
                                        shake.offset({
                                                top:off.top,
                                                left:off.left
                                        });
                                        clearInterval(timer);
                                }
                        }, _speed);
                },
                pos:function() {
                        this.step = this.step ? this.step :0;
                        this.step = this.step == 4 ? 0 :this.step;
                        var set = {
                                0:{
                                        x:0,
                                        y:-1
                                },
                                1:{
                                        x:-1,
                                        y:0
                                },
                                2:{
                                        x:0,
                                        y:1
                                },
                                3:{
                                        x:1,
                                        y:0
                                }
                        };
                        return set[this.step++];
                }
        };
})();
$(function() {
        listenMsg.num(0);
        listenMsg.num(1);
        $(".get_feedback").click(function() {
                listenMsg.pop();
        });
});
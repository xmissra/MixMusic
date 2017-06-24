var ajax = function(conf) {
        var type = conf.type;
        var url = conf.url;
        var data = conf.data;
        var dataType = conf.dataType;
        var success = conf.success;
        if (type == null) {
                type = "get";
        }
        if (dataType == null) {
                dataType = "text";
        }
        var xhr = createAjax();
        xhr.open(type, url, true);
        if (type == "GET" || type == "get") {
                xhr.send(null);
        } else {
                if (type == "POST" || type == "post") {
                        xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                        xhr.send(data);
                }
        }
        xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                        if (dataType == "text" || dataType == "TEXT") {
                                if (success != null) {
                                        success(xhr.responseText);
                                }
                        } else {
                                if (dataType == "xml" || dataType == "XML") {
                                        if (success != null) {
                                                success(xhr.responseXML);
                                        }
                                } else {
                                        if (dataType == "json" || dataType == "JSON") {
                                                if (success != null) {
                                                        success(eval("(" + xhr.responseText + ")"));
                                                }
                                        }
                                }
                        }
                } else {
                        if (xhr.readyState == 4 && xhr.status != 200) {}
                }
        };
};
var createAjax = function() {
        var xhr = null;
        try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
                try {
                        xhr = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                        xhr = new XMLHttpRequest();
                }
        }
        return xhr;
};
var lrcLst = null;
function lrcinfo(data) {
        lrcLst = data;
        if (!lrcLst || lrcLst.length == 0) {
                $("#lyrics").html("<p><span>无法识别的扩展名，请添加MIME类型！</span></p>");
        } else {
                var htm = [];
                for (var i = 0; i < lrcLst.length; i++) {
                        htm[htm.length] = "<p><span id='lrcs" + i + "'>";
                        htm[htm.length] = lrcLst[i].text;
                        htm[htm.length] = "</span></p>";
                }
                $("#lyrics").html(htm.join(""));
        }
}
var lastLine = 0;
function moveLrc(msec) {
        if (!lrcLst || lrcLst.length == 0) return;
        var msec = msec + 1;
        var sIndex = 0;
        for (var i = 0; i < lrcLst.length; i++) {
                if (msec >= lrcLst[i].timeId && (i == lrcLst.length - 1 || lrcLst[i + 1].timeId > msec)) {
                        sIndex = i;
                }
        }
        if (sIndex != 0) {
                if (lastLine) {
                        try {
                                $("#lrcs" + lastLine).removeClass("current");
                        } catch (e) {}
                }
                try {
                        $("#lrcs" + sIndex).addClass("current");
                } catch (e) {}
                lastLine = sIndex;
                if (sIndex > 1) {
                        try {
                                for (var h = 0; h < sIndex - 1; h++) {
                                        $("#lrcs" + h).html("");
                                }
                        } catch (e) {}
                }
        }
}
function player_data(_id) {
        var queryUrl = temp_url + "source/ajax_player.php?type=json&id=" + _id;
        ajax({
                type:"get",
                url:queryUrl,
                dataType:"json",
                success:function(data) {
                        var _audio = data.type[0] == "m4a" ? {
                                m4a:data.audio[0],
                                name:data.name[0],
                                singer:data.singer[0],
                                cover:data.cover[0],
                                lrc:data.lrclist,
                                id:_id
                        } :{
                                mp3:data.audio[0],
                                name:data.name[0],
                                singer:data.singer[0],
                                cover:data.cover[0],
                                lrc:data.lrclist,
                                id:_id
                        };
                        $("#player").jPlayer({
                                ready:function(event) {
                                        $("#player").jPlayer("setMedia", _audio).jPlayer("play");
                                },
                                play:function(event) {
                                        $("#album_pic img").attr("src", event.jPlayer.status.media.cover);
                                        $("#music_name").html(event.jPlayer.status.media.name);
                                        $("#singer_name").html(event.jPlayer.status.media.singer);
                                        lrcinfo(event.jPlayer.status.media.lrc);
                                        $(".single_list li").removeClass("play_current");
                                        $("#player_" + event.jPlayer.status.media.id).addClass("play_current");
                                },
                                ended:function(event) {
                                        player_next();
                                },
                                timeupdate:function(event) {
                                        var percent = event.jPlayer.status.currentTime / event.jPlayer.status.duration * 100 - 1;
                                        $(".progress_op").css("left", percent + "%");
                                        moveLrc(event.jPlayer.status.currentTime);
                                },
                                supplied:data.type[0],
                                swfPath:temp_url + "js",
                                wmode:"window",
                                loop:false,
                                volume:1,
                                cssSelectorAncestor:".m_player",
                                cssSelector:{
                                        currentTime:"#playtime",
                                        duration:"#totaltime",
                                        seekBar:".download_bar",
                                        playBar:".play_current_bar",
                                        play:".play_bt",
                                        pause:".pause_bt",
                                        mute:".volume_icon",
                                        unmute:".volume_mute",
                                        volumeBar:".volume_regulate",
                                        volumeBarValue:".volume_bar"
                                }
                        });
                        $("#player").jPlayer("setMedia", _audio).jPlayer("play");
                }
        });
}
function player_prev() {
        var _li = $("#jp-playlist-box li");
        if (_li.length > 1) {
                var _did = $(".play_current").attr("data-id");
                if (_li[0].getAttribute("data-id") != _did) {
                        for (var i = 0; i < _li.length; i++) {
                                if (_li[i].getAttribute("data-id") == _did) {
                                        var _mid = _li[i - 1].getAttribute("data-id");
                                        player_data(_mid);
                                }
                        }
                } else {
                        var _mid = _li[_li.length - 1].getAttribute("data-id");
                        player_data(_mid);
                }
        } else {
                $("#spansongnum1").click();
        }
}
function player_next() {
        var _li = $("#jp-playlist-box li");
        if (_li.length > 1) {
                var _did = $(".play_current").attr("data-id");
                if (_li[_li.length - 1].getAttribute("data-id") != _did) {
                        for (var i = 0; i < _li.length; i++) {
                                if (_li[i].getAttribute("data-id") == _did) {
                                        var _mid = _li[i + 1].getAttribute("data-id");
                                        player_data(_mid);
                                }
                        }
                } else {
                        var _mid = _li[0].getAttribute("data-id");
                        player_data(_mid);
                }
        } else {
                $("#spansongnum1").click();
        }
}
function player_index(obj, type) {
        var _num = "";
        var _fid = 0;
        var _li = $("#jp-playlist-box li");
        if (_li.length > 0) {
                for (var i = 0; i < _li.length; i++) {
                        var _lid = _li[i].getAttribute("data-id");
                        _num += _lid + ",";
                        if ($("#player_" + _lid).hasClass("play_current")) {
                                _fid = _lid;
                        }
                }
        }
        if (isNaN(obj)) {
                var mIdSrt = "";
                $("#" + obj + " :checkbox").each(function() {
                        if ($(this).attr("checked")) {
                                mIdSrt += $(this).val() + ",";
                        }
                });
                if (mIdSrt) {
                        var _ids = mIdSrt.substr(0, mIdSrt.length - 1);
                        var _nid = _ids.split(",");
                        var _did = _num + _ids;
                        $("#divnulllist").hide();
                        get_player(_did, _fid);
                        player_join(_did);
                        var title = $("#btnfold").attr("title");
                        if (title == "点击展开") {
                                $("#divplayer").addClass("m_player_playing");
                        }
                        $("#spanaddtips").show();
                        for (i = 1; i <= 30; i++) {
                                setTimeout('$("#spanaddtips").css("top", "' + -i + 'px");', i * 30);
                                if (i > 29) {
                                        setTimeout('$("#spanaddtips").hide();', 1500);
                                }
                        }
                        if (type == "ing") {
                                if (isNaN(_ids)) {
                                        player_data(_nid[0]);
                                } else {
                                        player_data(_ids);
                                }
                        }
                } else {
                        var _text = type == "add" ? "添加" :"播放";
                        lib.t_ips("请选择要" + _text + "的歌曲！", 0, 3e3);
                }
        } else {
                var _did = _num + obj;
                $("#divnulllist").hide();
                get_player(_did, _fid);
                player_join(_did);
                var title = $("#btnfold").attr("title");
                if (title == "点击展开") {
                        $("#divplayer").addClass("m_player_playing");
                }
                $("#spanaddtips").show();
                for (i = 1; i <= 30; i++) {
                        setTimeout('$("#spanaddtips").css("top", "' + -i + 'px");', i * 30);
                        if (i > 29) {
                                setTimeout('$("#spanaddtips").hide();', 1500);
                        }
                }
                if (type == "ing") {
                        player_data(obj);
                }
        }
}
function player_join(str) {
        var s = str.split(",");
        var dic = {};
        for (var i = s.length; i--; ) {
                dic[s[i]] = s[i];
        }
        var r = [];
        for (var v in dic) {
                r.push(dic[v]);
        }
        var n = r.join().split(",");
        $("#spansongnums").html(n.length);
}
$(function() {
        $("#btnfold").click(function() {
                var tit = $(this).attr("title");
                if (tit == "点击收起") {
                        $("#divplayer").animate({
                                left:-540
                        }, {
                                duration:500
                        });
                        $(this).attr("title", "点击展开");
                        if ($("#spansongnum1 span").html() > 0) {
                                $("#divplayer").addClass("mini_version");
                                $("#divplayer").addClass("m_player_folded");
                                $("#divplayer").addClass("m_player_playing");
                        } else {
                                $("#divplayer").addClass("m_player_folded");
                        }
                        $("#divplayframe").hide();
                        $("#divplayer").removeClass("mini_version");
                } else {
                        $("#divplayer").animate({
                                left:0
                        }, {
                                duration:500
                        });
                        $("#divplayer").removeClass("m_player_folded");
                        $("#divplayer").removeClass("m_player_playing");
                        $(this).attr("title", "点击收起");
                }
        });
        $("#spansongnum1").click(function() {
                var shows = $("#divplayframe").css("display");
                if (shows == "none") {
                        $("#divplayframe").show();
                        $("#divplayer").addClass("mini_version");
                } else {
                        $("#divplayframe").hide();
                        $("#divplayer").removeClass("mini_version");
                }
        });
        $("#btnclose").click(function() {
                $("#divplayframe").hide();
                $("#divplayer").removeClass("mini_version");
        });
        $("#btnlrc").click(function() {
                var shows = $("#player_lyrics_pannel").css("display");
                if (shows == "none") {
                        $("#player_lyrics_pannel").show();
                } else {
                        $("#player_lyrics_pannel").hide();
                }
        });
        $("#closelrcpannel").click(function() {
                $("#player_lyrics_pannel").hide();
        });
        $(".clear_list").click(function() {
                $("#jp-playlist-box").text("");
        });
        $("#jp-playlist-box li").live({
                mouseover:function() {
                        $(this).addClass("play_hover");
                },
                mouseout:function() {
                        $(this).removeClass("play_hover");
                }
        });
});
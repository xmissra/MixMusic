var config = {};
try {
        config.canPlayM4a = !!document.createElement("audio").canPlayType("audio/mpeg");
        config.canPlayAac = !!document.createElement("audio").canPlayType && document.createElement("audio").canPlayType('audio/mp4; codecs="mp4a.40.2"') == "probably";
} catch (e) {}
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
function $S(s) {
        return document.getElementById(s);
}
function $html(s, html) {
        $S(s).innerHTML = html;
}
function getMedia() {
        return $S("mediaPlayId");
}
function playstopop() {
        if ($("#playstopid").hasClass("icon_play--pause")) {
                getMedia().pause();
                $("#playstopid").removeClass("icon_play--pause");
        } else {
                try {
                        getMedia().pause();
                } catch (e) {}
                getMedia().play();
                $("#playstopid").addClass("icon_play--pause");
        }
}
var lrcLst = null;
function lrcinfo(data) {
        $S("tips").style.webkitTransform = "translateY(0px)";
        lrcLst = data;
        if (!lrcLst || lrcLst.length == 0) {
                $html("llrcId", "<p>无法识别的扩展名，请添加MIME类型！</p>");
        } else {
                var htm = [];
                htm[htm.length] = "<div class='lyric__text' id='llrcId'>";
                for (var i = 0; i < lrcLst.length; i++) {
                        htm[htm.length] = "<p id='lId" + i + "'>";
                        htm[htm.length] = lrcLst[i].text;
                        htm[htm.length] = "</p>";
                }
                htm[htm.length] = "</div>";
                $html("lrctextId", htm.join(""));
        }
}
function playStatus() {
        if (isplay == 0) {}
        if (isplay2 == 1) {
                if (smsecTime != null) {
                        clearTimeout(smsecTime);
                }
                isplay2 = 0;
        }
}
function loadError() {
        $S("tips").style.webkitTransform = "translateY(30px)";
}
var ltime = 0;
var isplay = 1;
var isplay2 = 1;
function updateMethod() {
        try {
                if (isplay == 1 && Math.floor(getMedia().currentTime) == 1) {
                        $("#playstopid").addClass("icon_play--pause");
                        if (toastTime != null) {
                                clearTimeout(toastTime);
                        }
                        isplay = 0;
                }
                var jd = getMedia().currentTime / parseFloat(getMedia().duration) * 100;
                $S("youwid").style.webkitTransform = "translateX(" + jd + "%)";
                $S("youwid").style.webkitTransitionDuration = "1s";
                $html("currTimeId", getTimeM(getMedia().currentTime));
                $html("totalTimeId", getTimeM(getMedia().duration));
                if (ltime > 3) {
                        moveLrc();
                        ltime = 0;
                }
                ltime++;
        } catch (e) {
                e.message;
        }
}
var lastLine = 0;
function moveLrc() {
        if (!lrcLst || lrcLst.length == 0) return;
        var msec = getMedia().currentTime + 1;
        var mv = 0;
        var sIndex = 0;
        for (var i = 0; i < lrcLst.length; i++) {
                if (msec >= lrcLst[i].timeId && (i == lrcLst.length - 1 || lrcLst[i + 1].timeId > msec)) {
                        mv = i * 42;
                        sIndex = i;
                }
        }
        if (mv != 0) {
                if (lastLine) {
                        try {
                                $S("lId" + lastLine).className = "";
                        } catch (e) {}
                }
                try {
                        $S("lId" + sIndex).className = "lyric__item--current";
                } catch (e) {}
                lastLine = sIndex;
                try {
                        $S("llrcId").style.webkitTransition = "-webkit-transform 0.3s ease-out";
                } catch (e) {}
                try {
                        $S("llrcId").style.webkitTransformOrigin = "0px 0px 0px";
                } catch (e) {}
                if (sIndex > 1) {
                        try {
                                $S("llrcId").style.webkitTransform = "translate3d(0px, " + -(mv - 84) + "px, 0px)";
                        } catch (e) {}
                }
        }
}
var smsecTime = null;
function loadStatus() {
        $("#playstopid").removeClass("icon_play--pause");
        if (smsecTime != null) {
                clearTimeout(smsecTime);
        }
}
function clearload() {
        try {
                errjs = 0;
                isplay = 1;
                isplay2 = 1;
                getMedia().src = "";
                getMedia().load();
        } catch (e) {}
}
function getTimeM(totalTime) {
        var totalTimeStr = "00:00";
        if (!isNaN(totalTime)) {
                var totalTimeStr = totalTime / 60 >= 10 ? parseInt(totalTime / 60) :"0" + parseInt(totalTime / 60);
                totalTimeSec = totalTime % 60 >= 10 ? parseInt(totalTime % 60) :"0" + parseInt(totalTime % 60);
                if (totalTimeStr > 99) {
                        totalTimeStr = "00";
                }
                totalTimeStr = totalTimeStr + ":" + totalTimeSec;
        }
        return totalTimeStr;
}
var p_song_flag = 0;
function dsExe() {
        p_song_flag = 0;
}
function getSongInfo() {
        try {
                getMedia().play();
        } catch (e) {}
        clearload();
        if (p_song_flag == 0) {
                p_song_flag = 1;
                setTimeout(dsExe, 3e3);
                var queryUrl = temp_url + "source/json.php?type=play&id=" + music_id;
                ajax({
                        type:"get",
                        url:queryUrl,
                        dataType:"json",
                        success:function(data) {
                                lrcinfo(data.lrclist);
                                playSong(data.audio[0]);
                        }
                });
        }
}
function setip(text, type, time) {
        document.getElementById("error_tips").style.display = "";
        document.getElementById("error_tips_content").style.background = type ? "#0dad51" :"#525c5f";
        document.getElementById("error_message").innerHTML = text;
        setTimeout("document.getElementById('error_tips').style.display = 'none';", time);
}
function getfav() {
        var queryUrl = temp_url + "source/json.php?type=getfav&id=" + music_id;
        ajax({
                type:"get",
                url:queryUrl,
                dataType:"text",
                success:function(data) {
                        $html("favorites", data);
                }
        });
}
function putfav() {
        var queryUrl = temp_url + "source/json.php?type=putfav&id=" + music_id;
        ajax({
                type:"get",
                url:queryUrl,
                dataType:"text",
                success:function(data) {
                        if (data == 1) {
                                setip("音乐收藏成功！", 1, 1e3);
                                getfav();
                        } else if (data == -1) {
                                setip("音乐取消收藏！", 1, 1e3);
                                getfav();
                        } else if (data == -2) {
                                setip("音乐不存在！", 0, 3e3);
                        } else {
                                setip("登录已过期！", 0, 3e3);
                        }
                }
        });
}
function playSong(url) {
        $html("playHTMLId", '<audio id="mediaPlayId" src="' + url + '" autoplay="autoplay" onended="getSongInfo();" onloadstart="loadStatus();" onplaying="playStatus();" onerror="loadError();" ontimeupdate="updateMethod();" mozaudiochannel="content" controls="controls"></audio>');
}
function c_init() {
        $S("lrctextId").style.height = "336px";
        getSongInfo();
        getfav();
}
window.onload = c_init;
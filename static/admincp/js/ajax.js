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
function ShowStar(_level, _id) {
        var htmlStr = "";
        if (_level > 0) {
                htmlStr += "<img src='static/admincp/css/star_del.png' border='0' style='cursor:pointer;margin-left:2px;' title='取消推荐' onclick='EditBest(0, " + _id + ")' />";
        }
        for (i = 1; i <= _level; i++) {
                htmlStr += "<img src='static/admincp/css/star_yes.gif' border='0' style='cursor:pointer;margin-left:2px;' title='推荐为" + i + "星级' onclick='EditBest(" + i + ", " + _id + ")' />";
        }
        for (j = _level + 1; j <= 5; j++) {
                htmlStr += "<img src='static/admincp/css/star_no.gif' border='0' style='cursor:pointer;margin-left:2px;' title='推荐为" + j + "星级' onclick='EditBest(" + j + ", " + _id + ")' />";
        }
        document.getElementById("in_best" + _id).innerHTML = htmlStr;
}
function EditBest(_level, _id) {
        var XMLHttpReq = getHttpObject();
        XMLHttpReq.open("GET", "?iframe=ajax&level=" + _level + "&id=" + _id, true);
        XMLHttpReq.onreadystatechange = function() {
                if (XMLHttpReq.readyState == 4) {
                        if (XMLHttpReq.status == 200) {
                                if (XMLHttpReq.responseText == 1) {
                                        if (_level > 0) {
                                                asyncbox.tips("推荐为" + _level + "星级", "success", 1e3);
                                        } else {
                                                asyncbox.tips("取消推荐", "success", 1e3);
                                        }
                                        ShowStar(_level, _id);
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
function uploadEdit(obj) {
	forms = document.getElementById(obj).getElementsByTagName("FORM");
	edit_save()
}
function edit_save() {
	var p = window.frames['uchome-ifrHtmlEditor'];
	var obj = p.window.frames['HtmlEditor'];
	var status = p.document.getElementById('uchome-editstatus').value;
	if (status == 'code') {
		document.getElementById('in_intro').value = p.document.getElementById('sourceEditor').value
	} else if (status == 'text') {
		document.getElementById('in_intro').value = p.document.getElementById('dvtext').value.replace(/\r\n|\n/g, "<br>")
	} else {
		document.getElementById('in_intro').value = obj.document.body.innerHTML
	}
	backupContent(document.getElementById('in_intro').value)
}
function backupContent(sHTML) {
	if (sHTML.length > 11) {
		var oArea = document.getElementById('in_intro');
		try {
			var xmlDoc = oArea.XMLDocument;
			var msgNode = xmlDoc.createNode(1, 'in_intro', '');
			var msgValueNode = xmlDoc.createNode(4, "in_intro", "");
			delmsg = xmlDoc.selectNodes("//in_intro");
			delmsg.removeAll();
			msgValueNode.nodeValue = sHTML;
			msgNode.appendChild(msgValueNode);
			root = xmlDoc.documentElement;
			root.appendChild(msgNode);
			oArea.save('UCHome')
		} catch (e) {
			if (window.sessionStorage) {
				try {
					sessionStorage.setItem('in_intro', sHTML)
				} catch (e) {}
			}
		}
	}
}
function edit_insert(html) {
	var p = window.frames['uchome-ifrHtmlEditor'];
	var obj = p.window.frames['HtmlEditor'];
	var status = p.document.getElementById('uchome-editstatus').value;
	if (status != 'html') {
		alert('本操作只在多媒体编辑模式下才有效');
		return
	}
	obj.focus();
	if (window.Event) {
		obj.document.execCommand('insertHTML', false, html)
	} else {
		obj.focus();
		var f = obj.document.selection.createRange();
		f.pasteHTML(html);
		f.collapse(false);
		f.select()
	}
	parent.layer.closeAll()
}
function ajax_upload(url) {
	url = url.split(':');
	var theHttpRequest = getHttpObject();
	theHttpRequest.onreadystatechange = function() {
		processAJAX()
	};
	theHttpRequest.open('GET', in_path + 'source/plugin/' + url[0] + '/doodle_ajax.php?path=' + url[1], true);
	theHttpRequest.send(null);
	function processAJAX() {
		if (theHttpRequest.readyState == 4) {
			if (theHttpRequest.status == 200) {
				edit_insert('<p><img src="' + theHttpRequest.responseText + '"></p>')
			} else {
				layer.msg('通讯异常，请检查网络设置！', 3, 3)
			}
		}
	}
}
function setDoodle(fid, oid, url, tid, from) {
	if (url.match(/^(http:\/\/)/g)) {
		edit_insert('<p><img src="' + url + '"></p>')
	} else {
		ajax_upload(url)
	}
}
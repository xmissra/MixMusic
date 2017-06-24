function get_best(best) {
	var star = '☆☆☆☆☆';
	if (best == 1) {
		star = '★☆☆☆☆';
	} else if (best == 2) {
		star = '★★☆☆☆';
	} else if (best == 3) {
		star = '★★★☆☆';
	} else if (best == 4) {
		star = '★★★★☆';
	} else if (best == 5) {
		star = '★★★★★';
	}
	return star;
}
function get_tag(str) {
	var keyword = str + '>';
	keyword = keyword.replace(/\,\>/g, '');
	keyword = keyword.replace(/\>/g, '');
	keyword = keyword.replace(/\//g, '');
	keyword = keyword.replace(/\\/g, '');
	keyword = keyword.replace(/\?/g, '');
	var tag = '';
	if (keyword) {
		var link = search_url.replace(/table/g, 'music');
		var strs = new Array();
		strs = keyword.split(',');
		for (i = 0; i < strs.length - 1; i++) {
			tag += '<a href="' + link.replace(/target/g, strs[i]) + '" target="_blank">' + strs[i] + '</a>,';
		}
	} else {
		tag = tag + '暂无标签,';
	}
	return tag.substr(0, tag.length - 1);
}
function getTop(e) {
	var offset = e.offsetTop;
	if (e.offsetParent != null) offset += getTop(e.offsetParent);
	return offset;
}
function getLeft(e2) {
	if (e2.offsetParent)
	 return (e2.offsetLeft + getLeft(e2.offsetParent));
	else
	 return (e2.offsetLeft);
}
$(function() {
	show = false;
	$(".dongBox").hover(function() {
		var top = getTop(this) + 30
		var left = getLeft(this)
		 $(".dong03").show().css({
			"position": "absolute",
			"left": left,
			"top": top + 35
		})
		 show = true;
	},
	function() {
		show = false;
		setTimeout("newMenuHide()", 500);
	})
	 $(".dong03").hover(function() {
		show = true;
	},
	function() {
		show = false;
		newMenuHide();
	})
});
function newMenuHide() {
	if (show == false) {
		$(".dong03").hide();
	}
}
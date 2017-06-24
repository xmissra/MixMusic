function setHomepage() {
	if (document.all) {
		document.body.style.behavior = 'url(#default#homepage)';
		document.body.setHomePage(location.href);
	} else if (window.sidebar) {
		if (window.netscape) {
			try {
				netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
			} catch(e) {
				asyncbox.tips("该操作被浏览器拒绝，请使用浏览器菜单手动设置！", "error", 3000);
			}
		}
		var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
		prefs.setCharPref('browser.startup.homepage', location.href);
	} else {
		asyncbox.tips("您的浏览器不支持，请使用浏览器菜单手动设置！", "wait", 3000);
	}
}
function addFavorite() {
	if (document.all) {
		try {
			window.external.addFavorite(location.href, document.title);
		} catch(e) {
			asyncbox.tips("加入收藏失败，请使用“Ctrl+D”进行添加！", "wait", 3000);
		}
	} else if (window.sidebar) {
		window.sidebar.addPanel(document.title, location.href, "");
	} else {
		asyncbox.tips("加入收藏失败，请使用“Ctrl+D”进行添加！", "error", 3000);
	}
}
function clickTabs(tabTit, on, tabCon) {
	$(tabTit).children().click(function() {
		$(this).addClass(on).siblings().removeClass(on);
		var index = $(tabTit).children().index(this);
		$(tabCon).children().eq(index).show().siblings().hide();
	});
}
$(function() {
	clickTabs(".clickTab-hd", "current", ".clickTab-bd");
}); (function($) {
	var goToTopTime;
	$.fn.goToTop = function(options) {
		var opts = $.extend({},
		$.fn.goToTop.def, options);
		var $window = $(window);
		$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
		var $this = $(this);
		clearTimeout(goToTopTime);
		goToTopTime = setTimeout(function() {
			var controlLeft;
			if ($window.width() > opts.pageHeightJg * 2 + opts.pageWidth) {
				controlLeft = ($window.width() - opts.pageWidth) / 2 + opts.pageWidth + opts.pageWidthJg;
			} else {
				controlLeft = $window.width() - opts.pageWidthJg - $this.width();
			}
			var cssfixedsupport = $.browser.msie && parseFloat($.browser.version) < 7;
			var controlTop = $window.height() - $this.height() - opts.pageHeightJg;
			controlTop = cssfixedsupport ? $window.scrollTop() + controlTop: controlTop;
			var shouldvisible = ($window.scrollTop() >= opts.startline) ? true: false;
			if (shouldvisible) {
				$this.stop().show();
			} else {
				$this.stop().hide();
			}
			$this.css({
				position: cssfixedsupport ? 'absolute': 'fixed',
				top: controlTop,
				left: controlLeft
			});
		},
		30);
		$(this).click(function(event) {
			$body.stop().animate({
				scrollTop: $(opts.targetObg).offset().top
			},
			opts.duration);
			$(this).blur();
			event.preventDefault();
			event.stopPropagation();
		});
	};
	$.fn.goToTop.def = {
		pageWidth: 960,
		pageWidthJg: 5,
		pageHeightJg: 120,
		startline: 30,
		duration: 200,
		targetObg: "body"
	};
})(jQuery);
$(function() {
	$('<a class="backToTop"></a>').appendTo("body");
});
$(function() {
	$(".backToTop").goToTop({});
	$(window).bind('scroll resize',
	function() {
		$(".backToTop").goToTop({});
	});
});
$(function() {
	$(".top-user li.down-menu").hover(function() {
		$(this).toggleClass("hover");
	})
});
$(function() {
	$(".setPlayXuan").live("click",
	function() {
		var $clThis = $(this);
		$(".setPlayXuan").not($clThis).removeClass("setPlayXuanCur");
		$clThis.toggleClass("setPlayXuanCur");
	})
});
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
	showHis = false;
	var loagList = 1;
	var hiscl = 0;
	$(".historyHd").each(function() {
		$(this).hover(function() {
			var top = getTop(this) + 35
			var left = getLeft(this)
			 if (loagList == 1) {
				showHisList(hisCurPage);
				loagList = 2;
			}
			$(".historyBd").show().css({
				"position": "absolute",
				"left": left,
				"top": top
			})
			 showHis = true;
		},
		function() {
			showHis = false;
			hiscl = setTimeout("newMenuHide()", 200);
			$(".historyBox").removeClass("hover");
		})
	})
	 $(".historyBd").hover(function() {
		showHis = true;
		$(".historyBox").addClass("hover");
	},
	function() {
		showHis = false;
		newMenuHide();
		clearTimeout(hiscl);
	})
});
function newMenuHide() {
	if (showHis == false) {
		$(".historyBd").hide();
		$(".historyBox").removeClass("hover");
	}
}
var hisCurPage = 1,
hisIsLoaded = 0;
function getHisId() {
	var returnid = "";
	var str = document.cookie;
	var num_start = str.indexOf("l_music");
	if (num_start != -1) {
		var num_end = str.indexOf("l_end");
		if (num_end > num_start) {
			var str_list = str.substring(num_start, num_end).replace(/l_music=/ig, "");
			var arr_list = str_list.split(",");
			if (arr_list.length > 0) {
				for (i = 0; i < arr_list.length; i++) {
					var str_ti = arr_list[i];
					if (str_ti != undefined || str_ti != "undefined" || str_ti != null || str_ti != "") {
						returnid = returnid + str_ti + ","
					}
				}
			}
		}
	}
	return returnid;
}
function showHisList(page) {
	if (hisIsLoaded == 1 && hisCurPage == page) return;
	hisCurPage = page;
	var hidstr = getHisId();
	if (hidstr == ",,") hidstr = "";
}
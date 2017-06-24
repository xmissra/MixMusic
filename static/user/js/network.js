function setintro(type) {
	var intro = '';
	var bPosition = '';
	if (type == 'doing') {
		intro = '用一句话记录自己生活中的点点滴滴';
		bPosition = '0';
	} else if (type == 'mtag') {
		intro = '创建自己的专辑，把好听的音乐分享给大家';
		bPosition = '175px';
	} else if (type == 'pic') {
		intro = '上传照片，分享生活中的精彩瞬间';
		bPosition = '55px';
	} else if (type == 'app') {
		intro = '与好友一起私信互动，增加彼此感情';
		bPosition = '118px';
	} else {
		intro = '马上注册，分享你的日志、照片、音乐、视频，一起玩转社区';
		bPosition = '0';
	}
	$('guest_intro').innerHTML = intro + '......';
	$('guest_intro').style.backgroundPosition = bPosition + ' 100%'
}
function scrollPic(e, LN, Width, Price, Speed) {
	id = e.id;
	if (LN == 'Last') {
		scrollNum = Width;
	} else if (LN == 'Next') {
		scrollNum = 0 - Width;
	}
	scrollStart = parseInt(e.style.marginLeft, 10);
	scrollEnd = parseInt(e.style.marginLeft, 10) + scrollNum;
	MaxIndex = (e.getElementsByTagName('li').length / Price).toFixed(0);
	sPicMaxScroll = 0 - Width * MaxIndex;
	if (scrollStart == 0 && scrollEnd == Width) {
		scrollEnd = -1806;
		e.style.marginLeft = parseInt(e.style.marginLeft, 10) - Speed + 'px';
	} else if (scrollStart == sPicMaxScroll + Width && scrollEnd == sPicMaxScroll) {
		scrollEnd = 0;
		e.style.marginLeft = parseInt(e.style.marginLeft, 10) + Speed + 'px';
	}
	scrollShowPic = setInterval(scrollShow, 1);
	function scrollShow() {
		if (scrollStart > scrollEnd) {
			if (parseInt(e.style.marginLeft, 10) > scrollEnd) {
				$(id + '_last').onclick = function() {
					return false;
				};
				$(id + '_next').onclick = function() {
					return false;
				};
				e.style.marginLeft = parseInt(e.style.marginLeft, 10) - Speed + 'px';
			} else {
				clearInterval(scrollShowPic);
				$(id + '_last').onclick = function() {
					scrollPic(e, 'Last', Width, Price, Speed);
					return false;
				};
				$(id + '_next').onclick = function() {
					scrollPic(e, 'Next', Width, Price, Speed);
					return false;
				};
			}
		} else {
			if (parseInt(e.style.marginLeft, 10) < scrollEnd) {
				$(id + '_last').onclick = function() {
					return false;
				};
				$(id + '_next').onclick = function() {
					return false;
				};
				e.style.marginLeft = parseInt(e.style.marginLeft, 10) + Speed + 'px';
			} else {
				clearInterval(scrollShowPic);
				$(id + '_last').onclick = function() {
					scrollPic(e, 'Last', Width, Price, Speed);
					return false;
				};
				$(id + '_next').onclick = function() {
					scrollPic(e, 'Next', Width, Price, Speed);
					return false;
				};
			}
		}
	}
}
function scrollShowNav(e, Width, Price, Speed) {
	id = e.id;
	$(id + '_last').onclick = function() {
		scrollPic(e, 'Last', Width, Price, Speed);
		return false;
	};
	$(id + '_next').onclick = function() {
		scrollPic(e, 'Next', Width, Price, Speed);
		return false;
	};
}
function getUserTip(obj) {
	var tipBox = $('usertip_box');
	tipBox.childNodes[0].innerHTML = '<strong>' + obj.rel + ':<\/strong> ' + obj.rev + '...';
	var showLeft;
	if (obj.parentNode.offsetLeft > 730) {
		showLeft = $('showuser').offsetLeft + obj.parentNode.offsetLeft - 148;
		tipBox.childNodes[0].style.right = 0;
	} else {
		tipBox.childNodes[0].style.right = 'auto';
		showLeft = $('showuser').offsetLeft + obj.parentNode.offsetLeft;
	}
	tipBox.style.left = showLeft + 'px';
	var showTop;
	if (obj.className == 'uonline') {
		showTop = $('showuser').offsetTop + obj.parentNode.offsetTop - tipBox.childNodes[0].clientHeight;
	} else {
		showTop = $('showuser').offsetTop + obj.parentNode.offsetTop + 48;
	}
	tipBox.style.top = showTop + 'px';
	tipBox.style.visibility = 'visible';
}
function startMarquee(h, speed, delay, sid) {
	var t = null;
	var p = false;
	var o = $(sid);
	o.innerHTML += o.innerHTML;
	o.onmouseover = function() {
		p = true
	}
	o.onmouseout = function() {
		p = false
	}
	o.scrollTop = 0;
	function start() {
		t = setInterval(scrolling, speed);
		if (!p) {
			o.scrollTop += 2;
		}
	}
	function scrolling() {
		if (p) return;
		if (o.scrollTop % h != 0) {
			o.scrollTop += 2;
			if (o.scrollTop >= o.scrollHeight / 2) o.scrollTop = 0;
		} else {
			clearInterval(t);
			setTimeout(start, delay);
		}
	}
	setTimeout(start, delay);
}
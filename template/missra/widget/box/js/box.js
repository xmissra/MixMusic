var cmpo;
function cmp_loaded(key) {
	cmpo = CMP.get('cmp');
	if (cmpo) {
		cmpo.addEventListener('model_load', 'cmp_model_load');
	}
}
function cmp_model_load(data) {
	var _id = '{_lrc}' + cmpo.item('_id');
	var htm = CMP.create('cmp', '200', '100', temp_url + 'widget/v.swf?php=lrc', {
		lists: _id
	},
	{
		wmode: 'transparent'
	});
	$('.single_list li').removeClass('play_current');
	$('#box_play_' + cmpo.item('_id')).addClass('play_current');
	document.getElementById('lyric').innerHTML = htm;
}
function send_box(_id) {
	var _ids = _id.replace(/\,/g, ',{box}');
	_ids = '{box}' + _ids;
	var htm = CMP.create('cmp', '440', '100%', temp_url + 'widget/v.swf?php=box', {
		api: 'cmp_loaded',
		lists: _ids
	},
	{
		wmode: 'transparent'
	});
	document.getElementById('divnulllist').style.display = 'none';
	document.getElementById('jp-playlist-box').innerHTML = getbox(_id);
	document.getElementById('qianweiplayer').innerHTML = htm;
	var title = $('#btnfold').attr('title');
	if (title == '点击展开') {
		$('#divplayer').addClass('m_player_playing');
	}
	document.getElementById('player_lyrics_pannel').style.display = '';
	document.getElementById('spansongnums').innerHTML = _id.split(',').length;
	document.getElementById('spanaddtips').style.display = '';
	for (i = 1; i <= 30; i++) {
		setTimeout("document.getElementById('spanaddtips').style.top = '-" + i + "px';", i * 30);
		if (i > 29) {
			setTimeout("document.getElementById('spanaddtips').style.display = 'none';", 1500);
		}
	}
}
function box_play(_id) {
	var htm = CMP.create('cmp', '440', '100%', temp_url + 'widget/v.swf?php=box', {
		api: 'cmp_loaded',
		lists: '{box}' + _id
	},
	{
		wmode: 'transparent'
	});
	document.getElementById('qianweiplayer').innerHTML = htm;
}
$(function() {
	$("#btnfold").click(function() {
		var tit = $(this).attr('title');
		if (tit == '点击收起') {
			$("#divplayer").animate({
				left: -540
			},
			{
				duration: 500
			});
			$(this).attr('title', '点击展开');
			if ($('#spansongnum1 span').html() > 0) {
				$('#divplayer').addClass("mini_version");
				$('#divplayer').addClass("m_player_folded");
				$('#divplayer').addClass("m_player_playing")
			} else {
				$('#divplayer').addClass("m_player_folded")
			}
			$('#divplayframe').hide();
			$('#divplayer').removeClass("mini_version")
		} else {
			$("#divplayer").animate({
				left: 0
			},
			{
				duration: 500
			});
			$('#divplayer').removeClass("m_player_folded");
			$('#divplayer').removeClass("m_player_playing");
			$(this).attr('title', '点击收起')
		}
	});
	$("#spansongnum1").click(function() {
		var shows = $('#divplayframe').css('display');
		if (shows == 'none') {
			$('#divplayframe').show();
			$('#divplayer').addClass("mini_version")
		} else {
			$('#divplayframe').hide();
			$('#divplayer').removeClass("mini_version")
		}
	});
	$("#btnclose").click(function() {
		$('#divplayframe').hide();
		$('#divplayer').removeClass("mini_version")
	});
	$("#btnlrc").click(function() {
		var shows = $('#player_lyrics_pannel').css('display');
		if (shows == 'none') {
			$('#player_lyrics_pannel').show()
		} else {
			$('#player_lyrics_pannel').hide()
		}
	});
	$("#closelrcpannel").click(function() {
		$('#player_lyrics_pannel').hide()
	});
	$("#jp-playlist-box li").live({
		"mouseover": function() {
			$(this).addClass("play_hover")
		},
		"mouseout": function() {
			$(this).removeClass("play_hover")
		}
	})
});
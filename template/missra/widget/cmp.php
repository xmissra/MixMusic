<?php
include '../../../source/system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
switch($_GET['id']){
	case 'video':
		echo "<cmp
		name = \"暂无视频\"
		skins = \"video/video.swf\"
		video = \"video/video.php?id=\"
		auto_play = \"1\"
		play_mode = \"1\"
		context_menu = \"0\"
		/>";
		break;
	case 'box':
		echo "<cmp
		name = \"暂无音乐\"
		skins = \"box/box.swf\"
		box = \"box/box.php?id=\"
		auto_play = \"1\"
		context_menu = \"0\"
		/>";
		break;
	case 'lrc':
		echo "<cmp
		description = \"暂无歌词\"
		skins = \"box/lrc.swf\"
		_lrc = \"box/lrc.php?id=\"
		volume = \"0\"
		auto_play = \"1\"
		context_menu = \"0\"
		/>";
		break;
	case 'share':
		echo "<cmp
		name = \"暂无音乐\"
		skins = \"share/share.swf\"
		share = \"share/share.php?id=\"
		auto_play = \"1\"
		play_mode = \"1\"
		context_menu = \"0\"
		/>";
		break;
	case 'fm':
		echo "<cmp
		name = \"暂无音乐\"
		description = \"暂无歌词\"
		skins = \"radio/fm.swf\"
		fm = \"radio/fm.php?id=\"
		auto_play = \"1\"
		list_delete = \"1\"
		mixer_id = \"10\"
		play_mode = \"2\"
		context_menu = \"0\"
		/>";
		break;
	case 'song':
		echo "<cmp
		name = \"暂无音乐\"
		description = \"暂无歌词\"
		skins = \"player/song.swf\"
		song = \"player/url.php?id=\"
		auto_play = \"1\"
		play_mode = \"1\"
		context_menu = \"0\"
		/>";
		break;
	case 'play':
		echo "<cmp
		name = \"暂无音乐\"
		description = \"暂无歌词\"
		skins = \"player/play.swf\"
		play = \"player/url.php?id=\"
		auto_play = \"1\"
		list_delete = \"1\"
		context_menu = \"0\"
		/>";
		break;
}
?>
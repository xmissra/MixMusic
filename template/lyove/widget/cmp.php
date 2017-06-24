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
		skins = \"video.swf\"
		video = \"video.php?id=\"
		auto_play = \"1\"
		play_mode = \"1\"
		context_menu = \"0\"
		/>";
		break;
	case 'share':
		echo "<cmp
		name = \"暂无音乐\"
		description = \"暂无歌词\"
		skins = \"share.swf\"
		share = \"url.php?id=\"
		auto_play = \"1\"
		play_mode = \"1\"
		context_menu = \"0\"
		/>";
		break;
	case 'play':
		echo "<cmp
		name = \"暂无音乐\"
		description = \"暂无歌词\"
		skins = \"play.swf\"
		play = \"url.php?id=\"
		auto_play = \"1\"
		list_delete = \"1\"
		context_menu = \"0\"
		/>";
		break;
}
?>
<?php
include '../../../source/system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db;
$ac = SafeRequest("ac","get");
$id = SafeRequest("id","get");
$uid = getfield('music', 'in_uid', 'in_id', $id);
$music = $db->num_rows($db->query("select count(*) from ".tname('music')." where in_uid=".$uid));
$special = $db->num_rows($db->query("select count(*) from ".tname('special')." where in_uid=".$uid));
$singer = $db->num_rows($db->query("select count(*) from ".tname('singer')." where in_uid=".$uid));
$video = $db->num_rows($db->query("select count(*) from ".tname('video')." where in_uid=".$uid));
if($ac == 'musicnum'){
	$showstr = "<span class=\"hotnumfb\">".$music."</span><br /><a href=\"".getlink($uid, 's_music')."\" target=\"_blank\">音乐</a>";
}elseif($ac == 'specialnum'){
	$showstr = "<span class=\"hotnumfb\">".$special."</span><br /><a href=\"".getlink($uid, 's_special')."\" target=\"_blank\">专辑</a>";
}elseif($ac == 'singernum'){
	$showstr = "<span class=\"hotnumfb\">".$singer."</span><br /><a href=\"".getlink($uid, 's_singer')."\" target=\"_blank\">歌手</a>";
}elseif($ac == 'videonum'){
	$showstr = "<span class=\"hotnumfb\">".$video."</span><br /><a href=\"".getlink($uid, 's_video')."\" target=\"_blank\">视频</a>";
}
echo $showstr;
?>
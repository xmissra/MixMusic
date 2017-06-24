<?php
include '../../../../source/system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
close_browse();
$id = SafeRequest("id","get");
$audio = geturl(getfield('music', 'in_audio', 'in_id', $id));
$name = getfield('music', 'in_name', 'in_id', $id);
$singer = getfield('singer', 'in_name', 'in_id', getfield('music', 'in_singerid', 'in_id', $id), '未知歌手');
$cover = geturl(getfield('music', 'in_cover', 'in_id', $id), 'cover');
$singercover = geturl(getfield('singer', 'in_cover', 'in_id', getfield('music', 'in_singerid', 'in_id', $id)), 'cover');
$fav = rewrite_mode('index.php/misc/mod/fav/'.$id.'/');
$down = rewrite_mode('index.php/misc/mod/down/'.$id.'/');
$type = substr(strrchr($audio, '.'), 1);
echo "<list><m type=\"".$type."\" src=\"".$audio."\" label=\"".$name." - ".$singer."\" lrc=\"".get_template(1)."source/lyric.php?id=".$id."\" image=\"".$cover."\" bg_video=\"{src:".$singercover.",xywh:[0,0,100,100]}\" _fav=\"".$fav."\" _down=\"".$down."\" /></list>";
?>
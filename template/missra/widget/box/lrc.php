<?php
include '../../../../source/system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
close_browse();
$id = SafeRequest("id","get");
$audio = geturl(getfield('music', 'in_audio', 'in_id', $id));
$type = substr(strrchr($audio, '.'), 1);
echo "<list><m type=\"".$type."\" src=\"".$audio."\" lrc=\"".get_template(1)."source/lyric.php?id=".$id."\" /></list>";
?>
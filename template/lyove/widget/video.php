<?php
include '../../../source/system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
close_browse();
$id = SafeRequest("id","get");
$play = geturl(getfield('video', 'in_play', 'in_id', $id));
$name = getfield('video', 'in_name', 'in_id', $id);
echo "<list><m type=\"video\" src=\"".$play."\" label=\"".$name."\" /></list>";
?>
<?php
include '../../../source/system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db;
$id = SafeRequest("id","get");
$query = $db->query("select * from ".tname('music')." where in_id in (".SafeSql($id, 1).")");
while ($row = $db->fetch_array($query)) {
        echo "<li onclick=\"box_play(".$row['in_id'].");\" id=\"box_play_".$row['in_id']."\"><strong class=\"music_name\">".getlenth($row['in_name'], 10)."</strong><strong class=\"singer_name\">".getfield('singer', 'in_name', 'in_id', getfield('music', 'in_singerid', 'in_id', $row['in_id']), '未知歌手')."</strong></li>";
}
?>
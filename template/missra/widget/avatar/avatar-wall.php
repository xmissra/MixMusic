<?php
include '../../../../source/system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/xml;charset=".IN_CHARSET);
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
echo "<avatarList>";
global $db;
$query = $db->query("select * from ".tname('user')." where in_isstar=1 order by in_rank desc LIMIT 0,38");
while ($row = $db->fetch_array($query)) {
echo "<avatar>";
echo "<user_name>";
echo convert_xmlcharset($row['in_username'], 2);
echo "</user_name>";
echo "<area>";
echo convert_xmlcharset($row['in_address'], 2);
echo "</area>";
echo "<sex>";
echo convert_xmlcharset(getsex($row['in_sex']), 2);
echo "</sex>";
echo "<avatar_url>";
echo getavatar($row['in_userid']);
echo "</avatar_url>";
echo "<link_url>";
echo getlink($row['in_userid']);
echo "</link_url>";
echo "</avatar>";
}
echo "</avatarList>";
?>
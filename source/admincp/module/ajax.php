<?php
if(!defined('IN_ROOT')){exit('Access denied');}
Administrator(1);
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db;
$level=intval(SafeRequest("level","get"));
$id=intval(SafeRequest("id","get"));
$sql="update ".tname('music')." set in_best=".$level." where in_id=".$id;
if($db->query($sql)){
	echo '1';
}
?>
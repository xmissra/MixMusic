<?php
include '../../../source/system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db;
$ac = SafeRequest("ac","get");
if($ac == 'goodbad'){
	$id = intval(SafeRequest("id","get"));
	$row = $db->getrow("select * from ".tname('music')." where in_id=".$id);
	$showstr = "<a class=\"dongStar\">评价：<font color=\"#FF3E3E\"><strong><i>+".$row['in_goodhits']."</i></strong></font> <font color=\"#398DFF\"><strong><i>-".$row['in_badhits']."</i></strong></font></a><a class=\"dongPing\" href=\"".rewrite_mode('index.php/misc/mod/wrong/'.$row['in_id'].'/')."\" target=\"_blank\">无法试听？</a>";
	echo $showstr;
}elseif($ac == 'dohits'){
	$do = SafeRequest("do","get");
	$id = intval(SafeRequest("id","get"));
	$field = $do == 'good' ? 'goodhits' : 'badhits';
	if($db->getone("select in_id from ".tname('music')." where in_id=".$id)){
		$cookie = 'in_like_music_'.$id;
		if(!empty($_COOKIE[$cookie])){
		        exit('return_2');
		}
		setcookie($cookie, 'have', time()+1800, IN_PATH);
		$db->query("update ".tname('music')." set in_".$field."=in_".$field."+1 where in_id=".$id);
		echo 'return_3';
	}else{
                echo 'return_1';
	}
}
?>
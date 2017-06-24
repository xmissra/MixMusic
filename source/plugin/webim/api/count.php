<?php
include '../../../system/db.class.php';
include '../../../system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db,$userlogined,$missra_in_userid;
$userlogined or exit("{count:-1}");
$gid = intval(SafeRequest("gid","get"));
if($gid > 0){
        $n = $db->num_rows($db->query("select count(*) from ".tname('friend')." where in_gid=".$gid));
	$s = 0;
	$m = 0;
	$query = $db->query("select * from ".tname('friend')." where in_gid=".$gid);
	while($row = $db->fetch_array($query)){
		if(getfield('session', 'in_id', 'in_uid', $row['in_uids'])){
			$s = $s + 1;
		}
		$c = $db->num_rows($db->query("select count(*) from ".tname('message')." where in_isread=0 and in_uid=".$row['in_uids']." and in_uids=".$missra_in_userid));
		$m = $m + $c;
	}
}else{
	$n = 0;
	$s = 0;
	$m = 0;
	$query = $db->query("select * from ".tname('user')." where in_islock=0");
	while($row = $db->fetch_array($query)){
		if(!$db->getone("select in_id from ".tname('friend')." where in_uid=".$missra_in_userid." and in_uids=".$row['in_userid'])){
			$n = $n + 1;
			if(getfield('session', 'in_id', 'in_uid', $row['in_userid'])){
				$s = $s + 1;
			}
			$c = $db->num_rows($db->query("select count(*) from ".tname('message')." where in_isread=0 and in_uid=".$row['in_userid']." and in_uids=".$missra_in_userid));
			$m = $m + $c;
		}
	}
}
echo "{count:'".$s."/".$n."[<label style=\"color:#F60\">".$m."</label>]'}";
?>
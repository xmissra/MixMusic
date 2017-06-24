<?php
include '../../system/db.class.php';
include '../../system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db,$userlogined;
$ac=SafeRequest("ac","get");
if($ac == 'add'){
	$username = unescape(SafeRequest("name","get"));
	$message = unescape(SafeRequest("msg","get"));
	global $missra_in_userid,$missra_in_username;
	$userid = $db->getone("select in_userid from ".tname('user')." where in_islock=0 and in_username='".$username."'");
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$userid){
		echo 'return_2';
	}elseif($userid == $missra_in_userid){
		echo 'return_3';
	}else{
		$setarr = array(
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_uids' => $userid,
			'in_unames' => $username,
			'in_content' => preg_replace('/.php\?/i', '', $message),
			'in_isread' => 0,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('message', $setarr, 1);
		echo 'return_4';
	}
}elseif($ac == 'del'){
	$msgid = intval(SafeRequest("id","get"));
	global $missra_in_userid;
	$userid = $db->getone("select in_uids from ".tname('message')." where in_id=".$msgid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$userid){
		echo 'return_2';
	}elseif($userid !== $missra_in_userid){
		echo 'return_3';
	}else{
		$db->query("delete from ".tname('message')." where in_id=".$msgid);
		echo 'return_4';
	}
}elseif($ac == 'set'){
	$id = SafeRequest("id","get");
	global $missra_in_userid;
	if(!$userlogined){
		echo 'return_1';
	}else{
		if($id > 0){
		        $db->query("update ".tname('message')." set in_isread=1 where in_isread=0 and in_uids=".$missra_in_userid);
		}else{
		        $db->query("delete from ".tname('message')." where in_isread=1 and in_uids=".$missra_in_userid);
		}
		echo 'return_2';
	}
}elseif($ac == 'reply'){
	$userid = intval(SafeRequest("uid","get"));
	$message = unescape(SafeRequest("msg","get"));
	global $missra_in_userid,$missra_in_username;
	if(!$userlogined){
		echo 'return_1';
	}else{
		$username = $db->getone("select in_username from ".tname('user')." where in_userid=".$userid);
		$setarr = array(
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_uids' => $userid,
			'in_unames' => $username,
			'in_content' => preg_replace('/.php\?/i', '', $message),
			'in_isread' => 0,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('message', $setarr, 1);
		echo 'return_2';
	}
}
?>
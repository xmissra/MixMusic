<?php
include '../../system/db.class.php';
include '../../system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db,$userlogined;
$ac=SafeRequest("ac","get");
if($ac == 'insert'){
	$uname = unescape(SafeRequest("name","get"));
	$msg = unescape(SafeRequest("msg","get"));
	$gid = intval(SafeRequest("gid","get"));
	global $missra_in_userid,$missra_in_username;
	$uid = $db->getone("select in_userid from ".tname('user')." where in_islock=0 and in_username='".$uname."'");
	$guid = $db->getone("select in_uid from ".tname('friend_group')." where in_id=".$gid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$uid){
		echo 'return_2';
	}elseif(!$guid){
		echo 'return_3';
	}elseif($uid == $missra_in_userid){
		echo 'return_4';
	}elseif($guid !== $missra_in_userid){
		echo 'return_5';
	}else{
		if(!empty($msg)){
		        $setarr = array(
			        'in_uid' => $missra_in_userid,
			        'in_uname' => $missra_in_username,
			        'in_uids' => $uid,
			        'in_unames' => $uname,
			        'in_content' => $msg,
			        'in_isread' => 0,
			        'in_addtime' => date('Y-m-d H:i:s')
		        );
		        inserttable('message', $setarr, 1);
		}
		if($fid = $db->getone("select in_id from ".tname('friend')." where in_uid=".$missra_in_userid." and in_uids=".$uid)){
		        updatetable('friend', array('in_gid' => $gid,'in_addtime' => date('Y-m-d H:i:s')), array('in_id' => $fid));
		}else{
		        $setarrs = array(
			        'in_gid' => $gid,
			        'in_uid' => $missra_in_userid,
			        'in_uname' => $missra_in_username,
			        'in_uids' => $uid,
			        'in_unames' => $uname,
			        'in_addtime' => date('Y-m-d H:i:s')
		        );
		        inserttable('friend', $setarrs, 1);
		}
		echo 'return_6';
	}
}elseif($ac == 'f_del'){
	$fid = intval(SafeRequest("id","get"));
	global $missra_in_userid;
	$uid = $db->getone("select in_uid from ".tname('friend')." where in_id=".$fid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$uid){
		echo 'return_2';
	}elseif($uid !== $missra_in_userid){
		echo 'return_3';
	}else{
		$db->query("delete from ".tname('friend')." where in_id=".$fid);
		echo 'return_4';
	}
}elseif($ac == 'change'){
	$fid = intval(SafeRequest("fid","get"));
	$gid = intval(SafeRequest("gid","get"));
	global $missra_in_userid;
	$fuid = $db->getone("select in_uid from ".tname('friend')." where in_id=".$fid);
	$guid = $db->getone("select in_uid from ".tname('friend_group')." where in_id=".$gid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$fuid){
		echo 'return_2';
	}elseif(!$guid){
		echo 'return_3';
	}elseif($fuid !== $missra_in_userid){
		echo 'return_4';
	}elseif($guid !== $missra_in_userid){
		echo 'return_5';
	}else{
		updatetable('friend', array('in_gid' => $gid), array('in_id' => $fid));
		echo 'return_6';
	}
}elseif($ac == 'add'){
	$title = unescape(SafeRequest("title","get"));
	global $missra_in_userid,$missra_in_username;
	if(!$userlogined){
		echo 'return_1';
	}elseif($db->getone("select in_id from ".tname('friend_group')." where in_title='".$title."' and in_uid=".$missra_in_userid)){
		echo 'return_2';
	}else{
		$setarr = array(
			'in_title' => $title,
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username
		);
		inserttable('friend_group', $setarr, 1);
		echo 'return_3';
	}
}elseif($ac == 'del'){
	$gid = intval(SafeRequest("id","get"));
	global $missra_in_userid;
	$userid = $db->getone("select in_uid from ".tname('friend_group')." where in_id=".$gid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$userid){
		echo 'return_2';
	}elseif($userid !== $missra_in_userid){
		echo 'return_3';
	}else{
		$db->query("delete from ".tname('friend')." where in_gid=".$gid);
		$db->query("delete from ".tname('friend_group')." where in_id=".$gid);
		echo 'return_4';
	}
}elseif($ac == 'edi'){
	$gid = intval(SafeRequest("id","get"));
	$title = unescape(SafeRequest("title","get"));
	global $missra_in_userid;
	$userid = $db->getone("select in_uid from ".tname('friend_group')." where in_id=".$gid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$userid){
		echo 'return_2';
	}elseif($userid !== $missra_in_userid){
		echo 'return_3';
	}elseif($db->getone("select in_id from ".tname('friend_group')." where in_id<>".$gid." and in_title='".$title."' and in_uid=".$missra_in_userid)){
		echo 'return_4';
	}else{
		updatetable('friend_group', array('in_title' => $title), array('in_id' => $gid));
		echo 'return_5';
	}
}
?>
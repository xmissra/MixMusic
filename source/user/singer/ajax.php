<?php
include '../../system/db.class.php';
include '../../system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db,$userlogined;
$ac=SafeRequest("ac","get");
if($ac == 'del'){
	$id = intval(SafeRequest("id","get"));
	global $missra_in_userid;
	$row = $db->getrow("select in_uid,in_passed from ".tname('singer')." where in_id=".$id);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$row){
		echo 'return_2';
	}elseif($row['in_uid'] !== $missra_in_userid){
		echo 'return_3';
	}elseif($row['in_passed'] == 0){
		echo 'return_4';
	}else{
		SafeDel('singer', 'in_cover', $id);
		$db->query("delete from ".tname('comment')." where in_table='singer' and in_tid=".$id);
		$db->query("delete from ".tname('feed')." where in_icon='singer' and in_tid=".$id);
		$db->query("delete from ".tname('singer')." where in_id=".$id);
		echo 'return_5';
	}
}elseif($ac == 'add'){
	$name = unescape(SafeRequest("name","get"));
	$classid = intval(SafeRequest("classid","get"));
	$nick = unescape(SafeRequest("nick","get"));
	$cover = checkrename(unescape(SafeRequest("cover","get")), 'attachment/singer/cover');
	$intro = unescape(SafeRequest("intro","get"));
	$content = ReplaceStr($intro,"&lt;br /&gt;","\r\n");
	$time = date('Y-m-d H:i:s');
	global $missra_in_userid,$missra_in_username;
	$cid = $db->getone("select in_id from ".tname('singer_class')." where in_id=".$classid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$cid){
		echo 'return_2';
	}else{
		$setarr = array(
			'in_name' => $name,
			'in_nick' => $nick,
			'in_classid' => $classid,
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_cover' => $cover,
			'in_intro' => $content,
			'in_hits' => 0,
			'in_passed' => 1,
			'in_addtime' => $time
		);
		$sid = inserttable('singer', $setarr, 1);
		$setarrs = array(
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_type' => 1,
			'in_tid' => $sid,
			'in_icon' => 'singer',
			'in_title' => '创建了歌手',
			'in_content' => getlenth($content, 100),
			'in_addtime' => $time
		);
		inserttable('feed', $setarrs, 1);
		echo 'return_3';
	}
}elseif($ac == 'edit'){
	$id = intval(SafeRequest("id","get"));
	$name = unescape(SafeRequest("name","get"));
	$classid = intval(SafeRequest("classid","get"));
	$nick = unescape(SafeRequest("nick","get"));
	$cover = checkrename(unescape(SafeRequest("cover","get")), 'attachment/singer/cover', getfield('singer', 'in_cover', 'in_id', $id), 'edit', 'singer', 'in_cover', $id);
	$intro = unescape(SafeRequest("intro","get"));
	$content = ReplaceStr($intro,"&lt;br /&gt;","\r\n");
	global $missra_in_userid;
	$row = $db->getrow("select in_uid,in_passed from ".tname('singer')." where in_id=".$id);
	$cid = $db->getone("select in_id from ".tname('singer_class')." where in_id=".$classid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$row){
		echo 'return_2';
	}elseif(!$cid){
		echo 'return_3';
	}elseif($row['in_uid'] !== $missra_in_userid){
		echo 'return_4';
	}elseif($row['in_passed'] == 0){
		echo 'return_5';
	}else{
		updatetable('singer', array('in_name' => $name,'in_classid' => $classid,'in_nick' => $nick,'in_cover' => $cover,'in_intro' => $content,'in_addtime' => date('Y-m-d H:i:s')), array('in_id' => $id));
		echo 'return_6';
	}
}
?>
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
	$row = $db->getrow("select in_uid,in_passed from ".tname('special')." where in_id=".$id);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$row){
		echo 'return_2';
	}elseif($row['in_uid'] !== $missra_in_userid){
		echo 'return_3';
	}elseif($row['in_passed'] == 0){
		echo 'return_4';
	}else{
		SafeDel('special', 'in_cover', $id);
		$db->query("delete from ".tname('comment')." where in_table='special' and in_tid=".$id);
		$db->query("delete from ".tname('feed')." where in_icon='special' and in_tid=".$id);
		$db->query("delete from ".tname('special')." where in_id=".$id);
		echo 'return_5';
	}
}elseif($ac == 'add'){
	$name = unescape(SafeRequest("name","get"));
	$classid = intval(SafeRequest("classid","get"));
	$singerid = intval(SafeRequest("singerid","get"));
	$firm = unescape(SafeRequest("firm","get"));
	$lang = unescape(SafeRequest("lang","get"));
	$cover = checkrename(unescape(SafeRequest("cover","get")), 'attachment/special/cover');
	$intro = unescape(SafeRequest("intro","get"));
	$content = ReplaceStr($intro,"&lt;br /&gt;","\r\n");
	$time = date('Y-m-d H:i:s');
	global $missra_in_userid,$missra_in_username;
	$cid = $db->getone("select in_id from ".tname('special_class')." where in_id=".$classid);
	$sid = $db->getone("select in_id from ".tname('singer')." where in_id=".$singerid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$cid){
		echo 'return_2';
	}elseif($singerid > 0 && !$sid){
		echo 'return_3';
	}else{
		$setarr = array(
			'in_name' => $name,
			'in_classid' => $classid,
			'in_singerid' => $singerid,
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_cover' => $cover,
			'in_intro' => $content,
			'in_firm' => $firm,
			'in_lang' => $lang,
			'in_hits' => 0,
			'in_passed' => 1,
			'in_addtime' => $time
		);
		$aid = inserttable('special', $setarr, 1);
		$setarrs = array(
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_type' => 1,
			'in_tid' => $aid,
			'in_icon' => 'special',
			'in_title' => '制作了专辑',
			'in_content' => getlenth($content, 100),
			'in_addtime' => $time
		);
		inserttable('feed', $setarrs, 1);
		echo 'return_4';
	}
}elseif($ac == 'edit'){
	$id = intval(SafeRequest("id","get"));
	$name = unescape(SafeRequest("name","get"));
	$classid = intval(SafeRequest("classid","get"));
	$singerid = intval(SafeRequest("singerid","get"));
	$firm = unescape(SafeRequest("firm","get"));
	$lang = unescape(SafeRequest("lang","get"));
	$cover = checkrename(unescape(SafeRequest("cover","get")), 'attachment/special/cover', getfield('special', 'in_cover', 'in_id', $id), 'edit', 'special', 'in_cover', $id);
	$intro = unescape(SafeRequest("intro","get"));
	$content = ReplaceStr($intro,"&lt;br /&gt;","\r\n");
	global $missra_in_userid;
	$row = $db->getrow("select in_uid,in_passed from ".tname('special')." where in_id=".$id);
	$cid = $db->getone("select in_id from ".tname('special_class')." where in_id=".$classid);
	$sid = $db->getone("select in_id from ".tname('singer')." where in_id=".$singerid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$row){
		echo 'return_2';
	}elseif(!$cid){
		echo 'return_3';
	}elseif($singerid > 0 && !$sid){
		echo 'return_4';
	}elseif($row['in_uid'] !== $missra_in_userid){
		echo 'return_5';
	}elseif($row['in_passed'] == 0){
		echo 'return_6';
	}else{
		updatetable('special', array('in_name' => $name,'in_classid' => $classid,'in_singerid' => $singerid,'in_firm' => $firm,'in_lang' => $lang,'in_cover' => $cover,'in_intro' => $content,'in_addtime' => date('Y-m-d H:i:s')), array('in_id' => $id));
		echo 'return_7';
	}
}
?>
<?php
include '../../system/db.class.php';
include '../../system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db,$userlogined;
$ac=SafeRequest("ac","get");
if($ac == 'delete'){
	$pre = SafeRequest("table","get");
	$table = $pre == 'listen' ? 'listen' : 'favorites';
	$id = intval(SafeRequest("id","get"));
	global $missra_in_userid;
	$uid = $db->getone("select in_uid from ".tname($table)." where in_id=".$id);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$uid){
		echo 'return_2';
	}elseif($uid !== $missra_in_userid){
		echo 'return_3';
	}else{
		$db->query("delete from ".tname($table)." where in_id=".$id);
		echo 'return_4';
	}
}elseif($ac == 'del'){
	$id = intval(SafeRequest("id","get"));
	global $missra_in_userid;
	$row = $db->getrow("select in_uid,in_passed from ".tname('music')." where in_id=".$id);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$row){
		echo 'return_2';
	}elseif($row['in_uid'] !== $missra_in_userid){
		echo 'return_3';
	}elseif($row['in_passed'] == 0){
		echo 'return_4';
	}else{
		SafeDel('music', 'in_audio', $id);
		SafeDel('music', 'in_lyric', $id);
		SafeDel('music', 'in_cover', $id);
		$db->query("delete from ".tname('favorites')." where in_mid=".$id);
		$db->query("delete from ".tname('listen')." where in_mid=".$id);
		$db->query("delete from ".tname('comment')." where in_table='music' and in_tid=".$id);
		$db->query("delete from ".tname('feed')." where in_icon='music' and in_tid=".$id);
		$db->query("delete from ".tname('music')." where in_id=".$id);
		echo 'return_5';
	}
}elseif($ac == 'add'){
	$name = unescape(SafeRequest("name","get"));
	$classid = intval(SafeRequest("classid","get"));
	$audio = checkrename(unescape(SafeRequest("audio","get")), 'attachment/music/audio');
	$specialid = intval(SafeRequest("specialid","get"));
	$singerid = intval(SafeRequest("singerid","get"));
	$tag = unescape(SafeRequest("tag","get"));
	$cover = checkrename(unescape(SafeRequest("cover","get")), 'attachment/music/cover');
	$lyric = checkrename(unescape(SafeRequest("lyric","get")), 'attachment/music/lyric');
	$text = unescape(SafeRequest("text","get"));
	$content = ReplaceStr($text,"&lt;br /&gt;","\r\n");
	$time = date('Y-m-d H:i:s');
	global $missra_in_userid,$missra_in_username;
	$cid = $db->getone("select in_id from ".tname('class')." where in_id=".$classid);
	$aid = $db->getone("select in_id from ".tname('special')." where in_id=".$specialid);
	$sid = $db->getone("select in_id from ".tname('singer')." where in_id=".$singerid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$cid){
		echo 'return_2';
	}elseif($specialid > 0 && !$aid){
		echo 'return_3';
	}elseif($singerid > 0 && !$sid){
		echo 'return_4';
	}else{
		$setarr = array(
			'in_name' => $name,
			'in_classid' => $classid,
			'in_specialid' => $specialid,
			'in_singerid' => $singerid,
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_audio' => $audio,
			'in_lyric' => $lyric,
			'in_text' => $content,
			'in_cover' => $cover,
			'in_tag' => $tag,
			'in_color' => '',
			'in_hits' => 0,
			'in_downhits' => 0,
			'in_favhits' => 0,
			'in_goodhits' => 0,
			'in_badhits' => 0,
			'in_points' => 0,
			'in_grade' => 3,
			'in_best' => 0,
			'in_passed' => 1,
			'in_wrong' => 0,
			'in_addtime' => $time
		);
		$mid = inserttable('music', $setarr, 1);
		$setarrs = array(
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_type' => 1,
			'in_tid' => $mid,
			'in_icon' => 'music',
			'in_title' => '上传了音乐',
			'in_content' => getlenth($content, 100),
			'in_addtime' => $time
		);
		inserttable('feed', $setarrs, 1);
		echo 'return_5';
	}
}elseif($ac == 'edit'){
	$id = intval(SafeRequest("id","get"));
	$name = unescape(SafeRequest("name","get"));
	$classid = intval(SafeRequest("classid","get"));
	$audio = checkrename(unescape(SafeRequest("audio","get")), 'attachment/music/audio', getfield('music', 'in_audio', 'in_id', $id), 'edit', 'music', 'in_audio', $id);
	$specialid = intval(SafeRequest("specialid","get"));
	$singerid = intval(SafeRequest("singerid","get"));
	$tag = unescape(SafeRequest("tag","get"));
	$cover = checkrename(unescape(SafeRequest("cover","get")), 'attachment/music/cover', getfield('music', 'in_cover', 'in_id', $id), 'edit', 'music', 'in_cover', $id);
	$lyric = checkrename(unescape(SafeRequest("lyric","get")), 'attachment/music/lyric', getfield('music', 'in_lyric', 'in_id', $id), 'edit', 'music', 'in_lyric', $id);
	$text = unescape(SafeRequest("text","get"));
	$content = ReplaceStr($text,"&lt;br /&gt;","\r\n");
	global $missra_in_userid;
	$row = $db->getrow("select in_uid,in_passed from ".tname('music')." where in_id=".$id);
	$cid = $db->getone("select in_id from ".tname('class')." where in_id=".$classid);
	$aid = $db->getone("select in_id from ".tname('special')." where in_id=".$specialid);
	$sid = $db->getone("select in_id from ".tname('singer')." where in_id=".$singerid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$row){
		echo 'return_2';
	}elseif(!$cid){
		echo 'return_3';
	}elseif($specialid > 0 && !$aid){
		echo 'return_4';
	}elseif($singerid > 0 && !$sid){
		echo 'return_5';
	}elseif($row['in_uid'] !== $missra_in_userid){
		echo 'return_6';
	}elseif($row['in_passed'] == 0){
		echo 'return_7';
	}else{
		$setarr = array(
			'in_name' => $name,
			'in_classid' => $classid,
			'in_specialid' => $specialid,
			'in_singerid' => $singerid,
			'in_audio' => $audio,
			'in_tag' => $tag,
			'in_cover' => $cover,
			'in_lyric' => $lyric,
			'in_text' => $content,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		updatetable('music', $setarr, array('in_id' => $id));
		echo 'return_8';
	}
}
?>
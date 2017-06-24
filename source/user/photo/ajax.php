<?php
include '../../system/db.class.php';
include '../../system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db,$userlogined;
$ac=SafeRequest("ac","get");
if($ac == 'share'){
	$id = intval(SafeRequest("id","get"));
	global $missra_in_userid,$missra_in_username;
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$db->getone("select in_id from ".tname('photo_group')." where in_id=".$id)){
		echo 'return_2';
	}else{
		$nums = $db->num_rows($db->query("select count(*) from ".tname('photo')." where in_gid=".$id));
		if($fid = $db->getone("select in_id from ".tname('feed')." where in_icon='photo' and in_uid=".$missra_in_userid." and in_tid=".$id)){
		        updatetable('feed', array('in_addtime' => date('Y-m-d H:i:s'),'in_content' => '共 '.$nums.' 张照片'), array('in_id' => $fid));
		        exit('return_3');
		}
		$setarr = array(
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_type' => 1,
			'in_tid' => $id,
			'in_icon' => 'photo',
			'in_title' => '推荐了一个相册',
			'in_content' => '共 '.$nums.' 张照片',
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('feed', $setarr, 1);
		echo 'return_3';
	}
}elseif($ac == 'add'){
	$photo = unescape(SafeRequest("photo","get"));
	global $missra_in_userid,$missra_in_username;
	if(!$userlogined){
		echo 'return_1';
	}elseif($db->getone("select in_id from ".tname('photo_group')." where in_title='".$photo."' and in_uid=".$missra_in_userid)){
		echo 'return_2';
	}else{
		$setarr = array(
			'in_pid' => 0,
			'in_title' => $photo,
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username
		);
		inserttable('photo_group', $setarr, 1);
		echo 'return_3';
	}
}elseif($ac == 'del'){
	$gid = intval(SafeRequest("id","get"));
	global $missra_in_userid;
	$userid = $db->getone("select in_uid from ".tname('photo_group')." where in_id=".$gid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$userid){
		echo 'return_2';
	}elseif($userid !== $missra_in_userid){
		echo 'return_3';
	}else{
		$query = $db->query("select in_url,in_id from ".tname('photo')." where in_gid=".$gid);
		while ($row = $db->fetch_array($query)) {
			if(is_file(IN_ROOT.$row['in_url'])){@unlink(IN_ROOT.$row['in_url']);}
			$db->query("delete from ".tname('comment')." where in_table='photo' and in_tid=".$row['in_id']);
		}
		$db->query("delete from ".tname('photo')." where in_gid=".$gid);
		$db->query("delete from ".tname('photo_group')." where in_id=".$gid);
		$db->query("delete from ".tname('feed')." where in_icon='photo' and in_tid=".$gid);
		echo 'return_4';
	}
}elseif($ac == 'edit'){
	$gid = intval(SafeRequest("id","get"));
	$title = unescape(SafeRequest("title","get"));
	global $missra_in_userid;
	$userid = $db->getone("select in_uid from ".tname('photo_group')." where in_id=".$gid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$userid){
		echo 'return_2';
	}elseif($userid !== $missra_in_userid){
		echo 'return_3';
	}elseif($db->getone("select in_id from ".tname('photo_group')." where in_id<>".$gid." and in_title='".$title."' and in_uid=".$missra_in_userid)){
		echo 'return_4';
	}else{
		updatetable('photo_group', array('in_title' => $title), array('in_id' => $gid));
		echo 'return_5';
	}
}elseif($ac == 'cover'){
	$pid = intval(SafeRequest("id","get"));
	global $missra_in_userid;
	$row = $db->getrow("select in_uid,in_gid from ".tname('photo')." where in_id=".$pid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$row){
		echo 'return_2';
	}elseif($row['in_uid'] !== $missra_in_userid){
		echo 'return_3';
	}else{
		updatetable('photo_group', array('in_pid' => $pid), array('in_id' => $row['in_gid']));
		echo 'return_4';
	}
}elseif($ac == 'cancel'){
	$pid = intval(SafeRequest("id","get"));
	global $missra_in_userid;
	$row = $db->getrow("select in_uid,in_url from ".tname('photo')." where in_id=".$pid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$row){
		echo 'return_2';
	}elseif($row['in_uid'] !== $missra_in_userid){
		echo 'return_3';
	}else{
		if(is_file(IN_ROOT.$row['in_url'])){@unlink(IN_ROOT.$row['in_url']);}
		$db->query("delete from ".tname('comment')." where in_table='photo' and in_tid=".$pid);
		$db->query("delete from ".tname('photo')." where in_id=".$pid);
		echo 'return_4';
	}
}elseif($ac == 'change'){
	$pid = intval(SafeRequest("pid","get"));
	$gid = intval(SafeRequest("gid","get"));
	$title = unescape(SafeRequest("title","get"));
	global $missra_in_userid;
	$puid = $db->getone("select in_uid from ".tname('photo')." where in_id=".$pid);
	$guid = $db->getone("select in_uid from ".tname('photo_group')." where in_id=".$gid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$puid){
		echo 'return_2';
	}elseif(!$guid){
		echo 'return_3';
	}elseif($puid !== $missra_in_userid){
		echo 'return_4';
	}elseif($guid !== $missra_in_userid){
		echo 'return_5';
	}else{
		updatetable('photo', array('in_gid' => $gid,'in_title' => $title,'in_addtime' => date('Y-m-d H:i:s')), array('in_id' => $pid));
		echo 'return_6';
	}
}elseif($ac == 'dig'){
	$id = intval(SafeRequest("id","get"));
	$field = SafeRequest("field","get");
	global $missra_in_userid;
	$uid = $db->getone("select in_uid from ".tname('photo')." where in_id=".$id);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$uid){
		echo 'return_2';
	}elseif($uid == $missra_in_userid){
		echo 'return_3';
	}elseif(in_array($field, array('egg', 'flower', 'scary', 'cool', 'beautiful'))){
		$cookie = 'in_dig_photo_'.$id;
		if(!empty($_COOKIE[$cookie])){
		        exit('return_4');
		}
		setcookie($cookie, 'have', time()+1800, IN_PATH);
		$db->query("update ".tname('photo')." set in_".$field."=in_".$field."+1 where in_id=".$id);
		echo 'return_5';
	}
}elseif($ac == 'comment'){
	$id = intval(SafeRequest("id","get"));
	$content = unescape(SafeRequest("content","get"));
	global $missra_in_userid,$missra_in_username;
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$db->getone("select in_id from ".tname('photo')." where in_id=".$id)){
		echo 'return_2';
	}else{
		$cookie = 'in_comment_photo_'.$id;
		if(!empty($_COOKIE[$cookie])){
		        exit('return_3');
		}
		setcookie($cookie, 'have', time()+30, IN_PATH);
		$setarr = array(
			'in_table' => 'photo',
			'in_tid' => $id,
			'in_content' => $content,
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('comment', $setarr, 1);
		echo 'return_4';
	}
}elseif($ac == 'c_del'){
	$id = intval(SafeRequest("id","get"));
	global $missra_in_userid;
	$tid = $db->getone("select in_tid from ".tname('comment')." where in_table='photo' and in_id=".$id);
	$uid = $db->getone("select in_uid from ".tname('photo')." where in_id=".$tid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$tid){
		echo 'return_2';
	}elseif($uid !== $missra_in_userid){
		echo 'return_3';
	}else{
		$db->query("delete from ".tname('comment')." where in_id=".$id);
		echo 'return_4';
	}
}
?>
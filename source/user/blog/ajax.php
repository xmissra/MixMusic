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
	$row = $db->getrow("select in_id,in_content from ".tname('blog')." where in_id=".$id);
	$content = getlenth(strip_tags(htmlspecialchars_decode($row['in_content'], ENT_QUOTES)), 100);
	$content = htmlspecialchars(trim($content), ENT_QUOTES, set_chars());
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$row){
		echo 'return_2';
	}else{
		if($fid = $db->getone("select in_id from ".tname('feed')." where in_icon='blog' and in_uid=".$missra_in_userid." and in_tid=".$id)){
		        updatetable('feed', array('in_addtime' => date('Y-m-d H:i:s'),'in_content' => $content), array('in_id' => $fid));
		        exit('return_3');
		}
		$setarr = array(
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_type' => 1,
			'in_tid' => $row['in_id'],
			'in_icon' => 'blog',
			'in_title' => '推荐了一篇日志',
			'in_content' => $content,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('feed', $setarr, 1);
		echo 'return_3';
	}
}elseif($ac == 'add'){
	$title = unescape(SafeRequest("title","get"));
	global $missra_in_userid,$missra_in_username;
	if(!$userlogined){
		echo 'return_1';
	}elseif($db->getone("select in_id from ".tname('blog_group')." where in_title='".$title."' and in_uid=".$missra_in_userid)){
		echo 'return_2';
	}else{
		$setarr = array(
			'in_title' => $title,
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username
		);
		inserttable('blog_group', $setarr, 1);
		echo 'return_3';
	}
}elseif($ac == 'del'){
	$gid = intval(SafeRequest("id","get"));
	global $missra_in_userid;
	$userid = $db->getone("select in_uid from ".tname('blog_group')." where in_id=".$gid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$userid){
		echo 'return_2';
	}elseif($userid !== $missra_in_userid){
		echo 'return_3';
	}else{
		$query = $db->query("select in_id from ".tname('blog')." where in_gid=".$gid);
		while ($row = $db->fetch_array($query)) {
			$db->query("delete from ".tname('comment')." where in_table='blog' and in_tid=".$row['in_id']);
			$db->query("delete from ".tname('feed')." where in_icon='blog' and in_tid=".$row['in_id']);
		}
		$db->query("delete from ".tname('blog')." where in_gid=".$gid);
		$db->query("delete from ".tname('blog_group')." where in_id=".$gid);
		echo 'return_4';
	}
}elseif($ac == 'edit'){
	$gid = intval(SafeRequest("id","get"));
	$title = unescape(SafeRequest("title","get"));
	global $missra_in_userid;
	$userid = $db->getone("select in_uid from ".tname('blog_group')." where in_id=".$gid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$userid){
		echo 'return_2';
	}elseif($userid !== $missra_in_userid){
		echo 'return_3';
	}elseif($db->getone("select in_id from ".tname('blog_group')." where in_id<>".$gid." and in_title='".$title."' and in_uid=".$missra_in_userid)){
		echo 'return_4';
	}else{
		updatetable('blog_group', array('in_title' => $title), array('in_id' => $gid));
		echo 'return_5';
	}
}elseif($ac == 'insert'){
	$classid = intval(SafeRequest("id","get"));
	$title = unescape(SafeRequest("t","get"));
	$search = array('http://'.$_SERVER['HTTP_HOST'].IN_PATH.'static/user/images/face/', 'http://'.$_SERVER['HTTP_HOST'].IN_PATH.'data/attachment/photo/');
	$replace = array('static/user/images/face/', 'data/attachment/photo/');
	$content = str_replace($search, $replace, unescape(SafeRequest("c","get")));
	global $missra_in_userid,$missra_in_username;
	$userid = $db->getone("select in_uid from ".tname('blog_group')." where in_id=".$classid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$userid){
		echo 'return_2';
	}elseif($userid !== $missra_in_userid){
		echo 'return_3';
	}else{
		$setarr = array(
			'in_gid' => $classid,
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_title' => $title,
			'in_content' => preg_replace('/.php\?/i', '', $content),
			'in_hits' => 0,
			'in_egg' => 0,
			'in_flower' => 0,
			'in_scary' => 0,
			'in_cool' => 0,
			'in_beautiful' => 0,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('blog', $setarr, 1);
		echo 'return_4';
	}
}elseif($ac == 'cancel'){
	$bid = intval(SafeRequest("id","get"));
	global $missra_in_userid;
	$uid = $db->getone("select in_uid from ".tname('blog')." where in_id=".$bid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$uid){
		echo 'return_2';
	}elseif($uid !== $missra_in_userid){
		echo 'return_3';
	}else{
		$db->query("delete from ".tname('comment')." where in_table='blog' and in_tid=".$bid);
		$db->query("delete from ".tname('feed')." where in_icon='blog' and in_tid=".$bid);
		$db->query("delete from ".tname('blog')." where in_id=".$bid);
		echo 'return_4';
	}
}elseif($ac == 'change'){
	$bid = intval(SafeRequest("bid","get"));
	$gid = intval(SafeRequest("gid","get"));
	$title = unescape(SafeRequest("t","get"));
	$search = array('http://'.$_SERVER['HTTP_HOST'].IN_PATH.'static/user/images/face/', 'http://'.$_SERVER['HTTP_HOST'].IN_PATH.'data/attachment/photo/');
	$replace = array('static/user/images/face/', 'data/attachment/photo/');
	$content = str_replace($search, $replace, unescape(SafeRequest("c","get")));
	global $missra_in_userid;
	$buid = $db->getone("select in_uid from ".tname('blog')." where in_id=".$bid);
	$guid = $db->getone("select in_uid from ".tname('blog_group')." where in_id=".$gid);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$buid){
		echo 'return_2';
	}elseif(!$guid){
		echo 'return_3';
	}elseif($buid !== $missra_in_userid){
		echo 'return_4';
	}elseif($guid !== $missra_in_userid){
		echo 'return_5';
	}else{
		updatetable('blog', array('in_gid' => $gid,'in_title' => $title,'in_content' => preg_replace('/.php\?/i', '', $content),'in_addtime' => date('Y-m-d H:i:s')), array('in_id' => $bid));
		echo 'return_6';
	}
}elseif($ac == 'dig'){
	$id = intval(SafeRequest("id","get"));
	$field = SafeRequest("field","get");
	global $missra_in_userid;
	$uid = $db->getone("select in_uid from ".tname('blog')." where in_id=".$id);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$uid){
		echo 'return_2';
	}elseif($uid == $missra_in_userid){
		echo 'return_3';
	}elseif(in_array($field, array('egg', 'flower', 'scary', 'cool', 'beautiful'))){
		$cookie = 'in_dig_blog_'.$id;
		if(!empty($_COOKIE[$cookie])){
		        exit('return_4');
		}
		setcookie($cookie, 'have', time()+1800, IN_PATH);
		$db->query("update ".tname('blog')." set in_".$field."=in_".$field."+1 where in_id=".$id);
		echo 'return_5';
	}
}elseif($ac == 'comment'){
	$id = intval(SafeRequest("id","get"));
	$content = unescape(SafeRequest("content","get"));
	global $missra_in_userid,$missra_in_username;
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$db->getone("select in_id from ".tname('blog')." where in_id=".$id)){
		echo 'return_2';
	}else{
		$cookie = 'in_comment_blog_'.$id;
		if(!empty($_COOKIE[$cookie])){
		        exit('return_3');
		}
		setcookie($cookie, 'have', time()+30, IN_PATH);
		$setarr = array(
			'in_table' => 'blog',
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
	$tid = $db->getone("select in_tid from ".tname('comment')." where in_table='blog' and in_id=".$id);
	$uid = $db->getone("select in_uid from ".tname('blog')." where in_id=".$tid);
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
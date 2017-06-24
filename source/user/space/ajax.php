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
	$row = $db->getrow("select in_userid,in_introduce from ".tname('user')." where in_islock=0 and in_userid=".$id);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$row){
		echo 'return_2';
	}else{
		if($fid = $db->getone("select in_id from ".tname('feed')." where in_icon='space' and in_uid=".$missra_in_userid." and in_tid=".$id)){
		        updatetable('feed', array('in_addtime' => date('Y-m-d H:i:s'),'in_content' => $row['in_introduce']), array('in_id' => $fid));
		        exit('return_3');
		}
		$setarr = array(
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_type' => 1,
			'in_tid' => $row['in_userid'],
			'in_icon' => 'space',
			'in_title' => '推荐了一位用户',
			'in_content' => $row['in_introduce'],
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('feed', $setarr, 1);
		echo 'return_3';
	}
}elseif($ac == 'wall'){
	$id = intval(SafeRequest("id","get"));
	$wall = unescape(SafeRequest("wall","get"));
	global $missra_in_userid,$missra_in_username;
	$row = $db->getrow("select in_userid,in_username from ".tname('user')." where in_islock=0 and in_userid=".$id);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$row){
		echo 'return_2';
	}else{
		$cookie = 'in_space_wall_'.$id;
		if(!empty($_COOKIE[$cookie])){
		        exit('return_3');
		}
		setcookie($cookie, 'have', time()+45, IN_PATH);
	        if($row['in_userid'] !== $missra_in_userid){
		        $setarr = array(
			        'in_uid' => $missra_in_userid,
			        'in_uname' => $missra_in_username,
			        'in_uids' => $row['in_userid'],
			        'in_unames' => $row['in_username'],
			        'in_content' => '你好，'.$row['in_username'].'！我在你的主页留言板留了个言，快去看看吧。',
			        'in_isread' => 0,
			        'in_addtime' => date('Y-m-d H:i:s')
		        );
		        inserttable('message', $setarr, 1);
	        }
		$setarr = array(
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_uids' => $row['in_userid'],
			'in_unames' => $row['in_username'],
			'in_content' => $wall,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('wall', $setarr, 1);
		echo 'return_4';
	}
}elseif($ac == 'w_del'){
	$id = intval(SafeRequest("id","get"));
	global $missra_in_userid;
	$userid = $db->getone("select in_uids from ".tname('wall')." where in_id=".$id);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$userid){
		echo 'return_2';
	}elseif($userid !== $missra_in_userid){
		echo 'return_3';
	}else{
		$db->query("delete from ".tname('wall')." where in_id=".$id);
		echo 'return_4';
	}
}
?>
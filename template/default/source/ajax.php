<?php
include '../../../source/system/db.class.php';
include '../../../source/system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db,$userlogined;
$ac=SafeRequest("ac","get");
if($ac == 'fav'){
	$id = intval(SafeRequest("id","get"));
	global $missra_in_userid,$missra_in_username;
	if(!$userlogined){
		echo 'return_0';
	}elseif(!$db->getone("select in_id from ".tname('music')." where in_id=".$id)){
		echo 'return_1';
	}else{
		if($fid = $db->getone("select in_id from ".tname('favorites')." where in_uid=".$missra_in_userid." and in_mid=".$id)){
			updatetable('favorites', array('in_addtime' => date('Y-m-d H:i:s')), array('in_id' => $fid));
		}else{
			$setarr = array(
			        'in_uid' => $missra_in_userid,
			        'in_uname' => $missra_in_username,
			        'in_mid' => $id,
			        'in_addtime' => date('Y-m-d H:i:s')
			);
			inserttable('favorites', $setarr, 1);
			$db->query("update ".tname('music')." set in_favhits=in_favhits+1 where in_id=".$id);
		}
		echo 'return_2';
	}
}elseif($ac == 'down'){
	$id = intval(SafeRequest("id","get"));
	global $missra_in_points,$missra_in_grade;
	if($row = $db->getrow("select * from ".tname('music')." where in_id=".$id)){
                if($row['in_grade'] == 1){
                        $userlogined or exit('return_0');
                        if($missra_in_grade < $row['in_grade']){
                                exit('return_1');
                        }
                }elseif($row['in_grade'] == 2){
                        $userlogined or exit('return_0');
                        if($missra_in_points < $row['in_points']){
                                exit('return_2');
                        }
                }
		echo 'return_4';
        }else{
		echo 'return_3';
        }
}elseif($ac == 'comment'){
	$id = intval(SafeRequest("id","get"));
	$content = unescape(SafeRequest("content","get"));
	global $missra_in_userid,$missra_in_username;
	if(!$userlogined){
		echo 'return_0';
	}elseif(!$db->getone("select in_id from ".tname('music')." where in_id=".$id)){
		echo 'return_1';
	}else{
		$cookie = 'in_comment_music_'.$id;
		if(!empty($_COOKIE[$cookie])){
		        exit('return_2');
		}
		setcookie($cookie, 'have', time()+30, IN_PATH);
		$setarr = array(
			'in_table' => 'music',
			'in_tid' => $id,
			'in_content' => $content,
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('comment', $setarr, 1);
		echo 'return_3';
	}
}elseif($ac == 'logout'){
        global $missra_in_userid;
        if($userlogined){
		if($db->getone("select in_id from ".tname('session')." where in_uid=".$missra_in_userid)){
		        $db->query("delete from ".tname('session')." where in_uid=".$missra_in_userid);
		}
        }
        setcookie('in_userid', '', time()-1, IN_PATH);
        setcookie('in_username', '', time()-1, IN_PATH);
        setcookie('in_userpassword', '', time()-1, IN_PATH);
        echo 'logout';
}
?>
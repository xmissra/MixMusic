<?php
if(!defined('IN_ROOT')){exit('Access denied');}
global $db,$userlogined,$missra_in_userid,$missra_in_username;
$space = explode('/', $_SERVER['PATH_INFO']);
$uid = isset($space[4]) ? $space[3] : $space[1];
if(is_numeric($uid)){
	$result = $db->query("select * from ".tname('user')." where in_islock=0 and in_userid=".$uid);
	if($row = $db->fetch_array($result)){
		$ear = array(
			'in_userid' => $row['in_userid'],
			'in_username' => $row['in_username'],
			'in_userpassword' => $row['in_userpassword'],
			'in_mail' => $row['in_mail'],
			'in_ismail' => $row['in_ismail'],
			'in_sex' => $row['in_sex'],
			'in_birthday' => $row['in_birthday'],
			'in_address' => $row['in_address'],
			'in_introduce' => $row['in_introduce'],
			'in_regdate' => $row['in_regdate'],
			'in_loginip' => $row['in_loginip'],
			'in_logintime' => $row['in_logintime'],
			'in_islock' => $row['in_islock'],
			'in_isstar' => $row['in_isstar'],
			'in_hits' => $row['in_hits'],
			'in_points' => $row['in_points'],
			'in_rank' => $row['in_rank'],
			'in_grade' => $row['in_grade'],
			'in_vipgrade' => $row['in_vipgrade'],
			'in_vipindate' => $row['in_vipindate'],
			'in_vipenddate' => $row['in_vipenddate'],
			'in_ucid' => $row['in_ucid'],
			'in_qqopen' => $row['in_qqopen'],
			'in_qqimg' => $row['in_qqimg'],
			'in_avatar' => $row['in_avatar']
		);
		if($userlogined && $ear['in_userid'] !== $missra_in_userid){
		        if($fid = $db->getone("select in_id from ".tname('footprint')." where in_uid=".$missra_in_userid." and in_uids=".$ear['in_userid'])){
		                updatetable('footprint', array('in_addtime' => date('Y-m-d H:i:s')), array('in_id' => $fid));
		        }else{
		                $setarr = array(
			                'in_uid' => $missra_in_userid,
			                'in_uname' => $missra_in_username,
			                'in_uids' => $ear['in_userid'],
			                'in_unames' => $ear['in_username'],
			                'in_addtime' => date('Y-m-d H:i:s')
		                );
		                inserttable('footprint', $setarr, 1);
		        }
		}
		$cookie = md5('in_space_'.getonlineip().'_'.$ear['in_userid']);
		if(empty($_COOKIE[$cookie])){
		        setcookie($cookie, 'have', time()+86400, IN_PATH);
		        $db->query("update ".tname('user')." set in_hits=in_hits+1 where in_userid=".$ear['in_userid']);
		}
	}else{
		exit(header("location:".rewrite_mode('user.php/space/wrong/')));
	}
}else{
	exit(header("location:".rewrite_mode('user.php/space/wrong/')));
}
?>
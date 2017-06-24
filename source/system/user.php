<?php
if(!defined('IN_ROOT')){exit('Access denied');}
if(IN_OPEN==0){exit(html_message("维护通知",IN_OPENS));}
global $db;
$userid = isset($_COOKIE['in_userid']) ? intval($_COOKIE['in_userid']) : 0;
$username = isset($_COOKIE['in_username']) ? SafeSql($_COOKIE['in_username']) : NULL;
$userpassword = isset($_COOKIE['in_userpassword']) ? SafeSql($_COOKIE['in_userpassword']) : NULL;
$session = $db->getone("select in_id from ".tname('session')." where in_uid=".$userid." and in_uname='".$username."'");
if($session){
	$db->query("update ".tname('session')." set in_addtime=".time()." where in_uid=".$userid);
	$sql = "select * from ".tname('user')." where in_islock=0 and in_userid=".$userid." and in_username='".$username."' and in_userpassword='".$userpassword."'";
	$result = $db->query($sql);
	if($row = $db->fetch_array($result)){
		$userlogined = true;
		$Field = $db->query("SHOW FULL COLUMNS FROM ".IN_DBTABLE."user");
		while($rows = $db->fetch_array($Field)){
		        $Variable = 'missra_'.$rows['Field'];
		        $$Variable = $row[$rows['Field']];
		}
	}else{
		$userlogined = false;
	}
}else{
	$userlogined = false;
}
$db->query("delete from ".tname('session')." where in_addtime<=".strtotime('-'.IN_ONLINEHOLD.' seconds'));
if($userlogined){
        if(!$db->getone("select in_userid from ".tname('user')." where in_userid=".$missra_in_userid." and DATEDIFF(DATE(in_logintime),'".date('Y-m-d')."')=0")){
	        $db->query("update ".tname('user')." set in_points=in_points+".IN_LOGINDAYPOINTS.",in_rank=in_rank+".IN_LOGINDAYRANK.",in_logintime='".date('Y-m-d H:i:s')."' where in_userid=".$missra_in_userid);
	        $setarr = array(
		        'in_uid' => 0,
		        'in_uname' => '系统用户',
		        'in_uids' => $missra_in_userid,
		        'in_unames' => $missra_in_username,
		        'in_content' => '每日首次登录：[金币+'.IN_LOGINDAYPOINTS.'][经验+'.IN_LOGINDAYRANK.']',
		        'in_isread' => 0,
		        'in_addtime' => date('Y-m-d H:i:s')
	        );
	        inserttable('message', $setarr, 1);
        }
        if($missra_in_grade == 1){
	        $vipenddate = strtotime($missra_in_vipenddate)-time();
	        if($vipenddate <= 0){
		        $db->query("update ".tname('user')." set in_grade=0,in_vipgrade=0,in_vipindate='0000-00-00 00:00:00',in_vipenddate='0000-00-00 00:00:00' where in_userid=".$missra_in_userid);
		        $setarrs = array(
			        'in_uid' => 0,
			        'in_uname' => '系统用户',
			        'in_uids' => $missra_in_userid,
			        'in_unames' => $missra_in_username,
			        'in_content' => '尊敬的用户'.$missra_in_username.'，您的绿钻会员已到期，请重新开通！',
			        'in_isread' => 0,
			        'in_addtime' => date('Y-m-d H:i:s')
		        );
		        inserttable('message', $setarrs, 1);
	        }
        }
}
?>
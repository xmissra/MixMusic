<?php
include '../../../system/db.class.php';
include '../../../system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db,$userlogined,$missra_in_userid;
$ac = SafeRequest("ac","get");
if($ac == 'lock'){
        if(empty($_COOKIE['in_adminid']) || empty($_COOKIE['in_adminname']) || empty($_COOKIE['in_adminpassword']) || empty($_COOKIE['in_permission']) || empty($_COOKIE['in_adminexpire']) || !getfield('admin', 'in_adminid', 'in_adminid', intval($_COOKIE['in_adminid'])) || md5(getfield('admin', 'in_adminpassword', 'in_adminid', intval($_COOKIE['in_adminid'])))!==$_COOKIE['in_adminpassword']){exit('return_1');}
        $userlogined or exit('return_2');
        $uid = intval(SafeRequest("uid","get"));
        if(!$db->getone("select in_userid from ".tname('user')." where in_islock=0 and in_userid=".$uid)){
                echo 'return_3';
        }elseif($uid == $missra_in_userid){
                echo 'return_4';
        }else{
                $db->query("update ".tname('user')." set in_islock=1 where in_userid=".$uid);
	        echo 'return_5';
        }
}elseif($ac == 'group'){
        $userlogined or exit('<select id="groupid"><option value="0">选择分组</option></select>');
        $str = '<select id="groupid"><option value="0">选择分组</option>';
        $query = $db->query("select * from ".tname('friend_group')." where in_uid=".$missra_in_userid." order by in_id asc");
        while($row = $db->fetch_array($query)){
                $str .= '<option value="'.$row['in_id'].'">'.$row['in_title'].'</option>';
        }
        echo $str.'</select>';
}
?>
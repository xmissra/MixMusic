<?php
include '../../../system/db.class.php';
include '../../../system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db,$userlogined,$missra_in_userid;
$ac = SafeRequest("ac","get");
if($ac == 'list'){
        $userlogined or exit("{list:-1}");
        $str = '';
        $query = $db->query("select * from ".tname('friend_group')." where in_uid=".$missra_in_userid." order by in_id asc");
        while($row = $db->fetch_array($query)){
                $str .= '<script type="text/javascript">listenMsg.count('.$row['in_id'].');</script><p id="group" lang="'.$row['in_id'].'"><span class="friend_menu_add" id="gid_'.$row['in_id'].'" title="'.$row['in_title'].'">'.$row['in_title'].'</span></p><ul id="girl" style="padding-top:5px;padding-bottom:6px;display:none">';
                $result = $db->query("select * from ".tname('friend')." where in_gid=".$row['in_id']." order by in_addtime asc");
                while($rows = $db->fetch_array($result)){
                        $class = getfield('session', 'in_id', 'in_uid', $rows['in_uids']) ? 'online' : 'offline';
		        $str .= '<li style="cursor:pointer" id="uid_'.$rows['in_uids'].'" title="'.$rows['in_unames'].'" lang="'.$rows['in_id'].'"><b></b><label class="'.$class.'"></label><img src="'.getavatar($rows['in_uids']).'" style="border-radius:85px"><span class="chat03_name" uid="'.$rows['in_uids'].'">'.$rows['in_unames'].'</span></li><script type="text/javascript">listenMsg.start('.$rows['in_uids'].', "num", 0);</script>';
                }
                $str .= '</ul>';
        }
	$s = '';
	$res = $db->query("select * from ".tname('user')." where in_islock=0 order by in_logintime desc");
	while($r = $db->fetch_array($res)){
		if(!$db->getone("select in_id from ".tname('friend')." where in_uid=".$missra_in_userid." and in_uids=".$r['in_userid'])){
			$class = getfield('session', 'in_id', 'in_uid', $r['in_userid']) ? 'online' : 'offline';
			$style = $missra_in_userid == $r['in_userid'] ? 'font-weight:bold;color:#337FD1' : 'font-weight:normal';
			$s .= '<li style="cursor:pointer" id="uid_'.$r['in_userid'].'" title="'.$r['in_username'].'"><b></b><label class="'.$class.'"></label><img src="'.getavatar($r['in_userid']).'" style="border-radius:85px"><span class="chat03_name" style="'.$style.'" uid="'.$r['in_userid'].'">'.$r['in_username'].'</span></li><script type="text/javascript">listenMsg.start('.$r['in_userid'].', "num", 0);</script>';
		}
	}
	$s .= '</ul>';
	$str .= '<script type="text/javascript">listenMsg.count(0);</script><p id="preset"><span class="friend_menu_desc" id="gid_0" title="未分组">未分组</span></p><ul id="boy" style="padding-top:5px;padding-bottom:6px">'.$s;
	echo "{list:'".$str."'}";
}
?>
<?php
include '../../system/db.class.php';
include '../../system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db,$userlogined;
$ac=SafeRequest("ac","get");
if($ac == 'sign'){
	global $missra_in_userid,$missra_in_username,$missra_in_grade,$missra_in_vipenddate,$missra_in_sign,$missra_in_signtime;
	if(!$userlogined){
		echo 'return_1';
	}elseif(DateDiff(date('Y-m-d', strtotime($missra_in_signtime)), date('Y-m-d')) == 0){
		echo 'return_2';
	}else{
		$sign = DateDiff(date('Y-m-d', strtotime($missra_in_signtime)), date('Y-m-d', strtotime('-1 days'))) == 0 ? intval(date('d')) == 1 ? 1 : ($missra_in_sign + 1) : 1;
		$points = $sign * IN_SIGNDAYPOINTS;
		$rank = $sign * IN_SIGNDAYRANK;
		$db->query("update ".tname('user')." set in_points=in_points+".$points.",in_rank=in_rank+".$rank.",in_sign=".$sign.",in_signtime='".date('Y-m-d H:i:s')."' where in_userid=".$missra_in_userid);
		$setarr = array(
			'in_uid' => 0,
			'in_uname' => '系统用户',
			'in_uids' => $missra_in_userid,
			'in_unames' => $missra_in_username,
			'in_content' => '每日打卡签到：[金币+'.$points.'][经验+'.$rank.']',
			'in_isread' => 0,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('message', $setarr, 1);
		if(IN_SIGNVIPOPEN == 1 && $sign == date('t')){
			$fixedtime = date('Y-m-d H:i:s');
			$vipday = $missra_in_grade == 0 ? 30 : (floor(DateDiff($fixedtime, $missra_in_vipenddate) / 3600 / 24) + 31);
			$vipgrade = $vipday < 360 ? 1 : 2;
			$vipenddate = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d') + $vipday, date('Y')));
			updatetable('user', array('in_grade' => 1,'in_vipgrade' => $vipgrade,'in_vipindate' => $fixedtime,'in_vipenddate' => $vipenddate), array('in_userid' => $missra_in_userid));
		        $setarrs = array(
			        'in_uid' => 0,
			        'in_uname' => '系统用户',
			        'in_uids' => $missra_in_userid,
			        'in_unames' => $missra_in_username,
			        'in_content' => '恭喜，您本月的打卡出勤率为100%！系统赠送了一个月绿钻给你，请注意查看。',
			        'in_isread' => 0,
			        'in_addtime' => $fixedtime
		        );
		        inserttable('message', $setarrs, 1);
		}
		echo 'return_3';
	}
}elseif($ac == 'share'){
	$play = unescape(SafeRequest("p","get"));
	$intro = unescape(SafeRequest("i","get"));
	$swf = str_replace(array('[flash]', '[/flash]'), array('', ''), $play);
	$content = str_replace(array('[flash]', '[/flash]'), array('', ''), $intro);
	global $missra_in_userid,$missra_in_username;
	if(!$userlogined){
		echo 'return_1';
	}else{
		$setarr = array(
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_type' => 1,
			'in_tid' => 0,
			'in_icon' => 'share',
			'in_title' => '分享了一个Flash',
			'in_content' => '[flash]'.preg_replace('/.php\?/i', '', $swf).'[/flash]'.$content,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('feed', $setarr, 1);
		echo 'return_2';
	}
}elseif($ac == 'invisible'){
	$id = SafeRequest("id","get");
	global $missra_in_userid;
	if(!$userlogined){
		echo 'return_1';
	}else{
		updatetable('session', array('in_invisible' => $id), array('in_uid' => $missra_in_userid));
		echo 'return_2';
	}
}elseif($ac == 'do'){
	$content = unescape(SafeRequest("c","get"));
	global $missra_in_userid,$missra_in_username;
	if(!$userlogined){
		echo 'return_1';
	}else{
		$setarr = array(
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_type' => 0,
			'in_tid' => 0,
			'in_icon' => 'feed',
			'in_title' => '发表了说说',
			'in_content' => $content,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('feed', $setarr, 1);
		echo 'return_2';
	}
}elseif($ac == 'f_del'){
	$id = intval(SafeRequest("id","get"));
	global $missra_in_userid;
	$uid = $db->getone("select in_uid from ".tname('feed')." where in_id=".$id);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$uid){
		echo 'return_2';
	}elseif($uid !== $missra_in_userid){
		echo 'return_3';
	}else{
		$db->query("delete from ".tname('reply')." where in_fid=".$id);
		$db->query("delete from ".tname('feed')." where in_id=".$id);
		echo 'return_4';
	}
}elseif($ac == 're'){
	$id = intval(SafeRequest("id","get"));
	$content = unescape(SafeRequest("c","get"));
	global $missra_in_userid,$missra_in_username;
	$uid = $db->getone("select in_uid from ".tname('feed')." where in_id=".$id);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$uid){
		echo 'return_2';
	}else{
		$setarr = array(
			'in_fuid' => $uid,
			'in_fid' => $id,
			'in_content' => $content,
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('reply', $setarr, 1);
		echo 'return_3';
	}
}elseif($ac == 'r_del'){
	$id = intval(SafeRequest("id","get"));
	global $missra_in_userid;
	$fuid = $db->getone("select in_fuid from ".tname('reply')." where in_id=".$id);
	if(!$userlogined){
		echo 'return_1';
	}elseif(!$fuid){
		echo 'return_2';
	}elseif($fuid !== $missra_in_userid){
		echo 'return_3';
	}else{
		$db->query("delete from ".tname('reply')." where in_id=".$id);
		echo 'return_4';
	}
}elseif($ac == 'get'){
	$id = intval(SafeRequest("id","get"));
	global $missra_in_userid;
	$sql = "select * from ".tname('reply')." where in_fid=".$id." order by in_addtime desc";
	$result = $db->query($sql);
	$count = $db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
	if($count == 0){
   	        $show = '<div class="sub_doing" id="docomment_'.$id.'" style="display:none;">';
	}else{
   	        $show = '<div class="sub_doing" id="docomment_'.$id.'">';
	}
   	$show = $show.'<span id="docomment_form_'.$id.'"></span><ol>';
	while ($row = $db->fetch_array($result)){
		$content = preg_replace('/\[em:(\d+)]/is', '<img src="'.IN_PATH.'static/user/images/face/\1.gif" class="face">', $row['in_content']);
		$show .= '<li style="padding-left:0em;">';
		$show .= '<a href="'.getlink($row['in_uid']).'">'.$row['in_uname'].'</a>: '.$content.' <span class="doingtime">('.datetime($row['in_addtime']).')</span>';
		$show .= $userlogined && $row['in_fuid'] == $missra_in_userid ? '&nbsp;<a href="javascript:void(0)" onclick="delreply('.$row['in_id'].', '.$id.');" class="gray">删除</a>' : '';
		$show .= '</li>';
	}
   	$show = $show.'</ol></div>';
   	echo $show;
}
?>
<?php
include '../../../source/system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db;
$ac = SafeRequest("ac","get");
if($ac == 'good'){
	$id = intval(SafeRequest("id","get"));
	$row = $db->getrow("select * from ".tname('music')." where in_id=".$id);
	$good = $row['in_goodhits'];
	$bad = $row['in_badhits'];
	$count = $good + $bad;
	if($good == $bad){
		$good_width = 50;
		$bad_width = 50;
	}else{
		$good_width = $good / $count * 100;
		$bad_width = $bad / $count * 100;
	}
	$showstr = "<div class=\"heart\"><a style=\"cursor:pointer;\" onclick=\"up_love($id, 'good');\"></a></div>";
	$showstr = $showstr."<div class=\"txt_per ffhei\">";
	$showstr = $showstr."<div class=\"txt_info\">喜欢的人数：<span class=\"fc_cd007e\">$good</span></div>";
	$showstr = $showstr."<div class=\"per_info\"><img src=\"".get_template(1)."css/per_act.jpg\" width=\"$good_width%\" height=\"10\" /></div>";
	$showstr = $showstr."<div class=\"per_info\"><img src=\"".get_template(1)."css/per_nol.jpg\" width=\"$bad_width%\" height=\"10\" /></div>";
	$showstr = $showstr."<div class=\"txt_info\">扔鸡蛋：{$bad}&nbsp;<span class=\"hits\">&nbsp;</span></div>";
	$showstr = $showstr."</div>";
	echo $showstr;
}elseif($ac == 'bad'){
	$id = SafeRequest("id","get");
	$showstr = "<a style=\"cursor:pointer;\" onclick=\"up_love($id, 'bad');\"><img src=\"".get_template(1)."css/egg.gif\" /></a>";
	if(empty($_COOKIE['in_like_music_'.$id])){
	        $showstr = $showstr."&nbsp;<span class=\"msg\" style=\"color:#ff5500\">+1</span>";
	}
	echo $showstr;
}elseif($ac == 'love'){
	$do = SafeRequest("do","get");
	$id = intval(SafeRequest("id","get"));
	$field = $do == 'good' ? 'goodhits' : 'badhits';
	if($db->getone("select in_id from ".tname('music')." where in_id=".$id)){
		$cookie = 'in_like_music_'.$id;
		if(!empty($_COOKIE[$cookie])){
		        exit('return_2');
		}
		setcookie($cookie, 'have', time()+1800, IN_PATH);
		$db->query("update ".tname('music')." set in_".$field."=in_".$field."+1 where in_id=".$id);
		echo $do == 'good' ? 'return_3' : 'return_4';
	}else{
                echo 'return_1';
	}
}
?>
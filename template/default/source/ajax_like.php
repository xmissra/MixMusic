<?php
include '../../../source/system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db;
$ac = SafeRequest("ac","get");
if($ac == 'get'){
	$id = intval(SafeRequest("id","get"));
	$row = $db->getrow("select * from ".tname('music')." where in_id=".$id);
	$num = $row['in_goodhits'] + $row['in_badhits'];
	$good = $num > 0 ? $row['in_goodhits'] > 0 ? ($row['in_goodhits'] * 100 / $num) : 0 : 0;
	$bad = $num > 0 ? $row['in_badhits'] > 0 ? ($row['in_badhits'] * 100 / $num) : 0 : 0;
	$score = $good > 0 ? ($good / 10) < 0.1 ? '0.0' : round(($good / 10), 1) : '0.0';
	echo '<strong class="score">'.($score > 0 ? ceil($score) == $score ? $score.'.0' : $score : '0.0').'</strong><p>'.$num.'评价</p><div class="rate"><p><i class="icon_good"></i><span class="bar"><span style="width:'.$good.'%;"></span></span><span class="rate_count">'.round($good, 0).'%</span></p><p><i class="icon_bad"></i><span class="bar"><span style="width:'.$bad.'%;"></span></span><span class="rate_count">'.round($bad, 0).'%</span></p></div>';
}elseif($ac == 'create'){
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
		echo 'return_3';
	}else{
                echo 'return_1';
	}
}
?>
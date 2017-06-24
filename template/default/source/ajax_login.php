<?php
include '../../../source/system/db.class.php';
include '../../../source/system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $userlogined,$missra_in_userid,$missra_in_username,$missra_in_grade,$missra_in_vipgrade;
if($userlogined){
	if($missra_in_grade == 1){
		$showstr = '<li class="nav_musicvip"><span class="musicvip_text"><img src="'.get_template(1).'css/svipe.png"><a href="'.rewrite_mode('user.php/profile/credit/').'" target="_blank"><span>'.($missra_in_vipgrade == 1 ? '月付绿钻' : '年付绿钻').'</span></a></span></li>';
		$showstr = $showstr.'<li class="nav_musicbag"><span class="line">&nbsp;</span><span class="musicbag_text"><a><img src="'.get_template(1).'css/sui.png"><span>充值金币</span></a></span><a href="'.rewrite_mode('user.php/profile/pay/').'" target="_blank" class="btn_open_musicbag">充值</a></li>';
		$showstr = $showstr.'<li class="nav_software"><span class="line">&nbsp;</span><a href="'.rewrite_mode('user.php/profile/index/').'" target="_blank"><span>个人设置</span></a></li>';
		$showstr = $showstr.'<li class="mod_user"><p class="top_info logined"><span onclick="window.open(\''.getlink($missra_in_userid).'\');">'.$missra_in_username.'</span><a class="exit" href="javascript:void(0)" onclick="logout();">退出</a></p></li>';
	}else{
		$showstr = '<li class="nav_musicvip"><span class="musicvip_text"><img src="'.get_template(1).'css/svip.png"><a><span>开通绿钻</span></a></span><a href="'.rewrite_mode('user.php/profile/vip/').'" target="_blank" class="btn_open_vip">开通</a></li>';
		$showstr = $showstr.'<li class="nav_musicbag"><span class="line">&nbsp;</span><span class="musicbag_text"><a><img src="'.get_template(1).'css/sui.png"><span>充值金币</span></a></span><a href="'.rewrite_mode('user.php/profile/pay/').'" target="_blank" class="btn_open_musicbag">充值</a></li>';
		$showstr = $showstr.'<li class="nav_software"><span class="line">&nbsp;</span><a href="'.rewrite_mode('user.php/profile/index/').'" target="_blank"><span>个人设置</span></a></li>';
		$showstr = $showstr.'<li class="mod_user"><p class="top_info logined"><span onclick="window.open(\''.getlink($missra_in_userid).'\');">'.$missra_in_username.'</span><a class="exit" href="javascript:void(0)" onclick="logout();">退出</a></p></li>';
	}
}else{
	$showstr = '<li class="mod_user"><p class="top_info unlogined">您还未登录，<a href="'.rewrite_mode('index.php/page/login/').'">马上登录</a></p></li>';
	$showstr = $showstr.'<li class="nav_musicbag"><span class="line">&nbsp;</span><span class="musicbag_text"><a href="'.rewrite_mode('index.php/page/register/').'"><span>注册帐号</span></a></span></li>';
}
	echo $showstr;
?>
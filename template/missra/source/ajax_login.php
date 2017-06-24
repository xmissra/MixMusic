<?php
include '../../../source/system/db.class.php';
include '../../../source/system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $userlogined,$missra_in_userid,$missra_in_username;
if($userlogined){
	$showstr = "<ul class=\"top-user\">";
   	$showstr = $showstr."<li><a href=\"".getlink($missra_in_userid)."\" target=\"_blank\">".$missra_in_username."</a></li><li class=\"pie\">|</li>";
   	$showstr = $showstr."<li><a href=\"".rewrite_mode('user.php/profile/credit/')."\" target=\"_blank\">个人账户</a></li><li class=\"pie\">|</li>";
   	$showstr = $showstr."<li><a href=\"".rewrite_mode('user.php/music/add/')."\" target=\"_blank\">分享音乐</a></li><li class=\"pie\">|</li>";
   	$showstr = $showstr."<li class=\"down-menu\"><span><a href=\"".rewrite_mode('user.php/profile/index/')."\" target=\"_blank\">设置</a></span></li>";
   	$showstr = $showstr."<li><a href=\"javascript:void(0)\" onclick=\"logout();\">退出</a></li>";
   	$showstr = $showstr."</ul>";
}else{
	$showstr = "<div class=\"topLogin\"><div class=\"webLogin\">[ <a href=\"".rewrite_mode('index.php/page/login/')."\" class=\"color\">立即登录</a> ]或[ <a href=\"".rewrite_mode('index.php/page/register/')."\" class=\"color\">注册</a> ]</div><div class=\"appLogin\" style=\"width:132px;\"></div><div>";
}
	echo $showstr;
?>
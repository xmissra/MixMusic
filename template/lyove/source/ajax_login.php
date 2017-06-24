<?php
include '../../../source/system/db.class.php';
include '../../../source/system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $userlogined,$missra_in_userid,$missra_in_username;
if($userlogined){
   	$showstr = '<div class="fl q_register"><span class="username"><a href="'.getlink($missra_in_userid).'" target="_blank">'.getlenth($missra_in_username, 3).'</a></span></div>';
   	$showstr = $showstr.'<div class="fl q_login"><a href="javascript:void(0)" onclick="logout();">退出</a></div>';
}else{
   	$showstr = '<div class="fl q_register"><a href="javascript:void(0)" onclick="pop_register();">免费注册</a></div>';
   	$showstr = $showstr.'<div class="fl q_login"><a href="javascript:void(0)" onclick="pop_login();">登录</a></div>';
}
	echo $showstr;
?>
<?php
include '../../../source/system/db.class.php';
include '../../../source/system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db,$userlogined,$missra_in_userid;
$star_num = $db->num_rows($db->query("select count(*) from ".tname('user')." where in_isstar=1"));
$showstr = "<div class=\"mdBox bgWrite\">";
$showstr = $showstr."<div class=\"mdBoxHd\"><a class=\"fr\" style=\"margin-top:10px\">".get_app()."</a><h2 class=\"mdBoxHdTit\"><span><strong><i><font color=\"#398DFF\">".$star_num."</font></i></strong> <small>位乐迷通过了明星认证</small></span></h2></div>";
$showstr = $showstr."<div style=\"width:100%; overflow:hidden; background:#FFF;\">";
$you_link = $userlogined ? getlink($missra_in_userid) : rewrite_mode('index.php/page/login/');
$guide_link = $userlogined ? rewrite_mode('user.php/people/home/') : rewrite_mode('index.php/page/register/');
$guide_img = $userlogined ? 'logined.png' : 'reg.png';
$showstr = $showstr."<div class=\"mdBoxBd\" style=\"float:left;\"><embed src=\"".get_template(1)."widget/avatar/avatar-wall.swf\" menu=\"false\" wmode=\"opaque\" quality=\"high\" pluginspage=\"http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave-flash\" width=\"725\" height=\"164\" flashVars=\"dataUrl=".get_template(1)."widget/avatar/avatar-wall.php&youLink=".$you_link."\"></embed></div>";
$showstr = $showstr."<div style=\"float:left; margin-top:6px; margin-left:-4px;\"><a href=\"".$guide_link."\"><img src=\"".get_template(1)."widget/avatar/".$guide_img."\" width=\"232\" height=\"152\"></a></div>";
$showstr = $showstr."</div></div>";
echo $showstr;
?>
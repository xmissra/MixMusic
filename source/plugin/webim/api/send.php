<?php
include '../../../system/db.class.php';
include '../../../system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db,$userlogined,$missra_in_userid,$missra_in_username;
$ac = SafeRequest("ac","get");
if($ac == 'send'){
        $userlogined or exit("{send:-1}");
        $text = unescape(SafeRequest("text","get"));
        $uname = unescape(SafeRequest("uname","get"));
        $uid = SafeRequest("uid","get");
	$setarr = array(
		'in_uid' => $missra_in_userid,
		'in_uname' => $missra_in_username,
		'in_uids' => $uid,
		'in_unames' => $uname,
		'in_content' => preg_replace('/.php\?/i', '', $text),
		'in_isread' => 0,
		'in_addtime' => date('Y-m-d H:i:s')
	);
	inserttable('message', $setarr, 1);
	echo "{send:1}";
}
?>
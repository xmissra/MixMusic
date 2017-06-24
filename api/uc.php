<?php
define('UC_VERSION', '1.0.0');
define('API_DELETEUSER', 1);
define('API_RENAMEUSER', 1);
define('API_UPDATEPW', 1);
define('API_GETTAG', 1);
define('API_SYNLOGIN', 1);
define('API_SYNLOGOUT', 1);
define('API_UPDATEBADWORDS', 1);
define('API_UPDATEHOSTS', 1);
define('API_UPDATEAPPS', 1);
define('API_UPDATECLIENT', 1);
define('API_UPDATECREDIT', 1);
define('API_GETCREDITSETTINGS', 1);
define('API_UPDATECREDITSETTINGS', 1);
define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '-2');

error_reporting(7);

define('UC_CLIENT_ROOT', DISCUZ_ROOT.'./client/');
chdir('../');
require_once './client/ucenter.php';

$code = $_GET['code'];
parse_str(authcode($code, 'DECODE', UC_KEY), $get);

if(MAGIC_QUOTES_GPC) {
	$get = dstripslashes($get);
}
if(time() - $get['time'] > 3600) {
	exit('Authracation has expiried');
}
if(empty($get)) {
	exit('Invalid Request');
}

$action = $get['action'];
$timestamp = time();

if($action == 'test') {
	exit(API_RETURN_SUCCEED);
} elseif($action == 'deleteuser') {
	!API_DELETEUSER && exit(API_RETURN_FORBIDDEN);
	include './include/db_mysql.class.php';
	$db = new dbstuff;
	$db->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
	unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
	$uids = $get['ids'];
	$query = $db->query("DELETE FROM {$tablepre}members WHERE uid IN ($uids)");
	exit(API_RETURN_SUCCEED);
} elseif($action == 'renameuser') {
	!API_RENAMEUSER && exit(API_RETURN_FORBIDDEN);
	$uid = $get['uid'];
	$usernamenew = $get['newusername'];
	$db->query("UPDATE {$tablepre}members SET username='$usernamenew' WHERE uid='$uid'");
	exit(API_RETURN_SUCCEED);
} elseif($action == 'updatepw') {
	!API_UPDATEPW && exit(API_RETURN_FORBIDDEN);
	exit(API_RETURN_SUCCEED);
} elseif($action == 'gettag') {
	!API_GETTAG && exit(API_RETURN_FORBIDDEN);
	$return = array($name, array());
	echo uc_serialize($return, 1);
} elseif($action == 'synlogin' && $_GET['time'] == $get['time']) {
	!API_SYNLOGIN && exit(API_RETURN_FORBIDDEN);
	include './source/system/db.class.php';
	if(IN_UCOPEN == 1) {
                global $db;
                if($row=$db->getrow("select * from ".tname('user')." where in_islock=0 and in_ucid>0 and in_ucid=".intval($get['uid']))) {
                        $session = $db->getone("select in_id from ".tname('session')." where in_uid=".$row['in_userid']);
                        if($session) {
                                updatetable('session', array('in_addtime' => time()), array('in_id' => $session));
                        } else {
                                $setarr = array(
			                'in_uid' => $row['in_userid'],
			                'in_uname' => $row['in_username'],
			                'in_invisible' => 0,
			                'in_addtime' => time()
                                );
                                inserttable('session', $setarr, 1);
                        }
                        if($db->getone("select in_userid from ".tname('user')." where in_userid=".$row['in_userid']." and DATEDIFF(DATE(in_logintime),'".date('Y-m-d')."')=0")) {
                                $db->query("update ".tname('user')." set in_loginip='".getonlineip()."',in_logintime='".date('Y-m-d H:i:s')."' where in_userid=".$row['in_userid']);
                        } else {
                                $db->query("update ".tname('user')." set in_points=in_points+".IN_LOGINDAYPOINTS.",in_rank=in_rank+".IN_LOGINDAYRANK.",in_loginip='".getonlineip()."',in_logintime='".date('Y-m-d H:i:s')."' where in_userid=".$row['in_userid']);
                                $setarrs = array(
			                'in_uid' => 0,
			                'in_uname' => '系统用户',
			                'in_uids' => $row['in_userid'],
			                'in_unames' => $row['in_username'],
			                'in_content' => '每日首次登录：[金币+'.IN_LOGINDAYPOINTS.'][经验+'.IN_LOGINDAYRANK.']',
			                'in_isread' => 0,
			                'in_addtime' => date('Y-m-d H:i:s')
                                );
                                inserttable('message', $setarrs, 1);
                        }
                        header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
                        setcookie('in_userid', $row['in_userid'], time()+86400, IN_PATH);
                        setcookie('in_username', $row['in_username'], time()+86400, IN_PATH);
                        setcookie('in_userpassword', $row['in_userpassword'], time()+86400, IN_PATH);
                }
	}
} elseif($action == 'synlogout') {
	!API_SYNLOGOUT && exit(API_RETURN_FORBIDDEN);
	include './source/system/db.class.php';
	include './source/system/user.php';
	if(IN_UCOPEN == 1) {
                global $db,$userlogined,$missra_in_userid;
                if($userlogined) {
                        if($db->getone("select in_id from ".tname('session')." where in_uid=".$missra_in_userid)) {
                                $db->query("delete from ".tname('session')." where in_uid=".$missra_in_userid);
                        }
                }
	        header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	        setcookie('in_userid', '', time()-1, IN_PATH);
	        setcookie('in_username', '', time()-1, IN_PATH);
	        setcookie('in_userpassword', '', time()-1, IN_PATH);
	}
} elseif($action == 'updatebadwords') {
	!API_UPDATEBADWORDS && exit(API_RETURN_FORBIDDEN);
	exit(API_RETURN_SUCCEED);
} elseif($action == 'updatehosts') {
	!API_UPDATEHOSTS && exit(API_RETURN_FORBIDDEN);
	exit(API_RETURN_SUCCEED);
} elseif($action == 'updateapps') {
	!API_UPDATEAPPS && exit(API_RETURN_FORBIDDEN);
	exit(API_RETURN_SUCCEED);
} elseif($action == 'updateclient') {
	!API_UPDATECLIENT && exit(API_RETURN_FORBIDDEN);
	exit(API_RETURN_SUCCEED);
} elseif($action == 'updatecredit') {
	!UPDATECREDIT && exit(API_RETURN_FORBIDDEN);
	exit(API_RETURN_SUCCEED);
} elseif($action == 'getcreditsettings') {
	!GETCREDITSETTINGS && exit(API_RETURN_FORBIDDEN);
	echo uc_serialize($credits);
} elseif($action == 'updatecreditsettings') {
	!API_UPDATECREDITSETTINGS && exit(API_RETURN_FORBIDDEN);
	exit(API_RETURN_SUCCEED);
} else {
	exit(API_RETURN_FAILED);
}

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

function dsetcookie($var, $value, $life = 0, $prefix = 1) {
	global $cookiedomain, $cookiepath, $timestamp, $_SERVER;
	setcookie($var, $value, $life ? $timestamp + $life : 0, $cookiepath, $cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}

function dstripslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = dstripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}

function uc_serialize($arr, $htmlon = 0) {
	include_once UC_CLIENT_ROOT.'./lib/xml.class.php';
	return xml_serialize($arr, $htmlon);
}

function uc_unserialize($s) {
	include_once UC_CLIENT_ROOT.'./lib/xml.class.php';
	return xml_unserialize($s);
}
?>
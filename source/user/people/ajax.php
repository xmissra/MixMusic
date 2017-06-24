<?php
include '../../system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
session_start();
global $db;
$ac=SafeRequest("ac","get");
if($ac == 'login'){
	if($_GET['qq'] == 1){
		if(empty($_COOKIE['in_qq_nick']) || empty($_COOKIE['in_qq_open']) || empty($_COOKIE['in_qq_img'])){
			exit('return_2');
		}elseif($db->getone("select in_userid from ".tname('user')." where in_qqopen='".SafeSql($_COOKIE['in_qq_open'])."'")){
			exit('return_3');
		}
	}
	$in_username = unescape(SafeRequest("name","get"));
	$in_userpassword = substr(md5(unescape(SafeRequest("pwd","get"))),8,16);
	$seccode = SafeRequest("code","get");
	$return = $db->getrow("select * from ".tname('user')." where in_username='".$in_username."' and in_userpassword='".$in_userpassword."'");
	if(!empty($seccode) && $seccode != $_SESSION['code']){
		echo 'return_1';
	}else{
		if(IN_UCOPEN == 1){
			include_once '../../../client/ucenter.php';
			include_once '../../../client/client.php';
			list($uid, $username, $userpassword, $mail) = uc_user_login(unescape($_GET['name']), unescape($_GET['pwd']));
			if($uid > 0){
		                if(!$db->getone("select in_userid from ".tname('user')." where in_username='".$username."'")){
		                        if($db->getone("select in_userid from ".tname('user')." where in_mail='".$mail."'")){
		                                $mail = NULL;
		                        }
		                        $sql="insert into `".tname('user')."` (in_username,in_userpassword,in_mail,in_ismail,in_sex,in_regdate,in_loginip,in_logintime,in_islock,in_isstar,in_hits,in_points,in_rank,in_grade,in_vipgrade,in_sign,in_ucid) values ('".$username."','".substr(md5($userpassword),8,16)."','".$mail."','0','0','".date('Y-m-d H:i:s')."','".getonlineip()."','".date('Y-m-d H:i:s')."','0','0','0','".(IN_REGPOINTS+IN_LOGINDAYPOINTS)."','".(IN_REGRANK+IN_LOGINDAYRANK)."','0','0','0','".$uid."')";
		                        if($db->query($sql)){
		                                $in_userid = $db->getone("select in_userid from ".tname('user')." where in_username='".$username."' and in_userpassword='".substr(md5($userpassword),8,16)."'");
		                                $db->query("insert into `".tname('session')."` (in_uid,in_uname,in_invisible,in_addtime) values ('".$in_userid."','".$username."','0','".time()."')");
		                                setcookie('in_userid', $in_userid, time()+86400, IN_PATH);
		                                setcookie('in_username', $username, time()+86400, IN_PATH);
		                                setcookie('in_userpassword', substr(md5($userpassword),8,16), time()+86400, IN_PATH);
		                                $setarrs = array(
			                                'in_uid' => 0,
			                                'in_uname' => '系统用户',
			                                'in_uids' => $in_userid,
			                                'in_unames' => $username,
			                                'in_content' => '激活并注册会员(含每日首次登录)：[金币+'.(IN_REGPOINTS+IN_LOGINDAYPOINTS).'][经验+'.(IN_REGRANK+IN_LOGINDAYRANK).']',
			                                'in_isread' => 0,
			                                'in_addtime' => date('Y-m-d H:i:s')
		                                );
		                                inserttable('message', $setarrs, 1);
		                                if($_GET['qq'] == 1){
			                                updatetable('user', array('in_qqopen' => SafeSql($_COOKIE['in_qq_open']),'in_qqimg' => SafeSql($_COOKIE['in_qq_img'])), array('in_userid' => $in_userid));
		                                        exit('return_4');
		                                }else{
			                                exit('return_5');
		                                }
		                        }
		                }
			}
		}
		if($return){
			if($return['in_islock'] == 1){
		                echo 'return_6';
			}else{
		                $session = $db->getone("select in_id from ".tname('session')." where in_uid=".$return['in_userid']);
		                if($session){
		                        updatetable('session', array('in_addtime' => time()), array('in_id' => $session));
		                }else{
		                        $setarr = array(
			                        'in_uid' => $return['in_userid'],
			                        'in_uname' => $return['in_username'],
			                        'in_invisible' => 0,
			                        'in_addtime' => time()
		                        );
		                        inserttable('session', $setarr, 1);
		                }
		                setcookie('in_userid', $return['in_userid'], time()+86400, IN_PATH);
		                setcookie('in_username', $return['in_username'], time()+86400, IN_PATH);
		                setcookie('in_userpassword', $return['in_userpassword'], time()+86400, IN_PATH);
		                if($db->getone("select in_userid from ".tname('user')." where in_userid=".$return['in_userid']." and DATEDIFF(DATE(in_logintime),'".date('Y-m-d')."')=0")){
		                        $db->query("update ".tname('user')." set in_loginip='".getonlineip()."',in_logintime='".date('Y-m-d H:i:s')."' where in_userid=".$return['in_userid']);
		                }else{
		                        $db->query("update ".tname('user')." set in_points=in_points+".IN_LOGINDAYPOINTS.",in_rank=in_rank+".IN_LOGINDAYRANK.",in_loginip='".getonlineip()."',in_logintime='".date('Y-m-d H:i:s')."' where in_userid=".$return['in_userid']);
		                        $setarrs = array(
			                        'in_uid' => 0,
			                        'in_uname' => '系统用户',
			                        'in_uids' => $return['in_userid'],
			                        'in_unames' => $return['in_username'],
			                        'in_content' => '每日首次登录：[金币+'.IN_LOGINDAYPOINTS.'][经验+'.IN_LOGINDAYRANK.']',
			                        'in_isread' => 0,
			                        'in_addtime' => date('Y-m-d H:i:s')
		                        );
		                        inserttable('message', $setarrs, 1);
		                }
		                if($_GET['qq'] == 1){
		                        if(!empty($return['in_qqopen'])){
		                                echo 'return_7';
		                        }else{
		                                updatetable('user', array('in_qqopen' => SafeSql($_COOKIE['in_qq_open']),'in_qqimg' => SafeSql($_COOKIE['in_qq_img'])), array('in_userid' => $return['in_userid']));
		                                echo 'return_8';
		                        }
		                }else{
		                        echo 'return_9';
		                }
			}
		}else{
			echo 'return_10';
		}
	}
}elseif($ac == 'register'){
	$in_username = unescape(SafeRequest("name","get"));
	$in_userpassword = substr(md5(unescape(SafeRequest("pwd","get"))),8,16);
	$in_mail = unescape(SafeRequest("mail","get"));
	$seccode = SafeRequest("code","get");
	$username = $db->getone("select in_userid from ".tname('user')." where in_username='".$in_username."'");
	$mail = $db->getone("select in_userid from ".tname('user')." where in_mail='".$in_mail."'");
	if(!empty($seccode) && $seccode != $_SESSION['code']){
		echo 'return_1';
	}elseif($username){
		echo 'return_11';
	}elseif($mail){
		echo 'return_12';
	}else{
		$in_ucid = 0;
		if(IN_UCOPEN == 1){
			include_once '../../../client/ucenter.php';
			include_once '../../../client/client.php';
		        $uid = uc_user_register(unescape($_GET['name']), unescape($_GET['pwd']), unescape($_GET['mail']));
		        if($uid <= 0){
			        if($uid == -1){
				        exit('return_13');
			        }elseif($uid == -2){
				        exit('return_14');
			        }elseif($uid == -3){
				        exit('return_15');
			        }elseif($uid == -4){
				        exit('return_16');
			        }elseif($uid == -5){
				        exit('return_17');
			        }elseif($uid == -6){
				        exit('return_18');
			        }else{
				        exit('return_19');
			        }
		        }
		        $ucid = uc_get_user(unescape($_GET['name']));
		        $in_ucid = $ucid[0];
		}
	        $sql="insert into `".tname('user')."` (in_username,in_userpassword,in_mail,in_ismail,in_sex,in_regdate,in_loginip,in_logintime,in_islock,in_isstar,in_hits,in_points,in_rank,in_grade,in_vipgrade,in_sign,in_ucid) values ('".$in_username."','".$in_userpassword."','".$in_mail."','0','0','".date('Y-m-d H:i:s')."','".getonlineip()."','".date('Y-m-d H:i:s')."','0','0','0','".(IN_REGPOINTS+IN_LOGINDAYPOINTS)."','".(IN_REGRANK+IN_LOGINDAYRANK)."','0','0','0','".$in_ucid."')";
	        if($db->query($sql)){
		        $in_userid = $db->getone("select in_userid from ".tname('user')." where in_username='".$in_username."' and in_userpassword='".$in_userpassword."'");
		        $db->query("insert into `".tname('session')."` (in_uid,in_uname,in_invisible,in_addtime) values ('".$in_userid."','".$in_username."','0','".time()."')");
		        setcookie('in_userid', $in_userid, time()+86400, IN_PATH);
		        setcookie('in_username', $in_username, time()+86400, IN_PATH);
		        setcookie('in_userpassword', $in_userpassword, time()+86400, IN_PATH);
		        $setarrs = array(
			        'in_uid' => 0,
			        'in_uname' => '系统用户',
			        'in_uids' => $in_userid,
			        'in_unames' => $in_username,
			        'in_content' => '注册会员初始(含每日首次登录)：[金币+'.(IN_REGPOINTS+IN_LOGINDAYPOINTS).'][经验+'.(IN_REGRANK+IN_LOGINDAYRANK).']',
			        'in_isread' => 0,
			        'in_addtime' => date('Y-m-d H:i:s')
		        );
		        inserttable('message', $setarrs, 1);
		        echo 'return_20';
	        }
	}
}elseif($ac == 'lostpasswd'){
        if($_GET['type'] == 1){
                if(IN_MAILOPEN == 0){
		        exit('return_0');
                }
	        $in_username = unescape(SafeRequest("name","get"));
	        $in_mail = unescape(SafeRequest("mail","get"));
	        $seccode = SafeRequest("code","get");
	        $in_userid = $db->getone("select in_userid from ".tname('user')." where in_username='".$in_username."' and in_mail='".$in_mail."'");
	        if(!empty($seccode) && $seccode != $_SESSION['code']){
		        echo 'return_1';
	        }elseif(!$db->getone("select in_userid from ".tname('user')." where in_username='".$in_username."'")){
		        echo 'return_21';
	        }elseif(!$in_userid){
		        echo 'return_22';
	        }else{
		        setcookie('in_send_mail_uname', $in_username, time()+60, IN_PATH);
		        setcookie('in_send_mail_email', $in_mail, time()+60, IN_PATH);
		        setcookie('in_send_mail_uid', $in_userid, time()+60, IN_PATH);
                        echo 'return_23';
	        }
        }elseif($_GET['type'] == 2){
	        $ucode = md5(time().rand(2,pow(2,24)));
		$cookie = 'in_send_mail';
		if(!empty($_COOKIE[$cookie])){
		        exit('return_26');
		}
		setcookie($cookie, 'have', time()+30, IN_PATH);
		$in_uname = SafeSql($_COOKIE['in_send_mail_uname']);
		$in_email = SafeSql($_COOKIE['in_send_mail_email']);
		$in_uid = intval($_COOKIE['in_send_mail_uid']);
		$in_uid and getfield('user', 'in_userid', 'in_username', $in_uname) == $in_uid and getfield('user', 'in_userid', 'in_mail', $in_email) == $in_uid or exit('return_27');
		include_once '../../pack/mail/mail.php';
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'utf-8';
		$mail->SMTPAuth = true;
		$mail->Host = IN_MAILSMTP;
		$mail->Username = IN_MAIL;
		$mail->Password = IN_MAILPW;
		$mail->From = IN_MAIL;
		$mail->FromName = convert_xmlcharset(IN_NAME, 2);
		$mail->Subject = convert_xmlcharset('['.$in_uname.']密码的重设地址邮件', 2);
		$mail->AddAddress($in_email, convert_xmlcharset($in_uname, 2));
		$html = 'http://'.$_SERVER['HTTP_HOST'].rewrite_mode('user.php/people/lostpasswd/'.$ucode.'/').'<br />以上地址请勿泄露给任何人。该地址有效期为'.IN_MAILDAY.'天，逾期失效！<br />如非本人操作，请勿理会！<br /><br />http://'.$_SERVER['HTTP_HOST'].IN_PATH;
		$mail->MsgHTML(convert_xmlcharset($html, 2));
		$mail->IsHTML(true);
		if(!$mail->Send()){
		        echo 'return_27';
		}else{
		        $setarr = array(
			        'in_uid' => $in_uid,
			        'in_ucode' => $ucode,
			        'in_addtime' => date('Y-m-d H:i:s')
		        );
		        inserttable('mail', $setarr, 1);
		        echo 'return_28';
		}
        }else{
	        $in_userpassword = substr(md5(unescape(SafeRequest("pwd","get"))),8,16);
	        $in_uid = intval(SafeRequest("uid","get"));
	        $in_ucode = SafeRequest("ucode","get");
	        $seccode = SafeRequest("code","get");
	        if($seccode != $_SESSION['code']){
		        echo 'return_1';
	        }elseif(!$db->getone("select in_id from ".tname('mail')." where in_uid=".$in_uid." and in_ucode='".$in_ucode."'")){
		        echo 'return_24';
	        }else{
		        $db->query("delete from ".tname('mail')." where in_uid=".$in_uid);
		        updatetable('user', array('in_userpassword' => $in_userpassword), array('in_userid' => $in_uid));
		        echo 'return_25';
	        }
        }
}
?>
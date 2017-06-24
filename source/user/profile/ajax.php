<?php
include '../../system/db.class.php';
include '../../system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db,$userlogined;
$ac=SafeRequest("ac","get");
if($ac == 'unconnect'){
	if(!$userlogined){
		echo 'return_1';
	}else{
		global $missra_in_userid;
		$db->query("update ".tname('user')." set in_qqopen='' where in_userid=".$missra_in_userid);
		echo 'return_2';
	}
}elseif($ac == 'editprofile'){
	$sex = SafeRequest("sex","get");
	$province = unescape(SafeRequest("province","get"));
	$city = unescape(SafeRequest("city","get"));
	$year = SafeRequest("year","get");
	$month = SafeRequest("month","get");
	$day = SafeRequest("day","get");
	$introduce = unescape(SafeRequest("introduce","get"));
	if(!$userlogined){
		echo 'return_1';
	}else{
		global $missra_in_userid;
		updatetable('user', array('in_sex' => $sex,'in_address' => $province.'-'.$city,'in_birthday' => $year.'-'.$month.'-'.$day,'in_introduce' => $introduce), array('in_userid' => $missra_in_userid));
		echo 'return_2';
	}
}elseif($ac == 'editpassword'){
	$old = substr(md5(unescape(SafeRequest("old","get"))),8,16);
	$new = substr(md5(unescape(SafeRequest("new","get"))),8,16);
	global $missra_in_userid,$missra_in_userpassword;
	if(!$userlogined){
		echo 'return_1';
	}elseif($old !== $missra_in_userpassword){
		echo 'return_2';
	}else{
		updatetable('user', array('in_userpassword' => $new), array('in_userid' => $missra_in_userid));
		echo 'return_3';
	}
}elseif($ac == 'editmail'){
        if($_GET['type'] == 1){
                if(IN_MAILOPEN == 0){
		        exit('return_0');
                }elseif(!$userlogined){
		        exit('return_1');
                }
	        global $missra_in_userid,$missra_in_username;
	        $in_mail = unescape(SafeRequest("mail","get"));
	        $ucode = md5(time().rand(2,pow(2,24)));
		$cookie = 'in_send_mail';
		if(!empty($_COOKIE[$cookie])){
		        exit('return_2');
		}
		setcookie($cookie, 'have', time()+30, IN_PATH);
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
		$mail->Subject = convert_xmlcharset('['.$missra_in_username.']激活邮箱的验证码邮件', 2);
		$mail->AddAddress($in_mail, convert_xmlcharset($missra_in_username, 2));
		$html = '激活邮箱的验证码为【'.$ucode.'】。该验证码有效期为'.IN_MAILDAY.'天，逾期失效！<br />如非本人操作，请忽略此邮件！<br /><br />http://'.$_SERVER['HTTP_HOST'].IN_PATH;
		$mail->MsgHTML(convert_xmlcharset($html, 2));
		$mail->IsHTML(true);
		if(!$mail->Send()){
		        echo 'return_3';
		}else{
		        $setarr = array(
			        'in_uid' => $missra_in_userid,
			        'in_ucode' => $in_mail.$ucode,
			        'in_addtime' => date('Y-m-d H:i:s')
		        );
		        inserttable('mail', $setarr, 1);
		        echo 'return_4';
		}
        }else{
	        $password = substr(md5(unescape(SafeRequest("pwd","get"))),8,16);
	        $mail = unescape(SafeRequest("mail","get"));
	        $code = SafeRequest("code","get");
	        global $missra_in_userid,$missra_in_username,$missra_in_ismail,$missra_in_userpassword;
	        if(!$userlogined){
		        echo 'return_1';
	        }elseif($password !== $missra_in_userpassword){
		        echo 'return_2';
	        }elseif($db->getone("select in_userid from ".tname('user')." where in_userid<>".$missra_in_userid." and in_mail='".$mail."'")){
		        echo 'return_3';
	        }elseif(!$db->getone("select in_id from ".tname('mail')." where in_uid=".$missra_in_userid." and in_ucode='".$mail.$code."'")){
		        echo 'return_4';
	        }else{
		        if($missra_in_ismail == 0){
			        $db->query("update ".tname('user')." set in_points=in_points+".IN_MAILPOINTS.",in_rank=in_rank+".IN_MAILRANK." where in_userid=".$missra_in_userid);
			        $setarrs = array(
			                'in_uid' => 0,
			                'in_uname' => '系统用户',
			                'in_uids' => $missra_in_userid,
			                'in_unames' => $missra_in_username,
			                'in_content' => '初次验证邮箱：[金币+'.IN_MAILPOINTS.'][经验+'.IN_MAILRANK.']',
			                'in_isread' => 0,
			                'in_addtime' => date('Y-m-d H:i:s')
			        );
			        inserttable('message', $setarrs, 1);
		        }
		        $db->query("delete from ".tname('mail')." where in_uid=".$missra_in_userid);
		        updatetable('user', array('in_mail' => $mail,'in_ismail' => 1), array('in_userid' => $missra_in_userid));
		        echo 'return_5';
	        }
        }
}elseif($ac == 'editverify'){
	$password = substr(md5(unescape(SafeRequest("pwd","get"))),8,16);
	$name = unescape(SafeRequest("name","get"));
	$cardtype = unescape(SafeRequest("type","get"));
	$cardnum = SafeRequest("num","get");
	$address = unescape(SafeRequest("address","get"));
	$mobile = SafeRequest("mobile","get");
	global $missra_in_userid,$missra_in_userpassword;
	if(!$userlogined){
		echo 'return_1';
	}elseif($password !== $missra_in_userpassword){
		echo 'return_2';
	}else{
	        if($num = $db->getone("select in_cardnum from ".tname('verify')." where in_uid=".$missra_in_userid)){
		        $cardnum = $cardnum == substr($num, 0, 6).'************' ? $num : $cardnum;
		        updatetable('verify', array('in_name' => $name,'in_cardtype' => $cardtype,'in_cardnum' => $cardnum,'in_address' => $address,'in_mobile' => $mobile), array('in_uid' => $missra_in_userid));
	        }else{
		        $setarr = array(
			        'in_uid' => $missra_in_userid,
			        'in_name' => $name,
			        'in_cardtype' => $cardtype,
			        'in_cardnum' => $cardnum,
			        'in_address' => $address,
			        'in_mobile' => $mobile,
			        'in_addtime' => date('Y-m-d H:i:s')
		        );
		        inserttable('verify', $setarr, 1);
	        }
		updatetable('user', array('in_isstar' => 2), array('in_userid' => $missra_in_userid));
		echo 'return_3';
	}
}elseif($ac == 'vip'){
	$password = substr(md5(unescape(SafeRequest("pwd","get"))),8,16);
	$uname = unescape(SafeRequest("name","get"));
	$vipnum = SafeRequest("num","get");
	global $missra_in_userid,$missra_in_username,$missra_in_userpassword,$missra_in_points;
	if(!$userlogined){
		echo 'return_1';
	}elseif($password !== $missra_in_userpassword){
		echo 'return_2';
	}elseif((IN_VIPPOINTS * $vipnum) > $missra_in_points){
		echo 'return_3';
	}elseif($row = $db->getrow("select * from ".tname('user')." where in_username='".$uname."'")){
	        $fixedtime = date('Y-m-d H:i:s');
	        $vipday = $row['in_grade'] == 0 ? ($vipnum * 30) : (floor(DateDiff($fixedtime, $row['in_vipenddate']) / 3600 / 24) + ($vipnum * 30) + 1);
	        $vipgrade = $vipday < 360 ? 1 : 2;
		$vipenddate = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d') + $vipday, date('Y')));
	        updatetable('user', array('in_grade' => 1,'in_vipgrade' => $vipgrade,'in_vipindate' => $fixedtime,'in_vipenddate' => $vipenddate), array('in_username' => $uname));
	        updatetable('user', array('in_points' => ($missra_in_points - (IN_VIPPOINTS * $vipnum))), array('in_userid' => $missra_in_userid));
	        if($uname !== $missra_in_username){
		        $setarr = array(
			        'in_uid' => $missra_in_userid,
			        'in_uname' => $missra_in_username,
			        'in_uids' => $row['in_userid'],
			        'in_unames' => $uname,
			        'in_content' => '你好，'.$uname.'！我赠送了 '.$vipnum.' 个月绿钻给你，请注意查看。',
			        'in_isread' => 0,
			        'in_addtime' => $fixedtime
		        );
		        inserttable('message', $setarr, 1);
	        }
		echo 'return_5';
	}else{
		echo 'return_4';
	}
}elseif($ac == 'pay'){
	$rmb = intval(SafeRequest("rmb","get"));
	$title = SafeRequest("title","get");
	global $missra_in_userid,$missra_in_username;
	if(!$userlogined){
		echo 'return_1';
	}else{
		$setarr = array(
		        'in_uid' => $missra_in_userid,
		        'in_uname' => $missra_in_username,
		        'in_title' => $title,
		        'in_points' => (IN_RMBPOINTS * $rmb),
		        'in_money' => $rmb,
		        'in_lock' => 1,
		        'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('paylog', $setarr, 1);
		echo 'return_2';
	}
}
?>
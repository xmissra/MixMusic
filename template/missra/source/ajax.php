<?php
include '../../../source/system/db.class.php';
include '../../../source/system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
session_start();
global $db,$userlogined;
$ac=SafeRequest("ac","get");
if($ac == 'kbps'){
	$id = SafeRequest("id","get");
	$audio = getfield('music', 'in_audio', 'in_id', $id);
	if(preg_match('/mp3$/', $audio) && is_file(IN_ROOT.$audio)){
		include_once '../../../source/pack/mp3/class.mp3.php';
		$kbps = @MP3::Bitrate(IN_ROOT.$audio);
		echo $kbps.' Kbps';
	}else{
		echo substr(strrchr($audio, '.'), 1);
	}
}elseif($ac == 'comment'){
	$id = intval(SafeRequest("id","get"));
	$content = unescape(SafeRequest("content","get"));
	global $missra_in_userid,$missra_in_username;
	if(!$userlogined){
		echo 'return_0';
	}elseif(!$db->getone("select in_id from ".tname('music')." where in_id=".$id)){
		echo 'return_1';
	}else{
		$cookie = 'in_comment_music_'.$id;
		if(!empty($_COOKIE[$cookie])){
		        exit('return_2');
		}
		setcookie($cookie, 'have', time()+30, IN_PATH);
		$setarr = array(
			'in_table' => 'music',
			'in_tid' => $id,
			'in_content' => $content,
			'in_uid' => $missra_in_userid,
			'in_uname' => $missra_in_username,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('comment', $setarr, 1);
		echo 'return_3';
	}
}elseif($ac == 'fav'){
	$id = intval(SafeRequest("id","get"));
	$seccode = SafeRequest("seccode","get");
	global $missra_in_userid,$missra_in_username;
	if(!$userlogined){
		echo 'return_0';
	}elseif($seccode != $_SESSION['code']){
		echo 'return_1';
	}elseif(!$db->getone("select in_id from ".tname('music')." where in_id=".$id)){
		echo 'return_2';
	}else{
		if($fid = $db->getone("select in_id from ".tname('favorites')." where in_uid=".$missra_in_userid." and in_mid=".$id)){
			updatetable('favorites', array('in_addtime' => date('Y-m-d H:i:s')), array('in_id' => $fid));
		}else{
			$setarr = array(
			        'in_uid' => $missra_in_userid,
			        'in_uname' => $missra_in_username,
			        'in_mid' => $id,
			        'in_addtime' => date('Y-m-d H:i:s')
			);
			inserttable('favorites', $setarr, 1);
			$db->query("update ".tname('music')." set in_favhits=in_favhits+1 where in_id=".$id);
		}
		echo 'return_3';
	}
}elseif($ac == 'wrong'){
	$id = intval(SafeRequest("id","get"));
	$seccode = SafeRequest("seccode","get");
	if($seccode != $_SESSION['code']){
		echo 'return_1';
	}elseif(!$db->getone("select in_id from ".tname('music')." where in_id=".$id)){
		echo 'return_2';
	}else{
		updatetable('music', array('in_wrong' => 1), array('in_id' => $id));
		echo 'return_3';
	}
}elseif($ac == 'diange'){
        if(IN_MAILOPEN == 0){
		exit('return_0');
        }
	$id = intval(SafeRequest("id","get"));
        if($row = $db->getrow("select * from ".tname('music')." where in_id=".$id)){
	        $name = unescape(SafeRequest("name","get"));
	        $email = unescape(SafeRequest("mail","get"));
	        $message = unescape(SafeRequest("message","get"));
	        $friend = unescape(SafeRequest("friend","get"));
		include_once '../../../source/pack/mail/mail.php';
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'utf-8';
		$mail->SMTPAuth = true;
		$mail->Host = IN_MAILSMTP;
		$mail->Username = IN_MAIL;
		$mail->Password = IN_MAILPW;
		$mail->From = IN_MAIL;
		$mail->FromName = convert_xmlcharset(IN_NAME, 2);
		$mail->Subject = convert_xmlcharset($row['in_name'].' - 点歌 - '.IN_NAME, 2);
		$mail->AddAddress($email, convert_xmlcharset($name, 2));
		$html = '<table width="100%" cellspacing="0" cellpadding="20" border="0" style="width:100%;background-color:rgb(255, 255, 255);background-position:initial initial;background-repeat:initial initial"><tbody><tr><td align="center"><table width="580" cellspacing="0" bgcolor="#f6f6f6" cellpadding="0" style="table-layout:fixed;border:1px solid #c9c9c9"><tbody><tr><td valign="top" align="left" style="font-size:14px;line-height:1.8;padding:15px 25px">嗨，<font color="#FF6969">'.$name.'</font>！你的好朋友<font color="#FF6969">'.$friend.'</font>('.getonlineip().')为您点了一首【<font color="#FF6969">'.$row['in_name'].'</font>】，赶紧打开聆听吧！http://'.$_SERVER['HTTP_HOST'].getlink($row['in_id'], 'music').'<br /><strong>TA还想对你说：</strong><font color="#009966">'.$message.'</font></td></tr></tbody></table></td></tr></tbody></table>';
		$mail->MsgHTML(convert_xmlcharset($html, 2));
		$mail->IsHTML(true);
		if(!$mail->Send()){
		        echo 'return_2';
		}else{
		        echo 'return_3';
		}
        }else{
		echo 'return_1';
        }
}elseif($ac == 'logout'){
        global $missra_in_userid;
        if($userlogined){
		if($db->getone("select in_id from ".tname('session')." where in_uid=".$missra_in_userid)){
		        $db->query("delete from ".tname('session')." where in_uid=".$missra_in_userid);
		}
        }
        setcookie('in_userid', '', time()-1, IN_PATH);
        setcookie('in_username', '', time()-1, IN_PATH);
        setcookie('in_userpassword', '', time()-1, IN_PATH);
        echo 'logout';
}
?>
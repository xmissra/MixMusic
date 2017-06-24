<?php
include 'class.ftp.php';
global $db,$userlogined,$missra_in_userid;
$userid = $userlogined ? $missra_in_userid : 0;
if($userid && isset($_GET['op']) && $_GET['op'] == 'doodle'){
	$uname = $db->getone("select in_username from ".tname('user')." where in_userid=".$userid);
	preg_match("/^new\:(.+)$/i", $_SERVER['HTTP_ALBUMID'], $matchs);
	if(!empty($matchs[1])){
		$albumname = convert_xmlcharset(trim(urldecode($matchs[1])));
		$albumname = empty($albumname) ? date('Ymd') : SafeSql($albumname);
		if(!$db->getone("select in_id from ".tname('photo_group')." where in_title='".$albumname."' and in_uid=".$userid)){
		        $setarr = array(
			        'in_pid' => 0,
			        'in_title' => $albumname,
			        'in_uid' => $userid,
			        'in_uname' => $uname
		        );
		        inserttable('photo_group', $setarr, 1);
		}
		$albumid = $db->getone("select in_id from ".tname('photo_group')." where in_title='".$albumname."' and in_uid=".$userid);
	}else{
		$albumid = intval($_SERVER['HTTP_ALBUMID']);
		if(!$db->getone("select in_id from ".tname('photo_group')." where in_uid=".$userid." and in_id=".$albumid)){
			$albumname = date('Ymd');
			if(!$db->getone("select in_id from ".tname('photo_group')." where in_title='".$albumname."' and in_uid=".$userid)){
		                $setarr = array(
			                'in_pid' => 0,
			                'in_title' => $albumname,
			                'in_uid' => $userid,
			                'in_uname' => $uname
		                );
		                inserttable('photo_group', $setarr, 1);
			}
			$albumid = $db->getone("select in_id from ".tname('photo_group')." where in_title='".$albumname."' and in_uid=".$userid);
		}
	}
        $data = empty($GLOBALS['HTTP_RAW_POST_DATA']) ? file_get_contents('php://input') : $GLOBALS['HTTP_RAW_POST_DATA'];
        if($data){
	        $ftp = new ftp(IN_REMOTEHOST, IN_REMOTEPORT, IN_REMOTEOUT, IN_REMOTEUSER, IN_REMOTEPW, IN_REMOTEPASV);
	        $src = IN_ROOT.'./data/tmp/ftp_'.date('YmdHis').rand(2,pow(2,24)).'_doodle.jpg';
	        $path = '/'.date('YmdHis').rand(2,pow(2,24)).'.jpg';
	        $dir = IN_REMOTEDIR == '.' ? NULL : IN_REMOTEDIR;
	        $file = @fopen($src, 'wb');
	        @fwrite($file, $data);
	        @fclose($file);
	        $return = $ftp->f_put($src, $dir, $path);
	        if($return){
		        @unlink($src);
		        $ftp->c_lose();
		        $setarr = array(
			        'in_gid' => $albumid,
			        'in_uid' => $userid,
			        'in_uname' => $uname,
			        'in_title' => 'doodle',
			        'in_url' => IN_REMOTEURL.$path,
			        'in_hits' => 0,
			        'in_egg' => 0,
			        'in_flower' => 0,
			        'in_scary' => 0,
			        'in_cool' => 0,
			        'in_beautiful' => 0,
			        'in_addtime' => date('Y-m-d H:i:s')
		        );
		        inserttable('photo', $setarr, 1);
		        $fileurl = $setarr['in_url'];
	        }
        }
}
@header("Expires: -1");
@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
@header("Pragma: no-cache");
@header("Content-type: application/xml;charset=".IN_CHARSET);
echo '<?xml version="1.0" encoding="utf-8" ?>';
?>
<?php if(isset($fileurl)): ?>
<uploadResponse>
	<status>success</status>
	<filepath><?php echo $fileurl; ?></filepath>
</uploadResponse>
<?php else: ?>
<parameter>
	<background>
		<bg url="<?php echo IN_PATH; ?>static/user/images/doodle/big/001.jpg" thumb="<?php echo IN_PATH; ?>static/user/images/doodle/thumb/001.jpg" />
		<bg url="<?php echo IN_PATH; ?>static/user/images/doodle/big/002.jpg" thumb="<?php echo IN_PATH; ?>static/user/images/doodle/thumb/002.jpg" />
		<bg url="<?php echo IN_PATH; ?>static/user/images/doodle/big/003.jpg" thumb="<?php echo IN_PATH; ?>static/user/images/doodle/thumb/003.jpg" />
		<bg url="<?php echo IN_PATH; ?>static/user/images/doodle/big/004.jpg" thumb="<?php echo IN_PATH; ?>static/user/images/doodle/thumb/004.jpg" />
		<bg url="<?php echo IN_PATH; ?>static/user/images/doodle/big/005.jpg" thumb="<?php echo IN_PATH; ?>static/user/images/doodle/thumb/005.jpg" />
		<bg url="<?php echo IN_PATH; ?>static/user/images/doodle/big/006.jpg" thumb="<?php echo IN_PATH; ?>static/user/images/doodle/thumb/006.jpg" />
		<bg url="<?php echo IN_PATH; ?>static/user/images/doodle/big/007.jpg" thumb="<?php echo IN_PATH; ?>static/user/images/doodle/thumb/007.jpg" />
		<bg url="<?php echo IN_PATH; ?>static/user/images/doodle/big/008.jpg" thumb="<?php echo IN_PATH; ?>static/user/images/doodle/thumb/008.jpg" />
		<bg url="<?php echo IN_PATH; ?>static/user/images/doodle/big/009.jpg" thumb="<?php echo IN_PATH; ?>static/user/images/doodle/thumb/009.jpg" />
		<bg url="<?php echo IN_PATH; ?>static/user/images/doodle/big/010.jpg" thumb="<?php echo IN_PATH; ?>static/user/images/doodle/thumb/010.jpg" />
	</background>
	<language>
		<create><?php echo convert_xmlcharset('创建', 2); ?></create>
		<notCreate><?php echo convert_xmlcharset('取消', 2); ?></notCreate>
		<albumName><?php echo convert_xmlcharset('相册名', 2); ?></albumName>
		<createTitle><?php echo convert_xmlcharset('创建新相册', 2); ?></createTitle>
		<reload><?php echo convert_xmlcharset('重画', 2); ?></reload>
		<save><?php echo convert_xmlcharset('保存', 2); ?></save>
		<notDraw><?php echo convert_xmlcharset('没有任何涂鸦动作，无法保存', 2); ?></notDraw>
	</language>
	<config>
		<maxupload>2097152</maxupload>
	</config>
	<filters>
		<filter id="0"><?php echo convert_xmlcharset('禁用', 2); ?></filter>
		<filter id="1"><?php echo convert_xmlcharset('阴影', 2); ?></filter>
		<filter id="2"><?php echo convert_xmlcharset('模糊', 2); ?></filter>
		<filter id="3"><?php echo convert_xmlcharset('发光', 2); ?></filter>
		<filter id="4"><?php echo convert_xmlcharset('水彩', 2); ?></filter>
		<filter id="5"><?php echo convert_xmlcharset('喷溅', 2); ?></filter>
		<filter id="6"><?php echo convert_xmlcharset('布纹', 2); ?></filter>
	</filters>
	<albums>
<?php
	$group = '<album id="-1">'.convert_xmlcharset('请选择相册', 2).'</album>';
	$query = $db->query("select in_id,in_title from ".tname('photo_group')." where in_uid=".$userid);
	while ($row = $db->fetch_array($query)) {
		$group .= '<album id="'.$row['in_id'].'">'.convert_xmlcharset($row['in_title'], 2).'</album>';
	}
	echo $group.'<album id="add">'.convert_xmlcharset('+新建相册', 2).'</album>';
?>
	</albums>
</parameter>
<?php endif; ?>
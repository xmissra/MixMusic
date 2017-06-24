<?php
include '../../system/db.class.php';
include 'class.ftp.php';
switch($_GET['t']){
	case 'music_audio':
		$ext = IN_UPMUSICEXT;
		break;
	case 'music_lyric':
		$ext = "*.lrc";
		break;
	case 'music_cover':
		$ext = "*.jpg;*.jpeg;*.gif;*.png";
		break;
	case 'special_cover':
		$ext = "*.jpg;*.jpeg;*.gif;*.png";
		break;
	case 'singer_cover':
		$ext = "*.jpg;*.jpeg;*.gif;*.png";
		break;
	case 'video_play':
		$ext = IN_UPVIDEOEXT;
		break;
	case 'video_cover':
		$ext = "*.jpg;*.jpeg;*.gif;*.png";
		break;
	case 'article_cover':
		$ext = "*.jpg;*.jpeg;*.gif;*.png";//新增Article模块
		break;
	case 'link_cover':
		$ext = "*.jpg;*.jpeg;*.gif;*.png";
		break;
}
$fileext = str_replace(array('*.', ';'), array('', '|'), $ext);
$filearray = preg_split('/\|/', $fileext);
$filepart = pathinfo($_FILES['Filedata']['name']);
if(!empty($_FILES) && in_array(strtolower($filepart['extension']), $filearray)){
        $ftp = new ftp(IN_REMOTEHOST, IN_REMOTEPORT, IN_REMOTEOUT, IN_REMOTEUSER, IN_REMOTEPW, IN_REMOTEPASV);
        $src = IN_ROOT.'./data/tmp/ftp_'.$_GET['uid'].'.'.date('YmdHis').rand(2,pow(2,24)).'_'.basename($_FILES['Filedata']['tmp_name']);
        $path = '/'.$_GET['uid'].'.'.date('YmdHis').rand(2,pow(2,24)).'.'.fileext($_FILES['Filedata']['name']);
        $dir = IN_REMOTEDIR == '.' ? NULL : IN_REMOTEDIR;
        move_uploaded_file($_FILES['Filedata']['tmp_name'], $src);
        $return = $ftp->f_put($src, $dir, $path);
        if($return){
                echo IN_REMOTEURL.$path;
        }else{
                echo '0';
        }
        @unlink($src);
        $ftp->c_lose();
}
?>
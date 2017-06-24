<?php
include '../../system/db.class.php';
switch($_GET['type']){
	case 'music_audio':
		$ext=IN_UPMUSICEXT;
		$text="音频文件";
		break;
	case 'music_lyric':
		$ext="*.lrc";
		$text="歌词文件";
		break;
	case 'music_cover':
		$ext="*.jpg;*.jpeg;*.gif;*.png";
		$text="音乐封面";
		break;
	case 'special_cover':
		$ext="*.jpg;*.jpeg;*.gif;*.png";
		$text="专辑封面";
		break;
	case 'singer_cover':
		$ext="*.jpg;*.jpeg;*.gif;*.png";
		$text="歌手封面";
		break;
	case 'video_play':
		$ext=IN_UPVIDEOEXT;
		$text="视频文件";
		break;
	case 'video_cover':
		$ext="*.jpg;*.jpeg;*.gif;*.png";
		$text="视频封面";
		break;
	case 'link_cover':
		$ext="*.jpg;*.jpeg;*.gif;*.png";
		$text="友链图片";
		break;

	//新增Article模块	
	case 'article_cover':
		$ext="*.jpg;*.jpeg;*.gif;*.png";
		$text="文章封面";
		break;
}
if(!empty($_FILES)){
	$dir="../../../data/tmp/";
	creatdir($dir);
	$file=$dir.date('YmdHis').rand(2,pow(2,24)).".".fileext($_FILES['Filedata']['name']);
	$fileext=str_replace(array('*.', ';'), array('', '|'), $ext);
	$filearray=preg_split('/\|/', $fileext);
	$filepart=pathinfo($_FILES['Filedata']['name']);
	if(in_array(strtolower($filepart['extension']), $filearray)){
		move_uploaded_file($_FILES['Filedata']['tmp_name'], $file);
		if(substr($file, -3) == 'mp3' && IN_UPMP3KBPS > 0){
			include_once '../mp3/class.mp3.php';
			$Kbps = @MP3::Bitrate($file);
			if($Kbps < IN_UPMP3KBPS){
				@unlink($file);
				exit('-1');
			}
		}
		$setarr = array(
			'in_uid' => SafeRequest("uid","get"),
			'in_uname' => SafeSql(base64_decode(SafeRequest("uname","get"))),
			'in_title' => str_replace($dir, '', $file),
			'in_type' => $text,
			'in_size' => $_FILES['Filedata']['size'],
			'in_url' => str_replace('../../../', '', $file),
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('uplog', $setarr, 1);
		echo str_replace('../../../', '', $file);
	}else{
	 	echo '0';
	}
}
?>
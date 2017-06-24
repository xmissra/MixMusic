<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>上传照片 - 相册 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<style type="text/css">
@import url(<?php echo IN_PATH; ?>static/user/css/style.css);
</style>
</head>
<body>
<?php include 'source/user/people/top.php'; ?>
<div id="main">
<?php include 'source/user/people/left.php'; ?>
<div id="mainarea">
<h2 class="title"><img src="<?php echo IN_PATH; ?>static/user/images/icon/photo.gif">照片</h2>
<div class="tabs_header">
<ul class="tabs">
<li><a href="<?php echo rewrite_mode('user.php/photo/index/'); ?>"><span>大家的照片</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/photo/friend/'); ?>"><span>好友的照片</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/photo/me/'); ?>"><span>我的相册</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/photo/add/'); ?>"><span>新建相册</span></a></li>
<li class="null"><a href="<?php echo rewrite_mode('user.php/photo/upload/'); ?>">上传照片</a></li>
</ul>
</div>
<div class="c_form">
<?php
if(IN_UPOPEN == 1){
        $script = 'http://'.$_SERVER['HTTP_HOST'].IN_PATH.'source/pack/upload/';
}elseif(IN_REMOTE == 1){
        $script = 'http://'.$_SERVER['HTTP_HOST'].IN_PATH.'source/plugin/'.IN_REMOTEPK.'/';
        if(!is_file(str_replace('http://'.$_SERVER['HTTP_HOST'].IN_PATH, IN_ROOT, $script.'do.php'))){
                $script = 'http://'.$_SERVER['HTTP_HOST'].IN_PATH.'source/pack/upload/';
        }
}else{
        $script = 'http://'.$_SERVER['HTTP_HOST'].IN_PATH.'source/pack/ftp/';
}
$upload = explode('/', $_SERVER['PATH_INFO']);
$gid = IsNum($upload[3]) ? $upload[3] : -1;
$row = $db->getrow("select * from ".tname('photo_group')." where in_id=".$gid);
if($gid > -1 && $row['in_uid'] !== $missra_in_userid){
?>
<div class="c_form">相册不存在或您无权上传。</div>
<?php }else{ ?>
<embed src="<?php echo IN_PATH; ?>static/pack/upload/upload.swf?site=<?php echo $script; ?>&albumid=<?php echo $gid; ?>" width="520" height="400" wmode="transparent" type="application/x-shockwave-flash"></embed>
<?php } ?>
</div>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
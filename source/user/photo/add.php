<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $userlogined; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>新建相册 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/photo.js"></script>
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
var in_path = '<?php echo IN_PATH; ?>';
</script>
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
<li class="active"><a href="<?php echo rewrite_mode('user.php/photo/add/'); ?>"><span>新建相册</span></a></li>
<li class="null"><a href="<?php echo rewrite_mode('user.php/photo/upload/'); ?>">上传照片</a></li>
</ul>
</div>
<form method="get" onsubmit="addgroup();return false;" class="c_form">
<table cellspacing="0" cellpadding="0" class="formtable">
<caption><h2>新建相册</h2></caption>
<tr><th style="width:10em;">相册名称:</th><td><input type="text" id="photo" class="t_input" /></td></tr>
<tr><th style="width:10em;"></th><td><input type="submit" value="新建相册" class="submit" /></td></tr>
</table>
</form>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
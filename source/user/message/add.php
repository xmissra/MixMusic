<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $userlogined; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>发短消息 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/message.js"></script>
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
<h2 class="title"><img src="<?php echo IN_PATH; ?>static/user/images/icon/message.gif">消息</h2>
<div class="tabs_header">
<ul class="tabs">
<li><a href="<?php echo rewrite_mode('user.php/message/index/'); ?>"><span>已读消息</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/message/read/'); ?>"><span>未读消息</span></a></li>
<li class="null"><a href="<?php echo rewrite_mode('user.php/message/add/'); ?>">发短消息</a></li>
</ul>
</div>
<div class="popupmenu_inner">
<form method="get" onsubmit="addmessage();return false;" class="ajaxshowdiv">
<table cellspacing="0" cellpadding="3">
<tr><th><label for="username">收件人：</label></th><td><input type="text" id="username" style="width: 400px;" class="t_input"  /></td></tr>
<tr><th style="vertical-align: top;"><label for="message">内容：</label></th><td><textarea id="message" cols="40" rows="4" style="width: 400px; height: 150px;"></textarea></td></tr>
<tr><th></th><td><input type="submit" value="发送" class="submit" /></td></tr>
</table>
</form>
</div>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
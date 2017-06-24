<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $userlogined,$missra_in_mail,$missra_in_ismail; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>密保邮箱 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/profile.js"></script>
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
<h2 class="title"><img src="<?php echo IN_PATH; ?>static/user/images/icon/profile.gif">个人设置</h2>
<div class="tabs_header">
<ul class="tabs">
<li class="active"><a href="<?php echo rewrite_mode('user.php/profile/index/'); ?>"><span>个人资料</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/profile/avatar/'); ?>"><span>我的头像</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/profile/credit/'); ?>"><span>积分账户</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/profile/oauth/'); ?>"><span>帐号绑定</span></a></li>
</ul>
</div>
<div class="l_status c_form">
<a href="<?php echo rewrite_mode('user.php/profile/index/'); ?>">基本资料</a><span class="pipe">|</span>
<a href="<?php echo rewrite_mode('user.php/profile/password/'); ?>">修改密码</a><span class="pipe">|</span>
<a href="<?php echo rewrite_mode('user.php/profile/mail/'); ?>" class="active">密保邮箱</a><span class="pipe">|</span>
<a href="<?php echo rewrite_mode('user.php/profile/verify/'); ?>">明星认证</a>
</div>
<form method="get" onsubmit="editmail(0);return false;" class="c_form">
<table cellspacing="0" cellpadding="0" class="formtable">
<tr><th style="width:10em;">登录密码:</th><td><input type="password" id="password" class="t_input" /><br />为了您的帐号安全，请输入登录密码。</td></tr>
<tr><th style="width:10em;">新邮箱:</th><td><input type="text" id="mail" value="<?php echo $missra_in_mail; ?>" class="t_input" /><br /><?php if($missra_in_ismail == 1){echo "[<span style=\"font-weight:bold;\">已激活</span>] 请通过接收邮件验证码来修改邮箱。";}else{echo "[<font color=\"red\">未激活</font>] 请通过接收邮件验证码来激活邮箱。";} ?></td><td><input type="button" value="发送邮件验证码" onclick="editmail(1);" class="submit" /></td></tr>
<tr><th style="width:10em;">邮件验证码:</th><td><input type="text" id="_code" class="t_input" /></td></tr>
<tr><th style="width:10em;"></th><td><input type="submit" value="提交验证" class="submit" /></td></tr>
</table>
</form>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
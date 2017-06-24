<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>用户注册 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<link href="<?php echo IN_PATH; ?>static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
var in_path = '<?php echo IN_PATH; ?>';
var guide_url = '<?php echo rewrite_mode('user.php/people/home/'); ?>';
function update_seccode(){
	$('img_seccode').src = '<?php echo rewrite_mode('user.php/people/seccode/\' + Math.random() + \'/'); ?>';
}
</script>
<style type="text/css">
@import url(<?php echo IN_PATH; ?>static/user/css/style.css);
</style>
</head>
<body>
<?php include 'source/user/people/top.php'; ?>
<?php if(IN_REGOPEN == 0){ ?>
<div class="showmessage">
<div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">
<caption>
<h2>信息提示</h2>
</caption>
<p><a href="<?php echo IN_PATH; ?>user.php">本站暂未开放注册，请稍后再试！</a><script type="text/javascript">setTimeout("location.href='<?php echo IN_PATH; ?>user.php';", 3000);</script></p>
<p class="op"><a href="<?php echo IN_PATH; ?>user.php">页面跳转中...</a></p>
</div></div></div></div>
</div>
<?php }else{ ?>
<form method="get" onsubmit="register();return false;" class="c_form">
<table cellpadding="0" cellspacing="0" class="formtable">
<caption>
<h2>用户注册</h2>
<p>请完整填写以下信息进行注册。<br />注册完成后，该帐号将作为您在本站的通行帐号，您可以享受本站提供的各种服务。</p>
</caption>
<tr><th width="100">用户名</th><td><input type="text" id="username" class="t_input" /><span id="username_tips" style="color:red"></span><br />由 3 到 15 个字符组成，不能有空格或 < > ' " / \ 等字符。</td></tr>
<tr><th width="100">注册密码</th><td><input type="password" id="password" class="t_input" /><span id="password_tips" style="color:red"></span><br />最小长度为 6 个字符。</td></tr>
<tr><th width="100">再次输入密码</th><td><input type="password" id="password1" class="t_input" /><span id="password1_tips" style="color:red"></span></td></tr>
<tr><th width="100">邮箱</th><td><input type="text" id="mail" class="t_input" /><span id="mail_tips" style="color:red"></span><br />请准确填入您的邮箱，在忘记密码时，邮件将发送到该邮箱。</td></tr>
<tr><th width="100">验证码</th><td><input type="text" id="seccode" class="t_input" style="width:45px;" maxlength="4" />&nbsp;<img id="img_seccode" src="<?php echo rewrite_mode('user.php/people/seccode/'); ?>" align="absmiddle" />&nbsp;<a href="javascript:update_seccode()">更换</a><span id="seccode_tips" style="color:red"></span></td></tr>
<tr><th width="100">&nbsp;</th><td><input type="submit" value="注册" class="submit" /></td></tr>
<tr><th>&nbsp;</th><td></td></tr>
</table>
</form>
<?php } ?>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
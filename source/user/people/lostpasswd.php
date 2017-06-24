<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>忘记密码 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<link href="<?php echo IN_PATH; ?>static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
var in_path = '<?php echo IN_PATH; ?>';
var guide_url = '<?php echo rewrite_mode('user.php/people/login/'); ?>';
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
<?php
global $db;
$lostpasswd = explode('/', $_SERVER['PATH_INFO']);
$ucode = isset($lostpasswd[3]) ? SafeSql($lostpasswd[3]) : NULL;
if(empty($ucode)){
?>
<form method="get" onsubmit="lostpasswd(1);return false;" class="c_form">
<table cellpadding="0" cellspacing="0" class="formtable">
<caption>
<h2>取回密码</h2>
<p>验证完成后，系统将会把重设地址发送至您的邮箱，请注意查收。</p>
</caption>
<tr><th width="100">用户名</th><td><input type="text" id="username" class="t_input" /><span id="username_tips" style="color:red"></span></td></tr>
<tr><th width="100">邮箱</th><td><input type="text" id="mail" class="t_input" /><span id="mail_tips" style="color:red"></span><br />请输入您注册时填写的邮箱。</td></tr>
<tr><th width="100">验证码</th><td><input type="text" id="seccode" class="t_input" style="width:45px;" maxlength="4" />&nbsp;<img id="img_seccode" src="<?php echo rewrite_mode('user.php/people/seccode/'); ?>" align="absmiddle" />&nbsp;<a href="javascript:update_seccode()">更换</a><span id="seccode_tips" style="color:red"></span></td></tr>
<tr><th width="100">&nbsp;</th><td><input type="submit" value="验证" class="submit" /></td></tr>
<tr><th>&nbsp;</th><td id="_tips"></td></tr>
</table>
</form>
<?php }elseif(!getfield('mail', 'in_id', 'in_ucode', $ucode)){ ?>
<div class="showmessage">
<div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">
<caption>
<h2>信息提示</h2>
</caption>
<p><a href="<?php echo IN_PATH; ?>user.php">重设地址不存在或已失效，请重新验证！</a><script type="text/javascript">setTimeout("location.href='<?php echo IN_PATH; ?>user.php';", 3000);</script></p>
<p class="op"><a href="<?php echo IN_PATH; ?>user.php">页面跳转中...</a></p>
</div></div></div></div>
</div>
<?php
}else{
$row = $db->getrow("select * from ".tname('mail')." where in_ucode='".$ucode."'");
?>
<form method="get" onsubmit="lostpasswd(0);return false;" class="c_form">
<table cellpadding="0" cellspacing="0" class="formtable">
<caption>
<h2>重设密码</h2>
<p>已验证完成，请尽快重设您的密码。</p>
</caption>
<tr><th width="100">用户名</th><td><input type="text" value="<?php echo getfield('user', 'in_username', 'in_userid', $row['in_uid']); ?>" readonly="readonly" class="t_input" /></td></tr>
<tr><th width="100">重设密码</th><td><input type="password" id="password" class="t_input" /><span id="password_tips" style="color:red"></span><br />最小长度为 6 个字符。</td></tr>
<tr><th width="100">确认密码</th><td><input type="password" id="password1" class="t_input" /><span id="password1_tips" style="color:red"></span></td></tr>
<tr><th width="100">验证码</th><td><input type="text" id="seccode" class="t_input" style="width:45px;" maxlength="4" />&nbsp;<img id="img_seccode" src="<?php echo rewrite_mode('user.php/people/seccode/'); ?>" align="absmiddle" />&nbsp;<a href="javascript:update_seccode()">更换</a><span id="seccode_tips" style="color:red"></span></td></tr>
<tr><th width="100">&nbsp;</th><td><input type="hidden" id="uid" value="<?php echo $row['in_uid']; ?>"><input type="hidden" id="ucode" value="<?php echo $row['in_ucode']; ?>"><input type="submit" value="立即重设" class="submit" /></td></tr>
<tr><th>&nbsp;</th><td></td></tr>
</table>
</form>
<?php } ?>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
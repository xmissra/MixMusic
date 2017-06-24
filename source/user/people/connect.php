<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>绑定QQ - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<link href="<?php echo IN_PATH; ?>static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
var in_path = '<?php echo IN_PATH; ?>';
var guide_url = '<?php echo rewrite_mode('user.php/profile/oauth/'); ?>';
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
if(empty($_COOKIE['in_qq_nick']) || empty($_COOKIE['in_qq_open']) || empty($_COOKIE['in_qq_img'])){
?>
<div class="showmessage">
<div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">
<caption>
<h2>信息提示</h2>
</caption>
<p><a href="<?php echo IN_PATH; ?>user.php">登录信息不存在或已失效，请重新获取！</a><script type="text/javascript">setTimeout("location.href='<?php echo IN_PATH; ?>user.php';", 3000);</script></p>
<p class="op"><a href="<?php echo IN_PATH; ?>user.php">页面跳转中...</a></p>
</div></div></div></div>
</div>
<?php }elseif(getfield('user', 'in_userid', 'in_qqopen', SafeSql($_COOKIE['in_qq_open']))){ ?>
<div class="showmessage">
<div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">
<caption>
<h2>信息提示</h2>
</caption>
<p><a href="<?php echo IN_PATH; ?>user.php">抱歉，该QQ号码已经被其它帐号绑定过！</a><script type="text/javascript">setTimeout("location.href='<?php echo IN_PATH; ?>user.php';", 3000);</script></p>
<p class="op"><a href="<?php echo IN_PATH; ?>user.php">页面跳转中...</a></p>
</div></div></div></div>
</div>
<?php }else{ ?>
<form method="get" onsubmit="login(1);return false;" class="c_form">
<table cellpadding="0" cellspacing="0" class="formtable">
<caption>
<h2>绑定QQ</h2>
<p>您正在绑定腾讯QQ，请使用已有的帐号进行登录，登录后即可直接绑定该QQ号码。</p>
</caption>
<tr><th width="100">&nbsp;</th><td><img src="<?php echo $_COOKIE['in_qq_img']; ?>" width="48" height="48" />&nbsp;<?php echo $_COOKIE['in_qq_nick']; ?></td></tr>
<tbody>
<tr><th width="100">用户名</th><td><input type="text" id="username" class="t_input" /><span id="username_tips" style="color:red"></span></td></tr>
<tr><th width="100">密　码</th><td><input type="password" id="password" class="t_input" /><span id="password_tips" style="color:red"></span></td></tr>
<tr><th width="100">验证码</th><td><input type="text" id="seccode" class="t_input" style="width:45px;" maxlength="4" />&nbsp;<img id="img_seccode" src="<?php echo rewrite_mode('user.php/people/seccode/'); ?>" align="absmiddle" />&nbsp;<a href="javascript:update_seccode()">更换</a><span id="seccode_tips" style="color:red"></span></td></tr>
</tbody>
<tr><th width="100">&nbsp;</th><td><input type="submit" value="登录并绑定" class="submit" /></td></tr>
</table>
</form>
<div class="c_form">
<table cellpadding="0" cellspacing="0" class="formtable">
<caption>
<h2>还没有注册吗？</h2>
<p>如果还没有本站的通行帐号，请先注册一个属于自己的帐号吧。</p>
</caption>
<tr><td>
<a href="<?php echo rewrite_mode('user.php/people/register/'); ?>" style="display:block;margin:0 110px 2em;width:100px;border:1px solid #486B26;background:#76A14F;line-height:30px;font-size:14px;text-align:center;text-decoration:none;"><strong style="display:block;border-top:1px solid #9EBC84;color:#FFF;padding:0 0.5em;">立即注册</strong></a>
</td></tr>
</table>
</div>
<?php } ?>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
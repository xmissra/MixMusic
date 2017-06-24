<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $userlogined,$missra_in_username; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>开通绿钻 - <?php echo IN_NAME; ?></title>
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
<li><a href="<?php echo rewrite_mode('user.php/profile/index/'); ?>"><span>个人资料</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/profile/avatar/'); ?>"><span>我的头像</span></a></li>
<li class="active"><a href="<?php echo rewrite_mode('user.php/profile/credit/'); ?>"><span>积分账户</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/profile/oauth/'); ?>"><span>帐号绑定</span></a></li>
</ul>
</div>
<div class="l_status c_form">
<a href="<?php echo rewrite_mode('user.php/profile/credit/'); ?>">我的积分</a><span class="pipe">|</span>
<a href="<?php echo rewrite_mode('user.php/profile/vip/'); ?>" class="active">开通绿钻</a><span class="pipe">|</span>
<a href="<?php echo rewrite_mode('user.php/profile/pay/'); ?>">充值金币</a>
</div>
<form method="get" onsubmit="getvip();return false;" class="c_form">
<table cellspacing="0" cellpadding="0" class="formtable">
<tr>绿钻会员每月售价为 <span style="font-weight:bold;"><?php echo IN_VIPPOINTS; ?></span> 金币，累计购买时间满360天自动转年付。</tr>
<tr><th style="width:10em;">登录密码:</th><td><input type="password" id="password" class="t_input" /><br />提交前请先输入登录密码。</td></tr>
<tr><th style="width:10em;">用户名:</th><td><input type="text" id="uname" value="<?php echo $missra_in_username; ?>" class="t_input" /><br />您还可以赠送绿钻给好友。</td></tr>
<tr><th style="width:10em;">购买月数:</th><td>
<select id="vipnum">
<option value="1">1个月</option>
<option value="2">2个月</option>
<option value="3">3个月</option>
<option value="4">4个月</option>
<option value="5">5个月</option>
<option value="6">6个月</option>
<option value="7">7个月</option>
<option value="8">8个月</option>
<option value="9">9个月</option>
<option value="10">10个月</option>
<option value="11">11个月</option>
<option value="12">12个月</option>
</select>
</td></tr>
<tr><th style="width:10em;"></th><td><input type="submit" value="立即开通" class="submit" /></td></tr>
</table>
</form>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid,$missra_in_isstar; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>明星认证 - <?php echo IN_NAME; ?></title>
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
<a href="<?php echo rewrite_mode('user.php/profile/mail/'); ?>">密保邮箱</a><span class="pipe">|</span>
<a href="<?php echo rewrite_mode('user.php/profile/verify/'); ?>" class="active">明星认证</a>
</div>
<form method="get" onsubmit="editverify();return false;" class="c_form">
<table cellspacing="0" cellpadding="0" class="formtable">
<tr>[<?php if($missra_in_isstar == 1){echo "<span style=\"font-weight:bold;color:red;\">已认证</span>";}elseif($missra_in_isstar == 2){echo "<font color=\"red\">待审核</font>";}else{echo "<span style=\"font-weight:bold;\">未认证</span>";} ?>] 修改认证资料会重新提交审核，本站承诺不会泄漏用户的隐私资料。</tr>
<tr><th style="width:10em;">登录密码:</th><td><input type="password" id="password" class="t_input" /><br />提交前请先输入登录密码。</td></tr>
<?php $row = $db->getrow("select * from ".tname('verify')." where in_uid=".$missra_in_userid); ?>
<tr><th style="width:10em;">真实姓名:</th><td><input type="text" id="_name" value="<?php echo $row['in_name']; ?>" class="t_input" /><br />资料审核通过后，该项会展现在您的个人主页。</td></tr>
<tr><th style="width:10em;">证件类型:</th><td>
<select id="_cardtype">
<option value="身份证">身份证</option>
<option value="护照"<?php if($row['in_cardtype'] == '护照'){echo " selected";} ?>>护照</option>
<option value="驾驶证"<?php if($row['in_cardtype'] == '驾驶证'){echo " selected";} ?>>驾驶证</option>
</select>
</td></tr>
<tr><th style="width:10em;">证件号码:</th><td><input type="text" id="_cardnum" value="<?php echo empty($row['in_cardnum']) ? NULL : substr($row['in_cardnum'], 0, 6).'************'; ?>" class="t_input" /><?php echo empty($row['in_cardnum']) ? NULL : '<br />该项如不更改请保持原样。'; ?></td></tr>
<tr><th style="width:10em;">联系地址:</th><td><input type="text" id="_address" value="<?php echo $row['in_address']; ?>" class="t_input" /></td></tr>
<tr><th style="width:10em;">手机号码:</th><td><input type="text" id="_mobile" value="<?php echo $row['in_mobile']; ?>" class="t_input" /></td></tr>
<tr><th style="width:10em;"></th><td><input type="submit" value="提交审核" class="submit" /></td></tr>
</table>
</form>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
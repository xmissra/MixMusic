<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>个人主页 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<style type="text/css">
@import url(<?php echo IN_PATH; ?>static/user/css/style.css);
</style>
</head>
<body>
<?php include 'source/user/people/top.php'; ?>
<div class="showmessage">
<div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">
<caption>
<h2>信息提示</h2>
</caption>
<p><a href="<?php echo IN_PATH; ?>user.php">用户不存在或已被管理员锁定！</a><script type="text/javascript">setTimeout("location.href='<?php echo IN_PATH; ?>user.php';", 3000);</script></p>
<p class="op"><a href="<?php echo IN_PATH; ?>user.php">页面跳转中...</a></p>
</div></div></div></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
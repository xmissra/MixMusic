<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid,$missra_in_username; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>查看详情 - 消息 - <?php echo IN_NAME; ?></title>
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
<div class="c_form">
<?php
$message = explode('/', $_SERVER['PATH_INFO']);
$msgid = isset($message[3]) ? intval($message[3]) : 0;
$row = $db->getrow("select * from ".tname('message')." where in_id=".$msgid);
if($row && $row['in_uids'] == $missra_in_userid){
$db->query("update ".tname('message')." set in_isread=1 where in_id=".$msgid);
if($row['in_uid'] > 0){
?>
<ul class="pm_list">
<li class="s_clear">
<div class="avatar48"><a href="<?php echo getlink($row['in_uid']); ?>"><img src="<?php echo getavatar($row['in_uid']); ?>" /></a></div>
<div class="pm_body"><div class="pm_h"><div class="pm_f">
<p><a href="<?php echo getlink($row['in_uid']); ?>"><?php echo $row['in_uname']; ?></a> <span class="gray"><?php echo datetime($row['in_addtime']); ?></span></p>
<div class="pm_c"><?php echo $row['in_content']; ?></div>
</div></div></div>
</li>
</ul>
<ul class="pm_list"><li class="s_clear">
<div class="avatar48"><a href="<?php echo getlink($missra_in_userid); ?>"><img src="<?php echo getavatar($missra_in_userid); ?>" /></a></div>
<div class="pm_body"><div class="pm_h"><div class="pm_f">
<p><a href="<?php echo getlink($missra_in_userid); ?>"><?php echo $missra_in_username; ?></a></p>
<div class="pm_c">
<form method="get" onsubmit="reply_message(<?php echo $row['in_uid']; ?>);return false;">
<textarea id="message" cols="40" rows="4" style="width: 95%;"></textarea><br />
<p style="padding-top:5px;"><input type="submit" value="快捷回复" class="submit" /></p>
</form>
</div>
</div></div></div>
</li></ul>
<?php }else{ ?>
<ul class="pm_list">
<li class="s_clear">
<div class="avatar48"><img src="<?php echo getavatar($row['in_uid']); ?>" /></div>
<div class="pm_body"><div class="pm_h"><div class="pm_f">
<p><?php echo $row['in_uname']; ?> <span class="gray"><?php echo datetime($row['in_addtime']); ?></span></p>
<div class="pm_c"><?php echo $row['in_content']; ?></div>
</div></div></div>
</li>
</ul>
<?php } ?>
<?php }else{ ?>
<div class="c_form">短消息不存在或您无权查看。</div>
<?php } ?>
</div>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
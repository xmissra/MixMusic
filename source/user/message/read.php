<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>未读消息 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/message.js"></script>
<script type="text/javascript">
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
<li class="active"><a href="<?php echo rewrite_mode('user.php/message/read/'); ?>"><span>未读消息</span></a></li>
<li class="null"><a href="<?php echo rewrite_mode('user.php/message/add/'); ?>">发短消息</a></li>
</ul>
</div>
<?php $message = explode("/", $_SERVER['PATH_INFO']); ?>
<div class="h_status">
<div class="r_option"><a href="javascript:void(0)" onclick="set_msg(1);">标记所有未读消息</a></div>
<a href="<?php echo rewrite_mode('user.php/message/read/'); ?>"<?php if($message[3] !== 'user' && $message[3] !== 'admin'){echo ' class="active"';} ?>>全部未读</a><span class="pipe">|</span>
<a href="<?php echo rewrite_mode('user.php/message/read/user/'); ?>"<?php if($message[3] == 'user'){echo ' class="active"';} ?>>私人消息</a><span class="pipe">|</span>
<a href="<?php echo rewrite_mode('user.php/message/read/admin/'); ?>"<?php if($message[3] == 'admin'){echo ' class="active"';} ?>>系统消息</a>
</div>
<div class="c_form">
<?php
if($message[3] !== 'user' && $message[3] !== 'admin'){
        $Arr = getuserpage("select * from ".tname('message')." where in_uids=".$missra_in_userid." and in_isread=0 order by in_addtime desc", 10, 3);
}elseif($message[3] == 'user'){
        $Arr = getuserpage("select * from ".tname('message')." where in_uids=".$missra_in_userid." and in_isread=0 and in_uid<>0 order by in_addtime desc", 10, 4);
}elseif($message[3] == 'admin'){
        $Arr = getuserpage("select * from ".tname('message')." where in_uids=".$missra_in_userid." and in_isread=0 and in_uid=0 order by in_addtime desc", 10, 4);
}
$result = $Arr[1];
$count = $Arr[2];
?>
<?php
if($count == 0){
?>
<div class="c_form">当前没有相应的短消息。</div>
<?php
}else{
echo '<ol class="pm_list">';
while ($row = $db->fetch_array($result)){
if($row['in_uid'] > 0){
?>
<li>
<div class="avatar48"><a href="<?php echo getlink($row['in_uid']); ?>"><img src="<?php echo getavatar($row['in_uid']); ?>" /></a></div>
<div class="pm_body"><div class="pm_h"><div class="pm_f">
<p><a href="<?php echo getlink($row['in_uid']); ?>"><?php echo $row['in_uname']; ?></a> <span class="gray"><?php echo datetime($row['in_addtime']); ?></span></p>
<div class="pm_c"><?php echo getlenth($row['in_content'], 100); ?><p><a href="<?php echo rewrite_mode('user.php/message/info/'.$row['in_id'].'/'); ?>">查看详情</a></p></div>
<a class="float_del" style="cursor:pointer" onclick="del_message(<?php echo $row['in_id']; ?>);">删除</a>
</div></div></div>
</li>
<?php }else{ ?>
<li>
<div class="avatar48"><img src="<?php echo getavatar($row['in_uid']); ?>" /></div>
<div class="pm_body"><div class="pm_h"><div class="pm_f">
<p><?php echo $row['in_uname']; ?> <span class="gray"><?php echo datetime($row['in_addtime']); ?></span></p>
<div class="pm_c"><?php echo getlenth($row['in_content'], 100); ?><p><a href="<?php echo rewrite_mode('user.php/message/info/'.$row['in_id'].'/'); ?>">查看详情</a></p></div>
<a class="float_del" style="cursor:pointer" onclick="del_message(<?php echo $row['in_id']; ?>);">删除</a>
</div></div></div>
</li>
<?php
}
}
echo '</ol>';
}
?>
<?php echo $Arr[0]; ?>
</div>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
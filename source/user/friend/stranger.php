<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>陌生人 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/confirm-lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/friend.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/message.js"></script>
<script type="text/javascript">
var in_path = '<?php echo IN_PATH; ?>';
var friend_group = '<select id="groupid" onchange="ongroup(this.value);"><option value="0">选择分组</option>'
<?php
$query = $db->query("select * from ".tname('friend_group')." where in_uid=".$missra_in_userid." order by in_id desc");
while ($row = $db->fetch_array($query)){
        echo " + '<option value=\"".$row['in_id']."\">".$row['in_title']."</option>'";
}
?>
+ '<option value="-1" style="color:red;">+新建分组</option></select>';
var pop = {
	friend: function(username) {
		$.layer({
			type: 1,
			title: '添加“' + username + '”为好友',
			page: {html: '<form method="get" onsubmit="addfriend(\'' + username + '\');return false;" class="c_form"><table cellspacing="0" cellpadding="0" class="formtable"><tr><th style="width:4em;">附言:</th><td><input type="text" id="message" class="t_input"  /></td></tr><tr><th style="width:4em;">分组:</th><td>' + friend_group + '</td></tr><tr><th style="width:4em;"></th><td><input type="submit" value="确定" class="submit" /></td></tr></table></form>'}
		});
	}
}
layer.use('confirm-ext.js');
function ongroup(_id) {
        if (_id < 0) {
		layer.closeAll();
		layer.prompt({title:'创建新分组'},function(title){addgroup(title);});
	}
}
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
<h2 class="title"><img src="<?php echo IN_PATH; ?>static/user/images/icon/friend.gif">好友</h2>
<div class="tabs_header">
<ul class="tabs">
<li><a href="<?php echo rewrite_mode('user.php/friend/index/'); ?>"><span>我的好友</span></a></li>
<li class="active"><a href="<?php echo rewrite_mode('user.php/friend/stranger/'); ?>"><span>陌生人</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/friend/trace/'); ?>"><span>我的足迹</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/friend/visitor/'); ?>"><span>我的访客</span></a></li>
</ul>
</div>
<div id="content" style="width:640px;">
<div class="c_mgs"><div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">他们添加过您，但还不是您的好友</div></div></div></div></div>
<?php
$id = '';
$query = $db->query("select in_uid from ".tname('friend')." where in_uids=".$missra_in_userid);
while ($rows = $db->fetch_array($query)) {
$friend = $db->getone("select in_id from ".tname('friend')." where in_uid=".$missra_in_userid." and in_uids=".$rows['in_uid']);
if(!$friend){
$id .= $rows['in_uid'].',';
}
}
$id = str_replace(',0', '', $id.'0');
$Arr = getuserpage("select * from ".tname('friend')." where in_uid in ($id) order by in_addtime desc", 10, 3);
$result = $Arr[1];
$count = $Arr[2];
if($count == 0){
?>
<div class="c_form">没有相关用户列表。</div>
<?php }else{ ?>
<div class="thumb_list"><ul>
<?php
while ($row = $db->fetch_array($result)){
$invisible = $db->getone("select in_invisible from ".tname('session')." where in_uid=".$row['in_uid']);
$online = is_numeric($invisible) && $invisible == 0 ? '<p class="online_icon_p">' : '<p>';
?>
<li>
<div class="avatar48"><a href="<?php echo getlink($row['in_uid']); ?>"><img src="<?php echo getavatar($row['in_uid']); ?>"></a></div>
<div class="thumbTitle"><?php echo $online; ?><a href="<?php echo getlink($row['in_uid']); ?>"><?php echo $row['in_uname']; ?></a></p></div>
<div class="gray"><?php echo datetime($row['in_addtime']); ?></div>
<div class="gray">
<a href="javascript:void(0)" onclick="pop.friend('<?php echo $row['in_uname']; ?>');">添加</a><span class="pipe">|</span>
<a href="javascript:void(0)" onclick="layer.prompt({title:'给“<?php echo $row['in_uname']; ?>”发短消息',type:3},function(msg){sendmessage('<?php echo $row['in_uname']; ?>', msg);});">私信</a>
</div>
</li>
<?php } ?>
</ul></div>
<?php echo $Arr[0]; ?>
<?php } ?>
</div>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
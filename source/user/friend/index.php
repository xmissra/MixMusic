<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<?php
$friend = explode('/', $_SERVER['PATH_INFO']);
$gid = isset($friend[3]) ? $friend[3] : NULL;
if(IsNum($gid)){
$get = $db->getone("select in_id from ".tname('friend_group')." where in_uid=".$missra_in_userid." and in_id=".$gid);
$Arr = getuserpage("select * from ".tname('friend')." where in_uid=".$missra_in_userid." and in_gid=".$gid." order by in_addtime desc", 10, 4);
}else{
$get = true;
$Arr = getuserpage("select * from ".tname('friend')." where in_uid=".$missra_in_userid." order by in_addtime desc", 10, 3);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>好友 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/confirm-lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/friend.js"></script>
<script type="text/javascript">
var in_path = '<?php echo IN_PATH; ?>';
var guide_url = '<?php echo rewrite_mode('user.php/friend/index/'); ?>';
var friend_group = '<select id="groupid" onchange="ongroup(this.value);"><option value="0">选择分组</option>'
<?php
$query = $db->query("select * from ".tname('friend_group')." where in_uid=".$missra_in_userid." order by in_id desc");
while ($row = $db->fetch_array($query)){
        echo " + '<option value=\"".$row['in_id']."\">".$row['in_title']."</option>'";
}
?>
+ '<option value="-1" style="color:red;">+新建分组</option></select>';
var pop = {
	friend: function(fid) {
		$.layer({
			type: 1,
			title: '移动到分组',
			page: {html: '<form method="get" onsubmit="changefriend(' + fid + ');return false;" class="c_form"><table cellspacing="0" cellpadding="0" class="formtable"><tr><th style="width:4em;">分组:</th><td>' + friend_group + '</td></tr><tr><th style="width:4em;"></th><td><input type="submit" value="确定" class="submit" /></td></tr></table></form>'}
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
function del_msg(_id) {
	$.layer({
		shade: [0],
		area: ['auto', 'auto'],
		dialog: {
			msg: '将同时清空分组中的好友，确认继续？',
			btns: 2,
			type: 4,
			btn: ['确认', '取消'],
			yes: function() {
				delgroup(_id);
			},
			no: function() {
				layer.msg('已取消删除', 1, 0);
			}
		}
	});
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
<li class="active"><a href="<?php echo rewrite_mode('user.php/friend/index/'); ?>"><span>我的好友</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/friend/stranger/'); ?>"><span>陌生人</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/friend/trace/'); ?>"><span>我的足迹</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/friend/visitor/'); ?>"><span>我的访客</span></a></li>
</ul>
</div>
<div id="content" style="width:640px;">
<?php if($get){ ?>
<?php
$result = $Arr[1];
$count = $Arr[2];
if($count == 0){
?>
<div class="c_form">没有相关用户列表。</div>
<?php }else{ ?>
<div class="thumb_list"><ul>
<?php
while ($row = $db->fetch_array($result)){
$invisible = $db->getone("select in_invisible from ".tname('session')." where in_uid=".$row['in_uids']);
$online = is_numeric($invisible) && $invisible == 0 ? '<p class="online_icon_p">' : '<p>';
$isfriend = $db->getone("select in_id from ".tname('friend')." where in_uid=".$row['in_uids']." and in_uids=".$missra_in_userid);
$checkfriend = $isfriend ? '<div class="gray" style="color:red;">互为好友</div>' : '<div class="gray">单向好友</div>';
?>
<li>
<div class="avatar48"><a href="<?php echo getlink($row['in_uids']); ?>"><img src="<?php echo getavatar($row['in_uids']); ?>"></a></div>
<div class="thumbTitle"><?php echo $online; ?><a href="<?php echo getlink($row['in_uids']); ?>"><?php echo $row['in_unames']; ?></a></p></div>
<?php echo $checkfriend; ?>
<div class="gray">
<a href="javascript:void(0)" onclick="pop.friend(<?php echo $row['in_id']; ?>);">分组</a><span class="pipe">|</span>
<a href="javascript:void(0)" onclick="delfriend(<?php echo $row['in_id']; ?>);">删除</a>
</div>
</li>
<?php } ?>
</ul></div>
<?php echo $Arr[0]; ?>
<?php } ?>
<?php }else{ ?>
<div class="c_form">分组不存在或您无权查看。</div>
<?php } ?>
</div>
<div id="sidebar" style="width:150px;">
<div class="cat">
<h3>好友分组</h3>
<ul class="post_list line_list">
<?php
if(!IsNum($gid)){
        echo "<li class=\"current\"><a onclick=\"layer.prompt({title:'创建新分组'},function(title){addgroup(title);});\" class=\"c_resend\" style=\"cursor:pointer\">新增</a><a href=\"".rewrite_mode('user.php/friend/index/')."\">全部好友</a></li>";
}else{
        echo "<li><a onclick=\"layer.prompt({title:'创建新分组'},function(title){addgroup(title);});\" class=\"c_resend\" style=\"cursor:pointer\">新增</a><a href=\"".rewrite_mode('user.php/friend/index/')."\">全部好友</a></li>";
}
$res=$db->query("select * from ".tname('friend_group')." where in_uid=".$missra_in_userid." order by in_id desc");
if($res){
        while ($rows = $db->fetch_array($res)){
                if($gid == $rows['in_id']){
                        echo "<li class=\"current\"><a onclick=\"layer.prompt({title:'修改分组'},function(title){edigroup(".$rows['in_id'].", title);});\" class=\"c_edit\" style=\"cursor:pointer\">编辑</a><a onclick=\"del_msg(".$rows['in_id'].");\" class=\"c_delete\" style=\"cursor:pointer\">删除</a><a href=\"".rewrite_mode('user.php/friend/index/'.$rows['in_id'].'/')."\">".$rows['in_title']."</a></li>";
                }else{
                        echo "<li><a onclick=\"layer.prompt({title:'修改分组'},function(title){edigroup(".$rows['in_id'].", title);});\" class=\"c_edit\" style=\"cursor:pointer\">编辑</a><a onclick=\"del_msg(".$rows['in_id'].");\" class=\"c_delete\" style=\"cursor:pointer\">删除</a><a href=\"".rewrite_mode('user.php/friend/index/'.$rows['in_id'].'/')."\">".$rows['in_title']."</a></li>";
                }
        }
}
?>
</ul>
</div>
</div>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
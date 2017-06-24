<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>排行榜 - <?php echo IN_NAME; ?></title>
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
<h2 class="title"><img src="<?php echo IN_PATH; ?>static/user/images/icon/rank.gif">排行榜</h2>
<div class="tabs_header">
<?php $rank = explode("/", $_SERVER['PATH_INFO']); ?>
<ul class="tabs">
<li<?php if(!in_array($rank[3], array('gold', 'level', 'man', 'woman', 'online', 'join'))){echo ' class="active"';} ?>><a href="<?php echo rewrite_mode('user.php/misc/rank/'); ?>"><span>人气排行</span></a></li>
<li<?php if($rank[3] == 'gold'){echo ' class="active"';} ?>><a href="<?php echo rewrite_mode('user.php/misc/rank/gold/'); ?>"><span>金币排行</span></a></li>
<li<?php if($rank[3] == 'level'){echo ' class="active"';} ?>><a href="<?php echo rewrite_mode('user.php/misc/rank/level/'); ?>"><span>经验排行</span></a></li>
<li<?php if($rank[3] == 'man'){echo ' class="active"';} ?>><a href="<?php echo rewrite_mode('user.php/misc/rank/man/'); ?>"><span>帅哥排行</span></a></li>
<li<?php if($rank[3] == 'woman'){echo ' class="active"';} ?>><a href="<?php echo rewrite_mode('user.php/misc/rank/woman/'); ?>"><span>美女排行</span></a></li>
<li<?php if($rank[3] == 'online'){echo ' class="active"';} ?>><a href="<?php echo rewrite_mode('user.php/misc/rank/online/'); ?>"><span>在线成员</span></a></li>
<li<?php if($rank[3] == 'join'){echo ' class="active"';} ?>><a href="<?php echo rewrite_mode('user.php/misc/rank/join/'); ?>"><span>全部成员</span></a></li>
</ul>
</div>
<div class="c_form">
<?php
if($rank[3] == 'gold'){
        $Arr = getuserpage("select * from ".tname('user')." order by in_points desc", 20, 4);
}elseif($rank[3] == 'level'){
        $Arr = getuserpage("select * from ".tname('user')." order by in_rank desc", 20, 4);
}elseif($rank[3] == 'man'){
        $Arr = getuserpage("select * from ".tname('user')." where in_sex=0 order by in_userid desc", 20, 4);
}elseif($rank[3] == 'woman'){
        $Arr = getuserpage("select * from ".tname('user')." where in_sex=1 order by in_userid desc", 20, 4);
}elseif($rank[3] == 'online'){
        $id = '';
        $query = $db->query("select in_uid from ".tname('session')." where in_invisible=0");
        while ($rows = $db->fetch_array($query)) {
                $id .= $rows['in_uid'].',';
        }
        $id = str_replace(',0', '', $id.'0');
        $Arr = getuserpage("select * from ".tname('user')." where in_userid in ($id) order by in_logintime desc", 20, 4);
}elseif($rank[3] == 'join'){
        $Arr = getuserpage("select * from ".tname('user')." order by in_regdate desc", 20, 4);
}else{
        $Arr = getuserpage("select * from ".tname('user')." order by in_hits desc", 20, 3);
}
$result = $Arr[1];
$count = $Arr[2];
if($count == 0){
        echo '<div class="c_form">没有相关成员。</div>';
}else{
        echo '<div class="space_list">';
        while ($row = $db->fetch_array($result)){
                $invisible = $db->getone("select in_invisible from ".tname('session')." where in_uid=".$row['in_userid']);
                $online = is_numeric($invisible) && $invisible == 0 ? '<a href="'.rewrite_mode('user.php/misc/rank/online/').'" title="当前在线"><img src="'.IN_PATH.'static/user/images/online_icon.gif" align="absmiddle"></a>&nbsp;' : '';
                $vip = $row['in_grade'] == 1 ? '<a href="'.rewrite_mode('user.php/profile/vip/').'" title="绿钻会员"><img src="'.IN_PATH.'static/user/images/vip/vip.gif" align="absmiddle"></a>&nbsp;' : '';
                $star = $row['in_isstar'] == 1 ? '<a href="'.rewrite_mode('user.php/profile/verify/').'" title="明星认证"><img src="'.IN_PATH.'static/user/images/star.png" align="absmiddle"></a>&nbsp;' : '';
?>
<table cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="65"><div class="avatar48"><a href="<?php echo getlink($row['in_userid']); ?>"><img src="<?php echo getavatar($row['in_userid']); ?>"></a></div></td>
<td>
<h2><?php echo $online; ?><a href="<?php echo getlink($row['in_userid']); ?>"><?php echo $row['in_username']; ?></a>&nbsp;<?php echo $vip; ?><?php echo $star; ?><?php echo getlevel($row['in_rank'], 1); ?></h2>
<p>人气：<?php echo $row['in_hits']; ?> / 金币：<?php echo $row['in_points']; ?> / 经验：<?php echo $row['in_rank']; ?></p>
</td>
<td width="100">
<ul class="line_list">
<li><a href="javascript:void(0)" onclick="pop.friend('<?php echo $row['in_username']; ?>');">加为好友</a></li>
<li><a href="javascript:void(0)" onclick="layer.prompt({title:'给“<?php echo $row['in_username']; ?>”发短消息',type:3},function(msg){sendmessage('<?php echo $row['in_username']; ?>', msg);});">发送消息</a></li>
</ul>
</td>
</tr>
</table>
<?php } ?>
<?php echo $Arr[0]; ?>
</div>
<?php } ?>
</div>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
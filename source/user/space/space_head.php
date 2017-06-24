<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title><?php echo $ear['in_username']; ?> - 个人主页 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<link href="<?php echo IN_PATH; ?>static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/confirm-lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/friend.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/message.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/wall.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/doing.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/face.js"></script>
<script type="text/javascript">
var in_path = '<?php echo IN_PATH; ?>';
var friend_group = '<select id="groupid" onchange="ongroup(this.value);"><option value="0">选择分组</option>'
<?php
if($userlogined){
$query = $db->query("select * from ".tname('friend_group')." where in_uid=".$missra_in_userid." order by in_id desc");
while ($row = $db->fetch_array($query)){
        echo " + '<option value=\"".$row['in_id']."\">".$row['in_title']."</option>'";
}
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
function setcopy(id, text){
	var browserName = navigator.appName;
	if(browserName == 'Netscape'){
		layer.tips('您的浏览器不支持自动复制，请手工复制！', '#' + id, {
			style: ['background-color:#FF8901;color:#fff', '#FF8901'],
			maxWidth: 185,
			time: 3,
			closeBtn: [0, true]
		});
	}else if(browserName == 'Microsoft Internet Explorer'){
		clipboardData.setData('Text', text);
		layer.tips('主页地址复制成功！', '#' + id, {
			style: ['background-color:#99C521;color:#fff', '#99C521'],
			maxWidth: 185,
			time: 3,
			closeBtn: [0, true]
		});
	}
}
</script>
<style type="text/css">
@import url(<?php echo IN_PATH; ?>static/user/css/style.css);
@import url(<?php echo IN_PATH; ?>static/user/css/space.css);
</style>
</head>
<body>
<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<?php
$blog = explode('/', $_SERVER['PATH_INFO']);
$gid = isset($blog[3]) ? $blog[3] : NULL;
if(IsNum($gid)){
$get = $db->getone("select in_id from ".tname('blog_group')." where in_uid=".$missra_in_userid." and in_id=".$gid);
$Arr = getuserpage("select * from ".tname('blog')." where in_uid=".$missra_in_userid." and in_gid=".$gid." order by in_addtime desc", 20, 4);
}else{
$get = true;
$Arr = getuserpage("select * from ".tname('blog')." where in_uid=".$missra_in_userid." order by in_addtime desc", 20, 3);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>我的日志 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/confirm-lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/blog.js"></script>
<script type="text/javascript">
var in_path = '<?php echo IN_PATH; ?>';
var guide_url = '<?php echo rewrite_mode('user.php/blog/me/'); ?>';
layer.use('confirm-ext.js');
function del_msg(_id) {
	$.layer({
		shade: [0],
		area: ['auto', 'auto'],
		dialog: {
			msg: '将同时清空分类中的日志，确认继续？',
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
.float_delblog{
	width:13px;
	height:14px;
	background:url(<?php echo IN_PATH; ?>static/user/images/delete.gif) no-repeat 0 0;
	top:0.5em;
	right:5px;
	text-indent:-999em;
	overflow:hidden;
	display:block
}
.float_delblog:hover{
	background-position:0 -14px
}
.float_editblog{
	float:right;
	width:13px;
	height:14px;
	background:url(<?php echo IN_PATH; ?>static/user/images/edit.gif) no-repeat 0 0;
	top:0.5em;
	right:5px;
	text-indent:-999em;
	overflow:hidden;
	display:block
}
.float_editblog:hover{
	background-position:0 -14px
}
</style>
</head>
<body>
<?php include 'source/user/people/top.php'; ?>
<div id="main">
<?php include 'source/user/people/left.php'; ?>
<div id="mainarea">
<h2 class="title"><img src="<?php echo IN_PATH; ?>static/user/images/icon/blog.gif">日志</h2>
<div class="tabs_header">
<ul class="tabs">
<li><a href="<?php echo rewrite_mode('user.php/blog/index/'); ?>"><span>大家的日志</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/blog/friend/'); ?>"><span>好友的日志</span></a></li>
<li class="active"><a href="<?php echo rewrite_mode('user.php/blog/me/'); ?>"><span>我的日志</span></a></li>
<li class="null"><a href="<?php echo rewrite_mode('user.php/blog/add/'); ?>">发表新日志</a></li>
</ul>
</div>
<div id="content" style="width:640px;">
<?php if($get){ ?>
<?php
$result = $Arr[1];
$count = $Arr[2];
if($count == 0){
?>
<div class="c_form">还没有相关的日志。</div>
<?php }else{ ?>
<ul id="share_ul">
<?php
while ($row = $db->fetch_array($result)){
$content = getblog($row['in_content'], 1);
?>
<li>
<div class="title">
<div class="r_option"><a class="float_delblog" style="cursor:pointer" onclick="delblog(<?php echo $row['in_id']; ?>);">删除</a></div>
<h4><a href="<?php echo rewrite_mode('user.php/blog/edit/'.$row['in_id'].'/'); ?>" class="float_editblog">编辑</a><a href="<?php echo getlink($row['in_id'], 'blog'); ?>"><?php echo $row['in_title']; ?></a></h4>
<span class="gray"><?php echo $row['in_addtime']; ?></span>
</div>
<div class="feed">
<div style="width:100%;overflow:hidden;">
<div class="quote">
<span class="q"><?php echo $content; ?></span>
</div></div></div>
</li>
<?php } ?>
</ul>
<?php echo $Arr[0]; ?>
<?php } ?>
<?php }else{ ?>
<div class="c_form">分类不存在或您无权查看。</div>
<?php } ?>
</div>
<div id="sidebar" style="width:150px;">
<div class="cat">
<h3>日志分类</h3>
<ul class="post_list line_list">
<?php
if(!IsNum($gid)){
        echo "<li class=\"current\"><a onclick=\"layer.prompt({title:'创建新分类'},function(title){addgroup(title);});\" class=\"c_resend\" style=\"cursor:pointer\">新增</a><a href=\"".rewrite_mode('user.php/blog/me/')."\">全部日志</a></li>";
}else{
        echo "<li><a onclick=\"layer.prompt({title:'创建新分类'},function(title){addgroup(title);});\" class=\"c_resend\" style=\"cursor:pointer\">新增</a><a href=\"".rewrite_mode('user.php/blog/me/')."\">全部日志</a></li>";
}
$res=$db->query("select * from ".tname('blog_group')." where in_uid=".$missra_in_userid." order by in_id desc");
if($res){
        while ($rows = $db->fetch_array($res)){
                if($gid == $rows['in_id']){
                        echo "<li class=\"current\"><a onclick=\"layer.prompt({title:'修改分类'},function(title){editgroup(".$rows['in_id'].", title);});\" class=\"c_edit\" style=\"cursor:pointer\">编辑</a><a onclick=\"del_msg(".$rows['in_id'].");\" class=\"c_delete\" style=\"cursor:pointer\">删除</a><a href=\"".rewrite_mode('user.php/blog/me/'.$rows['in_id'].'/')."\">".$rows['in_title']."</a></li>";
                }else{
                        echo "<li><a onclick=\"layer.prompt({title:'修改分类'},function(title){editgroup(".$rows['in_id'].", title);});\" class=\"c_edit\" style=\"cursor:pointer\">编辑</a><a onclick=\"del_msg(".$rows['in_id'].");\" class=\"c_delete\" style=\"cursor:pointer\">删除</a><a href=\"".rewrite_mode('user.php/blog/me/'.$rows['in_id'].'/')."\">".$rows['in_title']."</a></li>";
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
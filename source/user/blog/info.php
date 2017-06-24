<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php
global $db;
$info = explode('/', $_SERVER['PATH_INFO']);
$bid = isset($info[3]) ? intval($info[3]) : 0;
$rows = $db->getrow("select * from ".tname('blog')." where in_id=".$bid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>阅读日志 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<link href="<?php echo IN_PATH; ?>static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/blog.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/face.js"></script>
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
var in_path = '<?php echo IN_PATH; ?>';
var guide_url = '<?php echo rewrite_mode('user.php/people/home/'); ?>';
var pop = {
	up: function(scrolling, text, url, width, height, top) {
		layer.open({
			type: 2,
			maxmin: true,
			title: text,
			content: [url, scrolling],
			area: [width, height],
			offset: top,
			shade: false
		});
	}
}
function qzone_return(type){
        layer.closeAll();
        if(type==1){
            uc_syn('login');
            location.href = guide_url;
        }else{
            location.href = '<?php echo rewrite_mode('user.php/people/connect/'); ?>';
        }
}
function update_seccode(){
	$('img_seccode').src = '<?php echo rewrite_mode('user.php/people/seccode/\' + Math.random() + \'/'); ?>';
}
</script>
<style type="text/css">
@import url(<?php echo IN_PATH; ?>static/user/css/style.css);
@import url(<?php echo IN_PATH; ?>static/user/css/blog.css);
</style>
</head>
<body>
<?php include 'source/user/people/top.php'; ?>
<?php
if($rows){
$db->query("update ".tname('blog')." set in_hits=in_hits+1 where in_id=".$bid);
$digs = $rows['in_egg'] + $rows['in_flower'] + $rows['in_scary'] + $rows['in_cool'] + $rows['in_beautiful'];
$intro = getblog($rows['in_content']);
?>
<div id="main">
<?php include 'source/user/people/left.php'; ?>
<div id="mainarea">
<div class="c_header a_header">
<div class="avatar48"><a href="<?php echo getlink($rows['in_uid']); ?>"><img src="<?php echo getavatar($rows['in_uid']); ?>"></a></div>
<p style="font-size:14px"><a href="<?php echo getlink($rows['in_uid']); ?>"><?php echo $rows['in_uname']; ?></a></p>
<a href="<?php echo getlink($rows['in_uid'], 's_blog'); ?>" class="spacelink">TA的日志</a>
<span class="pipe">&raquo;</span>
<a href="<?php echo getlink($rows['in_id'], 'blog'); ?>"><?php echo $rows['in_title']; ?></a>
</div>
<div class="entry" style="padding:0 0 10px;">
<div class="title">
<h1><?php echo $rows['in_title']; ?></h1>
<span class="hot"><em>热</em><?php echo $rows['in_hits']; ?></span>
<span class="gray"><?php echo $rows['in_addtime']; ?></span>
</div>
<div class="article "><div class="resizeimg"><div class="resizeimg2"><div class="resizeimg3"><div class="resizeimg4"><?php echo $intro; ?></div></div></div></div></div>
</div>
<div style="padding:0 0 10px;"><div style="text-align: right; padding-top:10px; "><a href="javascript:void(0)" onclick="blogshare(<?php echo $rows['in_id']; ?>);" class="a_share">推荐</a></div></div>
<div style="margin:0 auto;padding:10px;width:100%;text-align:left;"><div class="digc"><table><tr>
<td valign="bottom"><a href="javascript:void(0)" onclick="dig_blog(<?php echo $rows['in_id']; ?>, 'egg');"><div class="digcolumn"><div class="digchart dc1" style="height:<?php echo $rows['in_egg'] == 0 ? 0 : ceil($rows['in_egg'] / $digs * 100 / 2); ?>px;"><em><?php echo $rows['in_egg']; ?></em></div></div><div class="digface"><img src="<?php echo IN_PATH; ?>static/user/images/click/egg.gif" /><br />鸡蛋</div></a></td>
<td valign="bottom"><a href="javascript:void(0)" onclick="dig_blog(<?php echo $rows['in_id']; ?>, 'flower');"><div class="digcolumn"><div class="digchart dc2" style="height:<?php echo $rows['in_flower'] == 0 ? 0 : ceil($rows['in_flower'] / $digs * 100 / 2); ?>px;"><em><?php echo $rows['in_flower']; ?></em></div></div><div class="digface"><img src="<?php echo IN_PATH; ?>static/user/images/click/flower.gif" /><br />鲜花</div></a></td>
<td valign="bottom"><a href="javascript:void(0)" onclick="dig_blog(<?php echo $rows['in_id']; ?>, 'scary');"><div class="digcolumn"><div class="digchart dc3" style="height:<?php echo $rows['in_scary'] == 0 ? 0 : ceil($rows['in_scary'] / $digs * 100 / 2); ?>px;"><em><?php echo $rows['in_scary']; ?></em></div></div><div class="digface"><img src="<?php echo IN_PATH; ?>static/user/images/click/scary.gif" /><br />雷人</div></a></td>
<td valign="bottom"><a href="javascript:void(0)" onclick="dig_blog(<?php echo $rows['in_id']; ?>, 'cool');"><div class="digcolumn"><div class="digchart dc4" style="height:<?php echo $rows['in_cool'] == 0 ? 0 : ceil($rows['in_cool'] / $digs * 100 / 2); ?>px;"><em><?php echo $rows['in_cool']; ?></em></div></div><div class="digface"><img src="<?php echo IN_PATH; ?>static/user/images/click/cool.gif" /><br />酷毙</div></a></td>
<td valign="bottom"><a href="javascript:void(0)" onclick="dig_blog(<?php echo $rows['in_id']; ?>, 'beautiful');"><div class="digcolumn"><div class="digchart dc5" style="height:<?php echo $rows['in_beautiful'] == 0 ? 0 : ceil($rows['in_beautiful'] / $digs * 100 / 2); ?>px;"><em><?php echo $rows['in_beautiful']; ?></em></div></div><div class="digface"><img src="<?php echo IN_PATH; ?>static/user/images/click/beautiful.gif" /><br />漂亮</div></a></td>
</tr></table></div></div>
<div style="padding-top:20px; width:100%; overflow:hidden;">
<h2>评论</h2>
<?php
$Arr = getuserpage("select * from ".tname('comment')." where in_table='blog' and in_tid=".$bid." order by in_addtime desc", 10, 4);
$result = $Arr[1];
echo '<div class="comments_list"><ul>';
while ($com = $db->fetch_array($result)){
$content = preg_replace('/\[em:(\d+)]/is', '<img src="'.IN_PATH.'static/user/images/face/\1.gif" class="face">', $com['in_content']);
?>
<li><div class="avatar48"><a href="<?php echo getlink($com['in_uid']); ?>"><img src="<?php echo getavatar($com['in_uid']); ?>" /></a></div><div class="title"><div class="r_option"><a href="javascript:void(0)" onclick="delcomment(<?php echo $com['in_id']; ?>);">删除</a></div><a href="<?php echo getlink($com['in_uid']); ?>"><?php echo $com['in_uname']; ?></a> <span class="gray"><?php echo datetime($com['in_addtime']); ?></span></div><div class="detail"><?php echo $content; ?></div></li>
<?php } ?>
</ul></div>
<?php echo $Arr[0]; ?>
<form method="get" onsubmit="commentblog(<?php echo $rows['in_id']; ?>);return false;" class="quickpost" style="padding-bottom: 1em;"><table cellpadding="0" cellspacing="0">
<tr><td><a href="javascript:void(0)" id="comment_face" onclick="showFace(this.id, 'content');return false;"><img src="<?php echo IN_PATH; ?>static/user/images/facelist.gif" align="absmiddle" /></a></td></tr>
<tr><td><textarea id="content" rows="5" cols="60" style="width: 380px;"></textarea></td></tr>
<tr><td><input type="submit" class="submit" value="评论" /> <span id="comment_tips" style="color:red"></span></td></tr>
</table></form>
</div>
</div>
<div id="bottom"></div>
</div>
<?php }else{ ?>
<div class="showmessage">
<div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">
<caption>
<h2>信息提示</h2>
</caption>
<p><a href="<?php echo IN_PATH; ?>user.php">抱歉，您要阅读的日志不存在！</a><script type="text/javascript">setTimeout("location.href='<?php echo IN_PATH; ?>user.php';", 3000);</script></p>
<p class="op"><a href="<?php echo IN_PATH; ?>user.php">页面跳转中...</a></p>
</div></div></div></div>
</div>
<?php } ?>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
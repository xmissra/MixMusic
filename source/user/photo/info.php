<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php
global $db;
$info = explode('/', $_SERVER['PATH_INFO']);
$pid = isset($info[3]) ? intval($info[3]) : 0;
$rows = $db->getrow("select * from ".tname('photo')." where in_id=".$pid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>浏览照片 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<link href="<?php echo IN_PATH; ?>static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/photo.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/face.js"></script>
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
var in_path = '<?php echo IN_PATH; ?>';
var del_url = '<?php echo getlink($rows['in_gid'], 'photogroup'); ?>';
var cover_url = '<?php echo rewrite_mode('user.php/photo/me/'); ?>';
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
function change(type) {
	if (type == 1) {
		p_edit.style.display = 'none';
		p_form.style.display = '';
	} else {
		p_edit.style.display = '';
		p_form.style.display = 'none';
	}
}
function photopage(_id, _cur) {
	if(_cur == 'prev'){
		if(_id){
			location.href = "<?php echo getlink('" + _id + "', 'photo'); ?>";
		}else{
			layer.msg('已经是第一张了！', {icon: 5});
		}
	}else{
		if(_id){
			location.href = "<?php echo getlink('" + _id + "', 'photo'); ?>";
		}else{
			layer.msg('已经是最后一张了！', {icon: 5});
		}
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
@import url(<?php echo IN_PATH; ?>static/user/css/album.css);
</style>
</head>
<body>
<?php include 'source/user/people/top.php'; ?>
<?php
if($rows){
$db->query("update ".tname('photo')." set in_hits=in_hits+1 where in_id=".$pid);
$digs = $rows['in_egg'] + $rows['in_flower'] + $rows['in_scary'] + $rows['in_cool'] + $rows['in_beautiful'];
$nums = $db->num_rows($db->query("select count(*) from ".tname('photo')." where in_gid=".$rows['in_gid']));
$gids = $db->getrow("select * from ".tname('photo_group')." where in_id=".$rows['in_gid']);
$p = 0;
$query = $db->query("select in_id from ".tname('photo')." where in_gid=".$rows['in_gid']." order by in_id asc");
while ($row = $db->fetch_array($query)) {
$p = $p+1;
if($pid == $row['in_id']){
$order = $p;
}
}
$upid=$db->getone("select in_id from ".tname('photo')." where in_gid=".$rows['in_gid']." and in_id<".$pid." order by in_id desc");
if($upid){
	$upurl = "javascript:photopage(".$upid.", 'prev');";
}else{
	$upurl = "javascript:photopage(0, 'prev');";
}
$downid=$db->getone("select in_id from ".tname('photo')." where in_gid=".$rows['in_gid']." and in_id>".$pid." order by in_id asc");
if($downid){
	$downurl = "javascript:photopage(".$downid.", 'next');";
}else{
	$downurl = "javascript:photopage(0, 'next');";
}
?>
<div id="main">
<?php include 'source/user/people/left.php'; ?>
<div id="mainarea">
<div class="c_header a_header">
<div class="avatar48"><a href="<?php echo getlink($rows['in_uid']); ?>"><img src="<?php echo getavatar($rows['in_uid']); ?>"></a></div>
<p style="font-size:14px"><a href="<?php echo getlink($rows['in_uid']); ?>"><?php echo $rows['in_uname']; ?></a></p>
<a href="<?php echo getlink($rows['in_uid'], 's_photo'); ?>" class="spacelink">TA的相册</a>
<span class="pipe">&raquo;</span>
<a href="<?php echo getlink($gids['in_id'], 'photogroup'); ?>"><?php echo $gids['in_title']; ?></a>
<span class="pipe">&raquo;</span>
<a href="<?php echo getlink($rows['in_id'], 'photo'); ?>"><?php echo $rows['in_title']; ?></a>
</div>
<div class="h_status"><div class="r_option"><a href="<?php echo $upurl; ?>">上一张</a><span class="pipe">|</span><a href="<?php echo $downurl; ?>">下一张</a></div>当前第 <?php echo $order; ?> 张<span class="pipe">|</span>共 <?php echo $nums; ?> 张照片</div>
<div class="photobox">
<div><a href="<?php echo $downurl; ?>"><img src="<?php echo getphoto($rows['in_id']); ?>" /></a></div>
<div class="yinfo">
<p>
<?php echo $rows['in_title']; ?>
<span class="pipe">|</span>
<a style="cursor:pointer" id="p_edit" onclick="change(1);">编辑</a>
<span id="p_form" style="display:none;">
<select id="groupid">
<option value="0">选择相册</option>
<?php
$change_query = $db->query("select * from ".tname('photo_group')." where in_uid=".$rows['in_uid']." order by in_id desc");
while ($change = $db->fetch_array($change_query)){
        if($rows['in_gid'] == $change['in_id']){
                echo "<option value=\"".$change['in_id']."\" selected>".$change['in_title']."</option>";
        }else{
                echo "<option value=\"".$change['in_id']."\">".$change['in_title']."</option>";
        }
}
?>
</select>
<input type="text" class="t_input" size="15" id="title">
<input type="button" class="submit" onclick="editphoto(<?php echo $rows['in_id']; ?>);" value="修改">
<button type="button" class="button" onclick="change(0);">取消</button>
</span>
</p>
<p class="gray"><span class="hot"><em>热</em><?php echo $rows['in_hits']; ?></span>上传于 <?php echo $rows['in_addtime']; ?></p>
</div>
<table width="100%"><tr>
<td align="left"><a href="<?php echo getphoto($rows['in_id']); ?>" target="_blank">查看原图</a></td>
<td align="right"><a href="javascript:void(0)" onclick="coverphoto(<?php echo $rows['in_id']; ?>);">设为封面</a><span class="pipe">|</span><a href="javascript:void(0)" onclick="delphoto(<?php echo $rows['in_id']; ?>);">删除</a></td>
</tr></table>
</div>
<div style="margin:0 auto;padding:10px;width:100%;text-align:left;"><div class="digc"><table><tr>
<td valign="bottom"><a href="javascript:void(0)" onclick="dig_photo(<?php echo $rows['in_id']; ?>, 'egg');"><div class="digcolumn"><div class="digchart dc1" style="height:<?php echo $rows['in_egg'] == 0 ? 0 : ceil($rows['in_egg'] / $digs * 100 / 2); ?>px;"><em><?php echo $rows['in_egg']; ?></em></div></div><div class="digface"><img src="<?php echo IN_PATH; ?>static/user/images/click/egg.gif" /><br />鸡蛋</div></a></td>
<td valign="bottom"><a href="javascript:void(0)" onclick="dig_photo(<?php echo $rows['in_id']; ?>, 'flower');"><div class="digcolumn"><div class="digchart dc2" style="height:<?php echo $rows['in_flower'] == 0 ? 0 : ceil($rows['in_flower'] / $digs * 100 / 2); ?>px;"><em><?php echo $rows['in_flower']; ?></em></div></div><div class="digface"><img src="<?php echo IN_PATH; ?>static/user/images/click/flower.gif" /><br />鲜花</div></a></td>
<td valign="bottom"><a href="javascript:void(0)" onclick="dig_photo(<?php echo $rows['in_id']; ?>, 'scary');"><div class="digcolumn"><div class="digchart dc3" style="height:<?php echo $rows['in_scary'] == 0 ? 0 : ceil($rows['in_scary'] / $digs * 100 / 2); ?>px;"><em><?php echo $rows['in_scary']; ?></em></div></div><div class="digface"><img src="<?php echo IN_PATH; ?>static/user/images/click/scary.gif" /><br />雷人</div></a></td>
<td valign="bottom"><a href="javascript:void(0)" onclick="dig_photo(<?php echo $rows['in_id']; ?>, 'cool');"><div class="digcolumn"><div class="digchart dc4" style="height:<?php echo $rows['in_cool'] == 0 ? 0 : ceil($rows['in_cool'] / $digs * 100 / 2); ?>px;"><em><?php echo $rows['in_cool']; ?></em></div></div><div class="digface"><img src="<?php echo IN_PATH; ?>static/user/images/click/cool.gif" /><br />酷毙</div></a></td>
<td valign="bottom"><a href="javascript:void(0)" onclick="dig_photo(<?php echo $rows['in_id']; ?>, 'beautiful');"><div class="digcolumn"><div class="digchart dc5" style="height:<?php echo $rows['in_beautiful'] == 0 ? 0 : ceil($rows['in_beautiful'] / $digs * 100 / 2); ?>px;"><em><?php echo $rows['in_beautiful']; ?></em></div></div><div class="digface"><img src="<?php echo IN_PATH; ?>static/user/images/click/beautiful.gif" /><br />漂亮</div></a></td>
</tr></table></div></div>
<div style="padding-top:20px; width:100%; overflow:hidden;">
<h2>评论</h2>
<?php
$Arr = getuserpage("select * from ".tname('comment')." where in_table='photo' and in_tid=".$pid." order by in_addtime desc", 10, 4);
$result = $Arr[1];
echo '<div class="comments_list"><ul>';
while ($com = $db->fetch_array($result)){
$content = preg_replace('/\[em:(\d+)]/is', '<img src="'.IN_PATH.'static/user/images/face/\1.gif" class="face">', $com['in_content']);
?>
<li><div class="avatar48"><a href="<?php echo getlink($com['in_uid']); ?>"><img src="<?php echo getavatar($com['in_uid']); ?>" /></a></div><div class="title"><div class="r_option"><a href="javascript:void(0)" onclick="delcomment(<?php echo $com['in_id']; ?>);">删除</a></div><a href="<?php echo getlink($com['in_uid']); ?>"><?php echo $com['in_uname']; ?></a> <span class="gray"><?php echo datetime($com['in_addtime']); ?></span></div><div class="detail"><?php echo $content; ?></div></li>
<?php } ?>
</ul></div>
<?php echo $Arr[0]; ?>
<form method="get" onsubmit="commentphoto(<?php echo $rows['in_id']; ?>);return false;" class="quickpost" style="padding-bottom: 1em;"><table cellpadding="0" cellspacing="0">
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
<p><a href="<?php echo IN_PATH; ?>user.php">抱歉，您要浏览的照片不存在！</a><script type="text/javascript">setTimeout("location.href='<?php echo IN_PATH; ?>user.php';", 3000);</script></p>
<p class="op"><a href="<?php echo IN_PATH; ?>user.php">页面跳转中...</a></p>
</div></div></div></div>
</div>
<?php } ?>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>发布视频 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<link href="<?php echo IN_PATH; ?>static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/video.js"></script>
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
var in_path = '<?php echo IN_PATH; ?>';
var guide_url = '<?php echo rewrite_mode('user.php/video/passed/'); ?>';
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
<h2 class="title"><img src="<?php echo IN_PATH; ?>static/user/images/icon/video.gif">视频</h2>
<div class="tabs_header">
<ul class="tabs">
<li><a href="<?php echo rewrite_mode('user.php/video/index/'); ?>"><span>已审视频</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/video/passed/'); ?>"><span>待审视频</span></a></li>
<li class="null"><a href="<?php echo rewrite_mode('user.php/video/add/'); ?>">发布视频</a></li>
</ul>
</div>
<form method="get" name="form" onsubmit="addvideo();return false;" class="c_form">
<table cellspacing="0" cellpadding="0" class="formtable"><caption><h2>发布视频</h2></caption>
<?php if(IN_SHAREOPEN == 0){ ?>
<tr><td style="font-weight:bold;color:red;">抱歉，投稿功能暂未开启！</td></tr>
<?php }else{ ?>
<tr><th style="width:10em;">视频名称:</th><td><input type="text" id="in_name" class="t_input" size="30" /></td></tr>
<tr><th style="width:10em;">所属分类:</th><td>
<select id="in_classid">
<option value="0">选择分类</option>
<?php
$result=$db->query("select * from ".tname('video_class')." order by in_id asc");
if($result){
        while ($row = $db->fetch_array($result)){
                echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
        }
}
?>
</select>
</td></tr>
<tr><th style="width:10em;">选择歌手:</th><td>
<select id="in_singerid">
<option value="0">不选择</option>
<?php
$result=$db->query("select * from ".tname('singer')." order by in_addtime desc");
if($result){
        while ($row = $db->fetch_array($result)){
                echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
        }
}
?>
</select>
<input type="button" class="button" value="选择" onclick="pop.up('yes', '选择歌手', in_path+'source/pack/tag/singer_opt.php?so=form.in_singerid', '500px', '400px', '115px');" />
</td></tr>
<tr><th style="width:10em;">视频地址:</th><td>
<input type="text" id="in_play" class="t_input" size="45" />
<input type="button" class="button" value="上传视频" onclick="pop.up('no', '上传视频', in_path+'source/pack/upload/open.php?mode=1&type=video_play&form=form.in_play', '406px', '180px', '225px');" />
</td></tr>
<tr><th style="width:10em;">封面地址:</th><td>
<input type="text" id="in_cover" class="t_input" size="45" />
<input type="button" class="button" value="上传封面" onclick="pop.up('no', '上传封面', in_path+'source/pack/upload/open.php?mode=1&type=video_cover&form=form.in_cover', '406px', '180px', '225px');" />
</td></tr>
<tr><th>视频介绍:</th><td><textarea id="in_intro" cols="40" rows="4" style="width: 282px; height: 118px;"></textarea></td></tr>
<tr><th style="width:10em;"></th><td><input type="submit" value="提交" class="submit" /></td></tr>
<?php } ?>
</table>
</form>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<?php
$singer = explode('/', $_SERVER['PATH_INFO']);
$sid = isset($singer[3]) ? $singer[3] : NULL;
if(IsNum($sid)){
$get = $db->getrow("select * from ".tname('singer')." where in_uid=".$missra_in_userid." and in_passed=1 and in_id=".$sid);
}else{
$get = false;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>编辑歌手 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<link href="<?php echo IN_PATH; ?>static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/singer.js"></script>
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
var in_path = '<?php echo IN_PATH; ?>';
var guide_url = '<?php echo rewrite_mode('user.php/singer/passed/'); ?>';
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
<h2 class="title"><img src="<?php echo IN_PATH; ?>static/user/images/icon/singer.gif">歌手</h2>
<div class="tabs_header">
<ul class="tabs">
<li><a href="<?php echo rewrite_mode('user.php/singer/index/'); ?>"><span>已审歌手</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/singer/passed/'); ?>"><span>待审歌手</span></a></li>
<li class="null"><a href="<?php echo rewrite_mode('user.php/singer/add/'); ?>">创建歌手</a></li>
</ul>
</div>
<?php if($get){ ?>
<form method="get" name="form" onsubmit="editsinger(<?php echo $get['in_id']; ?>);return false;" class="c_form">
<table cellspacing="0" cellpadding="0" class="formtable"><caption><h2>编辑歌手</h2></caption>
<tr><th style="width:10em;">歌手名称:</th><td><input type="text" id="in_name" value="<?php echo $get['in_name']; ?>" class="t_input" size="30" /></td></tr>
<tr><th style="width:10em;">歌手别名:</th><td><input type="text" id="in_nick" value="<?php echo $get['in_nick']; ?>" class="t_input" size="20" /></td></tr>
<tr><th style="width:10em;">所属分类:</th><td>
<select id="in_classid">
<option value="0">选择分类</option>
<?php
$result=$db->query("select * from ".tname('singer_class')." order by in_id asc");
if($result){
        while ($row = $db->fetch_array($result)){
                if($get['in_classid'] == $row['in_id']){
                        echo "<option value=\"".$row['in_id']."\" selected=\"selected\">".$row['in_name']."</option>";
                }else{
                        echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
                }
        }
}
?>
</select>
</td></tr>
<tr><th style="width:10em;">封面地址:</th><td>
<input type="text" id="in_cover" value="<?php echo $get['in_cover']; ?>" class="t_input" size="45" />
<input type="button" class="button" value="上传封面" onclick="pop.up('no', '上传封面', in_path+'source/pack/upload/open.php?mode=1&type=singer_cover&form=form.in_cover', '406px', '180px', '225px');" />
</td></tr>
<tr><th>歌手介绍:</th><td><textarea id="in_intro" cols="40" rows="4" style="width: 282px; height: 118px;"><?php echo $get['in_intro']; ?></textarea></td></tr>
<tr><th style="width:10em;"></th><td><input type="submit" value="保存编辑" class="submit" /></td></tr>
</table>
</form>
<?php }else{ ?>
<div id="content" style="width:100%;"><div class="c_form">歌手不存在或您无权编辑。</div></div>
<?php } ?>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
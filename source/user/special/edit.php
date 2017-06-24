<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<?php
$special = explode('/', $_SERVER['PATH_INFO']);
$aid = isset($special[3]) ? $special[3] : NULL;
if(IsNum($aid)){
$get = $db->getrow("select * from ".tname('special')." where in_uid=".$missra_in_userid." and in_passed=1 and in_id=".$aid);
}else{
$get = false;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>编辑专辑 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<link href="<?php echo IN_PATH; ?>static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/special.js"></script>
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
var in_path = '<?php echo IN_PATH; ?>';
var guide_url = '<?php echo rewrite_mode('user.php/special/passed/'); ?>';
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
<h2 class="title"><img src="<?php echo IN_PATH; ?>static/user/images/icon/special.gif">专辑</h2>
<div class="tabs_header">
<ul class="tabs">
<li><a href="<?php echo rewrite_mode('user.php/special/index/'); ?>"><span>已审专辑</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/special/passed/'); ?>"><span>待审专辑</span></a></li>
<li class="null"><a href="<?php echo rewrite_mode('user.php/special/add/'); ?>">制作专辑</a></li>
</ul>
</div>
<?php if($get){ ?>
<form method="get" name="form" onsubmit="editspecial(<?php echo $get['in_id']; ?>);return false;" class="c_form">
<table cellspacing="0" cellpadding="0" class="formtable"><caption><h2>编辑专辑</h2></caption>
<tr><th style="width:10em;">专辑名称:</th><td><input type="text" id="in_name" value="<?php echo $get['in_name']; ?>" class="t_input" size="30" /></td></tr>
<tr><th style="width:10em;">发行公司:</th><td><input type="text" id="in_firm" value="<?php echo $get['in_firm']; ?>" class="t_input" size="20" /></td></tr>
<tr><th style="width:10em;">所属语言:</th><td>
<select id="in_lang">
<option value="其它">其它</option>
<option value="国语"<?php if($get['in_lang'] == '国语'){echo " selected";} ?>>国语</option>
<option value="粤语"<?php if($get['in_lang'] == '粤语'){echo " selected";} ?>>粤语</option>
<option value="闽语"<?php if($get['in_lang'] == '闽语'){echo " selected";} ?>>闽语</option>
<option value="英语"<?php if($get['in_lang'] == '英语'){echo " selected";} ?>>英语</option>
<option value="日语"<?php if($get['in_lang'] == '日语'){echo " selected";} ?>>日语</option>
<option value="韩语"<?php if($get['in_lang'] == '韩语'){echo " selected";} ?>>韩语</option>
</select>
</td></tr>
<tr><th style="width:10em;">所属分类:</th><td>
<select id="in_classid">
<option value="0">选择分类</option>
<?php
$result=$db->query("select * from ".tname('special_class')." order by in_id asc");
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
<tr><th style="width:10em;">选择歌手:</th><td>
<select id="in_singerid">
<option value="0">不选择</option>
<?php
$result=$db->query("select * from ".tname('singer')." order by in_addtime desc");
if($result){
        while ($row = $db->fetch_array($result)){
                if($get['in_singerid'] == $row['in_id']){
                        echo "<option value=\"".$row['in_id']."\" selected=\"selected\">".$row['in_name']."</option>";
                }else{
                        echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
                }
        }
}
?>
</select>
<input type="button" class="button" value="选择" onclick="pop.up('yes', '选择歌手', in_path+'source/pack/tag/singer_opt.php?so=form.in_singerid', '500px', '400px', '115px');" />
</td></tr>
<tr><th style="width:10em;">封面地址:</th><td>
<input type="text" id="in_cover" value="<?php echo $get['in_cover']; ?>" class="t_input" size="45" />
<input type="button" class="button" value="上传封面" onclick="pop.up('no', '上传封面', in_path+'source/pack/upload/open.php?mode=1&type=special_cover&form=form.in_cover', '406px', '180px', '225px');" />
</td></tr>
<tr><th>专辑介绍:</th><td><textarea id="in_intro" cols="40" rows="4" style="width: 282px; height: 118px;"><?php echo $get['in_intro']; ?></textarea></td></tr>
<tr><th style="width:10em;"></th><td><input type="submit" value="保存编辑" class="submit" /></td></tr>
</table>
</form>
<?php }else{ ?>
<div id="content" style="width:100%;"><div class="c_form">专辑不存在或您无权编辑。</div></div>
<?php } ?>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
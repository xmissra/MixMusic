<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<?php
$Arr = getuserpage("select * from ".tname('photo')." order by in_addtime desc", 20, 3);
$result = $Arr[1];
$index = explode('/', $_SERVER['PATH_INFO']);
if(!empty($index[3])){
header("Content-type: application/xml;charset=".IN_CHARSET);
echo '<?xml version="1.0" encoding="gbk" ?>';
echo '<root><![CDATA[';
while ($row = $db->fetch_array($result)){
echo '<li><a href="'.getlink($row['in_id'], 'photo').'"><img src="'.getphoto($row['in_id']).'" /></a><p>'.$row['in_title'].'</p><div><a href="'.getlink($row['in_uid']).'"><img src="'.getavatar($row['in_uid']).'" /></a><a href="'.getlink($row['in_uid']).'">'.$row['in_uname'].'</a></div></li>';
}
echo ']]></root>';
exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>大家的照片 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript">var Jquery = $;</script>
<style type="text/css">
@import url(<?php echo IN_PATH; ?>static/user/css/style.css);
@import url(<?php echo IN_PATH; ?>static/user/css/album.css);
</style>
</head>
<body>
<?php include 'source/user/people/top.php'; ?>
<div id="main">
<?php include 'source/user/people/left.php'; ?>
<div id="mainarea">
<h2 class="title"><img src="<?php echo IN_PATH; ?>static/user/images/icon/photo.gif">照片</h2>
<div class="tabs_header">
<ul class="tabs">
<li class="active"><a href="<?php echo rewrite_mode('user.php/photo/index/'); ?>"><span>大家的照片</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/photo/friend/'); ?>"><span>好友的照片</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/photo/me/'); ?>"><span>我的相册</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/photo/add/'); ?>"><span>新建相册</span></a></li>
<li class="null"><a href="<?php echo rewrite_mode('user.php/photo/upload/'); ?>">上传照片</a></li>
</ul>
</div>
<?php
$count = $Arr[2];
if($count == 0){
echo '<div class="c_form">没有可浏览的照片。</div>';
}else{
echo '<div><ul class="list">';
while ($row = $db->fetch_array($result)){
echo '<li><a href="'.getlink($row['in_id'], 'photo').'"><img src="'.getphoto($row['in_id']).'" /></a><p>'.$row['in_title'].'</p><div><a href="'.getlink($row['in_uid']).'"><img src="'.getavatar($row['in_uid']).'" /></a><a href="'.getlink($row['in_uid']).'">'.$row['in_uname'].'</a></div></li>';
}
echo '</ul></div>';
}
?>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/jquery.masonry.min.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/jquery.imagesloaded.min.js"></script>
<script type="text/javascript">
var p = <?php echo $Arr[3]; ?>;
Jquery('.list').imagesLoaded(function() {
	Jquery('.list').masonry({
		itemSelector: 'li',
		columnWidth: 204
	});
	var page = 1;
	var istrue = true;
	Jquery(window).scroll(function() {
		var a = document.body.scrollHeight;
		var b = document.documentElement.clientHeight;
		var c = document.documentElement.scrollTop + document.body.scrollTop;
		if ((c + b + 150 >= a) && istrue && p > 1 && page < p) {
			istrue = false;
			page++;
			Jquery.get("<?php echo rewrite_mode('user.php/photo/index/p" + page + "/'); ?>?" + new Date().getTime(),
			function(result) {
				if (result) {
					var el = Jquery(Jquery(result).find("root").text());
					Jquery('.list').append(el);
					Jquery('.list').imagesLoaded(function() {
						Jquery('.list').masonry('appended', el, true);
					});
					istrue = true;
				}
			});
		}
	});
});
</script>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
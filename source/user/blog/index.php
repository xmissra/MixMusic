<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<?php
$Arr = getuserpage("select * from ".tname('blog')." order by in_addtime desc", 20, 3);
$result = $Arr[1];
$index = explode('/', $_SERVER['PATH_INFO']);
if(!empty($index[3])){
header("Content-type: application/xml;charset=".IN_CHARSET);
echo '<?xml version="1.0" encoding="gbk" ?>';
echo '<root><![CDATA[';
while ($row = $db->fetch_array($result)){
$content = getblog($row['in_content'], 1);
echo '<li>';
echo '<div class="title">';
echo '<a href="javascript:void(0)" onclick="blogshare('.$row['in_id'].');" class="a_share">推荐</a>';
echo '<h4><a href="'.getlink($row['in_id'], 'blog').'" >'.$row['in_title'].'</a></h4>';
echo '<div><div class="digb">'.$row['in_hits'].'</div><a href="'.getlink($row['in_uid']).'">'.$row['in_uname'].'</a> <span class="gray">'.datetime($row['in_addtime']).'</span></div>';
echo '</div>';
echo '<div class="feed"><div style="width:100%;overflow:hidden;"><div class="quote">';
echo '<span class="q">'.$content.'</span>';
echo '</div></div></div>';
echo '</li>';
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
<title>大家的日志 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/blog.js"></script>
<script type="text/javascript">
var Jquery = $;
var in_path = '<?php echo IN_PATH; ?>';
</script>
<style type="text/css">
@import url(<?php echo IN_PATH; ?>static/user/css/style.css);
@import url(<?php echo IN_PATH; ?>static/user/css/blog.css);
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
<li class="active"><a href="<?php echo rewrite_mode('user.php/blog/index/'); ?>"><span>大家的日志</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/blog/friend/'); ?>"><span>好友的日志</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/blog/me/'); ?>"><span>我的日志</span></a></li>
<li class="null"><a href="<?php echo rewrite_mode('user.php/blog/add/'); ?>">发表新日志</a></li>
</ul>
</div>
<div id="content" style="width:100%;">
<?php
$count = $Arr[2];
if($count == 0){
echo '<div class="c_form">没有可阅读的日志。</div>';
}else{
echo '<div><ul class="entry">';
while ($row = $db->fetch_array($result)){
$content = getblog($row['in_content'], 1);
echo '<li>';
echo '<div class="title">';
echo '<a href="javascript:void(0)" onclick="blogshare('.$row['in_id'].');" class="a_share">推荐</a>';
echo '<h4><a href="'.getlink($row['in_id'], 'blog').'" >'.$row['in_title'].'</a></h4>';
echo '<div><div class="digb">'.$row['in_hits'].'</div><a href="'.getlink($row['in_uid']).'">'.$row['in_uname'].'</a> <span class="gray">'.datetime($row['in_addtime']).'</span></div>';
echo '</div>';
echo '<div class="feed"><div style="width:100%;overflow:hidden;"><div class="quote">';
echo '<span class="q">'.$content.'</span>';
echo '</div></div></div>';
echo '</li>';
}
echo '</ul></div>';
}
?>
</div>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/jquery.masonry.min.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/jquery.imagesloaded.min.js"></script>
<script type="text/javascript">
var p = <?php echo $Arr[3]; ?>;
Jquery('.entry').imagesLoaded(function() {
	var page = 1;
	var istrue = true;
	Jquery(window).scroll(function() {
		var a = document.body.scrollHeight;
		var b = document.documentElement.clientHeight;
		var c = document.documentElement.scrollTop + document.body.scrollTop;
		if ((c + b + 150 >= a) && istrue && p > 1 && page < p) {
			istrue = false;
			page++;
			Jquery.get("<?php echo rewrite_mode('user.php/blog/index/p" + page + "/'); ?>?" + new Date().getTime(),
			function(result) {
				if (result) {
					var el = Jquery(Jquery(result).find("root").text());
					Jquery('.entry').append(el);
					Jquery('.entry').imagesLoaded(function() {
						Jquery('.entry').masonry('appended', el, true);
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
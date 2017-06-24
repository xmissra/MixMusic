<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>随便看看 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<link href="<?php echo IN_PATH; ?>static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/network.js"></script>
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
function search_user() {
	var keyword = $('keyword').value.replace(/\//g, '');
	keyword = keyword.replace(/\\/g, '');
	keyword = keyword.replace(/\?/g, '');
	keyword = keyword.replace(/\+/g, '');
	if (keyword == '') {
		$('keyword').focus();
		return;
	} else {
		location.href = '<?php echo rewrite_mode('user.php/misc/search/\' + keyword + \'/'); ?>';
	}
}
</script>
<style type="text/css">
@import url(<?php echo IN_PATH; ?>static/user/css/style.css);
@import url(<?php echo IN_PATH; ?>static/user/css/network.css);
</style>
</head>
<body>
<?php include 'source/user/people/top.php'; ?>
<div id="network">
<div id="guestbar" class="nbox">
<div class="nbox_c">
<p id="guest_intro">马上注册，分享你的日志、照片、音乐、视频，一起玩转社区......</p>
<a href="<?php echo rewrite_mode('user.php/people/register/'); ?>" id="regbutton" onmouseover="setintro('register');">马上注册</a>
<p id="guest_app">
<a class="appdoing" style="cursor:pointer" onmouseover="setintro('doing');">说说</a>
<a class="appphotos" style="cursor:pointer" onmouseover="setintro('pic');">照片</a>
<a class="appgames" style="cursor:pointer" onmouseover="setintro('app');">私信</a>
<a class="appgroups" style="cursor:pointer" onmouseover="setintro('mtag');">专辑</a>
</p>
</div>
<div class="nbox_s side_rbox" id="nlogin_box">
<?php if($userlogined){ ?>
<h3 class="ntitle">欢迎您</h3>
<div class="side_rbox_c">
<p style="height:154px;"><a href="<?php echo rewrite_mode('user.php/people/home/'); ?>" style="display:block;margin:55px 0px 0px 47px;width:130px;border:1px solid #486B26;background:#76A14F;line-height:30px;font-size:14px;text-align:center;text-decoration:none;"><strong style="display:block;border-top:1px solid #9EBC84;color:#FFF;padding:0 0.5em;">进入管理中心</strong></a></p>
</div>
<?php }else{ ?>
<h3 class="ntitle">请登录</h3>
<div class="side_rbox_c">
<form method="get" onsubmit="login(2);return false;">
<p><label for="username">用户名</label> <input type="text" id="username" class="t_input" /></p>
<p><label for="password">密　码</label> <input type="password" id="password" class="t_input" /></p>
<p><label for="seccode">验证码</label> <input type="text" id="seccode" class="t_input" style="width:45px;" maxlength="4" />&nbsp;<img id="img_seccode" src="<?php echo rewrite_mode('user.php/people/seccode/'); ?>" align="absmiddle" />&nbsp;<a href="javascript:update_seccode()">更换</a></p>
<p class="submitrow">
<input type="submit" id="loginsubmit" value="登录" class="submit" />
<a style="cursor:pointer" title="QQ登录" onclick="pop.up('no', 'QQ登录', in_path+'source/pack/connect/login.php', '700px', '430px', '100px');"><img src="<?php echo IN_PATH; ?>static/user/images/connect.gif" /></a>
</p>
</form>
</div>
<?php } ?>
</div>
</div>
<div class="nbox">
<div class="nbox_c">
<h2 class="ntitle"><span class="r_option"><a href="<?php echo rewrite_mode('user.php/blog/index/'); ?>">更多日志</a></span>日志 &raquo;</h2>
<ul class="bloglist">
<?php
$start = 0;
$query = $db->query("select * from ".tname('blog')." order by in_addtime desc LIMIT 0,6");
while ($row = $db->fetch_array($query)){
$content = getblog($row['in_content'], 1, 30);
$start = $start + 1;
?>
<?php if($start == 2 || $start == 4 || $start == 6){echo "<li class=\"list_r\">";}else{echo "<li>";} ?>
<h3><a href="<?php echo getlink($row['in_id'], 'blog'); ?>" target="_blank"><?php echo $row['in_title']; ?></a></h3>
<div class="d_avatar avatar48"><a href="<?php echo getlink($row['in_uid']); ?>"><img src="<?php echo getavatar($row['in_uid']); ?>"></a></div>
<p class="message"><?php echo $content; ?></p>
<p class="nhot"><?php echo $row['in_hits']; ?> 次阅读</p>
<p class="gray"><a href="<?php echo getlink($row['in_uid']); ?>"><?php echo $row['in_uname']; ?></a> 发表于 <?php echo datetime($row['in_addtime']); ?></p>
</li>
<?php } ?>
</ul>
</div>
<div class="nbox_s side_rbox side_rbox_w">
<h2 class="ntitle"><span class="r_option"><a href="<?php echo rewrite_mode('user.php/feed/index/'); ?>">更多说说</a></span>说说 &raquo;</h2>
<div class="side_rbox_c">
<ul class="side_rbox_c doinglist" id="scrollbody" style="height:319px;overflow:hidden">
<?php
$query = $db->query("select * from ".tname('feed')." where in_type=0 order by in_addtime desc LIMIT 0,10");
while ($row = $db->fetch_array($query)){
$content = preg_replace('/\[em:(\d+)]/is', '<img src="'.IN_PATH.'static/user/images/face/\1.gif" class="face">', $row['in_content']);
?>
<li>
<p>
<span class="gray r_option dot" style="margin:0;background-position-y:0;"><?php echo datetime($row['in_addtime']); ?></span>
<a href="<?php echo getlink($row['in_uid']); ?>" class="s_avatar"><img src="<?php echo getavatar($row['in_uid']); ?>"></a>
<a href="<?php echo getlink($row['in_uid']); ?>"><?php echo $row['in_uname']; ?></a>
</p>
<p class="message"><?php echo $content; ?></p>
</li>
<?php } ?>
</ul>
</div>
</div>
<script type="text/javascript">startMarquee(300, 60, 0, 'scrollbody');</script>
</div>
<div class="nbox" id="photolist">
<h2 class="ntitle"><a href="<?php echo rewrite_mode('user.php/photo/index/'); ?>" class="r_option">更多照片</a>相册 &raquo;</h2>
<div id="p_control">
<a style="cursor:pointer" id="spics_last">上一页</a>
<a style="cursor:pointer" id="spics_next">下一页</a>
<ul id="p_control_pages">
<li>第一页</li>
<li>第二页</li>
<li>第三页</li>
<li>第四页</li>
</ul>
</div>
<div id="spics_wrap">
<ul id="spics" style="margin-left: 0;">
<?php
$start = 0;
$query = $db->query("select * from ".tname('photo_group')." order by in_id desc LIMIT 0,28");
while ($row = $db->fetch_array($query)){
$nums = $db->num_rows($db->query("select count(*) from ".tname('photo')." where in_gid=".$row['in_id']));
$start = $start + 1;
?>
<li class="spic_<?php echo ($start - 1); ?>">
<div class="spic_img"><a href="<?php echo getlink($row['in_id'], 'photogroup'); ?>" target="_blank"><strong><?php echo $nums; ?></strong><img src="<?php echo getphoto($row['in_pid']); ?>" /></a></div>
<p><a href="<?php echo getlink($row['in_uid']); ?>"><?php echo $row['in_uname']; ?></a></p>
<p><?php echo $row['in_title']; ?></p>
</li>
<?php } ?>
</ul>
</div>
</div>
<script type="text/javascript">scrollShowNav($('spics'), 903, 7, 43);</script>
<div id="searchbar" class="nbox s_clear">
<div class="floatleft">
<form method="get" onsubmit="search_user();return false;">
<input type="text" id="keyword" size="15" class="t_input" style="padding:5px;">
<input type="submit" value="找人" class="submit"> &nbsp;
查找：<a href="<?php echo rewrite_mode('user.php/misc/rank/man/'); ?>">帅哥</a><span class="pipe">|</span>
<a href="<?php echo rewrite_mode('user.php/misc/rank/woman/'); ?>">美女</a><span class="pipe">|</span>
<a href="<?php echo rewrite_mode('user.php/misc/rank/'); ?>">排行榜</a><span class="pipe">|</span>
<a href="<?php echo rewrite_mode('user.php/misc/search/'); ?>">高级搜索</a>
</form>
</div>
</div>
<div id="showuser" class="nbox">
<div id="user_recomm"><h2>站长推荐</h2>
<?php
$query = $db->query("select * from ".tname('user')." order by in_points desc LIMIT 0,1");
while ($row = $db->fetch_array($query)){
$friends = $db->num_rows($db->query("select count(*) from ".tname('friend')." where in_uid=".$row['in_userid']));
?>
<div class="s_avatar"><a href="<?php echo getlink($row['in_userid']); ?>" target="_blank"><img src="<?php echo getavatar($row['in_userid'], 'middle'); ?>"></a></div>
<div class="s_cnts">
<h3><a href="<?php echo getlink($row['in_userid']); ?>" target="_blank"><?php echo $row['in_username']; ?></a></h3>
<p>金币: <?php echo $row['in_points']; ?></p>
<p>经验: <?php echo $row['in_rank']; ?></p>
<hr />
<p>人气: <?php echo $row['in_hits']; ?></p>
<p>好友: <?php echo $friends; ?></p>
</div>
<?php } ?>
</div>
<div id="user_wall" onmouseout="javascript:$('usertip_box').style.visibility = 'hidden';">
<div id="user_pay" class="s_clear">
<h2><a href="<?php echo rewrite_mode('user.php/misc/rank/gold/'); ?>">竞价排名</a></h2>
<ul>
<?php
$query = $db->query("select * from ".tname('user')." order by in_points desc LIMIT 0,23");
while ($row = $db->fetch_array($query)){
?>
<li><a href="<?php echo getlink($row['in_userid']); ?>" target="_blank" rel="<?php echo $row['in_username']; ?>" rev="<?php echo $row['in_introduce']; ?>" onmouseover="getUserTip(this)"><img src="<?php echo getavatar($row['in_userid']); ?>" width="48" height="48"></a></li>
<?php } ?>
</ul>
<p><a href="<?php echo rewrite_mode('user.php/profile/pay/'); ?>">我要上榜</a></p>
</div>
<div class="s_clear">
<h2><a href="<?php echo rewrite_mode('user.php/misc/rank/online/'); ?>">在线会员</a></h2>
<ul>
<?php
$id = '';
$result = $db->query("select in_uid from ".tname('session')." where in_invisible=0");
while ($rows = $db->fetch_array($result)) {
        $id .= $rows['in_uid'].',';
}
$id = str_replace(',0', '', $id.'0');
$query = $db->query("select * from ".tname('user')." where in_userid in ($id) order by in_logintime desc LIMIT 0,12");
while ($row = $db->fetch_array($query)){
?>
<li><a href="<?php echo getlink($row['in_userid']); ?>" target="_blank" rel="<?php echo $row['in_username']; ?>" rev="<?php echo $row['in_introduce']; ?>" class="uonline" onmouseover="getUserTip(this)"><img src="<?php echo getavatar($row['in_userid']); ?>" width="48" height="48"></a></li>
<?php } ?>
</ul>
</div>
</div>
</div>
<div id="usertip_box"><div></div></div>
<div class="nbox">
<div class="nbox_c">
<h2 class="ntitle">专辑 &raquo;</h2>
<ul class="elist">
<?php
$query = $db->query("select * from ".tname('special')." where in_passed=0 order by in_addtime desc LIMIT 0,4");
while ($row = $db->fetch_array($query)){
?>
<li>
<h3><a href="<?php echo getlink($row['in_id'], 'special'); ?>" target="_blank"><?php echo $row['in_name']; ?></a></h3>
<p class="eimage"><a href="<?php echo getlink($row['in_id'], 'special'); ?>" target="_blank"><img src="<?php echo geturl($row['in_cover'], 'cover'); ?>" /></a></p>
<p><span class="gray">人气:</span> <?php echo $row['in_hits']; ?></p>
<p><span class="gray">更新:</span> <?php echo datetime($row['in_addtime']); ?></p>
<p><span class="gray">分类:</span> <a href="<?php echo getlink($row['in_classid'], 'specialclass'); ?>" target="_blank"><?php echo getfield('special_class', 'in_name', 'in_id', $row['in_classid']); ?></a></p>
<p class="egz"><?php echo $row['in_lang']; ?><span class="pipe">|</span><?php echo $row['in_firm']; ?></p>
</li>
<?php } ?>
</ul>
</div>
<div id="nshare" class="nbox_s side_rbox side_rbox_w">
<h2 class="ntitle">动态 &raquo;</h2>
<div class="side_rbox_c">
<ul>
<?php
$query = $db->query("select * from ".tname('feed')." where in_type=1 order by in_addtime desc LIMIT 0,11");
while ($row = $db->fetch_array($query)){
?>
<li><a href="<?php echo getlink($row['in_uid']); ?>"><?php echo $row['in_uname']; ?></a> <em style="color:#666"><?php echo $row['in_title']; ?></em></li>
<?php } ?>
</ul>
</div>
</div>
</div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
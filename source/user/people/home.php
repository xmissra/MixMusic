<?php
if(!defined('IN_ROOT')){exit('Access denied');}
global $db,$userlogined,$missra_in_userid,$missra_in_username,$missra_in_ismail,$missra_in_isstar,$missra_in_hits,$missra_in_points,$missra_in_rank,$missra_in_grade,$missra_in_sign,$missra_in_signtime,$missra_in_ucid,$missra_in_qqopen,$missra_in_avatar;
if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();}
if($missra_in_sign > 0 && DateDiff(date('Y-m-d', strtotime($missra_in_signtime)), date('Y-m-d')) !== 0 && DateDiff(date('Y-m-d', strtotime($missra_in_signtime)), date('Y-m-d', strtotime('-1 days'))) !== 0 || $missra_in_sign > 0 && DateDiff(date('Y-m-d', strtotime($missra_in_signtime)), date('Y-m-d')) !== 0 && intval(date('d')) == 1){
        $missra_in_sign = 0;
        $db->query("update ".tname('user')." set in_sign=0 where in_userid=".$missra_in_userid);
}
$invisible = $db->getone("select in_invisible from ".tname('session')." where in_uid=".$missra_in_userid);
$last_doing = '';
$query = $db->query("select * from ".tname('feed')." where in_uid=".$missra_in_userid." and in_type=0 order by in_addtime desc LIMIT 0,1");
while ($row = $db->fetch_array($query)){
$last_doing = preg_replace('/\[em:(\d+)]/is', '<img src="'.IN_PATH.'static/user/images/face/\1.gif" class="face">', $row['in_content']);
}
$id = '';
$query = $db->query("select in_uids from ".tname('friend')." where in_uid=".$missra_in_userid);
while ($rows = $db->fetch_array($query)) {
$id .= $rows['in_uids'].',';
}
$id = str_replace(',0', '', $id.'0');
$home = explode('/', $_SERVER['PATH_INFO']);
$we = isset($home[3]) ? $home[3] : NULL;
if($we == 'friend'){
        $Arr = getuserpage("select * from ".tname('feed')." where in_uid in ($id) order by in_addtime desc", 20, 4);
}elseif($we == 'me'){
        $Arr = getuserpage("select * from ".tname('feed')." where in_uid=".$missra_in_userid." order by in_addtime desc", 20, 4);
}else{
        $Arr = getuserpage("select * from ".tname('feed')." order by in_addtime desc", 20, 3);
}
$result = $Arr[1];
$count = $Arr[2];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>首页 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<link href="<?php echo IN_PATH; ?>static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/doing.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/face.js"></script>
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
var in_path = '<?php echo IN_PATH; ?>';
var in_points = '<?php echo ($missra_in_sign + 1) * IN_SIGNDAYPOINTS; ?>';
var in_rank = '<?php echo ($missra_in_sign + 1) * IN_SIGNDAYRANK; ?>';
var guide_url = '<?php echo rewrite_mode('user.php/people/home/me/'); ?>';
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
@import url(<?php echo IN_PATH; ?>static/user/css/sign.css);
</style>
</head>
<body>
<?php include 'source/user/people/top.php'; ?>
<div id="main">
<?php include 'source/user/people/left.php'; ?>
<div id="mainarea">
<div id="content">
<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
<td valign="top" width="150">
<div class="ar_r_t"><div class="ar_l_t"><div class="ar_r_b"><div class="ar_l_b"><img src="<?php echo getavatar($missra_in_userid, 'middle'); ?>" width="120" height="120"></div></div></div></div>
<ul class="u_setting">
<li class="dropmenu"><a href="<?php echo rewrite_mode('user.php/profile/avatar/'); ?>">设置新头像 <img src="<?php echo IN_PATH; ?>static/user/images/more.gif" align="absmiddle"></a></li>
</ul>
</td>
<td valign="top">
<h3 class="index_name">
<?php if($invisible == 0){ ?>
<div class="r_option">当前在线 <img src="<?php echo IN_PATH; ?>static/user/images/invisible.gif" class="magicicon"><a href="javascript:void(0)" onclick="invisible(1);" class="gray">我要隐身</a></div>
<?php }else{ ?>
<div class="r_option">当前隐身 <img src="<?php echo IN_PATH; ?>static/user/images/invisible.gif" class="magicicon"><a href="javascript:void(0)" onclick="invisible(0);" class="gray">我要在线</a></div>
<?php } ?>
<a href="<?php echo getlink($missra_in_userid); ?>"><?php echo $missra_in_username; ?></a>
<?php if($missra_in_grade == 1){ ?>
<a href="<?php echo rewrite_mode('user.php/profile/credit/'); ?>" title="您已是绿钻会员，点击查看"><img src="<?php echo IN_PATH; ?>static/user/images/vip/vip.gif" align="absmiddle" /></a>
<?php }else{ ?>
<a href="<?php echo rewrite_mode('user.php/profile/vip/'); ?>" title="您还未开通绿钻，点击开通"><img src="<?php echo IN_PATH; ?>static/user/images/vip/novip.png" align="absmiddle" /></a>
<?php } ?>
<?php if($missra_in_isstar == 1){ ?>
<a href="<?php echo rewrite_mode('user.php/profile/verify/'); ?>" title="明星认证"><img src="<?php echo IN_PATH; ?>static/user/images/star.png" align="absmiddle" /></a>
<?php } ?>
<?php echo getlevel($missra_in_rank, 1); ?>
</h3>
<div class="index_note">已有 <?php echo $missra_in_hits; ?> 个人气, <?php echo $missra_in_points; ?> 个金币, <?php echo $missra_in_rank; ?> 个经验</div>
<div id="mood_mystatus"><?php echo $last_doing; ?></div>
<div id="mood_form">
<form method="get" onsubmit="doing();return false;">
<div id="mood_statusinput" class="statusinput">
<textarea id="message" onclick="showFace(this.id, 'message');return false;" ></textarea>
</div>
<div class="statussubmit">
<input type="submit" value="更新" class="submit" />
</div>
</form>
</div>
</td>
</tr></table>
<?php if(IN_UCOPEN == 0 && empty($missra_in_avatar) && empty($missra_in_qqopen) || $missra_in_ucid == 0 && empty($missra_in_avatar) && empty($missra_in_qqopen)){ ?>
<div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">
<div class="task_notice">
<div class="task_notice_body">
<div class="notice">您还没有上传头像，完成头像任务可以获得金币，赶快来参加吧</div>
<img src="<?php echo IN_PATH; ?>static/user/images/avatar.gif" class="icon" />
<h3><a href="<?php echo rewrite_mode('user.php/profile/avatar/'); ?>">更新一下自己的头像</a></h3>
<p>可获得 <span class="num"><?php echo IN_AVATARPOINTS; ?></span> 金币</p>
</div>
</div>
</div></div></div></div><br />
<?php }elseif($missra_in_ismail == 0){ ?>
<div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">
<div class="task_notice">
<div class="task_notice_body">
<div class="notice">您还没有激活邮箱，完成邮箱任务可以获得金币，赶快来参加吧</div>
<img src="<?php echo IN_PATH; ?>static/user/images/mail.gif" class="icon" />
<h3><a href="<?php echo rewrite_mode('user.php/profile/mail/'); ?>">验证激活自己的邮箱</a></h3>
<p>可获得 <span class="num"><?php echo IN_MAILPOINTS; ?></span> 金币</p>
</div>
</div>
</div></div></div></div><br />
<?php } ?>
<div class="tabs_header" style="padding-top:10px;">
<ul class="tabs">
<li<?php if($we !== 'friend' && $we !== 'me'){echo ' class="active"';} ?>><a href="<?php echo rewrite_mode('user.php/people/home/'); ?>"><span>全站动态</span></a></li>
<li<?php if($we == 'friend'){echo ' class="active"';} ?>><a href="<?php echo rewrite_mode('user.php/people/home/friend/'); ?>"><span>好友动态</span></a></li>
<li<?php if($we == 'me'){echo ' class="active"';} ?>><a href="<?php echo rewrite_mode('user.php/people/home/me/'); ?>"><span>我的动态</span></a></li>
</ul>
</div>
<div class="feed"><div class="enter-content">
<?php if($count == 0){ ?>
<ul><li>没有相关动态</li></ul>
<?php }else{ ?>
<ul>
<?php
while ($row = $db->fetch_array($result)){
if($row['in_type'] == 0){
$content = preg_replace('/\[em:(\d+)]/is', '<img src="'.IN_PATH.'static/user/images/face/\1.gif" class="face">', $row['in_content']);
$del = $row['in_uid'] == $missra_in_userid ? '&nbsp;<a href="javascript:void(0)" onclick="deldoing('.$row['in_id'].');" class="re gray">删除</a>' : '';
?>
<li class="s_clear">
<div style="width:100%;overflow:hidden;" >
<img src="<?php echo IN_PATH; ?>static/user/images/icon/feed.gif" />&nbsp;<a target="_blank" href="<?php echo getlink($row['in_uid']); ?>"><?php echo $row['in_uname']; ?></a>&nbsp;<?php echo $row['in_title']; ?>&nbsp;<span class="gray"><?php echo datetime($row['in_addtime']); ?></span><?php echo $del; ?>&nbsp;(<a href="javascript:void(0)" onclick="docomment_form(<?php echo $row['in_id']; ?>);">回复</a>)<div class="feed_content"><div class="quote"><span class="q"><?php echo $content; ?></span></div></div>
</div>
<div id="doreply<?php echo $row['in_id']; ?>"><script type="text/javascript">getreply(<?php echo $row['in_id']; ?>);</script></div>
</li>
<?php }elseif($row['in_icon'] == 'space'){ ?>
<li class="s_clear">
<div style="width:100%;overflow:hidden;" >
<img src="<?php echo IN_PATH; ?>static/user/images/icon/space.gif" />&nbsp;<a target="_blank" href="<?php echo getlink($row['in_uid']); ?>"><?php echo $row['in_uname']; ?></a>&nbsp;<?php echo $row['in_title']; ?>&nbsp;<span class="gray"><?php echo datetime($row['in_addtime']); ?></span>
<div class="feed_content">
<a href="<?php echo getlink($row['in_tid']); ?>" target="_blank"><img src="<?php echo getavatar($row['in_tid'], 'middle'); ?>" class="summaryimg"></a>
<div class="detail"><b><a target="_blank" href="<?php echo getlink($row['in_tid']); ?>"><?php echo getfield('user', 'in_username', 'in_userid', $row['in_tid']); ?></a></b></div>
<div class="quote"><span class="q"><?php echo $row['in_content']; ?></span></div>
</div>
</div>
</li>
<?php
}elseif($row['in_icon'] == 'share'){
$share = explode('[/flash]', $row['in_content']);
$intro = isset($share[1]) ? $share[1] : NULL;
$swf = isset($share[0]) ? str_replace('[flash]', '', $share[0]) : NULL;
$play = '<embed src="'.$swf.'" width="270" height="210" allowfullscreen="true" allowscriptaccess="always" wmode="transparent" type="application/x-shockwave-flash"></embed>';
?>
<li class="s_clear">
<div style="width:100%;overflow:hidden;" >
<img src="<?php echo IN_PATH; ?>static/user/images/icon/share.gif" />&nbsp;<a target="_blank" href="<?php echo getlink($row['in_uid']); ?>"><?php echo $row['in_uname']; ?></a>&nbsp;<?php echo $row['in_title']; ?>&nbsp;<span class="gray"><?php echo datetime($row['in_addtime']); ?></span>
<div class="feed_content">
<div class="detail"><?php echo $play; ?></div>
<div class="quote"><span class="q"><?php echo $intro; ?></span></div>
</div>
</div>
</li>
<?php }elseif($row['in_icon'] == 'blog'){ ?>
<li class="s_clear">
<div style="width:100%;overflow:hidden;" >
<img src="<?php echo IN_PATH; ?>static/user/images/icon/blog.gif" />&nbsp;<a target="_blank" href="<?php echo getlink($row['in_uid']); ?>"><?php echo $row['in_uname']; ?></a>&nbsp;<?php echo $row['in_title']; ?>&nbsp;<span class="gray"><?php echo datetime($row['in_addtime']); ?></span>
<div class="feed_content"><div class="detail"><b><a target="_blank" href="<?php echo getlink($row['in_tid'], 'blog'); ?>"><?php echo getfield('blog', 'in_title', 'in_id', $row['in_tid']); ?></a></b><br /><?php echo $row['in_content']; ?></div></div>
</div>
</li>
<?php }elseif($row['in_icon'] == 'photo'){ ?>
<li class="s_clear">
<div style="width:100%;overflow:hidden;" >
<img src="<?php echo IN_PATH; ?>static/user/images/icon/photo.gif" />&nbsp;<a target="_blank" href="<?php echo getlink($row['in_uid']); ?>"><?php echo $row['in_uname']; ?></a>&nbsp;<?php echo $row['in_title']; ?>&nbsp;<span class="gray"><?php echo datetime($row['in_addtime']); ?></span>
<div class="feed_content">
<a href="<?php echo getlink($row['in_tid'], 'photogroup'); ?>" target="_blank"><img src="<?php echo getphoto(getfield('photo_group', 'in_pid', 'in_id', $row['in_tid'])); ?>" class="summaryimg"></a>
<div class="detail"><b><a target="_blank" href="<?php echo getlink($row['in_tid'], 'photogroup'); ?>"><?php echo getfield('photo_group', 'in_title', 'in_id', $row['in_tid']); ?></a></b><br /><?php echo $row['in_content']; ?></div>
</div>
</div>
</li>
<?php }else{ ?>
<li class="s_clear">
<div style="width:100%;overflow:hidden;" >
<img src="<?php echo IN_PATH; ?>static/user/images/icon/<?php echo $row['in_icon']; ?>.gif" />&nbsp;<a target="_blank" href="<?php echo getlink($row['in_uid']); ?>"><?php echo $row['in_uname']; ?></a>&nbsp;<?php echo $row['in_title']; ?>&nbsp;<span class="gray"><?php echo datetime($row['in_addtime']); ?></span>
<div class="feed_content">
<a href="<?php echo getlink($row['in_tid'], $row['in_icon']); ?>" target="_blank"><img src="<?php echo geturl(getfield($row['in_icon'], 'in_cover', 'in_id', $row['in_tid']), 'cover'); ?>" class="summaryimg"></a>
<div class="detail"><b><a target="_blank" href="<?php echo getlink($row['in_tid'], $row['in_icon']); ?>"><?php echo getfield($row['in_icon'], 'in_name', 'in_id', $row['in_tid']); ?></a></b></div>
<div class="quote"><span class="q"><?php echo $row['in_content']; ?></span></div>
</div>
</div>
</li>
<?php } ?>
<?php } ?>
</ul>
<?php echo $Arr[0]; ?>
<?php } ?>
</div></div>
</div>
<div id="sidebar">
<div class="sidebox">
<div class="user_sign">
<span class="date"><?php echo date('m').'.'.date('d'); ?></span>
<span class="week"><script type="text/javascript">document.write(get_week());</script></span>
<span class="time_tip">DAY</span>
<strong class="time" id="in_sign"><?php echo $missra_in_sign; ?></strong>
<button class="user_sign_but" onclick="clock_sign();"></button>
</div>
<div class="calendarbox">
<ul><?php echo getsign($missra_in_sign, $missra_in_signtime); ?></ul>
</div>
</div>
<div class="sidebox">
<h2 class="title"><p class="r_option"><a href="<?php echo rewrite_mode('user.php/misc/rank/join/'); ?>">排行</a></p>热烈欢迎新成员</h2>
<ul class="avatar_list">
<?php
$query = $db->query("select * from ".tname('user')." order by in_regdate desc LIMIT 0,6");
while ($row = $db->fetch_array($query)){
$invisible = $db->getone("select in_invisible from ".tname('session')." where in_uid=".$row['in_userid']);
$online = is_numeric($invisible) && $invisible == 0 ? '<p class="online_icon_p">' : '<p>';
?>
<li>
<div class="avatar48"><a href="<?php echo getlink($row['in_userid']); ?>"><img src="<?php echo getavatar($row['in_userid']); ?>" /></a></div>
<?php echo $online; ?><a href="<?php echo getlink($row['in_userid']); ?>" title="<?php echo $row['in_username']; ?>"><?php echo $row['in_username']; ?></a></p>
<p class="gray"><?php echo datetime($row['in_regdate']); ?></p>
</li>
<?php } ?>
</ul>
</div>
<div class="sidebox">
<h2 class="title"><p class="r_option"><a href="<?php echo rewrite_mode('user.php/friend/visitor/'); ?>">全部</a></p>最近来访</h2>
<ul class="avatar_list">
<?php
$query = $db->query("select * from ".tname('footprint')." where in_uids=".$missra_in_userid." order by in_addtime desc LIMIT 0,6");
while ($row = $db->fetch_array($query)){
$invisible = $db->getone("select in_invisible from ".tname('session')." where in_uid=".$row['in_uid']);
$online = is_numeric($invisible) && $invisible == 0 ? '<p class="online_icon_p">' : '<p>';
?>
<li>
<div class="avatar48"><a href="<?php echo getlink($row['in_uid']); ?>"><img src="<?php echo getavatar($row['in_uid']); ?>" /></a></div>
<?php echo $online; ?><a href="<?php echo getlink($row['in_uid']); ?>" title="<?php echo $row['in_uname']; ?>"><?php echo $row['in_uname']; ?></a></p>
<p class="gray"><?php echo datetime($row['in_addtime']); ?></p>
</li>
<?php } ?>
</ul>
</div>
<div class="sidebox">
<h2 class="title"><p class="r_option"><a href="<?php echo rewrite_mode('user.php/friend/index/'); ?>">全部</a></p>最新好友</h2>
<ul class="avatar_list">
<?php
$query = $db->query("select * from ".tname('friend')." where in_uid=".$missra_in_userid." order by in_addtime desc LIMIT 0,6");
while ($row = $db->fetch_array($query)){
$invisible = $db->getone("select in_invisible from ".tname('session')." where in_uid=".$row['in_uids']);
$online = is_numeric($invisible) && $invisible == 0 ? '<p class="online_icon_p">' : '<p>';
?>
<li>
<div class="avatar48"><a href="<?php echo getlink($row['in_uids']); ?>"><img src="<?php echo getavatar($row['in_uids']); ?>" /></a></div>
<?php echo $online; ?><a href="<?php echo getlink($row['in_uids']); ?>" title="<?php echo $row['in_unames']; ?>"><?php echo $row['in_unames']; ?></a></p>
<p class="gray"><?php echo datetime($row['in_addtime']); ?></p>
</li>
<?php } ?>
</ul>
</div>
<div class="searchfriend">
<div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">
<h3>搜索用户</h3>
<form method="get" onsubmit="search_user();return false;" style="padding:10px 0 5px 0;">
<input id="keyword" size="20" class="t_input" type="text">
<input value="找人" class="submit" type="submit">
</form>
<p>
<a href="<?php echo rewrite_mode('user.php/misc/search/'); ?>">高级搜索</a><span class="pipe">|</span>
<a href="<?php echo rewrite_mode('user.php/misc/rank/'); ?>">排行榜</a>
</p>
</div></div></div></div>
</div>
<div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">
<form method="get" onsubmit="share_flash();return false;">
<table cellspacing="2" cellpadding="2" width="100%">
<tr><td><strong>分享Flash:</strong></td></tr>
<tr><td><input type="text" class="t_input" id="share_play" onfocus="javascript:if('http://'==this.value)this.value=''" onblur="javascript:if(''==this.value)this.value='http://'" style="width:98%;" value="http://" /></td></tr>
<tr><td><strong>描述:</strong></td></tr>
<tr><td><textarea id="share_intro" style="width:98%;" rows="3"></textarea></td></tr>
<tr><td><input type="submit" value="分享" class="submit" /></td></tr>
</table>
</form>
</div></div></div></div>
</div>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
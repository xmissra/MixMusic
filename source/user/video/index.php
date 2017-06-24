<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<?php
$index = explode('/', $_SERVER['PATH_INFO']);
$cid = isset($index[3]) ? $index[3] : NULL;
if(IsNum($cid)){
$get = $db->getone("select in_id from ".tname('video_class')." where in_id=".$cid);
$Arr = getuserpage("select * from ".tname('video')." where in_uid=".$missra_in_userid." and in_passed=0 and in_classid=".$cid." order by in_addtime desc", 10, 4);
}else{
$get = true;
$Arr = getuserpage("select * from ".tname('video')." where in_uid=".$missra_in_userid." and in_passed=0 order by in_addtime desc", 10, 3);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>已审视频 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<style type="text/css">
@import url(<?php echo IN_PATH; ?>static/user/css/style.css);
@import url(<?php echo IN_PATH; ?>static/user/css/event.css);
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
<li class="active"><a href="<?php echo rewrite_mode('user.php/video/index/'); ?>"><span>已审视频</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/video/passed/'); ?>"><span>待审视频</span></a></li>
<li class="null"><a href="<?php echo rewrite_mode('user.php/video/add/'); ?>">发布视频</a></li>
</ul>
</div>
<div id="content" style="width:640px;">
<?php if($get){ ?>
<div class="c_mgs"><div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">以下是您发布且已通过审核的视频列表</div></div></div></div></div>
<?php
$result = $Arr[1];
$count = $Arr[2];
if($count == 0){
?>
<div class="c_form">没有相关已审视频。</div>
<?php }else{ ?>
<div class="event_list"><ol>
<?php
while ($row = $db->fetch_array($result)){
?>
<li>
<div class="event_icon"><a href="<?php echo getlink($row['in_id'], 'video'); ?>" target="_blank"><img class="poster_pre" src="<?php echo geturl($row['in_cover'], 'cover'); ?>"></a></div>
<div class="event_content">
<h4 class="event_title"><a href="<?php echo getlink($row['in_id'], 'video'); ?>" target="_blank"><?php echo $row['in_name']; ?></a></h4>
<ul>
<li><span class="gray">人气:</span> <?php echo $row['in_hits']; ?></li>
<li><span class="gray">更新:</span> <?php echo $row['in_addtime']; ?></li>
<li><span class="gray">分类:</span> <a href="<?php echo getlink($row['in_classid'], 'videoclass'); ?>" target="_blank"><?php echo getfield('video_class', 'in_name', 'in_id', $row['in_classid']); ?></a></li>
</ul>
</div>
</li>
<?php } ?>
</ol>
<?php echo $Arr[0]; ?>
</div>
<?php } ?>
<?php }else{ ?>
<div class="c_form">分类不存在或已被删除。</div>
<?php } ?>
</div>
<div id="sidebar" style="width:150px;">
<div class="cat">
<h3>视频分类</h3>
<ul class="post_list line_list">
<?php
if(!IsNum($cid)){
        echo "<li class=\"current\"><a href=\"".rewrite_mode('user.php/video/index/')."\">不限分类</a></li>";
}else{
        echo "<li><a href=\"".rewrite_mode('user.php/video/index/')."\">不限分类</a></li>";
}
$res=$db->query("select * from ".tname('video_class')." order by in_id asc");
if($res){
        while ($rows = $db->fetch_array($res)){
                if($cid == $rows['in_id']){
                        echo "<li class=\"current\"><a href=\"".rewrite_mode('user.php/video/index/'.$rows['in_id'].'/')."\">".$rows['in_name']."</a></li>";
                }else{
                        echo "<li><a href=\"".rewrite_mode('user.php/video/index/'.$rows['in_id'].'/')."\">".$rows['in_name']."</a></li>";
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
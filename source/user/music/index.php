<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<?php
$index = explode('/', $_SERVER['PATH_INFO']);
$cid = isset($index[3]) ? $index[3] : NULL;
if(IsNum($cid)){
$get = $db->getone("select in_id from ".tname('class')." where in_id=".$cid);
$Arr = getuserpage("select * from ".tname('music')." where in_uid=".$missra_in_userid." and in_passed=0 and in_classid=".$cid." order by in_addtime desc", 20, 4);
}else{
$get = true;
$Arr = getuserpage("select * from ".tname('music')." where in_uid=".$missra_in_userid." and in_passed=0 order by in_addtime desc", 20, 3);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>已审音乐 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<style type="text/css">
@import url(<?php echo IN_PATH; ?>static/user/css/style.css);
</style>
</head>
<body>
<?php include 'source/user/people/top.php'; ?>
<div id="main">
<?php include 'source/user/people/left.php'; ?>
<div id="mainarea">
<h2 class="title"><img src="<?php echo IN_PATH; ?>static/user/images/icon/music.gif">音乐</h2>
<div class="tabs_header">
<ul class="tabs">
<li class="active"><a href="<?php echo rewrite_mode('user.php/music/index/'); ?>"><span>已审音乐</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/music/passed/'); ?>"><span>待审音乐</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/music/song/'); ?>"><span>我的歌单</span></a></li>
<li class="null"><a href="<?php echo rewrite_mode('user.php/music/add/'); ?>">上传音乐</a></li>
</ul>
</div>
<div id="content" style="width:640px;">
<?php if($get){ ?>
<div class="c_mgs"><div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">以下是您上传且已通过审核的音乐列表</div></div></div></div></div>
<?php
$result = $Arr[1];
$count = $Arr[2];
if($count == 0){
?>
<div class="c_form">没有相关已审音乐。</div>
<?php }else{ ?>
<div class="space_list">
<table cellspacing="0" cellpadding="0" width="100%">
<thead><tr>
<td>编号</td>
<td align="center">名称</td>
<td align="center">更新</td>
</tr></thead>
<?php
while ($row = $db->fetch_array($result)){
?>
<tr>
<td><?php echo $row['in_id']; ?></td>
<td align="center"><a href="<?php echo getlink($row['in_id'], 'music'); ?>" target="_blank"><?php echo $row['in_name']; ?></a></td>
<td align="center"><?php echo $row['in_addtime']; ?></td>
</tr>
<?php } ?>
</table>
<?php echo $Arr[0]; ?>
</div>
<?php } ?>
<?php }else{ ?>
<div class="c_form">分类不存在或已被删除。</div>
<?php } ?>
</div>
<div id="sidebar" style="width:150px;">
<div class="cat">
<h3>音乐分类</h3>
<ul class="post_list line_list">
<?php
if(!IsNum($cid)){
        echo "<li class=\"current\"><a href=\"".rewrite_mode('user.php/music/index/')."\">不限分类</a></li>";
}else{
        echo "<li><a href=\"".rewrite_mode('user.php/music/index/')."\">不限分类</a></li>";
}
$res=$db->query("select * from ".tname('class')." order by in_id asc");
if($res){
        while ($rows = $db->fetch_array($res)){
                if($cid == $rows['in_id']){
                        echo "<li class=\"current\"><a href=\"".rewrite_mode('user.php/music/index/'.$rows['in_id'].'/')."\">".$rows['in_name']."</a></li>";
                }else{
                        echo "<li><a href=\"".rewrite_mode('user.php/music/index/'.$rows['in_id'].'/')."\">".$rows['in_name']."</a></li>";
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
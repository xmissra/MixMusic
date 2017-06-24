<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db; ?>
<?php
$invisible = $db->getone("select in_invisible from ".tname('session')." where in_uid=".$ear['in_userid']);
$online = is_numeric($invisible) && $invisible == 0 ? '<a href="'.rewrite_mode('user.php/misc/rank/online/').'" title="当前在线"><img src="'.IN_PATH.'static/user/images/online_icon.gif" align="absmiddle"></a>&nbsp;' : '';
$last_doing = '';
$query = $db->query("select * from ".tname('feed')." where in_uid=".$ear['in_userid']." and in_type=0 order by in_addtime desc LIMIT 0,1");
while ($row = $db->fetch_array($query)){
$last_doing = preg_replace('/\[em:(\d+)]/is', '<img src="'.IN_PATH.'static/user/images/face/\1.gif" class="face">', $row['in_content']);
}
?>
<div id="content">
<h3 id="spaceindex_name">
<?php echo $online; ?><a href="<?php echo getlink($ear['in_userid']); ?>"><?php echo $ear['in_username']; ?></a>
<?php if($ear['in_grade'] == 1){ ?>
<a href="<?php echo rewrite_mode('user.php/profile/vip/'); ?>" title="绿钻会员"><img src="<?php echo IN_PATH; ?>static/user/images/vip/vip.gif" align="absmiddle" /></a>
<?php } ?>
<?php if($ear['in_isstar'] == 1){ ?>
<a href="<?php echo rewrite_mode('user.php/profile/verify/'); ?>" title="明星认证"><img src="<?php echo IN_PATH; ?>static/user/images/star.png" align="absmiddle" /></a>
<?php } ?>
<?php echo getlevel($ear['in_rank'], 1); ?>
</h3>
<div id="spaceindex_note">
<a href="javascript:void(0)" onclick="spaceshare(<?php echo $ear['in_userid']; ?>);" class="a_share">推荐</a>
<ul class="note_list">
<li>已有 <?php echo $ear['in_hits']; ?> 个人气, <?php echo $ear['in_points']; ?> 个金币, <?php echo $ear['in_rank']; ?> 个经验</li>
<li>用户等级：<a href="<?php echo rewrite_mode('user.php/profile/vip/'); ?>"><?php if($ear['in_grade'] == 1){echo "绿钻会员";}else{echo "普通用户";} ?></a> </li>
<li>主页地址：<a href="javascript:void(0)" id="space_link" onclick="setcopy(this.id, '<?php echo "http://".$_SERVER['HTTP_HOST'].getlink($ear['in_userid']); ?>');"><?php echo "http://".$_SERVER['HTTP_HOST'].getlink($ear['in_userid']); ?></a></li>
<li><?php echo $last_doing; ?></li>
</ul>
</div>
<?php if($ear['in_isstar'] == 1){ ?>
<div class="borderbox">
<p style="padding-bottom:10px;">该用户已通过明星认证，可以给TA留个言，或者发条私信，或者添加为好友。<br />成为好友后，您就可以第一时间关注到TA的更新动态。</p>
<a href="javascript:void(0)" onclick="pop.friend('<?php echo $ear['in_username']; ?>');" class="submit">加为好友</a>
</div><br />
<?php } ?>
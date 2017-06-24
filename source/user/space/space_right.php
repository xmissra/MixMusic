<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db; ?>
</div>
<div id="obar">
<div class="sidebox">
<h2 class="title">最近来访</h2>
<ul class="avatar_list">
<?php
$query = $db->query("select * from ".tname('footprint')." where in_uids=".$ear['in_userid']." order by in_addtime desc LIMIT 0,4");
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
<h2 class="title">最新好友</h2>
<ul class="avatar_list">
<?php
$query = $db->query("select * from ".tname('friend')." where in_uid=".$ear['in_userid']." order by in_addtime desc LIMIT 0,4");
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
</div>
</div>
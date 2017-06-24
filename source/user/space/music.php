<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php include 'source/user/space/common.php'; ?>
<?php include 'source/user/space/space_head.php'; ?>
<?php include 'source/user/people/top.php'; ?>
<?php include 'source/user/space/space_left.php'; ?>
<?php include 'source/user/space/space_center.php'; ?>
<?php global $db; ?>
<h3 class="feed_header">音乐</h3>
<?php
$Arr = getuserpage("select * from ".tname('music')." where in_uid=".$ear['in_userid']." order by in_addtime desc", 20, 4);
$result = $Arr[1];
$count = $Arr[2];
if($count == 0){
?>
<div class="c_form">还没有相关的音乐。</div>
<?php }else{ ?>
<ul class="line_list">
<?php
while ($row = $db->fetch_array($result)){
?>
<li>
<p class="r_option"><span class="event_state"><?php echo datetime($row['in_addtime']); ?></span></p>
<h4><a href="<?php echo getlink($row['in_id'], 'music'); ?>" target="_blank"><?php echo $row['in_name']; ?></a></h4>
<p><span class="gray">人气:</span> <?php echo $row['in_hits']; ?></p>
<p><span class="gray">分类:</span> <a href="<?php echo getlink($row['in_classid'], 'class'); ?>" target="_blank"><?php echo getfield('class', 'in_name', 'in_id', $row['in_classid']); ?></a></p>
</li>
<?php } ?>
</ul>
<?php echo $Arr[0]; ?>
<p style="padding:5px 0 10px 0;">&nbsp;</p>
<?php } ?>
<?php include 'source/user/space/space_right.php'; ?>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
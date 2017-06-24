<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php include 'source/user/space/common.php'; ?>
<?php include 'source/user/space/space_head.php'; ?>
<?php include 'source/user/people/top.php'; ?>
<?php include 'source/user/space/space_left.php'; ?>
<?php include 'source/user/space/space_center.php'; ?>
<?php global $db; ?>
<h3 class="feed_header">相册</h3>
<?php
$Arr = getuserpage("select * from ".tname('photo_group')." where in_uid=".$ear['in_userid']." order by in_id desc", 20, 4);
$result = $Arr[1];
$count = $Arr[2];
if($count == 0){
?>
<div class="c_form">没有可浏览的相册。</div>
<?php }else{ ?>
<table cellspacing="4" cellpadding="4" width="100%"><tbody><tr>
<?php
$loop_array = array(2, 4, 6, 8, 10, 12, 14, 16, 18);
$start = 0;
while ($row = $db->fetch_array($result)){
$nums = $db->num_rows($db->query("select count(*) from ".tname('photo')." where in_gid=".$row['in_id']));
$start = $start + 1;
?>
<td width="85" align="center"><a href="<?php echo getlink($row['in_id'], 'photogroup'); ?>" target="_blank"><img src="<?php echo getphoto($row['in_pid']); ?>" width="70" height="70"></a></td>
<td width="165">
<h6><a href="<?php echo getlink($row['in_id'], 'photogroup'); ?>" target="_blank"><?php echo $row['in_title']; ?></a></h6>
<p class="gray"><?php echo $nums; ?> 张照片</p>
</td>
<?php if(in_array($start, $loop_array)){echo "</tr><tr>";} ?>
<?php } ?>
</tr></tbody></table>
<?php echo $Arr[0]; ?>
<p style="padding:5px 0 10px 0;">&nbsp;</p>
<?php } ?>
<?php include 'source/user/space/space_right.php'; ?>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
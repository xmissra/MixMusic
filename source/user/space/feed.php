<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php include 'source/user/space/common.php'; ?>
<?php include 'source/user/space/space_head.php'; ?>
<?php include 'source/user/people/top.php'; ?>
<?php include 'source/user/space/space_left.php'; ?>
<?php include 'source/user/space/space_center.php'; ?>
<?php global $db,$userlogined,$missra_in_userid; ?>
<h3 class="feed_header">说说</h3>
<br />
<?php
$Arr = getuserpage("select * from ".tname('feed')." where in_uid=".$ear['in_userid']." and in_type=0 order by in_addtime desc", 20, 4);
$result = $Arr[1];
$count = $Arr[2];
if($count == 0){
?>
<div class="c_form">现在还没有说说</div>
<?php }else{ ?>
<div class="doing_list">
<ol>
<?php
while ($row = $db->fetch_array($result)){
$content = preg_replace('/\[em:(\d+)]/is', '<img src="'.IN_PATH.'static/user/images/face/\1.gif" class="face">', $row['in_content']);
$del = $userlogined && $row['in_uid'] == $missra_in_userid ? '&nbsp;<a href="javascript:void(0)" onclick="deldoing('.$row['in_id'].');" class="re gray">删除</a>' : '';
?>
<li>
<div class="doing">
<div class="doingcontent"><a href="<?php echo getlink($row['in_uid']); ?>"><?php echo $row['in_uname']; ?></a>: <span><?php echo $content; ?></span>&nbsp;<span class="gray">(<?php echo datetime($row['in_addtime']); ?>)</span><?php echo $del; ?>&nbsp;<a href="javascript:void(0)" onclick="docomment_form(<?php echo $row['in_id']; ?>);">回复</a></div>
<div id="doreply<?php echo $row['in_id']; ?>"><script type="text/javascript">getreply(<?php echo $row['in_id']; ?>);</script></div>
</div>
</li>
<?php } ?>
</ol>
<?php echo $Arr[0]; ?>
<p style="padding:5px 0 10px 0;">&nbsp;</p>
</div>
<?php } ?>
<?php include 'source/user/space/space_right.php'; ?>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
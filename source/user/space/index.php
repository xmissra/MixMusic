<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php include 'source/user/space/common.php'; ?>
<?php include 'source/user/space/space_head.php'; ?>
<?php include 'source/user/people/top.php'; ?>
<?php include 'source/user/space/space_left.php'; ?>
<?php include 'source/user/space/space_center.php'; ?>
<?php global $db; ?>
<h3 class="feed_header">个人资料</h3>
<br /><table cellspacing="0" cellpadding="0" class="infotable"><tbody>
<tr><th width="120">真实姓名:</th><td><?php if($ear['in_isstar'] == 1){echo $db->getone("select in_name from ".tname('verify')." where in_uid=".$ear['in_userid']);} ?></td></tr>
<tr><td class="td_title" colspan="2">基本资料</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><th>邮箱:</th><td><a href="mailto:<?php echo $ear['in_mail']; ?>"><?php echo $ear['in_mail']; ?></a></td></tr>
<tr><th>性别:</th><td><?php echo getsex($ear['in_sex']); ?></td></tr>
<tr><th>地区:</th><td><?php echo $ear['in_address']; ?></td></tr>
<tr><th>生日:</th><td><?php echo $ear['in_birthday']; ?></td></tr>
<tr><th>注册时间:</th><td><?php echo $ear['in_regdate']; ?></td></tr>
<tr><th>最近登录:</th><td><?php echo datetime($ear['in_logintime']); ?></td></tr>
<tr><th>个人介绍:</th><td><?php echo $ear['in_introduce']; ?></td></tr>
</tbody></table><br />
<div class="comments_list">
<h3 class="feed_header">留言板</h3>
<div class="box">
<form method="get" onsubmit="spacewall(<?php echo $ear['in_userid']; ?>);return false;" class="quickpost" style="padding:0 0 0 5px;"><table cellpadding="0" cellspacing="0">
<tr><td><a href="javascript:void(0)" id="wall_face" onclick="showFace(this.id, 'space_wall');return false;"><img src="<?php echo IN_PATH; ?>static/user/images/facelist.gif" align="absmiddle" /></a></td></tr>
<tr><td><textarea id="space_wall" rows="4" cols="60" style="width:98%;"></textarea></td></tr>
<tr><td><input type="submit" class="submit" value="留言" /> <span id="wall_tips" style="color:red"></span></td></tr>
</table></form>
</div>
<?php
$index = explode('/', $_SERVER['PATH_INFO']);
$pathinfo = isset($index[4]) ? 4 : 2;
$Arr = getuserpage("select * from ".tname('wall')." where in_uids=".$ear['in_userid']." order by in_addtime desc", 10, $pathinfo);
$result = $Arr[1];
$count = $Arr[2];
if($count == 0){
?>
<ul></ul>
<?php }else{ ?>
<ul>
<?php
while ($row = $db->fetch_array($result)){
$content = preg_replace('/\[em:(\d+)]/is', '<img src="'.IN_PATH.'static/user/images/face/\1.gif" class="face">', $row['in_content']);
?>
<li>
<div class="avatar48"><a href="<?php echo getlink($row['in_uid']); ?>"><img src="<?php echo getavatar($row['in_uid']); ?>"></a></div>
<div class="title">
<div class="r_option"><a href="javascript:void(0)" onclick="delwall(<?php echo $row['in_id']; ?>);">删除</a></div>
<a href="<?php echo getlink($row['in_uid']); ?>"><?php echo $row['in_uname']; ?></a>
<span class="gray"><?php echo datetime($row['in_addtime']); ?></span>
</div>
<div class="detail"><?php echo $content; ?></div>
</li>
<?php } ?>
</ul>
<?php echo $Arr[0]; ?>
<p style="padding:5px 0 10px 0;">&nbsp;</p>
<?php } ?>
</div>
<?php include 'source/user/space/space_right.php'; ?>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
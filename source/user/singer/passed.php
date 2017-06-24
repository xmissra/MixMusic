<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<?php
$letter_arr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
$letter_arr1 = array(-20319, -20283, -19775, -19218, -18710, -18526, -18239, -17922, -1, -17417, -16474, -16212, -15640, -15165, -14922, -14914, -14630, -14149, -14090, -13318, -1, -1, -12838, -12556, -11847, -11055);
$letter_arr2 = array(-20284, -19776, -19219, -18711, -18527, -18240, -17923, -17418, -1, -16475, -16213, -15641, -15166, -14923, -14915, -14631, -14150, -14091, -13319, -12839, -1, -1, -12557, -11848, -11056, -2050);
$passed = explode('/', $_SERVER['PATH_INFO']);
$cid = isset($passed[3]) ? $passed[3] : NULL;
if(in_array(strtoupper($cid), $letter_arr)){
$posarr = array_keys($letter_arr, strtoupper($cid));
$pos = $posarr[0];
$get = true;
$Arr = getuserpage("select * from ".tname('singer')." where UPPER(substring(".convert_using('in_name').",1,1))='".$letter_arr[$pos]."' and in_uid=".$missra_in_userid." and in_passed=1 or ord(substring(".convert_using('in_name').",1,1))-65536>=".$letter_arr1[$pos]." and  ord(substring(".convert_using('in_name').",1,1))-65536<=".$letter_arr2[$pos]." and in_uid=".$missra_in_userid." and in_passed=1", 10, 4);
}elseif(IsNum($cid)){
$get = $db->getone("select in_id from ".tname('singer_class')." where in_id=".$cid);
$Arr = getuserpage("select * from ".tname('singer')." where in_uid=".$missra_in_userid." and in_passed=1 and in_classid=".$cid." order by in_addtime desc", 10, 4);
}else{
$get = true;
$Arr = getuserpage("select * from ".tname('singer')." where in_uid=".$missra_in_userid." and in_passed=1 order by in_addtime desc", 10, 3);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>待审歌手 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/singer.js"></script>
<script type="text/javascript">
var in_path = '<?php echo IN_PATH; ?>';
</script>
<style type="text/css">
@import url(<?php echo IN_PATH; ?>static/user/css/style.css);
@import url(<?php echo IN_PATH; ?>static/user/css/event.css);
.float_delsinger{
	width:13px;
	height:14px;
	background:url(<?php echo IN_PATH; ?>static/user/images/delete.gif) no-repeat 0 0;
	top:0.5em;
	right:5px;
	text-indent:-999em;
	overflow:hidden;
	display:block
}
.float_delsinger:hover{
	background-position:0 -14px
}
.float_editsinger{
	float:left;
	width:13px;
	height:14px;
	background:url(<?php echo IN_PATH; ?>static/user/images/edit.gif) no-repeat 0 0;
	top:0.5em;
	right:5px;
	text-indent:-999em;
	overflow:hidden;
	display:block
}
.float_editsinger:hover{
	background-position:0 -14px
}
</style>
</head>
<body>
<?php include 'source/user/people/top.php'; ?>
<div id="main">
<?php include 'source/user/people/left.php'; ?>
<div id="mainarea">
<h2 class="title"><img src="<?php echo IN_PATH; ?>static/user/images/icon/singer.gif">歌手</h2>
<div class="tabs_header">
<ul class="tabs">
<li><a href="<?php echo rewrite_mode('user.php/singer/index/'); ?>"><span>已审歌手</span></a></li>
<li class="active"><a href="<?php echo rewrite_mode('user.php/singer/passed/'); ?>"><span>待审歌手</span></a></li>
<li class="null"><a href="<?php echo rewrite_mode('user.php/singer/add/'); ?>">创建歌手</a></li>
</ul>
</div>
<div id="content" style="width:640px;">
<?php if($get){ ?>
<div class="c_mgs"><div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">以下是您创建但未通过审核的歌手列表</div></div></div></div></div>
<div class="h_status">
<?php
for($i=0;$i<26;$i++){
        if($i < 25){
                if(strtoupper($cid) == $letter_arr[$i]){
                        echo '<a href="'.rewrite_mode('user.php/singer/passed/'.strtolower($letter_arr[$i]).'/').'" class="active">'.$letter_arr[$i].'</a><span class="pipe">|</span>';
                }else{
                        echo '<a href="'.rewrite_mode('user.php/singer/passed/'.strtolower($letter_arr[$i]).'/').'">'.$letter_arr[$i].'</a><span class="pipe">|</span>';
                }
        }else{
                if(strtoupper($cid) == $letter_arr[$i]){
                        echo '<a href="'.rewrite_mode('user.php/singer/passed/'.strtolower($letter_arr[$i]).'/').'" class="active">'.$letter_arr[$i].'</a>';
                }else{
                        echo '<a href="'.rewrite_mode('user.php/singer/passed/'.strtolower($letter_arr[$i]).'/').'">'.$letter_arr[$i].'</a>';
                }
        }
}
?>
</div>
<?php
$result = $Arr[1];
$count = $Arr[2];
if($count == 0){
?>
<div class="c_form">没有相关待审歌手。</div>
<?php }else{ ?>
<div class="event_list"><ol>
<?php
while ($row = $db->fetch_array($result)){
?>
<li>
<div class="event_icon"><a href="<?php echo getlink($row['in_id'], 'singer'); ?>" target="_blank"><img class="poster_pre" src="<?php echo geturl($row['in_cover'], 'cover'); ?>"></a></div>
<div class="event_content">
<h4 class="event_title"><a href="<?php echo getlink($row['in_id'], 'singer'); ?>" target="_blank"><?php echo $row['in_name']; ?></a></h4>
<ul>
<li><span class="gray">人气:</span> <?php echo $row['in_hits']; ?></li>
<li><span class="gray">更新:</span> <?php echo datetime($row['in_addtime']); ?></li>
<li><span class="gray">分类:</span> <a href="<?php echo getlink($row['in_classid'], 'singerclass'); ?>" target="_blank"><?php echo getfield('singer_class', 'in_name', 'in_id', $row['in_classid']); ?></a></li>
<li style="margin: 5px 0 0;"><a href="<?php echo rewrite_mode('user.php/singer/edit/'.$row['in_id'].'/'); ?>" class="float_editsinger">编辑</a><a class="float_delsinger" style="cursor:pointer" onclick="delsinger(<?php echo $row['in_id']; ?>);">删除</a></li>
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
<h3>歌手分类</h3>
<ul class="post_list line_list">
<?php
if(!IsNum($cid)){
        echo "<li class=\"current\"><a href=\"".rewrite_mode('user.php/singer/passed/')."\">不限分类</a></li>";
}else{
        echo "<li><a href=\"".rewrite_mode('user.php/singer/passed/')."\">不限分类</a></li>";
}
$res=$db->query("select * from ".tname('singer_class')." order by in_id asc");
if($res){
        while ($rows = $db->fetch_array($res)){
                if($cid == $rows['in_id']){
                        echo "<li class=\"current\"><a href=\"".rewrite_mode('user.php/singer/passed/'.$rows['in_id'].'/')."\">".$rows['in_name']."</a></li>";
                }else{
                        echo "<li><a href=\"".rewrite_mode('user.php/singer/passed/'.$rows['in_id'].'/')."\">".$rows['in_name']."</a></li>";
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
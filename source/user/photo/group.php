<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php
global $db;
$group = explode('/', $_SERVER['PATH_INFO']);
$gid = isset($group[3]) ? intval($group[3]) : 0;
$nums = $db->num_rows($db->query("select count(*) from ".tname('photo')." where in_gid=".$gid));
$rows = $db->getrow("select * from ".tname('photo_group')." where in_id=".$gid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>浏览相册 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<link href="<?php echo IN_PATH; ?>static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/photo.js"></script>
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
var in_path = '<?php echo IN_PATH; ?>';
var guide_url = '<?php echo rewrite_mode('user.php/people/home/'); ?>';
var pop = {
	up: function(scrolling, text, url, width, height, top) {
		layer.open({
			type: 2,
			maxmin: true,
			title: text,
			content: [url, scrolling],
			area: [width, height],
			offset: top,
			shade: false
		});
	}
}
function qzone_return(type){
        layer.closeAll();
        if(type==1){
            uc_syn('login');
            location.href = guide_url;
        }else{
            location.href = '<?php echo rewrite_mode('user.php/people/connect/'); ?>';
        }
}
function update_seccode(){
	$('img_seccode').src = '<?php echo rewrite_mode('user.php/people/seccode/\' + Math.random() + \'/'); ?>';
}
</script>
<style type="text/css">
@import url(<?php echo IN_PATH; ?>static/user/css/style.css);
@import url(<?php echo IN_PATH; ?>static/user/css/album.css);
</style>
</head>
<body>
<?php include 'source/user/people/top.php'; ?>
<?php if($rows){ ?>
<div id="main">
<?php include 'source/user/people/left.php'; ?>
<div id="mainarea">
<div class="c_header a_header">
<div class="avatar48"><a href="<?php echo getlink($rows['in_uid']); ?>"><img src="<?php echo getavatar($rows['in_uid']); ?>"></a></div>
<p style="font-size:14px"><a href="<?php echo getlink($rows['in_uid']); ?>"><?php echo $rows['in_uname']; ?></a></p>
<a href="<?php echo getlink($rows['in_uid'], 's_photo'); ?>" class="spacelink">TA的相册</a>
<span class="pipe">&raquo;</span>
<a href="<?php echo getlink($rows['in_id'], 'photogroup'); ?>"><?php echo $rows['in_title']; ?></a>
</div>
<div class="h_status"><a href="javascript:void(0)" onclick="groupshare(<?php echo $rows['in_id']; ?>);" class="a_share">推荐</a><?php echo $rows['in_title']; ?> - 共 <?php echo $nums; ?> 张照片</div>
<?php
$Arr = getuserpage("select * from ".tname('photo')." where in_gid=".$gid." order by in_id desc", 20, 4);
$result = $Arr[1];
$count = $Arr[2];
if($count == 0){
?>
<div class="c_form">该相册下还没有照片。</div>
<?php }else{ ?>
<table cellspacing="6" cellpadding="0" width="100%" class="photo_list"><tr>
<?php
$start = 0;
while ($row = $db->fetch_array($result)){
$start = $start + 1;
?>
<td align="center">
<a href="<?php echo getlink($row['in_id'], 'photo'); ?>" title="<?php echo $row['in_title']; ?>"><img src="<?php echo getphoto($row['in_id']); ?>" /></a>
</td>
<?php if($start == 4 || $start == 8 || $start == 12 || $start == 16){echo "</tr><tr>";} ?>
<?php } ?>
</tr><tr></tr></table>
<?php echo $Arr[0]; ?>
<?php } ?>
</div>
<div id="bottom"></div>
</div>
<?php }else{ ?>
<div class="showmessage">
<div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">
<caption>
<h2>信息提示</h2>
</caption>
<p><a href="<?php echo IN_PATH; ?>user.php">抱歉，您要浏览的相册不存在！</a><script type="text/javascript">setTimeout("location.href='<?php echo IN_PATH; ?>user.php';", 3000);</script></p>
<p class="op"><a href="<?php echo IN_PATH; ?>user.php">页面跳转中...</a></p>
</div></div></div></div>
</div>
<?php } ?>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
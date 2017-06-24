<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<?php
$special = explode('/', $_SERVER['PATH_INFO']);
$aid = isset($special[3]) ? $special[3] : NULL;
if(IsNum($aid)){
$get = $db->getrow("select * from ".tname('special')." where in_uid=".$missra_in_userid." and in_id=".$aid);
}else{
$get = false;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>专辑淘歌 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/lib.js"></script>
<script type="text/javascript">
function join_list(){
        if(document.form.joinlist.value == ''){
                layer.tips('请选择要加入专辑的歌曲！', '#joinlist', {
			tips: [1, '#3B5998'],
			time: 3000
		});
                document.form.joinlist.focus();
                return false;
        }
}
function del_list(){
        if(document.form.dellist.value == ''){
                layer.tips('请选择要删除的专辑歌曲！', '#dellist', {
			tips: [1, '#DDD'],
			time: 3000
		});
                document.form.dellist.focus();
                return false;
        }
}
</script>
<style type="text/css">
@import url(<?php echo IN_PATH; ?>static/user/css/style.css);
</style>
</head>
<body>
<?php include 'source/user/people/top.php'; ?>
<div id="main">
<?php include 'source/user/people/left.php'; ?>
<div id="mainarea">
<h2 class="title"><img src="<?php echo IN_PATH; ?>static/user/images/icon/special.gif">专辑</h2>
<div class="tabs_header">
<ul class="tabs">
<li><a href="<?php echo rewrite_mode('user.php/special/index/'); ?>"><span>已审专辑</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/special/passed/'); ?>"><span>待审专辑</span></a></li>
<li class="null"><a href="<?php echo rewrite_mode('user.php/special/add/'); ?>">制作专辑</a></li>
</ul>
</div>
<?php if($get){ ?>
<?php
if(submitcheck('join')){
	$db->query("update ".tname('music')." set in_specialid=".$get['in_id']." where in_id in (".set_special('joinlist', $missra_in_userid, 'join').")");
}elseif(submitcheck('del')){
	$db->query("update ".tname('music')." set in_specialid=0 where in_id in (".set_special('dellist', $get['in_id']).")");
}
?>
<form method="post" name="form" class="c_form">
<table cellspacing="0" cellpadding="0" class="formtable"><caption><h2>专辑淘歌 -> <?php echo $get['in_name']; ?></h2></caption>
<tr align="center"><td height="35">您上传且未加入任何专辑的音乐列表</td><td><b>按Shift键可多选</b></td><td>已加入该专辑的音乐列表</td></tr>
<tr align="center">
<td width="44%"><select name="joinlist[]" id="joinlist" style="width:320px;height:350px" multiple="multiple" size="1">
<?php
$result=$db->query("select * from ".tname('music')." where in_uid=".$missra_in_userid." and in_specialid=0 order by in_addtime desc");
if($result){
        while ($row = $db->fetch_array($result)){
                echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
        }
}
?>
</select></td>
<td width="12%"><input type="submit" name="join" value="<=加入" onclick="return join_list();" class="submit" /><br /><br /><input type="submit" name="del" value="删除=>" onclick="return del_list();" class="button" /></td>
<td width="44%"><select name="dellist[]" id="dellist" style="width:320px;height:350px" multiple="multiple" size="1">
<?php
$result=$db->query("select * from ".tname('music')." where in_specialid=".$get['in_id']." order by in_addtime desc");
if($result){
        while ($row = $db->fetch_array($result)){
                echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
        }
}
?>
</select></td>
</tr>
</table>
</form>
<?php }else{ ?>
<div id="content" style="width:100%;"><div class="c_form">专辑不存在或您无权淘歌。</div></div>
<?php } ?>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
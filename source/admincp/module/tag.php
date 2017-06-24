<?php
if(!defined('IN_ROOT')){exit('Access denied');}
Administrator(4);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>音乐标签</title>
<link href="static/admincp/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">function $(obj) {return document.getElementById(obj);}</script>
</head>
<body>
<?php
switch($action){
	case 'add':
		adds();
		break;
	case 'edit':
		edits();
		break;
	default:
		main(empty($_GET['type']) ? 0 : intval($_GET['type']));
		break;
	}
?>
</body>
</html>
<?php
function main($type){
	global $db;
	$sql="select * from ".tname('tag')." where in_type=".$type." order by in_id asc";
	$result=$db->query($sql);
	$count=$db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'MixMusic 管理中心 - 内容 - 音乐标签';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;音乐标签';</script>
<div class="floattop"><div class="itemtitle">
<ul class="tab1">
<?php if($type==0){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=tag"><span>按地域</span></a></li>
<?php if($type==1){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=tag&type=1"><span>按曲风</span></a></li>
<?php if($type==2){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=tag&type=2"><span>按心情</span></a></li>
<?php if($type==3){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=tag&type=3"><span>按歌手</span></a></li>
<?php if($type==4){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=tag&type=4"><span>按语言</span></a></li>
</ul></div></div>
<table class="tb tb2">
<tr><th class="partition">编辑标签</th></tr>
</table>
<form name="form" method="post" action="?iframe=tag&action=edit">
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>标签名称</th>
<th>状态</th>
</tr>
<?php
if($count==0){
?>
<tr><td colspan="2">没有标签</td></tr>
<?php
}
if($result){
while($row = $db->fetch_array($result)){
?>
<tr class="hover">
<td class="width-50"><?php echo $row['in_id']; ?></td>
<td><input type="text" name="in_title<?php echo $row['in_id']; ?>" value="<?php echo $row['in_title']; ?>" class="txt" /></td>
<td class="width-50"><input type="hidden" name="in_id[]" id="in_id" value="<?php echo $row['in_id']; ?>"><input type="checkbox" class="checkbox" name="in_checks<?php echo $row['in_id']; ?>" value="1" checked />保留</td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td colspan="15"><div class="fixsel"><input type="submit" class="btn" name="edit" value="提交修改" /></div></td></tr>
</table>
</form>

<table class="tb tb2">
<tr><th class="partition">新增标签</th></tr>
</table>
<form method="post" action="?iframe=tag&action=add">
<table class="tb tb2">
<tr class="header">
<th>标签名称</th>
</tr>
<tr class="hover">
<td><input type="hidden" name="in_type" value="<?php echo $type; ?>"><input type="text" class="txt" size="25" name="in_title"></td>
</tr>
</table>
<table class="tb tb2">
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="add" class="btn" value="新增" /></div></td></tr>
</table>
</form>
</div>



<?php
}
	function adds(){
		global $db;
		if(!submitcheck('add')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_type = SafeRequest("in_type","post");
		$in_title = SafeRequest("in_title","post");
		if(!IsNul($in_title)){ShowMessage("新增出错，标签名称不能为空！",$_SERVER['HTTP_REFERER'],"infotitle3",1000,1);}
		$sql="Insert ".tname('tag')." (in_title,in_type) values ('".$in_title."',".$in_type.")";
		if($db->query($sql)){
			ShowMessage("恭喜您，标签新增成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
		}else{
			ShowMessage("新增出错，标签新增失败！",$_SERVER['HTTP_REFERER'],"infotitle3",3000,1);
		}
	}

	function edits(){
		global $db;
		if(!submitcheck('edit')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_id = RequestBox("in_id");
		$ID=explode(",",$in_id);
		for($i=0;$i<count($ID);$i++){
			$in_title=SafeRequest("in_title".$ID[$i],"post");
			$in_checks=SafeRequest("in_checks".$ID[$i],"post");
			if(!IsNul($in_title)){ShowMessage("修改出错，标签名称不能为空！",$_SERVER['HTTP_REFERER'],"infotitle3",1000,1);}
			if($in_checks==1){
				$sql="update ".tname('tag')." set in_title='".$in_title."' where in_id=".intval($ID[$i]);
			}else{
				$sql="delete from ".tname('tag')." where in_id=".intval($ID[$i]);
			}
			$db->query($sql);
		}
		ShowMessage("恭喜您，标签修改成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
	}
?>
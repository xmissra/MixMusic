<?php
include '../../system/db.class.php';
$action=SafeRequest("action","get");
$so=SafeRequest("so","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>专辑选择</title>
<link href="../../../static/admincp/css/main.css" rel="stylesheet" type="text/css" />
<link href="../../../static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="../../../static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript">
function ReturnValue(reimg){
        this.parent.document.<?php echo $so; ?>.value=reimg;
        this.parent.asyncbox.tips("恭喜，专辑选择成功！", "success", 1000);
        this.parent.layer.closeAll();
}
function s(){
        var k=document.getElementById("search").value;
        if(k==""){
                asyncbox.tips("请输入要查询的关键词！", "wait", 1000);
                document.getElementById("search").focus();
                return false;
        }else{
                document.btnsearch.submit();
        }
}
</script>
</head>
<body>
<?php
switch($action){
	case 'keyword':
		$key=SafeRequest("key","get");
		main("select * from ".tname('special')." where in_name like '%".$key."%' or in_uname like '%".$key."%' order by in_addtime desc",20);
		break;
	default:
		main("select * from ".tname('special')." order by in_addtime desc",20);
		break;
	}
?>
</body>
</html>
<?php
function main($sql,$size){
	global $db,$so;
	$Arr=getpagerow($sql,$size);
	$result=$Arr[1];
	$count=$Arr[2];
?>
<div class="container">
<table class="tb tb2">
<form name="btnsearch" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<tr><td>
<input type="hidden" name="action" value="keyword">
<input type="hidden" name="so" value="<?php echo $so; ?>">
关键词：<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<input type="button" value="搜索" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<table class="tb tb2">
<tr class="header">
<th>专辑名称</th>
<th>所属会员</th>
<th>更新时间</th>
</tr>
<?php
if($count==0){
?>
<tr><td colspan="2">没有专辑</td></tr>
<?php
}
if($result){
while($row = $db->fetch_array($result)){
?>
<tr class="hover">
<td><a href="javascript:ReturnValue(<?php echo $row['in_id']; ?>);" class="act"><?php echo ReplaceStr($row['in_name'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><?php echo ReplaceStr($row['in_uname'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></td>
<td><?php echo $row['in_addtime']; ?></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<?php echo $Arr[0]; ?>
</table>
</div>
<?php } ?>
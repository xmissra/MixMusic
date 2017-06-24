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
	<title>音乐栏目</title>
	<link href="static/admincp/css/main.css" rel="stylesheet" type="text/css" />
	<link href="static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="static/pack/asynctips/jquery.min.js"></script>
	<script type="text/javascript" src="static/pack/asynctips/asyncbox.v1.4.5.js"></script>
	<script type="text/javascript">
		function CheckAll(form) {
			for (var i = 0; i < form.elements.length; i++) {
				var e = form.elements[i];
				if (e.name != 'chkall') {
					e.checked = form.chkall.checked;
				}
			}
		}
		function CheckForm(){
			if(document.form1.in_name.value==""){
				asyncbox.tips("栏目名称不能为空，请填写！", "wait", 1000);
				document.form1.in_name.focus();
				return false;
			}
			else if(document.form1.in_order.value==""){
				asyncbox.tips("排序不能为空，请填写！", "wait", 1000);
				document.form1.in_order.focus();
				return false;
			}
			else {
				return true;
			}
		}
		function CheckClass(){
			if(document.form2.Class_1.value==""){
				asyncbox.tips("原始栏目不能为空，请选择！", "wait", 1000);
				document.form2.Class_1.focus();
				return false;
			}
			else if(document.form2.Class_2.value==""){
				asyncbox.tips("目标栏目不能为空，请选择！", "wait", 1000);
				document.form2.Class_2.focus();
				return false;
			}
			else {
				return true;
			}
		}
	</script>
</head>
<body>
	<?php
	switch($action){
		case 'del':
			Del();
			break;
		case 'edithide':
			EditHide();
			break;
		case 'editsave':
			EditSave();
			break;
		case 'saveadd':
			SaveAdd();
			break;
		case 'unite':
			Unite();
			break;
		default:
			main();
			break;
		}
	?>
</body>
</html>
<?php
function main(){
	global $db;
	$sql="select * from ".tname('class')." order by in_id asc";
	$result=$db->query($sql);
	$count=$db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
?>
<div class="container">
	<script type="text/javascript">parent.document.title = 'MixMusic 管理中心 - 内容 - 音乐栏目';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;音乐栏目';</script>
	<div class="floattop">
		<div class="itemtitle">
			<ul class="tab1">
				<li class="current"><a href="javascript:void(0)"><span>音乐栏目</span></a><li>
			<ul>
		</div>
	</div>
	<table class="tb tb2">
		<tr><th class="partition">栏目管理</th></tr>
	</table>
	<form name="form" method="post" action="?iframe=class&action=editsave">
		<table class="tb tb2">
			<tr class="header">
				<th>编号</th>
				<th>栏目名称</th>
				<th>音乐统计</th>
				<th>排序</th>
				<th>状态</th>
				<th>编辑操作</th>
			</tr>
			<?php
			if($count==0){
			?>
			<tr><td colspan="2">没有音乐栏目</td></tr>
			<?php
			}
			if($result){
			while($row = $db->fetch_array($result)){
			?>
			<tr class="hover">
				<td class="width-50"><input class="checkbox" type="checkbox" name="in_id[]" id="in_id" value="<?php echo $row['in_id']; ?>"><?php echo $row['in_id']; ?></td>
				<td><div class="parentboard"><input type="text" name="in_name<?php echo $row['in_id']; ?>" value="<?php echo $row['in_name']; ?>" class="txt" /></div></td>
				<td><a href="?iframe=music&action=list&in_classid=<?php echo $row['in_id']; ?>" class="act">
				<?php
				$nums = $db->num_rows($db->query("select count(*) from ".tname('music')." where in_classid=".$row['in_id']));
				echo $nums;
				?>
				</a></td>
				<td class="width-50"><input type="text" name="in_order<?php echo $row['in_id']; ?>" value="<?php echo $row['in_order']; ?>" class="txt" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td>
				<td>
				<?php if($row['in_hide']==1){ ?>
				<a href="?iframe=class&action=edithide&in_id=<?php echo $row['in_id']; ?>&in_hide=0"><img src="static/admincp/css/show_no.gif" /></a>
				<?php }else{ ?>
				<a href="?iframe=class&action=edithide&in_id=<?php echo $row['in_id']; ?>&in_hide=1"><img src="static/admincp/css/show_yes.gif" /></a>
				<?php } ?>
				</td>
				<td><input type="button" class="btn" value="删除" onclick="location.href='?iframe=class&action=del&in_id=<?php echo $row['in_id']; ?>';" /></td>
			</tr>
			<?php
			}
			}
			?>
		</table>

		<table class="tb tb2">
			<tr><td class="width-50"><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form);" /><label for="chkall">全选</label></td><td colspan="15"><div class="fixsel"><input type="submit" class="btn" name="form" value="提交修改" /></div></td></tr>
		</table>
	</form>

	<table class="tb tb2">
		<tr><th class="partition">新增栏目</th></tr>
	</table>

	<form name="form1" method="post" action="?iframe=class&action=saveadd">
		<table class="tb tb2">
			<tr>
			<td>栏目名称</td>
			<td><input type="text" class="txt" name="in_name" id="in_name" size="18" style="margin:0; width: 140px;"></td>
			<td>排序</td>
			<td><input type="text" class="txt" name="in_order" id="in_order" style="margin:0; width: 104px;" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
			</tr>
			<tr><td colspan="15"><div class="fixsel"><input type="submit" name="form1" class="btn" onclick="return CheckForm();" value="新增" /></div></td></tr>
		</table>
	</form>

	<table class="tb tb2">
		<tr><th class="partition">数据转移</th></tr>
	</table>

	<form action="?iframe=class&action=unite" name="form2" method="post">
		<table class="tb tb2">
			<tr><td colspan="2">原始栏目:</td></tr>
			<tr><td class="vtop rowform">
			<select name="Class_1" id="Class_1">
			<option value="">选择栏目</option>
			<?php
			$sql="select * from ".tname('class')." order by in_id asc";
			$result=$db->query($sql);
			if($result){
			while ($row = $db->fetch_array($result)){
			?>
			<option value="<?php echo $row['in_id']; ?>"><?php echo $row['in_name']; ?></option>
			<?php
			}
			}
			?>
			</select>
			</td><td class="vtop tips2">等待转移数据的栏目</td></tr>
			<tr><td colspan="2">目标栏目:</td></tr>
			<tr><td class="vtop rowform">
			<select name="Class_2" id="Class_2">
			<option value="">选择栏目</option>
			<?php
			$sql="select * from ".tname('class')." order by in_id asc";
			$result=$db->query($sql);
			if($result){
			while ($row = $db->fetch_array($result)){
			?>
			<option value="<?php echo $row['in_id']; ?>"><?php echo $row['in_name']; ?></option>
			<?php
			}
			}
			?>
			</select>
			</td><td class="vtop tips2">等待转入数据的栏目</td></tr>
		</table>
		<table class="tb tb2">
			<tr><td colspan="15"><div class="fixsel"><input type="submit" name="form2" class="btn" onclick="return CheckClass();" value="转移" /> &nbsp;注意: 转移前请先备份数据库，合并后的数据将不可再单独分离到“原始栏目”</div></td></tr>
		</table>
	</form>
</div>


<?php
}
	function Unite(){
		global $db;
		if(!submitcheck('form2')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$Class_1=intval(SafeRequest("Class_1","post"));
		$Class_2=intval(SafeRequest("Class_2","post"));
		$sql="update ".tname('music')." set in_classid=".$Class_2." where in_classid=".$Class_1;
		if($db->query($sql)){
			ShowMessage("恭喜您，数据转移成功！","?iframe=class","infotitle2",3000,1);
		}
	}

	function SaveAdd(){
		global $db;
		if(!submitcheck('form1')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_name=SafeRequest("in_name","post");
		$in_order=SafeRequest("in_order","post");
		$sql="Insert ".tname('class')." (in_name,in_hide,in_order) values ('".$in_name."',0,".$in_order.")";
		if($db->query($sql)){
			ShowMessage("恭喜您，音乐栏目新增成功！","?iframe=class","infotitle2",1000,1);
		}
	}

	function EditSave(){
		global $db;
		if(!submitcheck('form')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_id=RequestBox("in_id");
		if($in_id==0){
			ShowMessage("修改失败，请先勾选要编辑的栏目！","?iframe=class","infotitle3",3000,1);
		}else{
			$ID=explode(",",$in_id);
			for($i=0;$i<count($ID);$i++){
				$in_name=SafeRequest("in_name".$ID[$i],"post");
				$in_order=SafeRequest("in_order".$ID[$i],"post");
				if(!IsNul($in_name)){ShowMessage("修改出错，栏目名称不能为空！","?iframe=class","infotitle3",1000,1);}
				if(!IsNum($in_order)){ShowMessage("修改出错，排序不能为空！","?iframe=class","infotitle3",1000,1);}
				$sql="update ".tname('class')." set in_name='".$in_name."',in_order=".intval($in_order)." where in_id=".intval($ID[$i]);
				$db->query($sql);
			}
			ShowMessage("恭喜您，音乐栏目修改成功！","?iframe=class","infotitle2",3000,1);
		}
	}

	function EditHide(){
		global $db;
		$in_id=intval(SafeRequest("in_id","get"));
		$in_hide=intval(SafeRequest("in_hide","get"));
		$sql="update ".tname('class')." set in_hide=".$in_hide." where in_id=".$in_id;
		if($db->query($sql)){
			ShowMessage("恭喜您，状态切换成功！","?iframe=class","infotitle2",1000,1);
		}
	}

	function Del(){
		global $db;
		$in_id=intval(SafeRequest("in_id","get"));
		$sql="delete from ".tname('class')." where in_id=".$in_id;
		if($db->query($sql)){
			ShowMessage("恭喜您，音乐栏目删除成功！","?iframe=class","infotitle2",3000,1);
		}
	}
?>
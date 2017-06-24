<?php
if(!defined('IN_ROOT')){exit('Access denied');}
Administrator(3);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>模板标签</title>
<link href="static/admincp/css/main.css" rel="stylesheet" type="text/css" />
<link href="static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript">
function CheckForm(){
        if(document.form.in_name.value==""){
            asyncbox.tips("标签名称不能为空，请填写！", "wait", 1000);
            document.form.in_name.focus();
            return false;
        }
        else if(document.form.in_type.value==""){
            asyncbox.tips("标签分类不能为空，请填写！", "wait", 1000);
            document.form.in_type.focus();
            return false;
        }
        else if(document.form.in_priority.value==""){
            asyncbox.tips("优先等级不能为空，请填写！", "wait", 1000);
            document.form.in_priority.focus();
            return false;
        }
        else if(document.form.in_selflable.value==""){
            asyncbox.tips("标签内容不能为空，请填写！", "wait", 1000);
            document.form.in_selflable.focus();
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
	case 'add':
		Add();
		break;
	case 'saveadd':
		SaveAdd();
		break;
	case 'edit':
		Edit();
		break;
	case 'saveedit':
		SaveEdit();
		break;
	case 'del':
		Del();
		break;
	case 'keyword':
		$key=SafeRequest("key","get");
		main("select * from ".tname('label')." where in_type like '%".$key."%' order by in_id desc",20);
		break;
	default:
		main("select * from ".tname('label')." order by in_id desc",20);
		break;
	}
?>
</body>
</html>
<?php
function EditBoard($Arr,$url,$arrname){
		$in_name = $Arr[0];
		$in_type = $Arr[1];
		$in_remark = $Arr[2];
		$in_priority = !IsNum($Arr[3]) ? 0 : $Arr[3];
		$in_selflable = $Arr[4];
?>
<div class="container">
<?php if($_GET['action']=="add"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 风格 - 新增标签';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='风格&nbsp;&raquo;&nbsp;新增标签';</script>";} ?>
<?php if($_GET['action']=="edit"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 风格 - 编辑标签';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='风格&nbsp;&raquo;&nbsp;编辑标签';</script>";} ?>
<div class="floattop"><div class="itemtitle"><ul class="tab1">
<li><a href="?iframe=label"><span>模板标签</span></a></li>
<?php if($_GET['action']=="add"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=label&action=add"><span>新增标签</span></a></li>
</ul></div></div>
<table class="tb tb2">
<form action="<?php echo $url; ?>" method="post" name="form">
<tr><th colspan="15" class="partition"><?php echo $arrname; ?>标签</th></tr>
<tr><td colspan="2">标签名称:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $in_name; ?>" name="in_name" id="in_name"></td><td class="vtop tips2">英文区分大小写，无需输入定界符且不可重复</td></tr>
<tr><td colspan="2">标签分类:</td></tr>
<tr><td class="vtop rowform">
<ul class="nofloat">
<li><input type="text" class="txt" value="<?php echo $in_type; ?>" id="in_type" name="in_type"></li>
<li><select onchange="in_type.value=this.value;">
<option value=""><?php echo $arrname; ?>分类</option>
<?php
global $db;
$sqlclass="select distinct (in_type) from ".tname('label');
$results=$db->query($sqlclass);
if($results){
while ($row3 = $db->fetch_array($results)){
echo "<option value=\"".$row3['in_type']."\">".$row3['in_type']."</option>";
}
}
?>
</select></li>
</ul>
</td><td class="vtop tips2">如没有分类，请新增一个</td></tr>
<tr><td colspan="2">标签描述:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $in_remark; ?>" name="in_remark" id="in_remark"></td><td class="vtop tips2">对标签的简短描述，便于记忆</td></tr>
<tr><td colspan="2">优先等级:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $in_priority; ?>" name="in_priority" id="in_priority" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">数值越小，优先级越高</td></tr>
<tr><td colspan="2">标签内容:</td></tr>
<tr><td class="vtop rowform"><textarea rows="6" name="in_selflable" id="in_selflable" cols="50" class="tarea"><?php echo base64_decode($in_selflable); ?></textarea></td><td class="vtop tips2">支持模板标签的多层嵌套调用，嵌套规则取决于“优先等级”</td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="form" onclick="return CheckForm();" class="btn" value="提交" /></div></td></tr>
</form>
</table>
</div>


<?php
}
function main($sql,$size){
	global $db,$action;
        $key=SafeRequest("key","get");
	$Arr=getpagerow($sql,$size);
	$result=$Arr[1];
	$count=$Arr[2];
?>
<script type="text/javascript" src="static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="static/pack/layer/lib.js"></script>
<script type="text/javascript">
function setcopy(text, id){
	var browserName = navigator.appName;
	if(browserName=="Netscape"){
		layer.tips('您的浏览器不支持自动复制，请手工复制！', '#copy' + id, {
			tips: [1, '#FF8901'],
			time: 3000
		});
	}else if(browserName=="Microsoft Internet Explorer"){
		clipboardData.setData('Text', text);
		layer.tips('标签' + text + '复制成功！', '#copy' + id, {
			tips: [1, '#99C521'],
			time: 3000
		});
	}
}
</script>
<div class="container">
<?php if(empty($action)){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 风格 - 模板标签';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='风格&nbsp;&raquo;&nbsp;模板标签';</script>";} ?>
<?php if($action=="keyword"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 风格 - 标签分类';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='风格&nbsp;&raquo;&nbsp;标签分类';</script>";} ?>
<div class="floattop">
<div class="itemtitle">
<ul class="tab1">
<?php if(empty($action)){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=label"><span>模板标签</span></a></li>
<li><a href="?iframe=label&action=add"><span>新增标签</span></a></li>
</ul></div></div>
<div style="height:45px;line-height:45px;margin-top:20px;">
<a href="?iframe=label"><?php if(empty($key)){echo "<b>全部分类</b>";}else{echo "全部分类";} ?></a>
<?php
$sqlclass="select distinct (in_type) from ".tname('label');
$results=$db->query($sqlclass);
$label="&nbsp;|&nbsp;";
if($results){
while($row3 = $db->fetch_array($results)){
$label=$label."<a href=\"?iframe=label&action=keyword&key=".$row3['in_type']."\">";
if($key==$row3['in_type']){
$label=$label."<b>".$row3['in_type']."</b>";
}else{
$label=$label.$row3['in_type'];
}
$label=$label."</a>&nbsp;|&nbsp;";
}
}
echo ReplaceStr($label."]","&nbsp;|&nbsp;]","");
?>
</div>
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>标签代码</th>
<th>优先等级</th>
<th>标签描述</th>
<th>更新时间</th>
<th>编辑操作</th>
</tr>
<?php
if($count==0){
?>
<tr><td colspan="2">没有模板标签</td></tr>
<?php
}
if($result){
while($row = $db->fetch_array($result)){
?>
<tr class="hover">
<td><?php echo $row['in_id']; ?></td>
<td><a href="javascript:void(0)" id="copy<?php echo $row['in_id']; ?>" onclick="setcopy('<!--{label <?php echo $row['in_name']; ?>}-->', <?php echo $row['in_id']; ?>);" class="act">&lt;!--{label <?php echo $row['in_name']; ?>}--&gt;</a></td>
<td><?php echo $row['in_priority']; ?></td>
<td><?php echo $row['in_remark']; ?></td>
<td><?php if(date("Y-m-d",strtotime($row['in_addtime']))==date('Y-m-d')){echo "<em class=\"lightnum\">".$row['in_addtime']."</em>";}else{echo $row['in_addtime'];} ?></td>
<td><a href="?iframe=label&action=edit&in_id=<?php echo $row['in_id']; ?>" class="act">编辑</a><a href="?iframe=label&action=del&in_id=<?php echo $row['in_id']; ?>" class="act">删除</a></td>
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



<?php
}
	//删除
	function Del(){
		global $db;
		$in_id=intval(SafeRequest("in_id","get"));
		$sql="delete from ".tname('label')." where in_id=".$in_id;
		if($db->query($sql)){
			ShowMessage("恭喜您，模板标签删除成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
		}
	}

	//编辑
	function Edit(){
		global $db;
		$in_id=intval(SafeRequest("in_id","get"));
		$sql="select * from ".tname('label')." where in_id=".$in_id;
		if($row=$db->getrow($sql)){
			$Arr=array($row['in_name'],$row['in_type'],$row['in_remark'],$row['in_priority'],$row['in_selflable']);
		}
		EditBoard($Arr,"?iframe=label&action=saveedit&in_id=".$in_id,"编辑");
	}

	//添加数据
	function Add(){
		$Arr=array("","","","","");
		EditBoard($Arr,"?iframe=label&action=saveadd","新增");
	}

	//执行保存
	function SaveAdd(){
		if(!submitcheck('form')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_name = SafeRequest("in_name","post");
		$in_type = SafeRequest("in_type","post");
		$in_selflable = base64_encode(stripslashes(SafeRequest("in_selflable","post",1)));
		$in_remark = SafeRequest("in_remark","post");
		$in_priority = SafeRequest("in_priority","post");
		$setarr = array(
			'in_name' => $in_name,
			'in_type' => $in_type,
			'in_selflable' => $in_selflable,
			'in_remark' => $in_remark,
			'in_priority' => $in_priority,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('label', $setarr, 1);
		ShowMessage("恭喜您，模板标签新增成功！","?iframe=label","infotitle2",1000,1);
	}

	//保存编辑
	function SaveEdit(){
		if(!submitcheck('form')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_id = SafeRequest("in_id","get");
		$in_name = SafeRequest("in_name","post");
		$in_type = SafeRequest("in_type","post");
		$in_selflable = base64_encode(stripslashes(SafeRequest("in_selflable","post",1)));
		$in_remark = SafeRequest("in_remark","post");
		$in_priority = SafeRequest("in_priority","post");
		$setarr = array(
			'in_name' => $in_name,
			'in_type' => $in_type,
			'in_selflable' => $in_selflable,
			'in_remark' => $in_remark,
			'in_priority' => $in_priority,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		updatetable('label', $setarr, array('in_id'=>$in_id));
		ShowMessage("恭喜您，模板标签编辑成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
	}
?>
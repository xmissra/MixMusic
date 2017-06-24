<?php
if(!defined('IN_ROOT')){exit('Access denied');}
Administrator(7);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>友情链接</title>
<link href="static/admincp/css/main.css" rel="stylesheet" type="text/css" />
<link href="static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="static/pack/layer/lib.js"></script>
<script type="text/javascript">
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
function CheckAll(form) {
	for (var i = 0; i < form.elements.length; i++) {
		var e = form.elements[i];
		if (e.name != 'chkall') {
			e.checked = form.chkall.checked;
		}
	}
}
function exchange_type(theForm){
	if (theForm.in_type.value =='2'){
		layer.tips('请填写链接图片！', '#in_cover', {
			tips: [3, '#3595CC'],
			time: 3000
		});
		theForm.in_cover.focus();
		return false;
	}
}
function CheckForm(){
        if(document.form1.in_name.value==""){
            asyncbox.tips("站点名称不能为空，请填写！", "wait", 1000);
            document.form1.in_name.focus();
            return false;
        }
        else if(document.form1.in_url.value==""){
            asyncbox.tips("链接地址不能为空，请填写！", "wait", 1000);
            document.form1.in_url.focus();
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
	case 'editisindex':
		editisindex();
		break;
	case 'alleditsave':
		alleditsave();
		break;
	default:
		main("select * from ".tname('link')." order by in_order asc",20);
		break;
	}
?>
</body>
</html>
<?php
function EditBoard($Arr,$url,$arrname){
	$in_name = $Arr[0];
	$in_url = $Arr[1];
	$in_cover = $Arr[2];
	$in_type = !IsNum($Arr[3]) ? 1 : $Arr[3];
	$in_hide = !IsNum($Arr[4]) ? 0 : $Arr[4];
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'MixMusic 管理中心 - 系统 - <?php echo $arrname; ?>链接';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='系统&nbsp;&raquo;&nbsp;<?php echo $arrname; ?>链接';</script>
<div class="floattop">
<div class="itemtitle">
<ul class="tab1">
<li><a href="?iframe=link"><span>友情链接</span></a></li>
<?php if($_GET['action']=="add"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=link&action=add"><span>新增链接</span></a></li>
</ul></div></div>
<table class="tb tb2">
<form action="<?php echo $url; ?>" method="post" name="form1">
<tr><th colspan="15" class="partition"><?php echo $arrname; ?>链接</th></tr>
<tr><td colspan="2">站点名称:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $in_name; ?>" name="in_name" id="in_name"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">链接地址:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $in_url; ?>" name="in_url" id="in_url"></td><td class="vtop tips2">必须以“http://”开头</td></tr>
<tr><td colspan="2">链接类型:</td></tr>
<tr class="noborder"><td class="vtop rowform"><select name="in_type" id="in_type" onchange="exchange_type(this.form);" class="ps">
<option value="1"<?php if($in_type==1){echo " selected";} ?>>文字</option>
<option value="2"<?php if($in_type==2){echo " selected";} ?>>图片</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">链接图片:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $in_cover; ?>" name="in_cover" id="in_cover"></td><td class="vtop"><a href="javascript:void(0)" onclick="pop.up('no', '上传图片', 'source/pack/upload/open.php?type=link_cover&form=form1.in_cover', '406px', '180px', '175px');" class="addtr">上传图片</a></td></tr>
<tr><td colspan="2">链接状态:</td></tr>
<tr class="noborder"><td class="vtop rowform"><select name="in_hide" class="ps">
<option value="0"<?php if($in_hide==0){echo " selected";} ?>>显示</option>
<option value="1"<?php if($in_hide==1){echo " selected";} ?>>隐藏</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" class="btn" name="link" onclick="return CheckForm();" value="提交" /></div></td></tr>
</form>
</table>
</div>


<?php
}
function main($sql,$size){
	global $db;
	$Arr=getpagerow($sql,$size);
	$result=$Arr[1];
	$count=$Arr[2];
?>
<div class="container">
<script type="text/javascript">parent.document.title = 'MixMusic 管理中心 - 系统 - 友情链接';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='系统&nbsp;&raquo;&nbsp;友情链接';</script>
<div class="floattop">
<div class="itemtitle">
<ul class="tab1">
<li class="current"><a href="?iframe=link"><span>友情链接</span></a></li>
<li><a href="?iframe=link&action=add"><span>新增链接</span></a></li>
</ul></div></div>
<form name="form" method="post" action="?iframe=link&action=alleditsave">
<table class="tb tb2">
<tr><th class="partition">链接列表</th></tr>
</table>
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>站点名称</th>
<th>链接地址</th>
<th>排序</th>
<th>类型</th>
<th>状态</th>
<th>编辑操作</th>
</tr>
<?php
if($count==0){
?>
<tr><td colspan="2">没有友情链接</td></tr>
<?php
}
if($result){
while($row = $db->fetch_array($result)){
?>
<tr class="hover">
<td class="width-50"><input class="checkbox" type="checkbox" name="in_id[]" id="in_id" value="<?php echo $row['in_id']; ?>"><?php echo $row['in_id']; ?></td>
<td><input type="text" class="txt" name="in_name<?php echo $row['in_id']; ?>" value="<?php echo $row['in_name']; ?>"></td>
<td><input type="text" class="txt" name="in_url<?php echo $row['in_id']; ?>" value="<?php echo $row['in_url']; ?>"></td>
<td><input type="text" class="txt" name="in_order<?php echo $row['in_id']; ?>" value="<?php echo $row['in_order']; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
<td><?php if($row['in_type']==1){echo "文字";}else{echo "<em class=\"lightnum\">图片</em>";} ?></td>
<td><?php if($row['in_hide']==1){ ?><a href="?iframe=link&action=editisindex&in_hide=0&in_id=<?php echo $row['in_id']; ?>"><img src="static/admincp/css/show_no.gif" /></a><?php }else{ ?><a href="?iframe=link&action=editisindex&in_hide=1&in_id=<?php echo $row['in_id']; ?>"><img src="static/admincp/css/show_yes.gif" /></a><?php } ?></td>
<td><a href="?iframe=link&action=edit&in_id=<?php echo $row['in_id']; ?>" class="act">编辑</a><a href="?iframe=link&action=del&in_id=<?php echo $row['in_id']; ?>" class="act">删除</a></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form);" /><label for="chkall">全选</label> &nbsp;&nbsp; <input type="submit" name="form" class="btn" value="提交修改" /></td></tr>
<?php echo $Arr[0]; ?>
</table>
</form>
</div>



<?php
}
	//删除
	function Del(){
		global $db;
		$in_id=intval(SafeRequest("in_id","get"));
		SafeDel('link', 'in_cover', $in_id);
		$sql="delete from ".tname('link')." where in_id=".$in_id;
		if($db->query($sql)){
			ShowMessage("恭喜您，友情链接删除成功！","?iframe=link","infotitle2",1000,1);
		}
	}

	//编辑
	function Edit(){
		global $db;
		$in_id=intval(SafeRequest("in_id","get"));
		$sql="select * from ".tname('link')." where in_id=".$in_id;
		if($row=$db->getrow($sql)){
			$Arr=array($row['in_name'],$row['in_url'],$row['in_cover'],$row['in_type'],$row['in_hide']);
		}
		EditBoard($Arr,"?iframe=link&action=saveedit&in_id=".$in_id,"编辑");
	}

	//添加数据
	function Add(){
		$Arr=array("","","","","");
		EditBoard($Arr,"?iframe=link&action=saveadd","新增");
	}

	//执行保存
	function SaveAdd(){
		if(!submitcheck('link')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_name = SafeRequest("in_name","post");
		$in_url = SafeRequest("in_url","post");
		$in_cover = checkrename(SafeRequest("in_cover","post"), 'attachment/link/cover');
		$in_type = SafeRequest("in_type","post");
		$in_hide = SafeRequest("in_hide","post");
		$setarr = array(
			'in_name' => $in_name,
			'in_url' => $in_url,
			'in_cover' => $in_cover,
			'in_type' => $in_type,
			'in_hide' => $in_hide,
			'in_order' => 0
		);
		inserttable('link', $setarr, 1);
		ShowMessage("恭喜您，友情链接新增成功！","?iframe=link","infotitle2",1000,1);
	}

	//保存编辑
	function SaveEdit(){
		if(!submitcheck('link')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_id = SafeRequest("in_id","get");
		$in_name = SafeRequest("in_name","post");
		$in_url = SafeRequest("in_url","post");
		$in_cover = checkrename(SafeRequest("in_cover","post"), 'attachment/link/cover', getfield('link', 'in_cover', 'in_id', $in_id), 'edit', 'link', 'in_cover', $in_id);
		$in_type = SafeRequest("in_type","post");
		$in_hide = SafeRequest("in_hide","post");
		$setarr = array(
			'in_name' => $in_name,
			'in_url' => $in_url,
			'in_cover' => $in_cover,
			'in_type' => $in_type,
			'in_hide' => $in_hide
		);
		updatetable('link', $setarr, array('in_id'=>$in_id));
		ShowMessage("恭喜您，友情链接编辑成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
	}

	function editisindex(){
		global $db;
		$in_id = intval(SafeRequest("in_id","get"));
		$in_hide = intval(SafeRequest("in_hide","get"));
		$sql="update ".tname('link')." set in_hide=".$in_hide." where in_id=".$in_id;
		if($db->query($sql)){
			ShowMessage("恭喜您，状态切换成功！","?iframe=link","infotitle2",1000,1);
		}
	}

	function alleditsave(){
		if(!submitcheck('form')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_id = RequestBox("in_id");
		if($in_id==0){
			ShowMessage("修改失败，请先勾选要编辑的友情链接！","?iframe=link","infotitle3",3000,1);
		}else{
			$ID=explode(",",$in_id);
			for($i=0;$i<count($ID);$i++){
				$in_name=SafeRequest("in_name".$ID[$i],"post");
				$in_url=SafeRequest("in_url".$ID[$i],"post");
				$in_order=SafeRequest("in_order".$ID[$i],"post");
				if(!IsNul($in_name)){ShowMessage("修改出错，站点名称不能为空！","?iframe=link","infotitle3",1000,1);}
				if(!IsNul($in_url)){ShowMessage("修改出错，链接地址不能为空！","?iframe=link","infotitle3",1000,1);}
				if(!IsNum($in_order)){ShowMessage("修改出错，排序不能为空！","?iframe=link","infotitle3",1000,1);}
				$setarr = array(
					'in_name' => $in_name,
					'in_url' => $in_url,
					'in_order' => $in_order
				);
				updatetable('link', $setarr, array('in_id'=>$ID[$i]));
			}
			ShowMessage("恭喜您，友情链接修改成功！","?iframe=link","infotitle2",1000,1);
		}
	}
?>
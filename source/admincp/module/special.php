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
<title>专辑管理</title>
<link href="static/admincp/css/main.css" rel="stylesheet" type="text/css" />
<link href="static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="static/pack/layer/lib.js"></script>
<script type="text/javascript">
function CheckAll(form, type) {
	for (var i = 0; i < form.elements.length; i++) {
		var e = form.elements[i];
		if (e.name != 'chkall') {
			e.checked = form.chkall.checked;
		}
	}
	if(type==1){
		all_save(form);
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
	case 'alldel':
		AllDel();
		break;
	case 'editpassed':
		EditPassed();
		break;
	case 'class':
		ClassMain();
		break;
	case 'delclass':
		DelClass();
		break;
	case 'edithideclass':
		EditHideClass();
		break;
	case 'editsaveclass':
		EditSaveClass();
		break;
	case 'saveaddclass':
		SaveAddClass();
		break;
	case 'list':
		$in_classid=intval(SafeRequest("in_classid","get"));
		main("select * from ".tname('special')." where in_classid=".$in_classid." order by in_addtime desc",20);
		break;
	case 'singer':
		$in_singerid=intval(SafeRequest("in_singerid","get"));
		main("select * from ".tname('special')." where in_singerid=".$in_singerid." order by in_addtime desc",20);
		break;
	case 'keyword':
		$key=SafeRequest("key","get");
		main("select * from ".tname('special')." where in_name like '%".$key."%' or in_uname like '%".$key."%' order by in_addtime desc",20);
		break;
	case 'pass':
		main("select * from ".tname('special')." where in_passed=1 order by in_addtime desc",20);
		break;
	default:
		main("select * from ".tname('special')." order by in_addtime desc",20);
		break;
	}
?>
</body>
</html>
<?php
function EditBoard($Arr,$url,$arrname){
	global $db,$action;
	$one = $db->getone("select in_userid from ".tname('user')." where in_username='".$_COOKIE['in_adminname']."'");
	$in_name = $Arr[0];
	$in_classid = $Arr[1];
	$in_singerid = $Arr[2];
	$in_uname = !IsNul($Arr[3]) && $one ? $_COOKIE['in_adminname'] : $Arr[3];
	$in_cover = $Arr[4];
	$in_intro = $Arr[5];
	$in_firm = $Arr[6];
	$in_lang = $Arr[7];
?>
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
function CheckForm(){
        if(document.form2.in_name.value==""){
            asyncbox.tips("专辑名称不能为空，请填写！", "wait", 1000);
            document.form2.in_name.focus();
            return false;
        }
        else if(document.form2.in_classid.value=="0"){
            asyncbox.tips("所属栏目不能为空，请选择！", "wait", 1000);
            document.form2.in_classid.focus();
            return false;
        }
        else if(document.form2.in_uname.value==""){
            asyncbox.tips("所属会员不能为空，请填写！", "wait", 1000);
            document.form2.in_uname.focus();
            return false;
        }
        else {
            return true;
        }
}
</script>
<div class="container">
<script type="text/javascript">parent.document.title = 'MixMusic 管理中心 - 内容 - <?php echo $arrname; ?>专辑';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;<?php echo $arrname; ?>专辑';</script>
<div class="floattop">
<div class="itemtitle">
<ul class="tab1">
<li><a href="?iframe=special"><span>所有专辑</span></a></li>
<?php if($action=="add"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=special&action=add"><span>新增专辑</span></a></li>
<li><a href="?iframe=special&action=pass"><span>待审专辑</span></a></li>
<li><a href="?iframe=special&action=class"><span>专辑栏目</span></a></li>
</ul></div></div>
<form action="<?php echo $url; ?>" method="post" name="form2">
<table class="tb tb2">
<tr>
<td>专辑名称：<input type="text" class="txt width-200" value="<?php echo $in_name; ?>" name="in_name" id="in_name"></td>
<td>所属栏目：<select name="in_classid" id="in_classid">
<option value="0">选择栏目</option>
<?php
$sql="select * from ".tname('special_class')." order by in_id asc";
$result=$db->query($sql);
if($result){
while ($row = $db->fetch_array($result)){
if($in_classid==$row['in_id']){
echo "<option value=\"".$row['in_id']."\" selected=\"selected\">".$row['in_name']."</option>";
}else{
echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
}
}
}
?>
</select></td>
</tr>

<tr>
<td>所属歌手：<select name="in_singerid" id="in_singerid">
<option value="0">不选择</option>
<?php
$res=$db->query("select * from ".tname('singer')." order by in_addtime desc");
if($res){
        while ($row = $db->fetch_array($res)){
                if($in_singerid==$row['in_id']){
                        echo "<option value=\"".$row['in_id']."\" selected=\"selected\">".getlenth($row['in_name'], 10)."</option>";
                }else{
                        echo "<option value=\"".$row['in_id']."\">".getlenth($row['in_name'], 10)."</option>";
                }
        }
}
?>
</select>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="pop.up('yes', '选择歌手', 'source/pack/tag/singer_opt.php?so=form2.in_singerid', '500px', '400px', '65px');" class="addtr">选择</a></td>
<td>所属会员：<input type="text" class="txt" value="<?php echo $in_uname; ?>" name="in_uname" id="in_uname"></td>
</tr>

<tr>
<td>发行公司：<input type="text" class="txt" value="<?php echo $in_firm; ?>" name="in_firm" id="in_firm"></td>
<td>所属语言：<select name="in_lang" id="in_lang">
<option value="其它">其它</option>
<option value="国语"<?php if($in_lang=="国语"){echo " selected";} ?>>国语</option>
<option value="粤语"<?php if($in_lang=="粤语"){echo " selected";} ?>>粤语</option>
<option value="闽语"<?php if($in_lang=="闽语"){echo " selected";} ?>>闽语</option>
<option value="英语"<?php if($in_lang=="英语"){echo " selected";} ?>>英语</option>
<option value="日语"<?php if($in_lang=="日语"){echo " selected";} ?>>日语</option>
<option value="韩语"<?php if($in_lang=="韩语"){echo " selected";} ?>>韩语</option>
</select></td>
</tr>

<tr>
<td class="longtxt">封面地址：<input type="text" class="txt" value="<?php echo $in_cover; ?>" name="in_cover" id="in_cover"></td><td><input class="btn" type="button" value="上传封面" onclick="pop.up('no', '上传封面', 'source/pack/upload/open.php?type=special_cover&form=form2.in_cover', '406px', '180px', '175px');" /></td>
</tr>
</table>

<table class="tb tb2">
<tr><td><div style="height:100px;line-height:100px;float:left;">专辑介绍：</div><textarea rows="6" cols="50" id="in_intro" name="in_intro" style="width:400px;height:100px;"><?php echo $in_intro; ?></textarea></td></tr>
<tr><td><input type="submit" class="btn" name="form2" value="提交" onclick="return CheckForm();" /><?php if($_GET['action']=="edit"){ ?><input type="hidden" name="in_addtime" value="<?php echo $Arr[8]; ?>"><input class="checkbox" type="checkbox" name="in_edittime" id="in_edittime" value="1" checked /><label for="in_edittime">更新时间</label><?php } ?></td></tr>
</table>
</form>
</div>


<?php
}
function main($sql,$size){
	global $db,$action;
	$Arr=getpagerow($sql,$size);
	$result=$Arr[1];
	$count=$Arr[2];
?>
<link href="static/pack/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/pack/fancybox/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="static/pack/fancybox/jquery.fancybox.pack.js"></script>
<script type="text/javascript">
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
function all_save(form){
        if(form.chkall.checked){
		layer.tips('删除专辑不可逆，请谨慎操作！', '#chkall', {
			tips: 3
		});
        }
}
</script>
<div class="container">
<?php if(empty($action)){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 内容 - 所有专辑';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;所有专辑';</script>";} ?>
<?php if($action=="pass"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 内容 - 待审专辑';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;待审专辑';</script>";} ?>
<?php if($action=="keyword"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 内容 - 搜索专辑';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;搜索专辑';</script>";} ?>
<?php if($action=="list"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 内容 - 栏目专辑';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;栏目专辑';</script>";} ?>
<?php if($action=="singer"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 内容 - 歌手专辑';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;歌手专辑';</script>";} ?>
<div class="floattop">
<div class="itemtitle">
<ul class="tab1">
<?php if(empty($action)){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=special"><span>所有专辑</span></a></li>
<li><a href="?iframe=special&action=add"><span>新增专辑</span></a></li>
<?php if($action=="pass"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=special&action=pass"><span>待审专辑</span></a></li>
<li><a href="?iframe=special&action=class"><span>专辑栏目</span></a></li>
</ul></div></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<?php
if(empty($action)){
echo "<li>以下是所有的专辑</li>";
}elseif($action=="pass"){
echo "<li>以下是需要审核的专辑，不会在前台显示</li>";
}elseif($action=="keyword"){
echo "<li>以下是搜索“".SafeRequest("key","get")."”的专辑</li>";
}elseif($action=="list"){
echo "<li>以下是按栏目查看的专辑</li>";
}elseif($action=="singer"){
echo "<li>以下是按歌手查看的专辑</li>";
}
?>
<li>可以输入专辑名称、所属会员等关键词进行搜索</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<form name="btnsearch" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<tr><td>
<input type="hidden" name="iframe" value="special">
<input type="hidden" name="action" value="keyword">
关键词：<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<select onchange="location.href=this.options[this.selectedIndex].value;">
<option value="?iframe=special">不限栏目</option>
<?php
$res=$db->query("select * from ".tname('special_class')." order by in_id asc");
if($res){
        while($row = $db->fetch_array($res)){
                if(SafeRequest("in_classid","get")==$row['in_id']){
                        echo "<option value=\"?iframe=special&action=list&in_classid=".$row['in_id']."\" selected=\"selected\">".$row['in_name']."</option>";
                }else{
                        echo "<option value=\"?iframe=special&action=list&in_classid=".$row['in_id']."\">".$row['in_name']."</option>";
                }
        }
}
?>
</select>
<select onchange="location.href=this.options[this.selectedIndex].value;">
<option value="?iframe=special">不限歌手</option>
<?php
$res=$db->query("select * from ".tname('singer')." order by in_addtime desc");
if($res){
        while($row = $db->fetch_array($res)){
                if(SafeRequest("in_singerid","get")==$row['in_id']){
                        echo "<option value=\"?iframe=special&action=singer&in_singerid=".$row['in_id']."\" selected=\"selected\">".getlenth($row['in_name'], 10)."</option>";
                }else{
                        echo "<option value=\"?iframe=special&action=singer&in_singerid=".$row['in_id']."\">".getlenth($row['in_name'], 10)."</option>";
                }
        }
}
?>
</select>
<input type="button" value="搜索" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<form name="form" method="post" action="?iframe=special&action=alldel">
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>专辑封面</th>
<th>专辑名称</th>
<th>所属会员</th>
<th>审核</th>
<th>更新时间</th>
<th>编辑操作</th>
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
<script type="text/javascript">
$(document).ready(function() {
	$("#thumb<?php echo $row['in_id']; ?>").fancybox({
		'overlayColor': '#000',
		'overlayOpacity': 0.1,
		'overlayShow': true,
		'transitionIn': 'elastic',
		'transitionOut': 'elastic'
	});
});
</script>
<tr class="hover">
<td class="width-50"><input class="checkbox" type="checkbox" name="in_id[]" id="in_id" value="<?php echo $row['in_id']; ?>"><?php echo $row['in_id']; ?></td>
<td><a href="<?php echo geturl($row['in_cover'], 'cover'); ?>" id="thumb<?php echo $row['in_id']; ?>"><img src="<?php echo geturl($row['in_cover'], 'cover'); ?>" width="25" height="25" /></a></td>
<td><a href="<?php echo getlink($row['in_id'], 'special'); ?>" target="_blank" class="act"><?php echo ReplaceStr($row['in_name'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><a href="<?php echo getlink($row['in_uid']); ?>" target="_blank" class="act"><?php echo ReplaceStr($row['in_uname'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><?php if($row['in_passed']==1){ ?><a href="?iframe=special&action=editpassed&in_id=<?php echo $row['in_id']; ?>"><img src="static/admincp/css/pass_no.gif" /></a><?php }else{ ?><img src="static/admincp/css/pass_yes.gif" /><?php } ?></td>
<td><?php if(date('Y-m-d',strtotime($row['in_addtime']))==date('Y-m-d')){echo "<em class=\"lightnum\">".date('Y-m-d',strtotime($row['in_addtime']))."</em>";}else{echo date('Y-m-d',strtotime($row['in_addtime']));} ?></td>
<td><a href="?iframe=special&action=edit&in_id=<?php echo $row['in_id']; ?>" class="act">编辑</a></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form, 1);" /><label for="chkall">全选</label> &nbsp;&nbsp; <input type="submit" name="form" class="btn" value="批量删除" /></td></tr>
<?php echo $Arr[0]; ?>
</table>
</form>
</div>


<?php
}
function ClassMain(){
	global $db;
	$sql="select * from ".tname('special_class')." order by in_id asc";
	$result=$db->query($sql);
	$count=$db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
?>
<script type="text/javascript">
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
</script>
<div class="container">
<script type="text/javascript">parent.document.title = 'MixMusic 管理中心 - 内容 - 专辑栏目';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;专辑栏目';</script>
<div class="floattop">
<div class="itemtitle">
<ul class="tab1">
<li><a href="?iframe=special"><span>所有专辑</span></a></li>
<li><a href="?iframe=special&action=add"><span>新增专辑</span></a></li>
<li><a href="?iframe=special&action=pass"><span>待审专辑</span></a></li>
<li class="current"><a href="?iframe=special&action=class"><span>专辑栏目</span></a></li>
</ul></div></div>
<table class="tb tb2">
<tr><th class="partition">栏目管理</th></tr>
</table>
<form name="form" method="post" action="?iframe=special&action=editsaveclass">
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>栏目名称</th>
<th>专辑统计</th>
<th>排序</th>
<th>状态</th>
<th>编辑操作</th>
</tr>
<?php
if($count==0){
?>
<tr><td colspan="2">没有专辑栏目</td></tr>
<?php
}
if($result){
while($row = $db->fetch_array($result)){
?>
<tr class="hover">
<td class="width-50"><input class="checkbox" type="checkbox" name="in_id[]" id="in_id" value="<?php echo $row['in_id']; ?>"><?php echo $row['in_id']; ?></td>
<td><div class="parentboard"><input type="text" name="in_name<?php echo $row['in_id']; ?>" value="<?php echo $row['in_name']; ?>" class="txt" /></div></td>
<td><a href="?iframe=special&action=list&in_classid=<?php echo $row['in_id']; ?>" class="act">
<?php
$nums = $db->num_rows($db->query("select count(*) from ".tname('special')." where in_classid=".$row['in_id']));
echo $nums;
?>
</a></td>
<td class="width-50"><input type="text" name="in_order<?php echo $row['in_id']; ?>" value="<?php echo $row['in_order']; ?>" class="txt" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td>
<td>
<?php if($row['in_hide']==1){ ?>
<a href="?iframe=special&action=edithideclass&in_id=<?php echo $row['in_id']; ?>&in_hide=0"><img src="static/admincp/css/show_no.gif" /></a>
<?php }else{ ?>
<a href="?iframe=special&action=edithideclass&in_id=<?php echo $row['in_id']; ?>&in_hide=1"><img src="static/admincp/css/show_yes.gif" /></a>
<?php } ?>
</td>
<td><input type="button" class="btn" value="删除" onclick="location.href='?iframe=special&action=delclass&in_id=<?php echo $row['in_id']; ?>';" /></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td class="width-50"><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form, 0);" /><label for="chkall">全选</label></td><td colspan="15"><div class="fixsel"><input type="submit" class="btn" name="form" value="提交修改" /></div></td></tr>
</table>
</form>

<table class="tb tb2">
<tr><th class="partition">新增栏目</th></tr>
</table>
<form name="form1" method="post" action="?iframe=special&action=saveaddclass">
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
</div>



<?php
}
	//审核
	function EditPassed(){
		global $db;
		$in_id = intval(SafeRequest("in_id","get"));
		$row = $db->getrow("select * from ".tname('special')." where in_id=".$in_id);
		$db->query("update ".tname('user')." set in_points=in_points+".IN_SPECIALINPOINTS.",in_rank=in_rank+".IN_SPECIALINRANK." where in_userid=".$row['in_uid']);
		$setarrs = array(
			'in_uid' => 0,
			'in_uname' => '系统用户',
			'in_uids' => $row['in_uid'],
			'in_unames' => $row['in_uname'],
			'in_content' => '恭喜，您制作的专辑“'.$row['in_name'].'”已通过审核！[金币+'.IN_SPECIALINPOINTS.'][经验+'.IN_SPECIALINRANK.']',
			'in_isread' => 0,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('message', $setarrs, 1);
		$sql="update ".tname('special')." set in_passed=0 where in_id=".$row['in_id'];
		if($db->query($sql)){
			ShowMessage("恭喜您，专辑审核成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
		}
	}

	//批量删除
	function AllDel(){
		global $db;
		if(!submitcheck('form')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_id=RequestBox("in_id");
		if($in_id==0){
			ShowMessage("批量删除失败，请先勾选要删除的专辑！",$_SERVER['HTTP_REFERER'],"infotitle3",3000,1);
		}else{
			$query = $db->query("select * from ".tname('special')." where in_id in ($in_id)");
			while ($row = $db->fetch_array($query)) {
				SafeDel('special', 'in_cover', $row['in_id']);
				$db->query("delete from ".tname('comment')." where in_table='special' and in_tid=".$row['in_id']);
				$db->query("delete from ".tname('feed')." where in_icon='special' and in_tid=".$row['in_id']);
				$content='抱歉，您制作的专辑“'.$row['in_name'].'”未通过审核并被删除！';
				if($row['in_passed']==0){
		                        $db->query("update ".tname('user')." set in_points=in_points-".IN_SPECIALOUTPOINTS.",in_rank=in_rank-".IN_SPECIALOUTRANK." where in_userid=".$row['in_uid']);
		                        $content='抱歉，您制作的专辑“'.$row['in_name'].'”被删除！[金币-'.IN_SPECIALOUTPOINTS.'][经验-'.IN_SPECIALOUTRANK.']';
				}
				$setarrs = array(
		                        'in_uid' => 0,
		                        'in_uname' => '系统用户',
		                        'in_uids' => $row['in_uid'],
		                        'in_unames' => $row['in_uname'],
		                        'in_content' => $content,
		                        'in_isread' => 0,
		                        'in_addtime' => date('Y-m-d H:i:s')
				);
				inserttable('message', $setarrs, 1);
			}
			$sql="delete from ".tname('special')." where in_id in ($in_id)";
			if($db->query($sql)){
				ShowMessage("恭喜您，专辑批量删除成功！",$_SERVER['HTTP_REFERER'],"infotitle2",3000,1);
			}
		}
	}

	//编辑
	function Edit(){
		global $db;
		$in_id=intval(SafeRequest("in_id","get"));
		$sql="select * from ".tname('special')." where in_id=".$in_id;
		if($row=$db->getrow($sql)){
			$Arr=array($row['in_name'],$row['in_classid'],$row['in_singerid'],$row['in_uname'],$row['in_cover'],$row['in_intro'],$row['in_firm'],$row['in_lang'],$row['in_addtime']);
		}
		EditBoard($Arr,"?iframe=special&action=saveedit&in_id=".$in_id,"编辑");
	}

	//添加数据
	function Add(){
		$Arr=array("","","","","","","","","");
		EditBoard($Arr,"?iframe=special&action=saveadd","新增");
	}

	//保存添加数据
	function SaveAdd(){
		global $db;
		if(!submitcheck('form2')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_name = SafeRequest("in_name","post");
		$in_classid = SafeRequest("in_classid","post");
		$in_singerid = SafeRequest("in_singerid","post");
		$in_uname = SafeRequest("in_uname","post");
		$in_cover = checkrename(SafeRequest("in_cover","post"), 'attachment/special/cover');
		$in_intro = SafeRequest("in_intro","post");
		$in_firm = SafeRequest("in_firm","post");
		$in_lang = SafeRequest("in_lang","post");
		$result=$db->query("select * from ".tname('user')." where in_username='".$in_uname."'");
		if($row=$db->fetch_array($result)){
			$db->query("Insert ".tname('special')." (in_name,in_classid,in_singerid,in_uid,in_uname,in_cover,in_intro,in_firm,in_lang,in_hits,in_passed,in_addtime) values ('".$in_name."',".$in_classid.",".$in_singerid.",".$row['in_userid'].",'".$row['in_username']."','".$in_cover."','".$in_intro."','".$in_firm."','".$in_lang."',0,0,'".date('Y-m-d H:i:s')."')");
			$db->query("update ".tname('user')." set in_points=in_points+".IN_SPECIALINPOINTS.",in_rank=in_rank+".IN_SPECIALINRANK." where in_userid=".$row['in_userid']);
			ShowMessage("恭喜您，专辑新增成功！","?iframe=special","infotitle2",1000,1);
		}else{
			ShowMessage("新增失败，所属会员不存在！","history.back(1);","infotitle3",3000,2);
		}
	}

	//保存编辑数据
	function SaveEdit(){
		global $db;
		if(!submitcheck('form2')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_id = intval(SafeRequest("in_id","get"));
		$in_name = SafeRequest("in_name","post");
		$in_classid = SafeRequest("in_classid","post");
		$in_singerid = SafeRequest("in_singerid","post");
		$in_uname = SafeRequest("in_uname","post");
		$in_cover = checkrename(SafeRequest("in_cover","post"), 'attachment/special/cover', getfield('special', 'in_cover', 'in_id', $in_id), 'edit', 'special', 'in_cover', $in_id);
		$in_intro = SafeRequest("in_intro","post");
		$in_firm = SafeRequest("in_firm","post");
		$in_lang = SafeRequest("in_lang","post");
		$datetime = SafeRequest("in_edittime","post")==1 ? date('Y-m-d H:i:s') : SafeRequest("in_addtime","post");
		$old=$db->getrow("select * from ".tname('special')." where in_id=".$in_id);
		$result=$db->query("select * from ".tname('user')." where in_username='".$in_uname."'");
		if($row=$db->fetch_array($result)){
			if($old['in_passed']==0 && $old['in_uid']!==$row['in_userid']){
			        $db->query("update ".tname('user')." set in_points=in_points+".IN_SPECIALINPOINTS.",in_rank=in_rank+".IN_SPECIALINRANK." where in_userid=".$row['in_userid']);
			        $db->query("update ".tname('user')." set in_points=in_points-".IN_SPECIALOUTPOINTS.",in_rank=in_rank-".IN_SPECIALOUTRANK." where in_userid=".$old['in_uid']);
			}
			$db->query("update ".tname('special')." set in_name='".$in_name."',in_classid=".$in_classid.",in_singerid=".$in_singerid.",in_uid=".$row['in_userid'].",in_uname='".$row['in_username']."',in_cover='".$in_cover."',in_intro='".$in_intro."',in_firm='".$in_firm."',in_lang='".$in_lang."',in_addtime='".$datetime."' where in_id=".$in_id);
			ShowMessage("恭喜您，专辑编辑成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
		}else{
			ShowMessage("编辑失败，所属会员不存在！","history.back(1);","infotitle3",3000,2);
		}
	}

	//添加栏目
	function SaveAddClass(){
		global $db;
		if(!submitcheck('form1')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_name=SafeRequest("in_name","post");
		$in_order=SafeRequest("in_order","post");
		$sql="Insert ".tname('special_class')." (in_name,in_hide,in_order) values ('".$in_name."',0,".$in_order.")";
		if($db->query($sql)){
			ShowMessage("恭喜您，专辑栏目新增成功！","?iframe=special&action=class","infotitle2",1000,1);
		}
	}

	//编辑栏目
	function EditSaveClass(){
		global $db;
		if(!submitcheck('form')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_id=RequestBox("in_id");
		if($in_id==0){
			ShowMessage("修改失败，请先勾选要编辑的栏目！","?iframe=special&action=class","infotitle3",3000,1);
		}else{
			$ID=explode(",",$in_id);
			for($i=0;$i<count($ID);$i++){
				$in_name=SafeRequest("in_name".$ID[$i],"post");
				$in_order=SafeRequest("in_order".$ID[$i],"post");
				if(!IsNul($in_name)){ShowMessage("修改出错，栏目名称不能为空！","?iframe=special&action=class","infotitle3",1000,1);}
				if(!IsNum($in_order)){ShowMessage("修改出错，排序不能为空！","?iframe=special&action=class","infotitle3",1000,1);}
				$sql="update ".tname('special_class')." set in_name='".$in_name."',in_order=".intval($in_order)." where in_id=".intval($ID[$i]);
				$db->query($sql);
			}
			ShowMessage("恭喜您，专辑栏目修改成功！","?iframe=special&action=class","infotitle2",3000,1);
		}
	}

	//栏目状态
	function EditHideClass(){
		global $db;
		$in_id=intval(SafeRequest("in_id","get"));
		$in_hide=intval(SafeRequest("in_hide","get"));
		$sql="update ".tname('special_class')." set in_hide=".$in_hide." where in_id=".$in_id;
		if($db->query($sql)){
			ShowMessage("恭喜您，状态切换成功！","?iframe=special&action=class","infotitle2",1000,1);
		}
	}

	//删除栏目
	function DelClass(){
		global $db;
		$in_id=intval(SafeRequest("in_id","get"));
		$sql="delete from ".tname('special_class')." where in_id=".$in_id;
		if($db->query($sql)){
			ShowMessage("恭喜您，专辑栏目删除成功！","?iframe=special&action=class","infotitle2",3000,1);
		}
	}
?>
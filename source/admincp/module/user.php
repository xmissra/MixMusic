<?php
if(!defined('IN_ROOT')){exit('Access denied');}
Administrator(5);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>用户</title>
<link href="static/admincp/css/main.css" rel="stylesheet" type="text/css" />
<link href="static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="static/pack/asynctips/asyncbox.v1.4.5.js"></script>
</head>
<body>
<?php
switch($action){
	case 'edit':
		Edit();
		break;
	case 'saveedit':
		SaveEdit();
		break;
	case 'allsave':
		AllSave();
		break;
	case 'keyword':
		$key=SafeRequest("key","get");
		main("select * from ".tname('user')." where in_username like '%".$key."%' or in_mail like '%".$key."%' order by in_regdate desc",20);
		break;
	case 'vip':
		main("select * from ".tname('user')." where in_grade=1 order by in_regdate desc",20);
		break;
	case 'lock':
		main("select * from ".tname('user')." where in_islock=1 order by in_regdate desc",20);
		break;
	case 'star':
		main("select * from ".tname('user')." where in_isstar=1 order by in_regdate desc",20);
		break;
	case 'staring':
		main("select * from ".tname('user')." where in_isstar=2 order by in_regdate desc",20);
		break;
	default:
		main("select * from ".tname('user')." order by in_regdate desc",20);
		break;
	}
?>
</body>
</html>
<?php
function EditBoard($Arr,$url){
	global $db;
	$music=$db->num_rows($db->query("select count(*) from ".tname('music')." where in_uid=".$Arr[0]));
	$special=$db->num_rows($db->query("select count(*) from ".tname('special')." where in_uid=".$Arr[0]));
	$singer=$db->num_rows($db->query("select count(*) from ".tname('singer')." where in_uid=".$Arr[0]));
	$video=$db->num_rows($db->query("select count(*) from ".tname('video')." where in_uid=".$Arr[0]));
	$article=$db->num_rows($db->query("select count(*) from ".tname('article')." where in_uid=".$Arr[0]));//新增Article模块
	$in_username = $Arr[1];
	$in_mail = $Arr[2];
	$in_ismail = $Arr[3];
	$in_sex = $Arr[4];
	$in_birthday = $Arr[5];
	$in_address = $Arr[6];
	$in_introduce = $Arr[7];
	$in_islock = $Arr[8];
	$in_isstar = $Arr[9];
	$in_points = $Arr[10];
	$in_rank = $Arr[11];
	$in_grade = $Arr[12];
	$in_vipgrade = $Arr[13];
	$in_vipindate = !IsNul($Arr[14]) ? "0000-00-00 00:00:00" : $Arr[14];
	$in_vipenddate = !IsNul($Arr[15]) ? "0000-00-00 00:00:00" : $Arr[15];
	$in_qqopen = $Arr[16];
	$in_avatar = $Arr[17];
	$birthday = explode("-",$in_birthday);
        $year = isset($birthday[0]) ? $birthday[0] : NULL;
        $month = isset($birthday[1]) ? $birthday[1] : NULL;
        $day = isset($birthday[2]) ? $birthday[2] : NULL;
	$address = explode("-",$in_address);
	$province = isset($address[0]) ? $address[0] : NULL;
	$city = isset($address[1]) ? $address[1] : NULL;
?>
<script type="text/javascript" src="static/pack/layer/laydate/laydate.js"></script>
<script type="text/javascript" src="static/pack/city/city.js"></script>
<script type="text/javascript">
function CheckForm(){
        var grade=document.getElementsByName("in_grade");
        var gradeNew;
        for(var i=0;i<grade.length;i++){
	        if(grade.item(i).checked){
		        gradeNew=grade.item(i).getAttribute("value");
		        break;
	        }else{
		        continue;
	        }
        }
        var vipgrade=document.getElementsByName("in_vipgrade");
        var vipgradeNew;
        for(var i=0;i<vipgrade.length;i++){
	        if(vipgrade.item(i).checked){
		        vipgradeNew=vipgrade.item(i).getAttribute("value");
		        break;
	        }else{
		        continue;
	        }
        }
        if(gradeNew==1){
                if(!vipgradeNew){
		        asyncbox.tips("请选择绿钻类型！", "wait", 1000);
		        return false;
	        }
	        if(document.form2.in_vipindate.value=="" || document.form2.in_vipindate.value=="0000-00-00 00:00:00"){
		        asyncbox.tips("请填写绿钻开通日期！", "wait", 1000);
		        document.form2.in_vipindate.focus();
		        return false;
	        }
	        if(document.form2.in_vipenddate.value=="" || document.form2.in_vipenddate.value=="0000-00-00 00:00:00"){
		        asyncbox.tips("请填写绿钻结束日期！", "wait", 1000);
		        document.form2.in_vipenddate.focus();
		        return false;
	        }
        }
}
function change(type){
	if(type==1){
		vipopen.style.display='';
        }else{
		vipopen.style.display='none';
        }
}
function getvipdate(type){
	if (type==1){
		document.form2.in_vipindate.value = "<?php echo date('Y-m-d H:i:s'); ?>";
		document.form2.in_vipenddate.value = "<?php echo date('Y-m-d H:i:s',mktime(date('H'),date('i'),date('s'),date('m'),date('d')+30,date('Y'))); ?>";
        }else{
		document.form2.in_vipindate.value = "<?php echo date('Y-m-d H:i:s'); ?>";
		document.form2.in_vipenddate.value = "<?php echo date('Y-m-d H:i:s',mktime(date('H'),date('i'),date('s'),date('m'),date('d')+360,date('Y'))); ?>";
        }
}
</script>
<div class="container">
<script type="text/javascript">parent.document.title = 'MixMusic 管理中心 - 用户 - 编辑用户';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户&nbsp;&raquo;&nbsp;编辑用户';</script>
<div class="floattop">
<div class="itemtitle">
<ul class="tab1">
<li><a href="?iframe=user"><span>所有用户</span></a></li>
<li><a href="?iframe=user&action=vip"><span>绿钻会员</span></a></li>
<li><a href="?iframe=user&action=lock"><span>锁定状态</span></a></li>
<li><a href="?iframe=user&action=star"><span>明星认证</span></a></li>
<li><a href="?iframe=user&action=staring"><span>待审明星</span></a></li>
</ul></div></div>
<form action="<?php echo $url; ?>" method="post" name="form2">
<table class="tb tb2">
<tr><td colspan="2">用户名:</td></tr>
<tr><td class="vtop rowform"><?php echo $in_username; ?></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">头像:</td></tr>
<tr class="noborder"><td class="vtop rowform"><img width="120" height="120" src="<?php echo getavatar($Arr[0], 'middle'); ?>" /><br /><br /><input type="hidden" name="avatar" value="<?php echo $in_avatar; ?>"><input name="editavatar" class="checkbox" type="checkbox" value="1"<?php if(!is_file($in_avatar)){ ?> disabled="disabled"<?php } ?> /> 删除头像</td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">统计信息:</td></tr>
<tr class="noborder"><td class="vtop rowform">
<a href="?iframe=music&action=keyword&key=<?php echo $in_username; ?>" class="act">音乐数(<?php echo $music; ?>)</a>
<a href="?iframe=special&action=keyword&key=<?php echo $in_username; ?>" class="act">专辑数(<?php echo $special; ?>)</a>
<a href="?iframe=singer&action=keyword&key=<?php echo $in_username; ?>" class="act">歌手数(<?php echo $singer; ?>)</a>
<a href="?iframe=video&action=keyword&key=<?php echo $in_username; ?>" class="act">视频数(<?php echo $video; ?>)</a>
<a href="?iframe=article&action=keyword&key=<?php echo $in_username; ?>" class="act">文章数(<?php echo $article; ?>)</a> <!--//新增Article模块-->
</td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">新密码:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="in_userpassword" name="in_userpassword" type="text" class="txt" /></td><td class="vtop tips2">如果不更改密码此处请留空</td></tr>
<tr><td colspan="2">邮箱:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="in_mail" name="in_mail" value="<?php echo $in_mail; ?>" type="text" class="txt" /></td><td class="vtop tips2">
<ul><?php if($in_ismail==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="checkbox" type="checkbox" name="editismail" id="editismail" value="1"<?php if($in_ismail==1){echo " checked";} ?>><label for="editismail">已验证</label></li></ul>
</td></tr>
<tr><td colspan="2">性别:</td></tr>
<tr class="noborder"><td class="vtop"><select id="in_sex" name="in_sex" class="ps">
<option value="0">帅哥</option>
<option value="1"<?php if($in_sex==1){echo " selected";} ?>>美女</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">地区:</td></tr>
<tr class="noborder"><td class="vtop">
<select onchange="javascript:gettown(this.options[this.selectedIndex].value,&quot;&quot;,&quot;in_city&quot;)" id="in_province" name="in_province" class="ps">
<option value="">省</option>
</select>
<select id="in_city" name="in_city" class="ps">
<option value="">市</option>
</select>
</td><td class="vtop tips2"></td></tr>
<script type="text/javascript">getcity('<?php echo $province; ?>','in_province','<?php echo $city; ?>','in_city');</script>
<tr><td colspan="2">生日:</td></tr>
<tr class="noborder"><td class="vtop">
<select id="in_year" name="in_year" class="ps">
<option value="">年</option>
<?php
for($i=0;$i<100;$i++){
        $they=date('Y')-$i;
        if($they>=1970){
                if($year==$they){
                        echo "<option value=\"".$they."\" selected>".$they."</option>";
                }else{
                        echo "<option value=\"".$they."\">".$they."</option>";
                }
        }
}
?>
</select>
<select id="in_month" name="in_month" class="ps">
<option value="">月</option>
<?php
for($i=1;$i<13;$i++){
        if($i<=9){
                $m="0".$i;
        }else{
                $m=$i;
        }
        if($month==$m){
                echo "<option value=\"".$m."\" selected>".$m."</option>";
        }else{
                echo "<option value=\"".$m."\">".$m."</option>";
        }
}
?>
</select>
<select id="in_day" name="in_day" class="ps">
<option value="">日</option>
<?php
for($i=1;$i<32;$i++){
        if($i<=9){
                $d="0".$i;
        }else{
                $d=$i;
        }
        if($day==$d){
                echo "<option value=\"".$d."\" selected>".$d."</option>";
        }else{
                echo "<option value=\"".$d."\">".$d."</option>";
        }
}
?>
</select>
</td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">金币:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input type="text" id="in_points" name="in_points" class="px" value="<?php echo $in_points; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">经验:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input type="text" id="in_rank" name="in_rank" class="px" value="<?php echo $in_rank; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">开通绿钻会员:</td></tr>
<tr class="noborder"><td class="vtop rowform"><ul><?php if($in_grade==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" id="in_grade" name="in_grade" value="1" onclick="change(1);"<?php if($in_grade==1){echo " checked";} ?>>&nbsp;是</li><?php if($in_grade==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" id="in_grade" name="in_grade" value="0" onclick="change(0);"<?php if($in_grade==0){echo " checked";} ?>>&nbsp;否</li></ul></td><td class="vtop tips2"></td></tr>
<tbody class="sub" id="vipopen"<?php if($in_grade==0){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2">绿钻类型:</td></tr>
<tr class="noborder"><td class="vtop rowform"><ul><?php if($in_vipgrade==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" id="in_vipgrade" name="in_vipgrade" value="1" onclick="getvipdate(1);"<?php if($in_vipgrade==1){echo " checked";} ?>>&nbsp;月付绿钻</li><?php if($in_vipgrade==2){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" id="in_vipgrade" name="in_vipgrade" value="2" onclick="getvipdate(2);"<?php if($in_vipgrade==2){echo " checked";} ?>>&nbsp;年付绿钻</li></ul></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">绿钻开通日期:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="in_vipindate" name="in_vipindate" value="<?php echo $in_vipindate; ?>" onclick="laydate();" type="text" class="txt" /></td><td class="vtop tips2">日期格式：YYYY-MM-DD hh:mm:ss</td></tr>
<tr><td colspan="2">绿钻结束日期:</td></tr>
<tr class="noborder"><td class="vtop rowform"><input id="in_vipenddate" name="in_vipenddate" value="<?php echo $in_vipenddate; ?>" onclick="laydate();" type="text" class="txt" /></td><td class="vtop tips2">日期格式：YYYY-MM-DD hh:mm:ss</td></tr>
</tbody>
<tr><td colspan="2">明星认证:</td></tr>
<tr class="noborder"><td class="vtop rowform"><select id="in_isstar" name="in_isstar" class="ps">
<option value="0">否</option>
<option value="1"<?php if($in_isstar==1){echo " selected";} ?>>是</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">锁定状态:</td></tr>
<tr class="noborder"><td class="vtop rowform"><select id="in_islock" name="in_islock" class="ps">
<option value="0">否</option>
<option value="1"<?php if($in_islock==1){echo " selected";} ?>>是</option>
</select></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">个人介绍:</td></tr>
<tr class="noborder"><td class="vtop rowform"><textarea id="in_introduce" name="in_introduce" class="pt" rows="3" cols="40"><?php echo $in_introduce; ?></textarea></td><td class="vtop tips2"></td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" class="btn" name="edit" onclick="return CheckForm();" value="提交" /><?php if(!empty($in_qqopen)){ ?><input class="checkbox" type="checkbox" name="editqqopen" id="editqqopen" value="1" /><label for="editqqopen">解绑QQ</label><?php } ?></div></td></tr>
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
<script type="text/javascript" src="static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="static/pack/layer/lib.js"></script>
<link href="static/pack/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/pack/fancybox/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="static/pack/fancybox/jquery.fancybox.pack.js"></script>
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
        all_save(form);
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
function all_save(form){
        var opt=document.getElementById("in_allsave").value;
        if(form.chkall.checked && opt=="0"){
		layer.tips('删除用户不可逆，请谨慎操作！', '#chkall', {
			tips: 3
		});
        }
}
</script>
<div class="container">
<?php if(empty($action)){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 用户 - 所有用户';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户&nbsp;&raquo;&nbsp;所有用户';</script>";} ?>
<?php if($action=="vip"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 用户 - 绿钻会员';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户&nbsp;&raquo;&nbsp;绿钻会员';</script>";} ?>
<?php if($action=="lock"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 用户 - 锁定状态';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户&nbsp;&raquo;&nbsp;锁定状态';</script>";} ?>
<?php if($action=="star"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 用户 - 明星认证';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户&nbsp;&raquo;&nbsp;明星认证';</script>";} ?>
<?php if($action=="staring"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 用户 - 待审明星';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户&nbsp;&raquo;&nbsp;待审明星';</script>";} ?>
<?php if($action=="keyword"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 用户 - 搜索用户';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='用户&nbsp;&raquo;&nbsp;搜索用户';</script>";} ?>
<div class="floattop">
<div class="itemtitle">
<ul class="tab1">
<?php if(empty($action)){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user"><span>所有用户</span></a></li>
<?php if($action=="vip"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=vip"><span>绿钻会员</span></a></li>
<?php if($action=="lock"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=lock"><span>锁定状态</span></a></li>
<?php if($action=="star"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=star"><span>明星认证</span></a></li>
<?php if($action=="staring"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=user&action=staring"><span>待审明星</span></a></li>
</ul></div></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<li>可以输入用户名、邮箱等关键词进行搜索</li>
</ul></td></tr>
</table>
<table class="tb tb2">
<form name="btnsearch" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<tr><td>
<input type="hidden" name="iframe" value="user">
<input type="hidden" name="action" value="keyword">
关键词：<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
<input type="button" value="搜索" class="btn" onclick="s()" />
</td></tr>
</form>
</table>
<form name="form" method="post" action="?iframe=user&action=allsave">
<table class="tb tb2">
<tr class="header">
<th>编号</th>
<th>头像</th>
<th>用户名</th>
<th>邮箱</th>
<th>等级</th>
<th>状态</th>
<th>明星认证</th>
<th>编辑操作</th>
</tr>
<?php
if($count==0){
?>
<tr><td colspan="2">没有用户</td></tr>
<?php
}
if($result){
while($row = $db->fetch_array($result)){
$verify = "<a href=\"javascript:void(0)\" onclick=\"pop.up('yes', '认证资料', '?iframe=verify&in_uid=".$row['in_userid']."', '500px', '400px', '40px');\" class=\"act\">认证资料</a>";
?>
<script type="text/javascript">
$(document).ready(function() {
	$("#thumb<?php echo $row['in_userid']; ?>").fancybox({
		'overlayColor': '#000',
		'overlayOpacity': 0.1,
		'overlayShow': true,
		'transitionIn': 'elastic',
		'transitionOut': 'elastic'
	});
});
</script>
<tr class="hover">
<td class="width-50"><input class="checkbox" type="checkbox" name="in_userid[]" id="in_userid" value="<?php echo $row['in_userid']; ?>"><?php echo $row['in_userid']; ?></td>
<td><a href="<?php echo getavatar($row['in_userid'], 'big'); ?>" id="thumb<?php echo $row['in_userid']; ?>"><img src="<?php echo getavatar($row['in_userid']); ?>" width="25" height="25" /></a></td>
<td><a href="<?php echo getlink($row['in_userid']); ?>" target="_blank" class="act"><?php echo ReplaceStr($row['in_username'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
<td><?php echo ReplaceStr($row['in_mail'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></td>
<td><?php if($row['in_grade']==1 && $row['in_vipgrade']==1){echo "<em class=\"lightnum\">月付绿钻</em>";}elseif($row['in_grade']==1 && $row['in_vipgrade']==2){echo "<em class=\"lightnum\">年付绿钻</em>";}else{echo "普通用户";} ?></td>
<td><?php if($row['in_islock']==1){echo "<em class=\"lightnum\">锁定</em>";}else{echo "正常";} ?></td>
<td><?php if($row['in_isstar']==1){echo "<em class=\"lightnum\">已认证[</em>".$verify."<em class=\"lightnum\">]</em>";}elseif($row['in_isstar']==2){echo "<em class=\"lightnum\">待审核[</em>".$verify."<em class=\"lightnum\">]</em>";}else{echo "未认证";} ?></td>
<td><a href="?iframe=user&action=edit&in_userid=<?php echo $row['in_userid']; ?>" class="act">编辑</a></td>
</tr>
<?php
}
}
?>
</table>
<table class="tb tb2">
<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form);" /><label for="chkall">全选</label> &nbsp;&nbsp; <select id="in_allsave" name="in_allsave" onchange="all_save(this.form);">
<option value="0">删除用户</option>
<option value="1">激活状态</option>
<option value="2">锁定状态</option>
<option value="3">授予明星认证</option>
<option value="4">取消明星认证</option>
<option value="5">开通月付绿钻</option>
<option value="6">开通年付绿钻</option>
<option value="7">解除绿钻会员</option>
</select> &nbsp;&nbsp; <input type="submit" name="allsave" class="btn" value="批量操作" /></td></tr>
<?php echo $Arr[0]; ?>
</table>
</form>
</div>



<?php
}
	//批量操作
	function AllSave(){
		global $db;
		if(!submitcheck('allsave')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_userid = RequestBox("in_userid");
		$in_allsave = SafeRequest("in_allsave","post");
		if($in_userid==0){
			ShowMessage("批量操作失败，请先勾选要操作的用户！",$_SERVER['HTTP_REFERER'],"infotitle3",3000,1);
		}else{
			if($in_allsave==0){
		                $query = $db->query("select in_url,in_id from ".tname('photo')." where in_uid in ($in_userid)");
		                while ($row = $db->fetch_array($query)) {
			                @unlink($row['in_url']);
			                $db->query("delete from ".tname('comment')." where in_table='photo' and in_tid=".$row['in_id']);
		                }
		                $query = $db->query("select in_avatar from ".tname('user')." where in_userid in ($in_userid)");
		                while ($row = $db->fetch_array($query)) {
			                @unlink($row['in_avatar']);
		                }
				$sql = "delete from ".tname('user')." where in_userid in ($in_userid)";
				if($db->query($sql)){
					$db->query("delete from ".tname('verify')." where in_uid in ($in_userid)");
					$db->query("delete from ".tname('session')." where in_uid in ($in_userid)");
					$db->query("delete from ".tname('message')." where in_uid in ($in_userid) or in_uids in ($in_userid)");
					$db->query("delete from ".tname('feed')." where in_uid in ($in_userid)");
					$db->query("delete from ".tname('reply')." where in_fuid in ($in_userid) or in_uid in ($in_userid)");
					$db->query("delete from ".tname('comment')." where in_uid in ($in_userid)");
					$db->query("delete from ".tname('wall')." where in_uid in ($in_userid) or in_uids in ($in_userid)");
					$db->query("delete from ".tname('blog_group')." where in_uid in ($in_userid)");
					$db->query("delete from ".tname('blog')." where in_uid in ($in_userid)");
					$db->query("delete from ".tname('photo_group')." where in_uid in ($in_userid)");
					$db->query("delete from ".tname('photo')." where in_uid in ($in_userid)");
					$db->query("delete from ".tname('friend_group')." where in_uid in ($in_userid)");
					$db->query("delete from ".tname('friend')." where in_uid in ($in_userid) or in_uids in ($in_userid)");
					$db->query("delete from ".tname('footprint')." where in_uid in ($in_userid) or in_uids in ($in_userid)");
					$db->query("delete from ".tname('favorites')." where in_uid in ($in_userid)");
					$db->query("delete from ".tname('listen')." where in_uid in ($in_userid)");
					$db->query("delete from ".tname('mail')." where in_uid in ($in_userid)");
					ShowMessage("恭喜您，用户批量删除成功！",$_SERVER['HTTP_REFERER'],"infotitle2",3000,1);
				}
			}elseif($in_allsave==1){
				$db->query("update ".tname('user')." set in_islock=0 where in_userid in ($in_userid)");
				ShowMessage("恭喜您，用户批量激活成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
			}elseif($in_allsave==2){
				$db->query("update ".tname('user')." set in_islock=1 where in_userid in ($in_userid)");
				ShowMessage("恭喜您，用户批量锁定成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
			}elseif($in_allsave==3){
				$query = $db->query("select in_userid,in_username from ".tname('user')." where in_userid in ($in_userid)");
				while ($row = $db->fetch_array($query)) {
		                        $db->query("update ".tname('user')." set in_isstar=1 where in_userid=".$row['in_userid']);
		                        $setarrs = array(
			                        'in_uid' => 0,
			                        'in_uname' => '系统用户',
			                        'in_uids' => $row['in_userid'],
			                        'in_unames' => $row['in_username'],
			                        'in_content' => '恭喜，您已经被管理员授予明星认证！',
			                        'in_isread' => 0,
			                        'in_addtime' => date('Y-m-d H:i:s')
		                        );
		                        inserttable('message', $setarrs, 1);
				}
				ShowMessage("恭喜您，用户批量授予明星认证成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
			}elseif($in_allsave==4){
				$query = $db->query("select in_userid,in_username from ".tname('user')." where in_userid in ($in_userid)");
				while ($row = $db->fetch_array($query)) {
		                        $db->query("update ".tname('user')." set in_isstar=0 where in_userid=".$row['in_userid']);
		                        $setarrs = array(
			                        'in_uid' => 0,
			                        'in_uname' => '系统用户',
			                        'in_uids' => $row['in_userid'],
			                        'in_unames' => $row['in_username'],
			                        'in_content' => '抱歉，您已经被管理员取消明星认证！',
			                        'in_isread' => 0,
			                        'in_addtime' => date('Y-m-d H:i:s')
		                        );
		                        inserttable('message', $setarrs, 1);
				}
				ShowMessage("恭喜您，用户批量取消明星认证成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
			}elseif($in_allsave==5){
				$vipindate = date('Y-m-d H:i:s');
				$vipenddate = date('Y-m-d H:i:s',mktime(date('H'),date('i'),date('s'),date('m'),date('d')+30,date('Y')));
				$query = $db->query("select in_userid,in_username from ".tname('user')." where in_userid in ($in_userid)");
				while ($row = $db->fetch_array($query)) {
		                        $db->query("update ".tname('user')." set in_grade=1,in_vipgrade=1,in_vipindate='".$vipindate."',in_vipenddate='".$vipenddate."' where in_userid=".$row['in_userid']);
		                        $setarrs = array(
			                        'in_uid' => 0,
			                        'in_uname' => '系统用户',
			                        'in_uids' => $row['in_userid'],
			                        'in_unames' => $row['in_username'],
			                        'in_content' => '恭喜，您已经被管理员开通月付绿钻会员！',
			                        'in_isread' => 0,
			                        'in_addtime' => date('Y-m-d H:i:s')
		                        );
		                        inserttable('message', $setarrs, 1);
				}
				ShowMessage("恭喜您，用户批量开通月付绿钻会员成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
			}elseif($in_allsave==6){
				$vipindate = date('Y-m-d H:i:s');
				$vipenddate = date('Y-m-d H:i:s',mktime(date('H'),date('i'),date('s'),date('m'),date('d')+360,date('Y')));
				$query = $db->query("select in_userid,in_username from ".tname('user')." where in_userid in ($in_userid)");
				while ($row = $db->fetch_array($query)) {
		                        $db->query("update ".tname('user')." set in_grade=1,in_vipgrade=2,in_vipindate='".$vipindate."',in_vipenddate='".$vipenddate."' where in_userid=".$row['in_userid']);
		                        $setarrs = array(
			                        'in_uid' => 0,
			                        'in_uname' => '系统用户',
			                        'in_uids' => $row['in_userid'],
			                        'in_unames' => $row['in_username'],
			                        'in_content' => '恭喜，您已经被管理员开通年付绿钻会员！',
			                        'in_isread' => 0,
			                        'in_addtime' => date('Y-m-d H:i:s')
		                        );
		                        inserttable('message', $setarrs, 1);
				}
				ShowMessage("恭喜您，用户批量开通年付绿钻会员成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
			}elseif($in_allsave==7){
				$query = $db->query("select in_userid,in_username from ".tname('user')." where in_userid in ($in_userid)");
				while ($row = $db->fetch_array($query)) {
		                        $db->query("update ".tname('user')." set in_grade=0,in_vipgrade=0,in_vipindate='0000-00-00 00:00:00',in_vipenddate='0000-00-00 00:00:00' where in_userid=".$row['in_userid']);
		                        $setarrs = array(
			                        'in_uid' => 0,
			                        'in_uname' => '系统用户',
			                        'in_uids' => $row['in_userid'],
			                        'in_unames' => $row['in_username'],
			                        'in_content' => '抱歉，您已经被管理员解除绿钻会员！',
			                        'in_isread' => 0,
			                        'in_addtime' => date('Y-m-d H:i:s')
		                        );
		                        inserttable('message', $setarrs, 1);
				}
				ShowMessage("恭喜您，用户批量解除绿钻会员成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
			}
		}
	}

	//编辑
	function Edit(){
		global $db;
		$in_userid = intval(SafeRequest("in_userid","get"));
		$sql = "select * from ".tname('user')." where in_userid=".$in_userid;
		if($row=$db->getrow($sql)){
			$Arr = array($row['in_userid'],$row['in_username'],$row['in_mail'],$row['in_ismail'],$row['in_sex'],$row['in_birthday'],$row['in_address'],$row['in_introduce'],$row['in_islock'],$row['in_isstar'],$row['in_points'],$row['in_rank'],$row['in_grade'],$row['in_vipgrade'],$row['in_vipindate'],$row['in_vipenddate'],$row['in_qqopen'],$row['in_avatar']);
		}
		EditBoard($Arr,"?iframe=user&action=saveedit&in_userid=".$in_userid);
	}

	//保存编辑
	function SaveEdit(){
		global $db;
		if(!submitcheck('edit')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_userid = intval(SafeRequest("in_userid","get"));
		$editismail = SafeRequest("editismail","post")==1 ? 1 : 0;
		$editqqopen = SafeRequest("editqqopen","post");
		$avatar = SafeRequest("avatar","post");
		$editavatar = SafeRequest("editavatar","post");
		$in_userpassword = SafeRequest("in_userpassword","post");
		$in_mail = SafeRequest("in_mail","post");
		$in_sex = SafeRequest("in_sex","post");
		$in_province = SafeRequest("in_province","post");
		$in_city = SafeRequest("in_city","post");
		$address= $in_province."-".$in_city;
		$in_year = SafeRequest("in_year","post");
		$in_month = SafeRequest("in_month","post");
		$in_day = SafeRequest("in_day","post");
		$birthday = $in_year."-".$in_month."-".$in_day;
		$in_points = !IsNum(SafeRequest("in_points","post")) ? 0 : SafeRequest("in_points","post");
		$in_rank = !IsNum(SafeRequest("in_rank","post")) ? 0 : SafeRequest("in_rank","post");
		$in_grade = SafeRequest("in_grade","post");
		$in_vipgrade = $in_grade==0 ? 0 : SafeRequest("in_vipgrade","post");
		$in_vipindate = $in_grade==0 ? "0000-00-00 00:00:00" : SafeRequest("in_vipindate","post");
		$in_vipenddate = $in_grade==0 ? "0000-00-00 00:00:00" : SafeRequest("in_vipenddate","post");
		$in_isstar = SafeRequest("in_isstar","post");
		$in_islock = SafeRequest("in_islock","post");
		$in_introduce = SafeRequest("in_introduce","post");
		$in_qqopen = NULL;
		if($editqqopen==1){
			$in_qqopen = ",in_qqopen=''";
		}
		$in_avatar = NULL;
		if($editavatar==1){
			@unlink($avatar);
			$in_avatar = ",in_avatar=''";
		}
		$userpassword = NULL;
		if(IsNul($in_userpassword)){
			$userpassword = "in_userpassword='".substr(md5($in_userpassword),8,16)."',";
		}
		$sql = "update ".tname('user')." set ".$userpassword."in_mail='".$in_mail."',in_ismail=".$editismail.",in_sex=".$in_sex.",in_address='".$address."',in_birthday='".$birthday."',in_points=".$in_points.",in_rank=".$in_rank.",in_grade=".$in_grade.",in_vipgrade=".$in_vipgrade.",in_vipindate='".$in_vipindate."',in_vipenddate='".$in_vipenddate."',in_isstar=".$in_isstar.",in_islock=".$in_islock.",in_introduce='".$in_introduce."'".$in_qqopen.$in_avatar." where in_userid=".$in_userid;
		if($db->getone("select in_userid from ".tname('user')." where in_userid<>".$in_userid." and in_mail='".$in_mail."'")){
			ShowMessage("编辑失败，邮箱已经存在！",$_SERVER['HTTP_REFERER'],"infotitle3",3000,1);
		}elseif($db->query($sql)){
			ShowMessage("恭喜您，用户编辑成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
		}else{
			ShowMessage("编辑出错，用户编辑失败！",$_SERVER['HTTP_REFERER'],"infotitle3",3000,1);
		}
	}
?>
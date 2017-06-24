<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>搜索 - <?php echo IN_NAME; ?></title>
<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/confirm-lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/city/city.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/friend.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/message.js"></script>
<script type="text/javascript">
var in_path = '<?php echo IN_PATH; ?>';
var friend_group = '<select id="groupid" onchange="ongroup(this.value);"><option value="0">选择分组</option>'
<?php
$query = $db->query("select * from ".tname('friend_group')." where in_uid=".$missra_in_userid." order by in_id desc");
while ($row = $db->fetch_array($query)){
        echo " + '<option value=\"".$row['in_id']."\">".$row['in_title']."</option>'";
}
?>
+ '<option value="-1" style="color:red;">+新建分组</option></select>';
var pop = {
	friend: function(username) {
		$.layer({
			type: 1,
			title: '添加“' + username + '”为好友',
			page: {html: '<form method="get" onsubmit="addfriend(\'' + username + '\');return false;" class="c_form"><table cellspacing="0" cellpadding="0" class="formtable"><tr><th style="width:4em;">附言:</th><td><input type="text" id="message" class="t_input"  /></td></tr><tr><th style="width:4em;">分组:</th><td>' + friend_group + '</td></tr><tr><th style="width:4em;"></th><td><input type="submit" value="确定" class="submit" /></td></tr></table></form>'}
		});
	}
}
layer.use('confirm-ext.js');
function ongroup(_id) {
        if (_id < 0) {
		layer.closeAll();
		layer.prompt({title:'创建新分组'},function(title){addgroup(title);});
	}
}
function all_search() {
	var uname = document.getElementById('uname').value.replace(/\//g, '');
	uname = uname.replace(/\\/g, '');
	uname = uname.replace(/\?/g, '');
	uname = uname.replace(/\+/g, '');
	var uid = document.getElementById('uid').value.replace(/\//g, '');
	uid = uid.replace(/\\/g, '');
	uid = uid.replace(/\?/g, '');
	uid = uid.replace(/\+/g, '');
	var mail = document.getElementById('mail').value.replace(/\//g, '');
	mail = mail.replace(/\\/g, '');
	mail = mail.replace(/\?/g, '');
	mail = mail.replace(/\+/g, '');
	var sex = document.getElementById('sex').value;
	var province = document.getElementById('province').value;
	var city = document.getElementById('city').value;
	var address = '[' + province + '-' + city + ']';
	address = address.replace(/\[-\]/g, '');
	address = address.replace(/-\]/g, '');
	address = address.replace(/\[/g, '');
	address = address.replace(/\]/g, '');
	var year = document.getElementById('year').value;
	var month = document.getElementById('month').value;
	var day = document.getElementById('day').value;
	var birthday = '[' + year + '-' + month + '-' + day + ']';
	birthday = birthday.replace(/\[--\]/g, '');
	birthday = birthday.replace(/--\]/g, '');
	birthday = birthday.replace(/\[--/g, '');
	birthday = birthday.replace(/-\]/g, '');
	birthday = birthday.replace(/\[-/g, '');
	birthday = birthday.replace(/\]/g, '');
	birthday = birthday.replace(/\[/g, '');
	var ismail = document.getElementById('ismail').value;
	var isstar = document.getElementById('isstar').value;
	var grade = document.getElementById('grade').value;
	keyword = uname + '+' + uid + '+' + mail + '+' + sex + '+' + address + '+' + birthday + '+' + ismail + '+' + isstar + '+' + grade;
	if (year !== '' && month == '' && day !== '') {
		document.getElementById('month').focus();
		return;
	} else {
		location.href = '<?php echo rewrite_mode('user.php/misc/search/\' + keyword + \'/'); ?>';
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
<h2 class="title"><img src="<?php echo IN_PATH; ?>static/user/images/icon/search.gif">搜索</h2>
<div class="tabs_header">
<?php $search = explode("/", $_SERVER['PATH_INFO']); ?>
<ul class="tabs">
<li<?php if(!isset($search[4])){echo ' class="active"';} ?>><a href="<?php echo rewrite_mode('user.php/misc/search/'); ?>"><span>高级搜索</span></a></li>
<li><a href="<?php echo rewrite_mode('user.php/misc/rank/'); ?>"><span>排行榜</span></a></li>
</ul>
</div>
<?php if(isset($search[4])){ ?>
<div class="c_form">
<?php
if(!preg_match("/\+/", $search[3])){
        $uname = htmlspecialchars(trim(is_utf8($search[3])), ENT_QUOTES, set_chars(), false);
        $Arr = getuserpage("select * from ".tname('user')." where in_username like '%".$uname."%' order by in_userid desc", 20, 4);
}elseif($search[3] == '++++++++'){
        $Arr = getuserpage("select * from ".tname('user')." order by in_userid desc", 20, 4);
}else{
        $keyword = explode("+", htmlspecialchars(trim(is_utf8($search[3])), ENT_QUOTES, set_chars(), false));
        $key0 = isset($keyword[0]) ? $keyword[0] : NULL;
        $key1 = isset($keyword[1]) ? $keyword[1] : NULL;
        $key2 = isset($keyword[2]) ? $keyword[2] : NULL;
        $key3 = isset($keyword[3]) ? $keyword[3] : NULL;
        $key4 = isset($keyword[4]) ? $keyword[4] : NULL;
        $key5 = isset($keyword[5]) ? $keyword[5] : NULL;
        $key6 = isset($keyword[6]) ? $keyword[6] : NULL;
        $key7 = isset($keyword[7]) ? $keyword[7] : NULL;
        $key8 = isset($keyword[8]) ? $keyword[8] : NULL;
        $uname = empty($key0) ? NULL : "in_username like '%".$key0."%'";
        $uid = !is_numeric($key1) ? NULL : " and in_userid='".$key1."'";
        $mail = empty($key2) ? NULL : " and in_mail like '%".$key2."%'";
        $sex = !is_numeric($key3) ? NULL : " and in_sex='".$key3."'";
        $address = empty($key4) ? NULL : " and in_address like '%".$key4."%'";
        $birthday = empty($key5) ? NULL : " and in_birthday like '%".$key5."%'";
        $ismail = !is_numeric($key6) ? NULL : " and in_ismail='".$key6."'";
        $isstar = !is_numeric($key7) ? NULL : " and in_isstar='".$key7."'";
        $grade = !is_numeric($key8) ? NULL : " and in_grade='".$key8."'";
        $key = $uname.$uid.$mail.$sex.$address.$birthday.$ismail.$isstar.$grade;
        $word = str_replace(array('&in_username', '& and in_'), array('in_username', 'in_'), '&'.$key);
        $words = $word == '&' ? NULL : " where ".$word;
        $Arr = getuserpage("select * from ".tname('user').$words." order by in_userid desc", 20, 4);
}
$result = $Arr[1];
$count = $Arr[2];
if($count == 0){
        echo '<div class="c_form">没有找到相关用户。<a href="'.rewrite_mode('user.php/misc/search/').'">换个搜索条件试试</a></div>';
}else{
        echo '<div style="padding:0 0 20px 0;">以下是查找到的用户列表，您还可以<a href="'.rewrite_mode('user.php/misc/search/').'">换个搜索条件试试</a>。</div>';
        echo '<div class="space_list">';
        while ($row = $db->fetch_array($result)){
                $invisible = $db->getone("select in_invisible from ".tname('session')." where in_uid=".$row['in_userid']);
                $online = is_numeric($invisible) && $invisible == 0 ? '<a href="'.rewrite_mode('user.php/misc/rank/online/').'" title="当前在线"><img src="'.IN_PATH.'static/user/images/online_icon.gif" align="absmiddle"></a>&nbsp;' : '';
                $vip = $row['in_grade'] == 1 ? '<a href="'.rewrite_mode('user.php/profile/vip/').'" title="绿钻会员"><img src="'.IN_PATH.'static/user/images/vip/vip.gif" align="absmiddle"></a>&nbsp;' : '';
                $star = $row['in_isstar'] == 1 ? '<a href="'.rewrite_mode('user.php/profile/verify/').'" title="明星认证"><img src="'.IN_PATH.'static/user/images/star.png" align="absmiddle"></a>&nbsp;' : '';
?>
<table cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="65"><div class="avatar48"><a href="<?php echo getlink($row['in_userid']); ?>"><img src="<?php echo getavatar($row['in_userid']); ?>"></a></div></td>
<td>
<h2><?php echo $online; ?><a href="<?php echo getlink($row['in_userid']); ?>"><?php echo $row['in_username']; ?></a>&nbsp;<?php echo $vip; ?><?php echo $star; ?><?php echo getlevel($row['in_rank'], 1); ?></h2>
<p>人气：<?php echo $row['in_hits']; ?> / 金币：<?php echo $row['in_points']; ?> / 经验：<?php echo $row['in_rank']; ?></p>
</td>
<td width="100">
<ul class="line_list">
<li><a href="javascript:void(0)" onclick="pop.friend('<?php echo $row['in_username']; ?>');">加为好友</a></li>
<li><a href="javascript:void(0)" onclick="layer.prompt({title:'给“<?php echo $row['in_username']; ?>”发短消息',type:3},function(msg){sendmessage('<?php echo $row['in_username']; ?>', msg);});">发送消息</a></li>
</ul>
</td>
</tr>
</table>
<?php } ?>
<?php echo $Arr[0]; ?>
</div>
<?php } ?>
</div>
<?php }else{ ?>
<form method="get" onsubmit="all_search();return false;" class="c_form">
<table cellspacing="0" cellpadding="0" class="formtable">
<caption><h2>精确查找</h2></caption>
<tr><th style="width:10em;">模糊项 -> 用户名:</th><td><input type="text" id="uname" class="t_input" /></td></tr>
<tr><th style="width:10em;">UID:</th><td><input type="text" id="uid" class="t_input" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /></td></tr>
<tr><th style="width:10em;">模糊项 -> 邮箱:</th><td><input type="text" id="mail" class="t_input" /></td></tr>
<tr><th style="width:10em;">性别:</th><td>
<select id="sex">
<option value="">不限</option>
<option value="0">帅哥</option>
<option value="1">美女</option>
</select>
</td></tr>
<tr><th>模糊项 -> 地区:</th><td>
<select onchange="javascript:gettown(this.options[this.selectedIndex].value,&quot;&quot;,&quot;city&quot;)" id="province"><option value="">省</option></select>
<select id="city"><option value="">市</option></select>
</td></tr>
<script type="text/javascript">getcity('', 'province', '', 'city');</script>
<tr><th>模糊项 -> 生日:</th><td>
<select id="year">
<option value="">年</option>
<?php
for($i=0;$i<100;$i++){
        $they=date('Y')-$i;
        if($they>=1970){
                echo "<option value=\"".$they."\">".$they."</option>";
        }
}
?>
</select>
<select id="month">
<option value="">月</option>
<?php
for($i=1;$i<13;$i++){
        if($i<=9){
                $m="0".$i;
        }else{
                $m=$i;
        }
        echo "<option value=\"".$m."\">".$m."</option>";
}
?>
</select>
<select id="day">
<option value="">日</option>
<?php
for($i=1;$i<32;$i++){
        if($i<=9){
                $d="0".$i;
        }else{
                $d=$i;
        }
        echo "<option value=\"".$d."\">".$d."</option>";
}
?>
</select>
</td></tr>
<tr><th style="width:10em;">激活邮箱:</th><td>
<select id="ismail">
<option value="">不限</option>
<option value="0">否</option>
<option value="1">是</option>
</select>
</td></tr>
<tr><th style="width:10em;">明星认证:</th><td>
<select id="isstar">
<option value="">不限</option>
<option value="0">否</option>
<option value="1">是</option>
</select>
</td></tr>
<tr><th style="width:10em;">绿钻会员:</th><td>
<select id="grade">
<option value="">不限</option>
<option value="0">否</option>
<option value="1">是</option>
</select>
</td></tr>
<tr><th style="width:10em;"></th><td><input type="submit" value="查找" class="submit" /></td></tr>
</table>
</form>
<?php } ?>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
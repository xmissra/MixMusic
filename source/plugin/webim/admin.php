<?php
if(!defined('IN_ROOT')){exit('Access denied');}
include 'source/plugin/webim/config.php';
include 'source/admincp/include/function.php';
Administrator(1);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>即时通讯</title>
<link href="<?php echo IN_PATH; ?>static/admincp/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
function change(type){
        if(type==1){
            $('webim_open').style.display='';
        }else{
            $('webim_open').style.display='none';
        }
}
</script>
</head>
<body>
<?php
switch($action){
	case 'save':
		save();
		break;
	default:
		main();
		break;
	}
?>
</body>
</html>
<?php function main(){ ?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?action=save">
<div class="container">
<script type="text/javascript">parent.document.title = 'MixMusic 管理中心 - 即时通讯';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='即时通讯';</script>
<div class="floattop"><div class="itemtitle"><h3>即时通讯</h3></div></div>
<table class="tb tb2">
<tr><th colspan="15" class="partition">插件设置</th></tr>
<tr><td colspan="2">插件开关:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if(in_plugin_webim_open==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="in_plugin_webim_open" value="1" onclick="change(1);"<?php if(in_plugin_webim_open==1){echo " checked";} ?>>&nbsp;开启</li>
<?php if(in_plugin_webim_open==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="in_plugin_webim_open" value="0" onclick="change(0);"<?php if(in_plugin_webim_open==0){echo " checked";} ?>>&nbsp;关闭</li>
</ul>
</td><td class="vtop tips2">关闭后将无法访问该插件</td></tr>
<tbody class="sub" id="webim_open"<?php if(in_plugin_webim_open<>1){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2">私聊消息保留:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo in_plugin_webim_sec; ?>" name="in_plugin_webim_sec" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">秒</td></tr>
<tr><td colspan="2">群聊消息加载:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo in_plugin_webim_num; ?>" name="in_plugin_webim_num" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">条</td></tr>
<tr><td colspan="2">接口请求频率:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo in_plugin_webim_time; ?>" name="in_plugin_webim_time" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">毫秒</td></tr>
</tbody>
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="submit" class="btn" value="提交" /></div></td></tr>
</table>
</div>
</form>
<?php } function save(){
        if(!submitcheck('submit')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
        $str=file_get_contents('source/plugin/webim/config.php');
        $str=preg_replace("/'in_plugin_webim_open', '(.*?)'/", "'in_plugin_webim_open', '".SafeRequest("in_plugin_webim_open","post")."'", $str);
        $str=preg_replace("/'in_plugin_webim_sec', '(.*?)'/", "'in_plugin_webim_sec', '".SafeRequest("in_plugin_webim_sec","post")."'", $str);
        $str=preg_replace("/'in_plugin_webim_num', '(.*?)'/", "'in_plugin_webim_num', '".SafeRequest("in_plugin_webim_num","post")."'", $str);
        $str=preg_replace("/'in_plugin_webim_time', '(.*?)'/", "'in_plugin_webim_time', '".SafeRequest("in_plugin_webim_time","post")."'", $str);
	$ifile = new iFile('source/plugin/webim/config.php', 'w');
	$ifile->WriteFile($str, 3);
	ShowMessage("恭喜您，设置保存成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
}
?>
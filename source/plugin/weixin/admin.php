<?php
if(!defined('IN_ROOT')){exit('Access denied');}
include 'source/plugin/weixin/config.php';
include 'source/admincp/include/function.php';
Administrator(1);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>微信公众号</title>
<link href="<?php echo IN_PATH; ?>static/admincp/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
function change(type){
        if(type==1){
            $('weixin_open').style.display='';
        }else{
            $('weixin_open').style.display='none';
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
<script type="text/javascript">parent.document.title = 'MixMusic 管理中心 - 微信公众号';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='微信公众号';</script>
<div class="floattop"><div class="itemtitle"><h3>微信公众号</h3></div></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<li>微信公众平台：<a href="http://mp.weixin.qq.com/" target="_blank">mp.weixin.qq.com</a></li>
<li>URL：<em class="lightnum"><?php echo "http://".$_SERVER['HTTP_HOST'].IN_PATH."source/plugin/weixin/token.php"; ?></em></li>
<li>Token：<em class="lightnum">必须与插件设置中的Token保持一致</em></li>
</ul></td></tr>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">插件设置</th></tr>
<tr><td colspan="2">插件开关:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if(in_plugin_weixin_open==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="in_plugin_weixin_open" value="1" onclick="change(1);"<?php if(in_plugin_weixin_open==1){echo " checked";} ?>>&nbsp;开启</li>
<?php if(in_plugin_weixin_open==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="in_plugin_weixin_open" value="0" onclick="change(0);"<?php if(in_plugin_weixin_open==0){echo " checked";} ?>>&nbsp;关闭</li>
</ul>
</td><td class="vtop tips2">关闭后将无法访问该插件</td></tr>
<tbody class="sub" id="weixin_open"<?php if(in_plugin_weixin_open<>1){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2">公众平台微信号:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo in_plugin_weixin_user; ?>" name="in_plugin_weixin_user"></td><td class="vtop tips2">将自动获取该微信公众号的二维码图片</td></tr>
<tr><td colspan="2">Token:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo in_plugin_weixin_token; ?>" name="in_plugin_weixin_token"></td><td class="vtop tips2">必须与微信公众平台中设置的Token保持一致</td></tr>
</tbody>
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="submit" class="btn" value="提交" /></div></td></tr>
</table>
</div>
</form>
<?php } function save(){
        if(!submitcheck('submit')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
        $str=file_get_contents('source/plugin/weixin/config.php');
        $str=preg_replace("/'in_plugin_weixin_open', '(.*?)'/", "'in_plugin_weixin_open', '".SafeRequest("in_plugin_weixin_open","post")."'", $str);
        $str=preg_replace("/'in_plugin_weixin_user', '(.*?)'/", "'in_plugin_weixin_user', '".SafeRequest("in_plugin_weixin_user","post")."'", $str);
        $str=preg_replace("/'in_plugin_weixin_token', '(.*?)'/", "'in_plugin_weixin_token', '".SafeRequest("in_plugin_weixin_token","post")."'", $str);
	$ifile = new iFile('source/plugin/weixin/config.php', 'w');
	$ifile->WriteFile($str, 3);
	ShowMessage("恭喜您，设置保存成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
}
?>
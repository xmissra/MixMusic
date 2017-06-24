<?php
if(!defined('IN_ROOT')){exit('Access denied');}
Administrator(2);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>">
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>全局配置</title>
<link href="static/admincp/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function $(obj) {return document.getElementById(obj);}
function change(type){
        if(type==1){
            $('mailopen').style.display='';
        }else if(type==2){
            $('mailopen').style.display='none';
        }else if(type==3){
            $('codeopen').style.display='';
        }else if(type==4){
            $('codeopen').style.display='none';
        }else if(type==5){
            $('in_open').style.display='none';
        }else if(type==6){
            $('in_open').style.display='';
        }else if(type==7){
            $('cacheopen').style.display='';
        }else if(type==8){
            $('cacheopen').style.display='none';
        }else if(type==9){
            $('upopen').style.display='';
        }else if(type==10){
            $('upopen').style.display='none';
        }else if(type==11){
            $('remotedisk').style.display='';
            $('remoteftp').style.display='none';
        }else if(type==12){
            $('remotedisk').style.display='none';
            $('remoteftp').style.display='';
        }else if(type==13){
            $('qqopen').style.display='';
        }else if(type==14){
            $('qqopen').style.display='none';
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
<?php function main(){
global $action;
?>
<form method="post" action="?iframe=config&action=save">
<input type="hidden" name="hash" value="<?php echo $_COOKIE['in_adminpassword']; ?>" />
<div class="container" style="<?php if(empty($action)){echo "display:block";}else{echo "display:none";} ?>;">
<?php if(empty($action)){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 全局 - 站点信息';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='全局&nbsp;&raquo;&nbsp;站点信息';</script>";} ?>
<div class="floattop">
    <div class="itemtitle">
        <ul class="tab1">
            <li class="current"><a href="?iframe=config"><span>站点信息</span></a></li>
            <li><a href="?iframe=config&action=cache"><span>缓存信息</span></a></li>
            <li><a href="?iframe=config&action=upload"><span>上传信息</span></a></li>
            <li><a href="?iframe=config&action=pay"><span>支付信息</span></a></li>
            <li><a href="?iframe=config&action=user"><span>会员信息</span></a></li>
        </ul>
    </div>
</div>

<table class="tb tb2">
    <tr><th colspan="15" class="partition">基本设置</th></tr>
    <tr><td colspan="2">站点名称:</td></tr>
    <tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_NAME; ?>" name="IN_NAME"></td><td class="vtop tips2">显示在浏览器窗口标题等位置</td></tr>
    <tr><td colspan="2">关键字词:</td></tr>
    <tr><td class="vtop rowform"><textarea rows="3" name="IN_KEYWORDS" cols="50" class="tarea"><?php echo IN_KEYWORDS; ?></textarea></td><td class="vtop tips2">合理的词汇有利于搜索引擎优化</td></tr>
    <tr><td colspan="2">站点描述:</td></tr>
    <tr><td class="vtop rowform"><textarea rows="6" name="IN_DESCRIPTION" cols="50" class="tarea"><?php echo IN_DESCRIPTION; ?></textarea></td><td class="vtop tips2">合理的描述有利于搜索引擎优化</td></tr>
    <tr><td colspan="2">备案信息:</td></tr>
    <tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_ICP; ?>" name="IN_ICP"></td><td class="vtop tips2">显示在页面底部等位置</td></tr>
    <tr><td colspan="2">客服 E-mail:</td></tr>
    <tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_MAIL; ?>" name="IN_MAIL"></td><td class="vtop tips2">发邮件时的发件人地址</td></tr>
    <tr><td colspan="2">邮件服务开关:</td></tr>
    <tr>
        <td class="vtop rowform">
            <ul>
            <?php if(IN_MAILOPEN==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="IN_MAILOPEN" value="1" onclick="change(1);"<?php if(IN_MAILOPEN==1){echo " checked";} ?>>&nbsp;开启</li>
            <?php if(IN_MAILOPEN==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="IN_MAILOPEN" value="0" onclick="change(2);"<?php if(IN_MAILOPEN==0){echo " checked";} ?>>&nbsp;关闭</li>
            </ul>
        </td>
        <td class="vtop lightnum">主要用于前台找回密码与验证邮箱等功能，建议开启</td>
    </tr>
    <tbody class="sub" id="mailopen"<?php if(IN_MAILOPEN<>1){echo " style=\"display:none;\"";} ?>>
    <tr><td colspan="2">SMTP 服务器:</td></tr>
    <tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_MAILSMTP; ?>" name="IN_MAILSMTP"></td><td class="vtop tips2">发邮件时所指定的服务器</td></tr>
    <tr><td colspan="2">E-mail 密码:</td></tr>
    <tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_MAILPW; ?>" name="IN_MAILPW"></td><td class="vtop tips2">发邮件时需要验证的密码</td></tr>
    </tbody>
    <tr><td colspan="2">后台提问开关:</td></tr>
    <tr>
        <td class="vtop rowform">
        <ul>
            <?php if(IN_CODEOPEN==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="IN_CODEOPEN" value="1" onclick="change(3);"<?php if(IN_CODEOPEN==1){echo " checked";} ?>>&nbsp;开启</li>
            <?php if(IN_CODEOPEN==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="IN_CODEOPEN" value="0" onclick="change(4);"<?php if(IN_CODEOPEN==0){echo " checked";} ?>>&nbsp;关闭</li>
            </ul>
        </td>
        <td class="vtop tips2">为了站点安全起见，建议开启</td>
    </tr>
    <tbody class="sub" id="codeopen"<?php if(IN_CODEOPEN<>1){echo " style=\"display:none;\"";} ?>>
    <tr><td colspan="2">认证码:</td></tr>
    <tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_CODE; ?>" name="IN_CODE"></td><td class="vtop tips2">管理员登录后台时的安全提问答案</td></tr>
    </tbody>
    <tr><td colspan="2">统计代码:</td></tr>
    <tr><td class="vtop rowform"><textarea rows="6" name="IN_STAT" cols="50" class="tarea"><?php echo base64_decode(IN_STAT); ?></textarea></td><td class="vtop tips2">页面底部显示的第三方统计</td></tr>
</table>

<table class="tb tb2">
<tr><th colspan="15" class="partition">关闭站点</th></tr>
<tr><td colspan="2">站点维护开关:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if(IN_OPEN==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="IN_OPEN" value="1" onclick="change(5);"<?php if(IN_OPEN==1){echo " checked";} ?>>&nbsp;开放</li>
<?php if(IN_OPEN==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="IN_OPEN" value="0" onclick="change(6);"<?php if(IN_OPEN==0){echo " checked";} ?>>&nbsp;维护</li>
</ul>
</td><td class="vtop tips2">暂时将站点关闭，前台无法访问，但不影响后台访问</td></tr>
<tbody class="sub" id="in_open"<?php if(IN_OPEN<>0){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2">维护说明:</td></tr>
<tr><td class="vtop rowform"><textarea rows="6" name="IN_OPENS" cols="50" class="tarea"><?php echo IN_OPENS; ?></textarea></td><td class="vtop tips2">前台显示的维护信息</td></tr>
</tbody>
<tr><td colspan="15"><div class="fixsel"><input type="submit" class="btn" value="提交" /></div></td></tr>
</table>
</div>

<div class="container" style="<?php if($action=="cache"){echo "display:block";}else{echo "display:none";} ?>;">
<?php if($action=="cache"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 全局 - 缓存信息';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='全局&nbsp;&raquo;&nbsp;缓存信息';</script>";} ?>
<div class="floattop">
    <div class="itemtitle">
        <ul class="tab1">
            <li><a href="?iframe=config"><span>站点信息</span></a></li>
            <li class="current"><a href="?iframe=config&action=cache"><span>缓存信息</span></a></li>
            <li><a href="?iframe=config&action=upload"><span>上传信息</span></a></li>
            <li><a href="?iframe=config&action=pay"><span>支付信息</span></a></li>
            <li><a href="?iframe=config&action=user"><span>会员信息</span></a></li>
        </ul>
    </div>
</div>
<table class="tb tb2">
<tr><th colspan="15" class="partition">模板缓存</th></tr>
<tr><td colspan="2">缓存开关:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if(IN_CACHEOPEN==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="IN_CACHEOPEN" value="1" onclick="change(7);"<?php if(IN_CACHEOPEN==1){echo " checked";} ?>>&nbsp;开启</li>
<?php if(IN_CACHEOPEN==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="IN_CACHEOPEN" value="0" onclick="change(8);"<?php if(IN_CACHEOPEN==0){echo " checked";} ?>>&nbsp;关闭</li>
</ul>
</td><td class="vtop tips2">开启缓存能提高模板的运行效率</td></tr>
<tbody class="sub" id="cacheopen"<?php if(IN_CACHEOPEN<>1){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2">缓存时间:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_CACHETIME; ?>" name="IN_CACHETIME" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">秒</td></tr>
</tbody>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">运行模式</th></tr>
<tr><td colspan="2">伪静态开关:</td></tr>
<tr><td class="vtop rowform">
<select name="IN_REWRITEOPEN">
<option value="0">动态</option>
<option value="1"<?php if(IN_REWRITEOPEN==1){echo " selected";} ?>>伪静态</option>
<option value="2"<?php if(IN_REWRITEOPEN==2){echo " selected";} ?>>静态</option>
</select>
</td><td class="vtop tips2">如果您的服务器不支持 Rewrite，请选择“动态”</td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" class="btn" value="提交" /></div></td></tr>
</table>
</div>

<div class="container" style="<?php if($action=="upload"){echo "display:block";}else{echo "display:none";} ?>;">
<?php if($action=="upload"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 全局 - 上传信息';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='全局&nbsp;&raquo;&nbsp;上传信息';</script>";} ?>
<div class="floattop">
    <div class="itemtitle">
        <ul class="tab1">
            <li><a href="?iframe=config"><span>站点信息</span></a></li>
            <li><a href="?iframe=config&action=cache"><span>缓存信息</span></a></li>
            <li class="current"><a href="?iframe=config&action=upload"><span>上传信息</span></a></li>
            <li><a href="?iframe=config&action=pay"><span>支付信息</span></a></li>
            <li><a href="?iframe=config&action=user"><span>会员信息</span></a></li>
        </ul>
    </div>
</div>
<table class="tb tb2">
<tr><th colspan="15" class="partition">本地设置</th></tr>
<tr><td colspan="2">上传开关:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if(IN_UPOPEN==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="IN_UPOPEN" value="1" onclick="change(9);"<?php if(IN_UPOPEN==1){echo " checked";} ?>>&nbsp;开启</li>
<?php if(IN_UPOPEN==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="IN_UPOPEN" value="0" onclick="change(10);"<?php if(IN_UPOPEN==0){echo " checked";} ?>>&nbsp;关闭</li>
</ul>
</td><td class="vtop tips2">关闭后全站将自动切换到远程上传</td></tr>
<tbody class="sub" id="upopen"<?php if(IN_UPOPEN<>1){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2">MP3音质下限:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_UPMP3KBPS; ?>" name="IN_UPMP3KBPS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">单位：Kbps，0 为关闭该功能</td></tr>
<tr><td colspan="2">音频允许的大小:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_UPMUSICSIZE; ?>" name="IN_UPMUSICSIZE" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">MB</td></tr>
<tr><td colspan="2">音频允许的类型:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_UPMUSICEXT; ?>" name="IN_UPMUSICEXT"></td><td class="vtop tips2">多个类型时请用“;”隔开</td></tr>
<tr><td colspan="2">视频允许的大小:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_UPVIDEOSIZE; ?>" name="IN_UPVIDEOSIZE" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">MB</td></tr>
<tr><td colspan="2">视频允许的类型:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_UPVIDEOEXT; ?>" name="IN_UPVIDEOEXT"></td><td class="vtop tips2">多个类型时请用“;”隔开</td></tr>
</tbody>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">远程设置</th></tr>
<tr><td colspan="2">上传类型:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if(IN_REMOTE==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="IN_REMOTE" value="1" onclick="change(11);"<?php if(IN_REMOTE==1){echo " checked";} ?>>&nbsp;云存储</li>
<?php if(IN_REMOTE==2){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="IN_REMOTE" value="2" onclick="change(12);"<?php if(IN_REMOTE==2){echo " checked";} ?>>&nbsp;FTP</li>
</ul>
</td><td class="vtop tips2">关闭本地上传时会自动切换到该类型</td></tr>
<tbody class="sub" id="remotedisk"<?php if(IN_REMOTE<>1){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2">上传标识:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_REMOTEPK; ?>" name="IN_REMOTEPK"></td><td class="vtop tips2">云存储的扩展目录</td></tr>
<tr><td colspan="2">Bucket:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_REMOTEBK; ?>" name="IN_REMOTEBK"></td><td class="vtop tips2">云存储的空间名称</td></tr>
<tr><td colspan="2">AccessKey:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_REMOTEAK; ?>" name="IN_REMOTEAK"></td><td class="vtop tips2">云存储的通信密钥</td></tr>
<tr><td colspan="2">SecretKey:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_REMOTESK; ?>" name="IN_REMOTESK"></td><td class="vtop tips2">云存储的通信密钥</td></tr>
</tbody>
<tbody class="sub" id="remoteftp"<?php if(IN_REMOTE<>2){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2">FTP 服务器地址:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_REMOTEHOST; ?>" name="IN_REMOTEHOST"></td><td class="vtop tips2">可以是 FTP 服务器的 IP 地址或域名</td></tr>
<tr><td colspan="2">FTP 服务器端口:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_REMOTEPORT; ?>" name="IN_REMOTEPORT" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">默认为 21</td></tr>
<tr><td colspan="2">FTP 帐号:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_REMOTEUSER; ?>" name="IN_REMOTEUSER"></td><td class="vtop tips2">该帐号必需具有以下权限：读取文件、写入文件、删除文件、创建目录、子目录继承</td></tr>
<tr><td colspan="2">FTP 密码:</td></tr>
<tr><td class="vtop rowform"><input type="password" class="txt" value="<?php echo IN_REMOTEPW; ?>" name="IN_REMOTEPW"></td><td class="vtop tips2">基于安全考虑，FTP 密码将被隐藏</td></tr>
<tr><td colspan="2">被动模式(pasv)连接:</td></tr>
<tr><td class="vtop rowform">
<select name="IN_REMOTEPASV">
<option value="0">否</option>
<option value="1"<?php if(IN_REMOTEPASV==1){echo " selected";} ?>>是</option>
</select>
</td><td class="vtop tips2">一般情况下非被动模式即可，如果存在上传失败问题，可尝试打开此设置</td></tr>
<tr><td colspan="2">远程附件目录:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_REMOTEDIR; ?>" name="IN_REMOTEDIR"></td><td class="vtop tips2">远程附件目录的绝对路径或相对于 FTP 主目录的相对路径，<em class="lightnum">前后不要加斜杠</em>“<em class="lightnum">/</em>”，“<em class="lightnum">.</em>”<em class="lightnum">表示 FTP 主目录</em></td></tr>
<tr><td colspan="2">远程访问 URL:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_REMOTEURL; ?>" name="IN_REMOTEURL"></td><td class="vtop tips2">支持 HTTP 和 FTP 协议，<em class="lightnum">结尾不要加斜杠</em>“<em class="lightnum">/</em>”；如果使用 FTP 协议，FTP 服务器必需支持 PASV 模式，为了安全起见，使用 FTP 连接的帐号不要设置可写权限和列表权限</td></tr>
<tr><td colspan="2">FTP 传输超时时间:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_REMOTEOUT; ?>" name="IN_REMOTEOUT" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">单位：秒，0 为服务器默认</td></tr>
</tbody>
<tr><td colspan="15"><div class="fixsel"><input type="submit" class="btn" value="提交" /></div></td></tr>
</table>
</div>

<div class="container" style="<?php if($action=="pay"){echo "display:block";}else{echo "display:none";} ?>;">
<?php if($action=="pay"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 全局 - 支付信息';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='全局&nbsp;&raquo;&nbsp;支付信息';</script>";} ?>
<div class="floattop">
    <div class="itemtitle">
        <ul class="tab1">
            <li><a href="?iframe=config"><span>站点信息</span></a></li>
            <li><a href="?iframe=config&action=cache"><span>缓存信息</span></a></li>
            <li><a href="?iframe=config&action=upload"><span>上传信息</span></a></li>
            <li class="current"><a href="?iframe=config&action=pay"><span>支付信息</span></a></li>
            <li><a href="?iframe=config&action=user"><span>会员信息</span></a></li>
        </ul>
    </div>
</div>
<table class="tb tb2">
<tr><th colspan="15" class="partition">支付宝</th></tr>
<tr><td colspan="2">合作身份者 ID:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_ALIPAYID; ?>" name="IN_ALIPAYID"></td><td class="vtop tips2">以2088开头的16位纯数字</td></tr>
<tr><td colspan="2">安全检验码:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_ALIPAYKEY; ?>" name="IN_ALIPAYKEY"></td><td class="vtop tips2">以数字和字母组成的32位字符</td></tr>
<tr><td colspan="2">支付宝账号:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_ALIPAYUID; ?>" name="IN_ALIPAYUID"></td><td class="vtop tips2">签约支付宝账号或卖家支付宝帐户</td></tr>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">增值业务</th></tr>
<tr><td colspan="2">金币充值汇率换算:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_RMBPOINTS; ?>" name="IN_RMBPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币/每元</td></tr>
<tr><td colspan="2">自助开通绿钻售价:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_VIPPOINTS; ?>" name="IN_VIPPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币/每月</td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" class="btn" value="提交" /></div></td></tr>
</table>
</div>

<div class="container" style="<?php if($action=="user"){echo "display:block";}else{echo "display:none";} ?>;">
<?php if($action=="user"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 全局 - 会员信息';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='全局&nbsp;&raquo;&nbsp;会员信息';</script>";} ?>
<div class="floattop"><div class="itemtitle"><ul class="tab1">
<li><a href="?iframe=config"><span>站点信息</span></a></li>
<li><a href="?iframe=config&action=cache"><span>缓存信息</span></a></li>
<li><a href="?iframe=config&action=upload"><span>上传信息</span></a></li>
<li><a href="?iframe=config&action=pay"><span>支付信息</span></a></li>
<li class="current"><a href="?iframe=config&action=user"><span>会员信息</span></a></li>
</ul></div></div>
<table class="tb tb2">
<tr><th colspan="15" class="partition">QQ登录</th></tr>
<tr><td colspan="2">登录开关:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if(IN_QQOPEN==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="IN_QQOPEN" value="1" onclick="change(13);"<?php if(IN_QQOPEN==1){echo " checked";} ?>>&nbsp;开启</li>
<?php if(IN_QQOPEN==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="IN_QQOPEN" value="0" onclick="change(14);"<?php if(IN_QQOPEN==0){echo " checked";} ?>>&nbsp;关闭</li>
</ul>
</td><td class="vtop lightnum">回调地址：<?php echo "http://".$_SERVER['HTTP_HOST'].IN_PATH."source/pack/connect/redirect.php"; ?></td></tr>
<tbody class="sub" id="qqopen"<?php if(IN_QQOPEN<>1){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2">APP ID:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_QQAPPID; ?>" name="IN_QQAPPID"></td><td class="vtop tips2">QQ互联的通信密钥</td></tr>
<tr><td colspan="2">APP KEY:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_QQAPPKEY; ?>" name="IN_QQAPPKEY"></td><td class="vtop tips2">QQ互联的通信密钥</td></tr>
</tbody>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">功能设置</th></tr>
<tr><td colspan="2">会员注册开关:</td></tr>
<tr><td class="vtop rowform">
<select name="IN_REGOPEN">
<option value="0">关闭</option>
<option value="1"<?php if(IN_REGOPEN==1){echo " selected";} ?>>开放</option>
</select>
</td><td class="vtop tips2">关闭后前台将无法使用注册功能</td></tr>
<tr><td colspan="2">会员投稿开关:</td></tr>
<tr><td class="vtop rowform">
<select name="IN_SHAREOPEN">
<option value="0">关闭</option>
<option value="1"<?php if(IN_SHAREOPEN==1){echo " selected";} ?>>开放</option>
</select>
</td><td class="vtop tips2">关闭后前台将无法使用投稿功能</td></tr>
<tr><td colspan="2">用户在线保留秒数:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_ONLINEHOLD; ?>" name="IN_ONLINEHOLD" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">秒</td></tr>
<tr><td colspan="2">动态记录保留天数:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_FEEDDAY; ?>" name="IN_FEEDDAY" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">天</td></tr>
<tr><td colspan="2">访客记录保留天数:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_FOOTPRINTDAY; ?>" name="IN_FOOTPRINTDAY" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">天</td></tr>
<tr><td colspan="2">消息记录保留天数:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_MESSAGEDAY; ?>" name="IN_MESSAGEDAY" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">天</td></tr>
<tr><td colspan="2">试听记录保留天数:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_LISTENDAY; ?>" name="IN_LISTENDAY" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">天</td></tr>
<tr><td colspan="2">邮件记录保留天数:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_MAILDAY; ?>" name="IN_MAILDAY" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">天</td></tr>
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">奖励设置</th></tr>
<tr><td colspan="2">注册会员初始:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_REGPOINTS; ?>" name="IN_REGPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_REGRANK; ?>" name="IN_REGRANK" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">经验</td></tr>
<tr><td colspan="2">每日首次登录:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_LOGINDAYPOINTS; ?>" name="IN_LOGINDAYPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_LOGINDAYRANK; ?>" name="IN_LOGINDAYRANK" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">经验</td></tr>
<tr><td colspan="2">每日打卡签到:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_SIGNDAYPOINTS; ?>" name="IN_SIGNDAYPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币*连续签到天数</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_SIGNDAYRANK; ?>" name="IN_SIGNDAYRANK" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">经验*连续签到天数</td></tr>
<tr><td class="vtop rowform"><select name="IN_SIGNVIPOPEN"><option value="0">否</option><option value="1"<?php if(IN_SIGNVIPOPEN==1){echo " selected";} ?>>是</option></select></td><td class="vtop tips2">是否设立“月付绿钻”满勤奖</td></tr>
<tr><td colspan="2">初次上传头像:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_AVATARPOINTS; ?>" name="IN_AVATARPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_AVATARRANK; ?>" name="IN_AVATARRANK" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">经验</td></tr>
<tr><td colspan="2">初次验证邮箱:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_MAILPOINTS; ?>" name="IN_MAILPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_MAILRANK; ?>" name="IN_MAILRANK" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">经验</td></tr>
<tr><td colspan="2">审核音乐:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_MUSICINPOINTS; ?>" name="IN_MUSICINPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_MUSICINRANK; ?>" name="IN_MUSICINRANK" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">经验</td></tr>
<tr><td colspan="2">审核专辑:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_SPECIALINPOINTS; ?>" name="IN_SPECIALINPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_SPECIALINRANK; ?>" name="IN_SPECIALINRANK" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">经验</td></tr>
<tr><td colspan="2">审核歌手:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_SINGERINPOINTS; ?>" name="IN_SINGERINPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_SINGERINRANK; ?>" name="IN_SINGERINRANK" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">经验</td></tr>
<tr><td colspan="2">审核视频:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_VIDEOINPOINTS; ?>" name="IN_VIDEOINPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_VIDEOINRANK; ?>" name="IN_VIDEOINRANK" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">经验</td></tr>
<tr><td colspan="2">审核文章:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_ARTICLEINPOINTS; ?>" name="IN_ARTICLEINPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币</td></tr> <!--新增Article模块-->
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_ARTICLEINRANK; ?>" name="IN_ARTICLEINRANK" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">经验</td></tr> <!--新增Article模块-->
</table>
<table class="tb tb2">
<tr><th colspan="15" class="partition">惩罚设置</th></tr>
<tr><td colspan="2">删除音乐:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_MUSICOUTPOINTS; ?>" name="IN_MUSICOUTPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_MUSICOUTRANK; ?>" name="IN_MUSICOUTRANK" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">经验</td></tr>
<tr><td colspan="2">删除专辑:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_SPECIALOUTPOINTS; ?>" name="IN_SPECIALOUTPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_SPECIALOUTRANK; ?>" name="IN_SPECIALOUTRANK" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">经验</td></tr>
<tr><td colspan="2">删除歌手:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_SINGEROUTPOINTS; ?>" name="IN_SINGEROUTPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_SINGEROUTRANK; ?>" name="IN_SINGEROUTRANK" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">经验</td></tr>
<tr><td colspan="2">删除视频:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_VIDEOOUTPOINTS; ?>" name="IN_VIDEOOUTPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_VIDEOOUTRANK; ?>" name="IN_VIDEOOUTRANK" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">经验</td></tr>
<tr><td colspan="2">删除文章:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_ARTICLEOUTPOINTS; ?>" name="IN_ARTICLEOUTPOINTS" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">金币</td></tr> <!--新增Article模块-->
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo IN_ARTICLEOUTRANK; ?>" name="IN_ARTICLEOUTRANK" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td><td class="vtop tips2">经验</td></tr> <!--新增Article模块-->
<tr><td colspan="15"><div class="fixsel"><input type="submit" class="btn" value="提交" /></div></td></tr>
</table>
</div>
</form>
<?php
}
function save(){
if(!submitcheck('hash', 1)){ShowMessage("表单来路不明，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
$str=file_get_contents('source/system/config.inc.php');
$str=preg_replace("/'IN_NAME', '(.*?)'/", "'IN_NAME', '".SafeRequest("IN_NAME","post")."'", $str);
$str=preg_replace("/'IN_KEYWORDS', '(.*?)'/", "'IN_KEYWORDS', '".SafeRequest("IN_KEYWORDS","post")."'", $str);
$str=preg_replace("/'IN_DESCRIPTION', '(.*?)'/", "'IN_DESCRIPTION', '".SafeRequest("IN_DESCRIPTION","post")."'", $str);
$str=preg_replace("/'IN_ICP', '(.*?)'/", "'IN_ICP', '".SafeRequest("IN_ICP","post")."'", $str);
$str=preg_replace("/'IN_MAIL', '(.*?)'/", "'IN_MAIL', '".SafeRequest("IN_MAIL","post")."'", $str);
$str=preg_replace("/'IN_MAILOPEN', '(.*?)'/", "'IN_MAILOPEN', '".SafeRequest("IN_MAILOPEN","post")."'", $str);
$str=preg_replace("/'IN_MAILSMTP', '(.*?)'/", "'IN_MAILSMTP', '".SafeRequest("IN_MAILSMTP","post")."'", $str);
$str=preg_replace("/'IN_MAILPW', '(.*?)'/", "'IN_MAILPW', '".SafeRequest("IN_MAILPW","post")."'", $str);
$str=preg_replace("/'IN_CODEOPEN', '(.*?)'/", "'IN_CODEOPEN', '".SafeRequest("IN_CODEOPEN","post")."'", $str);
$str=preg_replace("/'IN_CODE', '(.*?)'/", "'IN_CODE', '".SafeRequest("IN_CODE","post")."'", $str);
$str=preg_replace("/'IN_STAT', '(.*?)'/", "'IN_STAT', '".base64_encode(stripslashes(SafeRequest("IN_STAT","post",1)))."'", $str);
$str=preg_replace("/'IN_OPEN', '(.*?)'/", "'IN_OPEN', '".SafeRequest("IN_OPEN","post")."'", $str);
$str=preg_replace("/'IN_OPENS', '(.*?)'/", "'IN_OPENS', '".SafeRequest("IN_OPENS","post")."'", $str);
$str=preg_replace("/'IN_CACHEOPEN', '(.*?)'/", "'IN_CACHEOPEN', '".SafeRequest("IN_CACHEOPEN","post")."'", $str);
$str=preg_replace("/'IN_CACHETIME', '(.*?)'/", "'IN_CACHETIME', '".SafeRequest("IN_CACHETIME","post")."'", $str);
$str=preg_replace("/'IN_REWRITEOPEN', '(.*?)'/", "'IN_REWRITEOPEN', '".SafeRequest("IN_REWRITEOPEN","post")."'", $str);
$str=preg_replace("/'IN_UPOPEN', '(.*?)'/", "'IN_UPOPEN', '".SafeRequest("IN_UPOPEN","post")."'", $str);
$str=preg_replace("/'IN_UPMP3KBPS', '(.*?)'/", "'IN_UPMP3KBPS', '".SafeRequest("IN_UPMP3KBPS","post")."'", $str);
$str=preg_replace("/'IN_UPMUSICSIZE', '(.*?)'/", "'IN_UPMUSICSIZE', '".SafeRequest("IN_UPMUSICSIZE","post")."'", $str);
$str=preg_replace("/'IN_UPMUSICEXT', '(.*?)'/", "'IN_UPMUSICEXT', '".SafeRequest("IN_UPMUSICEXT","post")."'", $str);
$str=preg_replace("/'IN_UPVIDEOSIZE', '(.*?)'/", "'IN_UPVIDEOSIZE', '".SafeRequest("IN_UPVIDEOSIZE","post")."'", $str);
$str=preg_replace("/'IN_UPVIDEOEXT', '(.*?)'/", "'IN_UPVIDEOEXT', '".SafeRequest("IN_UPVIDEOEXT","post")."'", $str);
$str=preg_replace("/'IN_REMOTE', '(.*?)'/", "'IN_REMOTE', '".SafeRequest("IN_REMOTE","post")."'", $str);
$str=preg_replace("/'IN_REMOTEPK', '(.*?)'/", "'IN_REMOTEPK', '".SafeRequest("IN_REMOTEPK","post")."'", $str);
$str=preg_replace("/'IN_REMOTEBK', '(.*?)'/", "'IN_REMOTEBK', '".SafeRequest("IN_REMOTEBK","post")."'", $str);
$str=preg_replace("/'IN_REMOTEAK', '(.*?)'/", "'IN_REMOTEAK', '".SafeRequest("IN_REMOTEAK","post")."'", $str);
$str=preg_replace("/'IN_REMOTESK', '(.*?)'/", "'IN_REMOTESK', '".SafeRequest("IN_REMOTESK","post")."'", $str);
$str=preg_replace("/'IN_REMOTEHOST', '(.*?)'/", "'IN_REMOTEHOST', '".SafeRequest("IN_REMOTEHOST","post")."'", $str);
$str=preg_replace("/'IN_REMOTEPORT', '(.*?)'/", "'IN_REMOTEPORT', '".SafeRequest("IN_REMOTEPORT","post")."'", $str);
$str=preg_replace("/'IN_REMOTEUSER', '(.*?)'/", "'IN_REMOTEUSER', '".SafeRequest("IN_REMOTEUSER","post")."'", $str);
$str=preg_replace("/'IN_REMOTEPW', '(.*?)'/", "'IN_REMOTEPW', '".SafeRequest("IN_REMOTEPW","post")."'", $str);
$str=preg_replace("/'IN_REMOTEPASV', '(.*?)'/", "'IN_REMOTEPASV', '".SafeRequest("IN_REMOTEPASV","post")."'", $str);
$str=preg_replace("/'IN_REMOTEDIR', '(.*?)'/", "'IN_REMOTEDIR', '".SafeRequest("IN_REMOTEDIR","post")."'", $str);
$str=preg_replace("/'IN_REMOTEURL', '(.*?)'/", "'IN_REMOTEURL', '".SafeRequest("IN_REMOTEURL","post")."'", $str);
$str=preg_replace("/'IN_REMOTEOUT', '(.*?)'/", "'IN_REMOTEOUT', '".SafeRequest("IN_REMOTEOUT","post")."'", $str);
$str=preg_replace("/'IN_ALIPAYID', '(.*?)'/", "'IN_ALIPAYID', '".SafeRequest("IN_ALIPAYID","post")."'", $str);
$str=preg_replace("/'IN_ALIPAYKEY', '(.*?)'/", "'IN_ALIPAYKEY', '".SafeRequest("IN_ALIPAYKEY","post")."'", $str);
$str=preg_replace("/'IN_ALIPAYUID', '(.*?)'/", "'IN_ALIPAYUID', '".SafeRequest("IN_ALIPAYUID","post")."'", $str);
$str=preg_replace("/'IN_RMBPOINTS', '(.*?)'/", "'IN_RMBPOINTS', '".SafeRequest("IN_RMBPOINTS","post")."'", $str);
$str=preg_replace("/'IN_VIPPOINTS', '(.*?)'/", "'IN_VIPPOINTS', '".SafeRequest("IN_VIPPOINTS","post")."'", $str);
$str=preg_replace("/'IN_QQOPEN', '(.*?)'/", "'IN_QQOPEN', '".SafeRequest("IN_QQOPEN","post")."'", $str);
$str=preg_replace("/'IN_QQAPPID', '(.*?)'/", "'IN_QQAPPID', '".SafeRequest("IN_QQAPPID","post")."'", $str);
$str=preg_replace("/'IN_QQAPPKEY', '(.*?)'/", "'IN_QQAPPKEY', '".SafeRequest("IN_QQAPPKEY","post")."'", $str);
$str=preg_replace("/'IN_REGOPEN', '(.*?)'/", "'IN_REGOPEN', '".SafeRequest("IN_REGOPEN","post")."'", $str);
$str=preg_replace("/'IN_SHAREOPEN', '(.*?)'/", "'IN_SHAREOPEN', '".SafeRequest("IN_SHAREOPEN","post")."'", $str);
$str=preg_replace("/'IN_ONLINEHOLD', '(.*?)'/", "'IN_ONLINEHOLD', '".SafeRequest("IN_ONLINEHOLD","post")."'", $str);
$str=preg_replace("/'IN_FEEDDAY', '(.*?)'/", "'IN_FEEDDAY', '".SafeRequest("IN_FEEDDAY","post")."'", $str);
$str=preg_replace("/'IN_FOOTPRINTDAY', '(.*?)'/", "'IN_FOOTPRINTDAY', '".SafeRequest("IN_FOOTPRINTDAY","post")."'", $str);
$str=preg_replace("/'IN_MESSAGEDAY', '(.*?)'/", "'IN_MESSAGEDAY', '".SafeRequest("IN_MESSAGEDAY","post")."'", $str);
$str=preg_replace("/'IN_LISTENDAY', '(.*?)'/", "'IN_LISTENDAY', '".SafeRequest("IN_LISTENDAY","post")."'", $str);
$str=preg_replace("/'IN_MAILDAY', '(.*?)'/", "'IN_MAILDAY', '".SafeRequest("IN_MAILDAY","post")."'", $str);
$str=preg_replace("/'IN_REGPOINTS', '(.*?)'/", "'IN_REGPOINTS', '".SafeRequest("IN_REGPOINTS","post")."'", $str);
$str=preg_replace("/'IN_REGRANK', '(.*?)'/", "'IN_REGRANK', '".SafeRequest("IN_REGRANK","post")."'", $str);
$str=preg_replace("/'IN_LOGINDAYPOINTS', '(.*?)'/", "'IN_LOGINDAYPOINTS', '".SafeRequest("IN_LOGINDAYPOINTS","post")."'", $str);
$str=preg_replace("/'IN_LOGINDAYRANK', '(.*?)'/", "'IN_LOGINDAYRANK', '".SafeRequest("IN_LOGINDAYRANK","post")."'", $str);
$str=preg_replace("/'IN_SIGNDAYPOINTS', '(.*?)'/", "'IN_SIGNDAYPOINTS', '".SafeRequest("IN_SIGNDAYPOINTS","post")."'", $str);
$str=preg_replace("/'IN_SIGNDAYRANK', '(.*?)'/", "'IN_SIGNDAYRANK', '".SafeRequest("IN_SIGNDAYRANK","post")."'", $str);
$str=preg_replace("/'IN_SIGNVIPOPEN', '(.*?)'/", "'IN_SIGNVIPOPEN', '".SafeRequest("IN_SIGNVIPOPEN","post")."'", $str);
$str=preg_replace("/'IN_AVATARPOINTS', '(.*?)'/", "'IN_AVATARPOINTS', '".SafeRequest("IN_AVATARPOINTS","post")."'", $str);
$str=preg_replace("/'IN_AVATARRANK', '(.*?)'/", "'IN_AVATARRANK', '".SafeRequest("IN_AVATARRANK","post")."'", $str);
$str=preg_replace("/'IN_MAILPOINTS', '(.*?)'/", "'IN_MAILPOINTS', '".SafeRequest("IN_MAILPOINTS","post")."'", $str);
$str=preg_replace("/'IN_MAILRANK', '(.*?)'/", "'IN_MAILRANK', '".SafeRequest("IN_MAILRANK","post")."'", $str);
$str=preg_replace("/'IN_MUSICINPOINTS', '(.*?)'/", "'IN_MUSICINPOINTS', '".SafeRequest("IN_MUSICINPOINTS","post")."'", $str);
$str=preg_replace("/'IN_MUSICINRANK', '(.*?)'/", "'IN_MUSICINRANK', '".SafeRequest("IN_MUSICINRANK","post")."'", $str);
$str=preg_replace("/'IN_SPECIALINPOINTS', '(.*?)'/", "'IN_SPECIALINPOINTS', '".SafeRequest("IN_SPECIALINPOINTS","post")."'", $str);
$str=preg_replace("/'IN_SPECIALINRANK', '(.*?)'/", "'IN_SPECIALINRANK', '".SafeRequest("IN_SPECIALINRANK","post")."'", $str);
$str=preg_replace("/'IN_SINGERINPOINTS', '(.*?)'/", "'IN_SINGERINPOINTS', '".SafeRequest("IN_SINGERINPOINTS","post")."'", $str);
$str=preg_replace("/'IN_SINGERINRANK', '(.*?)'/", "'IN_SINGERINRANK', '".SafeRequest("IN_SINGERINRANK","post")."'", $str);
$str=preg_replace("/'IN_VIDEOINPOINTS', '(.*?)'/", "'IN_VIDEOINPOINTS', '".SafeRequest("IN_VIDEOINPOINTS","post")."'", $str);
$str=preg_replace("/'IN_VIDEOINRANK', '(.*?)'/", "'IN_VIDEOINRANK', '".SafeRequest("IN_VIDEOINRANK","post")."'", $str);
$str=preg_replace("/'IN_ARTICLEINPOINTS', '(.*?)'/", "'IN_ARTICLEINPOINTS', '".SafeRequest("IN_ARTICLEINPOINTS","post")."'", $str);//新增Article模块
$str=preg_replace("/'IN_ARTICLEINRANK', '(.*?)'/", "'IN_ARTICLEINRANK', '".SafeRequest("IN_ARTICLEINRANK","post")."'", $str);//新增Article模块
$str=preg_replace("/'IN_MUSICOUTPOINTS', '(.*?)'/", "'IN_MUSICOUTPOINTS', '".SafeRequest("IN_MUSICOUTPOINTS","post")."'", $str);
$str=preg_replace("/'IN_MUSICOUTRANK', '(.*?)'/", "'IN_MUSICOUTRANK', '".SafeRequest("IN_MUSICOUTRANK","post")."'", $str);
$str=preg_replace("/'IN_SPECIALOUTPOINTS', '(.*?)'/", "'IN_SPECIALOUTPOINTS', '".SafeRequest("IN_SPECIALOUTPOINTS","post")."'", $str);
$str=preg_replace("/'IN_SPECIALOUTRANK', '(.*?)'/", "'IN_SPECIALOUTRANK', '".SafeRequest("IN_SPECIALOUTRANK","post")."'", $str);
$str=preg_replace("/'IN_SINGEROUTPOINTS', '(.*?)'/", "'IN_SINGEROUTPOINTS', '".SafeRequest("IN_SINGEROUTPOINTS","post")."'", $str);
$str=preg_replace("/'IN_SINGEROUTRANK', '(.*?)'/", "'IN_SINGEROUTRANK', '".SafeRequest("IN_SINGEROUTRANK","post")."'", $str);
$str=preg_replace("/'IN_VIDEOOUTPOINTS', '(.*?)'/", "'IN_VIDEOOUTPOINTS', '".SafeRequest("IN_VIDEOOUTPOINTS","post")."'", $str);
$str=preg_replace("/'IN_VIDEOOUTRANK', '(.*?)'/", "'IN_VIDEOOUTRANK', '".SafeRequest("IN_VIDEOOUTRANK","post")."'", $str);
$str=preg_replace("/'IN_ARTICLEOUTPOINTS', '(.*?)'/", "'IN_ARTICLEOUTPOINTS', '".SafeRequest("IN_ARTICLEOUTPOINTS","post")."'", $str);//新增Article模块
$str=preg_replace("/'IN_ARTICLEROUTRANK', '(.*?)'/", "'IN_ARTICLEOUTRANK', '".SafeRequest("IN_ARTICLEOUTRANK","post")."'", $str);//新增Article模块

if(!$fp = fopen('source/system/config.inc.php', 'w')) {
	ShowMessage("保存失败，文件{source/system/config.inc.php}没有写入权限！",$_SERVER['HTTP_REFERER'],"infotitle3",3000,1);
}
	$ifile = new iFile('source/system/config.inc.php', 'w');
	$ifile->WriteFile($str, 3);
	ShowMessage("恭喜您，设置保存成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
}
?>
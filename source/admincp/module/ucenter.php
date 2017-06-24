<?php
if(!defined('IN_ROOT')){exit('Access denied');}
Administrator(9);
include_once 'client/ucenter.php';
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>">
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>UCenter</title>
<link href="static/admincp/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function change(type){
        if(type==1){
            ucopen.style.display='none';
        }else if(type==2){
            ucopen.style.display='';
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
	case 'ucsubmit':
		ucsubmit();
		break;
	default:
		main(preg_match("/^(http:\/\/)/i", UC_API) ? 1 : 0);
		break;
	}
?>
</body>
</html>
<?php function main($type){ ?>
<div class="container"><div class="floattop"><div class="itemtitle"><h3>UCenter</h3></div></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<li class="lightnum">您也可以登录 UCenter 用户中心自定义安装一条应用，然后复制该应用的配置信息粘贴到 ./client/ucenter.php 文件来完成通信设置，连接后将与 UCenter 进行会员数据的同步。</li>
</ul></td></tr>
</table>
<?php if($type==1){ ?>
<form method="post" action="?iframe=ucenter&action=save">
<table class="tb tb2">
<tr><th colspan="15" class="partition">UCenter API 通信模块</th></tr>
<tr><td colspan="2">通信开关:</td></tr>
<tr><td class="vtop rowform">
<ul>
<?php if(IN_UCOPEN==0){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="IN_UCOPEN" value="0" onclick="change(1);"<?php if(IN_UCOPEN==0){echo " checked";} ?>>&nbsp;中断</li>
<?php if(IN_UCOPEN==1){echo "<li class=\"checked\">";}else{echo "<li>";} ?><input class="radio" type="radio" name="IN_UCOPEN" value="1" onclick="change(2);"<?php if(IN_UCOPEN==1){echo " checked";} ?>>&nbsp;连接</li>
</ul>
</td><td class="vtop lightnum">在连接的情况下，如果配置信息设置有误，将影响前台登录以及注册等功能</td></tr>
<tbody class="sub" id="ucopen"<?php if(IN_UCOPEN<>1){echo " style=\"display:none;\"";} ?>>
<tr><td colspan="2">连接 UCenter 方式:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_CONNECT; ?>" name="UC_CONNECT"></td><td class="vtop tips2">默认为“mysql”</td></tr>
<tr><td colspan="2">UCenter 数据库主机:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_DBHOST; ?>" name="UC_DBHOST"></td><td class="vtop tips2">默认为“localhost”</td></tr>
<tr><td colspan="2">UCenter 数据库用户名:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_DBUSER; ?>" name="UC_DBUSER"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">UCenter 数据库密码:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_DBPW; ?>" name="UC_DBPW"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">UCenter 数据库名称:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_DBNAME; ?>" name="UC_DBNAME"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">UCenter 数据库字符集:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_DBCHARSET; ?>" name="UC_DBCHARSET"></td><td class="vtop tips2">默认为“<?php echo IN_DBCHARSET; ?>”</td></tr>
<tr><td colspan="2">UCenter 数据库表前缀:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_DBTABLEPRE; ?>" name="UC_DBTABLEPRE"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">UCenter 数据库持久连接:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_DBCONNECT; ?>" name="UC_DBCONNECT"></td><td class="vtop tips2">默认为“0”</td></tr>
<tr><td colspan="2">UCenter 通信密钥:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_KEY; ?>" name="UC_KEY"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">UCenter URL:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_API; ?>" name="UC_API"></td><td class="vtop lightnum">如需重新安装请清空此项</td></tr>
<tr><td colspan="2">UCenter 字符集:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_CHARSET; ?>" name="UC_CHARSET"></td><td class="vtop tips2">默认为“<?php echo IN_CHARSET; ?>”</td></tr>
<tr><td colspan="2">UCenter IP:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_IP; ?>" name="UC_IP"></td><td class="vtop tips2">正常情况下留空即可</td></tr>
<tr><td colspan="2">UCenter ID:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_APPID; ?>" name="UC_APPID"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="2">UCenter 数据调用每页显示条数:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo UC_PPP; ?>" name="UC_PPP"></td><td class="vtop tips2">默认为“20”</td></tr>
</tbody>
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="submit" class="btn" value="提交" /></div></td></tr>
</table>
</form>
<?php }else{ ?>
<form method="post" action="?iframe=ucenter&action=ucsubmit">
<table class="tb tb2">
<tr><th colspan="15" class="partition">UCenter API 安装模块</th></tr>
<tr><td colspan="2">UCenter 的 URL 地址:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" name="ucapi"></td><td class="vtop tips2">例如：http://www.discuz.net/uc_server</td></tr>
<tr><td colspan="2">UCenter 的创始人密码:</td></tr>
<tr><td class="vtop rowform"><input type="text" class="txt" name="ucfounderpw"></td><td class="vtop tips2"></td></tr>
<tr><td colspan="15"><div class="fixsel"><input type="submit" name="submit" class="btn" value="提交" /></div></td></tr>
</table>
</form>
<?php } ?>
</div>
<?php
}
function save(){
	if(!submitcheck('submit')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
	$IN_UCOPEN = SafeRequest("IN_UCOPEN","post");
	$UC_CONNECT = SafeRequest("UC_CONNECT","post");
	$UC_DBHOST = SafeRequest("UC_DBHOST","post");
	$UC_DBUSER = SafeRequest("UC_DBUSER","post");
	$UC_DBPW = SafeRequest("UC_DBPW","post");
	$UC_DBNAME = SafeRequest("UC_DBNAME","post");
	$UC_DBCHARSET = SafeRequest("UC_DBCHARSET","post");
	$UC_DBTABLEPRE = SafeRequest("UC_DBTABLEPRE","post");
	$UC_DBCONNECT = SafeRequest("UC_DBCONNECT","post");
	$UC_KEY = SafeRequest("UC_KEY","post");
	$UC_API = SafeRequest("UC_API","post");
	$UC_CHARSET = SafeRequest("UC_CHARSET","post");
	$UC_IP = SafeRequest("UC_IP","post");
	$UC_APPID = SafeRequest("UC_APPID","post");
	$UC_PPP = SafeRequest("UC_PPP","post");
	$str = "<?php\r\n";
	$str = $str."define('UC_CONNECT', '".$UC_CONNECT."');\r\n";
	$str = $str."define('UC_DBHOST', '".$UC_DBHOST."');\r\n";
	$str = $str."define('UC_DBUSER', '".$UC_DBUSER."');\r\n";
	$str = $str."define('UC_DBPW', '".$UC_DBPW."');\r\n";
	$str = $str."define('UC_DBNAME', '".$UC_DBNAME."');\r\n";
	$str = $str."define('UC_DBCHARSET', '".$UC_DBCHARSET."');\r\n";
	$str = $str."define('UC_DBTABLEPRE', '".$UC_DBTABLEPRE."');\r\n";
	$str = $str."define('UC_DBCONNECT', '".$UC_DBCONNECT."');\r\n";
	$str = $str."define('UC_KEY', '".$UC_KEY."');\r\n";
	$str = $str."define('UC_API', '".$UC_API."');\r\n";
	$str = $str."define('UC_CHARSET', '".$UC_CHARSET."');\r\n";
	$str = $str."define('UC_IP', '".$UC_IP."');\r\n";
	$str = $str."define('UC_APPID', '".$UC_APPID."');\r\n";
	$str = $str."define('UC_PPP', '".$UC_PPP."');\r\n";
	$str = $str."?>";
	$strs = file_get_contents('source/system/config.inc.php');
	$strs = preg_replace("/'IN_UCOPEN', '(.*?)'/", "'IN_UCOPEN', '".$IN_UCOPEN."'", $strs);
	if(!$fp = fopen('client/ucenter.php', 'w')) {
	        ShowMessage("保存失败，文件{client/ucenter.php}没有写入权限！","?iframe=ucenter","infotitle3",3000,1);
	} else if(!$fp = fopen('source/system/config.inc.php', 'w')) {
	        ShowMessage("保存失败，文件{source/system/config.inc.php}没有写入权限！","?iframe=ucenter","infotitle3",3000,1);
	}
	$ifile = new iFile('client/ucenter.php', 'w');
	$ifile->WriteFile($str, 3);
	$ifiles = new iFile('source/system/config.inc.php', 'w');
	$ifiles->WriteFile($strs, 3);
	ShowMessage("恭喜您，设置保存成功！","?iframe=ucenter","infotitle2",1000,1);
}
function ucsubmit(){
	if(!submitcheck('submit')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
	$ucip = isset($_POST['ucip']) ? trim($_POST['ucip']) : NULL;
	$ucapi = preg_replace("/\/$/", '', trim($_POST['ucapi']));
	$ucfounderpw = $_POST['ucfounderpw'];
	if(empty($ucapi) || !preg_match("/^(http:\/\/)/i", $ucapi)) {
	        ShowMessage("UCenter 的 URL 地址不规范！","?iframe=ucenter","infotitle3",3000,1);
	} else {
		if(!$ucip) {
			$temp = @parse_url($ucapi);
			$ucip = gethostbyname($temp['host']);
			if(ip2long($ucip) == -1 || ip2long($ucip) === FALSE) {
				$ucip = '';
			}
		}
	}
	include_once 'client/client.php';
	$ucinfo = uc_fopen2($ucapi.'/index.php?m=app&a=ucinfo&release='.UC_RELEASE, 500, '', '', 1, $ucip);
	list($status, $ucversion, $ucrelease, $uccharset, $ucdbcharset, $apptypes) = explode('|', $ucinfo);
	$dbcharset = IN_DBCHARSET;
	$ucdbcharset = strtolower(trim($ucdbcharset ? str_replace('-', '', $ucdbcharset) : $ucdbcharset));
	if($status != 'UC_STATUS_OK') {
		echo '<div class="container"><div class="floattop"><div class="itemtitle"><h3>UCenter</h3></div></div>';
		echo '<table class="tb tb2">';
		echo '<tr><th class="partition">技巧提示</th></tr>';
		echo '<tr><td class="tipsblock"><ul>';
		echo '<li class="lightnum">当前 UCenter 无法正常连接，请正确填写 UCenter 的 IP 地址。</li>';
		echo '</ul></td></tr>';
		echo '</table>';
		echo '<h3>MixMusic 提示</h3>';
		echo '<div class="infobox"><br /><h4 class="marginbot normal" style="color:#C00">'.$status.'</h4><br />';
		echo '<form method="post" action="?iframe=ucenter&action=ucsubmit"><table class="tb tb2"><tr><td>';
		echo '<input type="text" class="txt" value="'.$ucip.'" name="ucip"> &nbsp; <input type="submit" name="submit" class="btn" value="提交" />';
		echo '<input type="hidden" value="'.$ucapi.'" name="ucapi"><input type="hidden" value="'.$ucfounderpw.'" name="ucfounderpw">';
		echo '</td></tr></table></form>';
		echo '<br /></div>';
		exit('</div></body></html>');
	} elseif($ucdbcharset && $ucdbcharset != $dbcharset) {
	        ShowMessage("UCenter 字符集与您的网站字符集不相同！","?iframe=ucenter","infotitle3",3000,1);
	}
	$uri = "http://".$_SERVER['HTTP_HOST'].IN_PATH."]";
	$app_url = str_replace('/]', '', $uri);
	$postdata = "m=app&a=add&ucfounder=&ucfounderpw=".urlencode($ucfounderpw)."&apptype=".urlencode('OTHER')."&appname=".urlencode('MixMusic')."&appurl=".urlencode($app_url)."&appip=&appcharset=".IN_CHARSET.'&appdbcharset='.IN_DBCHARSET.'&release='.UC_RELEASE;
	$s = uc_fopen2($ucapi.'/index.php', 500, $postdata, '', 1, $ucip);
	if(empty($s)) {
	        ShowMessage("UCenter 返回的数据为空！","?iframe=ucenter","infotitle3",3000,1);
	} elseif($s == '-1') {
	        ShowMessage("UCenter 的创始人密码不正确！","?iframe=ucenter","infotitle3",3000,1);
	} else {
		$ucs = explode('|', $s);
		if(empty($ucs[0]) || empty($ucs[1])) {
			ShowMessage("UCenter 返回的数据出现问题！","?iframe=ucenter","infotitle3",3000,1);
		} else {
			$str = file_get_contents('client/ucenter.php');
			$link = mysql_connect($ucs[2], $ucs[4], $ucs[5], 1);
			$connect = $link && mysql_select_db($ucs[3], $link) ? 'mysql' : '';
			foreach (array('key', 'appid', 'dbhost', 'dbname', 'dbuser', 'dbpw', 'dbcharset', 'dbtablepre', 'charset') as $key => $value) {
				if($value == 'dbtablepre') {
					$ucs[$key] = '`'.$ucs[3].'`.'.$ucs[$key];
				}
				$str = preg_replace("/define\('UC_".strtoupper($value)."', (.*?)\)/", "define('UC_".strtoupper($value)."', '".$ucs[$key]."')", $str);
			}
			$str = preg_replace("/'UC_CONNECT', '(.*?)'/", "'UC_CONNECT', '".$connect."'", $str);
			$str = preg_replace("/'UC_API', '(.*?)'/", "'UC_API', '".$ucapi."'", $str);
			$str = preg_replace("/'UC_IP', '(.*?)'/", "'UC_IP', '".$ucip."'", $str);
			$strs = file_get_contents('source/system/config.inc.php');
			$strs = preg_replace("/'IN_UCOPEN', '(.*?)'/", "'IN_UCOPEN', '1'", $strs);
			$ifile = new iFile('client/ucenter.php', 'w');
			$ifile->WriteFile($str, 3);
			$ifiles = new iFile('source/system/config.inc.php', 'w');
			$ifiles->WriteFile($strs, 3);
			ShowMessage("UCenter 安装成功！应用ID为：".$ucs[1],"?iframe=ucenter","infotitle2",3000,1);
		}
	}
}
?>
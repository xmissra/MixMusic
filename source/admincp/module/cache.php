<?php
if(!defined('IN_ROOT')){exit('Access denied');}
Administrator(6);
$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>更新缓存</title>
<link href="static/admincp/css/main.css" rel="stylesheet" type="text/css" />
<link href="static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript">
function clean_cache(){
	var cache=document.getElementById("cache").value;
	var tmp=document.getElementById("tmp").value;
	var data=document.getElementById("data").value;
	if(!document.getElementById("cache").checked){
		cache=0;
	}
	if(!document.getElementById("tmp").checked){
		tmp=0;
	}
	if(!document.getElementById("data").checked){
		data=0;
	}
        if(cache<1 && tmp<1 && data<1){
		asyncbox.tips("至少需要勾选一项！", "wait", 1000);
        }else{
		document.getElementById("loader").innerHTML="<h4 class=\"infotitle1\">正在更新缓存，请稍候......</h4><img src=\"static/admincp/css/loader.gif\" class=\"marginbot\" />";
		location.href='?iframe=cache&action=save&cache='+cache+'&tmp='+tmp+'&data='+data;
        }
}
</script>
</head>
<body>
<div class="container">
<script type="text/javascript">parent.document.title = 'MixMusic 管理中心 - 工具 - 更新缓存';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='工具&nbsp;&raquo;&nbsp;更新缓存';</script>
<div class="floattop"><div class="itemtitle"><h3>更新缓存</h3></div></div>
<table class="tb tb2">
<tr><th class="partition">技巧提示</th></tr>
<tr><td class="tipsblock"><ul>
<li>如不能勾选“模板缓存”，请先在 全局->缓存信息->模板缓存->缓存开关 选择“开启”</li>
</ul></td></tr>
</table>
<h3>MixMusic 提示</h3>
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
</div>
</body>
</html>
<?php
function main(){
        $cache=NULL;
        if(IN_CACHEOPEN==0){
	        $cache=" disabled";
        }
        echo "<div class=\"infobox\" id=\"loader\"><br /><h4 class=\"marginbot normal\"><input class=\"checkbox\" type=\"checkbox\" id=\"cache\" value=\"1\"".$cache."><label for=\"cache\">模板缓存</label><input class=\"checkbox\" type=\"checkbox\" id=\"tmp\" value=\"1\" checked><label for=\"tmp\">临时文件</label><input class=\"checkbox\" type=\"checkbox\" id=\"data\" value=\"1\" checked><label for=\"data\">过期数据</label></h4><br /><p class=\"margintop\"><input type=\"button\" class=\"btn\" value=\"更新缓存\" onclick=\"clean_cache();\"></p><br /></div>";
}

function save(){
	$cache=SafeRequest("cache","get");
	$tmp=SafeRequest("tmp","get");
	$data=SafeRequest("data","get");
	if($cache==1){
	        $d='data/cache/';
	        if(is_dir($d)){
	  	        $dh=opendir($d);
 		        while(false !== ($file = readdir($dh))){
   			        if($file != "." && $file != ".."){
      				        $fullpath=$d.$file;
      				        if(!is_dir($fullpath)){
         		 		        unlink($fullpath);
      				        }
   			        }
 		        }
   		        closedir($dh);
	        }
	}
	if($tmp==1){
	        $d='data/tmp/';
	        if(is_dir($d)){
	  	        $dh=opendir($d);
 		        while(false !== ($file = readdir($dh))){
   			        if($file != "." && $file != ".."){
      				        $fullpath=$d.$file;
      				        if(!is_dir($fullpath)){
         		 		        unlink($fullpath);
      				        }
   			        }
 		        }
   		        closedir($dh);
	        }
	}
	if($data==1){
	        global $db;
	        $db->query("delete from ".tname('feed')." where in_type<>0 and DATEDIFF(DATE(in_addtime),'".date('Y-m-d')."')<=-".IN_FEEDDAY);
	        $db->query("delete from ".tname('footprint')." where DATEDIFF(DATE(in_addtime),'".date('Y-m-d')."')<=-".IN_FOOTPRINTDAY);
	        $db->query("delete from ".tname('message')." where DATEDIFF(DATE(in_addtime),'".date('Y-m-d')."')<=-".IN_MESSAGEDAY);
	        $db->query("delete from ".tname('listen')." where DATEDIFF(DATE(in_addtime),'".date('Y-m-d')."')<=-".IN_LISTENDAY);
	        $db->query("delete from ".tname('mail')." where DATEDIFF(DATE(in_addtime),'".date('Y-m-d')."')<=-".IN_MAILDAY);
	}
	echo "<div class=\"infobox\"><br /><h4 class=\"infotitle2\">恭喜，缓存已经全部更新完成！</h4><br /></div>";
}
?>
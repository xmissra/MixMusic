<?php
include 'source/system/config.inc.php';
include 'source/system/function_common.php';

$step = empty($_GET['step']) ? 0 : intval($_GET['step']);
$version = IN_VERSION;
$charset = strtoupper(IN_CHARSET);
$build = IN_BUILD;
$year = date('Y');

$lock = IN_ROOT.'./data/install.lock';
if(file_exists($lock)) {
	show_msg('警告！您已经安装过MixMusic！<br>为了保证数据安全，请立即删除{install.php}文件！<br>如果您想重新安装MixMusic，请删除{data/install.lock}文件！', 999);
}
$sql = IN_ROOT.'./static/install/table.sql';
if(!file_exists($sql)) {
	show_msg('缺少{static/install/table.sql}数据库结构文件，请检查！', 999);
}
$config = IN_ROOT.'./source/system/config.inc.php';
if(!@$fp = fopen($config, 'a')) {
	show_msg('文件{source/system/config.inc.php}读写权限设置错误，请先设置为可写！', 999);
} else {
	@fclose($fp);
}

if(empty($step)) {
	$phpos = PHP_OS;
	$phpversion = PHP_VERSION;
	$attachmentupload = @ini_get('file_uploads') ? '<td class="w pdleft1">'.ini_get('upload_max_filesize').'</td>' : '<td class="nw pdleft1">unknow</td>';
	if(function_exists('disk_free_space')) {
		$diskspace = '<td class="w pdleft1">'.floor(disk_free_space(IN_ROOT) / (1024*1024)).'M</td>';
	} else {
		$diskspace = '<td class="nw pdleft1">unknow</td>';
	}
	$checkok = true;
	$perms = array();
	if(!checkfdperm(IN_ROOT.'./client/ucenter.php', 1)) {
		$perms['ucenter'] = '<td class="nw pdleft1">不可写</td>';
		$checkok = false;
	} else {
		$perms['ucenter'] = '<td class="w pdleft1">可写</td>';
	}
	if(!checkfdperm(IN_ROOT.'./client/data/')) {
		$perms['ucdata'] = '<td class="nw pdleft1">不可写</td>';
		$checkok = false;
	} else {
		$perms['ucdata'] = '<td class="w pdleft1">可写</td>';
	}
	if(!checkfdperm(IN_ROOT.'./data/')) {
		$perms['data'] = '<td class="nw pdleft1">不可写</td>';
		$checkok = false;
	} else {
		$perms['data'] = '<td class="w pdleft1">可写</td>';
	}
	if(!checkfdperm(IN_ROOT.'./source/system/config.inc.php', 1)) {
		$perms['config'] = '<td class="nw pdleft1">不可写</td>';
		$checkok = false;
	} else {
		$perms['config'] = '<td class="w pdleft1">可写</td>';
	}
	if(!checkfdperm(IN_ROOT.'./source/plugin/')) {
		$perms['plugin'] = '<td class="nw pdleft1">不可写</td>';
		$checkok = false;
	} else {
		$perms['plugin'] = '<td class="w pdleft1">可写</td>';
	}
	if(!checkfdperm(IN_ROOT.'./template/')) {
		$perms['template'] = '<td class="nw pdleft1">不可写</td>';
		$checkok = false;
	} else {
		$perms['template'] = '<td class="w pdleft1">可写</td>';
	}
	$check_mysql_connect = function_exists('mysql_connect') ? '<td class="w pdleft1">支持</td>' : '<td class="nw pdleft1">不支持</td>';
	$check_file_get_contents = function_exists('file_get_contents') ? '<td class="w pdleft1">支持</td>' : '<td class="nw pdleft1">不支持</td>';
	show_header();
	print<<<END
	<div class="setup step1">
	<h2>开始安装</h2>
	<p>环境以及文件目录权限检查</p>
	</div>
	<div class="stepstat">
	<ul>
	<li class="current">检查安装环境</li>
	<li class="unactivated">创建数据库</li>
	<li class="unactivated">设置后台管理员</li>
	<li class="unactivated last">安装</li>
	</ul>
	<div class="stepstatbg stepstat1"></div>
	</div>
	</div>
	<div class="main">
	<div class="licenseblock">
	<div class="license">
	<h1>产品授权协议 适用于所有用户</h1>

	<p>MixMusic是一款界面采用Discuz后台样式与UCHome用户中心样式相结合、内核由高速模板引擎与缓存机制等框架并存的PHP音乐系统。</p>

	<p>用户须知：本协议是您与MixMusic之间关于您使用MixMusic提供的软件产品及服务的法律协议。无论您是个人或组织、盈利与否、用途如何（包括以学习和研究为目的），均需仔细阅读本协议，包括免除或者限制MixMusic的免责条款及对您的权利限制。请您审阅并接受或不接受本服务条款。如您不同意本服务条款及/或MixMusic随时对其的修改，您应不使用或主动取消MixMusic提供的产品。否则，您的任何对MixMusic产品中的相关服务的注册、登陆、下载、查看等使用行为将被视为您对本服务条款全部的完全接受，包括接受MixMusic对服务条款随时所做的任何修改。</p>

	<p>本服务条款一旦发生变更, MixMusic将在网页上公布修改内容。修改后的服务条款一旦在网页上公布即有效代替原来的服务条款。您可随时登陆MixMusic官方网址查阅最新版服务条款。如果您选择接受本条款，即表示您同意接受协议各项条件的约束。如果您不同意本服务条款，则不能获得使用本服务的权利。您若有违反本条款规定，MixMusic有权随时中止或终止您对MixMusic产品的使用资格并保留追究相关法律责任的权利。</p>

	<p>在理解、同意、并遵守本协议的全部条款后，方可开始使用MixMusic产品。您可能与MixMusic直接签订另一书面协议，以补充或者取代本协议的全部或者任何部分。</p>

	<p>MixMusic拥有本软件的全部知识产权。本软件只供许可协议，并非出售。MixMusic只允许您在遵守本协议各项条款的情况下复制、下载、安装、使用或者以其他方式受益于本软件的功能或者知识产权。</p>
	<br >
	<h3>I. 协议许可的权利</h3>
	<ol>
	    <li>您可以在完全遵守本许可协议的基础上，将本软件应用于非商业用途，而不必支付软件版权许可费用。</li>
	    <li>您可以在协议规定的约束和限制范围内修改MixMusic产品源代码(如果被提供的话)或风格以适应您的网站要求。</li>
	    <li>您拥有使用本软件构建的网站中全部会员资料、文章及相关信息的所有权，并独立承担与使用本软件构建的网站内容的审核、注意义务，确保其不侵犯任何人的合法权益，独立承担因使用MixMusic软件和服务带来的全部责任，若造成MixMusic或用户损失的，您应予以全部赔偿。</li>
	    <li>若您需将MixMusic软件或服务用户商业用途，必须另行获得MixMusic的书面许可，您在获得商业授权之后，您可以将本软件应用于商业用途，同时依据所购买的授权类型中确定的技术支持期限、技术支持方式和技术支持内容，自购买时刻起，在技术支持期限内拥有通过指定的方式获得指定范围内的技术支持服务。商业授权用户享有反映和提出意见的权力，相关意见将被作为首要考虑，但没有一定被采纳的承诺或保证。</li>
	</ol>
	<br >
	<h3>II. 协议规定的约束和限制</h3>
	<ol>
	    <li>未获MixMusic书面商业授权之前，不得将本软件用于商业用途（包括但不限于企业网站、经营性网站、以营利为目或实现盈利的网站）。购买商业授权请登陆www.missra.com参考相关说明，也可以发送邮件到web@missra.com了解详情。</li>
	    <li>不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。</li>
	    <li>无论如何，即无论用途如何、是否经过修改或美化、修改程度如何，只要使用MixMusic产品的整体或任何部分，未经书面许可，页面页脚处的MixMusic产品名称和MixMusic官方网站（www.missra.com） 的链接都必须保留，而不能清除或修改。</li>
	    <li>禁止在MixMusic产品的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。</li>
	    <li>如果您未能遵守本协议的条款，您的授权将被终止，所许可的权利将被收回，同时您应承担相应法律责任。</li>
	</ol>
	<br >
	<h3>III. 有限担保和免责声明</h3>
	<ol>
	    <li>本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。</li>
	    <li>用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任。</li>
	    <li>MixMusic不对使用本软件构建的网站中的文章或信息承担责任，全部责任由您自行承担。</li>
	    <li>MixMusic对其提供的软件和服务之及时性、安全性、准确性不作担保，由于不可抗力因素、MixMusic无法控制的因素（包括黑客攻击、停断电等）等造成软件使用和服务中止或终止，而给您造成损失的，您同意放弃追究MixMusic责任的全部权利。</li>
	    <li>MixMusic特别提请您注意，MixMusic为了保障公司业务发展和调整的自主权，MixMusic拥有随时经或未经事先通知而修改服务内容、中止或终止部分或全部软件使用和服务的权利，修改会公布于MixMusic网站相关页面上，一经公布视为通知。 MixMusic行使修改或中止、终止部分或全部软件使用和服务的权利而造成损失的，MixMusic不需对您或任何第三方负责。</li>
	</ol>

	<p>有关MixMusic产品最终用户授权协议、商业授权与技术服务的详细内容，均由MixMusic独家提供。MixMusic拥有在不事先通知的情况下，修改授权协议和服务价目表的权利，修改后的协议或价目表对自改变之日起的新授权用户生效。</p>

	<p>一旦您开始安装MixMusic产品，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权利的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。</p>

	<p>本许可协议条款的解释，效力及纠纷的解决，适用于中华人民共和国大陆法律。</p>

	<p>若您和MixMusic之间发生任何纠纷或争议，首先应友好协商解决，协商不成的，您在此完全同意将纠纷或争议提交MixMusic所在地人民法院管辖。MixMusic拥有对以上各项条款内容的解释权及修改权。</p>

	<p>版权所有 (c) $year MixMusic保留所有权利。</p>

	<p align="right">MixMusic</p>
	</div>
	</div>
	<h2 class="title">环境检查</h2>
	<table class="tb" style="margin:20px 0 20px 55px;">
		<tr>
			<th>项目</th>
			<th class="padleft">所需配置</th>
			<th class="padleft">最佳配置</th>
			<th class="padleft">当前状态</th>
		</tr>
		<tr>
			<td>操作系统</td>
			<td class="padleft">不限制</td>
			<td class="padleft">类Unix</td>
			<td class="w pdleft1">$phpos</td>
		</tr>
		<tr>
			<td>PHP 版本</td>
			<td class="padleft">4.3.0+</td>
			<td class="padleft">5.0.0+</td>
			<td class="w pdleft1">$phpversion</td>
		</tr>
		<tr>
			<td>附件上传</td>
			<td class="padleft">允许</td>
			<td class="padleft">允许</td>
			$attachmentupload
		</tr>
		<tr>
			<td>磁盘空间</td>
			<td class="padleft">不限制</td>
			<td class="padleft">不限制</td>
			$diskspace
		</tr>
	</table>
	<h2 class="title">目录、文件权限检查</h2>
	<table class="tb" style="margin:20px 0 20px 55px;width:90%;">
		<tr><th>目录文件</th><th class="padleft">所需状态</th><th class="padleft">当前状态</th></tr>
		<tr><td>./client/ucenter.php</td><td class="w pdleft1">可写</td>$perms[ucenter]</tr>
		<tr><td>./client/data/</td><td class="w pdleft1">可写</td>$perms[ucdata]</tr>
		<tr><td>./data/</td><td class="w pdleft1">可写</td>$perms[data]</tr>
		<tr><td>./source/system/config.inc.php</td><td class="w pdleft1">可写</td>$perms[config]</tr>
		<tr><td>./source/plugin/</td><td class="w pdleft1">可写</td>$perms[plugin]</tr>
		<tr><td>./template/</td><td class="w pdleft1">可写</td>$perms[template]</tr>
	</table>
	<h2 class="title">函数依赖性检查</h2>
	<table class="tb" style="margin:20px 0 20px 55px;width:90%;">
		<tr>
			<th>函数名称</th>
			<th class="padleft">检查结果</th>
			<th class="padleft">建议</th>
		</tr>
		<tr>
			<td>mysql_connect()</td>
			$check_mysql_connect
			<td class="padleft">无</td>
		</tr>
		<tr>
			<td>file_get_contents()</td>
			$check_file_get_contents
			<td class="padleft">无</td>
		</tr>
	</table>
END;
	if(!$checkok) {
		echo "<div class=\"btnbox marginbot\"><form method=\"post\" action=\"install.php?step=1\"><input type=\"submit\" value=\"强制继续\"><input type=\"button\" value=\"关闭\" onclick=\"windowclose();\"></form></div>";
	} else {
		print <<<END
		<div class="btnbox marginbot">
			<form method="post" action="install.php?step=1">
				<input type="button" value="不同意" onclick="windowclose();">
				<input type="submit" value="同意并安装">
			</form>
		</div>
END;
	}
	show_footer();

} elseif ($step == 1) {
	show_header();
	print<<<END
	<div class="setup step2">
		<h2>安装数据库</h2>
		<p>正在执行数据库安装</p>
		</div>
		<div class="stepstat">
			<ul>
				<li class="unactivated">检查安装环境</li>
				<li class="current">创建数据库</li>
				<li class="unactivated">设置后台管理员</li>
				<li class="unactivated last">安装</li>
			</ul>
			<div class="stepstatbg stepstat2"></div>
		</div>
	</div>
	<div class="main">
	<form name="themysql" method="post" action="install.php?step=2">
		<div class="desc"><b>填写数据库信息</b></div>
		<table class="tb2">
			<tr>
				<th class="tbopt" align="left">&nbsp;数据库主机:</th>
				<td><input type="text" name="dbhost" value="localhost" size="35" class="txt"></td>
				<td>数据库服务器地址，一般为 localhost</td>
			</tr>
			<tr>
				<th class="tbopt" align="left">&nbsp;数据库名称:</th>
				<td><input type="text" name="dbname" value="mixmusic" size="35" class="txt"></td>
				<td>如果不存在，则会尝试自动创建</td>
			</tr>
			<tr>
				<th class="tbopt" align="left">&nbsp;数据库用户名:</th>
				<td><input type="text" name="dbuser" value="root" size="35" class="txt"></td>
				<td></td>
			</tr>
			<tr>
				<th class="tbopt" align="left">&nbsp;数据库密码:</th>
				<td><input type="password" name="dbpw" value="" size="35" class="txt"></td>
				<td></td>
			</tr>
		</table>
		<div class="desc"><b>其它可选设置项</b></div>
		<table class="tb2">
			<tr><th class="tbopt" align="left">&nbsp;数据库表前缀:</th>
			<td><input type="text" name="dbtablepre" value="mix_" size="35" class="txt"></td>
			<td>不能为空，默认为mix_</td>
			</tr>
			</table>
			<table class="tb2">
			<tr><th class="tbopt" align="left">&nbsp;</th>
			<td><input type="submit" name="submitmysql" value="创建数据库" onclick="return checkmysql();" class="btn"></td>
			<td></td>
			</tr>
		</table>
	</form>
END;
	show_footer();

} elseif ($step == 2) {
	if(!submitcheck('submitmysql')){show_msg('表单验证不符，无法提交！', 999);}
	$path=$_SERVER['PHP_SELF'];
	$path=str_replace('install.php', '', strtolower($path));
	$host=SafeRequest("dbhost","post");
	$name=SafeRequest("dbname","post");
	$user=SafeRequest("dbuser","post");
	$pw=SafeRequest("dbpw","post");
	$tablepre=SafeRequest("dbtablepre","post");
	$havedata = false;
	if(!@mysql_connect($host, $user, $pw)) {
		show_msg('数据库信息填写有误，请更改！');
	}
	$config=file_get_contents("source/system/config.inc.php");
	$config=preg_replace("/'IN_DBHOST', '(.*?)'/", "'IN_DBHOST', '".$host."'", $config);
	$config=preg_replace("/'IN_DBNAME', '(.*?)'/", "'IN_DBNAME', '".$name."'", $config);
	$config=preg_replace("/'IN_DBUSER', '(.*?)'/", "'IN_DBUSER', '".$user."'", $config);
	$config=preg_replace("/'IN_DBPW', '(.*?)'/", "'IN_DBPW', '".$pw."'", $config);
	$config=preg_replace("/'IN_DBTABLE', '(.*?)'/", "'IN_DBTABLE', '".$tablepre."'", $config);
	$config=preg_replace("/'IN_PATH', '(.*?)'/", "'IN_PATH', '".$path."'", $config);
	$ifile=new iFile('source/system/config.inc.php', 'w');
	$ifile->WriteFile($config, 3);
	if(@mysql_select_db($name)) {
		if(mysql_query("SELECT COUNT(*) FROM ".$tablepre."admin")) {
			$havedata = true;
		}
	} else {
		if(!mysql_query("CREATE DATABASE `".$name."`")) {
			show_msg('设定的数据库无权限操作，请先手工新建后，再执行安装程序！');
		}
	}
	if($havedata) {
		show_msg('危险！指定的数据库已有数据，如果继续将会清空原有数据！', ($step+1));
	} else {
		show_msg('数据库信息配置成功，即将开始安装数据...', ($step+1), 1);
	}

} elseif ($step == 3) {
	$lnk=@mysql_connect(IN_DBHOST, IN_DBUSER, IN_DBPW) or show_msg('数据库连接异常，无法执行！', 999);
	@mysql_select_db(IN_DBNAME, $lnk) or show_msg('数据库连接异常，无法执行！', 999);
	mysql_query("SET NAMES ".IN_DBCHARSET, $lnk);
	$table=file_get_contents("static/install/table.sql");
	$table=str_replace('prefix_', IN_DBTABLE, $table);
	$table=str_replace('{charset}', IN_DBCHARSET, $table);
	$tablearr=explode(";",$table);
	$data=file_get_contents("static/install/data.sql");
	$data=str_replace(array('prefix_', '{host}', '{path}'), array(IN_DBTABLE, $_SERVER['HTTP_HOST'], IN_PATH), $data);
	$dataarr=explode("--preset--",$data);
	$sqlarr=explode("{jie}{gou}*/",$table);
	$str="<p>正在安装数据...</p>{replace}";
	for($i=0;$i<count($tablearr)-1;$i++){
		mysql_query($tablearr[$i]);
	}
	for($i=0;$i<count($dataarr);$i++){
		mysql_query($dataarr[$i]);
	}
	for($i=0;$i<count($sqlarr)-1;$i++){
		$strsql=explode("/*{shu}{ju}",$sqlarr[$i]);
		$str.=$strsql[1];
	}
	$str=str_replace('{biao} `', '<p>建立数据表 ', $str);
	$str=str_replace('` {de}', ' ... 成功</p>{replace}', $str);
	$str=$str."<p>安装附加数据 ... 成功</p>{replace}";
	show_header();
	print<<<END
	<div class="setup step2">
		<h2>安装数据库</h2>
		<p>正在执行数据库安装</p>
		</div>
		<div class="stepstat">
			<ul>
				<li class="unactivated">检查安装环境</li>
				<li class="current">创建数据库</li>
				<li class="unactivated">设置后台管理员</li>
				<li class="unactivated last">安装</li>
			</ul>
			<div class="stepstatbg stepstat2"></div>
		</div>
	</div>
	<div class="main">
		<div class="notice" id="log">
			<div class="license" id="loginner"></div>
		</div>
		<div class="btnbox margintop marginbot">
		<input type="button" value="正在安装..." disabled="disabled">
	</div>
	<script type="text/javascript">
		var log = "$str";
		var n = 0;
		var timer = 0;
		log = log.split('{replace}');
		function GoPlay() {
			if (n > log.length-1) {
					n=-1;
					clearIntervals();
			}
			if (n > -1) {
					postcheck(n);
					n++;
			}
		}
		function postcheck(n) {
			document.getElementById('loginner').innerHTML += log[n];
			document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
		}
		function setIntervals() {
			timer = setInterval('GoPlay()', 100);
		}
		function clearIntervals() {
			clearInterval(timer);
			location.href = "install.php?step=4";
		}
		setTimeout(setIntervals, 25);
	</script>
END;
	show_footer();

} elseif ($step == 4) {
	show_header();
	print<<<END
	<div class="setup step3">
		<h2>创建管理员</h2>
		<p>正在设置后台管理帐号</p>
	</div>
	<div class="stepstat">
		<ul>
			<li class="unactivated">检查安装环境</li>
			<li class="unactivated">创建数据库</li>
			<li class="current">设置后台管理员</li>
			<li class="unactivated last">安装</li>
		</ul>
		<div class="stepstatbg stepstat3"></div>
	</div>
	</div>
	<div class="main">
	<form name="theuser" method="post" action="install.php?step=5">
		<div class="desc"><b>填写管理员信息</b></div>
		<table class="tb2">
			<tr>
				<th class="tbopt" align="left">&nbsp;管理员帐号:</th>
				<td><input type="text" name="uname" value="admin" size="35" class="txt" onkeyup="value=value.replace(/[\W]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
				<td>仅限字母与数字</td>
			</tr>
			<tr>
				<th class="tbopt" align="left">&nbsp;管理员密码:</th>
				<td><input type="password" name="upw" value="" size="35" class="txt"></td>
				<td>密码设置越复杂，安全级别越高</td>
			</tr>
			<tr>
				<th class="tbopt" align="left">&nbsp;重复密码:</th>
				<td><input type="password" name="upw1" value="" size="35" class="txt"></td>
				<td></td>
			</tr>
			<tr>
				<th class="tbopt" align="left">&nbsp;认证码:</th>
				<td><input type="text" name="ucode" value="" size="35" class="txt"></td>
				<td>设置后，可以在后台选择开启或关闭</td>
			</tr>
		</table>
		<table class="tb2">
			<tr>
				<th class="tbopt" align="left">&nbsp;</th>
				<td><input type="submit" name="submituser" value="创建管理员" onclick="return checkuser();" class="btn"></td>
				<td></td>
			</tr>
		</table>
	</form>
END;
	show_footer();

} elseif ($step == 5) {
	if(!submitcheck('submituser')){show_msg('表单验证不符，无法提交！', 999);}
	$lnk=@mysql_connect(IN_DBHOST, IN_DBUSER, IN_DBPW) or show_msg('数据库连接异常，无法执行！', 999);
	@mysql_select_db(IN_DBNAME, $lnk) or show_msg('数据库连接异常，无法执行！', 999);
	mysql_query("SET NAMES ".IN_DBCHARSET, $lnk);
	$name=SafeRequest("uname","post");
	$pw=SafeRequest("upw","post");
	$pw1=SafeRequest("upw1","post");
	$code=SafeRequest("ucode","post");

	/////////////////////////////////////////////////////////
	
	$t_name="默认模板";
	$t_dir="default";
	$t_html="html";
	$str=file_get_contents("template/".$t_dir."/install.xml");
	$str=preg_replace("/type=\"(.*?)\"/", "type=\"".IN_CHARSET."\"", $str);
	$str=preg_replace("/name=\"(.*?)\"/", "name=\"".$t_name."\"", $str);
	$str=preg_replace("/dir=\"(.*?)\"/", "dir=\"".$t_dir."\"", $str);
	$str=preg_replace("/html=\"(.*?)\"/", "html=\"".$t_html."\"", $str);
	$str=preg_replace("/CDATA\[(.*?)\]/", "CDATA[".IN_VERSION."]", $str);
	$ifile=new iFile('template/'.$t_dir.'/install.xml', 'w');
	$ifile->WriteFile(convert_xmlcharset($str, 1), 3);
	
	//Lyove模板
	$t2_name="Lyove";
	$t2_dir="lyove";
	$t2_html="html";
	$str2=file_get_contents("template/".$t2_dir."/install.xml");
	$str2=preg_replace("/type=\"(.*?)\"/", "type=\"".IN_CHARSET."\"", $str2);
	$str2=preg_replace("/name=\"(.*?)\"/", "name=\"".$t2_name."\"", $str2);
	$str2=preg_replace("/dir=\"(.*?)\"/", "dir=\"".$t2_dir."\"", $str2);
	$str2=preg_replace("/html=\"(.*?)\"/", "html=\"".$t2_html."\"", $str2);
	$str2=preg_replace("/CDATA\[(.*?)\]/", "CDATA[".IN_VERSION."]", $str2);
	$ifile2=new iFile('template/'.$t2_dir.'/install.xml', 'w');
	$ifile2->WriteFile(convert_xmlcharset($str2, 1), 3);
	
	//Missra模板
	$t3_name="Missra";
	$t3_dir="missra";
	$t3_html="html";
	$str3=file_get_contents("template/".$t3_dir."/install.xml");
	$str3=preg_replace("/type=\"(.*?)\"/", "type=\"".IN_CHARSET."\"", $str3);
	$str3=preg_replace("/name=\"(.*?)\"/", "name=\"".$t3_name."\"", $str3);
	$str3=preg_replace("/dir=\"(.*?)\"/", "dir=\"".$t3_dir."\"", $str3);
	$str3=preg_replace("/html=\"(.*?)\"/", "html=\"".$t3_html."\"", $str3);
	$str3=preg_replace("/CDATA\[(.*?)\]/", "CDATA[".IN_VERSION."]", $str3);
	$ifile3=new iFile('template/'.$t3_dir.'/install.xml', 'w');
	$ifile3->WriteFile(convert_xmlcharset($str3, 1), 3);
	
	/////////////////////////////////////////////////////

	$strs=file_get_contents("source/system/config.inc.php");
	$strs=preg_replace("/'IN_CODE', '(.*?)'/", "'IN_CODE', '".$code."'", $strs);
	$ifiles=new iFile('source/system/config.inc.php', 'w');
	$ifiles->WriteFile($strs, 3);

	$p_name="即时通讯";
	$p_dir="webim";
	$p_file="admin";
	$p_type=2;
	$p_author="missra";
	$p_address="http://www.missra.com/";
	$strss=file_get_contents("source/plugin/".$p_dir."/install.xml");
	$strss=preg_replace("/g type=\"(.*?)\"/", "g type=\"".IN_CHARSET."\"", $strss);
	$strss=preg_replace("/name=\"(.*?)\"/", "name=\"".$p_name."\"", $strss);
	$strss=preg_replace("/dir=\"(.*?)\"/", "dir=\"".$p_dir."\"", $strss);
	$strss=preg_replace("/file=\"(.*?)\"/", "file=\"".$p_file."\"", $strss);
	$strss=preg_replace("/\" type=\"(.*?)\"/", "\" type=\"".$p_type."\"", $strss);
	$strss=preg_replace("/author=\"(.*?)\"/", "author=\"".$p_author."\"", $strss);
	$strss=preg_replace("/address=\"(.*?)\"/", "address=\"".$p_address."\"", $strss);
	$strss=preg_replace("/CDATA\[(.*?)\]/", "CDATA[".IN_VERSION."]", $strss);
	$ifiless=new iFile('source/plugin/'.$p_dir.'/install.xml', 'w');
	$ifiless->WriteFile(convert_xmlcharset($strss, 1), 3);

	$sql_admin="insert into `".tname('admin')."` (in_adminname,in_adminpassword,in_loginnum,in_islock,in_permission) values ('".$name."','".md5($pw1)."','0','0','1,2,3,4,5,6,7,8,9')";
	$sql_user="insert into `".tname('user')."` (in_username,in_userpassword,in_ismail,in_sex,in_regdate,in_islock,in_isstar,in_hits,in_points,in_rank,in_grade,in_vipgrade,in_sign,in_ucid) values ('".$name."','".substr(md5($pw1),8,16)."','0','0','".date('Y-m-d H:i:s')."','0','0','0','0','0','0','0','0','0')";
	$sql_template1="insert into `".tname('template')."` (in_name,in_path,in_default,in_addtime) values ('".$t_name."','template/".$t_dir."/".$t_html."/','1','".date('Y-m-d H:i:s')."')";
	$sql_template2="insert into `".tname('template')."` (in_name,in_path,in_default,in_addtime) values ('".$t2_name."','template/".$t2_dir."/".$t2_html."/','0','".date('Y-m-d H:i:s')."')";
	$sql_template3="insert into `".tname('template')."` (in_name,in_path,in_default,in_addtime) values ('".$t3_name."','template/".$t3_dir."/".$t3_html."/','0','".date('Y-m-d H:i:s')."')";
	$sql_plugin1="insert into `".tname('plugin')."` (in_name,in_dir,in_file,in_isindex,in_type,in_author,in_address,in_addtime) values ('阿里云存储','oss','uplog','0','3','missra','http://www.missra.com/','".date('Y-m-d H:i:s')."')";
	$sql_plugin2="insert into `".tname('plugin')."` (in_name,in_dir,in_file,in_isindex,in_type,in_author,in_address,in_addtime) values ('".$p_name."','".$p_dir."','".$p_file."','1','".$p_type."','".$p_author."','".$p_address."','".date('Y-m-d H:i:s')."')";
	if(mysql_query($sql_admin) && mysql_query($sql_user) && mysql_query($sql_template1) && mysql_query($sql_template2)&& mysql_query($sql_template3) && mysql_query($sql_plugin1) && mysql_query($sql_plugin2)) {
		fwrite(fopen('data/install.lock', 'wb+'), date('Y-m-d H:i:s'));
		show_msg('恭喜！MixMusic 顺利安装完成！<br>为了保证数据安全，请手动删除install目录！<br><br><a href="admin.php"">管理后台</a> 或 <a href="index.php" target="_blank">网站首页</a>', 999);
	} else {
		show_msg(mysql_error(), 999);
	}
}

function show_header() {
	global $version, $charset, $build;
	print<<<END
	<!DOCTYPE html>
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=$charset" />
	<title>MixMusic 安装向导</title>
	<link rel="stylesheet" href="./static/install/images/style.css" type="text/css" media="all" />
	<link href="./static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="./static/pack/asynctips/jquery.min.js"></script>
	<script type="text/javascript" src="./static/pack/asynctips/asyncbox.v1.4.5.js"></script>
	<script type="text/javascript">
	function windowclose() {
		var browserName = navigator.appName;
		if (browserName=="Netscape") {
        		window.open('', '_self', '');
        		window.close();
        	} else if (browserName=="Microsoft Internet Explorer") {
        		window.opener = "whocares";
        		window.opener = null;
        		window.open('', '_top');
        		window.close();
        	}
        }
	function checkmysql() {
		if (this.themysql.dbhost.value=="") {
			asyncbox.tips("数据库主机不能为空，请填写！", "wait", 1000);
			this.themysql.dbhost.focus();
			return false;
		} else if (this.themysql.dbname.value=="") {
			asyncbox.tips("数据库名称不能为空，请填写！", "wait", 1000);
			this.themysql.dbname.focus();
			return false;
		} else if (this.themysql.dbuser.value=="") {
			asyncbox.tips("数据库用户名不能为空，请填写！", "wait", 1000);
			this.themysql.dbuser.focus();
			return false;
		} else if (this.themysql.dbpw.value=="") {
			asyncbox.tips("数据库密码不能为空，请填写！", "wait", 1000);
			this.themysql.dbpw.focus();
			return false;
		} else if (this.themysql.dbtablepre.value=="") {
			asyncbox.tips("数据库表前缀不能为空，请填写！", "wait", 1000);
			this.themysql.dbtablepre.focus();
			return false;
		} else {
			return true;
		}
	}
	function checkuser() {
		if (this.theuser.uname.value=="") {
			asyncbox.tips("管理员帐号不能为空，请填写！", "wait", 1000);
			this.theuser.uname.focus();
			return false;
		} else if (this.theuser.upw.value=="") {
			asyncbox.tips("管理员密码不能为空，请填写！", "wait", 1000);
			this.theuser.upw.focus();
			return false;
		} else if (this.theuser.upw1.value=="") {
			asyncbox.tips("重复密码不能为空，请填写！", "wait", 1000);
			this.theuser.upw1.focus();
			return false;
		} else if (this.theuser.upw1.value!==this.theuser.upw.value) {
			asyncbox.tips("两次输入密码不一致，请更改！", "error", 1000);
			this.theuser.upw1.focus();
			return false;
		} else if (this.theuser.ucode.value=="") {
			asyncbox.tips("认证码不能为空，请填写！", "wait", 1000);
			this.theuser.ucode.focus();
			return false;
		} else {
			return true;
		}
	}
	</script>
	</head>
	<body>
	<div class="container">
	<div class="header">
	<h1>MixMusic 安装向导</h1>
	<span>MixMusic $version 简体中文$charset $build</span>
END;
}

function show_footer() {
	global $year;
	print<<<END
	<div class="footer">&copy; $year <a href="http://www.missra.com/" target="_blank">MixMusic</a> Inc.</div>
	</div>
	</div>
	</body>
	</html>
END;
}

function show_msg($message, $next=0, $jump=0) {
	$step = empty($_GET['step']) ? 0 : intval($_GET['step']);
	$nextstr = '';
	$backstr = '';
	if(empty($next)) {
		$backstr .= "<a href=\"install.php?step=1\">返回上一步</a>";
	} elseif ($next < 999) {
		$url_forward = "install.php?step=$next";
		if(empty($jump)) {
			$nextstr .= "<a href=\"$url_forward\">继续下一步</a>";
			$backstr .= "<a href=\"install.php?step=1\">返回上一步</a>";
		} else {
			$nextstr .= "<a href=\"$url_forward\">请稍等...</a><script type=\"text/javascript\">setTimeout(\"location.href='$url_forward';\", 1000);</script>";
		}
	}
	show_header();
	print<<<END
	<div class="setup">
		<h2>安装提示</h2>
	</div>
	<div class="stepstat">
		<ul>
			<li class="unactivated">检查安装环境</li>
			<li class="unactivated">创建数据库</li>
			<li class="unactivated">设置后台管理员</li>
			<li class="current last">安装</li>
		</ul>
		<div class="stepstatbg stepstat$step"></div>
	</div>
	</div>
	<div class="main">
	<div class="desc" align="center"><b>提示信息</b></div>
	<table class="tb2">
		<tr><td class="desc" align="center">$message</td>
	</tr>
	</table>
	<div class="btnbox marginbot">$backstr $nextstr</div>
END;
	show_footer();
	exit();
}

function checkfdperm($path, $isfile=0) {
	if($isfile) {
		$file = $path;
		$mod = 'a';
	} else {
		$file = $path.'./install_tmptest.data';
		$mod = 'w';
	}
	if(!@$fp = fopen($file, $mod)) {
		return false;
	}
	if(!$isfile) {
		fwrite($fp, ' ');
		fclose($fp);
		if(!@unlink($file)) {
			return false;
		}
		if(is_dir($path.'./install_tmpdir')) {
			if(!@rmdir($path.'./install_tmpdir')) {
				return false;
			}
		}
		if(!@mkdir($path.'./install_tmpdir')) {
			return false;
		}
		if(!@rmdir($path.'./install_tmpdir')) {
			return false;
		}
	} else {
		fclose($fp);
	}
	return true;
}
?>
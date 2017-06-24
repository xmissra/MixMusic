<?php
	if(!defined('IN_ROOT')){exit('Access denied');}
	Administrator(1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
		<title><?php echo IN_NAME; ?> 管理中心</title>
		<link rel="shortcut icon" href="static/admincp/css/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="static/admincp/css/main.css" type="text/css" media="all" />
		<script src="static/admincp/js/common.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="append_parent"></div>
		<table id="frametable">
			<tr>
				<td colspan="2" height="90">
					<div class="mainhd">
						<a href="?iframe=index" class="logo"><?php echo IN_NAME; ?> Administrator's Control Panel</a>
						<div class="uinfo" id="frameuinfo">
							<span>您好, <em><?php echo $_COOKIE['in_adminname']; ?></em> [<a href="?action=logout">退出</a>]</span>
							<span class="btnlink"><a href="index.php" target="_blank">站点首页</a></span>
						</div>
						<div class="nav">
							<ul id="topmenu">
								<li><em><a href="?iframe=body" id="header_index" hidefocus="true" onmouseover="previewheader('index')" onmouseout="previewheader()" onclick="toggleMenu('index', '?iframe=body');doane(event);">首页</a></em></li>
								<li><em><a href="?iframe=config" id="header_global" hidefocus="true" onmouseover="previewheader('global')" onmouseout="previewheader()" onclick="toggleMenu('global', '?iframe=config');doane(event);">全局</a></em></li>
								<li><em><a href="?iframe=music" id="header_content" hidefocus="true" onmouseover="previewheader('content')" onmouseout="previewheader()" onclick="toggleMenu('content', '?iframe=music');doane(event);">内容</a></em></li>
								<li><em><a href="?iframe=skin" id="header_style" hidefocus="true" onmouseover="previewheader('style')" onmouseout="previewheader()" onclick="toggleMenu('style', '?iframe=skin');doane(event);">风格</a></em></li>
								<li><em><a href="?iframe=user" id="header_user" hidefocus="true" onmouseover="previewheader('user')" onmouseout="previewheader()" onclick="toggleMenu('user', '?iframe=user');doane(event);">用户</a></em></li>
								<li><em><a href="?iframe=backup" id="header_plugin" hidefocus="true" onmouseover="previewheader('plugin')" onmouseout="previewheader()" onclick="toggleMenu('plugin', '?iframe=backup');doane(event);">工具</a></em></li>
								<li><em><a href="?iframe=admin" id="header_system" hidefocus="true" onmouseover="previewheader('system')" onmouseout="previewheader()" onclick="toggleMenu('system', '?iframe=admin');doane(event);">系统</a></em></li>
								<li><em><a href="?iframe=module" id="header_app" hidefocus="true" onmouseover="previewheader('app')" onmouseout="previewheader()" onclick="toggleMenu('app', '?iframe=module');doane(event);">扩展</a></em></li>
								<li><em><a href="?iframe=ucenter" id="header_uc" hidefocus="true" onmouseover="previewheader('uc')" onmouseout="previewheader()" onclick="toggleMenu('uc', '?iframe=ucenter');doane(event);">UCenter</a></em></li>
							</ul>
							<div class="currentloca">
								<p id="admincpnav"></p>
							</div>
							<div class="navbd"></div>
							<div class="sitemapbtn">
								<a href="javascript:void(0)" id="cpmap" onclick="showMap();return false;"><img src="static/admincp/css/btn_map.png" title="管理中心导航(ESC键)" width="18" height="18" /></a>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="160" class="menutd">
					<div id="leftmenu" class="menu">
						<ul id="menu_index" style="display: none">
							<li><a href="?iframe=body" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="管理中心首页"></em>管理中心首页</a></li>
						</ul>
						<ul id="menu_global" style="display: none">
							<li><a href="?iframe=config" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="站点信息"></em>站点信息</a></li>
							<li><a href="?iframe=config&action=cache" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="缓存信息"></em>缓存信息</a></li>
							<li><a href="?iframe=config&action=upload" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="上传信息"></em>上传信息</a></li>
							<li><a href="?iframe=config&action=pay" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="支付信息"></em>支付信息</a></li>
							<li><a href="?iframe=config&action=user" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="会员信息"></em>会员信息</a></li>
						</ul>
						<ul id="menu_style" style="display: none">
							<li><a href="?iframe=skin" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="模板方案"></em>模板方案</a></li>
							<li><a href="?iframe=label" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="模板标签"></em>模板标签</a></li>
						</ul>
						<ul id="menu_content" style="display: none">
							<li class="s">
								<div class="lsub" subid="M11fe1b9c">
									<div onclick="lsub('M11fe1b9c', this.parentNode)">音乐管理</div>
									<ol style="display: none" id="M11fe1b9c">
										<li><a href="?iframe=music" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="所有音乐"></em>所有音乐</a></li>
										<li><a href="?iframe=music&action=add" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="新增音乐"></em>新增音乐</a></li>
										<li><a href="?iframe=music&action=pass" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="待审音乐"></em>待审音乐</a></li>
										<li><a href="?iframe=music&action=wrong" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="报错音乐"></em>报错音乐</a></li>
										<li><a href="?iframe=class" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="音乐栏目"></em>音乐栏目</a></li>
										<li><a href="?iframe=tag" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="音乐标签"></em>音乐标签</a></li>
									</ol>
								</div>
							</li>
							<li class="s">
								<div class="lsub" subid="M34a79c04">
									<div onclick="lsub('M34a79c04', this.parentNode)">专辑管理</div>
									<ol style="display: none" id="M34a79c04">
										<li><a href="?iframe=special" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="所有专辑"></em>所有专辑</a></li>
										<li><a href="?iframe=special&action=add" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="新增专辑"></em>新增专辑</a></li>
										<li><a href="?iframe=special&action=pass" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="待审专辑"></em>待审专辑</a></li>
										<li><a href="?iframe=special&action=class" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="专辑栏目"></em>专辑栏目</a></li>
										<li class="sp"></li>
									</ol>
								</div>
							</li>
							<li class="s">
								<div class="lsub" subid="M3b496078">
									<div onclick="lsub('M3b496078', this.parentNode)">歌手管理</div>
									<ol style="display: none" id="M3b496078">
										<li><a href="?iframe=singer" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="所有歌手"></em>所有歌手</a></li>
										<li><a href="?iframe=singer&action=add" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="新增歌手"></em>新增歌手</a></li>
										<li><a href="?iframe=singer&action=pass" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="待审歌手"></em>待审歌手</a></li>
										<li><a href="?iframe=singer&action=class" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="歌手栏目"></em>歌手栏目</a></li>
										<li class="sp"></li>
									</ol>
								</div>
							</li>
							<li class="s">
								<div class="lsub" subid="M9570187e">
									<div onclick="lsub('M9570187e', this.parentNode)">视频管理</div>
									<ol style="display: none" id="M9570187e">
										<li><a href="?iframe=video" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="所有视频"></em>所有视频</a></li>
										<li><a href="?iframe=video&action=add" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="新增视频"></em>新增视频</a></li>
										<li><a href="?iframe=video&action=pass" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="待审视频"></em>待审视频</a></li>
										<li><a href="?iframe=video&action=class" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="视频栏目"></em>视频栏目</a></li>
										<li class="sp"></li>
									</ol>
								</div>
							</li>

							<!--新增Article模块-->
							<li class="s">
								<div class="lsub" subid="M3xyz">
									<div onclick="lsub('M3xyz', this.parentNode)">文章管理</div>
									<ol style="display: none" id="M3xyz">
										<li><a href="?iframe=article" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="所有文章"></em>所有文章</a></li>
										<li><a href="?iframe=article&action=add" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="新增文章"></em>新增文章</a></li>
										<li><a href="?iframe=article&action=pass" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="待审文章手"></em>待审文章</a></li>
										<li><a href="?iframe=article&action=class" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="文章栏目"></em>文章栏目</a></li>
										<li class="sp"></li>
									</ol>
								</div>
							</li>
						</ul>
						<ul id="menu_user" style="display: none">
							<li><a href="?iframe=user" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="所有用户"></em>所有用户</a></li>
							<li><a href="?iframe=comment" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="所有评论"></em>所有评论</a></li>
							<li><a href="?iframe=feed" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="所有说说"></em>所有说说</a></li>
							<li><a href="?iframe=wall" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="所有留言"></em>所有留言</a></li>
							<li><a href="?iframe=blog" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="所有日志"></em>所有日志</a></li>
							<li><a href="?iframe=photo" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="所有照片"></em>所有照片</a></li>
						</ul>
						<ul id="menu_plugin" style="display: none">
							<li><a href="?iframe=backup" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="站点备份"></em>站点备份</a></li>
							<li><a href="?iframe=sql" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="执行语句"></em>执行语句</a></li>
							<li><a href="?iframe=cache" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="更新缓存"></em>更新缓存</a></li>
							<li><a href="?iframe=html" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="静态生成"></em>静态生成</a></li>
						</ul>
						<ul id="menu_system" style="display: none">
							<li><a href="?iframe=admin" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="系统用户"></em>系统用户</a></li>
							<li><a href="?iframe=link" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="友情链接"></em>友情链接</a></li>
							<li><a href="?iframe=uplog" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="上传记录"></em>上传记录</a></li>
							<li><a href="?iframe=paylog" hidefocus="true" target="main"><em onclick="menuNewwin(this)" title="支付记录"></em>支付记录</a></li>
						</ul>
						<ul id="menu_app" style="display: none">
							<?php echo Menu_App(); ?>
						</ul>
						<ul id="menu_uc" style="display: none"></ul>
					</div>
				</td>
				<td valign="top" width="100%" class="mask">
					<iframe src="?iframe=body" id="main" name="main" width="100%" height="100%" frameborder="0" scrolling="yes" style="overflow:visible;display:block;"></iframe>
				</td>
			</tr>
		</table>
		<div id="scrolllink" style="display: none">
			<span onclick="menuScroll(1)"><img src="static/admincp/css/scrollu.gif" /></span><span onclick="menuScroll(2)"><img src="static/admincp/css/scrolld.gif" /></span>
		</div>
		<div class="copyright">
			<p>版本：<?php echo IN_NAME; ?>_V<?php echo IN_VERSION; ?></p>
			<p>版权：&copy;<?php echo date('Y'); ?> <a href="http://www.missra.com/" target="_blank">Missra</a></p>
		</div>
		<div id="cpmap_menu" class="custom" style="display: none">
			<div class="cmain" id="cmain"></div>
			<div class="cfixbd"></div>
		</div>
		<script src="static/admincp/js/admincp.js" type="text/javascript"></script>
	</body>
</html>
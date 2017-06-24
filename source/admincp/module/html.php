<?php
if(!defined('IN_ROOT')){exit('Access denied');}
Administrator(6);
$action=SafeRequest("action","get");
switch($action){
	//新增Article模块
	case 'article':
		html_top();
		html_article();
		html_bottom();
		break;
	case 'video':
		html_top();
		html_video();
		html_bottom();
		break;
	case 'singer':
		html_top();
		html_singer();
		html_bottom();
		break;
	case 'special':
		html_top();
		html_special();
		html_bottom();
		break;
	case 'music':
		html_top();
		html_music();
		html_bottom();
		break;
	case 'mainjump':
		mainjump();
		break;
	default:
		html_top();
		html_index();
		html_bottom();
		break;
} function html_top(){
        global $action;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
	<meta http-equiv="x-ua-compatible" content="ie=7" />
	<title>静态生成</title>
	<link href="static/admincp/css/main.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">function $(obj) {return document.getElementById(obj);}</script>
</head>
<body>
	<div class="container">
		<?php if($action==""){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 静态生成 - 生成首页';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='静态生成&nbsp;&raquo;&nbsp;生成首页';</script>";} ?>
		<?php if($action=="music"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 静态生成 - 生成音乐';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='静态生成&nbsp;&raquo;&nbsp;生成音乐';</script>";} ?>
		<?php if($action=="special"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 静态生成 - 生成专辑';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='静态生成&nbsp;&raquo;&nbsp;生成专辑';</script>";} ?>
		<?php if($action=="singer"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 静态生成 - 生成歌手';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='静态生成&nbsp;&raquo;&nbsp;生成歌手';</script>";} ?>
		<?php if($action=="video"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 静态生成 - 生成视频';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='静态生成&nbsp;&raquo;&nbsp;生成视频';</script>";} ?>
		<?php if($action=="article"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 静态生成 - 生成文章';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='静态生成&nbsp;&raquo;&nbsp;生成文章';</script>";} ?><!--新增Article模块-->
		<div class="floattop">
			<div class="itemtitle">
				<ul class="tab1">
				<?php if($action==""){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=html"><span>生成首页</span></a></li>
				<?php if($action=="music"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=html&action=music"><span>生成音乐</span></a></li>
				<?php if($action=="special"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=html&action=special"><span>生成专辑</span></a></li>
				<?php if($action=="singer"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=html&action=singer"><span>生成歌手</span></a></li>
				<?php if($action=="video"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=html&action=video"><span>生成视频</span></a></li>
				<?php if($action=="article"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=html&action=article"><span>生成文章</span></a></li> <!--新增Article模块-->
				</ul>
			</div>
		</div>
		<?php } 
		
		//生成首页
		function html_index(){ ?>
		<form method="post" name="form" target="iframe">
			<table class="tb tb2">
				<tr><th class="partition">生成首页</th></tr>
			</table>
			<table class="tb tb2">
				<tr>
					<td><input type="submit" class="btn" value="生成首页" onclick="form.action='?iframe=html_index'" /></td>
				</tr>
			</table>
		</form>
		<?php } 
		
		//生成音乐
		function html_music(){ ?>
		<form method="post" name="form" target="iframe">
			<table class="tb tb2">
				<tr><th class="partition">生成音乐</th></tr>
			</table>
			<table class="tb tb2">
				<tr>
					<td>
						<select name="listid">
							<option value="0">所有栏目</option>
							<?php
							global $db;
							$sql="select * from ".tname('class')." order by in_id asc";
							$result=$db->query($sql);
							if($result){
								while ($row=$db->fetch_array($result)){
									echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
								}
							}
							?>
						</select>
					</td>
					<td><input type="submit" class="btn" value="生成栏目" onclick="form.action='?iframe=html_list&table=class'" /></td>
				</tr>
				<tr>
					<td>
						<select name="classid">
							<option value="0">所有音乐</option>
							<?php
							$sql="select * from ".tname('class')." order by in_id asc";
							$result=$db->query($sql);
							if($result){
								while ($row=$db->fetch_array($result)){
									echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
								}
							}
							?>
						</select>
					</td>
					<td><input type="submit" class="btn" value="生成音乐" onclick="form.action='?iframe=html_info&table=music&ac=class'" /></td>
				</tr>
				<tr>
					<td>
						<select name="dayid">
							<option value="0">今天更新</option>
							<option value="1">昨天更新</option>
							<option value="2">前天更新</option>
						</select>
					</td>
					<td><input type="submit" class="btn" value="生成音乐" onclick="form.action='?iframe=html_info&table=music&ac=day'" /></td>
				</tr>
			</table>
		</form>
		<?php } 
		
		//生成专辑
		function html_special(){ ?>
		<form method="post" name="form" target="iframe">
			<table class="tb tb2">
				<tr><th class="partition">生成专辑</th></tr>
			</table>
			<table class="tb tb2">
				<tr>
					<td>
						<select name="listid">
							<option value="0">所有栏目</option>
							<?php
							global $db;
							$sql="select * from ".tname('special_class')." order by in_id asc";
							$result=$db->query($sql);
							if($result){
								while ($row=$db->fetch_array($result)){
									echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
								}
							}
							?>
						</select>
					</td>
					<td><input type="submit" class="btn" value="生成栏目" onclick="form.action='?iframe=html_list&table=special_class'" /></td>
				</tr>
				<tr>
					<td>
						<select name="classid">
							<option value="0">所有专辑</option>
							<?php
							$sql="select * from ".tname('special_class')." order by in_id asc";
							$result=$db->query($sql);
							if($result){
								while ($row=$db->fetch_array($result)){
									echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
								}
							}
							?>
						</select>
					</td>
					<td><input type="submit" class="btn" value="生成专辑" onclick="form.action='?iframe=html_info&table=special&ac=class'" /></td>
				</tr>
				<tr>
					<td>
						<select name="dayid">
							<option value="0">今天更新</option>
							<option value="1">昨天更新</option>
							<option value="2">前天更新</option>
						</select>
					</td>
					<td><input type="submit" class="btn" value="生成专辑" onclick="form.action='?iframe=html_info&table=special&ac=day'" /></td>
				</tr>
			</table>
		</form>
		<?php } 

		//生成歌手
		function html_singer(){ ?>
		<form method="post" name="form" target="iframe">
		<table class="tb tb2">
			<tr><th class="partition">生成歌手</th></tr>
		</table>
		<table class="tb tb2">
			<tr>
				<td>
					<select name="listid">
						<option value="0">所有栏目</option>
						<?php
						global $db;
						$sql="select * from ".tname('singer_class')." order by in_id asc";
						$result=$db->query($sql);
						if($result){
							while ($row=$db->fetch_array($result)){
								echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
							}
						}
						?>
					</select>
				</td>
				<td><input type="submit" class="btn" value="生成栏目" onclick="form.action='?iframe=html_list&table=singer_class'" /></td>
			</tr>
			<tr>
				<td>
					<select name="classid">
						<option value="0">所有歌手</option>
						<?php
						$sql="select * from ".tname('singer_class')." order by in_id asc";
						$result=$db->query($sql);
						if($result){
							while ($row=$db->fetch_array($result)){
								echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
							}
						}
						?>
					</select>
				</td>
				<td><input type="submit" class="btn" value="生成歌手" onclick="form.action='?iframe=html_info&table=singer&ac=class'" /></td>
			</tr>
			<tr>
				<td>
					<select name="dayid">
						<option value="0">今天更新</option>
						<option value="1">昨天更新</option>
						<option value="2">前天更新</option>
					</select>
				</td>
				<td><input type="submit" class="btn" value="生成歌手" onclick="form.action='?iframe=html_info&table=singer&ac=day'" /></td>
			</tr>
		</table>
		</form>
		<?php } 


		//生成视频
		function html_video(){ ?>
		<form method="post" name="form" target="iframe">
			<table class="tb tb2">
				<tr><th class="partition">生成视频</th></tr>
			</table>
			<table class="tb tb2">
				<tr>
					<td>
						<select name="listid">
						<option value="0">所有栏目</option>
						<?php
						global $db;
						$sql="select * from ".tname('video_class')." order by in_id asc";
						$result=$db->query($sql);
						if($result){
							while ($row=$db->fetch_array($result)){
								echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
							}
						}
						?>
						</select>
					</td>
					<td><input type="submit" class="btn" value="生成栏目" onclick="form.action='?iframe=html_list&table=video_class'" /></td>
				</tr>
				<tr>
					<td>
						<select name="classid">
							<option value="0">所有视频</option>
							<?php
							$sql="select * from ".tname('video_class')." order by in_id asc";
							$result=$db->query($sql);
							if($result){
								while ($row=$db->fetch_array($result)){
									echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
								}
							}
							?>
						</select>
					</td>
					<td><input type="submit" class="btn" value="生成视频" onclick="form.action='?iframe=html_info&table=video&ac=class'" /></td>
				</tr>
				<tr>
					<td>
						<select name="dayid">
							<option value="0">今天更新</option>
							<option value="1">昨天更新</option>
							<option value="2">前天更新</option>
						</select>
					</td>
					<td><input type="submit" class="btn" value="生成视频" onclick="form.action='?iframe=html_info&table=video&ac=day'" /></td>
				</tr>
			</table>
		</form>
		<?php } 

		//新增Article模块
		function html_article(){ ?>
		<form method="post" name="form" target="iframe">
		<table class="tb tb2">
			<tr><th class="partition">生成文章</th></tr>
		</table>
		<table class="tb tb2">
			<tr>
				<td>
					<select name="listid">
						<option value="0">所有栏目</option>
						<?php
						global $db;
						$sql="select * from ".tname('article_class')." order by in_id asc";
						$result=$db->query($sql);
						if($result){
							while ($row=$db->fetch_array($result)){
								echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
							}
						}
						?>
					</select>
				</td>
				<td><input type="submit" class="btn" value="生成栏目" onclick="form.action='?iframe=html_list&table=article_class'" /></td>
			</tr>
			<tr>
				<td>
				<select name="classid">
					<option value="0">所有文章</option>
					<?php
					$sql="select * from ".tname('article_class')." order by in_id asc";
					$result=$db->query($sql);
					if($result){
						while ($row=$db->fetch_array($result)){
							echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
						}
					}
					?>
				</select>
				</td>
				<td><input type="submit" class="btn" value="生成文章" onclick="form.action='?iframe=html_info&table=article&ac=class'" /></td>
			</tr>
			<tr>
				<td>
					<select name="dayid">
						<option value="0">今天更新</option>
						<option value="1">昨天更新</option>
						<option value="2">前天更新</option>
					</select>
				</td>
				<td><input type="submit" class="btn" value="生成文章" onclick="form.action='?iframe=html_info&table=article&ac=day'" /></td>
			</tr>
		</table>
		</form>
		<?php }

	function html_bottom(){ ?>
		<h3>MixMusic 提示</h3>
			<div class="infobox"><iframe name="iframe" frameborder="0" width="100%" height="100%" src="?iframe=html&action=mainjump"></iframe></div>
		</div>
    </body>
</html>
<?php } ?>
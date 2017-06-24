<?php
	if(!defined('IN_ROOT')){exit('Access denied');}
	Administrator(3);
	$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>">
	<meta http-equiv="x-ua-compatible" content="ie=7" />
	<title>模板方案</title>
	<link href="static/admincp/css/main.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="static/pack/layer/jquery.js"></script>
	<script type="text/javascript" src="static/pack/layer/confirm-lib.js"></script>
	<script type="text/javascript">
		function del_msg(href) {
			$.layer({
				shade: [0],
				area: ['auto', 'auto'],
				dialog: {
					msg: '卸载操作不可逆，确认继续？',
					btns: 2,
					type: 4,
					btn: ['确认', '取消'],
					yes: function() {
						location.href = href;
					},
					no: function() {
						layer.msg('已取消卸载', 1, 0);
					}
				}
			});
		}
	</script>
</head>
<body>
	<?php
	switch($action){
		case 'setting':
			Setting();
			break;
		case 'savesetting':
			SaveSetting();
			break;
		case 'temp':
			Temp();
			break;
		case 'del':
			Del();
			break;
		case 'templist':
			TempList();
			break;
		case 'save':
			Save();
			break;
		case 'delfile':
			DelFile();
			break;
		case 'copyfile':
			CopyFile();
			break;
		default:
			global $develop_auth;
			main($develop_auth);
			break;
		}
	?>
	</body>
</html>
<?php
	function Setting(){
		$in_id = SafeRequest("in_id","get");
		$in_name = getfield('template', 'in_name', 'in_id', $in_id);
		$in_path = getfield('template', 'in_path', 'in_id', $in_id);
		$temp = substr($in_path, 0, strrpos(str_replace('//', '', $in_path.'/'), '/') + 1);
?>
<div class="container">
	<script type="text/javascript">
		parent.document.title = 'MixMusic 管理中心 - 风格 - 设置模板';
		if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML = '风格&nbsp;&raquo;&nbsp;设置模板';
	</script>
	<div class="floattop">
		<div class="itemtitle"><h3>设置模板</h3></div>
	</div>
	
	<table class="tb tb2">
		<tr><th class="partition"><?php echo $in_name; ?></th></tr>
	</table>
	<table class="tb tb2">
		<form action="?iframe=skin&action=savesetting&in_id=<?php echo $in_id; ?>" method="post">
		<tr><td colspan="2">模板名称:</td></tr>
		<tr><td class="vtop rowform"><input type="text" class="txt" value="<?php echo $in_name; ?>" name="in_name"></td><td class="vtop tips2">默认项目</td></tr>
		<?php
			if($xml = @simplexml_load_file($temp.'setting.xml')){
				foreach($xml->item as $key){
					echo '<tr><td colspan="2">'.trim(detect_encoding($key['title'])).':</td></tr>';
					if(trim($key['type']) == 'select'){
						echo '<tr><td class="vtop rowform"><select name="setting[]"><option value="0">禁用</option><option value="1"'.(trim($key['value']) == 1 ? ' selected' : '').'>启用</option></select></td></tr>';
					}else{
						echo '<tr><td class="vtop rowform"><input type="text" class="txt" value="'.trim(detect_encoding($key['value'])).'" name="setting[]"></td></tr>';
					}
				}
			}
		?>
		<tr><td colspan="15"><div class="fixsel"><input name="edit" type="submit" class="btn" value="提交" /></div></td></tr>
		</form>
	</table>
</div>
<?php }

function TempList(){
	if(is_file(SafeRequest("path","get").SafeRequest("file","get"))){
	?>
	<div class="container">
		<script type="text/javascript">parent.document.title = 'MixMusic 管理中心 - 风格 - 编辑模板';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='风格&nbsp;&raquo;&nbsp;编辑模板';</script>
		<div class="floattop">
			<div class="itemtitle"><h3>编辑模板</h3></div>
		</div>
		
		<table class="tb tb2">
			<tr><th class="partition"><?php echo SafeRequest("tempname","get"); ?></th></tr>
		</table>
		<table class="tb tb2">
			<form action="?iframe=skin&action=save" method="post">
				<tr>
					<td class="vtop rowform"><input type="text" class="txt" value="<?php echo SafeRequest("file","get"); ?>" name="file"></td>
				</tr>
				<tr class="noborder">
					<td class="vtop rowform"><textarea rows="30" name="content" style="width:700px;"><?php echo file_get_contents(SafeRequest("path","get").SafeRequest("file","get")); ?></textarea></td>
					<td class="vtop tips2"></td>
				</tr>
				<tr>
					<td colspan="15"><div class="fixsel"><input type="hidden" name="path" value="<?php echo SafeRequest("path","get"); ?>"><input name="tempname" type="hidden" value="<?php echo SafeRequest("tempname","get"); ?>"><input name="save" type="submit" class="btn" value="提交修改" /> &nbsp; <input type="button" class="btn" value="返回" onclick="location.href='?iframe=skin&action=templist&tempname=<?php echo SafeRequest("tempname","get"); ?>&path=<?php echo SafeRequest("path","get"); ?>';"></div></td>
				</tr>
			</form>
		</table>
	</div>

<?php
	}else{
	$dir = SafeRequest("path","get");
	$path = !empty($dir) ? $dir : getcwd();
?>
	<div class="container">
		<script type="text/javascript">parent.document.title = 'MixMusic 管理中心 - 风格 - 浏览模板';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='风格&nbsp;&raquo;&nbsp;浏览模板';</script>
		<div class="floattop">
			<div class="itemtitle"><h3>浏览模板</h3></div>
		</div>
		

		<table class="tb tb2">
			<tr><th class="partition"><?php echo SafeRequest("tempname","get"); ?></th></tr>
		</table>

		<table class="tb tb2">
			<tr class="header">
				<th>模板名称</th>
				<th>模板类型</th>
				<th>文件大小</th>
				<th>修改时间</th>
				<th>编辑操作</th>
			</tr>
			<?php
			if(is_dir($path)){
				$d = dir($path);
				$d->rewind();
				while(false !== ($v = $d->read())){
					$file = $d->path.$v;
				if($v == "." || $v == ".."){
					continue;
				}elseif(is_dir($file)){
					continue;
				}elseif(is_file($file)){
			?>
			<tr class="hover">
				<td><a href="?iframe=skin&action=templist&tempname=<?php echo SafeRequest("tempname","get"); ?>&path=<?php echo $path; ?>&file=<?php echo $v; ?>" class="act"><?php echo $v; ?></a></td>
				<td><?php echo getTemplateType($v); ?></td>
				<td><?php echo round(filesize($file) / 1204, 2).' KB'; ?></td>
				<td><?php echo date('Y-m-d H:i:s', filemtime($file)); ?></td>
				<td><a href="?iframe=skin&action=templist&tempname=<?php echo SafeRequest("tempname","get"); ?>&path=<?php echo $path; ?>&file=<?php echo $v; ?>" class="act">编辑</a><a href="?iframe=skin&action=copyfile&tempname=<?php echo SafeRequest("tempname","get"); ?>&path=<?php echo $path; ?>&file=<?php echo $v; ?>" class="act">复制</a><a href="?iframe=skin&action=delfile&tempname=<?php echo SafeRequest("tempname","get"); ?>&path=<?php echo $path; ?>&file=<?php echo $v; ?>" class="act">删除</a></td>
			</tr>
		<?php }
			}
			$d->close();
		} ?>
		</table>
	</div>

<?php }
}
function main($develop_auth){
	global $db;
	$sql="select * from ".tname('template');
	$result=$db->query($sql);
	$count=$db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
?>
	<div class="container">
		<script type="text/javascript">
			parent.document.title = 'MixMusic 管理中心 - 风格 - 模板方案';
			if(parent.$('admincpnav')) {
				parent.$('admincpnav').innerHTML='风格&nbsp;&raquo;&nbsp;模板方案';
			}
		</script>
		
		<div class="floattop">
			<div class="itemtitle">
				<h3>模板方案</h3>
			</div>
		</div>

		<table class="tb tb2">
		<?php if($count==0){ ?>
			<tr><td colspan="2"><strong>没有模板方案</strong></td></tr>
			<tr>
		<?php
		}else{
			if($result){
				while($row = $db->fetch_array($result)){
					$temp = substr($row['in_path'], 0, strrpos(str_replace('//', '', $row['in_path'].'/'), '/') + 1);
		?>
				<td colspan="2" width="30%">
					<div class="template-thumb">
						<p><img width="100%" height="160" style="cursor:pointer" onclick="location.href='?iframe=skin&action=templist&tempname=<?php echo $row['in_name']; ?>&path=<?php echo $row['in_path']; ?>';" title="<?php echo $row['in_name']; ?>" onerror="this.src='static/admincp/css/preview.gif'" src="<?php echo $temp; ?>preview.jpg" /></p>
					</div>
					<div class="template-name-path">	
						<p><?php echo $row['in_name']; ?></p>
						<p><?php echo $row['in_path']; ?></p>
					</div>
					<div class="tepmlate-setting">
						<span class="fixsel"><input type="button" <?php if($row['in_default'] == 1){ ?> class="btn active" value="已为默认" disabled="disabled"<?php }else{ ?> class="btn" value="设为默认" onclick="location.href='?iframe=skin&action=temp&in_id=<?php echo $row['in_id']; ?>';"<?php } ?> /></span>
						<span class="fixsel"><input type="button" class="btn" value="手机版" onclick="location.href='?iframe=skin&action=templist&tempname=<?php echo $row['in_name']; ?>&path=<?php echo $temp; ?>mobile/html/';" /></span>
						<span class="fixsel"><input type="button" class="btn" value="设置" onclick="location.href='?iframe=skin&action=setting&in_id=<?php echo $row['in_id']; ?>';" /></span>
						<span class="fixsel"><input type="button" class="btn"<?php if($row['in_default'] == 1){ ?> value="保留" disabled="disabled"<?php }else{ ?> value="卸载" onclick="del_msg('?iframe=skin&action=del&in_id=<?php echo $row['in_id']; ?>');"<?php } ?> /></span>
					</div>
				</td>
			
		<?php }
			}
		}?>
</tr>
		</table>
	</div>

<?php }

	//复制模板文件
	function CopyFile(){
		$tempname = SafeRequest("tempname","get");
		$path = SafeRequest("path","get");
		$file = SafeRequest("file","get");
		if(copy($path.$file, $path."复件 ".$file)){
			ShowMessage("恭喜您，模板文件{".$file."}复制成功！","?iframe=skin&action=templist&tempname=".$tempname."&path=".$path,"infotitle2",1000,1);
		}
	}

	//删除模板文件
	function DelFile(){
		$tempname = SafeRequest("tempname","get");
		$path = SafeRequest("path","get");
		$file = SafeRequest("file","get");
		if(file_exists($path.$file)){
			unlink($path.$file);
			ShowMessage("恭喜您，模板文件删除成功！","?iframe=skin&action=templist&tempname=".$tempname."&path=".$path,"infotitle2",1000,1);
		}else{
			ShowMessage("删除失败，模板文件不存在！","?iframe=skin&action=templist&tempname=".$tempname."&path=".$path,"infotitle3",3000,1);
		}
	}

	//编辑模板文件
	function Save(){
		if(!submitcheck('save')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$file = SafeRequest("file","post");
		$path = SafeRequest("path","post");
		$tempname = SafeRequest("tempname","post");
		$content = stripslashes(SafeRequest("content","post",1));
		if(strtolower(substr(strrchr($file, '.'), 1)) == "html"){
			if(!$fp = fopen($path.$file, 'w')){
				ShowMessage("修改失败，模板文件{".$path.$file."}没有写入权限！","?iframe=skin&action=templist&tempname=".$tempname."&path=".$path,"infotitle3",3000,1);
			}
			$ifile = new iFile($path.$file, 'w');
			$ifile->WriteFile($content, 3);
			ShowMessage("恭喜您，模板文件修改成功！","?iframe=skin&action=templist&tempname=".$tempname."&path=".$path,"infotitle2",1000,1);
		}else{
			ShowMessage("保存出错，模板文件扩展名不规范！","?iframe=skin&action=templist&tempname=".$tempname."&path=".$path,"infotitle3",3000,1);
		}
	}

	//删除模板方案
	function Del(){
		global $db;
		$in_id = intval(SafeRequest("in_id","get"));
		$row = $db->getrow("select * from ".tname('template')." where in_id=".$in_id);
		$template = substr($row['in_path'], 0, strrpos(str_replace('//', '', $row['in_path'].'/'), '/') + 1);
			if(@include_once($template.'function.php')){
			style_uninstall();
			}
		$sql="delete from ".tname('template')." where in_id=".$in_id;
		if($db->query($sql)){
			destroyDir($template);
			ShowMessage("恭喜您，模板方案卸载成功！","?iframe=skin","infotitle2",1000,1);
		}
	}

	//编辑模板方案
	function SaveSetting(){
		if(!submitcheck('edit')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_id = SafeRequest("in_id","get");
		$in_name = SafeRequest("in_name","post");
		$in_path = getfield('template', 'in_path', 'in_id', $in_id);
		$temp = substr($in_path, 0, strrpos(str_replace('//', '', $in_path.'/'), '/') + 1);
		IsNul($in_name) or ShowMessage("修改出错，模板名称不能为空！","history.back(1);","infotitle3",3000,2);
		if(is_file($temp.'setting.xml')){
			$content = file_get_contents($temp.'setting.xml');
			preg_match_all('/<item(.*?)>/', $content, $array);
			for($i=0;$i<count($_POST['setting']);$i++){
				$edit = preg_replace('/value="(.*?)"/', 'value="'.convert_xmlcharset(SafeSql($_POST['setting'][$i]), 1).'"', $array[0][$i]);
				$content = str_replace($array[0][$i], $edit, $content);
			}
			$ifile = new iFile($temp.'setting.xml', 'w');
			$ifile->WriteFile($content, 3);
		}
		updatetable('template', array('in_name' => $in_name), array('in_id' => $in_id));
		ShowMessage("恭喜您，模板方案修改成功！","?iframe=skin","infotitle2",1000,1);
	}

	//切换模板方案
	function Temp(){
		global $db;
		$in_id = intval(SafeRequest("in_id","get"));
		if($db->query("update ".tname('template')." set in_default=0")){
			$db->query("update ".tname('template')." set in_default=1 where in_id=".$in_id);
			ShowMessage("恭喜您，模板方案设为默认成功！","?iframe=skin","infotitle2",1000,1);
		}
	}

	function getTemplateType($filename){
		switch(strtolower($filename)){
			case 'index.html':
				$Type="首页文件";
				break;
			case "search.html":
				$Type="音乐搜索";
				break;
			case "special_search.html":
				$Type="专辑搜索";
				break;
			case "singer_search.html":
				$Type="歌手搜索";
				break;
			case "video_search.html":
				$Type="视频搜索";
				break;
			case "class.html":
				$Type="音乐栏目";
				break;
			case "special_class.html":
				$Type="专辑栏目";
				break;
			case "singer_class.html":
				$Type="歌手栏目";
				break;
			case "video_class.html":
				$Type="视频栏目";
				break;
			case "music.html":
				$Type="音乐内容";
				break;
			case "special.html":
				$Type="专辑内容";
				break;
			case "singer.html":
				$Type="歌手内容";
				break;
			case "video.html":
				$Type="视频内容";
				break;
				
			//新增Article模块	
			case "article_class.html":
				$Type="文章栏目";
				break;
			case "article.html":
				$Type="文章内容";
				break;
			case "article_search.html":
				$Type="文章搜索";
				break;
			default:
				if(stristr($filename, '.html')){
					$Type="模板拓展";
				}else{
					$Type="其它文件";
				}
		}
		return $Type;
	}
?>
<?php
	if(!defined('IN_ROOT')){exit('Access denied');}
	Administrator(4);
	$action=SafeRequest("action","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
		<meta http-equiv="x-ua-compatible" content="ie=7" />
		<title>音乐管理</title>
		<link href="static/admincp/css/main.css" rel="stylesheet" type="text/css" />
		<link href="static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="static/pack/asynctips/jquery.min.js"></script>
		<script type="text/javascript" src="static/pack/asynctips/asyncbox.v1.4.5.js"></script>
		<script type="text/javascript" src="static/pack/layer/jquery.js"></script>
		<script type="text/javascript" src="static/pack/layer/lib.js"></script>
	</head>
<body>
	<?php
		switch($action){
			case 'add':
				Add();
				break;
			case 'saveadd':
				SaveAdd();
				break;
			case 'edit':
				Edit();
				break;
			case 'saveedit':
				SaveEdit();
				break;
			case 'alldel':
				AllDel();
				break;
			case 'editpassed':
				EditPassed();
				break;
			case 'list':
				$in_classid=intval(SafeRequest("in_classid","get"));
				main("select * from ".tname('music')." where in_classid=".$in_classid." order by in_addtime desc",20);
				break;
			case 'special':
				$in_specialid=intval(SafeRequest("in_specialid","get"));
				main("select * from ".tname('music')." where in_specialid=".$in_specialid." order by in_addtime desc",20);
				break;
			case 'singer':
				$in_singerid=intval(SafeRequest("in_singerid","get"));
				main("select * from ".tname('music')." where in_singerid=".$in_singerid." order by in_addtime desc",20);
				break;
			case 'keyword':
				$key=SafeRequest("key","get");
				main("select * from ".tname('music')." where in_name like '%".$key."%' or in_uname like '%".$key."%' order by in_addtime desc",20);
				break;
			case 'pass':
				main("select * from ".tname('music')." where in_passed=1 order by in_addtime desc",20);
				break;
			case 'wrong':
				main("select * from ".tname('music')." where in_wrong=1 order by in_addtime desc",20);
				break;
			default:
				main("select * from ".tname('music')." order by in_addtime desc",20);
				break;
		}
	?>
</body>
</html>
<?php
	function EditBoard($Arr,$url,$arrname){
		global $db,$action;
		$one = $db->getone("select in_userid from ".tname('user')." where in_username='".$_COOKIE['in_adminname']."'");
		$in_name = $Arr[0];
		$in_classid = $Arr[1];
		$in_specialid = $Arr[2];
		$in_singerid = $Arr[3];
		$in_uname = !IsNul($Arr[4]) && $one ? $_COOKIE['in_adminname'] : $Arr[4];
		$in_audio = $Arr[5];
		$in_lyric = $Arr[6];
		$in_text = $Arr[7];
		$in_cover = $Arr[8];
		$in_tag = $Arr[9];
		$in_color = $Arr[10];
		$in_points = !IsNum($Arr[11]) ? 0 : $Arr[11];
		$in_grade = $Arr[12];
		$in_best = $Arr[13];
		if(IN_UPOPEN == 1){
			$script = 'source/pack/upload/save.php';
		}elseif(IN_REMOTE == 1){
			$script = 'source/plugin/'.IN_REMOTEPK.'/save.php';
			if(!is_file($script)){
				$script = 'source/pack/upload/save.php';
			}
		}else{
			$script = 'source/pack/ftp/save.php';
		}
	?>

	<script type="text/javascript" src="static/pack/layer/confirm-html.js"></script>

	<script type="text/javascript">
		var pop = {
			up: function(scrolling, text, url, width, height, top) {
				layer.open({
					type: 2,
					maxmin: true,
					title: text,
					content: [url, scrolling],
					area: [width, height],
					offset: top,
					shade: false
				});
			},
			record: function() {
				$.flayer({
					type: 1,
					title: '录制音频',
					area: ['auto', 'auto'],
					page: {html: '<object id="as_js" type="application/x-shockwave-flash" width="811" height="140"><param name="movie" value="static/pack/upload/record.swf" /><param name="wmode" value="transparent" /></object>'}
				});
			}
		}
		function f_getURL() {
			return '<?php echo $script; ?>';
		}
		function f_getMAX() {
			return 3600;
		}
		function f_getMIN() {
			return 10;
		}
		function f_complete(filename) {
			if (filename == 'error'){
				asyncbox.tips("保存出错，请重试！", "error", 3000);
			}else{
				document.form2.in_audio.value = filename;
				asyncbox.tips("恭喜，文件录制成功！", "success", 1000);
			}
			flayer.closeAll();
		}
		function CheckForm(){
			if(document.form2.in_name.value==""){
				asyncbox.tips("音乐名称不能为空，请填写！", "wait", 1000);
				document.form2.in_name.focus();
				return false;
			}else if(document.form2.in_classid.value=="0"){
				asyncbox.tips("所属栏目不能为空，请选择！", "wait", 1000);
				document.form2.in_classid.focus();
				return false;
			}else if(document.form2.in_uname.value==""){
				asyncbox.tips("所属会员不能为空，请填写！", "wait", 1000);
				document.form2.in_uname.focus();
				return false;
			}else if(document.form2.in_audio.value==""){
				asyncbox.tips("音频地址不能为空，请填写！", "wait", 1000);
				document.form2.in_audio.focus();
				return false;
			}else if(document.form2.in_points.value==""){
				asyncbox.tips("下载扣点不能为空，请填写！", "wait", 1000);
				document.form2.in_points.focus();
				return false;
			}else {
				return true;
			}
		}
	</script>
	<div class="container">
		<script type="text/javascript">parent.document.title = 'MixMusic 管理中心 - 内容 - <?php echo $arrname; ?>音乐';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;<?php echo $arrname; ?>音乐';</script>
		<div class="floattop">
			<div class="itemtitle">
				<ul class="tab1">
					<li><a href="?iframe=music"><span>所有音乐</span></a></li>
					<?php if($action=="add"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=music&action=add"><span>新增音乐</span></a></li>
					<li><a href="?iframe=music&action=pass"><span>待审音乐</span></a></li>
					<li><a href="?iframe=music&action=wrong"><span>报错音乐</span></a></li>
				</ul>
			</div>
		</div>

		

		<form action="<?php echo $url; ?>" method="post" name="form2">
			<table class="tb tb2">
			<tr>
				<td class="lightnum">
					音乐名称：<input type="text" class="txt width-200" value="<?php echo $in_name; ?>" name="in_name" id="in_name">
					<select name="in_color">
						<option value="">颜色</option>
						<option style="background-color:#88b3e6;color:#88b3e6" value="#88b3e6"<?php if($in_color=="#88b3e6"){echo " selected";} ?>>淡蓝</option>
						<option style="background-color:#0C87CD;color:#0C87CD" value="#0C87CD"<?php if($in_color=="#0C87CD"){echo " selected";} ?>>天蓝</option>
						<option style="background-color:#FF6969;color:#FF6969" value="#FF6969"<?php if($in_color=="#FF6969"){echo " selected";} ?>>粉红</option>
						<option style="background-color:#F34F34;color:#F34F34" value="#F34F34"<?php if($in_color=="#F34F34"){echo " selected";} ?>>深红</option>
						<option style="background-color:#93C366;color:#93C366" value="#93C366"<?php if($in_color=="#93C366"){echo " selected";} ?>>淡绿</option>
						<option style="background-color:#FA7A19;color:#FA7A19" value="#FA7A19"<?php if($in_color=="#FA7A19"){echo " selected";} ?>>黄色</option>
					</select>
				</td>
				<td class="lightnum">所属栏目：<select name="in_classid" id="in_classid">
						<option value="0">选择栏目</option>
						<?php
							$sql="select * from ".tname('class')." order by in_id asc";
							$result=$db->query($sql);
							if($result){
								while ($row = $db->fetch_array($result)){
									if($in_classid==$row['in_id']){
										echo "<option value=\"".$row['in_id']."\" selected=\"selected\">".$row['in_name']."</option>";
									}else{
										echo "<option value=\"".$row['in_id']."\">".$row['in_name']."</option>";
									} 
								} 
							}
						?>
					</select>
				</td>
			</tr>

			<tr>
				<td>所属专辑：<select name="in_specialid" id="in_specialid">
					<option value="0">不选择</option>
					<?php
						$res=$db->query("select * from ".tname('special')." order by in_addtime desc");
						if($res){
							while ($row = $db->fetch_array($res)){
								if($in_specialid==$row['in_id']){
									echo "<option value=\"".$row['in_id']."\" selected=\"selected\">".getlenth($row['in_name'], 10)."</option>";
								}else{
									echo "<option value=\"".$row['in_id']."\">".getlenth($row['in_name'], 10)."</option>";
								}
							}
						}
					?>
					</select>
					<a href="javascript:void(0)" onclick="pop.up('yes', '选择专辑', 'source/pack/tag/special_opt.php?so=form2.in_specialid', '500px', '400px', '65px');" class="addtr">选择</a>
				</td>
				<td>所属会员：<input type="text" class="txt" value="<?php echo $in_uname; ?>" name="in_uname" id="in_uname"></td>
			</tr>

			<tr>
				<td>所属歌手：<select name="in_singerid" id="in_singerid">
						<option value="0">不选择</option>
						<?php
							$res=$db->query("select * from ".tname('singer')." order by in_addtime desc");
							if($res){
								while ($row = $db->fetch_array($res)){
									if($in_singerid==$row['in_id']){
											echo "<option value=\"".$row['in_id']."\" selected=\"selected\">".getlenth($row['in_name'], 10)."</option>";
									}else{
											echo "<option value=\"".$row['in_id']."\">".getlenth($row['in_name'], 10)."</option>";
									}
								}
							}
						?>
					</select>
					<a href="javascript:void(0)" onclick="pop.up('yes', '选择歌手', 'source/pack/tag/singer_opt.php?so=form2.in_singerid', '500px', '400px', '65px');" class="addtr">选择</a>
				</td>
				<td>推荐星级：<select name="in_best" id="in_best">
						<option value="0">不推荐</option>
						<option value="1"<?php if($in_best==1){echo " selected";} ?>>一星</option>
						<option value="2"<?php if($in_best==2){echo " selected";} ?>>二星</option>
						<option value="3"<?php if($in_best==3){echo " selected";} ?>>三星</option>
						<option value="4"<?php if($in_best==4){echo " selected";} ?>>四星</option>
						<option value="5"<?php if($in_best==5){echo " selected";} ?>>五星</option>
					</select>
				</td>
			</tr>

			<tr>
				<td>下载权限：<select name="in_grade" id="in_grade">
						<option value="3">游客下载</option>
						<option value="2"<?php if($in_grade==2){echo " selected";} ?>>普通用户</option>
						<option value="1"<?php if($in_grade==1){echo " selected";} ?>>绿钻会员</option>
					</select>
				</td>
				<td>下载扣点：<input type="text" class="txt" value="<?php echo $in_points; ?>" name="in_points" id="in_points" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
			</tr>

			<tr>
				<td>音乐标签：<input type="text" class="txt width-200" value="<?php echo $in_tag; ?>" name="in_tag" id="in_tag"><a href="javascript:void(0)" onclick="pop.up('yes', '添加标签', 'source/pack/tag/open.php?form=form2.in_tag', '540px', '400px', '65px');" class="addtr">添加</a></td>
			</tr>

			<tr>
				<td class="longtxt lightnum">音频地址：<input type="text" class="txt" value="<?php echo $in_audio; ?>" name="in_audio" id="in_audio"></td><td><input class="btn" type="button" value="上传音频" onclick="pop.up('no', '上传音频', 'source/pack/upload/open.php?type=music_audio&form=form2.in_audio', '406px', '180px', '175px');" />&nbsp;<a href="javascript:void(0)" onclick="pop.record();" class="addtr">录制音频</a></td>
			</tr>

			<tr>
				<td class="longtxt">封面地址：<input type="text" class="txt" value="<?php echo $in_cover; ?>" name="in_cover" id="in_cover"></td><td><input class="btn" type="button" value="上传封面" onclick="pop.up('no', '上传封面', 'source/pack/upload/open.php?type=music_cover&form=form2.in_cover', '406px', '180px', '175px');" /></td>
			</tr>

			<tr>
				<td class="longtxt">歌词地址：<input type="text" class="txt" value="<?php echo $in_lyric; ?>" name="in_lyric" id="in_lyric"></td><td><input class="btn" type="button" value="上传歌词" onclick="pop.up('no', '上传歌词', 'source/pack/upload/open.php?type=music_lyric&form=form2.in_lyric', '406px', '180px', '175px');" /></td>
			</tr>
			</table>

			<table class="tb tb2">
				<tr>
					<td><div style="height:100px;line-height:100px;float:left;">文本歌词：</div><textarea rows="6" cols="50" id="in_text" name="in_text" style="width:400px;height:100px;"><?php echo $in_text; ?></textarea></td>
				</tr>
				<tr>
					<td><input type="submit" class="btn" name="form2" value="提交" onclick="return CheckForm();" /><?php if($_GET['action']=="edit"){ ?><input type="hidden" name="in_addtime" value="<?php echo $Arr[14]; ?>"><input class="checkbox" type="checkbox" name="in_edittime" id="in_edittime" value="1" checked /><label for="in_edittime">更新时间</label><?php } ?></td>
				</tr>
			</table>
		</form>
	</div>
<?php } ?>

<?php
function main($sql,$size){
	global $db,$action;
	$Arr=getpagerow($sql,$size);
	$result=$Arr[1];
	$count=$Arr[2];
?>
	<script type="text/javascript" src="static/admincp/js/ajax.js"></script>
	<script type="text/javascript">
		function CheckAll(form) {
			for (var i = 0; i < form.elements.length; i++) {
				var e = form.elements[i];
				if (e.name != 'chkall') {
					e.checked = form.chkall.checked;
				}
			}
			all_save(form);
		}
		function s(){
			var k=document.getElementById("search").value;
			if(k==""){
				asyncbox.tips("请输入要查询的关键词！", "wait", 1000);
				document.getElementById("search").focus();
				return false;
			}else{
				document.btnsearch.submit();
			}
		}
		function all_save(form){
			if(form.chkall.checked){
				layer.tips('删除音乐不可逆，请谨慎操作！', '#chkall', {
					tips: 3
				});
			}
		}
	</script>
	<div class="container">
		<?php if(empty($action)){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 内容 - 所有音乐';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;所有音乐';</script>";} ?>
		<?php if($action=="pass"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 内容 - 待审音乐';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;待审音乐';</script>";} ?>
		<?php if($action=="wrong"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 内容 - 报错音乐';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;报错音乐';</script>";} ?>
		<?php if($action=="keyword"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 内容 - 搜索音乐';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;搜索音乐';</script>";} ?>
		<?php if($action=="list"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 内容 - 栏目音乐';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;栏目音乐';</script>";} ?>
		<?php if($action=="special"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 内容 - 专辑音乐';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;专辑音乐';</script>";} ?>
		<?php if($action=="singer"){echo "<script type=\"text/javascript\">parent.document.title = 'MixMusic 管理中心 - 内容 - 歌手音乐';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='内容&nbsp;&raquo;&nbsp;歌手音乐';</script>";} ?>
		<div class="floattop">
			<div class="itemtitle">
			<ul class="tab1">
				<?php if(empty($action)){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=music"><span>所有音乐</span></a></li>
				<li><a href="?iframe=music&action=add"><span>新增音乐</span></a></li>
				<?php if($action=="pass"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=music&action=pass"><span>待审音乐</span></a></li>
				<?php if($action=="wrong"){echo "<li class=\"current\">";}else{echo "<li>";} ?><a href="?iframe=music&action=wrong"><span>报错音乐</span></a></li>
			</ul>
		</div>
	</div>
	
	

	<table class="tb tb2">
		<tr><th class="partition">技巧提示</th></tr>
		<tr>
			<td class="tipsblock">
				<ul>
					<?php if(empty($action)){
						echo "<li>以下是所有的音乐</li>";
					}elseif($action=="pass"){
						echo "<li>以下是需要审核的音乐，不会在前台显示</li>";
					}elseif($action=="wrong"){
						echo "<li>以下是被报错的音乐，重新编辑可消除错误状态</li>";
					}elseif($action=="keyword"){
						echo "<li>以下是搜索“".SafeRequest("key","get")."”的音乐</li>";
					}elseif($action=="list"){
						echo "<li>以下是按栏目查看的音乐</li>";
					}elseif($action=="special"){
						echo "<li>以下是按专辑查看的音乐</li>";
					}elseif($action=="singer"){
						echo "<li>以下是按歌手查看的音乐</li>";
					}?>
					<li>可以输入音乐名称、所属会员等关键词进行搜索</li>
				</ul>
			</td>
		</tr>
	</table>

	<table class="tb tb2">
		<form name="btnsearch" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<tr>
			<td>
				<input type="hidden" name="iframe" value="music">
				<input type="hidden" name="action" value="keyword" />
				关键词：<input class="txt" x-webkit-speech type="text" name="key" id="search" value="" />
				<select onchange="location.href=this.options[this.selectedIndex].value;">
				<option value="?iframe=music">不限栏目</option>
				<?php
					$res=$db->query("select * from ".tname('class')." order by in_id asc");
					if($res){
						while($row = $db->fetch_array($res)){
							if(SafeRequest("in_classid","get")==$row['in_id']){
								echo "<option value=\"?iframe=music&action=list&in_classid=".$row['in_id']."\" selected=\"selected\">".$row['in_name']."</option>";
							}else{
								echo "<option value=\"?iframe=music&action=list&in_classid=".$row['in_id']."\">".$row['in_name']."</option>";
							}
						}
					}
				?>
				</select>

				<select onchange="location.href=this.options[this.selectedIndex].value;">
					<option value="?iframe=music">不限专辑</option>
					<?php
						$res=$db->query("select * from ".tname('special')." order by in_addtime desc");
						if($res){
							while($row = $db->fetch_array($res)){
								if(SafeRequest("in_specialid","get")==$row['in_id']){
									echo "<option value=\"?iframe=music&action=special&in_specialid=".$row['in_id']."\" selected=\"selected\">".getlenth($row['in_name'], 10)."</option>";
								}else{
									echo "<option value=\"?iframe=music&action=special&in_specialid=".$row['in_id']."\">".getlenth($row['in_name'], 10)."</option>";
								}
							}
						}
					?>
				</select>

				<select onchange="location.href=this.options[this.selectedIndex].value;">
					<option value="?iframe=music">不限歌手</option>
					<?php
						$res=$db->query("select * from ".tname('singer')." order by in_addtime desc");
						if($res){
							while($row = $db->fetch_array($res)){
								if(SafeRequest("in_singerid","get")==$row['in_id']){
									echo "<option value=\"?iframe=music&action=singer&in_singerid=".$row['in_id']."\" selected=\"selected\">".getlenth($row['in_name'], 10)."</option>";
								}else{
									echo "<option value=\"?iframe=music&action=singer&in_singerid=".$row['in_id']."\">".getlenth($row['in_name'], 10)."</option>";
								}
							}
						}
					?>
				</select>
				<input type="button" value="搜索" class="btn" onclick="s()" />
			</td>
		</tr>
	</form>
	</table>
	<form name="form" method="post" action="?iframe=music&action=alldel">
		<table class="tb tb2">
			<tr class="header">
				<th>编号</th>
				<th>音乐名称</th>
				<th>所属栏目</th>
				<th>所属会员</th>
				<th>推荐星级</th>
				<th>审核</th>
				<th>更新时间</th>
				<th>编辑操作</th>
				<th>查看</th>
			</tr>
			<?php if($count==0){ ?>
			<tr><td colspan="2">没有音乐</td></tr>
			<?php } if($result){ 
				while($row = $db->fetch_array($result)){
			?>
			<tr class="hover">
				<td class="width-50"><input class="checkbox" type="checkbox" name="in_id[]" id="in_id" value="<?php echo $row['in_id']; ?>"><?php echo $row['in_id']; ?></td>
				<td><a href="?iframe=music&action=edit&in_id=<?php echo $row['in_id']; ?>" class="act"><?php echo ReplaceStr($row['in_name'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
				<td><a href="?iframe=music&action=list&in_classid=<?php echo $row['in_classid']; ?>" class="act"><?php echo $row['in_classid']; ?></a>
				</td>
				<td><a href="<?php echo getlink($row['in_uid']); ?>" target="_blank" class="act"><?php echo ReplaceStr($row['in_uname'],SafeRequest("key","get"),"<em class=\"lightnum\">".SafeRequest("key","get")."</em>"); ?></a></td>
				<td id="in_best<?php echo $row['in_id']; ?>"><script type="text/javascript">ShowStar(<?php echo $row['in_best']; ?>, <?php echo $row['in_id']; ?>);</script></td>
				<td><?php if($row['in_passed']==1){ ?><a href="?iframe=music&action=editpassed&in_id=<?php echo $row['in_id']; ?>"><img src="static/admincp/css/pass_no.gif" /></a><?php }else{ ?><img src="static/admincp/css/pass_yes.gif" /><?php } ?></td>
				<td><?php if(date('Y-m-d',strtotime($row['in_addtime']))==date('Y-m-d')){echo "<em class=\"lightnum\">".date('Y-m-d',strtotime($row['in_addtime']))."</em>";}else{echo date('Y-m-d',strtotime($row['in_addtime']));} ?></td>
				<td><a href="?iframe=music&action=edit&in_id=<?php echo $row['in_id']; ?>" class="act">编辑</a></td>
				<td><a href="<?php echo getlink($row['in_id'], 'music'); ?>" target="_blank" class="act">预览</a></td>
			</tr>
			<?php } } ?>
		</table>
		<table class="tb tb2">
			<tr><td><input type="checkbox" id="chkall" class="checkbox" onclick="CheckAll(this.form);" /><label for="chkall">全选</label> &nbsp;&nbsp; <input type="submit" name="form" class="btn" value="批量删除" /></td></tr>
			<?php echo $Arr[0]; ?>
		</table>
	</form>
	</div>

<?php } ?>

<?php
	//审核
	function EditPassed(){
		global $db;
		$in_id = intval(SafeRequest("in_id","get"));
		$row = $db->getrow("select * from ".tname('music')." where in_id=".$in_id);
		$db->query("update ".tname('user')." set in_points=in_points+".IN_MUSICINPOINTS.",in_rank=in_rank+".IN_MUSICINRANK." where in_userid=".$row['in_uid']);
		$setarrs = array(
			'in_uid' => 0,
			'in_uname' => '系统用户',
			'in_uids' => $row['in_uid'],
			'in_unames' => $row['in_uname'],
			'in_content' => '恭喜，您分享的音乐“'.$row['in_name'].'”已通过审核！[金币+'.IN_MUSICINPOINTS.'][经验+'.IN_MUSICINRANK.']',
			'in_isread' => 0,
			'in_addtime' => date('Y-m-d H:i:s')
		);
		inserttable('message', $setarrs, 1);
		$sql="update ".tname('music')." set in_passed=0 where in_id=".$row['in_id'];
		if($db->query($sql)){
			ShowMessage("恭喜您，音乐审核成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
		}
	}

	//批量删除
	function AllDel(){
		global $db;
		if(!submitcheck('form')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_id=RequestBox("in_id");
		if($in_id==0){
			ShowMessage("批量删除失败，请先勾选要删除的音乐！",$_SERVER['HTTP_REFERER'],"infotitle3",3000,1);
		}else{
			$query = $db->query("select * from ".tname('music')." where in_id in ($in_id)");
			while ($row = $db->fetch_array($query)) {
				SafeDel('music', 'in_audio', $row['in_id']);
				SafeDel('music', 'in_lyric', $row['in_id']);
				SafeDel('music', 'in_cover', $row['in_id']);
				$db->query("delete from ".tname('favorites')." where in_mid=".$row['in_id']);
				$db->query("delete from ".tname('listen')." where in_mid=".$row['in_id']);
				$db->query("delete from ".tname('comment')." where in_table='music' and in_tid=".$row['in_id']);
				$db->query("delete from ".tname('feed')." where in_icon='music' and in_tid=".$row['in_id']);
				$content='抱歉，您分享的音乐“'.$row['in_name'].'”未通过审核并被删除！';
				if($row['in_passed']==0){
		                        $db->query("update ".tname('user')." set in_points=in_points-".IN_MUSICOUTPOINTS.",in_rank=in_rank-".IN_MUSICOUTRANK." where in_userid=".$row['in_uid']);
		                        $content='抱歉，您分享的音乐“'.$row['in_name'].'”被删除！[金币-'.IN_MUSICOUTPOINTS.'][经验-'.IN_MUSICOUTRANK.']';
				}
				$setarrs = array(
					'in_uid' => 0,
					'in_uname' => '系统用户',
					'in_uids' => $row['in_uid'],
					'in_unames' => $row['in_uname'],
					'in_content' => $content,
					'in_isread' => 0,
					'in_addtime' => date('Y-m-d H:i:s')
				);
				inserttable('message', $setarrs, 1);
			}
			$sql="delete from ".tname('music')." where in_id in ($in_id)";
			if($db->query($sql)){
				ShowMessage("恭喜您，音乐批量删除成功！",$_SERVER['HTTP_REFERER'],"infotitle2",3000,1);
			}
		}
	}

	//编辑
	function Edit(){
		global $db;
		$in_id=intval(SafeRequest("in_id","get"));
		$sql="select * from ".tname('music')." where in_id=".$in_id;
		if($row=$db->getrow($sql)){
			$Arr=array($row['in_name'],$row['in_classid'],$row['in_specialid'],$row['in_singerid'],$row['in_uname'],$row['in_audio'],$row['in_lyric'],$row['in_text'],$row['in_cover'],$row['in_tag'],$row['in_color'],$row['in_points'],$row['in_grade'],$row['in_best'],$row['in_addtime']);
		}
		EditBoard($Arr,"?iframe=music&action=saveedit&in_id=".$in_id,"编辑");
	}

	//添加数据
	function Add(){
		$Arr=array("","","","","","","","","","","","","","","");
		EditBoard($Arr,"?iframe=music&action=saveadd","新增");
	}

	//保存添加数据
	function SaveAdd(){
		global $db;
		if(!submitcheck('form2')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_name = SafeRequest("in_name","post");
		$in_classid = SafeRequest("in_classid","post");
		$in_specialid = SafeRequest("in_specialid","post");
		$in_singerid = SafeRequest("in_singerid","post");
		$in_uname = SafeRequest("in_uname","post");
		$in_audio = checkrename(SafeRequest("in_audio","post"), 'attachment/music/audio');
		$in_lyric = checkrename(SafeRequest("in_lyric","post"), 'attachment/music/lyric');
		$in_text = SafeRequest("in_text","post");
		$in_cover = checkrename(SafeRequest("in_cover","post"), 'attachment/music/cover');
		$in_tag = SafeRequest("in_tag","post");
		$in_color = SafeRequest("in_color","post");
		$in_points = SafeRequest("in_points","post");
		$in_grade = SafeRequest("in_grade","post");
		$in_best = SafeRequest("in_best","post");
		$result=$db->query("select * from ".tname('user')." where in_username='".$in_uname."'");
		if($row=$db->fetch_array($result)){
			$db->query("Insert ".tname('music')." (in_name,in_classid,in_specialid,in_singerid,in_uid,in_uname,in_audio,in_lyric,in_text,in_cover,in_tag,in_color,in_hits,in_downhits,in_favhits,in_goodhits,in_badhits,in_points,in_grade,in_best,in_passed,in_wrong,in_addtime) values ('".$in_name."',".$in_classid.",".$in_specialid.",".$in_singerid.",".$row['in_userid'].",'".$row['in_username']."','".$in_audio."','".$in_lyric."','".$in_text."','".$in_cover."','".$in_tag."','".$in_color."',0,0,0,0,0,".$in_points.",".$in_grade.",".$in_best.",0,0,'".date('Y-m-d H:i:s')."')");
			$db->query("update ".tname('user')." set in_points=in_points+".IN_MUSICINPOINTS.",in_rank=in_rank+".IN_MUSICINRANK." where in_userid=".$row['in_userid']);
			ShowMessage("恭喜您，音乐新增成功！","?iframe=music","infotitle2",1000,1);
		}else{
			ShowMessage("新增失败，所属会员不存在！","history.back(1);","infotitle3",3000,2);
		}
	}

	//保存编辑数据
	function SaveEdit(){
		global $db;
		if(!submitcheck('form2')){ShowMessage("表单验证不符，无法提交！",$_SERVER['PHP_SELF'],"infotitle3",3000,1);}
		$in_id = intval(SafeRequest("in_id","get"));
		$in_name = SafeRequest("in_name","post");
		$in_classid = SafeRequest("in_classid","post");
		$in_specialid = SafeRequest("in_specialid","post");
		$in_singerid = SafeRequest("in_singerid","post");
		$in_uname = SafeRequest("in_uname","post");
		$in_audio = checkrename(SafeRequest("in_audio","post"), 'attachment/music/audio', getfield('music', 'in_audio', 'in_id', $in_id), 'edit', 'music', 'in_audio', $in_id);
		$in_lyric = checkrename(SafeRequest("in_lyric","post"), 'attachment/music/lyric', getfield('music', 'in_lyric', 'in_id', $in_id), 'edit', 'music', 'in_lyric', $in_id);
		$in_text = SafeRequest("in_text","post");
		$in_cover = checkrename(SafeRequest("in_cover","post"), 'attachment/music/cover', getfield('music', 'in_cover', 'in_id', $in_id), 'edit', 'music', 'in_cover', $in_id);
		$in_tag = SafeRequest("in_tag","post");
		$in_color = SafeRequest("in_color","post");
		$in_points = SafeRequest("in_points","post");
		$in_grade = SafeRequest("in_grade","post");
		$in_best = SafeRequest("in_best","post");
		$datetime = SafeRequest("in_edittime","post")==1 ? date('Y-m-d H:i:s') : SafeRequest("in_addtime","post");
		$old=$db->getrow("select * from ".tname('music')." where in_id=".$in_id);
		$result=$db->query("select * from ".tname('user')." where in_username='".$in_uname."'");
		if($row=$db->fetch_array($result)){
			if($old['in_passed']==0 && $old['in_uid']!==$row['in_userid']){
			        $db->query("update ".tname('user')." set in_points=in_points+".IN_MUSICINPOINTS.",in_rank=in_rank+".IN_MUSICINRANK." where in_userid=".$row['in_userid']);
			        $db->query("update ".tname('user')." set in_points=in_points-".IN_MUSICOUTPOINTS.",in_rank=in_rank-".IN_MUSICOUTRANK." where in_userid=".$old['in_uid']);
			}
			$db->query("update ".tname('music')." set in_name='".$in_name."',in_classid=".$in_classid.",in_specialid=".$in_specialid.",in_singerid=".$in_singerid.",in_uid=".$row['in_userid'].",in_uname='".$row['in_username']."',in_audio='".$in_audio."',in_lyric='".$in_lyric."',in_text='".$in_text."',in_cover='".$in_cover."',in_tag='".$in_tag."',in_color='".$in_color."',in_points=".$in_points.",in_grade=".$in_grade.",in_best=".$in_best.",in_wrong=0,in_addtime='".$datetime."' where in_id=".$in_id);
			ShowMessage("恭喜您，音乐编辑成功！",$_SERVER['HTTP_REFERER'],"infotitle2",1000,1);
		}else{
			ShowMessage("编辑失败，所属会员不存在！","history.back(1);","infotitle3",3000,2);
		}
	}
?>
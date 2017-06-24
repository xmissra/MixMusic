<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db,$userlogined,$missra_in_userid; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
	<meta http-equiv="x-ua-compatible" content="ie=7" />
	<title>发表新日志 - <?php echo IN_NAME; ?></title>
	<meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
	<meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
	<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
	<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/confirm-lib.js"></script>
	<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/lib.js"></script>
	<script type="text/javascript" src="<?php echo IN_PATH; ?>static/user/js/blog.js"></script>
	<script type="text/javascript">
		var in_path = '<?php echo IN_PATH; ?>';
		var guide_url = '<?php echo rewrite_mode('user.php/blog/me/'); ?>';
		var pop = {
			doodle: function() {
				$.layer({
					type: 1,
					title: '涂鸦板',
					area: ['auto', 'auto'],
					page: {html: '<embed src="<?php echo IN_PATH; ?>source/pack/doodle/image/doodle.swf" width="438" height="304" wmode="transparent" type="application/x-shockwave-flash"></embed>'}
				});
			}
		}
		layer.use('confirm-ext.js');
		function ongroup(_id) {
				if (_id < 0) {
				layer.prompt({title:'创建新分类'},function(title){addgroup(title);});
			}
		}
	</script>
	<style type="text/css">
		@import url(<?php echo IN_PATH; ?>static/user/css/style.css);
	</style>
</head>
<body>
	<?php include 'source/user/people/top.php'; ?>
	<div id="main">
		<?php include 'source/user/people/left.php'; ?>
		<div id="mainarea">
			<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/editor/editor_function.js"></script>
			<h2 class="title"><img src="<?php echo IN_PATH; ?>static/user/images/icon/blog.gif">日志</h2>
			<div class="tabs_header">
				<ul class="tabs">
					<li><a href="<?php echo rewrite_mode('user.php/blog/index/'); ?>"><span>大家的日志</span></a></li>
					<li><a href="<?php echo rewrite_mode('user.php/blog/friend/'); ?>"><span>好友的日志</span></a></li>
					<li><a href="<?php echo rewrite_mode('user.php/blog/me/'); ?>"><span>我的日志</span></a></li>
					<li class="null"><a href="<?php echo rewrite_mode('user.php/blog/add/'); ?>">发表新日志</a></li>
				</ul>
			</div>
			<form method="get" id="attachbody" onsubmit="addblog(this.id);return false;" class="c_form">
				<table cellspacing="4" cellpadding="4" width="100%" class="infotable">
					<tr>
						<td>
							<select id="classid" onchange="ongroup(this.value);">
								<option value="0">选择分类</option>
								<?php
									$result=$db->query("select * from ".tname('blog_group')." where in_uid=".$missra_in_userid." order by in_id desc");
									if($result){
										while ($row = $db->fetch_array($result)){
											echo "<option value=\"".$row['in_id']."\">".$row['in_title']."</option>";
										}
									}
								?>
								<option value="-1" style="color:red;">+新建分类</option>
							</select>
							<input type="text" class="t_input" size="60" id="title">
						</td>
					</tr>
					<tr><td><textarea class="userData" name="message" id="uchome-ttHtmlEditor" style="height:100%;width:100%;display:none;border:0px"></textarea><iframe src="<?php echo IN_PATH; ?>static/pack/editor/editor.php" name="uchome-ifrHtmlEditor" id="uchome-ifrHtmlEditor" scrolling="no" border="0" frameborder="0" style="width:100%;border: 1px solid #C5C5C5;" height="400"></iframe></td></tr>
					<tr><td><input type="submit" class="submit" value="立即发表" /></td></tr>
				</table>
			</form>
		</div>
		<div id="bottom"></div>
	</div>
	<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
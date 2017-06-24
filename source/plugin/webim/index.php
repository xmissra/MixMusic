<?php
if(!defined('IN_ROOT')){exit('Access denied');}
global $userlogined,$missra_in_userid;
if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();}
include 'source/plugin/webim/config.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<title>即时通讯 - <?php echo IN_NAME; ?></title>
<link href="<?php echo IN_PATH; ?>source/plugin/webim/api/chat.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/jquery.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/layer/confirm-lib.js"></script>
<script type="text/javascript">
var in_path = '<?php echo IN_PATH; ?>';
var in_time = <?php echo in_plugin_webim_time; ?>;
var in_num = <?php echo in_plugin_webim_num; ?>;
var in_sec = <?php echo in_plugin_webim_sec; ?>;
var in_uid = <?php echo $missra_in_userid; ?>;
var in_space = '<?php echo getlink(0); ?>';
layer.use('confirm-ext.js');
</script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/upload/swfobject.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>source/plugin/webim/api/uploadify.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>source/plugin/webim/api/lib.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>source/plugin/webim/api/chat.js"></script>
<style type="text/css">@import url(<?php echo IN_PATH; ?>static/user/css/style.css);</style>
</head>
<body>
<?php include 'source/user/people/top.php'; ?>
<div id="main">
<?php include 'source/user/people/left.php'; ?>
<div id="mainarea">
<h2 class="title"><img src="<?php echo IN_PATH; ?>source/plugin/webim/icon.jpg">即时通讯</h2>
<?php if(in_plugin_webim_open){ ?>
<div id="menu_girl" style="display:none">
	<ul>
		<li id="space"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/space.png"> 访问主页</li>
		<li id="move"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/move.png"> 好友分组</li>
		<li id="del"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/del.png"> 删除好友</li>
	</ul>
</div>
<div id="menu_boy" style="display:none">
	<ul>
		<li id="space"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/space.png"> 访问主页</li>
		<li id="add"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/add.png"> 加为好友</li>
		<li id="lock"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/lock.png"> 锁定用户</li>
	</ul>
</div>
<div id="menu_group" style="display:none">
	<ul>
		<li id="insert"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/insert.png"> 新增分组</li>
		<li id="edit"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/edit.png"> 修改分组</li>
		<li id="cancel"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/cancel.png"> 删除分组</li>
	</ul>
</div>
<div id="menu_preset" style="display:none">
	<ul>
		<li id="insert"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/insert.png"> 新增分组</li>
	</ul>
</div>
<div id="content" style="width:732px">
	<div class="c_mgs">
		<div class="chatBox">
			<div class="chatLeft">
				<div class="chat01">
					<div class="chat01_title">
						<ul class="talkTo" num="0">
							<li><a uid=""></a></li>
						</ul>
						<a class="close_btn" title="清屏"></a>
					</div>
					<div class="chat01_content">
						<div class="message_box"></div>
					</div>
				</div>
				<div class="chat02">
					<div class="chat02_title">
						<a class="chat02_title_btn ctb00" id="_emoji"></a>
						<a class="chat02_title_btn ctb07" id="_record"></a>
						<a class="chat02_title_btn ctb02"></a>
						<a class="chat02_title_btn ctb03"></a>
						<a class="chat02_title_btn ctb04" id="_shake" title="窗口抖动"></a>
						<a class="chat02_title_btn ctb09" id="_upload" title="分享文件"><input type="file" name="uploadify" id="uploadify" /></a>
						<a class="chat02_title_btn ctb06" title="涂鸦板"></a>
						<div class="wl_faces_box">
							<div class="wl_faces_content">
								<div class="title">
									<ul>
										<li class="title_name">选择表情</li>
										<li class="wl_faces_close"><span>&nbsp;</span></li>
									</ul>
								</div>
								<div class="wl_faces_main">
									<ul>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_01.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_02.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_03.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_04.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_05.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_06.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_07.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_08.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_09.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_10.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_11.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_12.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_13.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_14.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_15.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_16.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_17.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_18.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_19.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_20.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_21.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_22.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_23.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_24.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_25.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_26.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_27.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_28.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_29.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_30.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_31.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_32.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_33.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_34.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_35.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_36.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_37.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_38.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_39.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_40.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_41.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_42.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_43.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_44.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_45.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_46.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_47.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_48.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_49.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_50.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_51.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_52.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_53.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_54.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_55.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_56.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_57.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_58.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_59.gif"></a></li>
										<li><a href="javascript:;"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/emo_60.gif"></a></li>
									</ul>
								</div>
							</div>
							<div class="wlf_icon">
							</div>
						</div>
						<div class="wl_faces_box8">
							<div class="wl_faces_content8">
								<div class="title">
									<ul>
										<li class="title_name">发送语音</li>
										<li class="wl_faces_close8"><span>&nbsp;</span></li>
									</ul>
								</div>
								<object id="as_js" type="application/x-shockwave-flash" width="100%" height="100%"><param name="movie" value="<?php echo IN_PATH; ?>static/pack/upload/record.swf" /><param name="wmode" value="transparent" /></object>
							</div>
							<div class="wlf_icon">
							</div>
						</div>
						<div class="wl_faces_box2">
							<div class="wl_faces_content2">
								<div class="title">
									<ul>
										<li class="title_name">网络图片</li>
										<li class="wl_faces_close2"><span>&nbsp;</span></li>
									</ul>
								</div>
								<textarea id="_img" onkeydown="lib.press('value', this.id, 'wl_faces_box2');" onfocus="javascript:if('按 Esc 键返回'==this.value)this.value=''" onblur="javascript:if(''==this.value)this.value='按 Esc 键返回'">按 Esc 键返回</textarea>
							</div>
							<div class="wlf_icon">
							</div>
						</div>
						<div class="wl_faces_box3">
							<div class="wl_faces_content3">
								<div class="title">
									<ul>
										<li class="title_name">网络视频</li>
										<li class="wl_faces_close3"><span>&nbsp;</span></li>
									</ul>
								</div>
								<textarea id="_flash" onkeydown="lib.press('value', this.id, 'wl_faces_box3');" onfocus="javascript:if('按 Esc 键返回'==this.value)this.value=''" onblur="javascript:if(''==this.value)this.value='按 Esc 键返回'">按 Esc 键返回</textarea>
							</div>
							<div class="wlf_icon">
							</div>
						</div>
					</div>
					<div class="chat02_content">
						<textarea id="textarea" onkeydown="lib.press('send', 0, 0);"></textarea>
					</div>
					<div class="chat02_bar">
						<ul>
							<li id="send_tips" style="right:100px;top:10px">按 Enter 键快捷发送</li>
							<li style="right:5px;top:5px"><a onclick="listenMsg.send();" style="cursor:pointer"><img src="<?php echo IN_PATH; ?>source/plugin/webim/api/send_btn.jpg"></a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="chatRight">
				<div class="chat03">
					<div class="chat03_title">
						<label class="chat03_title_t">用户列表</label>
						<label class="chat02_title_t" title="刷新列表" id="list_reload"></label>
					</div>
					<div class="chat03_content"><script type="text/javascript">listenMsg.load();</script></div>
				</div>
			</div>
			<div style="clear: both;">
			</div>
		</div>
	</div>
</div>
<?php }else{ ?>
<div class="showmessage"><div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">
<caption><h2>信息提示</h2></caption>
<p>抱歉，该插件暂未开启！</p>
</div></div></div></div></div>
<?php } ?>
</div>
<div id="bottom"></div>
</div>
<?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
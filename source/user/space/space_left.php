<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $db; ?>
<div id="space_page">
<div id="ubar">
<div id="space_avatar"><div><img src="<?php echo getavatar($ear['in_userid'], 'big'); ?>"></div></div>
<div class="borderbox">
<ul class="spacemenu_list" style="width:100%; overflow:hidden;">
<li><img src="<?php echo IN_PATH; ?>static/user/images/icon/message.gif"><a href="javascript:void(0)" onclick="layer.prompt({title:'给“<?php echo $ear['in_username']; ?>”发短消息',type:3},function(msg){sendmessage('<?php echo $ear['in_username']; ?>', msg);});">发送消息</a></li>
<li><img src="<?php echo IN_PATH; ?>static/user/images/icon/friend.gif"><a href="javascript:void(0)" onclick="pop.friend('<?php echo $ear['in_username']; ?>');">加为好友</a></li>
</ul>
</div><br />
<div id="space_mymenu">
<h2>个人菜单</h2>
<ul class="line_list">
<li><img src="<?php echo IN_PATH; ?>static/user/images/icon/space.gif"><a href="<?php echo getlink($ear['in_userid']); ?>">个人主页</a></li>
<li><img src="<?php echo IN_PATH; ?>static/user/images/icon/feed.gif"><a href="<?php echo getlink($ear['in_userid'], 's_feed'); ?>">说说</a><em>(<?php echo $db->num_rows($db->query("select count(*) from ".tname('feed')." where in_type=0 and in_uid=".$ear['in_userid'])); ?>)</em></li>
<li><img src="<?php echo IN_PATH; ?>static/user/images/icon/music.gif"><a href="<?php echo getlink($ear['in_userid'], 's_music'); ?>">音乐</a></li>
<li><img src="<?php echo IN_PATH; ?>static/user/images/icon/special.gif"><a href="<?php echo getlink($ear['in_userid'], 's_special'); ?>">专辑</a></li>
<li><img src="<?php echo IN_PATH; ?>static/user/images/icon/singer.gif"><a href="<?php echo getlink($ear['in_userid'], 's_singer'); ?>">歌手</a></li>
<li><img src="<?php echo IN_PATH; ?>static/user/images/icon/video.gif"><a href="<?php echo getlink($ear['in_userid'], 's_video'); ?>">视频</a></li>
<li><img src="<?php echo IN_PATH; ?>static/user/images/icon/photo.gif"><a href="<?php echo getlink($ear['in_userid'], 's_photo'); ?>">相册</a></li>
<li><img src="<?php echo IN_PATH; ?>static/user/images/icon/blog.gif"><a href="<?php echo getlink($ear['in_userid'], 's_blog'); ?>">日志</a></li>
<!-- <li><img src="<?php echo IN_PATH; ?>static/user/images/icon/article.gif"><a href="<?php //echo getlink($ear['in_userid'], 's_article'); ?>">文章</a></li> --> <!--新增Article模块-->
</ul>
</div>
</div>
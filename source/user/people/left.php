<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $userlogined; ?>
<div id="app_sidebar">
        <?php if($userlogined){ ?>
        <ul class="app_list">
                <li><img src="<?php echo IN_PATH; ?>static/user/images/icon/feed.gif"><a href="<?php echo rewrite_mode('user.php/feed/index/'); ?>">说说</a></li>
                <li><img src="<?php echo IN_PATH; ?>static/user/images/icon/music.gif"><a href="<?php echo rewrite_mode('user.php/music/index/'); ?>">音乐</a><em><a href="<?php echo rewrite_mode('user.php/music/add/'); ?>" class="gray">上传</a></em></li>
                <li><img src="<?php echo IN_PATH; ?>static/user/images/icon/special.gif"><a href="<?php echo rewrite_mode('user.php/special/index/'); ?>">专辑</a><em><a href="<?php echo rewrite_mode('user.php/special/add/'); ?>" class="gray">制作</a></em></li>
                <li><img src="<?php echo IN_PATH; ?>static/user/images/icon/singer.gif"><a href="<?php echo rewrite_mode('user.php/singer/index/'); ?>">歌手</a><em><a href="<?php echo rewrite_mode('user.php/singer/add/'); ?>" class="gray">创建</a></em></li>
                <li><img src="<?php echo IN_PATH; ?>static/user/images/icon/video.gif"><a href="<?php echo rewrite_mode('user.php/video/index/'); ?>">视频</a><em><a href="<?php echo rewrite_mode('user.php/video/add/'); ?>" class="gray">发布</a></em></li>
                <li><img src="<?php echo IN_PATH; ?>static/user/images/icon/photo.gif"><a href="<?php echo rewrite_mode('user.php/photo/index/'); ?>">照片</a></li>
                <li><img src="<?php echo IN_PATH; ?>static/user/images/icon/blog.gif"><a href="<?php echo rewrite_mode('user.php/blog/index/'); ?>">日志</a></li>
                <li><img src="<?php echo IN_PATH; ?>static/user/images/icon/friend.gif"><a href="<?php echo rewrite_mode('user.php/friend/index/'); ?>">好友</a></li>
                <li><img src="<?php echo IN_PATH; ?>static/user/images/icon/message.gif"><a href="<?php echo rewrite_mode('user.php/message/index/'); ?>">消息</a></li>
                <li><img src="<?php echo IN_PATH; ?>static/user/images/icon/rank.gif"><a href="<?php echo rewrite_mode('user.php/misc/rank/'); ?>">排行</a></li>
                <li><img src="<?php echo IN_PATH; ?>static/user/images/icon/search.gif"><a href="<?php echo rewrite_mode('user.php/misc/search/'); ?>">搜索</a></li>
                <li><img src="<?php echo IN_PATH; ?>static/user/images/icon/profile.gif"><a href="<?php echo rewrite_mode('user.php/profile/index/'); ?>">设置</a></li>
        </ul>
        <ul class="app_list topline"></ul>
        <?php echo left_plugin(); ?>
        <?php } else { ?>
        <div class="bar_text">
            <form method="get" onsubmit="login(2);return false;">
                <p class="title">登录本站</p>
                <p>用户名</p>
                <p><input type="text" id="username" class="t_input" size="15" /></p>
                <p>密　码</p>
                <p><input type="password" id="password" class="t_input" size="15" /></p>
                <p>验证码</p>
                <p><input type="text" id="seccode" class="t_input" style="width:45px;" maxlength="4" />&nbsp;<img id="img_seccode" src="<?php echo rewrite_mode('user.php/people/seccode/'); ?>" align="absmiddle" /></p>
                <p style="margin-top:5px;"><a href="javascript:update_seccode()">更换</a></p>
                <p style="margin-top:10px;"><input type="submit" value="登录" class="submit" />&nbsp;<input type="button" value="注册" class="button" onclick="location.href='<?php echo rewrite_mode('user.php/people/register/'); ?>';"></p>
                <p style="margin-top:10px;"><a href="javascript:void(0)" onclick="pop.up('no', 'QQ登录', in_path+'source/pack/connect/login.php', '700px', '430px', '100px');"><img src="<?php echo IN_PATH; ?>static/user/images/connect.gif" /></a></p>
            </form>
        </div>
        <?php } ?>
</div>
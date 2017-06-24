<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $userlogined,$missra_in_userid,$missra_in_username,$missra_in_points; ?>
<div id="append_parent"></div>
<div id="header">
        <div class="headerwarp">
                <h1 class="logo"><a href="<?php if($userlogined){echo rewrite_mode('user.php/people/home/');}else{echo IN_PATH.'user.php';} ?>"><img src="<?php echo IN_PATH; ?>static/user/images/logo.gif" /></a></h1>
                <div id="ucappmenu_menu" style="position:relative;z-index:9999;display:none">
                <ul class="dropmenu_drop">
                        <li><a href="<?php echo rewrite_mode('user.php/people/home/'); ?>">管理首页</a></li>
                        <li><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].IN_PATH; ?>" target="_blank">网站首页</a></li>
                </ul>
                </div>
                <ul class="menu">
                        <li class="dropmenu" style="cursor:pointer" onclick="if(document.getElementById('ucappmenu_menu').style.display==''){document.getElementById('ucappmenu_menu').style.display='none'}else{document.getElementById('ucappmenu_menu').style.display=''}"><a href="javascript:void(0)">首页</a></li>
                        <li><a href="<?php if($userlogined){echo getlink($missra_in_userid);}else{echo rewrite_mode('user.php/people/login/');} ?>">个人主页</a></li>
                        <li><a href="<?php echo rewrite_mode('user.php/friend/index/'); ?>">好友</a></li>
                        <li><a href="<?php echo IN_PATH; ?>user.php">随便看看</a></li>
                        <li><a href="<?php echo rewrite_mode('user.php/message/index/'); ?>">消息</a></li>
                        <?php if($userlogined && top_message($missra_in_userid)){ ?>
                        <li class="notify"><a href="<?php echo rewrite_mode('user.php/message/read/'); ?>"><?php echo top_message($missra_in_userid); ?>条私信</a></li>
                        <?php } ?>
                </ul>
                <div class="nav_account">
                        <?php if($userlogined){ ?>
                        <a href="<?php echo getlink($missra_in_userid); ?>" class="login_thumb"><img src="<?php echo getavatar($missra_in_userid); ?>"></a>
                        <a href="<?php echo getlink($missra_in_userid); ?>" class="loginName"><?php echo $missra_in_username; ?></a>
                        <a href="<?php echo rewrite_mode('user.php/profile/credit/'); ?>" style="font-size:11px;padding:0 0 0 5px;"><img src="<?php echo IN_PATH; ?>static/user/images/credit.gif"><?php echo $missra_in_points; ?></a><br />
                        <a href="<?php echo rewrite_mode('user.php/profile/index/'); ?>">个人设置</a> 
                        <a href="<?php echo rewrite_mode('user.php/people/logout/'); ?>">退出</a>
                        <?php }else{ ?>
                        <a href="<?php echo rewrite_mode('user.php/people/login/'); ?>" class="login_thumb"><img src="<?php echo getavatar(0); ?>"></a>欢迎您<br />
                        <a href="<?php echo rewrite_mode('user.php/people/login/'); ?>">登录</a> | 
                        <a href="<?php echo rewrite_mode('user.php/people/register/'); ?>">注册</a>
                        <?php } ?>
                </div>
        </div>
</div>
<div id="wrap">
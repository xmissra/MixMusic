<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<?php global $userlogined,$missra_in_rank,$missra_in_points,$missra_in_grade,$missra_in_vipgrade,$missra_in_vipindate,$missra_in_vipenddate; ?>
<?php if(!$userlogined){header("location:".rewrite_mode('user.php/people/login/'));exit();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
    <meta http-equiv="x-ua-compatible" content="ie=7" />
    <title>我的积分 - <?php echo IN_NAME; ?></title>
    <meta name="Keywords" content="<?php echo IN_KEYWORDS; ?>" />
    <meta name="Description" content="<?php echo IN_DESCRIPTION; ?>" />
    <style type="text/css">
            @import url(<?php echo IN_PATH; ?>static/user/css/style.css);
    </style>
</head>
<body>
    <?php include 'source/user/people/top.php'; ?>
    <div id="main">
        <?php include 'source/user/people/left.php'; ?>
        <div id="mainarea">
            <h2 class="title"><img src="<?php echo IN_PATH; ?>static/user/images/icon/profile.gif">个人设置</h2>
            <div class="tabs_header">
                <ul class="tabs">
                    <li><a href="<?php echo rewrite_mode('user.php/profile/index/'); ?>"><span>个人资料</span></a></li>
                    <li><a href="<?php echo rewrite_mode('user.php/profile/avatar/'); ?>"><span>我的头像</span></a></li>
                    <li class="active"><a href="<?php echo rewrite_mode('user.php/profile/credit/'); ?>"><span>积分账户</span></a></li>
                    <li><a href="<?php echo rewrite_mode('user.php/profile/oauth/'); ?>"><span>帐号绑定</span></a></li>
                </ul>
            </div>
            <div class="l_status c_form">
                <a href="<?php echo rewrite_mode('user.php/profile/credit/'); ?>" class="active">我的积分</a><span class="pipe">|</span>
                <a href="<?php echo rewrite_mode('user.php/profile/vip/'); ?>">开通绿钻</a><span class="pipe">|</span>
                <a href="<?php echo rewrite_mode('user.php/profile/pay/'); ?>">充值金币</a>
            </div>
            <div class="c_form">
                <table cellspacing="0" cellpadding="0" class="formtable">
                    <tr><th width="150">经验值:</th><td><span style="color:#3B5998;font-size:14px;"><?php echo $missra_in_rank; ?></span> <?php echo getlevel($missra_in_rank); ?></td></tr>
                    <tr>
                        <th width="150">&nbsp;</th>
                        <td class="gray">经验每满 <strong>100</strong> 个，图标就会升一级<br />
                            <?php
                            $level = '图标等级由低到高为：';
                            for($i=1;$i<11;$i++){
                                $level .= '<img src="'.IN_PATH.'static/user/images/level/star_level'.$i.'.gif" align="absmiddle">';
                            }
                            echo $level;
                            ?>
                        </td>
                    </tr>
                    <tr><th width="150">金币数:</th><td><img src="<?php echo IN_PATH; ?>static/user/images/credit.gif"> <span style="color:red;font-size:14px;"><?php echo $missra_in_points; ?></span></td></tr>
                    <tr>
                        <th width="150">用户等级:</th>
                        <td>
                        <?php
                            if($missra_in_grade == 0){
                                    echo '普通用户 <img src="'.IN_PATH.'static/user/images/vip/novip.jpg" align="absmiddle"></td></tr>';
                            }else{
                                if($missra_in_vipgrade == 1){
                                    echo '<span style="color:green;">月付绿钻</span> <img src="'.IN_PATH.'static/user/images/vip/vip.png" align="absmiddle"> <img src="'.IN_PATH.'static/user/images/vip/no_year_vip.jpg" align="absmiddle"></td></tr>';
                                }elseif($missra_in_vipgrade == 2){
                                    echo '<span style="color:green;">年付绿钻</span> <img src="'.IN_PATH.'static/user/images/vip/vip.png" align="absmiddle"> <img src="'.IN_PATH.'static/user/images/vip/year_vip.jpg" align="absmiddle"></td></tr>';
                                }
                                echo '<tr><th width="150">&nbsp;</th><td class="gray">业务于 <strong>'.$missra_in_vipindate.'</strong> 开通，将在 <strong>'.$missra_in_vipenddate.'</strong> 到期<br />';
                                echo '绿钻服务还剩 <strong style="color:green;">'.floor(DateDiff(date('Y-m-d H:i:s'), $missra_in_vipenddate) / 3600 / 24).'</strong> 天</td></tr>';
                            }
                        ?>
                </table>

                <br />

                <table cellspacing="0" cellpadding="0" class="listtable">
                    <caption>
                        <h2>积分奖励规则</h2>
                        <p>进行以下事件动作，会得到积分奖励。不过，在一个周期内，您最多得到的奖励次数有限制。</p>
                    </caption>
                    <thead>
                        <tr class="title">
                            <td>动作名称</td>
                            <td align="center">周期范围</td>
                            <td align="center">奖励金币</td>
                            <td align="center">奖励经验</td>
                        </tr>
                    </thead>
                    <tr class="line">
                        <td>注册用户</td>
                        <td align="center">一次性</td>
                        <td align="center"><?php echo IN_REGPOINTS; ?></td>
                        <td align="center"><?php echo IN_REGRANK; ?></td>
                    </tr>
                    <tr>
                        <td>每日登录</td>
                        <td align="center">每天</td>
                        <td align="center"><?php echo IN_LOGINDAYPOINTS; ?></td>
                        <td align="center"><?php echo IN_LOGINDAYRANK; ?></td>
                    </tr>
                    <tr>
                        <td>每日签到</td>
                        <td align="center">每天</td>
                        <td align="center"><?php echo IN_SIGNDAYPOINTS; ?>*连续签到天数</td>
                        <td align="center"><?php echo IN_SIGNDAYRANK; ?>*连续签到天数</td>
                    </tr>
                    <tr>
                        <td>上传头像</td>
                        <td align="center">一次性</td>
                        <td align="center"><?php echo IN_AVATARPOINTS; ?></td>
                        <td align="center"><?php echo IN_AVATARRANK; ?></td>
                    </tr>
                    <tr>
                        <td>验证邮箱</td>
                        <td align="center">一次性</td>
                        <td align="center"><?php echo IN_MAILPOINTS; ?></td>
                        <td align="center"><?php echo IN_MAILRANK; ?></td>
                    </tr>
                    <tr>
                        <td>审核音乐</td>
                        <td align="center">不限周期</td>
                        <td align="center"><?php echo IN_MUSICINPOINTS; ?></td>
                        <td align="center"><?php echo IN_MUSICINRANK; ?></td>
                    </tr>
                    <tr>
                        <td>审核专辑</td>
                        <td align="center">不限周期</td>
                        <td align="center"><?php echo IN_SPECIALINPOINTS; ?></td>
                        <td align="center"><?php echo IN_SPECIALINRANK; ?></td>
                    </tr>
                    <tr>
                        <td>审核歌手</td>
                        <td align="center">不限周期</td>
                        <td align="center"><?php echo IN_SINGERINPOINTS; ?></td>
                        <td align="center"><?php echo IN_SINGERINRANK; ?></td>
                    </tr>
                    <tr>
                        <td>审核视频</td>
                        <td align="center">不限周期</td>
                        <td align="center"><?php echo IN_VIDEOINPOINTS; ?></td>
                        <td align="center"><?php echo IN_VIDEOINRANK; ?></td>
                    </tr>
                    <!--新增Article模块-->
                    <tr>
                        <td>审核文章</td>
                        <td align="center">不限周期</td>
                        <td align="center"><?php echo IN_ARTICLEINPOINTS; ?></td>
                        <td align="center"><?php echo IN_ARTICLEINRANK; ?></td>
                    </tr>
                </table>

                <br />

                <table cellspacing="0" cellpadding="0" class="listtable">
                    <caption>
                        <h2>积分惩罚规则</h2>
                        <p>以下事件动作发生时，会扣减积分。其中，自己发布的信息自己删除，不扣减积分，被管理员删除才会扣减积分。</p>
                    </caption>
                    <thead>
                        <tr class="title">
                            <td>动作名称</td>
                            <td align="center">周期范围</td>
                            <td align="center">扣减金币</td>
                            <td align="center">扣减经验</td>
                        </tr>
                    </thead>
                    <tr class="line">
                        <td>删除音乐</td>
                        <td align="center">不限周期</td>
                        <td align="center"><?php echo IN_MUSICOUTPOINTS; ?></td>
                        <td align="center"><?php echo IN_MUSICOUTRANK; ?></td>
                    </tr>
                    <tr>
                        <td>删除专辑</td>
                        <td align="center">不限周期</td>
                        <td align="center"><?php echo IN_SPECIALOUTPOINTS; ?></td>
                        <td align="center"><?php echo IN_SPECIALOUTRANK; ?></td>
                    </tr>
                    <tr>
                        <td>删除歌手</td>
                        <td align="center">不限周期</td>
                        <td align="center"><?php echo IN_SINGEROUTPOINTS; ?></td>
                        <td align="center"><?php echo IN_SINGEROUTRANK; ?></td>
                    </tr>
                    <tr>
                        <td>删除视频</td>
                        <td align="center">不限周期</td>
                        <td align="center"><?php echo IN_VIDEOOUTPOINTS; ?></td>
                        <td align="center"><?php echo IN_VIDEOOUTRANK; ?></td>
                    </tr>
                    <!--新增Article模块-->
                    <tr>
                        <td>删除文章</td>
                        <td align="center">不限周期</td>
                        <td align="center"><?php echo IN_ARTICLEOUTPOINTS; ?></td>
                        <td align="center"><?php echo IN_ARTICLEOUTRANK; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="bottom"></div>
    </div>
    <?php include 'source/user/people/bottom.php'; ?>
</body>
</html>
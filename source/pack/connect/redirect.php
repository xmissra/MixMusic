<?php
include '../../system/db.class.php';
header("Content-type: text/html;charset=".IN_CHARSET);
require_once 'function.php';
session_start();
if(!isset($_GET['state']) || empty($_GET['state']) || !isset($_GET['code']) || empty($_GET['code'])){
        echo '第三方登录获取参数失败！';
}else{
        if($_GET['state'] != $_SESSION['state']){
                exit('请求非法或超时！');
        }
        $get_url = 'https://graph.qq.com/oauth2.0/token';
        $get_param = array("grant_type" => "authorization_code", "client_id" => $_SESSION['appid'], "client_secret" => $_SESSION['appkey'], "code" => $_GET['code'], "state" => $_GET['state'], "redirect_uri" => $_SESSION['redirect_url']);
        unset($_SESSION['redirect_url']);
        $content = get($get_url, $get_param);
        if($content && $content !== FALSE){
                $temp = explode('&', $content);
                $param = array();
                foreach($temp as $val){
                        $temp2 = explode('=', $val);
                        $param[$temp2[0]] = $temp2[1];
                }
                $_SESSION['access_token'] = $param['access_token'];
                $get_url = 'https://graph.qq.com/oauth2.0/me';
                $get_param = array("access_token" => $param['access_token']);
                $content = get($get_url, $get_param);
                if($content && $content !== FALSE){
                        $random = get_random(6);
                        $temp = array();
                        preg_match('/callback\(\s+(.*?)\s+\)/i', $content, $temp);
                        $result = json_decode($temp[1], true);
                        $openid = $result['openid'];
                        $_SESSION['oauth_pass'] = $random.strtolower(substr($openid, 2, 2));
                        $_SESSION['oauth_openid'] = $openid;
                        $email = strtolower(substr($openid, 2, 8)).'@qq.com';
                        if($result['openid'] && !empty($result['openid']) && !empty($param['access_token'])){
                                $get_url = 'https://graph.qq.com/user/get_user_info';
                                $get_param = array("access_token" => $param['access_token'], "oauth_consumer_key" => $_SESSION['appid'], "openid" => $result['openid']);
                                unset($_SESSION['appid']);
                                unset($_SESSION['appkey']);
                                $token = $param['access_token'];
                                $content = get($get_url, $get_param);
                                $result = json_decode($content, true);
                                if($result && $result['ret'] == 0){
                                        $user = convert_xmlcharset(trim($result['nickname']));
                                        $img = $result['figureurl_2'];
                                        global $db;
                                        if($row=$db->getrow("select * from ".tname('user')." where in_islock=0 and in_qqopen='".SafeSql($openid)."'")){
                                                $session = $db->getone("select in_id from ".tname('session')." where in_uid=".$row['in_userid']);
                                                if($session){
                                                        updatetable('session', array('in_addtime' => time()), array('in_id' => $session));
                                                }else{
                                                        $setarr = array(
			                                        'in_uid' => $row['in_userid'],
			                                        'in_uname' => $row['in_username'],
			                                        'in_invisible' => 0,
			                                        'in_addtime' => time()
                                                        );
                                                        inserttable('session', $setarr, 1);
                                                }
                                                setcookie('in_userid', $row['in_userid'], time()+86400, IN_PATH);
                                                setcookie('in_username', $row['in_username'], time()+86400, IN_PATH);
                                                setcookie('in_userpassword', $row['in_userpassword'], time()+86400, IN_PATH);
                                                if($db->getone("select in_userid from ".tname('user')." where in_userid=".$row['in_userid']." and DATEDIFF(DATE(in_logintime),'".date('Y-m-d')."')=0")){
                                                        $db->query("update ".tname('user')." set in_loginip='".getonlineip()."',in_logintime='".date('Y-m-d H:i:s')."' where in_userid=".$row['in_userid']);
                                                }else{
                                                        $db->query("update ".tname('user')." set in_points=in_points+".IN_LOGINDAYPOINTS.",in_rank=in_rank+".IN_LOGINDAYRANK.",in_loginip='".getonlineip()."',in_logintime='".date('Y-m-d H:i:s')."' where in_userid=".$row['in_userid']);
                                                        $setarrs = array(
			                                        'in_uid' => 0,
			                                        'in_uname' => '系统用户',
			                                        'in_uids' => $row['in_userid'],
			                                        'in_unames' => $row['in_username'],
			                                        'in_content' => '每日首次登录：[金币+'.IN_LOGINDAYPOINTS.'][经验+'.IN_LOGINDAYRANK.']',
			                                        'in_isread' => 0,
			                                        'in_addtime' => date('Y-m-d H:i:s')
                                                        );
                                                        inserttable('message', $setarrs, 1);
                                                }
                                                echo "<script type=\"text/javascript\">this.parent.qzone_return(1);</script>";
                                        }else{
                                                setcookie('in_qq_nick', $user, time()+900, IN_PATH);
                                                setcookie('in_qq_open', $openid, time()+900, IN_PATH);
                                                setcookie('in_qq_img', $img, time()+900, IN_PATH);
                                                echo "<script type=\"text/javascript\">this.parent.qzone_return(0);</script>";
                                        }
                                }else{
                                        echo "用户信息请求错误，错误代码：".$result['ret']."；错误信息：".$result['msg'];
                                }
                        }
                }
        }
}
?>
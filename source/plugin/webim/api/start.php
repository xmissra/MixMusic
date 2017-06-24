<?php
include '../../../system/db.class.php';
include '../../../system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db,$userlogined,$missra_in_userid;
$ac = SafeRequest("ac","get");
if($ac == 'start'){
        $userlogined or exit("{start:-1}");
        $type = SafeRequest("type","get");
        $do = SafeRequest("do","get");
        $uid = intval(SafeRequest("uid","get"));
        $sec = intval(SafeRequest("sec","get"));
        $num = $db->num_rows($db->query("select count(*) from ".tname('message')." where in_isread=0 and in_uid=".$uid." and in_uids=".$missra_in_userid));
        if($type == 'num'){
                $status = getfield('session', 'in_id', 'in_uid', $uid) ? 1 : 0;
                echo "{start:'".$num."',status:".$status."}";
        }elseif($do || $num > 0){
                $msg = '';
                $sid = 0;
                $mid = $db->query("select * from ".tname('message')." where in_isread=0 and in_uid=".$uid." and in_uids=".$missra_in_userid." and in_content like '%[event:shake]%' order by in_addtime desc LIMIT 0,1");
                while($row = $db->fetch_array($mid)){
                        $sid = $row['in_id'];
                }
                $where = $do == 2 ? 'in_uid='.$uid.' and in_uids='.$missra_in_userid.' or in_uid='.$missra_in_userid.' and in_uids='.$uid : 'in_isread=0 and in_uid='.$uid.' and in_uids='.$missra_in_userid;
                $query = $db->query("select * from ".tname('message')." where ".$where." order by in_addtime asc");
                while($row = $db->fetch_array($query)){
                        $content = preg_replace('/\[emoji:(\d+)]/is', '<img src="'.IN_PATH.'source/plugin/webim/api/emo_\1.gif">', $row['in_content']);
                        $content = preg_replace('/\[record:(\d+)]/is', '<embed src="'.IN_PATH.'source/plugin/webim/api/record.swf?url='.IN_PATH.'data/tmp/\1.mp3&autoplay=0" wmode="opaque" width="261" height="23" type="application/x-shockwave-flash">', $content);
                        $content = preg_replace('/\[img](.*?)\[\/img]/is', '<img src="\1">', $content);
                        $content = preg_replace('/\[flash](.*?)\[\/flash]/is', '<embed src="\1" width="100%" height="100%" allowfullscreen="true" allowscriptaccess="always" wmode="transparent" type="application/x-shockwave-flash">', $content);
                        $content = $row['in_id'] == $sid ? preg_replace('/\[event:shake]/is', '<script type="text/javascript">lib.shake(40, 16, "content", 56);</script><img src="'.IN_PATH.'source/plugin/webim/api/shake.png">', $content, 1) : preg_replace('/\[event:shake]/is', '<img src="'.IN_PATH.'source/plugin/webim/api/shake.png">', $content);
                        $content = preg_replace('/\[event:shake]/is', '<img src="'.IN_PATH.'source/plugin/webim/api/shake.png">', $content);
                        $content = preg_replace('/\[attach:(.*?):(.*?):(.*?)]/is', '<img src="'.IN_PATH.'source/plugin/webim/api/success.png" style="vertical-align:bottom">&nbsp;<a href="'.IN_PATH.'data/tmp/\1">\2[\3]</a>', $content);
                        $msg .= '<div class="message clearfix"><div class="user-logo"><img src="'.getavatar($row['in_uid']).'" width="50" height="50" style="border-radius:85px"></div><div class="wrap-text"><h5 class="clearfix" style="'.($row['in_uid'] == $missra_in_userid ? 'color:#337FD1' : 'color:#E35850').'">'.$row['in_uname'].'</h5><div style="'.($row['in_uid'] == $missra_in_userid ? 'background:#2A3651;color:#FFEA76' : 'background:#CDD7E2;color:#252424').'">'.$content.'</div></div><div class="wrap-ri"><div clsss="clearfix"><span>'.datetime($row['in_addtime']).'</span></div></div><div style="clear:both;"></div></div>';
                }
                $me = $db->query("select * from ".tname('message')." where in_uid=".$missra_in_userid." and in_uids=".$uid." order by in_addtime desc LIMIT 0,1");
                while($row = $db->fetch_array($me)){
                        $content = preg_replace('/\[emoji:(\d+)]/is', '<img src="'.IN_PATH.'source/plugin/webim/api/emo_\1.gif">', $row['in_content']);
                        $content = preg_replace('/\[record:(\d+)]/is', '<embed src="'.IN_PATH.'source/plugin/webim/api/record.swf?url='.IN_PATH.'data/tmp/\1.mp3&autoplay=0" wmode="opaque" width="261" height="23" type="application/x-shockwave-flash">', $content);
                        $content = preg_replace('/\[img](.*?)\[\/img]/is', '<img src="\1">', $content);
                        $content = preg_replace('/\[flash](.*?)\[\/flash]/is', '<embed src="\1" width="100%" height="100%" allowfullscreen="true" allowscriptaccess="always" wmode="transparent" type="application/x-shockwave-flash">', $content);
                        $content = preg_replace('/\[event:shake]/is', '<img src="'.IN_PATH.'source/plugin/webim/api/shake.png">', $content);
                        $content = preg_replace('/\[attach:(.*?):(.*?):(.*?)]/is', '<img src="'.IN_PATH.'source/plugin/webim/api/success.png" style="vertical-align:bottom">&nbsp;<a href="'.IN_PATH.'data/tmp/\1">\2[\3]</a>', $content);
                        $msg .= $do == 1 ? '<div class="message clearfix"><div class="user-logo"><img src="'.getavatar($row['in_uid']).'" width="50" height="50" style="border-radius:85px"></div><div class="wrap-text"><h5 class="clearfix" style="color:#337FD1">'.$row['in_uname'].'</h5><div style="background:#2A3651;color:#FFEA76">'.$content.'</div></div><div class="wrap-ri"><div clsss="clearfix"><span>'.datetime($row['in_addtime']).'</span></div></div><div style="clear:both;"></div></div>' : '';
                }
                $db->query("update ".tname('message')." set in_isread=1 where in_uid=".$uid." and in_uids=".$missra_in_userid);
                $db->query("delete from ".tname('message')." where in_uid=".$uid." and in_uids=".$missra_in_userid." and UNIX_TIMESTAMP(in_addtime)<=".strtotime('-'.$sec.' seconds')." or in_isread=1 and in_uid=".$missra_in_userid." and in_uids=".$uid." and UNIX_TIMESTAMP(in_addtime)<=".strtotime('-'.$sec.' seconds'));
                echo "{start:'".$msg."'}";
        }else{
                echo "{start:''}";
        }
}
?>
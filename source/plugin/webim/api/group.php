<?php
include '../../../system/db.class.php';
include '../../../system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db,$userlogined,$missra_in_userid;
$ac = SafeRequest("ac","get");
if($ac == 'group'){
        $userlogined or exit("{group:-1}");
        $num = intval(SafeRequest("num","get"));
        $nums = intval(SafeRequest("nums","get"));
        $count = $db->num_rows($db->query("select count(*) from ".tname('message')." where in_uids=0"));
        $start = empty($num) ? $count > $nums ? ($count - $nums) : 0 : $num;
        $end = empty($num) ? $nums : ($count - $num);
        $msg = '';
        $sid = 0;
        $mid = $db->query("select * from ".tname('message')." where in_uids=0 and in_content like '%[event:shake]%' order by in_addtime desc LIMIT 0,1");
        while($row = $db->fetch_array($mid)){
                $sid = $row['in_id'];
        }
        $query = $db->query("select * from ".tname('message')." where in_uids=0 order by in_addtime asc LIMIT ".$start.",".$end);
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
        echo "{group:'".$msg."',num:'".$count."'}";
}
?>
<?php
include '../../../source/system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
$ac = SafeRequest("ac","get");
if($ac == 'save'){
        $data = empty($GLOBALS['HTTP_RAW_POST_DATA']) ? file_get_contents('php://input') : $GLOBALS['HTTP_RAW_POST_DATA'];
        if($data){
                $time = date('YmdHis').rand(2,pow(2,24));
                $path = '../../../data/tmp/'.$time.'.mp3';
                $file = @fopen($path, 'w');
	        @fwrite($file, $data);
                @fclose($file);
                include_once '../../../source/pack/mp3/class.mp3.php';
                $MP3 = new MP3($path);
                $Meta = $MP3->get_metadata();
                $setarr = array(
                        'in_uid' => 0,
		        'in_uname' => '边听边说['.getonlineip().']',
		        'in_uids' => 0,
		        'in_unames' => '公共频道',
		        'in_content' => '[record:'.$time.']'.($Meta['Length'] * 1000),
		        'in_isread' => 0,
		        'in_addtime' => date('Y-m-d H:i:s')
                );
                inserttable('message', $setarr, 1);
                echo 'success';
        }else{
                echo 'error';
        }
}elseif($ac == 'send'){
        $img = preg_replace('/.php\?/i', '', SafeRequest("img","get"));
        $info = unescape(SafeRequest("info","get"));
	$setarr = array(
		'in_uid' => 0,
		'in_uname' => '边听边说['.getonlineip().']',
		'in_uids' => 0,
		'in_unames' => '公共频道',
		'in_content' => '[img]'.$img.'[/img]'.str_replace(array('[', ']'), array('', ''), $info),
		'in_isread' => 1,
		'in_addtime' => date('Y-m-d H:i:s')
	);
	inserttable('message', $setarr, 1);
	echo "{send:1}";
}elseif($ac == 'num'){
        global $db;
        $type = intval(SafeRequest("type","get"));
        $num = $db->num_rows($db->query("select count(*) from ".tname('message')." where in_uid=0 and in_uids=0 and in_isread=".$type));
        echo "{num:'".$num."'}";
}elseif($ac == 'ing'){
        global $db;
        $type = intval(SafeRequest("type","get"));
        $count = $db->num_rows($db->query("select count(*) from ".tname('message')." where in_uid=0 and in_uids=0 and in_isread=".$type));
        $num = intval(SafeRequest("num","get"));
        if($type > 0 && $count > $num){
                $query = $db->query("select * from ".tname('message')." where in_uid=0 and in_uids=0 and in_isread=1 order by in_addtime asc LIMIT $num,".($count - $num));
                $barrager = "barrager:[";
                while($row = $db->fetch_array($query)){
                        $content = explode('[/img]', $row['in_content']);
                        $barrager .= "{img:'".str_replace('[img]', '', $content[0])."',info:'".$content[1]."'},";
                }
                echo "{p:0,num:'".$count."',".str_replace(',]', ']', $barrager.']').",time:3000}";
        }elseif($count > $num){
                $query = $db->query("select * from ".tname('message')." where in_uid=0 and in_uids=0 and in_isread=0 order by in_addtime asc LIMIT $num,1");
                while($row = $db->fetch_array($query)){
                        $content = explode(']', $row['in_content']);
                        echo "{p:1,num:'".($num + 1)."',record:'".str_replace('[record:', '', $content[0])."',time:'".$content[1]."'}";
                }
        }else{
                echo "{p:0,num:'".$count."',time:3000}";
        }
}
?>
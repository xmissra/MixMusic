<?php
include '../../../source/system/db.class.php';
include '../../../source/system/user.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db,$userlogined,$missra_in_userid;
$action = SafeRequest("ac","get");
if($action == 'ajax'){
        echo "<p class=\"hisQing clearfix\"><a onclick=\"lib.all_play('";
        if($userlogined){
	        $sql = "select * from ".tname('listen')." where in_uid=".$missra_in_userid." order by in_addtime desc LIMIT 0,10";
	        $query = $db->query($sql);
	        $num = $db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
	        if($num > 0){
	                $hisid = '';
	                while ($row = $db->fetch_array($query)) {
   	                        $hisid = $hisid.$row['in_mid'].'/';
	                }
		        echo $hisid;
	        }
	        echo "');\" style=\"cursor:pointer;\" id=\"playHis\">全部播放</a><a onclick=\"his_del('alldel', 0);\" style=\"cursor:pointer;\" id=\"qingkong\">清空记录</a></p><ul class=\"hisList clearfix\" id=\"hislisten\">";
	        $sqls = "select * from ".tname('listen')." where in_uid=".$missra_in_userid." order by in_addtime desc LIMIT 0,10";
	        $querys = $db->query($sqls);
	        $nums = $db->num_rows($db->query(str_replace('*', 'count(*)', $sqls)));
	        if($nums == 0){
		        echo "<li>没有试听记录！</li>";
	        }else{
	                $i = 0;
	                while ($rows = $db->fetch_array($querys)) {
   	                        $i = $i + 1;
   	                        echo "<li><input class=\"check\" type=\"checkbox\" value=\"".$rows['in_mid']."\"><span class=\"num\">".$i."</span><a href=\"".getlink($rows['in_mid'], 'music')."\" target=\"_blank\" class=\"playList-songName\">".getfield('music', 'in_name', 'in_id', $rows['in_mid'])."</a><a href=\"".getlink(getfield('music', 'in_classid', 'in_id', $rows['in_mid']), 'class')."\" target=\"_blank\" class=\"playList-singerName\">".getfield('class', 'in_name', 'in_id', getfield('music', 'in_classid', 'in_id', $rows['in_mid']))."</a><span class=\"hisListBtn\"><a class=\"hisListBtn-delete\" onclick=\"his_del('del', ".$rows['in_id'].");\" style=\"cursor:pointer;\">移除</a></span></li>";
	                }
	        }
        }else{
	        echo "');\" style=\"cursor:pointer;\" id=\"playHis\">全部播放</a><a onclick=\"his_del('alldel', 0);\" style=\"cursor:pointer;\" id=\"qingkong\">清空记录</a></p><ul class=\"hisList clearfix\" id=\"hislisten\"><li>请先登录！</li>";
        }
        echo "</ul><div class=\"hisCao clearfix\"><div class=\"ctrBtn clearfix\"><label class=\"allXuan\" style=\"cursor:pointer;\" id=\"allXuan\"><input class=\"check\" type=\"checkbox\" name=\"allXuan\" onclick=\"lib.quanxuan('hislisten');\">&nbsp;全选</label><a onclick=\"lib.player('hislisten', 'play');\" class=\"allAdd\" style=\"cursor:pointer;\">播放所选</a></div><div class=\"his-page\"></div></div>";
}elseif($action == 'hisdel'){
        $id = intval(SafeRequest("id","get"));
        $do = SafeRequest("do","get");
        if($userlogined){
                if($do == 'del'){
		        $uid = $db->getone("select in_uid from ".tname('listen')." where in_id=".$id);
		        if(!$uid){
			        echo 'return_1';
		        }elseif($uid !== $missra_in_userid){
			        echo 'return_2';
		        }else{
			        $db->query("delete from ".tname('listen')." where in_id=".$id);
			        echo 'return_3';
		        }
                }else{
		        $db->query("delete from ".tname('listen')." where in_uid=".$missra_in_userid);
		        echo 'return_4';
                }
        }else{
                echo 'return_0';
        }
}
?>
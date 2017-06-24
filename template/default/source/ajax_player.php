<?php
include '../../../source/system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db;
$id = SafeRequest("id","get");
$type = SafeRequest("type","get");
if($type == 'get'){
        $fid = SafeRequest("fid","get");
        $query = $db->query("select * from ".tname('music')." where in_id in (".SafeSql($id, 1).")");
        while($row = $db->fetch_array($query)){
	        echo "<li onclick=\"player_data(".$row['in_id'].");\" id=\"player_".$row['in_id']."\" data-id=\"".$row['in_id']."\"".($row['in_id'] == $fid ? ' class="play_current"' : NULL)."><strong class=\"music_name\">".getlenth($row['in_name'], 10)."</strong><strong class=\"singer_name\">".getfield('singer', 'in_name', 'in_id', $row['in_singerid'], '未知歌手')."</strong></li>";
        }
}else{
        close_browse();
        $audio = geturl(getfield('music', 'in_audio', 'in_id', $id));
        $cover = geturl(getfield('music', 'in_cover', 'in_id', $id), 'cover');
        $name = getfield('music', 'in_name', 'in_id', $id);
        $singer = getfield('singer', 'in_name', 'in_id', getfield('music', 'in_singerid', 'in_id', $id), '未知歌手');
        $lyric = geturl(getfield('music', 'in_lyric', 'in_id', $id), 'lyric');
        preg_match_all("/\[(\d{2}):(\d{2}).\d{2}\](.*\n|.*)/", @file_get_contents($lyric), $arr);
        if(!empty($arr)){
		$lrc = 'lrclist:[';
		for($i = 0; $i < count($arr[0]); $i++){
			$timeId = intval($arr[1][$i]) * 60 + intval($arr[2][$i]) + 1;
			$text = trim(detect_encoding($arr[3][$i]));
			$lrc .= !empty($text) ? "{'timeId':'".$timeId."','text':'".$text."'}," : "";
		}
		$lrc = str_replace(',]', ']', $lrc.']');
        }else{
		$lrc = "lrclist:[]";
        }
        echo "{type:['".substr(strrchr($audio, '.'), 1)."'],audio:['".$audio."'],cover:['".$cover."'],name:['".$name."'],singer:['".$singer."'],".$lrc."}";
}
?>
<?php
include '../../../source/system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db;
$id = intval(SafeRequest("id","get"));
$pid = intval(SafeRequest("pid","get"));
$str = '<div class="commentArea">';
$str = $str.'<textarea id="_content" cols="136" rows="6"></textarea>';
$str = $str.'<div class="sendComment">';
$str = $str.'<span class="commentTip" id="_tips">请<em>文明</em>发言！</span>';
$str = $str.'<button class="btnComment" type="button" onclick="send_comment('.$id.');">评 论</button>';
$str = $str.'</div>';
$str = $str.'</div>';
$str = $str.'<div class="listArea">';
$Arr = getstylepage("select * from ".tname('comment')." where in_table='music' and in_tid=".$id." order by in_addtime desc", $id, $pid);
$result = $Arr[1];
$count = $Arr[2];
if($count == 0){
        $str = $str.'<center style="color:#8b8b8b">还没有评论，赶快来抢占沙发吧！</center>';
}else{
        if($result){
                $str = $str.'<ul class="commentList">';
                while($com = $db->fetch_array($result)){
                        $content = getlenth($com['in_content'], 128);
                        $str .= '<li><div class="commentHead"><a href="'.getlink($com['in_uid']).'" target="_blank"><img src="'.getavatar($com['in_uid']).'" width="30" height="30"></a></div><div class="commentWrap"><span class="commentContent" style="color:#8b8b8b"><a href="'.getlink($com['in_uid']).'" target="_blank" style="font-weight:bold;color:#0c8f44">'.$com['in_uname'].': </a>'.$content.'</span><span class="commentOpe"><a class="commentReply replyAction" style="color:#8b8b8b">'.datetime($com['in_addtime']).'</a></span></div></li>';
                }
                $str = $str.'</ul>';
        }
}
$str = $str.'</div>';
$str = $str.'<div style="text-align:right;padding:0;margin:0;padding-right:20px;height:20px;line-height:20px">';
echo $str.$Arr[0].'</div>';
function getstylepage($select, $id, $pid){
	global $db;
 	$nums = $db->num_rows($db->query(str_replace('*', 'count(*)', $select)));
	$num = $nums == 0 ? 1 : $nums;
  	$pagejs = ceil($num / 10);
	if($pid > $pagejs){
		$pid = $pagejs;
	}
	$result = $db->query($select.' LIMIT '.(10 * ($pid - 1)).',10');
 	$str = '';
	if($nums > 0){
 		$str .= '<a style="color:#0c8f44">共<strong>'.$nums.'</strong>条评论</a> ';
		if($pid == 1){
			$str .= '<a style="color:#0c8f44">首页</a> ';
		}else{
			$str .= '<a style="cursor:pointer;font-weight:bold;color:#0c8f44" onclick="get_comment('.$id.', 1);">首页</a> ';
		}
		if($pid > 1){
			$str .= '<a style="cursor:pointer;font-weight:bold;color:#0c8f44" onclick="get_comment('.$id.', '.($pid - 1).');">上一页</a> ';
		}else{
			$str .= '<a style="color:#0c8f44">上一页</a> ';
		}
		if($pid < $pagejs){
			$str .= '<a style="cursor:pointer;font-weight:bold;color:#0c8f44" onclick="get_comment('.$id.', '.($pid + 1).');">下一页</a> ';
		}else{
			$str .= '<a style="color:#0c8f44">下一页</a> ';
		}
		if($pid == $pagejs){
			$str .= '<a style="color:#0c8f44">尾页</a> ';
		}else{
			$str .= '<a style="cursor:pointer;font-weight:bold;color:#0c8f44" onclick="get_comment('.$id.', '.$pagejs.');">尾页</a> ';
		}
 		$str .= '<a style="color:#0c8f44"><strong>'.$pid.'</strong>/<strong>'.$pagejs.'</strong></a>';
	}
	$arr = array($str, $result, $nums);
	return $arr;
}
?>
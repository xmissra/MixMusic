<?php
function getstylepage($sqlstr, $pagesok){
	global $db;
	$url = $_SERVER['QUERY_STRING'];
	if(stristr($url, '&pages')){
		$url = preg_replace('/&pages=([\S]+?)$/', '', $url);
	}
	$page = intval(SafeRequest("pages","get"));
	$pages = $page <= 0 ? 1 : $page;
 	$nums = $db->num_rows($db->query(str_replace('*', 'count(*)', $sqlstr)));
	$num = $nums == 0 ? 1 : $nums;
  	$pagejs = ceil($num / $pagesok);
	if($pages > $pagejs){
		$pages = $pagejs;
	}
	$result = $db->query($sqlstr." LIMIT ".$pagesok * ($pages - 1).",".$pagesok);
 	$str = '';
	if($nums > 0){
 		$str .= "<a>共<strong>".$nums."</strong>条评论</a> ";
		if($pages == 1){
			$str .= "<a>首页</a> ";
		}else{
			$str .= "<a style=\"cursor:pointer\" onclick=\"location.href='?".$url."&pages=1';\">首页</a> ";
		}
		if($pages > 1){
			$str .= "<a style=\"cursor:pointer\" onclick=\"location.href='?".$url."&pages=".($pages - 1)."';\">上一页</a> ";
		}else{
			$str .= "<a>上一页</a> ";
		}
		if($pages < $pagejs){
			$str .= "<a style=\"cursor:pointer\" onclick=\"location.href='?".$url."&pages=".($pages + 1)."';\">下一页</a> ";
		}else{
			$str .= "<a>下一页</a> ";
		}
		if($pages == $pagejs){
			$str .= "<a>尾页</a> ";
		}else{
			$str .= "<a style=\"cursor:pointer\" onclick=\"location.href='?".$url."&pages=".$pagejs."';\">尾页</a> ";
		}
 		$str .= "<a><strong>".$pages."</strong>/<strong>".$pagejs."</strong></a> ";
	}
	$arr = array($str, $result, $nums);
	return $arr;
}
?>
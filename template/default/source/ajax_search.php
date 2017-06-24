<?php
include '../../../source/system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
global $db;
$key = unescape(SafeRequest("key","get"));
$str = '<div class="search_sort"><h4 class="search_sort_title"><i class="icon_song"></i>单曲</h4><ul>';
$query = $db->query("select * from ".tname('music')." where in_passed=0 and in_name like '%".$key."%' order by in_addtime desc LIMIT 0,4");
while($row = $db->fetch_array($query)){
        $str .= '<li onmouseover="this.className=\'current\'" onmouseout="this.className=\'\'"><a href="'.getlink($row['in_id'], 'music').'" target="_blank"><span class="s_keyword">'.str_replace($key, '<span class="keyword">'.$key.'</span>', $row['in_name']).'</span>-<span class="s_connect">'.getfield('singer', 'in_name', 'in_id', $row['in_singerid'], '未知歌手').'</span></a></li>';
}
$str = $str.'</ul></div><div class="search_sort search_sort_alt"><h4 class="search_sort_title"><i class="icon_singer"></i>歌手</h4><ul>';
$query = $db->query("select * from ".tname('singer')." where in_passed=0 and in_name like '%".$key."%' order by in_addtime desc LIMIT 0,2");
while($row = $db->fetch_array($query)){
        $str .= '<li onmouseover="this.className=\'current\'" onmouseout="this.className=\'\'"><a href="'.getlink($row['in_id'], 'singer').'" target="_blank"><span class="s_keyword">'.str_replace($key, '<span class="keyword">'.$key.'</span>', $row['in_name']).'</span></a></li>';
}
$str = $str.'</ul></div><div class="search_sort search_sort_alt"><h4 class="search_sort_title"><i class="icon_album"></i>专辑</h4><ul>';
$query = $db->query("select * from ".tname('special')." where in_passed=0 and in_name like '%".$key."%' order by in_addtime desc LIMIT 0,2");
while($row = $db->fetch_array($query)){
        $str .= '<li onmouseover="this.className=\'current\'" onmouseout="this.className=\'\'"><a href="'.getlink($row['in_id'], 'special').'" target="_blank"><span class="s_keyword">'.str_replace($key, '<span class="keyword">'.$key.'</span>', $row['in_name']).'</span>-<span class="s_connect">'.getfield('singer', 'in_name', 'in_id', $row['in_singerid'], '未知歌手').'</span></a></li>';
}
$str = $str.'</ul></div><div class="search_sort"><h4 class="search_sort_title"><i class="icon_mv"></i>MV</h4><ul>';
$query = $db->query("select * from ".tname('video')." where in_passed=0 and in_name like '%".$key."%' order by in_addtime desc LIMIT 0,2");
while($row = $db->fetch_array($query)){
        $str .= '<li onmouseover="this.className=\'current\'" onmouseout="this.className=\'\'"><a href="'.getlink($row['in_id'], 'video').'" target="_blank"><span class="s_keyword">'.str_replace($key, '<span class="keyword">'.$key.'</span>', $row['in_name']).'</span>-<span class="s_connect">'.getfield('singer', 'in_name', 'in_id', $row['in_singerid'], '未知歌手').'</span></a></li>';
}
echo $str.'</ul></div>';
?>
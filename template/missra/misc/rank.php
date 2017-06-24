<?php
if(!defined('IN_ROOT')){exit('Access denied');}
global $cache;
$rank = explode('/', $_SERVER['PATH_INFO']);
$rank_arr = array('down', 'fav', 'good', 'bad');
$type = isset($rank[3]) ? $rank[3] : NULL;
in_array($type, $rank_arr) or exit(header('location:'.IN_PATH));
if(!$cache->start('rank_'.$type)){
        $static = @file_get_contents(get_template().'rank.html');
        $title = str_replace($rank_arr, array('下载', '收藏', '好评', '差评'), $type);
        $static = str_replace(array('{$rank[\'id\']}', '{$rank[\'name\']}'), array($type, $title), $static);
	$static = Min::G_lobal($static);
	echo Lib::E_val($static);
        $cache->end();
}
?>
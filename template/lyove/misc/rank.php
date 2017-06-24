<?php
if(!defined('IN_ROOT')){exit('Access denied');}
global $cache;
$rank = explode('/', $_SERVER['PATH_INFO']);
$rank_arr = array('new', 'hot', 'good', 'bad', 'fav', 'down');
$type = isset($rank[3]) ? $rank[3] : NULL;
in_array($type, $rank_arr) or exit(header('location:'.IN_PATH));
if(!$cache->start('rank_'.$type)){
        $title = str_replace($rank_arr, array('最新', '最热', '好评', '差评', '收藏', '下载'), $type);
        $sort = str_replace($rank_arr, array('time', 'hits', 'goodhits', 'badhits', 'favhits', 'downhits'), $type);
        $static = @file_get_contents(get_template().'rank.html');
        $static = str_replace(array('{$rank[\'sort\']}', '{$rank[\'title\']}'), array($sort, $title), $static);
	$static = Min::G_lobal($static);
	echo Lib::E_val($static);
        $cache->end();
}
?>
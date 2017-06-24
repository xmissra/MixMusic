<?php
if(!defined('IN_ROOT')){exit('Access denied');}
global $db;
$radio = explode('/', $_SERVER['PATH_INFO']);
$fid = isset($radio[4]) ? $radio[4] : NULL;
$mid = '';
if(is_numeric($fid)){
	$fmid = getfield('class', 'in_id', 'in_id', $fid, 'none');
	$fmname = getfield('class', 'in_name', 'in_id', $fid, '暂无频道');
	$query = $db->query("select * from ".tname('music')." where in_classid=".$fid." order by rand() desc LIMIT 0,100");
}else{
	$fmid = 'none';
	$fmname = '随便听听';
	$query = $db->query("select * from ".tname('music')." order by rand() desc LIMIT 0,100");
}
while ($row = $db->fetch_array($query)) {
	$mid .= '{fm}'.$row['in_id'].',';
}
$mid = str_replace(array(',]', ']'), array('', ''), $mid.']');
$static = @file_get_contents(get_template().'radio.html');
$static = str_replace(array('{$radio[\'fmid\']}', '{$radio[\'fmname\']}', '{$radio[\'mid\']}'), array($fmid, $fmname, $mid), $static);
$static = Min::G_lobal($static);
echo Lib::E_val($static);
?>
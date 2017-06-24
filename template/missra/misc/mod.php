<?php
if(!defined('IN_ROOT')){exit('Access denied');}
global $db,$cache;
$mod = explode('/', $_SERVER['PATH_INFO']);
$mtype_arr = array('fav', 'down', 'diange', 'wrong');
$mtype = isset($mod[3]) ? $mod[3] : NULL;
$mid = intval(isset($mod[4]) ? $mod[4] : NULL);
in_array($mtype, $mtype_arr) or exit(header('location:'.IN_PATH));
if(!$cache->start('mod_'.$mtype.'_'.$mid)){
        if($row = $db->getrow("select * from ".tname('music')." where in_id=".$mid)){
                $static = @file_get_contents(get_template().$mtype.'.html');
	        $static = Min::G_lobal($static, $row['in_id']);
	        $static = Min::M_usic($static, $static, $row);
	        echo Lib::E_val($static);
        }else{
                echo html_message("错误信息","数据不存在或已被删除！");
        }
        $cache->end();
}
?>
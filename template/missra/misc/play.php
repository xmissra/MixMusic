<?php
if(!defined('IN_ROOT')){exit('Access denied');}
$play = explode('/', $_SERVER['PATH_INFO']);
$id = isset($play[3]) ? $play[3] : NULL;
if(is_numeric($id)){
        $lists = str_replace(array('/misc/play/', '/]', '/'), array('', '', ',{play}'), $_SERVER['PATH_INFO'].']');
        setcookie('in_misc_play', '{play}'.$lists, time()+60, IN_PATH);
        echo "<script type=\"text/javascript\">location.href='".rewrite_mode('index.php/page/play/')."';</script>";
}else{
        header('location:'.IN_PATH);
}
?>
<?php
include 'source/system/db.class.php';
include 'source/system/user.php';
include 'source/user/function.php';
$plugin = explode('/', isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : NULL);
$dir = isset($plugin[1]) ? $plugin[1] : NULL;
$file = isset($plugin[2]) ? $plugin[2] : NULL;
core_entry('source/plugin/'.$dir.'/'.$file.'.php');
?>
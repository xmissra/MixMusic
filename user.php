<?php
include 'source/system/db.class.php';
include 'source/system/user.php';
include 'source/user/function.php';
$user = explode('/', isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : NULL);
$dir = isset($user[1]) ? $user[1] : 'people';
if(is_numeric($dir)){
        core_entry('source/user/space/index.php');
}else{
        $file = isset($user[2]) ? $user[2] : 'index';
        core_entry('source/user/'.$dir.'/'.$file.'.php');
}
?>
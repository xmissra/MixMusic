<?php
include '../../system/db.class.php';
include '../../system/user.php';
if(IN_UPOPEN == 1){
        require_once('../upload/doodle.php');
}elseif(IN_REMOTE == 1){
        $doodle = '../../plugin/'.IN_REMOTEPK.'/doodle.php';
        if(!is_file($doodle)){
                $doodle = '../upload/doodle.php';
        }
        require_once($doodle);
}else{
        require_once('../ftp/doodle.php');
}
?>
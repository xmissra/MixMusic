<?php
include '../../system/db.class.php';
include 'class.ftp.php';
$data = empty($GLOBALS['HTTP_RAW_POST_DATA']) ? file_get_contents('php://input') : $GLOBALS['HTTP_RAW_POST_DATA'];
if($data){
        $ftp = new ftp(IN_REMOTEHOST, IN_REMOTEPORT, IN_REMOTEOUT, IN_REMOTEUSER, IN_REMOTEPW, IN_REMOTEPASV);
        $src = IN_ROOT.'./data/tmp/ftp_'.date('YmdHis').rand(2,pow(2,24)).'_record.mp3';
        $path = '/'.date('YmdHis').rand(2,pow(2,24)).'.mp3';
        $dir = IN_REMOTEDIR == '.' ? NULL : IN_REMOTEDIR;
        $file = @fopen($src, 'w');
	@fwrite($file, $data);
        @fclose($file);
        $return = $ftp->f_put($src, $dir, $path);
        if($return){
                echo IN_REMOTEURL.$path;
        }else{
                echo 'error';
        }
        @unlink($src);
        $ftp->c_lose();
}else{
        echo 'error';
}
?>
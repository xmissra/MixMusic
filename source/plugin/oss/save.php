<?php
include '../../system/db.class.php';
require_once 'conf.inc.php';
require_once 'sdk.class.php';
$data = empty($GLOBALS['HTTP_RAW_POST_DATA']) ? file_get_contents('php://input') : $GLOBALS['HTTP_RAW_POST_DATA'];
if($data){
	$oss_sdk_service = new ALIOSS();
	$src = IN_ROOT.'./data/tmp/oss_'.date('YmdHis').rand(2,pow(2,24)).'_record.mp3';
	$object = $_SERVER['HTTP_HOST'].'.'.date('YmdHis').rand(2,pow(2,24)).'.mp3';
	$content = '';
	$length = 0;
        $file = @fopen($src, 'w');
	@fwrite($file, $data);
        @fclose($file);
	$fp = fopen($src, 'r');
	if($fp){
		$f = fstat($fp);
		$length = $f['size'];
		while(!feof($fp)){
			$content .= fgets($fp);
		}
	}
	fclose($fp);
	$upload_file_options = array('content' => $content, 'length' => $length);
	$upload_file_by_content = $oss_sdk_service->upload_file_by_content(OSS_BUCKET, $object, $upload_file_options);
        echo OSS_DLINK.OSS_BUCKET.'/'.$object;
        @unlink($src);
}else{
        echo 'error';
}
?>
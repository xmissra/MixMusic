<?php
require_once '../../system/config.inc.php';
require_once 'conf.inc.php';
require_once 'sdk.class.php';
if(!empty($_FILES)){
        $oss_sdk_service = new ALIOSS();
        $object = $_SERVER['HTTP_HOST'].'.'.$_GET['uid'].'.'.date('YmdHis').rand(2,pow(2,24)).'.'.strtolower(trim(substr(strrchr($_FILES['Filedata']['name'],'.'),1)));
        $content = '';
        $length = 0;
        $fp = fopen($_FILES['Filedata']['tmp_name'], 'r');
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
}
?>
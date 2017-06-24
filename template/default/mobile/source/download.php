<?php
include '../../../../source/system/db.class.php';
checkmobile() or exit(header('location:'.IN_PATH));
$type = SafeRequest("type","get");
$id = SafeRequest("id","get");
if($type == 'music'){
        $file = geturl(getfield('music', 'in_audio', 'in_id', $id));
}else{
        $file = geturl(getfield('video', 'in_play', 'in_id', $id));
}
$headers = get_headers($file, 1);
if(array_key_exists('Content-Length', $headers)){
        $filesize = $headers['Content-Length'];
}else{
        $filesize = strlen(@file_get_contents($file));
}
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=".basename($file));
header("Content-Length: ".$filesize);
readfile($file);
?>
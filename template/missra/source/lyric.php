<?php
include '../../../source/system/db.class.php';
$id = SafeRequest("id","get");
$file = geturl(getfield('music', 'in_lyric', 'in_id', $id), 'lyric');
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=".basename($file));
readfile($file);
?>
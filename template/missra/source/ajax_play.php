<?php
include '../../../source/system/db.class.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=".IN_CHARSET);
$lists = isset($_COOKIE['in_misc_play']) ? $_COOKIE['in_misc_play'] : NULL;
echo '<embed src="'.get_template(1).'widget/v.swf?php=play&lists='.$lists.'&.swf" width="100%" height="100%" wmode="transparent" type="application/x-shockwave-flash"></embed>';
?>
<?php
if(!defined('IN_ROOT')){exit('Access denied');}
Administrator(6);
include_once 'source/system/min.static.class.php';
include_once 'source/system/lib.static.class.php';
mainjump();
if(IN_REWRITEOPEN != 2){exit("<span style=\"color:#C00\">请先在 全局->缓存信息->运行模式->伪静态开关 选择“静态”</span>");}
fwrite(fopen('index.html', 'wb'), Lib::L_oad('index.html'));
echo iframe_message("首页生成完毕！");
?>
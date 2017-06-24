<?php
if(!defined('IN_ROOT')){exit('Access denied');}
Administrator(6);
include_once 'source/system/min.static.class.php';
include_once 'source/system/lib.static.class.php';
mainjump();
if(IN_REWRITEOPEN != 2){exit("<span style=\"color:#C00\">请先在 全局->缓存信息->运行模式->伪静态开关 选择“静态”</span>");}
?>
<script type="text/javascript">
var _table;
var _pagenum = 0;
var _sizes = 0;
var _size = 0;
function setpagenum(table, pagenum, sizes, size){
        _table = table;
        _pagenum = pagenum;
        _sizes = sizes;
        _size = size;
        document.getElementById("pagenum").innerHTML = pagenum;
        document.getElementById("status").innerHTML = sizes+"/"+size;
}
function setpagenums(pagenums, i, pagerows){
        if(_pagenum > 0){
                var percent = Math.round(pagenums*100/_pagenum);
                var percents = Math.round(i*100/pagerows);
                document.getElementById("progressbar").style.width = percent+"%";
                document.getElementById("pagenums").innerHTML = pagenums;
                if(percent > 0){
                        document.getElementById("progressbar").innerHTML = percent+"%";
                        document.getElementById("progressText").innerHTML = "";
                }else{
                        document.getElementById("progressText").innerHTML = percent+"%";
                }
                if(_sizes < _size && percents > 99){
                        setTimeout("location.href='?iframe=html_list&table="+_table+"&listid=0&sizes="+(Number(_sizes)+1)+"&pagenums="+pagenums+"';", 1000);
                }
        }
}
</script>
<?php
echo "<table style=\"text-align:center;width:100%;border:1px solid #09C\">";
echo "<tr><th style=\"border:1px solid #09C\">分批状态</th><td style=\"border:1px solid #09C\"><div id=\"status\">0/0</div></td></tr>";
echo "<tr><th style=\"border:1px solid #09C\">累计生成</th><td style=\"border:1px solid #09C\"><div id=\"pagenums\">0</div></td></tr>";
echo "<tr><th style=\"border:1px solid #09C\">分页总数</th><td style=\"border:1px solid #09C\"><div id=\"pagenum\">0</div></td></tr>";
echo "<tr><th style=\"border:1px solid #09C\">完成进度</th><td style=\"border:1px solid #09C\"><div id=\"progressbar\" style=\"float:left;width:1px;text-align:center;color:#FFFFFF;background-color:#09C\"></div><div id=\"progressText\" style=\"float:left\">0%</div></td></tr>";
echo "</table>";
ob_start();
@set_time_limit(0);
global $db;
$table = SafeRequest("table","get");
$info = $table == 'class' ? 'music' : str_replace('_class', '', $table);
$listid = isset($_POST['listid']) ? SafeRequest("listid","post") : SafeRequest("listid","get");
$sizes = isset($_GET['sizes']) ? SafeRequest("sizes","get") : 1;
if($listid == 0){
        $sql = "select * from ".tname($table);
        $list = $db->query($sql);
        $size = $db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
        $class = $db->query("select * from ".tname($table)." LIMIT ".($sizes - 1).",1");
}else{
        $list = $db->query("select * from ".tname($table)." where in_id in ($listid)");
        $size = 1;
        $class = $db->query("select * from ".tname($table)." where in_id=".intval($listid));
}
preg_match_all('/<!--\{loop '.$info.'(.*?page=([\S]+).*?)\}-->([\s\S]+?)<!--\{\/loop '.$info.'\}-->/', file_get_contents(get_template().$table.'.html'), $arr);
$pagenum = 0;
while($row = $db->fetch_array($list)){
        $count = $db->num_rows($db->query("select count(*) from ".tname($info)." where in_passed=0 and in_classid=".$row['in_id']));
        $pagenum = $pagenum + ($count == 0 ? 1 : ceil($count / $arr[2][0]));
}
echo "<script type=\"text/javascript\">setpagenum('".$table."', ".$pagenum.", ".$sizes.", ".$size.");</script>";
$pagenums = isset($_GET['pagenums']) ? SafeRequest("pagenums","get") : 0;
while($rows = $db->fetch_array($class)){
        $counts = $db->num_rows($db->query("select count(*) from ".tname($info)." where in_passed=0 and in_classid=".$rows['in_id']));
        $pagerows = $counts == 0 ? 1 : ceil($counts / $arr[2][0]);
        for($i = 1; $i < $pagerows + 1; $i++){
                $pagenums = $pagenums + 1;
                $self = 'index.php/'.$table.'/'.$rows['in_id'].'/p'.$i.'/';
                $save = substr(rewrite_mode($self, true), strlen(IN_PATH));
                creatdir(substr($save, 0, strrpos($save, '/') + 1));
                fwrite(fopen($save, 'wb'), Lib::L_ist($rows['in_id'], $table, $i, $self));
                echo "<script type=\"text/javascript\">setpagenums(".$pagenums.", ".$i.", ".$pagerows.");</script>";
                ob_flush();
                flush();
        }
}
?>
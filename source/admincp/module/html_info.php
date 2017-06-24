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
var _ac;
var _id = 0;
var _num = 0;
var _sizes = 0;
var _size = 0;
var _htmlsize = 0;
function setnum(table, ac, id, num, sizes, size, htmlsize){
        _table = table;
        _ac = ac;
        _id = id;
        _num = num;
        _sizes = sizes;
        _size = size;
        _htmlsize = htmlsize;
        document.getElementById("num").innerHTML = num;
        document.getElementById("status").innerHTML = sizes+"/"+size;
}
function setnums(nums){
        if(_num > 0){
                var time = _table.match(/^(music|video)$/g) ? 3000 : 2000;
                var percent = Math.round(nums*100/_num);
                var percents = Math.round((Number(nums)-((Number(_sizes)-1)*_htmlsize))*100/_htmlsize);
                document.getElementById("progressbar").style.width = percent+"%";
                document.getElementById("nums").innerHTML = nums;
                if(percent > 0){
                        document.getElementById("progressbar").innerHTML = percent+"%";
                        document.getElementById("progressText").innerHTML = "";
                }else{
                        document.getElementById("progressText").innerHTML = percent+"%";
                }
                if(_sizes < _size && percents > 99){
                        setTimeout("location.href='?iframe=html_info&table="+_table+"&ac="+_ac+"&id="+_id+"&sizes="+(Number(_sizes)+1)+"&nums="+(_sizes*_htmlsize)+"';", time);
                }
        }
}
</script>
<?php
echo "<table style=\"text-align:center;width:100%;border:1px solid #09C\">";
echo "<tr><th style=\"border:1px solid #09C\">分批状态</th><td style=\"border:1px solid #09C\"><div id=\"status\">0/0</div></td></tr>";
echo "<tr><th style=\"border:1px solid #09C\">累计生成</th><td style=\"border:1px solid #09C\"><div id=\"nums\">0</div></td></tr>";
echo "<tr><th style=\"border:1px solid #09C\">内页总数</th><td style=\"border:1px solid #09C\"><div id=\"num\">0</div></td></tr>";
echo "<tr><th style=\"border:1px solid #09C\">完成进度</th><td style=\"border:1px solid #09C\"><div id=\"progressbar\" style=\"float:left;width:1px;text-align:center;color:#FFFFFF;background-color:#09C\"></div><div id=\"progressText\" style=\"float:left\">0%</div></td></tr>";
echo "</table>";
ob_start();
@set_time_limit(0);
define('IN_HTMLSIZE', '6000');
global $db;
$table = SafeRequest("table","get");
$action = SafeRequest("ac","get");
if($action == 'class'){
        $sizes = isset($_GET['sizes']) ? SafeRequest("sizes","get") : 1;
        $classid = isset($_POST['classid']) ? SafeRequest("classid","post") : SafeRequest("id","get");
        if($classid == 0){
                $sql = "select * from ".tname($table);
                $info = $db->query($sql);
                $num = $db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
                $size = $num > IN_HTMLSIZE ? ceil($num/IN_HTMLSIZE) : 1;
                if($size > 1){
                        $info = $db->query("select * from ".tname($table)." LIMIT ".(($sizes - 1) * IN_HTMLSIZE).",".IN_HTMLSIZE);
                }
        }else{
                $sql = "select * from ".tname($table)." where in_classid=".intval($classid);
                $info = $db->query($sql);
                $num = $db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
                $size = $num > IN_HTMLSIZE ? ceil($num/IN_HTMLSIZE) : 1;
                if($size > 1){
                        $info = $db->query("select * from ".tname($table)." where in_classid=".intval($classid)." LIMIT ".(($sizes - 1) * IN_HTMLSIZE).",".IN_HTMLSIZE);
                }
        }
        echo "<script type=\"text/javascript\">setnum('".$table."', '".$action."', ".$classid.", ".$num.", ".$sizes.", ".$size.", ".IN_HTMLSIZE.");</script>";
}elseif($action == 'day'){
        $sizes = isset($_GET['sizes']) ? SafeRequest("sizes","get") : 1;
        $dayid = isset($_POST['dayid']) ? SafeRequest("dayid","post") : SafeRequest("id","get");
        if($dayid == 0){
                $sql = "select * from ".tname($table)." where DATEDIFF(DATE(in_addtime),'".date('Y-m-d')."')=0";
                $info = $db->query($sql);
                $num = $db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
                $size = $num > IN_HTMLSIZE ? ceil($num/IN_HTMLSIZE) : 1;
                if($size > 1){
                        $info = $db->query("select * from ".tname($table)." where DATEDIFF(DATE(in_addtime),'".date('Y-m-d')."')=0 LIMIT ".(($sizes - 1) * IN_HTMLSIZE).",".IN_HTMLSIZE);
                }
        }else{
                $sql = "select * from ".tname($table)." where DATEDIFF(DATE(in_addtime),'".date('Y-m-d')."')=-".$dayid;
                $info = $db->query($sql);
                $num = $db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
                $size = $num > IN_HTMLSIZE ? ceil($num/IN_HTMLSIZE) : 1;
                if($size > 1){
                        $info = $db->query("select * from ".tname($table)." where DATEDIFF(DATE(in_addtime),'".date('Y-m-d')."')=-".$dayid." LIMIT ".(($sizes - 1) * IN_HTMLSIZE).",".IN_HTMLSIZE);
                }
        }
        echo "<script type=\"text/javascript\">setnum('".$table."', '".$action."', ".$dayid.", ".$num.", ".$sizes.", ".$size.", ".IN_HTMLSIZE.");</script>";
}
$nums = isset($_GET['nums']) ? SafeRequest("nums","get") : 0;
while($row = $db->fetch_array($info)){
        $nums = $nums + 1;
        $save = substr(getlink($row['in_id'], $table), strlen(IN_PATH));
        creatdir(substr($save, 0, strrpos($save, '/') + 1));
        fwrite(fopen($save, 'wb'), Lib::I_nfo($row['in_id'], $table));
        echo "<script type=\"text/javascript\">setnums(".$nums.");</script>";
        ob_flush();
        flush();
}
?>
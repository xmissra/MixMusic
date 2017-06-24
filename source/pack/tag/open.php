<?php
include '../../system/db.class.php';
global $db;
$array='';
$sql="select * from ".tname('tag')." where in_type=0 order by in_id asc";
$result=$db->query($sql);
$count=$db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
if($count>0){
        $array='Array("按地域",';
        while($row=$db->fetch_array($result)){
                $array=$array.'"'.$row['in_title'].'",';
        }
        $array=str_replace(',]', '),', $array.']');
}
$sql="select * from ".tname('tag')." where in_type=1 order by in_id asc";
$result=$db->query($sql);
$count=$db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
if($count>0){
        $array=$array.'Array("按曲风",';
        while($row=$db->fetch_array($result)){
                $array=$array.'"'.$row['in_title'].'",';
        }
        $array=str_replace(',]', '),', $array.']');
}
$sql="select * from ".tname('tag')." where in_type=2 order by in_id asc";
$result=$db->query($sql);
$count=$db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
if($count>0){
        $array=$array.'Array("按心情",';
        while($row=$db->fetch_array($result)){
                $array=$array.'"'.$row['in_title'].'",';
        }
        $array=str_replace(',]', '),', $array.']');
}
$sql="select * from ".tname('tag')." where in_type=3 order by in_id asc";
$result=$db->query($sql);
$count=$db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
if($count>0){
        $array=$array.'Array("按歌手",';
        while($row=$db->fetch_array($result)){
                $array=$array.'"'.$row['in_title'].'",';
        }
        $array=str_replace(',]', '),', $array.']');
}
$sql="select * from ".tname('tag')." where in_type=4 order by in_id asc";
$result=$db->query($sql);
$count=$db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
if($count>0){
        $array=$array.'Array("按语言",';
        while($row=$db->fetch_array($result)){
                $array=$array.'"'.$row['in_title'].'",';
        }
        $array=str_replace(',]', '),', $array.']');
}
        $array=str_replace(',]', '', $array.']');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<title>标签添加</title>
<link href="../../../static/pack/tag/tag.css" rel="stylesheet" type="text/css" />
<link href="../../../static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../static/pack/tag/jquery.js"></script>
<script type="text/javascript" src="../../../static/pack/tag/tag.js"></script>
<script type="text/javascript" src="../../../static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="../../../static/pack/asynctips/asyncbox.v1.4.5.js"></script>
</head>
<body>
<script type="text/javascript">
var tagarray = Array(<?php echo $array; ?>);
var html = '<div class="popDiyTags-form form-box"><div class="popDiyTags-title"><div class="fl"><h4 class="selected-index">你已经选择了 <span class="red">0</span> 个标签<em>（最多选择5个）</em></h4><ul class="selected-list selected-list01"></ul></div><a class="btn btnTure" href="javascript:void(0);"><span class="btn-wrap"><span class="btn-inner"><span class="btn-txt">添加并返回</span></span></span></a></div>';
for (var i = 0; i < tagarray.length; i++) {
	html += '<dl class="popDiyTags-list clearfix">';
	html += '<dt>' + tagarray[i][0] + '</dt>';
	for (var j = 1; j < tagarray[i].length; j++) {
		html += '<dd><a href="#">' + tagarray[i][j] + '</a></dd>';
	}
	html += "</dl>";
}
html += '<div class="popDiyTags-title"><div class="fl"><h4 class="selected-index">你已经选择了 <span class="red">0</span> 个标签<em>（最多选择5个）</em></h4><ul class="selected-list selected-list02"></ul></div><a class="btn btnTure" href="javascript:void(0);"><span class="btn-wrap"><span class="btn-inner"><span class="btn-txt">添加并返回</span></span></span></a></div></div>';
document.writeln(html);
function ReturnValue(reimg){
        this.parent.document.<?php echo $_GET['form']; ?>.value=reimg;
        this.parent.asyncbox.tips("恭喜，标签添加成功！", "success", 1000);
        this.parent.layer.closeAll();
}
</script>
</body>
</html>
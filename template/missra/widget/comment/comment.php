<?php
include '../../../../source/system/db.class.php';
include '../../../../source/system/user.php';
include '../../common.php';
global $db,$userlogined,$missra_in_userid,$missra_in_username;
$id = SafeRequest("id","get");
if($row = $db->getrow("select * from ".tname('music')." where in_id=".intval($id))){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<title><?php echo $row['in_name']; ?> - 音乐评论 - <?php echo IN_NAME; ?></title>
<link href="./comment.css" rel="stylesheet" type="text/css" />
<link href="<?php echo IN_PATH; ?>static/pack/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo IN_PATH; ?>static/pack/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript" src="../../js/lib.js"></script>
<script type="text/javascript">var temp_url = '<?php echo get_template(1); ?>';</script>
</head>
<body>
<div class="commentArea">
<div class="commentHeader">
<?php if($userlogined){ ?>
<h2 class="floatLeft"><a href="<?php echo getlink($missra_in_userid); ?>" target="_blank"><?php echo $missra_in_username; ?></a></h2>
<?php }else{ ?>
<h1 class="floatLeft"><a href="<?php echo IN_PATH; ?>user.php" target="_blank">游客</a></h1>
<a class="floatRight logout" href="<?php echo rewrite_mode('index.php/page/register/'); ?>" target="_blank">注册</a>
<?php } ?>
</div>
<textarea id="_content" cols="35" rows="5"></textarea>
<div class="sendComment">
<span class="commentTip" id="_tips">请<em>文明</em>发言！</span>
<button class="btnComment" type="button" onclick="send_comment(<?php echo $row['in_id']; ?>);">评 论</button>
</div>
</div>
<div class="listArea" style="overflow-y:scroll;overflow-x:hidden;height:380px;">
<?php
$sql = "select * from ".tname('comment')." where in_table='music' and in_tid=".$row['in_id']." order by in_addtime desc";
$Arr = getstylepage($sql, 10);
$result = $Arr[1];
$count = $Arr[2];
if($count == 0){
        echo "<center>还没有评论，赶快来抢占沙发吧！</center>";
}else{
        if($result){
                echo "<ul class=\"commentList\">";
                while ($com = $db->fetch_array($result)) {
                        $content = getlenth($com['in_content'], 128);
                        echo "<li><div class=\"commentHead\"><a href=\"".getlink($com['in_uid'])."\" target=\"_blank\"><img src=\"".getavatar($com['in_uid'])."\" width=\"30\" height=\"30\"></a></div><div class=\"commentWrap\"><span class=\"commentContent\"><a href=\"".getlink($com['in_uid'])."\" target=\"_blank\" style=\"font-weight:bold;\">".$com['in_uname'].": </a>".$content."</span><span class=\"commentOpe\"><a class=\"commentReply replyAction\">".datetime($com['in_addtime'])."</a></span></div></li>";
                }
                echo "</ul>";
        }
}
?>
</div>
<div style="text-align:right;padding:0;margin:0;padding-right:20px;height:20px;line-height:20px;">
<?php echo $Arr[0]; ?>
</div>
</body>
</html>
<?php }else{
exit(html_message("错误信息","数据不存在或已被删除！"));
} ?>
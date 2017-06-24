<?php
if(!defined('IN_ROOT')){exit('Access denied');}
Administrator(5);
$in_uid=intval(SafeRequest("in_uid","get"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>认证资料</title>
<link href="static/admincp/css/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="container">
<table class="tb tb2 fixpadding">
<tr><th colspan="15" class="partition">认证资料</th></tr>
<?php
global $db;
if($row = $db->getrow("select * from ".tname('verify')." where in_uid=".$in_uid)){
?>
<tr class="hover"><td><table>
<tr><td width="100">真实姓名:</td><td><?php echo $row['in_name']; ?></td></tr>
<tr><td width="100">证件类型:</td><td><?php echo $row['in_cardtype']; ?></td></tr>
<tr><td width="100">证件号码:</td><td><?php echo $row['in_cardnum']; ?></td></tr>
<tr><td width="100">联系地址:</td><td><?php echo $row['in_address']; ?></td></tr>
<tr><td width="100">手机号码:</td><td><?php echo $row['in_mobile']; ?></td></tr>
<tr><td width="100">提交时间:</td><td><?php echo $row['in_addtime']; ?></td></tr>
</table></td></tr>
<?php }else{ ?>
<tr><td colspan="4"><strong>没有认证资料</strong></td></tr>
<?php } ?>
</table>
</div>
</body>
</html>
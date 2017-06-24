<?php
include '../../system/db.class.php';
require_once 'alipay.config.php';
require_once 'alipay_notify.class.php';
?>
<!DOCTYPE HTML>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>">
<?php
$alipayNotify = new AlipayNotify($aliapy_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {
	$dingdan	= $_GET['out_trade_no'];
	$trade_no	= $_GET['trade_no'];
	$total_fee	= $_GET['price'];
	if($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS' || $_GET['trade_status'] == 'TRADE_FINISHED') {
		global $db;
		$result=$db->query("select * from ".tname('paylog')." where in_title='".SafeSql($dingdan)."'");
		if($row=$db->fetch_array($result)){
			$in_uid = $row['in_uid'];
			$in_points = $row['in_points'];
			$db->query("update ".tname('paylog')." set in_lock=0 where in_title='".SafeSql($dingdan)."'");
			$db->query("update ".tname('user')." set in_points=in_points+".$in_points." where in_userid=".$in_uid);
			$trade_statuss = "恭喜您，成功购买 ".$in_points." 个金币";
		}else{
    			$trade_statuss = "非法操作，请勿刷新此页。";
		}
	} else {
    		$trade_statuss = "支付失败，请将以上信息复制给管理员1。";
	}
}else {
    	$trade_statuss = "支付失败，请将以上信息复制给管理员。";
}
?>
        <title>支付宝即时支付</title>
        <style type="text/css">
            .font_content{
                font-family:"宋体";
                font-size:14px;
                color:#FF6600;
            }
            .font_title{
                font-family:"宋体";
                font-size:16px;
                color:#FF0000;
                font-weight:bold;
            }
            table{
                border: 1px solid #CCCCCC;
            }
        </style>
    </head>
    <body>
        <table align="center" width="600" cellpadding="5" cellspacing="0">
            <tr>
                <td align="center" class="font_title" colspan="2">通知返回</td>
            </tr>
            <tr>
                <td class="font_content" align="right">支付宝交易号：</td>
                <td class="font_content" align="left"><?php echo $_GET['trade_no']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">订单号：</td>
                <td class="font_content" align="left"><?php echo $_GET['out_trade_no']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">付款总金额：</td>
                <td class="font_content" align="left"><?php echo $_GET['total_fee']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">商品标题：</td>
                <td class="font_content" align="left"><?php echo $_GET['subject']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">商品描述：</td>
                <td class="font_content" align="left"><?php echo $_GET['body']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">买家账号：</td>
                <td class="font_content" align="left"><?php echo $_GET['buyer_email']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">交易状态：</td>
                <td class="font_title" align="left"><?php echo $trade_statuss; ?></td>
            </tr>
        </table>
    </body>
</html>
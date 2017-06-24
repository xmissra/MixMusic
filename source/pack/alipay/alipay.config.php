<?php
$aliapy_config['partner']      = IN_ALIPAYID;
$aliapy_config['key']          = IN_ALIPAYKEY;
$aliapy_config['seller_email'] = IN_ALIPAYUID;
$aliapy_config['return_url']   = 'http://'.$_SERVER['HTTP_HOST'].IN_PATH.'source/pack/alipay/return_url.php';
$aliapy_config['notify_url']   = 'http://'.$_SERVER['HTTP_HOST'].IN_PATH.'source/pack/alipay/notify_url.php';
$aliapy_config['sign_type']    = 'MD5';
$aliapy_config['input_charset']= IN_CHARSET;
$aliapy_config['transport']    = 'http';
?>
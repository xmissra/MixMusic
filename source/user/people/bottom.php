<?php if(!defined('IN_ROOT')){exit('Access denied');} ?>
<div id="footer">
        <p><a href="mailto:<?php echo IN_MAIL; ?>">联系我们</a> - <a href="http://www.miitbeian.gov.cn/" target="_blank"><?php echo IN_ICP; ?></a> <?php echo base64_decode(IN_STAT); ?></p>
        <p>Powered by <a href="http://www.missra.com/" target="_blank"><strong>MixMusic</strong></a> <span title="<?php echo IN_BUILD; ?>"><?php echo IN_VERSION; ?></span> &copy; 2015-<?php echo date('Y'); ?> <a href="http://www.missra.com/" target="_blank">MixMusic</a> Inc.</p>
</div>
</div>
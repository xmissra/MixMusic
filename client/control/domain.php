<?php
!defined('IN_UC') && exit('Access Denied');

class domaincontrol extends base {
	function domaincontrol() {
		$this->base();
		$this->load('domain');
	}
	function onls() {
		return $_ENV['domain']->get_list(1, 9999, 9999);
	}
}
?>
<?php
!defined('IN_UC') && exit('Access Denied');

class cachecontrol extends base {
	function cachecontrol() {
		$this->base();
	}
	function onupdate($arr) {
		$this->load("cache");
		$_ENV['cache']->updatedata();
	}
}
?>
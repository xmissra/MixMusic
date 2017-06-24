<?php
!defined('IN_UC') && exit('Access Denied');

class appmodel {
	var $db;
	var $base;
	function appmodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
	}
	function get_apps($col = '*', $where = '') {
		$arr = $this->db->fetch_all("SELECT $col FROM ".UC_DBTABLEPRE."applications".($where ? ' WHERE '.$where : ''));
		return $arr;
	}
}
?>
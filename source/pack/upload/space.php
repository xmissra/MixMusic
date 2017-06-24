<?php
include '../../system/db.class.php';
if($_GET['do'] == 'album'){
	header("location:".getlink($_GET['id'] < 0 ? 0 : $_GET['id'], 'photogroup'));
}
?>
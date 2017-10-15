<?php
	// Require các thư viện
	require_once 'admin/classes/DB.php';
	require_once 'admin/classes/session.php';
	require_once 'admin/classes/functions.php';

	// Kết nối database
	$db = new DB();
	$db->connect();
	$db->set_char('utf8');

	$_DOMAIN = 'http://localhost:7000/Project/Project-01/';
	$_CSS = 'http://localhost:7000/Project/Project-01/front-end/css/';
	$_JS = 'http://localhost:7000/Project/Project-01/front-end/js/';
	$_IMG = 'http://localhost:7000/Project/Project-01/front-end/images/';
	// Lấy thông tin Website
	$sql_get_date_web = "SELECT * FROM website";
	if ($db->num_rows($sql_get_date_web)) {
		$data_web = $db->fetch_assoc($sql_get_date_web, 1);
	}
?>
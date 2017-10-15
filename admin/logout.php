<?php
	// Require database & thông tin chung
	require_once 'core/init.php';

	// Xóa session
	$session->destroy();
	// Trở về trang index
	new Redirect($_DOMAIN);
?>
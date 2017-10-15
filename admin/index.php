<?php
	// Require database & thông tin chung
	require_once 'core/init.php';

	// Require Header
	require_once 'includes/header.php';

	// Nếu đăng nhập
	if ($user) {
		// Hiển thị Sidebar
		require_once 'templates/sidebar.php';

		// Hiển thị Content
		require_once 'templates/content.php';

	// Nếu không đăng nhập
	} else {
		// Hiển thị Form đăng nhập
		require_once 'templates/signin.php';
	}

	// Require Footer
	require_once 'includes/footer.php';
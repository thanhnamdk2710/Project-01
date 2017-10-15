<section>
<?php
	// Trang nội dung bài viết
	if (isset($_GET['sp']) && isset($_GET['id'])) {
		require_once 'templates/posts.php';
	// Trang góp ý
	} else if (isset($_GET['sc']) &&  $_GET['sc'] == 'contact') {
		require_once 'templates/contact.php';
	// Trang hình ảnh
	} else if (isset($_GET['sc']) &&  $_GET['sc'] == 'photos') {
		require_once 'templates/photos.php';
	// Trang chuyên mục
	} else if (isset($_GET['sc'])) {
		require_once 'templates/categories.php';
	// Trang tìm kiếm
	} else if (isset($_GET['s'])) {
		require_once 'templates/search.php';
	} else {
		require_once 'templates/latest-news.php';
	}
?>
</section>
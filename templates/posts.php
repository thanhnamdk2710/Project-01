<?php
	// Sidebar left
	require_once 'templates/sidebar-left.php';
?>
<!--====================Main=====================-->
<article class="content col-md-6 block">
	<?php
	// Get tham số post
	$sp = trim(htmlspecialchars(addslashes($_GET['sp'])));
	$id = trim(htmlspecialchars(addslashes($_GET['id'])));

	// Lấy thông tin bài viết
	$sql_get_data_post = "SELECT * FROM posts WHERE id_post = $id AND slug = '$sp'";
	if ($db->num_rows($sql_get_data_post)) {
		$data_post = $db->fetch_assoc($sql_get_data_post, 1);
		$get_author_post = $data_post['author_id'];

		$sql_get_author = "SELECT id_acc, username FROM accounts WHERE id_acc = 1";
		$author_post = $db->fetch_assoc($sql_get_author, 1);

		echo '
			<h4>'.$data_post['title'].'</h4>
			<div class="body_post">
				'.htmlspecialchars_decode($data_post['body']).'
			</div>
			<div class="pull-right">Tác giả: '.$author_post['username'].'</div>
		';
	} else {
		echo '
			<h2 class="text-danger text-center">OOPS! Trang này không tồn tại</h2>
			<a href="'.$_DOMAIN.'" class="btn btn-primary">Trở về trang chủ</a>
		';
	}
	?>
	
</article>

<?php
	// Sidebar right
	require_once 'templates/sidebar-right.php';
?>
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
	$sql_get_data_post = "SELECT * FROM posts WHERE id_post = $id";
	if ($db->num_rows($sql_get_data_post)) {
		$data_post = $db->fetch_assoc($sql_get_data_post, 1);
	} else {
		// Nếu không tồn tại
		require 'templates/404.php';
		exit;
	}
	?>
	<h4><?= $data_post['title'] ?></h4>
	<div class="body_post">
		<?= htmlspecialchars_decode($data_post['body']) ?>
	</div>
</article>

<?php
	// Sidebar right
	require_once 'templates/sidebar-right.php';
?>
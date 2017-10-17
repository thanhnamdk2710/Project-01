<!-- Dashboard bài viết -->
<h3>Bài viết</h3>
<div class="row">
	<?php
	if ($data_user['position'] == '1') {
		// Lấy tổng số bài viết
		$sql_get_count_all_post = "SELECT * FROM posts";
		$count_all_post = $db->num_rows($sql_get_count_all_post);

		echo '
			<div class="col-md-4">
				<div class="alert alert-info">
					<h1>'.$count_all_post.'</h1>
					<p>Tổng bài viết</p>
				</div>
			</div>
		';
	} else {
		// Lấy số bài viết của tác giả
		$sql_get_count_post_author = "SELECT id_post FROM posts WHERE author_id = '$data_user[id_acc]'";
		$count_post_author = $db->num_rows($sql_get_count_post_author);

		echo '
			<div class="col-md-4">
				<div class="alert alert-info">
					<h1>'.$count_post_author.'</h1>
					<p>Bài viết của bạn</p>
				</div>
			</div>
		';
	}
	?>
	<div class="col-md-4">
		<div class="alert alert-success">
			<h1>
				<?php
				// Lấy tổng bài viết xuất bản
				// Nếu là admin lấy toàn bộ bài viết xuất bản
				if ($data_user['position'] == '1') {
					$sql_get_count_post_public = "SELECT * FROM posts WHERE status = '1'";
				// Nếu là tác giá lấy các bài viết xuất bản của tác giả
				} else {
					$sql_get_count_post_public = "SELECT * FROM posts WHERE status = '1' AND author_id ='$data_user[id_acc]'";
				}
				echo $db->num_rows($sql_get_count_post_public);
				?>
			</h1>
			<p>Bài viết xuất bản</p>
		</div>
	</div>
	<div class="col-md-4">
		<div class="alert alert-warning">
			<h1>
				<?php
				// Lấy tổng bài viết ẩn
				// Nếu là admin thì lấy toàn bộ bài viết ẩn
				if ($data_user['position'] == '1') {
				$sql_get_count_post_hide = "SELECT * FROM posts WHERE status = '0'";
				// Nếu là tác giá lấy các bài viết xuất bản của tác giả
				} else {
					$sql_get_count_post_hide = "SELECT * FROM posts WHERE status = '0' AND author_id ='$data_user[id_acc]'";
				}
				echo $db->num_rows($sql_get_count_post_hide);
				?>
			</h1>
			<p>Bài viết ẩn</p>
		</div>
	</div>
</div>

<!-- Dashboard Hình ảnh -->
<h3>Hình Ảnh</h3>
<div class="row">
	<?php
	if ($data_user['position'] == '1') {
		// Lấy tổng số hình ảnh
		$sql_get_count_img = "SELECT id_img FROM images";
		$label = 'Tổng hình ảnh';
	} else {
		// Lấy số hình ảnh của tác giả
		$sql_get_count_img = "SELECT id_img FROM images WHERE uploader_id = '$data_user[id_acc]'";
		$label = 'Hình ảnh';
	}
	$count_img = $db->num_rows($sql_get_count_img);
	echo '
		<div class="col-md-4">
			<div class="alert alert-info">
				<h1>'.$count_img.'</h1>
				<p>'.$label.'</p>
			</div>
		</div>
	';

	if ($data_user['position'] == '1') {
		// Lấy tổng dung lượng
		$sql_get_size_img = "SELECT size FROM images";
		$label = 'Tổng dung lượng ảnh';
	} else {
		// Lấy dung lượng ảnh của tác giả
		$sql_get_size_img = "SELECT size FROM images WHERE uploader_id = '$data_user[id_acc]'";
		$label = 'Dung lượng ảnh';
	}
	
	// Tính dung lượng hình ảnh
	if ($db->num_rows($sql_get_size_img)) {
		$count_size_img = 0;
		foreach ($db->fetch_assoc($sql_get_size_img, 0) as $data_img) {
			$count_size_img = $count_size_img + $data_img['size'];
		}
	} else {
		$count_size_img = 0;
	}

	// Gán đơn vị cho dung lượng
	if ($count_size_img < 1024) {
		$count_size_img = $count_size_img . ' B';
	} else if ($count_size_img < 1048576) {
		$count_size_img = round($count_size_img / 1024) . ' KB';
	} else if ($count_size_img < 1073741824) {
		$count_size_img = round($count_size_img / 1024 / 1024) . ' MB';
	} else if ($count_size_img < 1099511627776) {
		$count_size_img = round($count_size_img / 1024 / 1024 / 1024) . ' GB';
	}

	echo '
		<div class="col-md-4">
			<div class="alert alert-success">
				<h1>'.$count_size_img.'</h1>
				<p>'.$label.'</p>
			</div>
		</div>
	';

	if ($data_user['position'] == '1') {
		// Lấy tổng số hình ảnh lỗi
		$sql_get_count_img = "SELECT url FROM images";
		$label = 'Tổng hình ảnh lỗi';
	} else {
		// Lấy số hình ảnh của tác giả
		$sql_get_count_img = "SELECT url FROM images WHERE uploader_id = '$data_user[id_acc]'";
		$label = 'Hình ảnh lỗi';
	}
	
	// Kiểm tra danh sách hình ảnh
	$count_img_error = 0;
	if ($db->num_rows($sql_get_count_img)) {
		foreach ($db->fetch_assoc($sql_get_count_img, 0) as $data_img) {
			if (!file_exists('../' . $data_img['url'])) {
				$count_img_error++;
			}
		}
	}

	echo '
		<div class="col-md-4">
			<div class="alert alert-danger">
				<h1>'.$count_img_error.'</h1>
				<p>'.$label.'</p>
			</div>
		</div>
	';
	?>
</div>


<?php
	if ($data_user['position'] == '1') {
?>
<!-- Dashboard góp ý -->
<h3>Góp ý</h3>
<div class="row">
	<?php
	// Lấy tổng góp ý
	$sql_get_count_feed = "SELECT id_feed FROM feedback";
	$count_feed = $db->num_rows($sql_get_count_feed);

	echo '
		<div class="col-md-4">
			<div class="alert alert-info">
				<h1>'.$count_feed.'</h1>
				<p>Tổng số góp ý</p>
			</div>
		</div>
	';

	// Lấy số góp đã xem
	$sql_get_count_feed_view = "SELECT id_feed FROM feedback WHERE status = '1'";
	$count_feed_view = $db->num_rows($sql_get_count_feed_view);

	echo '
		<div class="col-md-4">
			<div class="alert alert-success">
				<h1>'.$count_feed_view.'</h1>
				<p>Góp ý đã xem</p>
			</div>
		</div>
	';

	// Lấy số góp ý chưa xem
	$sql_get_count_feed_not_view = "SELECT id_feed FROM feedback WHERE status = '0'";
	$count_feed_not_view = $db->num_rows($sql_get_count_feed_not_view);

	echo '
		<div class="col-md-4">
			<div class="alert alert-danger">
				<h1>'.$count_feed_not_view.'</h1>
				<p>Góp ý chưa xem</p>
			</div>
		</div>
	';
	?>
</div>

<!-- Dashboard tài khoản -->
<h3>Tài khoản</h3>
<div class="row">
	<?php
	// Lấy tổng tài khoản
	$sql_get_count_acc = "SELECT id_acc FROM accounts WHERE position = '0'";
	$count_acc = $db->num_rows($sql_get_count_acc);

	echo '
		<div class="col-md-4">
			<div class="alert alert-info">
				<h1>'.$count_acc.'</h1>
				<p>Tổng tài khoản</p>
			</div>
		</div>
	';

	// Lấy số tài khoản hoạt động
	$sql_get_count_acc_active = "SELECT id_acc FROM accounts WHERE status = '0' AND position = '0'";
	$count_acc_active = $db->num_rows($sql_get_count_acc_active);

	echo '
		<div class="col-md-4">
			<div class="alert alert-success">
				<h1>'.$count_acc_active.'</h1>
				<p>Tài khoản hoạt động</p>
			</div>
		</div>
	';

	// Lấy số tài khoản khóa
	$sql_get_count_acc_locked = "SELECT id_acc FROM accounts WHERE status = '1' AND position = '0'";
	$count_acc_locked = $db->num_rows($sql_get_count_acc_locked);

	echo '
		<div class="col-md-4">
			<div class="alert alert-danger">
				<h1>'.$count_acc_locked.'</h1>
				<p>Tài khoản khóa</p>
			</div>
		</div>
	';
	?>
</div>

<!-- Dashboard chuyên mục -->
<h3>Chuyên mục</h3>
<div class="row">
	<?php
	// Lấy tổng chuyên mục
	$sql_get_count_cate = "SELECT id_cate FROM categories";
	$count_cate = $db->num_rows($sql_get_count_cate);

	echo '
		<div class="col-md-4">
			<div class="alert alert-info">
				<h1>'.$count_cate.'</h1>
				<p>Tổng chuyên mục</p>
			</div>
		</div>
	';

	// Lấy số chuyên mục lớn
	$sql_get_count_cate_1 = "SELECT id_cate FROM categories WHERE type = '1'";
	$count_cate_1 = $db->num_rows($sql_get_count_cate_1);

	echo '
		<div class="col-md-4">
			<div class="alert alert-success">
				<h1>'.$count_cate_1.'</h1>
				<p>Chuyên mục lớn</p>
			</div>
		</div>
	';

	// Lấy số chuyên mục vừa
	$sql_get_count_cate_2 = "SELECT id_cate FROM categories WHERE type = '2'";
	$count_cate_2 = $db->num_rows($sql_get_count_cate_2);

	echo '
		<div class="col-md-4">
			<div class="alert alert-warning">
				<h1>'.$count_cate_2.'</h1>
				<p>Chuyên mục vừa</p>
			</div>
		</div>
	';
	?>
</div>
	

<?php
	}
?>
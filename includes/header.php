<?php
	$title_error_404 = 'Không tìm thấy trang.';

	// URL bài viết
	if (isset($_GET['sp']) && isset($_GET['id'])) {
		$slug_post = trim(htmlspecialchars($_GET['sp']));
		$id_post = trim(htmlspecialchars($_GET['id']));

		// Kiểm tra bài viết tồn tại
		$sql_check_post = "SELECT id_post, slug, title FROM posts WHERE slug = '$slug_post' AND id_post = '$id_post'";
		if ($db->num_rows($sql_check_post)) {
			$data_post = $db->fetch_assoc($sql_check_post, 1);

			$title = $data_post['title'];
			// ..
		} else {
			$title = $title_error_404;
		}

	// URL chuyên mục
	} else if (isset($_GET['sc'])) {
		$slug_cate = trim(htmlspecialchars($_GET['sc']));

		// Kiểm tra chuyên mục tồn tại
		$sql_check_cate = "SELECT url, label FROM categories WHERE url ='$slug_cate'";
		if ($db->num_rows($sql_check_cate)) {
			$data_cate = $db->fetch_assoc($sql_check_cate, 1);

			$title = $data_cate['label'];
			// ..
		} else if ($slug_cate == 'photos') {
			$title = 'Hình ảnh';
		} else if ($slug_cate == 'contact') {
			$title = 'Liên hệ';
		} else {
			$title = $title_error_404;
		}
	} else {
		$title = $data_web['title'];
		// ..
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title><?= $title ?></title>
		<link rel="icon" href="<?= $_IMG ?>logo.jpg"/>

		<!-- Require Css -->
		<link rel="stylesheet" type="text/css" href="<?= $_CSS ?>bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?= $_CSS ?>bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="<?= $_CSS ?>font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?= $_CSS ?>lightbox.min.css">
		<link rel="stylesheet" type="text/css" href="<?= $_CSS ?>jquery.bxslider.min.css">
		<link rel="stylesheet" type="text/css" href="<?= $_CSS ?>common.css">
		
		<!-- Require JS -->
		<script src="<?= $_JS ?>jquery.min.js"></script>

	</head>
	<body>
		<main id="wrapper">
			<header>
				<a href="<?= $_DOMAIN ?>">
					<img src="<?= $_IMG ?>logo.png" title="Trường Cao đẳng nghề Nha Trang" />
				</a>
			</header>
			<!-- End header -->			

			<nav>
				<ul class="menu">
					<li>
						<a href="<?= $_DOMAIN ?>">Trang chủ
						</a>
					</li>
					<?php
						// Lấy danh sách chuyên mục cấp 1
						$sql_get_list_menu_1 = "SELECT * FROM categories WHERE type = '1' ORDER BY sort ASC";
						if ($db->num_rows($sql_get_list_menu_1)) {
							// In chuyên mục cấp 1
							foreach ($db->fetch_assoc($sql_get_list_menu_1, 0) as $data_menu_1) {
					?>
					<li>
						<a href="<?= $_DOMAIN ?>category/<?= $data_menu_1['url'] ?>">
							<?= $data_menu_1['label'] ?>
						</a>
						<?php
							// Lấy chuyên mục cấp 2 theo id cha
							$sql_get_list_menu_2 = "SELECT * FROM categories WHERE type = '2' AND parent_id = '$data_menu_1[id_cate]' ORDER BY sort ASC";
							if ($db->num_rows($sql_get_list_menu_2)) {
						?>
						<ul class="sub-menu">
							<?php
									foreach ($db->fetch_assoc($sql_get_list_menu_2, 0) as $data_menu_2) {
							?>
							<li>
								<a href="<?= $_DOMAIN ?>category/<?= $data_menu_2['url'] ?>">
									<?= $data_menu_2['label'] ?>
								</a>
							</li>
							<?php
									}
							?>
						</ul>
						<?php
							}
						?>
					</li>
					<?php
							}
						}
					?>
					<li>
						<a href="<?= $_DOMAIN ?>category/photos">Hình ảnh</a>
					</li>
					<li>
						<a href="<?= $_DOMAIN ?>category/contact">Góp ý</a>
					</li>
				</ul>
				<div class="search pull-right col-md-3">
					<form action="<?= $_DOMAIN ?>" method="GET">
						<div class="input-group">
					      	<input type="text" class="form-control" name="s" placeholder="Tìm kiếm..." aria-label="Tìm kiếm...">
					      	<span class="input-group-btn">
					        	<button class="btn btn-default" type="button"><span class="fa fa-search"></span></button>
					      	</span>
					    </div>
				    </form>
				</div>
			</nav>
			<!-- end nav -->
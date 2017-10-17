<?php
	// Lấy đếm dữ liệu
	$sql_count_img = "SELECT id_img FROM images";
	$countImg = $db->num_rows($sql_count_img);
	
	// Lấy tham số trang
	if (isset($_GET['p'])){
		$page = trim(htmlspecialchars(addslashes($_GET['p'])));

		if (preg_match('/\d/', $page)) {
			$page = $page;
		} else {
			$page = 1;
		}
	} else {
		$page = 1;
	}

	$limit = 12;
	$totalPage = ceil($countImg / $limit);

	// Validate tham số page
	if ($page > $totalPage) {
		$page = $totalPage;
	} else if($page < 1) {
		$page = 1;
	}

	$start = ($page - 1) * $limit;

	$sql_data_img = "SELECT * FROM images ORDER BY id_img DESC LIMIT $start, $limit";

?>
<articel class="photos">
	<h2 class="text-center">Hình ảnh</h2>
	<ul class="gallery">
		<?php
			foreach ($db->fetch_assoc($sql_data_img, 0) as $data_img) {
		?>
		<li>
			<a data-lightbox="vacation" href="<?= $_DOMAIN . $data_img['url'] ?>">
				<img src="<?= $_DOMAIN . $data_img['url'] ?>" alt="">
			</a>
		</li>
		<?php
			}
		?>
	</ul>
	<div class="btn-toolbar" role="toolbar">
		<div class="btn-group">
			
		<?php
			if ($page > 1 && $totalPage > 1) {
				echo '
					<a href="'.$_DOMAIN.'category/photos/'.($page - 1) .'" class="btn btn-default">
						<span class="glyphicon glyphicon-chevron-left"></span>
					</a>
				';
			} else {
				echo '
					<a href="'.$_DOMAIN.'category/photos/'.($page - 1) .'" class="btn btn-default" disabled>
						<span class="glyphicon glyphicon-chevron-left"></span>
					</a>
				';
			}
			for($i = 1; $i <= $totalPage; $i++){
				if ($i == $page) {
					echo '<a class="btn btn-primary">'.$i.'</a>';
				} else {
					echo '
						<a href="'.$_DOMAIN.'category/photos/'.$i.'" class="btn btn-default">'.$i.'</a>
					';
				}
			}
			if ($page < $totalPage && $totalPage > 1) {
				echo '
					<a href="'.$_DOMAIN.'category/photos/'.($page + 1) .'" class="btn btn-default">
						<span class="glyphicon glyphicon-chevron-right"></span>
					</a>
				';
			} else {
				echo '
					<a href="'.$_DOMAIN.'category/photos/'.($page + 1) .'" class="btn btn-default" disabled>
						<span class="glyphicon glyphicon-chevron-right"></span>
					</a>
				';
			}
		?>
		</div>
	</div>
</articel>
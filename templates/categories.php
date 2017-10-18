<?php
	// Sidebar left
	require_once 'templates/sidebar-left.php';
?>

<!--====================Main=====================-->
<article class="content col-md-6 block">

	<?php
		// Nhận giá trị slug của chuyên mục
		$sc = trim(htmlentities(addslashes($_GET['sc'])));

		// Lấy id của chuyên mục
		$sql_get_id_cate = "SELECT * FROM categories WHERE url = '$sc'";

		if ($db->num_rows($sql_get_id_cate)) {

			$get_data_cate = $db->fetch_assoc($sql_get_id_cate, 1);
			$id_cate = $get_data_cate['id_cate'];
			$parent_cate = $get_data_cate['parent_id'];

			if ($parent_cate == 0) {

				$sql_cate_news = "SELECT * FROM categories WHERE parent_id = $id_cate";
				echo '
					<ol class="breadcrumb">
					  	<li class="breadcrumb-item active">'.$get_data_cate["label"] . '</li>
					</ol>
				';	
				foreach ($db->fetch_assoc($sql_cate_news, 0) as $data_cate) {
		?>
		<div class="panel panel-default news">
			<div class="panel-heading">
				<a href="<?= $_DOMAIN ?>category/<?= $data_cate['url'] ?>"><span class="panel-title"><?= $data_cate['label'] ?></span></a>
			</div>
			<div class="panel-body">
				<?php
					$sql_post_news = "SELECT * FROM posts WHERE cate_2_id = $data_cate[id_cate] AND status = 1 ORDER BY id_post LIMIT 0, 3";
					foreach ($db->fetch_assoc($sql_post_news, 0) as $data_post) {
				?>
				<div class="row">
					<div class="col-md-4">
						<div class="img-edit">
							<img src="<?= $_DOMAIN.$data_post['url_thumb'] ?>" class="img-thumbnail">
						</div>
					</div>
					<div class="col-md-8 title-post">
						<h4><a href="<?= $_DOMAIN . $data_post['slug'] . '-' . $data_post['id_post'] ?>.html"><?= $data_post['title'] ?></a></h4>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<?php 
				}
			} else {
				$sql_cate_parent = "SELECT * FROM categories WHERE id_cate = $parent_cate";
				$cate_1_post = $db->fetch_assoc($sql_cate_parent, 1);

				$sql_cate_news = "SELECT * FROM categories WHERE id_cate = $id_cate";
				$data_cate = $db->fetch_assoc($sql_cate_news, 1);
		?>
		<ol class="breadcrumb">
		  	<li class="breadcrumb-item"><a href="<?= $_DOMAIN .'category/'. $cate_1_post['url'] ?>"><?= $cate_1_post['label'] ?></a></li>
		  	<li class="breadcrumb-item active"><?= $data_cate['label'] ?></li>
		</ol>
		<div class="panel panel-default news">
			<div class="panel-heading">
				<a href="<?= $_DOMAIN ?>category/<?= $data_cate['url'] ?>"><span class="panel-title"><?= $data_cate['label'] ?></span></a>
			</div>
			<div class="panel-body">
				<?php
					$sql_count_post = "SELECT id_post FROM posts WHERE cate_2_id = $data_cate[id_cate] AND status = 1";
					$countPost = $db->num_rows($sql_count_post);
					
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

					$limit = 10;
					$totalPage = ceil($countPost / $limit);

					// Validate tham số page
					if ($page > $totalPage) {
						$page = $totalPage;
					} else if($page < 1) {
						$page = 1;
					}

					$start = ($page - 1) * $limit;

					$sql_post_news = "SELECT * FROM posts WHERE cate_2_id = $data_cate[id_cate] AND status = 1 ORDER BY id_post DESC LIMIT $start, $limit";
					foreach ($db->fetch_assoc($sql_post_news, 0) as $data_post) {
				?>
				<div class="row">
					<div class="col-md-4">
						<div class="img-edit">
							<img src="<?= $_DOMAIN.$data_post['url_thumb'] ?>" class="img-thumbnail">
						</div>
					</div>
					<div class="col-md-8 title-post">
						<h4><a href="<?= $_DOMAIN . $data_post['slug'] . '-' . $data_post['id_post'] ?>.html"><?= $data_post['title'] ?></a></h4>
					</div>
				</div>
				<?php } ?>
				<div class="btn-toolbar" role="toolbar">
					<div class="btn-group">
						
					<?php
						if ($page > 1 && $totalPage > 1) {
							echo '
								<a href="'.$_DOMAIN.'category/'.$data_cate['url'].'/'.($page - 1) .'" class="btn btn-default">
									<span class="glyphicon glyphicon-chevron-left"></span>
								</a>
							';
						} else {
							echo '
								<a href="'.$_DOMAIN.'category/'.$data_cate['url'].'/'.($page - 1) .'" class="btn btn-default" disabled>
									<span class="glyphicon glyphicon-chevron-left"></span>
								</a>
							';
						}
						for($i = 1; $i <= $totalPage; $i++){
							if ($i == $page) {
								echo '<a class="btn btn-primary">'.$i.'</a>';
							} else {
								echo '
									<a href="'.$_DOMAIN.'category/'.$data_cate['url'].'/'.$i.'" class="btn btn-default">'.$i.'</a>
								';
							}
						}
						if ($page < $totalPage && $totalPage > 1) {
							echo '
								<a href="'.$_DOMAIN.'category/'.$data_cate['url'].'/'.($page + 1) .'" class="btn btn-default">
									<span class="glyphicon glyphicon-chevron-right"></span>
								</a>
							';
						} else {
							echo '
								<a href="'.$_DOMAIN.'category/'.$data_cate['url'].'/'.($page + 1) .'" class="btn btn-default" disabled>
									<span class="glyphicon glyphicon-chevron-right"></span>
								</a>
							';
						}
					?>
					</div>
				</div>
			</div>
		</div>
		<?php
			}
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
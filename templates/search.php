<?php
	// Sidebar left
	require_once 'templates/sidebar-left.php';
?>

<!--====================Main=====================-->
<article class="content col-md-6 block">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				<span class="fa fa-graduation-cap"></span> Tìm kiếm
			</h3>
		</div>
		<div class="panel-body">
		<?php
		// Lấy tham số từ khóa tìm kiếm
		$s = trim(htmlspecialchars(addslashes($_GET['s'])));

		if ($s) {

			$sql_get_news = "SELECT * FROM posts WHERE status = '1' AND title LIKE '%$s%' OR keywords LIKE '%$s%' OR descr LIKE '%$s%' ORDER BY id_post DESC LIMIT 0, 10";
			if ($db->num_rows($sql_get_news)) {
				foreach ($db->fetch_assoc($sql_get_news, 0) as $data_post) {
					echo '
						<div class="row">
							<div class="col-md-4">
								<div class="img-edit">
									<img src="'.$_DOMAIN.$data_post['url_thumb'].'" class="img-thumbnail">
								</div>
							</div>
							<div class="col-md-8 title-post">
								<h4><a href="'.$_DOMAIN . $data_post['slug'] . '-' . $data_post['id_post'].'.html">'.$data_post['title'].'</a></h4>
							</div>
						</div>
					';	
				}

            } else {
                echo '<div class="well well-lg">Không tìm thấy kết quả nào.</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Vui lòng nhập từ khóa tìm kiếm.</div>';
        }
		?>
		</div>
	</div>
</article>

<?php
	// Sidebar right
	require_once 'templates/sidebar-right.php';
?>
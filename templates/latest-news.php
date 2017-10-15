<?php
	// Sidebar left
	require_once 'templates/sidebar-left.php';
?>
<!--====================Main=====================-->
<article class="content col-md-6 block">
	<div class="panel panel-primary slidebar">
		<div class="panel-heading">
			<h3 class="panel-title">
				<span class="fa fa-graduation-cap"></span> Thư viện hình ảnh
			</h3>
		</div>
		<div class="panel-body">
			<div id="imageCarousel" class="carousel slide" data-interval="2000">
				<ol class="carousel-indicators">
					<li data-target="#imageCarousel" data-slide-to="0" class="active"></li>
					<li data-target="#imageCarousel" data-slide-to="1"></li>
					<li data-target="#imageCarousel" data-slide-to="2"></li>
					<li data-target="#imageCarousel" data-slide-to="3"></li>
				</ol>
				<div class="carousel-inner">
					<div class="item active">
						<a href="#">
							<img src="front-end/images/01.jpg" class="img-responsive">
							<div class="carousel-caption">
								<h4>Giới thiệu trường</h4>
							</div>
						</a>
					</div>
					<div class="item">
						<a href="#">
							<img src="front-end/images/02.jpg" class="img-responsive">
							<div class="carousel-caption">
								<h4>Ban giám hiệu nhà trường</h4>
							</div>
						</a>
					</div>
					<div class="item">
						<a href="#">
							<img src="front-end/images/03.jpg" class="img-responsive">
							<div class="carousel-caption">
								<h4>Giới thiệu trường</h4>
							</div>
						</a>
					</div>
					<div class="item">
						<a href="#">
							<img src="front-end/images/04.jpg" class="img-responsive">
							<div class="carousel-caption">
								<h4>Ban giám hiệu trường Cao đẳng nghề Nha Trang</h4>
							</div>
						</a>
					</div>
				</div>
				<a href="#imageCarousel" class="carousel-control left" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
				</a>
				<a href="#imageCarousel" class="carousel-control right" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
				</a>
			</div>
		</div>
	</div>
	<!-- slider -->

	<?php 
		$sql_cate_news = "SELECT * FROM categories WHERE parent_id = 3";
		foreach ($db->fetch_assoc($sql_cate_news, 0) as $data_cate) {
	?>
	<div class="panel panel-default news">
		<div class="panel-heading">
			<span class="panel-title"><?= $data_cate['label'] ?></span>
		</div>
		<div class="panel-body">
			<?php
				$sql_post_news = "SELECT * FROM posts WHERE cate_2_id = $data_cate[id_cate]";
				$data_post_first = $db->fetch_assoc($sql_post_news, 1);
			?>
			<div class="row">
				<div class="col-md-4">
					<div class="img-edit">
						<img src="<?= $data_post_first['url_thumb'] ?>" class="img-thumbnail">
					</div>
				</div>
				<div class="col-md-8 title-post">
					<h4><a href="<?= $_DOMAIN.$data_post_first['title'] ?>"><?= $data_post_first['title'] ?></a></h4>
				</div>
				<div class="col-md-12 desc-post">
					<p><?= $data_post_first['descr'] ?></p>
				</div>
			</div>
			
			<div class="list-group">
				<?php
					foreach ($db->fetch_assoc($sql_post_news, 0) as $data_post) {
						if ($data_post['id_post'] == $data_post_first['id_post']) {
							continue;
						}
				?>
				<a class="list-group-item" href="<?= $_DOMAIN.$data_post['slug'] ?>"><span class="fa fa-caret-right"></span>&nbsp; <?= $data_post['title'] ?></a>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php } ?>
</article>

<?php
	// Sidebar right
	require_once 'templates/sidebar-right.php';
?>
<!--====================Aside-right=====================-->
<article class="aside-right col-md-3 block">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><span class="fa fa-graduation-cap"></span> Tiêu điểm</h3>
		</div>
		<div class="panel-body">
			<ul>
				<?php
					$sql_hot_post = "SELECT * FROM posts WHERE cate_1_id = 3 ORDER BY id_post ASC LIMIT 0, 3";
					foreach ($db->fetch_assoc($sql_hot_post, 0) as $data_post) {
				?>
				<li>
					<a href="<?= $_DOMAIN . $data_post['slug'] ?>"><img src="<?= $_DOMAIN . $data_post['url_thumb'] ?>"></a>
					<a href="<?= $_DOMAIN . $data_post['slug'] ?>"><?= $data_post['title'] ?></a>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="panel panel-primary application">
		<div class="panel-heading">
			<h3 class="panel-title"><span class="fa fa-graduation-cap"></span> Cổng thông tin điện tử</h3>
		</div>
		<div class="panel-body">
			<a href="<?= $_DOMAIN ?>"><img src="<?= $_IMG ?>cong-thong-tin1-300x225_1.png" class="img-full"></a>
			<a href="<?= $_DOMAIN ?>"><img src="<?= $_IMG ?>tkb2_2.jpg" class="img-full"></a>
			<a href="<?= $_DOMAIN ?>"><img src="<?= $_IMG ?>thu_1.png" class="img-full"></a>
		</div>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><span class="fa fa-graduation-cap"></span> Thư viện</h3>
		</div>
		<div class="panel-body">
			<a href="<?= $_DOMAIN ?>"><img src="<?= $_IMG ?>tv.jpg" class="img-full"></a>
		</div>
	</div>		
</article>
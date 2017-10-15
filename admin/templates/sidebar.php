<div class="col-md-3 sidebar">
	<ul class="list-group">
		<li class="list-group-item">
			<div class="media">
				<div class="pull-left">
					<img class="media-object" src="
					<?php
						// URL ảnh đại diện
						if ($data_user['url_avatar'] == '') {
							echo $_DOMAIN . 'images/profile.png';
						} else {
							echo str_replace('admin/', '', $_DOMAIN).$data_user['url_avatar'];
						}
					?>
					" alt="Ảnh đại diện của <?= $data_user['display_name']; ?>" width="130" height="150">
				</div>
				<div class="media-body">
					<h4 class="media-heading"><?= $data_user['display_name']; ?></h4>
					<?php
						if ($data_user['position'] == '1') {
							echo '<span class="label label-success">Quản trị viên</span>';
						} else {
							echo '<span class="label label-warning">Giáo viên</span>';
						}
					?>
				</div>
			</div>
		</li>
		<a class="list-group-item active" href="<?= $_DOMAIN?>">
			<span class="glyphicon glyphicon-dashboard"></span> Bảng điều khiển
		</a>
		<a class="list-group-item" href="<?= $_DOMAIN;?>profile">
			<span class="glyphicon glyphicon-user"></span> Hồ sơ cá nhân
		</a>
		<a class="list-group-item" href="<?= $_DOMAIN;?>posts">
			<span class="glyphicon glyphicon-edit"></span> Bài viết
		</a>
		<a class="list-group-item" href="<?= $_DOMAIN;?>photos">
			<span class="glyphicon glyphicon-picture"></span> Hình ảnh
		</a>

		<?php
			// Nếu là admin sẽ hiển thị chuyên mục, tài khoản, cài đặt
			if ($data_user['position'] == '1') {
		?>
		<a class="list-group-item" href="<?= $_DOMAIN;?>categories">
			<span class="glyphicon glyphicon-tag"></span> Chuyên mục
		</a>
		<a class="list-group-item" href="<?= $_DOMAIN;?>accounts">
			<span class="glyphicon glyphicon-lock"></span> Tài khoản
		</a>
		<a class="list-group-item" href="<?= $_DOMAIN;?>setting">
			<span class="glyphicon glyphicon-cog"></span> Cài đặt chung
		</a>

		<?php
			}
		?>
		<a class="list-group-item" href="<?= $_DOMAIN;?>logout.php">
			<span class="glyphicon glyphicon-off"></span> Thoát
		</a>
	</ul>
</div>
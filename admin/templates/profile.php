<?php
	// Nếu đăng nhập
	if ($user) {
		// URL ảnh đại diện tài khoản
		if ($data_user['url_avatar'] == '') {
			$data_user['url_avatar'] = $_DOMAIN.'images/profile.png';
		} else {
			$data_user['url_avatar'] = str_replace('admin/', '',$_DOMAIN).$data_user['url_avatar'];
		}

		// form update ảnh đại diện
		echo '
			<h3>Hồ sơ cá nhân</h3>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">Update ảnh đại diện</h2>
				</div>
				<div class="panel-body">
					<form method="POST" enctype="multipart/form-data" onsubmit="return false;" action="'.$_DOMAIN.'profile.php" id="formUpAvt">
						<div class="form-group box-current-img">
							<p><strong>Ảnh hiện tại</strong></p>
							<img src="'.$data_user['url_avatar'].'" alt="Ảnh đại diện của '.$data_user['display_name'].'" width="80" height="80">
						</div>
						<div class="alert alert-info">Vui lòng chọn file ảnh có đuôi .jpg, .png, .gif và có dung lượng dưới 5MB.</div>
						<div class="form-group">
							<label>Chọn hình ảnh</label>
							<input type="file" class="form-control" id="img_avt" name="img_avt" onchange="preUpAvt();">
						</div>
						<div class="form-group box-pre-img hidden">
							<p><strong>Ảnh xem trước</strong></p>
						</div>
						<div class="form-group box-progress-bar hidden">
							<div class="progress-bar" role="progressbar"></div>
						</div>
						<div class="form-group">
	                        <button class="btn btn-primary pull-left" type="submit">Upload</button>
	                        <a class="btn btn-danger pull-right" id="del_avt">
	                        	<span class="glyphicon glyphicon-trash"></span> Xoá
	                        </a>
	                    </div>
	                    <div class="clearfix"></div><br>
	                    <div class="alert alert-danger hidden"></div>
					</form>
				</div>
			</div>
		';

		// Form cập nhật các thông tin còn lại
		echo '
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">Cập nhật thông tin</h2>
				</div>
				<div class="panel-body">
					<form method="POST" onsubmit="return false;" id="formUpdateInfo">
						<div class="form-group">
							<label>Tên hiển thị</label>
							<input type="text" id="dn_update" value="'.$data_user['display_name'].'" class="form-control">
						</div>
						<div class="form-group">
							<label>Email *</label>
							<input type="text" id="email_update" value="'.$data_user['email'].'" class="form-control">
						</div>
						<div class="form-group">
							<label>Số điện thoại</label>
							<input type="text" id="phone_update" value="'.$data_user['phone'].'" class="form-control">
						</div>
						<div class="form-group">
							<button class="btn btn-primary" type="submit">Lưu thay đổi</button>
						</div>
						<div class="alert alert-danger hidden"></div>
					</form>
				</div>
			</div>
		';

		// Form đổi mật khẩu
		echo '
			<div class="panel panel-default">
				<div class="panel-heading">	
					<h2 class="panel-title">Đổi mật khẩu</h2>
				</div>
				<div class="panel-body">
					<form method="POST" onsubmit="return false;" id="formChangePw">
						<div class="form-group">
							<label>Mật khẩu cũ</label>
							<input type="password" id="old_pw_change" class="form-control">
						</div>
						<div class="form-group">
							<label>Mật khẩu mới</label>
							<input type="password" id="new_pw_change" class="form-control">
						</div>
						<div class="form-group">
							<label>Nhập lại mật khẩu mới</label>
							<input type="password" id="re_new_pw_change" class="form-control">
						</div>
						<div class="form-group">
							<button class="btn btn-primary" type="submit">Lưu thay đổi</button>
						</div>
						<div class="alert alert-danger hidden"></div>
					</form>
				</div>
			</div>
		';
	} else {
		new Redirect($_DOMAIN);
	}

?>
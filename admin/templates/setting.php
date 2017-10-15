<?php
	// Nếu đăng nhập
if ($user) {
	// Nếu tài khoản là tác giả
	if ($data_user['position'] == '0') {
		echo '<div class="alert alert-danger">Bạn không có đủ quyền để vào trang này.</div>';
	}
	// Ngược lại tài khoản là admin
	else if ($data_user['position'] == '1') {
		echo '<h3>Cài đặt chung</h3>';

		// Trạng thái Website
		$sql_get_stt_web = "SELECT * FROM website";
		if ($db->num_rows($sql_get_stt_web)) {

			// Mở hoặc Đóng hoạt động của Website
			echo '
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Trạng thái hoạt động</h3>
					</div>
					<div class="panel-body">
						<form method="POST" onsubmit="return false;" id="formStatusWeb">
			';
			$data_web = $db->fetch_assoc($sql_get_stt_web, 1);

			if ($data_web['status'] == '0') {
				echo '
					<div class="radio">
						<label><input type="radio" value="1" name="stt_web"> Mở</label>
					</div>
					<div class="radio">
						<label><input type="radio" value="0" name="stt_web" checked> Đóng</label>
					</div>
				';
			} else if ($data_web['status'] == '1') {
				echo '
					<div class="radio">
						<label><input type="radio" value="1" name="stt_web" checked> Mở</label>
					</div>
					<div class="radio">
						<label><input type="radio" value="0" name="stt_web"> Đóng</label>
					</div>
				';
			}

			echo '
							<button type="submit" class="btn btn-primary">Lưu</button>
							<div class="alert alert-danger hidden"></div>
						</form>
					</div>
				</div>
			';

			// Chỉnh sửa thông tin Website
			$sql_get_info_web = "SELECT title, descr, keywords FROM website";
			if ($db->num_rows($sql_get_info_web)) {
				$data_web = $db->fetch_assoc($sql_get_info_web, 1);
			}

			echo '
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Chỉnh sửa thông tin</h3>
					</div>
					<div class="panel-body">
						<form method="POST" onsubmit="return false;" id="formInfoWeb">
							<div class="form-group">
								<label>Tiêu đề Website</label>
								<input type="text" class="form-control" value="'.$data_web['title'].'" id="title_web">
							</div>
							<div class="form-group">
								<label>Mô tả Website</label>
								<textarea class="form-control" id="descr_web">'.$data_web['descr'].'</textarea>
							</div>
							<div class="form-group">
								<label>Từ khóa Website</label>
								<input type="text" class="form-control" value="'.$data_web['keywords'].'" id="keywords_web">
							</div>
							<button class="btn btn-primary" type="submit">Lưu</button><br><br>
	                		<div class="alert alert-danger hidden"></div>
						</form>
					</div>
				</div>
			';
		
		} else {
			echo '<div class="alert alert-wraning">Website chưa có thông tin.</div>';
		}

		
	}
} else {
	new Redirect($_DOMAIN);
}
?>
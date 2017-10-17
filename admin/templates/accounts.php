<?php
	// Nếu đăng nhập
	if ($user) {
		// Nếu tài khoản là tác giả
		if ($data_user['position'] == 0) {
			echo '<div class="alert alert-danger">Bạn không có quyền vào trang này.</div>';
		}
		// Ngược lại nếu là admin
		else if ($data_user['position'] == 1) {
			echo '<h3>Tài khoản</h3>';

			// Lấy tham số ac
			if (isset($_GET['ac'])) {
				$ac = trim(addslashes(htmlspecialchars($_GET['ac'])));
			} else {
				$ac = '';
			}

			// Lấy tham số id
			if (isset($_GET['id'])) {
				$id = trim(addslashes(htmlspecialchars($_GET['id'])));
			} else {
				$id = '';
			}

			// Nếu có tham số ac
			if ($ac != '') {
				// Trang thêm tài khoản
				if ($ac == 'add') {
					// Dãy nút của trang thêm tài khoản
					echo '
						<a href="'.$_DOMAIN.'accounts" class="btn btn-default">
							<span class="glyphicon glyphicon-arrow-left"></span> Trở về
						</a>
					';

					// Content thêm tài khoản
					echo '
						<p class="form-add-acc">
							<form method="POST" onsubmit="return false;" id="formAddAcc">
								<div class="form-group">
									<label>Tên đăng nhập</label>
									<input type="text" id="un_add_acc" class="form-control title">
								</div>
								<div class="form-group">
									<label>Mật khẩu</label>
									<input type="password" id="pw_add_acc" class="form-control title">
								</div>
								<div class="form-group">
									<label>Nhập lại mật khẩu</label>
									<input type="password" id="repw_add_acc" class="form-control title">
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Thêm</button>
								</div>
								<div class="alert alert-danger hidden"></div>
							</form>
						</p>
					';
				}

			// Ngược lại không có tham số ac
			// Trang danh sách tài khoản
			} else {
				// Dãy nút của danh sách tài khoản
				echo '
					<a href="'.$_DOMAIN.'accounts/add" class="btn btn-default">
						<span class="glyphicon glyphicon-plus"></span> Thêm
					</a>
					<a href="'.$_DOMAIN.'accounts" class="btn btn-default">
						<span class="glyphicon glyphicon-repeat"></span> Reload
					</a>
					<a id="lock_acc_list" class="btn btn-warning">
						<span class="glyphicon glyphicon-lock"></span> Khóa
					</a>
					<a id="unlock_acc_list" class="btn btn-success">
						<span class="glyphicon glyphicon-lock"></span> Mở khóa
					</a>
					<a id="del_acc_list" class="btn btn-danger">
						<span class="glyphicon glyphicon-trash"></span> Xóa
					</a>
				';

				// Content danh sách tài khoản
				$sql_get_list_acc = "SELECT * FROM accounts WHERE position = '0' ORDER BY id_acc DESC";
				// Nếu có tài khoản
				if ($db->num_rows($sql_get_list_acc)) {
					echo '
						<br><br>
						<div class="table-responsive">
							<table class="table table-striped list" id="list_acc">
								<tr>
									<th class="text-center"><input type="checkbox"></th>
									<th class="text-center">ID</th>
									<th class="text-center">Tên đăng nhập</th>
									<th class="text-center">Trạng thái</th>
									<th class="text-center">Tools</th>
								</tr>
					';

					// in danh sách tài khoản
					foreach ($db->fetch_assoc($sql_get_list_acc, 0) as $key => $data_acc) {
						// Trạng thái tài khoản
						if ($data_acc['status'] == '1') {
							$stt_acc = '<label class="label label-success">Hoạt động</label>';
						} else if($data_acc['status'] == '0') {
							$stt_acc = '<label class="label label-warning">Khóa</label>';
						}
						echo '
							<tr>
								<td class="text-center"><input type="checkbox" name="id_acc[]" value="'.$data_acc['id_acc'].'"></td>
								<td class="text-center">'.$data_acc['id_acc'].'</td>
								<td class="text-center">'.$data_acc['username'].'</td>
								<td class="text-center">'.$stt_acc.'</td>
								<td class="text-center">
									<a data-id="'.$data_acc['id_acc'].'" class="btn btn-warning btn-sm lock-acc-list">
										<span class="glyphicon glyphicon-lock"></span>
									</a>
									<a data-id="'.$data_acc['id_acc'].'" class="btn btn-success btn-sm unlock-acc-list">
										<span class="glyphicon glyphicon-lock"></span>
									</a>
									<a data-id="'.$data_acc['id_acc'].'" class="btn btn-danger btn-sm del-acc-list">
										<span class="glyphicon glyphicon-trash"></span>
									</a>
								</td>
							</tr>
						';
					}

					echo '
							</table>
						</div>
					';	
				// Nếu không có tài khoản nào
				} else {
					echo '<br><br><div class="alert alert-info">Chưa có tài khoản nào.</div>';
				}
			}
		}
	} else {
		new Redirect($_DOMAIN);
	}
?>
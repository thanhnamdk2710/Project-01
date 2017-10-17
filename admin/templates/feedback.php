<?php
	// Nếu đăng nhập
	if ($user) {
		// Nếu tài khoản là tác giả
		if ($data_user['position'] == 0) {
			echo '<div class="alert alert-danger">Bạn không có quyền vào trang này.</div>';
		}
		// Ngược lại nếu là admin
		else if ($data_user['position'] == 1) {
			echo '<h3>Góp ý</h3>';

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
				if ($ac == 'view') {

					$sql_check_id_feed = "SELECT * FROM feedback WHERE id_feed = '$id'";
					if ($db->num_rows($sql_check_id_feed)) {
						$data_feed = $db->fetch_assoc($sql_check_id_feed, 1);

						// Dãy nút của trang thêm tài khoản
						echo '
							<a href="'.$_DOMAIN.'feedback" class="btn btn-default">
								<span class="glyphicon glyphicon-arrow-left"></span> Trở về
							</a>
							<a data-id="'.$data_feed['id_feed'].'" class="btn btn-danger btn-sm del-feed-list">
								<span class="glyphicon glyphicon-trash"></span> Xóa
							</a>
						';

						// Content xem feed
						echo ' 

							<br>
							<br>
							<div class="tabel-resposive feedback">
								<table class="table-striped table-bordered">
									<tr>
										<th class="col-md-2">Tên</th>
										<td class="col-md-10">'.$data_feed['name'].'</td>
									</tr>
									<tr>
										<th class="col-md-2">Email</th>
										<td class="col-md-10">'.$data_feed['email'].'</td>
									</tr>
									<tr>
										<th class="col-md-2">Điện thoại</th>
										<td class="col-md-10">'.$data_feed['phone'].'</td>
									</tr>
									<tr>
										<th class="col-md-2">Ngày gửi</th>
										<td class="col-md-10">'.$data_feed['date_sent'].'</td>
									</tr>
									<tr>
										<th class="col-md-2">Nội dung</th>
										<td class="col-md-10">'.$data_feed['body'].'</td>
									</tr>
								</table>
								<a data-id="'.$data_feed['id_feed'].'" class="btn btn-success btn-sm view-feed-list">
									<span class="fa fa-eye"></span> Đã xem
								</a>
							</div>
						';
					} else {
						echo "<div class='alert alert-danger'>ID bài viết đã bị xóa hoặc không tồn tại.</div>";
					}

				}

			// Ngược lại không có tham số ac
			// Trang danh sách tài khoản
			} else {
				// Dãy nút của danh sách tài khoản
				echo '
					<a href="'.$_DOMAIN.'feedback" class="btn btn-default">
						<span class="glyphicon glyphicon-repeat"></span> Reload
					</a>
					<a id="view_feed_list" class="btn btn-success">
						<span class="fa fa-eye"></span> Đã xem
					</a>
					<a id="del_feed_list" class="btn btn-danger">
						<span class="glyphicon glyphicon-trash"></span> Xóa
					</a>
				';

				// Content danh sách tài khoản
				$sql_get_list_feed = "SELECT * FROM feedback ORDER BY id_feed DESC";
				// Nếu có góp ý
				if ($db->num_rows($sql_get_list_feed)) {
					echo '
						<br><br>
						<div class="table-responsive">
							<table class="table table-striped list" id="list_feed">
								<tr>
									<th class="text-center"><input type="checkbox"></th>
									<th class="text-center">ID</th>
									<th class="text-center">Tên người gửi</th>
									<th class="text-center">Email</th>
									<th class="text-center">Phone</th>
									<th class="text-center">Trạng thái</th>
									<th class="text-center">Ngày</th>
									<th class="text-center">Tools</th>
								</tr>
					';

					// in danh sách góp ý
					foreach ($db->fetch_assoc($sql_get_list_feed, 0) as $key => $data_feed) {
						// Trạng thái góp ý
						if ($data_feed['status'] == '0') {
							$stt_feed = '<label class="label label-warning">Chưa xem</label>';
						} else if($data_feed['status'] == '1') {
							$stt_feed = '<label class="label label-success">Đã xem</label>';
						}
						echo '
							<tr>
								<td class="text-center"><input type="checkbox" name="id_feed[]" value="'.$data_feed['id_feed'].'"></td>
								<td class="text-center">'.$data_feed['id_feed'].'</td>
								<td><a href="' . $_DOMAIN . 'feedback/view/' . $data_feed['id_feed'] .'">'.$data_feed['name'].'</a></td>
								<td>'.$data_feed['email'].'</td>
								<td class="text-right">'.$data_feed['phone'].'</td>
								<td class="text-center">'.$stt_feed.'</td>
								<td class="text-center">'.$data_feed['date_sent'].'</td>
								<td class="text-center">
									<a data-id="'.$data_feed['id_feed'].'" class="btn btn-success btn-sm view-feed-list">
										<span class="fa fa-eye"></span>
									</a>
									<a data-id="'.$data_feed['id_feed'].'" class="btn btn-danger btn-sm del-feed-list">
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
					echo '<br><br><div class="alert alert-info">Chưa có góp ý nào.</div>';
				}
			}
		}
	} else {
		new Redirect($_DOMAIN);
	}
?>
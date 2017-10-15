<?php
	// Nếu đăng nhập
	if ($user) {
		echo '<h3>Hình ảnh</h3>';
		// Lấy tham số ac
		if(isset($_GET['ac'])){
			$ac = trim(addslashes(htmlspecialchars($_GET['ac'])));
		} else {
			$ac = '';
		}

		// Nếu có tham số ac
		if ($ac != '') {
			// Trang upload hình ảnh
			if ($ac == 'add') {
				// Dãy nút của Upload hình ảnh
				echo '
					<a href="'.$_DOMAIN.'photos" class="btn btn-default">
						<span class="glyphicon glyphicon-arrow-left"></span> Trở về
					</a>
				';

				// Content Upload hình ảnh
				echo '
					<p class="form-up-img">
						<div class="alert alert-info">Mỗi lần upload tối đa 20 file ảnh. Mỗi file có dung lượng không vượt quá 5MB và có đuôi định dạng là .jpg, .png, .gif,... </div>
						<form action="'.$_DOMAIN.'photos.php" method="POST" enctype="multipart/form-data" onsubmit="return false;" id="formUpImg">
							<div class="form-group">
				                <label>Chọn hình ảnh</label>
				                <input type="file" class="form-control" accept="image/*" name="img_up[]" multiple="true" id="img_up" onchange="preUpImg();">
				            </div>
							<div class="form-group box-pre-img hidden">
				                <p><strong>Ảnh xem trước</strong></p>
				            </div>
				            <div class="form-group hidden box-progress-bar">
				                <div class="progress">
				                    <div class="progress-bar" role="progressbar"></div>
				                </div>
				            </div>
				            <div class="form-group">
				                <button type="submit" class="btn btn-primary">Upload</button>
				                <button class="btn btn-default" type="reset">Chọn lại</button>
				            </div>
				            <div class="alert alert-danger hidden"></div>
						</form>
					</p>
				';
			}
		}
		// Ngược lại không có tham số ac
		// Trang danh sách hình ảnh
		else {
			// Dãy nút trang danh sách
			echo '
				<a href="'.$_DOMAIN.'photos/add" class="btn btn-default">
					<span class="glyphicon glyphicon-plus"></span> Thêm
				</a>
				<a href="'.$_DOMAIN.'photos" class="btn btn-default">
					<span class="glyphicon glyphicon-repeat"></span> Reload
				</a>
				<a class="btn btn-danger" id="del_img_list">
					<span class="glyphicon glyphicon-trash"></span> Xóa
				</a>
			';

			// Content danh sách hình ảnh
			if ($data_user['position'] == '1') {
				$sql_get_img = "SELECT * FROM images ORDER BY id_img DESC";

			// Nếu là tác giả thì chỉ lấy những bài viết thuộc sở hữu
			} else {
				$sql_get_img = "SELECT * FROM images WHERE uploader_id = '$data_user[id_acc]' ORDER BY id_img DESC";
			}

			// Nếu có hình ảnh
			if ($db->num_rows($sql_get_img)) {
				// Lấy số trang
				if (isset($_GET['page'])) {
					$current_page = trim(htmlspecialchars(addslashes($_GET['page'])));
				} else {
					$current_page = 0;
				}

				$limit = 8; //Giới hạn số bài viết trong 1 trang
				$total_page = ceil($db->num_rows($sql_get_img) / $limit); //Tổng trang
				$start = ($current_page - 1) * $limit; // Vị trí bắt đầu lấy trang

				// Nếu số trang hiện tại lớn hơn tổng số trang
				if ($current_page > $total_page) {
					new Redirect($_DOMAIN . 'photos&page=' . $total_page); // Trang tối đa
				// Nếu số trang hiện tại bé hơn 1
				} else if ($current_page < 1) {
					new Redirect($_DOMAIN . 'photos&page=1'); // Trang đầu tiên
				}

				// Nếu là admin thì lấy toàn bộ hình ảnh
				if ($data_user['position'] == '1') {
					$sql_get_list_images_limit = "SELECT * FROM images ORDER BY id_img DESC LIMIT $start, $limit";
				// Nếu là tác giả thì chỉ lấy những hình ảnh thuộc sở hữu
				} else {
					$sql_get_list_images_limit = "SELECT * FROM images WHERE id_img = '$data_user[id_acc]' ORDER BY id_img DESC LIMIT $start, $limit";
				}
			    echo '
			        <div class="row list" id="list_img">
			            <div class="col-md-12">
			                <div class="checkbox"><label><input type="checkbox"> Chọn/Bỏ chọn tất cả</label></div>
			            </div>
			    ';
			    foreach($db->fetch_assoc($sql_get_list_images_limit, 0) as $key => $data_img) {
			        // Trạng thái ảnh
			        if (file_exists('../'.$data_img['url'])) {
			            $status_img = '<label class="label label-success">Tồn tại</label>';
			        } else {
			            $status_img = '<label class="label label-danger">Hỏng</label>';
			        }

			        // Dung lượng ảnh
			        if ($data_img['size'] < 1024) {
			            $size_img = $data_img['size'] . 'B';
			        } else if ($data_img['size'] < 1048576) {
			            $size_img = round($data_img['size'] / 1024) . 'KB';               
			        } else if ($data_img['size'] > 1048576) {
			            $size_img = round($data_img['size'] / 1024 / 1024) . 'MB';
			        }

			        echo '    
			            <div class="col-md-3">
			                <div class="thumbnail">
			                    <a href="' . str_replace('admin/', '', $_DOMAIN) . $data_img['url'] . '">
			                        <img src="' . str_replace('admin/', '', $_DOMAIN) . $data_img['url'] . '" style="height: 150px;">
			                    </a>
			                    <div class="caption">
			                        <div class="input-group">
			                            <span class="input-group-addon">
			                                <input type="checkbox" name="id_img[]" value="' . $data_img['id_img'] . '">
			                            </span>
			                            <input type="text" class="form-control" value="' . str_replace('admin/', '', $_DOMAIN)  . $data_img['url'] . '" disabled>
			                            <span class="input-group-btn">
			                                <button class="btn btn-danger del-img" data-id="' . $data_img['id_img'] . '">
			                                    <span class="glyphicon glyphicon-trash"></span>
			                                </button>
			                            </span>
			                        </div>
			                        <p>Trạng thái: ' . $status_img . '</p>
			                        <p>Dung lượng: ' . $size_img . '</p>
			                        <p>Định dạng: ' . strtoupper($data_img['type']) . '</p>
			                    </div>
			                </div>
			            </div>   
			        ';
			    }
			    echo '</div>';

			    // Nút phân trang
				echo '<div class="btn-group" id="paging_post">';
				// Nếu trang hiện tại lớn hơn 1 và tổng số trang > 1 thì hiển thị nút pre
				if ($current_page > 1 && $total_page > 1) {
					echo '
						<a href="'.$_DOMAIN.'photos&page='.($current_page - 1).'" class="btn btn-default">
							<span class="glyphicon glyphicon-chevron-left"></span> Prev
						</a>
					';
				} else {
					echo '
						<a href="'.$_DOMAIN.'photos&page='.($current_page - 1).'" class="btn btn-default disabled">
							<span class="glyphicon glyphicon-chevron-left"></span> Prev
						</a>
					';
				}

				// In số trang
				for ($i = 1; $i <= $total_page; $i++) {
					// Nếu trùng vs trang hiện tại thì active
					if ($i == $current_page) {
						echo '<a class="btn btn-default active">'. $i .'</a>';
					// Ngược lại
					} else {
						echo '<a href="'.$_DOMAIN.'photos&page='. $i .'" class="btn btn-default">'. $i .'</a>';
					}
					
				}

				// Nếu trang hiện tại < tổng số trang và > 1 thì hiển thị nút Next
				if ($current_page < $total_page && $total_page > 1) {
					echo '
						<a href="'.$_DOMAIN.'photos&page='.($current_page + 1).'" class="btn btn-default">
							 Next <span class="glyphicon glyphicon-chevron-right"></span>
						</a>
					';
				} else {
					echo '
						<a href="'.$_DOMAIN.'photos&page='.($current_page + 1).'" class="btn btn-default disabled">
							 Next <span class="glyphicon glyphicon-chevron-right"></span>
						</a>
					';
				}

				echo '<br><br><br></div>';

			} else {
			    echo '<br><br><div class="alert alert-info">Chưa có hình ảnh nào.</div>';
			}
		}
	}
	// Ngược lại chưa đăng nhập
	else {
		new Redirect($_DOMAIN); //Trở về trang index
	}
?>
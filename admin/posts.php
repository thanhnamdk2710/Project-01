<?php
	// Kết nối database và thông tin chung
	require_once 'core/init.php';

	// Nếu đăng nhập
	if ($user) {
		// Nếu tồn tại tham số action
		if (isset($_POST['action'])) {
			// Xử lý POST action
			$action = trim(addslashes(htmlspecialchars($_POST['action'])));

			// Thêm bài viết
			if ($action == 'add_post') {

				$dir = "../upload/";
				$name_thumb = stripslashes($_FILES['url_thumb_add_post']['name']);
				$source_thumb = $_FILES['url_thumb_add_post']['tmp_name'];

				// Lấy ngày tháng năm hiện tại
				$day_current = substr($date_current, 8, 2);
				$month_current = substr($date_current, 5, 2);
				$year_current = substr($date_current, 0, 4);

				// Tạo folder năm hiện tại
				if (!is_dir($dir.$year_current)) {
					mkdir($dir.$year_current.'/');
				}

				// Tạo folder tháng hiện tại
				if (!is_dir($dir.$year_current.'/'.$month_current)) {
					mkdir($dir.$year_current.'/'.$month_current.'/');
				}

				// Tạo folder tháng hiện tại
				if (!is_dir($dir.$year_current.'/'.$month_current.'/'.$day_current)) {
					mkdir($dir.$year_current.'/'.$month_current.'/'.$day_current.'/');
				}

				// Đường dẫn đến file thumbnail
				$path_thumb = $dir.$year_current.'/'.$month_current.'/'.$day_current.'/'.$name_thumb;
				move_uploaded_file($source_thumb, $path_thumb);
				$url_thumb = substr($path_thumb, 3);

				// Xử lý các giá trị
				$title_add_post = trim(addslashes(htmlspecialchars($_POST['title_add_post'])));
				$slug_add_post = trim(addslashes(htmlspecialchars($_POST['slug_add_post'])));
			    $desc_add_post = trim(htmlspecialchars(addslashes($_POST['desc_add_post'])));
			    $keywords_add_post = trim(htmlspecialchars(addslashes($_POST['keywords_add_post'])));
			    $cate_1_add_post = trim(htmlspecialchars(addslashes($_POST['cate_1_add_post'])));
			    $cate_2_add_post = trim(htmlspecialchars(addslashes($_POST['cate_2_add_post'])));
			    $body_add_post = trim(htmlspecialchars(addslashes($_POST['body_add_post'])));
			    $url_thumb_add_post = $url_thumb;

				// Các biến xử lý thông báo
				$show_alert = '<script>$("#formAddPost .alert").removeClass("hidden");</script>';
				$hide_alert = '<script>$("#formAddPost .alert").addClass("hidden");</script>';
				$success = '<script>$("#formAddPost .alert").attr("class", "alert alert-success");</script>';

				// Nếu các giá trị rỗng
				if ( 	$title_add_post == '' ||
					 	$slug_add_post == ''||
					 	$url_thumb_add_post == '' ||
				        $desc_add_post == '' ||
				        $keywords_add_post == '' ||
				        $cate_1_add_post == '' ||
				        $cate_2_add_post == '' ||
				        $body_add_post == ''
				) {
					echo '<div class="alert alert-danger">Vui lòng điền đầy đủ thông tin</div>';

				// Ngược lại
				} else {
					// Kiểm tra bài viết tồn tại
					$sql_check_post_exist = "SELECT title, slug FROM posts WHERE title = '$title_add_post' OR slug = '$slug_add_post'";
					// Nếu bài viết tồn tại
					if ($db->num_rows($sql_check_post_exist)) {
						echo $show_alert.'Bài viết có tiêu đề hoặc slug đã tồn tại.';
					} else {
						// Thực thi bài viết
						if ($data_user['position'] == '1') {
							$sql_add_post = "INSERT INTO posts VALUES(
								'',
								'$title_add_post',
								'$desc_add_post',
								'$url_thumb_add_post',
								'$slug_add_post',
								'$keywords_add_post',
								'$body_add_post',
								'$cate_1_add_post',
								'$cate_2_add_post',
								'$data_user[id_acc]',
								'1',
								'0',
								'$date_current'
							)";
						} else {
							$sql_add_post = "INSERT INTO posts VALUES(
								'',
								'$title_add_post',
								'$desc_add_post',
								'$url_thumb_add_post',
								'$slug_add_post',
								'$keywords_add_post',
								'$body_add_post',
								'$cate_1_add_post',
								'$cate_2_add_post',
								'$data_user[id_acc]',
								'0',
								'0',
								'$date_current'
							)";
						}
						
						$db->query($sql_add_post);
						echo $show_alert.$success.'Thêm bài viết thành công';
						$db->close();
						new Redirect($_DOMAIN.'posts');
					}
				}

			// Tải chuyên mục trong chỉnh sửa bài viết
			// Chuyên mục vừa
			} else if ($action == 'load_cate_2') {
				$parent_id = trim(htmlspecialchars(addslashes($_POST['parent_id'])));

				$sql_get_cate_2 = "SELECT id_cate, label FROM categories WHERE type ='2' AND parent_id ='$parent_id'";
				if ($db->num_rows($sql_get_cate_2)) {
					foreach ($db->fetch_assoc($sql_get_cate_2, 0) as $key => $data_cate_2) {
						echo '<option value="'.$data_cate_2['id_cate'].'">'.$data_cate_2['label'].'</option>';
					}
				} else {
					echo '<option value="">Chưa có chuyên mục nào</option>';
				}

			// Chuyên mục nhỏ
			} else if ($action == 'load_cate_3') {
			    $parent_id = trim(htmlspecialchars(addslashes($_POST['parent_id'])));
			 
			    $sql_get_cate_3 = "SELECT id_cate, label FROM categories WHERE type = '3' AND parent_id = '$parent_id'";
			    if ($db->num_rows($sql_get_cate_3)) {
			        foreach ($db->fetch_assoc($sql_get_cate_3, 0) as $key => $data_cate_3) {
			            echo '<option value="' . $data_cate_3['id_cate'] . '">' . $data_cate_3['label'] . '</option>';
			        }
			    } else {
			        echo '<option value="">Chưa có chuyên mục nhỏ nào</option>';
			    }

			// Chỉnh sửa bài viết  
			} else if ($action == 'edit_post') {

				$dir = "../upload/";
				$name_thumb = stripslashes($_FILES['url_thumb_edit_post']['name']);
				$source_thumb = $_FILES['url_thumb_edit_post']['tmp_name'];

				// Lấy ngày tháng năm hiện tại
				$day_current = substr($date_current, 8, 2);
				$month_current = substr($date_current, 5, 2);
				$year_current = substr($date_current, 0, 4);

				// Tạo folder năm hiện tại
				if (!is_dir($dir.$year_current)) {
					mkdir($dir.$year_current.'/');
				}

				// Tạo folder tháng hiện tại
				if (!is_dir($dir.$year_current.'/'.$month_current)) {
					mkdir($dir.$year_current.'/'.$month_current.'/');
				}

				// Tạo folder ngày hiện tại
				if (!is_dir($dir.$year_current.'/'.$month_current.'/'.$day_current)) {
					mkdir($dir.$year_current.'/'.$month_current.'/'.$day_current.'/');
				}

				// Đường dẫn đến file thumbnail
				$path_thumb = $dir.$year_current.'/'.$month_current.'/'.$day_current.'/'.$name_thumb;
				move_uploaded_file($source_thumb, $path_thumb);
				$url_thumb = substr($path_thumb, 3);

				// Xử lý các giá trị
				$id_post = trim(htmlspecialchars(addslashes($_POST['id_post'])));
			    $stt_edit_post = trim(htmlspecialchars(addslashes($_POST['stt_edit_post'])));
			    $title_edit_post = trim(htmlspecialchars(addslashes($_POST['title_edit_post'])));
			    $slug_edit_post = trim(htmlspecialchars(addslashes($_POST['slug_edit_post'])));
			    $url_thumb_edit_post = $url_thumb;
			    $desc_edit_post = trim(htmlspecialchars(addslashes($_POST['desc_edit_post'])));
			    $keywords_edit_post = trim(htmlspecialchars(addslashes($_POST['keywords_edit_post'])));
			    $cate_1_edit_post = trim(htmlspecialchars(addslashes($_POST['cate_1_edit_post'])));
			    $cate_2_edit_post = trim(htmlspecialchars(addslashes($_POST['cate_2_edit_post'])));
			    $body_edit_post = trim(htmlspecialchars(addslashes($_POST['body_edit_post'])));

			    // Các biến xử lý thông báo
			    $show_alert = '<script>$("#formEditPost .alert").removeClass("hidden");</script>';
			    $hide_alert = '<script>$("#formEditPost .alert").addClass("hidden");</script>';
			    $success = '<script>$("#formEditPost .alert").attr("class", "alert alert-success");</script>';

			    // Kiểm tra id bài viết
			    $sql_check_id_post = "SELECT * FROM posts WHERE id_post = '$id_post'";

			    // Nếu các giá trị rỗng
			    if ($stt_edit_post == '' || 
			    	$title_edit_post == '' || 
			    	$slug_edit_post == '' || 
			    	$cate_1_edit_post == '' || 
			    	$cate_2_edit_post == '' || 
			    	$body_edit_post == '' ||
			    	$url_thumb_edit_post == ''
			    ) {
			    	echo $show_alert.'Vui lòng điền đầy đủ thông tin.';
			    } else if (!$db->num_rows($sql_check_id_post)) {
			    	echo $show_alert.'Đã có lỗi xảy ra, vui lòng thử lại.';
			    } else {
			    	// Sửa bài viết
			    	$sql_edit_post = "UPDATE posts SET
			    		status = '$stt_edit_post',
			            title = '$title_edit_post',
			            slug = '$slug_edit_post',
			            url_thumb = '$url_thumb_edit_post',
			            descr = '$desc_edit_post',
			            keywords = '$keywords_edit_post',
			            cate_1_id = '$cate_1_edit_post',
			            cate_2_id = '$cate_2_edit_post',
			            body = '$body_edit_post'
			            WHERE id_post = '$id_post'
			    	";
			    	$db->query($sql_edit_post);
			    	$db->close();
			    	echo $show_alert.$success.'Chỉnh sửa bài viết thành công.';
			    	new Redirect($_DOMAIN.'posts');
			    }

			// Xóa 1 bài viết  
			} else if ($action == 'delete_post') {
				$id_post = trim(htmlspecialchars(addslashes($_POST['id_post'])));
				$sql_check_id_post_exist = "SELECT id_post FROM posts WHERE id_post ='$id_post'";
				if ($db->num_rows($sql_check_id_post_exist)) {
					$sql_delete_post = "DELETE FROM posts WHERE id_post = '$id_post'";
					$db->query($sql_delete_post);
					$db->close();
				}

			// Xoá nhiều bài viết cùng 1 lúc
			} else if ($action == 'delete_post_list') {
				foreach ($_POST['id_post'] as $key => $id_post) {
					$sql_check_id_post_exist = "SELECT id_post FROM posts WHERE id_post ='$id_post'";
					if ($db->num_rows($sql_check_id_post_exist)) {
						$sql_delete_post = "DELETE FROM posts WHERE id_post = '$id_post'";
						$db->query($sql_delete_post);
					}
				}
				$db->close();

			// Tìm kiếm bài viết
			} else if ($action == 'search_post') {
				$kw_search_post = trim(htmlspecialchars(addslashes($_POST['kw_search_post'])));

				if ($kw_search_post != '') {
					$sql_search_post = "SELECT * FROM posts WHERE
						id_post like '%$kw_search_post%' OR
						title like '%$kw_search_post%' OR
						slug like '%$kw_search_post%'
						ORDER BY id_post DESC
					";

					// Nếu có kết quả
					if ($db->num_rows($sql_search_post)) {
						echo '
							<table class="table table-striped list">
								<tr>
									<th class="text-center"><input type="checkbox"></th>
									<th class="text-center">ID</th>
									<th class="text-center">Tiêu đề</th>
									<th class="text-center">Trạng thái</th>
									<th class="text-center">Chuyên mục</th>
									<th class="text-center">Lượt xem</th>
						';

						// Nếu tài khoản là admin
						if ($data_user['position'] == '1') {
							echo '<th class="text-center">Tác giả</th>';
						}

						echo '
								<th class="text-center">Tools</th>
							</tr>
						';

						// In danh sách kết quả tìm kiếm
						foreach ($db->fetch_assoc($sql_search_post, 0) as $key => $data_post) {
							// Trạng thái bài viết
							if ($data_post['status'] == 0) {
								$stt_post = '<label class="label label-warning">Ẩn</label>';
							} else {
								$stt_post = '<label class="label label-success">Xuất bản</label>';
							}

							// Chuyên mục bài viết
							$cate_post = '';
							$sql_check_id_cate_1 = "SELECT lable, id FROM categories WHERE id_cate = '$data_post[cate_1_id]' AND type = '1'";
							if ($db->num_rows($sql_check_id_cate_1)) {
								$data_cate_1 = $db->fetch_assoc($sql_check_id_cate_1, 1);
								$cate_post .= $data_cate_1['label'];
							} else {
								$cate_post .= '<span class="text-danger">Lỗi</span>';
							}

							$sql_check_id_cate_2 = "SELECT lable, id FROM categories WHERE id_cate = '$data_post[cate_2_id]' AND type = '2'";
							if ($db->num_rows($sql_check_id_cate_1)) {
								$data_cate_2 = $db->fetch_assoc($sql_check_id_cate_2, 1);
								$cate_post .= ', ' . $data_cate_2['label'];
							} else {
								$cate_post .= '<span class="text-danger">Lỗi</span>';
							}

							// Tác giả bài viết
							$sql_get_author = "SELECT display_name FROM accounts WHERE id_acc = '$data_post[author_id]'";
							if ($db->num_rows($sql_get_author)) {
								$data_author = $db->fetch_assoc($sql_get_author, 1);
								$author_post = $data_author['display_name'];
							} else {
								$author_post = '<span class="text-danger">Lỗi</span>';
							}

							echo '
								<tr>
									<td class="text-center"><input type="checkbox" name="id_post[]" value="'.$data_post['id_post'].'"></td>
									<td class="text-center">'.$data_post['id_post'].'</td>
									<td style="width: 30%;"><a href="'.$_DOMAIN. 'posts/edit/' . $data_post['id_post']. '">'.$data_post['title'].'</a></td>
									<td class="text-center">'.$stt_post.'</td>
									<td>'.$cate_post.'</td>
									<td class="text-center">'.$data_post['view'].'</td>
							';

							// Tác giả bài viết
							if ($data_user['position'] == '1') {
								echo '<td>' . $author_post . '</td>';
							}

							echo '
									<td class="text-center">
										<a href="'.$_DOMAIN. 'posts/edit/' . $data_post['id_post'] . '" class="btn btn-primary">
											<span class="glyphicon glyphicon-edit"></span>
										</a>
										<a class="btn btn-danger del_post_list" data-id="'.$data_post['id_post'].'">
											<span class="glyphicon glyphicon-trash"></span>
										</a>
									</td>
								</tr>
							';
						}
						echo '</table>';
					// Ngược lại không có kết quả
					} else {
						echo '<div class="alert alert-info">Không tìm thấy kết quả nào cho từ khoá <strong>' . $kw_search_post . '</strong>.</div>';
					}
				}

			}

		// Ngược lại không tồn tại POST action
		} else {
			new Redirect($_DOMAIN);
		}

	// Ngược lại không đăng nhập
	} else {
		new Redirect($_DOMAIN);
	}
?>
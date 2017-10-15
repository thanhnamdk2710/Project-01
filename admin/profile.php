<?php
	// Kết nối database và thông tin chung
	require_once 'core/init.php';

	// Nếu đăng nhập
	if ($user) {
		// Nếu có file upload
		if (isset($_FILES['img_avt'])) {
			$dir = "../upload/";
			$name_img = stripslashes($_FILES['img_avt']['name']);
			$source_img = $_FILES['img_avt']['tmp_name'];

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
			if (!is_dir($dir.$year_current.'/'.$month_current.''.$day_current)) {
				mkdir($dir.$year_current.'/'.$month_current.'/'.$day_current.'/');
			}

			// Đường dẫn đến file avatar
			$path_img = $dir.$year_current.'/'.$month_current.'/'.$day_current.'/'.$name_img;
			move_uploaded_file($source_img, $path_img);
			$url_img = substr($path_img, 3);

			$sql_up_avt = "UPDATE accounts SET url_avatar = '$url_img' WHERE id_acc = '$data_user[id_acc]'";
			$db->query($sql_up_avt);
			echo 'Upload thành công';
			$db->close();
			new Redirect($_DOMAIN.'profile');
		}
		// Nếu tồn tại POST action
		if (isset($_POST['action'])) {
			$action = trim(addslashes(htmlspecialchars($_POST['action'])));

			// Xóa ảnh avatar
			if ($action == 'delete_avt') {
				if (file_exists('../'.$data_user['url_avatar'])) {
					unlink('../'.$data_user['url_avatar']);
				}

				$sql_delete_avt = "UPDATE accounts SET url_avatar = '' WHERE id_acc = '$data_user[id_acc]'";
				$db->query($sql_delete_avt);
				$db->close();
			}
			// Cập nhật các thông tin
			if ($action == 'update_info') {
				// Xử lý các giá trị
				$dn_update = trim(htmlspecialchars(addslashes($_POST['dn_update'])));
				$email_update = trim(htmlspecialchars(addslashes($_POST['email_update'])));
				$phone_update = trim(htmlspecialchars(addslashes($_POST['phone_update'])));

				// Các biến xử lý thông báo
			    $show_alert = '<script>$("#formUpdateInfo .alert").removeClass("hidden");</script>';
			    $hide_alert = '<script>$("#formUpdateInfo .alert").addClass("hidden");</script>';
			    $success = '<script>$("#formUpdateInfo .alert").attr("class", "alert alert-success");</script>';

			    if ($dn_update && $email_update) {
			    	// Kiểm tra tên hiển thị
			    	if (strlen($dn_update) < 3 || strlen($dn_update) > 50) {
			    		echo $show_alert . 'Tên hiển thị phải nằm trong khoảng từ 3 đến 50 ký tự';
			    	}
			    	// Kiểm tra mail
			    	else if (filter_var($email_update, FILTER_VALIDATE_EMAIL) === FALSE) {
			    		echo $show_alert . 'Email không hợp lệ.';
			    	// Kiểm tra số điện thoại
			    	} else if ($phone_update && (strlen($phone_update) < 10 || strlen($phone_update) > 11) || preg_match('/^[0-9]+$/', $phone_update) === false) {
			    		echo $show_alert . 'Số điện thoại không hợp lệ.';
			    	} else {
			    		$sql_update_info = "UPDATE accounts SET
			    			display_name = '$dn_update',
			    			email = '$email_update',
			    			phone = '$phone_update'
			    			WHERE id_acc = '$data_user[id_acc]'
			    		";
			    		$db->query($sql_update_info);
			    		echo $success.'Cập nhật thông tin thành công.';
			    		new Redirect($_DOMAIN.'profile');
			    	}
			    } else {
			    	echo $show_alert . 'Vui lòng điền đầy đủ thông tin';
			    }
			}
			// Đổi mật khẩu
			if ($action == 'change_pw') {
				// Xử lý các giá trị
				$old_pw_change = md5($_POST['old_pw_change']);
				$new_pw_change = trim(htmlspecialchars(addslashes($_POST['new_pw_change'])));
				$re_new_pw_change = trim(htmlspecialchars(addslashes($_POST['re_new_pw_change'])));

				// Các biến xử lý thông báo
				$show_alert = '<script>$("#formUpdateInfo .alert").removeClass("hidden");</script>';
			    $hide_alert = '<script>$("#formUpdateInfo .alert").addClass("hidden");</script>';
			    $success = '<script>$("#formUpdateInfo .alert").attr("class", "alert alert-success");</script>';

			    if ($old_pw_change && $new_pw_change && $re_new_pw_change) {
			    	// Kiểm tra mật khẩu cũ có chính xác không
			    	if ($old_pw_change != $data_user['password']) {
			    		echo $show_alert . 'Mật khẩu cũ không chính xác';
			    	// Kiểm tra mật khẩu mới
			    	} else if (strlen($new_pw_change) < 6) {
			    		echo $show_alert . 'Mật khẩu mới quá ngắn';
			    	// Kiểm tra mật khẩu mới và mật khẩu mới nhập lại
			    	} else if ($new_pw_change != $re_new_pw_change) {
			    		echo $show_alert . 'Mật khẩu mới nhập lại không khớp';
			    	} else {
			    		$new_pw_change = md5($new_pw_change);
			    		$sql_change_pw = "UPDATE accounts SET password ='$new_pw_change' WHERE id_acc = '$data_user[id_acc]'";
			    		$db->query($sql_change_pw);
			    		echo $success . 'Thay đổi mật khẩu thành công.';
			    		new Redirect($_DOMAIN.'profile');
			    	}
			    } else {
			        echo $show_alert.'Vui lòng điền đầy đủ thông tin.';
			    }
			}
		} else {
			new Redirect($_DOMAIN);
		}
	} else {
		new Redirect($_DOMAIN);
	}
?>
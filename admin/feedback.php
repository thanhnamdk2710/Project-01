<?php
	// Kết nối database và thông tin chung
	require_once 'core/init.php';

	// Nếu đăng nhập
	if ($user) {
		// Nếu tồn tại post action
		if (isset($_POST['action'])) {
			$action = trim(htmlspecialchars(addslashes($_POST['action'])));

			// View nhiều tài khoản
			if ($action == 'view_feed_list') {
				foreach ($_POST['id_feed'] as $key => $id_feed) {
					$sql_check_id_feed_exist = "SELECT id_feed FROM feedback WHERE id_feed ='$id_feed'";
					if ($db->num_rows($sql_check_id_feed_exist)) {
						$sql_view_feed = "UPDATE feedback SET status = '1' WHERE id_feed = '$id_feed'";
						$db->query($sql_view_feed);
					}
				}
				$db->close();
			}
			// View 1 tài khoản
			else if ($action == 'view_feed') {
				$id_feed = trim(htmlspecialchars(addslashes($_POST['id_feed'])));
				$sql_check_id_feed_exist = "SELECT id_feed FROM feedback WHERE id_feed ='$id_feed'";
				if ($db->num_rows($sql_check_id_feed_exist)) {
					$sql_view_feed = "UPDATE feedback SET status = '1' WHERE id_feed = '$id_feed'";
					$db->query($sql_view_feed);
					$db->close();
				}
			}
			// Xóa nhiều tài khoản
			else if ($action == 'del_feed_list') {
				foreach ($_POST['id_feed'] as $key => $id_feed) {
					$sql_check_id_feed_exist = "SELECT id_feed FROM feedback WHERE id_feed ='$id_feed'";
					if ($db->num_rows($sql_check_id_feed_exist)) {
						$sql_del_feed = "DELETE FROM feedback WHERE id_feed = '$id_feed'";
						$db->query($sql_del_feed);
					}
				}
				$db->close();
			}
			// Xóa 1 tài khoản
			else if ($action == 'del_feed') {
				$id_feed = trim(htmlspecialchars(addslashes($_POST['id_feed'])));
				$sql_check_id_feed_exist = "SELECT id_feed FROM feedback WHERE id_feed ='$id_feed'";
				if ($db->num_rows($sql_check_id_feed_exist)) {
					$sql_del_feed = "DELETE FROM feedback WHERE id_feed = '$id_feed'";
					$db->query($sql_del_feed);
					$db->close();
				}
			}
		} else {
			new Redirect($_DOMAIN);
		}
	} else {
		new Redirect($_DOMAIN);
	}


			
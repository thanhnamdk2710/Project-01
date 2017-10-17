<?php
	// Kết nối database và thông tin chung
	require_once 'core/init.php';

	if (isset($_POST['action'])) {

		$ac = trim(htmlspecialchars(addslashes($_POST['action'])));

		if ($ac == 'feedback') {
			$name = trim(htmlspecialchars(addslashes($_POST['name_feedback'])));
			$email = trim(htmlspecialchars(addslashes($_POST['email_feedback'])));
			$phone = trim(htmlspecialchars(addslashes($_POST['phone_feedback'])));
			$body = trim(htmlspecialchars(addslashes($_POST['body_feedback'])));

			// Các biến xử lý
			$show_alert = '<script>$("#formFeedback .alert").removeClass("hidden");</script>';
            $hide_alert = '<script>$("#formFeedback .alert").addClass("hidden");</script>';
            $success = '<script>$("#formFeedback .alert").attr("class", "alert alert-success");</script>';

            // Nếu các giá trị rỗng
            if ($name == '' || $email == '' || $phone == '' || $body == '') {
                echo $show_alert.'Vui lòng điền đầy đủ thông tin';
            } else {
            	// Gửi góp ý
            	$sql_sent_feedback = "INSERT INTO feedback VALUES(
					'',
					'$name',
					'$email',
					'$phone',
					'$body',
					'$date_current',
					'0'
            	)";
            	$db->query($sql_sent_feedback);
            	echo $show_alert.$success.'Góp ý thành công.';
                $db->close(); // Giải phóng
                new Redirect($_DOMAIN.'category/contact');
            }
		}
	}
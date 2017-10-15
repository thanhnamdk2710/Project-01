<?php
    // Kết nối database và thông tin chung
    require_once 'core/init.php';

    // Nếu có tồn tại phương thức POST
    if (isset($_POST['user_signin']) && isset($_POST['pass_signin'])) {
        // Xử lý các giá trị
        $user_signin = trim(htmlspecialchars(addslashes($_POST['user_signin'])));
        $pass_signin = trim(htmlspecialchars(addslashes($_POST['pass_signin'])));

        // Các biến thông báo
        $show_alert = '<script>$("#formSignin .alert").removeClass("hidden");</script>';
        $hide_alert = '<script>$("#formSignin .alert").addClass("hidden");</script>';
        $success = '<script>$("#formSignin .alert").attr("class", "alert alert-success");</script>';

        // Nếu giá trị rỗng
        if ($user_signin == '' || $pass_signin == '') {
            echo $show_alert . 'Vui lòng điền đầy đủ thông tin.';
        // Ngược lại
        } else {
            $sql_check_user_exist = "SELECT username FROM accounts WHERE username = '$user_signin'";

            // Nếu tồn tại username
            if ($db->num_rows($sql_check_user_exist)) {
                $pass_signin = md5($pass_signin);
                $sql_check_signin = "SELECT username, password FROM accounts WHERE username = '$user_signin' AND password = '$pass_signin'";

                // Nếu user và pass đúng
                if ($db->num_rows($sql_check_signin)) {
                    $sql_check_stt = "SELECT username, password, status FROM accounts WHERE username = '$user_signin' AND password = '$pass_signin' AND status = '1'";

                    // Nếu user, pass đúng và tài khoản không bị khóa (status = 1)
                    if ($db->num_rows($sql_check_stt)) {
                        // Lưu session
                        $session->send($user_signin);
                        $db->close();

                        echo $show_alert.$success. 'Đăng nhập thành công.';
                        new Redirect($_DOMAIN);

                    // Nếu tài khoản bị khóa
                    } else {
                        echo $show_alert.'Tài khoản bị khóa! Vui lòng liên hệ Admin để biết thêm chi tiết.';
                    }

                // Nếu mật khẩu không đúng
                } else {
                    echo $show_alert.'Mật khẩu không đúng.';
                }

            // Nếu tài khoản không đúng
            } else {
                echo $show_alert.'Tên đăng nhập không đúng.';
            }
        }

    // Nếu không tồn tại phương thức POST
    } else {
        new Redirect($_DOMAIN);
    }
?>